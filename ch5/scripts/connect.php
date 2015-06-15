<?php
	require '../../config/app_config.php';

	$link = mysqli_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);

	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}

	if ($result = mysqli_query($link, "SELECT DATABASE()")) {
	    $row = mysqli_fetch_row($result);
	    printf("Default database is %s.\n", $row[0]);
	    mysqli_free_result($result);
	}

	$result = mysqli_query($link, "SHOW TABLES;");

	if(!$result) {
		die("<p>Ошибка при выводе перечня таблиц: " . mysqli_error($link) . "</p>");
	}

	echo "<p>Таблицы, имеющиеся в базе данных:</p>";
	echo "<ul>";
	while($row = mysqli_fetch_row($result)) {
		echo "<li>Таблица: {$row[0]}</li>";
	}
	echo "</ul>";
	mysqli_close($link);
?>