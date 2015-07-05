<?php
	require_once '../config/app_config.php';
	require_once '../config/db_connection.php';

	$user_pic = $_FILES['user_pic'];
	$upload_dir = HOST_WWW_ROOT . "uploads/profile_pics/";

	//потенциальные ошибки отправки файлов
	$php_errors = [
		1 => "Превышен максимальный развмер файла, указанный в php.ini",
		2 => "Превышен максимальный развмер файла, указанный в форме HTML",
		3 => "Произошла ошибка при передаче файла",
		4 => "Файл для отправки не был выбран"
	];

	$first_name = trim($_REQUEST['first_name']);
	$last_name = trim($_REQUEST['last_name']);
	$email = trim($_REQUEST['email']);
	$bio = trim($_REQUEST['bio']);

	$facebook_url = str_replace("facebook.org", "facebook.com",
								trim($_REQUEST['facebook_url']));
	$position = strpos($facebook_url, "facebook.com");
	if($position === false) {
		$facebook_url= "http://facebook.com/" . $facebook_url;
	}

	$twitter_handle = trim($_REQUEST['twitter_handle']);
	$position = strpos($twitter_handle, "@");
	if($position === 0){
		$twitter_handle = substr($twitter_handle, $position + 1);
	}

	//проверка отсутствия ошибок при отправке изображения
	$result = $user_pic['error'];
	if($result) {
		handle_error("сервер не может получить выбранное вами изображение.", $php_errors[$user_pic['error']]);
		exit();
	}
	//был ли отправлен именно файл
	$result = @is_uploaded_file($user_pic['tmp_name']);
	if(!$result) {
		handle_error("сервер не может получить выбранный вами файл.",
		"Запрос на отпраку файла " . "'{$user_pic['name']}'");
		exit();
	}
	//проверка типа файла
	$result = @getimagesize($user_pic['tmp_name']);
	if(!$result) {
		handle_error("сервер не может получить выбранный вами файл, так как он не является изображением.",
		"{$user_pic['name']} " . "не является изображением.");
		exit();
	}

	$now = time();
	while(file_exists($upload_file = $upload_dir . $now . "-" . basename($user_pic['name']))) {
		$now++;
	}

	$result = @move_uploaded_file($user_pic['tmp_name'], $upload_file);
	if(!$result) {
		handle_error("ошибка сохранения изображения на сервер.", "Файл {$user_pic['name']} не был сохранен.");
		exit();
	}

	//подготовка SQL-запроса
	$insert_sql = sprintf(
							"INSERT INTO users (
									first_name,
									last_name,
									email,
									bio,
									facebook_url,
									twitter_handle,
									user_pic_path
									)" .
							"VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s');",
								mysqli_real_escape_string($link, $first_name),
								mysqli_real_escape_string($link, $last_name),
								mysqli_real_escape_string($link, $email),
								mysqli_real_escape_string($link, $bio),
								mysqli_real_escape_string($link, $facebook_url),
								mysqli_real_escape_string($link, $twitter_handle),
								mysqli_real_escape_string($link, $upload_file)
						);

	$result = mysqli_query($link, $insert_sql);
	if(!$result) {
		handle_error("oшибка при выполнении запроса в базу данных.", mysqli_error($link));
		exit();
	}

	header("Location: show_user.php?user_id=" . mysqli_insert_id($link));
	exit();