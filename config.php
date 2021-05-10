<?php
	session_start();
	
	global $db, $adminId,$sessUserId;

	$adminId = (isset($_SESSION["adminId"]) && $_SESSION["adminId"] > 0 ? (int)$_SESSION["adminId"] : 0);

	$sessUserId = (isset($_SESSION["userId"]) && $_SESSION["userId"] > 0 ? (int)$_SESSION["userId"] : 0);
	$sessUserName = (isset($_SESSION["userName"]) && $_SESSION["userName"] > 0 ? (int)$_SESSION["userName"] : NULL);
	

	require_once('database.php');

	require_once('class.pdohelper.php');
	require_once('class.pdowrapper.php');
	$dbConfig = array("host"=>DB_HOST,"dbname"=>DB_NAME,"username"=>DB_USER,"password"=>DB_PASS);
	$db = new PdoWrapper($dbConfig);
	$helper = new PDOHelper();
	$db->setErrorLog(true);

	require_once('functions.php');
	