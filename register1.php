<?php 

	function filtruj($zmienna)
	{
		if(get_magic_quotes_gpc())
			$zmienna = stripslashes($zmienna); // usuwamy slashe
	 
	   // usuwamy spacje, tagi html oraz niebezpieczne znaki
		return htmlentities(trim($zmienna), ENT_QUOTES, "UTF-8");
	}
	session_start();
	
	if(empty($_POST['nick']) || 
	   empty($_POST['email']) || 
	   empty($_POST['haslo1']) || 
	   empty($_POST['haslo2'])) {
		    $_SESSION['error2'] = 'Wszystkie pola muszą być wypełnione.';
			$_SESSION['popup'] = true;
			$_SESSION['image'] = '<img src="images/x.png">';
			header('Location: registration1.php');
			exit();
	}
	
	$nick = filtruj($_POST['nick']);
	$email = filtruj($_POST['email']);
	$haslo1 = filtruj($_POST['haslo1']);
	$haslo2 = filtruj($_POST['haslo2']);
	
	
	if(strlen($nick) >= 3 && strlen($nick) <= 25 && ctype_alnum($nick) == true) {
		if(strlen($haslo1) > 7 && strlen($haslo1) < 21) {
			if($haslo1 == $haslo2) {
				$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
				
				require_once "connect.php";
				$connect = @new mysqli($host, $db_user, $db_password, $db_name);
				
				if ($connect->connect_errno != 0) {
					echo "Error: ".$connect->connect_errno;
				}
				else {
					$connect->query ('SET NAMES utf8');
					$connect->query ('SET CHARACTER_SET utf8_unicode_ci');				
					//sprawdzenie czy nick istnieje w bazie
					if($result=@$connect->query(sprintf("SELECT * FROM accounts
														WHERE Login = '%s'", $nick))){
						$liczba_wierszy = $result->num_rows;
					
						if($liczba_wierszy == 0){
							// sprawdzenie czy mail jest w bazie					
							if($result=@$connect->query(sprintf("SELECT * FROM accounts 
																WHERE Email = '%s'", $email))){
								$liczba_wierszy = $result->num_rows;
		
								if($liczba_wierszy == 0){
									$_SESSION['nick'] = $nick;
									$_SESSION['email'] = $email;
									$_SESSION['haslo'] = $haslo_hash;
									header('Location: registration2.php');
								}
								else {
									$_SESSION['error2'] = 'Podany email jest już w bazie użytkowników.';
									$_SESSION['popup'] = true;
									$_SESSION['image'] = '<img src="images/x.png">';
									header('Location: registration1.php');
									exit();
								}
							}
						}
						else {
							$_SESSION['error2'] = 'Podany login jest już w bazie użytkowników.';
							$_SESSION['popup'] = true;
							$_SESSION['image'] = '<img src="images/x.png">';
							header('Location: registration1.php');
							exit();
						}
					}
				}	
			}
			else {
				$_SESSION['error2'] = 'Podane hasła są różne.';
				$_SESSION['popup'] = true;
				$_SESSION['image'] = '<img src="images/x.png">';
				header('Location: registration1.php');
				exit();
			}
		}
		else {
			$_SESSION['error2'] = 'Hasło musi się składać od 8 do 20 znaków.';
			$_SESSION['popup'] = true;
			$_SESSION['image'] = '<img src="images/x.png">';
			header('Location: registration1.php');
			exit();
		}
	}
	else {
		$_SESSION['error2'] = 'Login musi posiadać od 3 do 25 znaków.';
		header('Location: registration1.php');
		exit();
	}
?>