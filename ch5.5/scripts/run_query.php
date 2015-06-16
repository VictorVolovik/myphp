<?php
	require '../../config/db_connection.php';


	$query_text = $_REQUEST['query'];
	$result = mysqli_query($link, $query_text);

	if(!$result) {
		die("<p>Ошибка при выполнении SLQ-запроса" . $query_text . ":" . mysqli_error($link). "</p>");
	}

	$return_rows = true;
	if(preg_match("/^\s*(CREATE|INSERT|UPDATE|DELETE|DROP)/i", $query_text)){
		$return_rows = false;
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