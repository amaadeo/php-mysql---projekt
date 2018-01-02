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
		$current_ballance_sql = "SELECT Current_Ballance FROM accounts WHERE Login ='$login'";
		
		if ($result = @$connect->query($current_ballance_sql)) {
			$row = $result->fetch_assoc();
			$_SESSION['current_ballance'] = $row['Current_Ballance'];
			$result->free_result();
			header('Location: transfer.php');
		}
		$connect->close();
	}
?>