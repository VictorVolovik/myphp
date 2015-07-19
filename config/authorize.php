<?php
require_once "db_connection.php";
require_once "app_config.php";

session_start();

function authorize_user($groups = NULL) {
  global $link;
  if ((!isset($_SESSION['user_id'])) ||(!strlen($_SESSION['user_id']) > 0)) {
    header("Location: signin.php?error_message=Вам необходимо авторизоваться.");
    exit();
  }

  if ((is_null($groups)) || (empty($groups))) {
    return;
  }

  $query_string =
    "SELECT ug.user_id FROM user_groups ug, groups g
    WHERE g.name = '%s' AND g.id = ug.group_id AND ug.user_id = " .
    mysqli_real_escape_string($link, $_SESSION['user_id']);

  foreach ($groups as $group) {
    $query = sprintf($query_string, mysqli_real_escape_string($link, $group));
    $result = mysqli_query($link, $query);
    if(mysqli_num_rows($result) == 1) {
      return;
    }

    handle_error("вы не прошли авторизацию либо не имеете доступа к данному разделу.", "Неверное имя пользователя или пароль.");
    exit;
  }
}
