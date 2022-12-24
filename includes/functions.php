<?php
	// require_once "db.php"; 

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

    // Function to sanitize form submissions
	function sanitizeData ($string) {
		$sanitizedString = trim($string);
		$sanitizedString = stripslashes($sanitizedString);
		$sanitizedString = htmlspecialchars($sanitizedString);
		return $sanitizedString;
	}
    
?>

