<?php

	function filtruj($zmienna)
	{
		if(get_magic_quotes_gpc())
			$zmienna = stripslashes($zmienna); // usuwamy slashe
	 
	   // usuwamy spacje, tagi html oraz niebezpieczne znaki
		return htmlentities(trim($zmienna), ENT_QUOTES, "UTF-8");
	}

	
	session_start();
	
	if(!isset($_SESSION['ifLogIn']) && ($_SESSION['ifLogIn'] == false)) {
		header('Location: index.php');
		exit();
	}
	
	$_SESSION['popup'] = false;
	
	if (empty($_POST['stare']) ||
		empty($_POST['nowe1']) ||
		empty($_POST['nowe2'])){
			$_SESSION['error2'] = 'Wszystkie pola muszą być wypełnione.';
			$_SESSION['popup'] = true;
			$_SESSION['image'] = '<img src="images/x.png">';
			header('Location: changepassword.php');
			exit();
	}
	require_once "connect.php";
	$connect = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($connect->connect_errno != 0) {
		echo "Error: ".$connect->connect_errno;
	}
	else {
		$connect->query ('SET NAMES utf8');
		$connect->query ('SET CHARACTER_SET utf8_unicode_ci');
		
		$login = $_SESSION['user'];
		$stare = filtruj($_POST['stare']);
		$nowe1 = filtruj($_POST['nowe1']);
		$nowe2 = filtruj($_POST['nowe2']);
		
		if(strlen($nowe1) > 7 && strlen($nowe1) < 21) {
			if($nowe1 == $nowe2) {
				$result = @$connect->query(sprintf("SELECT Password FROM accounts WHERE Login = '%s'", $login));
				$users_number = $result->num_rows;
				$row = $result->fetch_assoc();		
					if ($users_number > 0) {
						
						if(password_verify($stare, $row['Password'])){
							$haslo_hash = password_hash($nowe1, PASSWORD_DEFAULT);
							@$connect->query(sprintf("UPDATE accounts SET Password= '%s' WHERE Login = '%s'", $haslo_hash, $login));
							$_SESSION['error2'] = 'Pomyślnie zmieniono hasło!';
							$_SESSION['popup'] = true;
							$_SESSION['image'] = '<img src="images/v.png">';
							header('Location: account.php');
							exit();
						}
						else {
							$_SESSION['error2'] = 'Stare hasło nieprawidłowe!';
							$_SESSION['popup'] = true;
							$_SESSION['image'] = '<img src="images/x.png">';
							header('Location: changepassword.php');
							exit();
						}
		
					}
			}
			else {
				$_SESSION['error2'] = 'Podane nowe hasła są różne!';
				$_SESSION['popup'] = true;
				$_SESSION['image'] = '<img src="images/x.png">';
				header('Location: changepassword.php');
				exit();
			}
		}
		else {
			$_SESSION['error2'] = 'Nowe hasło musi się składać od 8 do 20 znaków!';
			$_SESSION['popup'] = true;
			$_SESSION['image'] = '<img src="images/x.png">';
			header('Location: changepassword.php');
			exit();
		}
	}
?>