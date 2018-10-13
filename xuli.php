<?php
	$msg = $_POST['msg'];
	$user_id = $_POST['user_id'];

	$conn = mysqli_connect("localhost", "root", "", "nodejs-chat");
	$sql = "INSERT INTO message(user_id, content) VALUES ('".$user_id."','".$msg."')";
	// die($sql);
	$query = mysqli_query($conn, $sql);