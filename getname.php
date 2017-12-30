<?php 
	session_start();
	
	if(!isset($_SESSION['ifLogIn']) && ($_SESSION['ifLogIn'] == false)) {
		header('Location: index.php');
		exit();
	}
	
	require_once "connect.php";
	$connect = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($connect->connect_errno != 0) {
		echo "Error: ".$connect->connect_errno;
	}
	else {
		$login = $_SESSION['user'];
		$name_sql = "SELECT c.Name FROM customers AS c
					JOIN accounts as a 
					ON c.Customer_ID = a.Customer_ID 
					WHERE Login = '$login'";

		
		if ($result = @$connect->query($name_sql)) {
			$row = $result->fetch_assoc();
			$_SESSION['name'] = $row['Name'];
			
			$result->free_result();
			header('Location: account_number.php'); 
		}
		
		else{
			echo 'otsochodzdddd';
		}
		$connect->close();
	}
?>