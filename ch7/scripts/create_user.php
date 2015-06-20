<?php
	require '../../config/db_connection.php';

	$first_name = trim($_REQUEST['first_name']);
	$last_name = trim($_REQUEST['last_name']);
	$email = trim($_REQUEST['email']);

	$facebook_url = str_replace("facebook.org", "facebook.com",
								trim($_REQUEST['facebook_url']));
	$position = strpos($facebook_url, "facebook.com");
	if($position === false) {
		$facebook_url= "http://facebook.com/" . $facebook_url;
	}

	$twitter_handle = trim($_REQUEST['twitter_handle']);
	$position = strpos($twitter_handle, "@");
	if($position === 0){
		$twitter_handle = substr($twitter_handle, $position + 1);
	}

	$bio = trim($_REQUEST['bio']);

	$insert_sql = "INSERT INTO users (first_name,
									last_name,
									email,
									bio,
									facebook_url,
									twitter_handle)" .
							"VALUES ('{$first_name}',
									'{$last_name}',
									'{$email}',
									'{$bio}',
									'{$facebook_url}',
									'{$twitter_handle}'
									);";

	$result = mysqli_query($link, $insert_sql);
	if(!$result) {
		die("<p>Ошибка при выполнении SLQ-запроса" . $insert_sql . ":" . mysqli_error($link). "</p>");
	}

	header("Location: show_user.php?user_id=" . mysqli_insert_id($link));
	exit();

	mysqli_close($link);
?>