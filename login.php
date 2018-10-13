<?php
    $conn = mysqli_connect("localhost", "root", "", "nodejs-chat");
    if(isset($_POST['btnLogin'])) {
    	$name = $_POST['name'];
	    $sql = "SELECT * FROM users WHERE name = '$name'";
	    $query = mysqli_query($conn, $sql);
	    $row = mysqli_fetch_assoc($query);
	    if(!empty($row)) {
	    	setcookie("name", $name, time() + (86400 * 30), "/");
	    	setcookie("user_id", $row['id'], time() + (86400 * 30), "/");
	    	header("location:index.php");
	    }
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>LogIn</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="login.css">
	<script type="text/javascript" src="js.js"></script>
</head>
<body>
	<div id="login">
	<form action="" method="post" enctype="multipart/form-data">
	    <h2>Log in</h2>
	    <input type="text" name="name" id="name" placeholder="Enter username..." required="required" />
	    <!-- <input type="password" name="password" id="pass" placeholder="Enter password..." required="required" /> -->
	    <input type="submit" name="btnLogin" id="button" value="Log in"/>
    </form>
</body>
</html>