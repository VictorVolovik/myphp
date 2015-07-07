<?php
	require_once 'config/app_config.php';
	require_once 'config/db_connection.php';
	require_once 'config/view.php';

	$error_message = "";

	if (!isset($_COOKIE['user_id'])) {
		if(isset($_POST['username'])) {
			$username = mysqli_real_escape_string($link, trim($_REQUEST['username']));
			$password = mysqli_real_escape_string($link, trim($_REQUEST['password']));

			$query = sprintf(
						"SELECT user_id, username FROM users " .
						" WHERE username = '%s' AND password = '%s';",
						$username, crypt($password, $username)
					);

			$results = mysqli_query($link, $query);

			if(mysqli_num_rows($results) == 1) {
				$result = mysqli_fetch_array($results);
				$user_id = $result['user_id'];
				setrawcookie('user_id', $user_id);
				setrawcookie('username', $result['username']);
				header("Location: scripts/show_user.php?user_id=" . $user_id);
				exit();
			} else {
				$error_message = "Вы дали неверную комбинацию имени пользователя и пароля.";
			}
		}
		page_start("Авторизация", NULL, NULL, $error_message);
?>
		<div id="content">
			<h1>Авторизация в клубе</h1>
			<form  id="signin_form" action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
				<fieldset>
					<label for="username">Имя пользователя:</label>
					<input id="username" type="text" name="username" size="20"
							value="<?php if (isset($username)) echo $username; ?>"><br>
					<label for="password">Пароль:</label>
					<input id="password" type="password" name="password" size="20"><br>
				</fieldset>
				<fieldset class="center">
					<input type="submit" value="Авторизоваться">
				</fieldset>
			</form>
		</div>
		<div id="footer">
		</div>
	</body>
</html>

<?php
	} else {
		$user_id = $_COOKIE['user_id'];
		header("Location: scripts/show_user.php?user_id=" . $user_id);
		exit();
	}