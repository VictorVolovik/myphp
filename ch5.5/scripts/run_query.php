<?php
	require '../../config/db_connection.php';


	$query_text = $_REQUEST['query'];
	$result = mysqli_query($link, $query_text);

	if(!$result) {
		die("<p>Ошибка при выполнении SLQ-запроса" . $query_text . ":" . mysqli_error($link). "</p>");
	}

	$return_rows = false;
	$query_text = strtoupper($query_text);
	$location = strpos($query_text, "CREATE");
	if($location === false) {
		$location = strpos($query_text, "INSERT");
		if($location === false) {
			$location = strpos($query_text, "UPDATE");
			if($location === false) {
				$location = strpos($query_text, "DELETE");
				if($location === false) {
					$location = strpos($query_text, "DROP");
					if($location === false){
						$return_rows = true;
					}
				}
			}
		}
	}
	if($return_rows){
		echo "<p>Результаты вашего запроса:</p>";
		echo "<ul>";
		while($row = mysqli_fetch_row($result)) {
			echo "<li>{$row[0]}</li>";
		}
		echo "</ul>";
	} else {
		if($result) {
			echo "<p>Запрос сработал.</p>";
			echo "{$query_text}";
		}
	}
?>