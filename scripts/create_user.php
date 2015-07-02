<?php
	require_once '../config/app_config.php';
	require_once '../config/db_connection.php';

	$upload_dir = HOST_WWW_ROOT . "uploads/profile_pics/";
	$upload_file = $upload_dir . basename($_FILES['user_pic']['name']);

	//потенциальные ошибки отправки файлов
	$php_errors = [
		1 => "Превышен максимальный развмер файла, указанный в php.ini",
		2 => "Превышен максимальный развмер файла, указанный в форме HTML",
		3 => "Произошла ошибка при передаче файла",
		4 => "Файл для отправки не был выбра"
	];

	$first_name = trim($_REQUEST['first_name']);
	$last_name = trim($_REQUEST['last_name']);
	$email = trim($_REQUEST['email']);

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

	//проверка отсутсивя ошибки при отправке изображения
	$result = move_uploaded_file($_FILES['user_pic']['tmp_name'], $upload_file);

	if(!$result) {
		handle_error("сервер не может получить выбранное вами изображение.", $php_errors[$_FILES['user_pic']['error']]);
		exit();
	}

	$bio = trim($_REQUEST['bio']);

	$insert_sql = "INSERT INTO users (first_name,
									last_name,
									email,
									bio,
									facebook_url,
									twitter_handle)" .
							"VALUES ('{$first_name}',
									'{$last_name}',
									'{$email}',
									'{$bio}',
									'{$facebook_url}',
									'{$twitter_handle}'
									);";

	$result = mysqli_query($link, $insert_sql);
	if(!$result) {
		handle_error("oшибка при выполнении запроса в базу данных.", mysqli_error($link));
		exit();
	}

	header("Location: show_user.php?user_id=" . mysqli_insert_id($link));
	exit();