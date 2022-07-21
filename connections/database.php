<?php 

function conn() {

	try {
		$host = "localhost";
		$port = 3306;
		$database = "contact_form";
		$username = "root";
		$password = "";
		$charset = "utf8";
		$connection = new PDO("mysql:host=$host;port=$port;dbname=$database;charset=$charset", $username, $password);
		return $connection;
	} catch(Exception $ex) {
		throw new Error($ex->getMessage());
	}
}