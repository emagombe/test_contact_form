<?php

require "../connections/database.php";

try {
	$connection = conn();

	if(
		!isset($_POST["name"]) ||
		!isset($_POST["email"]) ||
		!isset($_POST["message"])
	) {
		die(json_encode([
			"status" => "error",
			"message" => "Invalid request",
		]));
	}

	$name = $_POST["name"];
	$email = $_POST["email"];
	$message = $_POST["message"];

	if(strlen(trim($name)) < 3) {
		die(json_encode([
			"status" => "error",
			"message" => "Name must have min of 3 characters without space",
		]));
	}
	if(strlen($name) > 120) {
		die(json_encode([
			"status" => "error",
			"message" => "Name must have max of 120 characters",
		]));
	}

	if(strlen(trim($email)) < 5) {
		die(json_encode([
			"status" => "error",
			"message" => "E-mail must have min of 5 characters without space",
		]));
	}
	if(strlen($email) > 320) {
		die(json_encode([
			"status" => "error",
			"message" => "E-mail must have max of 320 characters",
		]));
	}
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		die(json_encode([
			"status" => "error",
			"message" => "Invalid email",
		]));
	}

	if(strlen(trim($message)) < 10) {
		die(json_encode([
			"status" => "error",
			"message" => "Message must have min of 10 characters without space",
		]));
	}
	if(strlen($message) > 500) {
		die(json_encode([
			"status" => "error",
			"message" => "Message must have max of 500 characters",
		]));
	}

	$sql = "INSERT INTO messages (name, email, message) VALUES (:name, :email, :message);";
	$stmt = $connection->prepare($sql);
	$stmt->bindParam(":name", $name, PDO::PARAM_STR);
	$stmt->bindParam(":email", $email, PDO::PARAM_STR);
	$stmt->bindParam(":message", $message, PDO::PARAM_STR);

	if($stmt->execute()) {
		die(json_encode([
			"status" => "success",
			"message" => "Message sent sucessfully",
		]));
	} else {
		die(json_encode([
			"status" => "error",
			"message" => "Failed to send message",
		]));
	}
} catch (Exception $ex) {
	die(json_encode([
		"status" => "error",
		"message" => "Something went wrong while trying to send message! Please try again later.",
	]));
}

?>