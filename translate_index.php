<?php
header("Content-Type: text/html; charset=utf-8");
$url = "";
$error_message = "";
if (isset($_POST['submit'])) {
    if (!isset($_POST['text']) || empty(trim($_POST['text']))) {
        $error_message .= "Please input some text into the textbox!";
    }

    if (!isset($_POST['from']) || empty($_POST['from'])) {
        $error_message .= "Please check the language type of your input text!";
    }

    if (!isset($_POST['to']) || empty($_POST['to'])) {
        $error_message .= "Please at least choose one language type you want to translate text to!";
    }

    if (empty($error_message)) {
        $text = urlencode(trim($_POST['text']));
        $from = urlencode($_POST['from']);
        $to = urlencode(implode(' ', $_POST['to']));

        $url .= 'http://localhost/webservices/translate_service.php?action=translate&text=';
        $url .= $text . '&from=';
        $url .= $from . '&to=';
        $url .= $to;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Translator Web Services</title>
</head>
<body>
<form action="" method="post">
	<fieldset>
    	<legend>Translate From:</legend>
		<input type="radio" name="from" value="english">English
		<input type="radio" name="from" value="french">French
		<input type="radio" name="from" value="chinese">Chinese
		<input type="radio" name="from" value="spanish">Spanish
		<input type="radio" name="from" value="portuguese">Portuguese
		<input type="radio" name="from" value="german">German
		<input type="radio" name="from" value="italian">Italian
		<input type="radio" name="from" value="russian">Russian
		<input type="radio" name="from" value="dutch">Dutch
		<input type="radio" name="from" value="danish">Danish
		<input type="radio" name="from" value="arabic">Arabic
  	</fieldset>
  	<fieldset>
  		<legend>Translate Text</legend>
  		<input type="text" name="text" size="60" />
  	</fieldset>
	<fieldset>
    	<legend>Translate To:</legend>
		<input type="checkbox" name="to[]" value="english">English
		<input type="checkbox" name="to[]" value="french">French
		<input type="checkbox" name="to[]" value="chinese">Chinese
		<input type="checkbox" name="to[]" value="spanish">Spanish
		<input type="checkbox" name="to[]" value="portuguese">Portuguese
		<input type="checkbox" name="to[]" value="german">German
		<input type="checkbox" name="to[]" value="italian">Italian
		<input type="checkbox" name="to[]" value="russian">Russian
		<input type="checkbox" name="to[]" value="dutch">Dutch
		<input type="checkbox" name="to[]" value="danish">Danish
		<input type="checkbox" name="to[]" value="arabic">Arabic
  	</fieldset>
  	<br><button type="submit" name="submit" value="submit">Get URL</button>
</form>
<div>
	<?php if (!empty($error_message)): ?>
		<p><?php echo $error_message;?></p>
	<?php else: ?>
		<p><a href="<?php echo $url;?>"><?php echo $url;?></a></p>
	<?php endif;?>

</div>

</body>
</html>
