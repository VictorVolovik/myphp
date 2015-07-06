<?php
	require_once 'config/app_config.php';
	require_once 'config/db_connection.php';

	$select_users = "SELECT user_id, first_name, last_name, email FROM users;";

	$result = mysqli_query($link, $select_users);

	if(!result) {
		handle_error("oшибка при выполнении запроса в базу данных.", "Ошибка получения информации о пользователях");
		exit();
	}

	if (isset($_REQUEST['success_message'])) {
		$msg = $_REQUEST['success_message'];
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Пользователи</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/phpMM.css">
		<script type="text/javascript">
		function delete_user(user_id) {
			if (confirm("Вы уверены, что хотите удалить этого пользователя?" + "\nВернуть его уже не удастаться!")){
				window.location = "scripts/delete_user.php?user_id=" + user_id;
			}
		}

		<?php if (isset($msg)) { ?>
			window.onload = function() {
				alert("<?= $msg ?>");
			}
		<?php } ?>
		</script>
	</head>
	<body>
		<div id="header">
			<h1>PHP &amp; MySQL: The Missing Manual</h1>
		</div>
		<div id="example">
				Пользователи
		</div>
		<div id="content">
			<ul>
				<?php
					while ($user = mysqli_fetch_array($result)) {
						$user_row = sprintf(
							"<li><a href='scripts/show_user.php?user_id=%d'>%s %s</a> " .
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