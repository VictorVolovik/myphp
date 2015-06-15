<?php
	$first_name = trim($_REQUEST['first_name']);
	$last_name = trim($_REQUEST['last_name']);
	$email = trim($_REQUEST['email']);
 
	$facebook_url = str_replace("facebook.org", "facebook.com",
								trim($_REQUEST['facebook_url']));
	$position = strpos($facebook_url, "facebook.com");
	if($position === false) {
		$facebook_url= "http://facebook.com/" . $facebook_url;
	}

	$twitter_handler = trim($_REQUEST['twitter_handler']);
	$twitter_url = "http://www.twitter.com/";
	$position = strpos($twitter_handler, "@");
	if($position === false){
		$twitter_url = $twitter_url . $twitter_handler;
	} else {
		$twitter_url = $twitter_url . substr($twitter_handler, $position + 1);
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Social</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="../css/phpMM.css">
	</head>
	<body>
		<div id="header">
			<h1>PHP &amp; MySQL: The Missing Manual</h1>
		</div>
		<div id="example">
			Пример 3.1
		</div>
		<div id="content">
			<p>Это структура с данными, полученными из формы:</p>
			<p>
				Имя: <?php echo $first_name; ?><br>
				Фамилия: <?php echo $last_name; ?><br>
				Адрес электронной почты: <?php echo $email; ?><br>
				<a href="<?php echo $facebook_url; ?>" target="_blank">Ваша страница на Facebook</a><br>
				<a href="<?php echo $twitter_url; ?>" target="_blank">Ваш канал в Twitter</a><br>
			</p>
		</div>
	</body>
</html>