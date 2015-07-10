<?php
require_once "config/app_config.php";
require_once "config/authorize.php";
require_once "config/db_connection.php";

authorize_user(["admins"]);


$user_id = $_REQUEST['user_id'];
$current_user = $_COOKIE['user_id'];

$delete_query = sprintf(
  "DELETE FROM users WHERE user_id = %d", $user_id
  );

$result = mysqli_query($link, $delete_query);

if(!$result || mysqli_affected_rows($link) == 0) {
  handle_error("oшибка при выполнении запроса в базу данных.", "Ошибка удаления пользователя c данным ID {$user_id}");
  exit();
}

if($current_user === $user_id) {
  setcookie("user_id", "", time()-(365*24*60*60), "/");
}


$msg = "Указанный пользователь был удален.";

header("Location: ../show_users.php?success_message={$msg}");
exit();