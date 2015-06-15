<?php
	require '../../config/app_config.php';

	$link = mysqli_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);

	if (mysqli_connect_errno()) {
		printf("Ошибка подключения: %s\n", mysqli_connect_error());
		exit();
	}

	echo "<p>Вы подключены к MySQL с использованием базы данных " . DATABASE_NAME . "</p>";
?>