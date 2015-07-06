<?php
	require_once '../config/app_config.php';
	require_once '../config/db_connection.php';

	$user_id = $_REQUEST['user_id'];

	$delete_query = sprintf(
						"DELETE FROM users WHERE user_id = %d", $user_id
					);

	$result = mysqli_query($link, $delete_query);

	if(!$result || mysqli_affected_rows($link) == 0) {
		handle_error("oшибка при выполнении запроса в базу данных.", "Ошибка удаления пользователя c ID {$user_id}");
		exit();
	}

	$msg = "Указанный пользователь был удален.";

	header("Location: ../show_users.php?success_message={$msg}");
	exit();