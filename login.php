<?php 

	function filtruj($zmienna)
	{
		if(get_magic_quotes_gpc())
			$zmienna = stripslashes($zmienna); // usuwamy slashe
	 
	   // usuwamy spacje, tagi html oraz niebezpieczne znaki
		return htmlentities(trim($zmienna), ENT_QUOTES, "UTF-8");
	}

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
		$login = filtruj($_POST['login']);
		$password = filtruj($_POST['password']);

		if ($result = @$connect->query(
			sprintf("SELECT * FROM accounts WHERE Login = '%s'",
			mysqli_real_escape_string($connect, $login)))) {
			
				$users_number = $result->num_rows;
				
				if ($users_number > 0) {
					
					$row = $result->fetch_assoc();
					$czy_otwarte = $row['Account_Status_ID'];
					
					if($czy_otwarte == 1) {
						if(password_verify($password, $row['Password'])){
						
						$_SESSION['ifLogIn'] = true;
						$_SESSION['user'] = $row['Login'];
						unset($_SESSION['error']);
						$result->free_result();
						$_SESSION['flag'] = true;
						header('Location: getaccountinformations.php');
						}
						else {
							$_SESSION['error'] = 'Nieprawidłowy login lub hasło!';
							header('Location: index.php');
						}
					}
					else {
					$_SESSION['error'] = 'Nieprawidłowy login lub hasło!';
					header('Location: index.php');
				}
				}
				else {
					$_SESSION['error'] = 'Nieprawidłowy login lub hasło!';
					header('Location: index.php');
				}
		}
		$connect->close();
	}
?> 
