<?php 
	session_Start();
	
	if(!isset($_SESSION['ifLogIn']) && ($_SESSION['ifLogIn'] == false)) {
		header('Location: index.php');
		exit();
	}
	
	if($_SESSION['zamknij']) {
		require_once "connect.php";
		$connect = @new mysqli($host, $db_user, $db_password, $db_name);
		
		if ($connect->connect_errno != 0) {
			echo "Error: ".$connect->connect_errno;
		}
		else {
			$connect->query ('SET NAMES utf8');
			$connect->query ('SET CHARACTER_SET utf8_unicode_ci');
			
			$login = $_SESSION['user'];
			
			$zamknij_konto_sql = "UPDATE accounts SET Account_Status_ID = 0 where Login = '$login'";
			@$connect->query($zamknij_konto_sql);
			$_SESSION['zamknij'] = false;
			header('Location: logout.php');
			exit;
		}
	}
?>