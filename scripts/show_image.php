<?php
	require_once '../config/app_config.php';
	require_once '../config/db_connection.php';

	try {
		if (!isset($_REQUEST['image_id'])){
			handle_error("не указано изображение для загрузки.", "не указано изображение для загрузки.");
		}

		$image_id = $_REQUEST['image_id'];

		$select_query = sprintf(
									"SELECT * FROM images WHERE image_id = %d",
									$image_id
								);
		$result = mysqli_query($link, $select_query);
		if(!$result) {
			handle_error("oшибка при выполнении запроса в базу данных.", "Ошибка обнаружения изображения с ID {$image_id}");
			exit();
		}

		$image = mysqli_fetch_array($result);
		header('Content-type: ' . $image['mime_type']);
		header('Content-length: ' . $image['file_size']);

		echo $image['image_data'];

	} catch (Exception $exc) {
		handle_error("произошел сбой при загрзке изображения.", "Ошибка при загрзке изображения: " . $exc->getMessage());
		exit();
	}
