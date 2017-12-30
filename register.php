<?php 
	session_start();
	
	if(!isset($_POST['name']) || 
	   !isset($_POST['surname']) || 
	   !isset($_POST['street']) || 
	   !isset($_POST['city']) || 
	   !isset($_POST['post_code']) || 
	   !isset($_POST['province']) || 
	   !isset($_POST['country'])) {
			header('Location: registration.php');
			exit();
	}
	
	$nie = "niedziala";
	$tak = "dziala";
	require_once "connect.php";
	$connect = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($connect->connect_errno != 0) {
		echo "Error: ".$connect->connect_errno;
		header('Location: index2.php');
	}
	else {
		
		$name = $_POST['name'];
		$surname = $_POST['surname'];
		$street = $_POST['street'];
		$city = $_POST['city'];
		$post_code = $_POST['post_code'];
		$province = $_POST['province'];
		$country = $_POST['country'];

		$customer = "INSERT INTO customers (Customer_ID, Address_ID, Branch_ID, Name, Surname, User, Password, Email) VALUES ('4', '4', '4', '$name', '$surname', '$city', '$province', '$country')";
		
		$address = "INSERT INTO addresses(Line_1, Town_City, Zip-Postcode, State_Province_County, Country) VALUES ('$street', '$city', '$post_code', '$province', '$country')";

		
		if(@$connect->query($customer)){
		
			echo $tak;
		}
		else {
			echo $nie;
		}
		$connect->close();
	}
?> 
