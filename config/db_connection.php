<?php
	require 'app_config.php';

	$link = mysqli_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);

	if (mysqli_connect_errno()) {
		printf("Ошибка подключения: %s\n", mysqli_connect_error());
		exit();
	}
?>