<?php
//установка режима отладки
const DEBUG_MODE = true;

const SITE_ROOT = "/";
const HOST_WWW_ROOT = "d:/web/openserver/domains/myphp/";

const DATABASE_HOST = "localhost";
const DATABASE_USERNAME = "root";
const DATABASE_PASSWORD = "";
const DATABASE_NAME = "myphp";

function debug_print($message) {
  if(DEBUG_MODE) {
   echo $message;
 }
}

function handle_error($user_error_message, $system_error_message) {
  session_start();
  $_SESSION['error_message'] = $user_error_message;
  $_SESSION['system_error_message'] = $system_error_message;
  header("Location: " . SITE_ROOT . "show_error.php");
}

function get_web_path($file_system_path) {
  return str_replace(strtolower($_SERVER['DOCUMENT_ROOT']), '', $file_system_path);
}