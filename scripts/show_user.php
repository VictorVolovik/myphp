<?php
	require_once '../config/db_connection.php';
	require_once '../config/app_config.php';

	$user_id = $_REQUEST['user_id'];

	$select_query = "SELECT * FROM users WHERE user_id = " . $user_id;

	$result = mysqli_query($link, $select_query);
	if($result) {
		$row = mysqli_fetch_array($result);
		$first_name = $row['first_name'];
		$last_name = $row['last_name'];
		$bio = preg_replace("/[\r\n]+/", "</p><p>", $row['bio']);
		$email = $row['email'];
		$facebook_url = $row['facebook_url'];
		$twitter_handle = $row['twitter_handle'];
		$twitter_url = "http://www.twitter.com/" . $twitter_handle;
		$user_image = $row['user_pic_path'];
		$user_image = get_web_path($user_image);
	} else {
		handle_error("oшибка при выполнении запроса в базу данных.", "Ошибка обнаружения пользователя с ID {$user_id}");
		exit();
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
			Профиль
		</div>
		<div id="content">
			<div class="user_profile">
				<h1><?= "$first_name $last_name"; ?></h1>
				<img src="<?= $user_image; ?>" class="user_pic" alt="<?= "$first_name $last_name"; ?>">
				<p><?php  echo "$bio"; ?></p>
				<p class="contact_info">
					Поддерживайте связь с <?= $first_name; ?>:
				</p>
				<ul>
					<li>...<a href="mailto:<?php echo $email; ?>">по электронной почте</a></li>
					<li>...<a href="<?= $facebook_url; ?>" target="_blank">через Facebook</a></li>
					<li>...<a href="<?= $twitter_url; ?>" target="_blank">или Twitter</a></li>
				</ul>
			</div>
		</div>
	</body>
</html>