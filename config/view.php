<?php
require_once "db_connection.php";
require_once "app_config.php";
require_once "authorize.php";

const SUCCESS_MESSAGE = "success";
const ERROR_MESSAGE = "error";

function display_messages($success_msg = NULL, $error_msg = NULL) {
  echo "<div id='messages'>\n";
  if(!is_null($success_msg) && (strlen($success_msg) > 0)) {
   display_message($success_msg, SUCCESS_MESSAGE);
 }
 if(!is_null($error_msg) && (strlen($error_msg) > 0)) {
   display_message($error_msg, ERROR_MESSAGE);
 }
 echo "</div>\n\n";
}

function display_message($msg, $msg_type) {
  echo " <div class='{$msg_type}'>\n";
  echo " <p>{$msg}</p>\n";
  echo "</div>\n";
}

function display_head($page_title = "", $embedded_javascript = NULL) {
  echo <<<EOD
  <html>
  <head>
    <title>{$page_title}</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/css/phpMM.css">
    <link rel="stylesheet" type="text/css" href="css/jquery.validate.password.css">
    <script type="text/javascript" src="js/jquery-1.8.1.min.js"></script>
    <script type="text/javascript" src="js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="js/jquery.validate.password.js"></script>
EOD;
    if (!is_null($embedded_javascript)) {
      echo "<script type='text/javascript'>" .
      $embedded_javascript .
      "</script>";
   }
   echo " </head>";
 }

 function display_title($title, $success_msg = NULL, $error_msg = NULL) {
  echo <<<EOD
  <body>
    <div id="header">
      <h1>PHP &amp; MySQL: The Missing Manual</h1>
    </div>
    <div id="example">
      {$title}
    </div>
    <div id="menu">
      <ul>
        <li><a href="../index.html">Главная страница</a></li>
EOD;
   if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    echo "<li><a href='show_user.php?user_id={$user_id}'>Мой профиль</a></li>";
    if(user_in_group($user_id, "admins")) {
      echo "<li><a href='show_users.php'>Управление</a></li>";
    }
    echo "<li><a href='signout.php'>Выйти</a></li>";
  } else {
    echo "<li><a href='signin.php'>Войти</a></li>";
  }
  echo <<< EOD
      </ul>
    </div>
EOD;
display_messages($success_msg, $error_msg);
}

function user_in_group($user_id, $group) {
  global $link;

  $query_string =
  "SELECT ug.user_id FROM user_groups ug, groups g
  WHERE g.name = '%s' AND g.id = ug.group_id AND ug.user_id = " .
  mysqli_real_escape_string($link, $_SESSION['user_id']);

  $query = sprintf($query_string,
    mysqli_real_escape_string($link, $group),
    mysqli_real_escape_string($link, $user_id));

  $result = mysqli_query($link, $query);
    if(mysqli_num_rows($result) == 1) {
      return true;
    } else {
      return false;
    }
}

function page_start($title, $javascript = NULL,
  $success_message = NULL, $error_message = NULL) {
  display_head($title, $javascript);
  display_title($title, $success_message, $error_message);
}
