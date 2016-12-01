<?php
require("../../../config.php");
require("classes/helper_class.php"); 
	//!!!!!!!!!!
	// see file peab olema koigil lehtedel kus tahan kasutada SESSION muutujat
	session_start();
	$database ="if16_stanislav";
	$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
	
	$Helper = new Helper();
	
?>