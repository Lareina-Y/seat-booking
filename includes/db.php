<?php
	/*
	 * @file: 	db.php
	 * @author: 
	 * @desc:	This file connects to the database and creates the connection object.
	 * @notes:	
	 * 
	 */

	$host = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "dcssa"; 

	$conn = new mysqli($host, $username, $password, $dbname);

	if ($conn->connect_error) {
		die("Nooooooooo!" . $conn->connect_error);
	}

?>
