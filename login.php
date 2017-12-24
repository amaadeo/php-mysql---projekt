<?php 
	session_start();
	
	if(!isset($_POST['login']) || !isset($_POST['password'])) {
		header('Location: index.php');
		exit();
	}
	
	require_once "connect.php";
	$connect = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($connect->connect_errno != 0) {
		echo "Error: ".$connect->connect_errno;
	}
	else {
		$login = $_POST['login'];
		$password = $_POST['password'];
		
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		$password = htmlentities($password, ENT_QUOTES, "UTF-8");

		if ($result = @$connect->query(
			sprintf("SELECT * FROM customers WHERE User = '%s' AND Password = '%s'",
			mysqli_real_escape_string($connect, $login),
			mysqli_real_escape_string($connect, $password)))) {
			
				$users_number = $result->num_rows;
				
				if ($users_number == 1) {
					$_SESSION['ifLogIn'] = true;
					
					$row = $result->fetch_assoc();
					$_SESSION['user'] = $row['User'];
					$pass = $row['Password'];
					
					unset($_SESSION['error']);
					$result->free_result();
					header('Location: account.php');
				}
				else {
					$_SESSION['error'] = 'Nieprawidłowy login lub hasło!';
					header('Location: index.php');
				}
		}
		$connect->close();
	}
?> 
