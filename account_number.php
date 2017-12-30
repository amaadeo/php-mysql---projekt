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
		$account_number_sql = "SELECT Account_Number FROM accounts WHERE Login ='$login'";
		
		if ($result = @$connect->query($account_number_sql)) {
			$row = $result->fetch_assoc();
			$_SESSION['account_number'] = $row['Account_Number'];
			$result->free_result();
			header('Location: current_ballance.php');

		}
		$connect->close();
	}
?>