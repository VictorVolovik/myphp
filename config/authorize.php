<?php
	require_once 'app_config.php';
	require_once 'db_connection.php';

	if (!isset($_SERVER['PHP_AUTH_USER']) ||
		!isset($_SERVER['PHP_AUTH_PW'])) {
			header('HTTP/1.1 401 Unauthorized');
			header('WWW-Authenticate: Basic realm="The Social Site"');
			exit("Необходимо указать верное имя пользователя и пароль. Доступ запрещен.");
	}

	$query = sprintf(
						"SELECT user_id, username FROM users " .
						" WHERE username = '%s' AND password = '%s';",
						mysqli_real_escape_string($link, trim($_SERVER['PHP_AUTH_USER'])),
						mysqli_real_escape_string($link, crypt(trim($_SERVER['PHP_AUTH_PW']), $_SERVER['PHP_AUTH_USER']))
					);

	$results = mysqli_query($link, $query);

	if(mysqli_num_rows($results) == 1) {
		$result = mysqli_fetch_array($results);
		$current_user_id = $result['user_id'];
		$current_username = $result['username'];
	} else {
		header('HTTP/1.1 401 Unauthorized');
		header('WWW-Authenticate: Basic realm="The Social Site"');
		exit("Необходимо указать верное имя пользователя и пароль. Доступ запрещен.");
	}