<?php

DEFINE('DSN', 'mysql:dbname=language;host=localhost;charset=UTF8');
DEFINE('USER', 'studentweb');
DEFINE('PASSWORD', 'studentweb');

try {
    $pdo = new PDO(DSN, USER, PASSWORD);
} catch (PDOException $e) {
    echo 'Connection failed:' . $e->getMessage();
}
