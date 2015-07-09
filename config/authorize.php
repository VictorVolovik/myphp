<?php
if ((!isset($_COOKIE['user_id'])) ||(!strlen($_COOKIE['user_id']) > 0)) {
  header("Location: signin.php?error_message=Вам необходимо авторизоваться.");
  exit();
}