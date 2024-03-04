<?php

require_once 'core.php';


// $valid['success'] = array('success' => false, 'messages' => array());

$userID = $_GET['user'];

if ($userID) {

	$sql = "DELETE FROM users WHERE user_id = '$userID'";

	if ($connect->query($sql) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = "Successfully Removed";
	} else {
		$valid['success'] = false;
		$valid['messages'] = "Error while remove the brand";
	}

	$connect->close();

	header("Location: https://nerissas-grocery.store/users.php");
} // /if $_POST