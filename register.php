<?php 
	session_start();
	
	if(!isset($_POST['naem']) || 
	   !isset($_POST['surname']) || 
	   !isset($_POST['street']) || 
	   !isset($_POST['city']) || 
	   !isset($_POST['post_code']) || 
	   !isset($_POST['province']) || 
	   !isset($_POST['country'])) {
			header('Location: registration.php');
			exit();
	}
	
	require_once "connect.php";
	$connect = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($connect->connect_errno != 0) {
		echo "Error: ".$connect->connect_errno;
	}
	else {
		$name = $_POST['name'];
		$surname = $_POST['surname'];
		$street = $_POST['street'];
		$city = $_POST['city'];
		$post_code = $_POST['post_code'];
		$province = $_POST['province'];
		$country = $_POST['country'];

		$sql = "INSERT INTO `customers`(`Name`, `Surname`, `User`, `Password`, `Email`) VALUES ('$name', 'surname', 'city', 'province', 'country')";
		
		@$connect->query($sql);
		#$connect->close();
	}
?> 
