<?php

  /*
	 * @file: 	header.php
   * @modified: Lareina
	 * @desc:	This file is the header of the website
	 */



  // Include folder Access control 
	// citation from CSCI2170 A4 solution by Dr. Raghav V. Sampangi, =========================
	$currentDirectory = getcwd();
	$accessPreventPattern = "/.*includes$/i";
	$accessAttemptFromIncludesFolder = preg_match($accessPreventPattern, $currentDirectory);
	if ($accessAttemptFromIncludesFolder) {
		header("Location: ../index.php");
		ob_end_flush();
		die();
	}

  // connect to the database
  require_once "includes/db.php"; 

  // sanitize form submissions
  require_once "includes/functions.php"; 


  $currentPage = basename($_SERVER['PHP_SELF']);


?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>DCSSA</title>
	<link rel="icon" href="img/Fevicon.png" type="image/png">
  
  <!-- add for the project purpose -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
