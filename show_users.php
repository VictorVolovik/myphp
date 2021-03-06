<?php
require_once 'config/app_config.php';
require_once 'config/authorize.php';
require_once 'config/db_connection.php';
require_once 'config/view.php';

authorize_user(["admins"]);

$select_users = "SELECT user_id, first_name, last_name, email FROM users;";

$result = mysqli_query($link, $select_users);

if(!$result) {
  handle_error("oшибка при выполнении запроса в базу данных.", "Ошибка получения информации о пользователях");
  exit();
}

$delete_user_script = <<<EOD
function delete_user(user_id) {
  if (confirm("Вы уверены, что хотите удалить этого пользователя?" + "Вернуть его уже не удастаться!")){
   window.location = "delete_user.php?user_id=" + user_id;
 }
}
EOD;

$success_message = isset($_REQUEST['success_message']) ? $_REQUEST['success_message'] : NULL;
$error_message = isset($_REQUEST['error_message']) ? $_REQUEST['error_message'] : NULL;

page_start("Пользователи", $delete_user_script,
$success_message, $error_message);
?>

  <div id="content">
   <ul>
    <?php
    while ($user = mysqli_fetch_array($result)) {
      $user_row = sprintf(
       "<li><a href='show_user.php?user_id=%d'>%s %s</a> " .
       "<a href='mailto:%s'>%s</a> " .
       "<a href='javascript:delete_user(%d);'> " .
       "<img class='delete_user' src='images/delete.png' width='15'></a></li>",
       $user['user_id'], $user['first_name'], $user['last_name'],
       $user['email'], $user['email'], $user['user_id']
       );
      echo $user_row;
    }
    ?>
  </ul>
</div>
<div id="footer">
</div>
</body>
</html>
