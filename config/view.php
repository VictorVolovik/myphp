<?php
require_once 'app_config.php';

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
 EOD;
 display_messages($success_msg, $error_msg);
}

function page_start($title, $javascript = NULL,
  $success_message = NULL, $error_message = NULL) {
  display_head($title, $javascript);
  display_title($title, $success_message, $error_message);
}