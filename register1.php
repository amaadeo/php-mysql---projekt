<?php 
	session_start();
	
	if(empty($_POST['nick']) || 
	   empty($_POST['email']) || 
	   empty($_POST['haslo1']) || 
	   empty($_POST['haslo2'])) {
		    $_SESSION['error2'] = 'Wszystkie pola muszą być wypełnione.';
			header('Location: registration1.php');
			exit();
	}
	
	$nick = $_POST['nick'];
	$email = $_POST['email'];
	$haslo1 = $_POST['haslo1'];
	$haslo2 = $_POST['haslo2'];
	
	
	if(strlen($nick) > 3 && strlen($nick) < 25 && ctype_alnum($nick) == true) {
		if(strlen($haslo1) > 7 && strlen($haslo1) < 21) {
			if($haslo1 == $haslo2) {
				$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
				
				require_once "connect.php";
				$connect = @new mysqli($host, $db_user, $db_password, $db_name);
				
				if ($connect->connect_errno != 0) {
					echo "Error: ".$connect->connect_errno;
				}
				else {	
					$sprawdzenie_nick_sql = "SELECT * FROM accounts
											 WHERE Login = '$nick'";
				
					if($result=@$connect->query($sprawdzenie_nick_sql)){
						$liczba_wierszy = $result->num_rows;
					
						if($liczba_wierszy == 0){
							$sprawdzenie_maila_sql = "SELECT * FROM accounts 
													  WHERE Email = '$email'";
													  
							if($result=@$connect->query($sprawdzenie_maila_sql)){
								$liczba_wierszy = $result->num_rows;
		
								if($liczba_wierszy == 0){
									$_SESSION['nick'] = $nick;
									$_SESSION['email'] = $email;
									$_SESSION['haslo'] = $haslo_hash;
									header('Location: registration2.php');
									
								}
								else {
									echo 'email w bazie';
									echo $email;
									$_SESSION['error'] = "Podany email jest już w bazie.";
								}
							}
						}
						else {
							echo 'nick zajety';
							$_SESSION['error'] = "Nick jest zajęty.";
						}
					}
				}	
			}
			else {
				echo 'niezgodne hasla';
			}
		}
		else {
			echo 'za krotkie haslo';
		}
	}
	else {
		echo 'za krotki lub za dlugi nick';
	}
?>