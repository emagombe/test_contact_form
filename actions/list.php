<?php

require "../connections/database.php";

try {
	$connection = conn();

	$sql = "SELECT id, name, email, message, DATE_FORMAT(date_added, '%Y-%m-%d') AS date_added FROM messages ORDER BY messages.date_added DESC;";
	$stmt = $connection->query($sql);
	$result = $stmt->fetchAll();

	die(json_encode($result));
} catch (Exception $ex) {
	die(json_encode([
		"status" => "error",
		"message" => "Something went wrong while trying to send message! Please try again later.",
	]));
}

?>