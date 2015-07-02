<?php
	require_once 'app_config.php';

	$link = @mysqli_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
	if(!$link) {
		handle_error("возникла проблема, связанная с подюключением к базе данных, содержащей необходимую информацию.",
		mysqli_connect_error());
		exit();
	}