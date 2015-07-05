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

	//подготовка SQL-запроса для вставки изображения
	$now = time();
	while(file_exists($image_filename = $now . "-" . basename($user_pic['name']))) {
		$now++;
	}
	$image_info = getimagesize($user_pic['tmp_name']);
	$image_mime_type = $image_info['mime'];
	$image_size = $user_pic['size'];
	$image_data = file_get_contents($user_pic['tmp_name']);

	$insert_image_sql = sprintf(
								"INSERT INTO images (
										filename,
										mime_type,
										file_size,
										image_data
										)" .
								"VALUES ('%s', '%s', '%d', '%s');",
										mysqli_real_escape_string($link, $image_filename),
										mysqli_real_escape_string($link, $image_mime_type),
										mysqli_real_escape_string($link, $image_size),
										mysqli_real_escape_string($link, $image_data)
								);

	$result = mysqli_query($link, $insert_image_sql);
	if(!$result) {
		handle_error("oшибка при выполнении запроса в базу данных.", mysqli_error($link));
		exit();
	}

	//подготовка SQL-запроса для вставки пользователя в базу
	$insert_sql = sprintf(
							"INSERT INTO users (
									first_name,
									last_name,
									email,
									bio,
									facebook_url,
									twitter_handle,
									profile_pic_id
									)" .
							"VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%d');",
								mysqli_real_escape_string($link, $first_name),
								mysqli_real_escape_string($link, $last_name),
								mysqli_real_escape_string($link, $email),
								mysqli_real_escape_string($link, $bio),
								mysqli_real_escape_string($link, $facebook_url),
								mysqli_real_escape_string($link, $twitter_handle),
								mysqli_insert_id($link)
						);

	$result = mysqli_query($link, $insert_sql);
	if(!$result) {
		handle_error("oшибка при выполнении запроса в базу данных.", mysqli_error($link));
		exit();
	}

	header("Location: show_user.php?user_id=" . mysqli_insert_id($link));
	exit();