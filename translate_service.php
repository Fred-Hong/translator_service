<?php
header('Content-Type:application/json; charset=UTF-8');
require_once 'database.php';

if (isset($_GET["action"])) {
    $translate_from = $_GET["from"];
    $text = trim(urldecode($_GET["text"]));
    $languages_array = explode(' ', urldecode($_GET["to"]));
    $translated_words_array = translate($translate_from, $text, $languages_array, $pdo);
    $translated_words_json = json_encode($translated_words_array);
}
exit($translated_words_json);

function translate($translate_from, $text, $languages_array, $pdo)
{
    if (empty($text)) {
        return array();
    }
    $words_id_array = get_words_id_array($translate_from, $text, $pdo);
    $translated_words_array = get_translated_words_array($languages_array, $words_id_array, $pdo);
    return $translated_words_array;
}

function get_words_id_array($translate_from, $text, $pdo)
{

    $words_array = explode(' ', $text);
    $query_text = implode('","', $words_array);
    $sql = "SELECT " . $translate_from . "_id FROM " . $translate_from . " WHERE word IN(\"" . $query_text . "\")";
    $sql .= get_order_in_case($words_array, "word");
    $words_id_array = array();
    if ($result = $pdo->query($sql)) {
        while ($id = $result->fetch(PDO::FETCH_NUM)[0]) {
            $words_id_array[] = intval($id);
        }
    }
    return $words_id_array;
}

function get_translated_words_array($languages_array, $words_id_array, $pdo)
{
    $translated_words_array = array();
    $query_text = implode(",", $words_id_array);
    foreach ($languages_array as $language) {
        $translated_words_array[$language] = array();
        $sql = "SELECT word FROM " . $language . " WHERE " . $language . "_id IN(" . $query_text . ")";
        $sql .= get_order_in_case($words_id_array, $language . "_id");
        if ($result = $pdo->query($sql)) {
            while ($word = $result->fetch(PDO::FETCH_NUM)[0]) {
                $translated_words_array[$language][] = $word;
            }
        }
    }
    return $translated_words_array;
}

function get_order_in_case($array, $column)
{
    $order_in_case = " order by CASE $column ";
    foreach ($array as $key => $value) {
        $order_in_case .= 'WHEN "' . $value . '" THEN ' . ($key + 1) . ' ';
    }
    $order_in_case .= " END;";
    return $order_in_case;
}
