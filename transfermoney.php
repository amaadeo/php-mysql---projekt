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
	
	if (empty($_POST['amount']) ||
		empty($_POST['nazwaodbiorcy']) ||
		empty($_POST['numerrachunku']) ||
		empty($_POST['adresodbiorcy']) ||
		empty($_POST['tytulprzelewu'])){
			$_SESSION['error2'] = 'Wszystkie pola muszą być wypełnione.';
			$_SESSION['popup'] = true;
			$_SESSION['image'] = '<img src="images/x.png">';
			header('Location: transfer.php');
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
		$kwota = filtruj($_POST['amount']);
		$user = filtruj($_POST['nazwaodbiorcy']);
		$account_number = filtruj($_POST['numerrachunku']);
		$address = filtruj($_POST['adresodbiorcy']);
		$transfertitle = filtruj($_POST['tytulprzelewu']);
		
		$konto_nadawcy = $_SESSION['account_number'];
		$stan_konta_nadawcy = $_SESSION['current_ballance'];
		$account_id_nadawcy = $_SESSION['account_id'];
		
		if($account_number != $konto_nadawcy) {
			if(is_numeric($account_number)) {				
				if(strlen($account_number) == 9) {
					if(floatval($stan_konta_nadawcy) >= floatval($kwota)) {

							//stan konta odbiorcy
							if ($result=@$connect->query(sprintf("SELECT a.Current_Ballance, a.Customer_ID 
																FROM accounts as a
																JOIN customers as c
																ON c.Customer_ID = a.Customer_ID
																WHERE c.Name = '%s' 
																AND a.Account_Number = '%s'", $user, $account_number))) {
												
								$liczba_wierszy = $result->num_rows;
									
								if ($liczba_wierszy == 1) {
									$row = $result->fetch_assoc();
									$stan_konta_odbirocy = $row['Current_Ballance'];
									$customer_id_odbiorcy = $row['Customer_ID'];
									$new_ballance = floatval($stan_konta_odbirocy) + floatval($kwota);
																
									//nowy stan konta odbiorcy
									@$connect->query(sprintf("UPDATE accounts 
																SET Current_Ballance = '%s'
																WHERE Account_Number = '%s'", 
														$new_ballance, $account_number)); 
									$new_ballance2 = $stan_konta_nadawcy - $kwota;
									

									//nowy stan konta nadawcy
									@$connect->query(sprintf("UPDATE accounts 
															SET Current_Ballance = '%s'
															WHERE Account_Number = '%s'",
													$new_ballance2, $konto_nadawcy));

									
									//dodanie nowej transakcji do bazy 
									@$connect->query(sprintf("INSERT INTO transactions 
															(Account_ID, Customer_ID, Transaction_Type_ID, Transaction_Datetime, 
															Transaction_Amount, Transaction_Title, Account_Ballance_Before, Account_Ballance_After) 
															VALUES ('%s', '%s', '2', now(), '%s', '%s', '%s', '%s')",
													$account_id_nadawcy, $customer_id_odbiorcy, $kwota, $transfertitle, $stan_konta_nadawcy, $new_ballance2));
									
								}
								else {
									$_SESSION['error2'] = 'Nieprawidłowe dane odbiorcy!';
									$_SESSION['popup'] = true;
									$_SESSION['image'] = '<img src="images/x.png">';
									header('Location: transfer.php');
									exit();
								}
								$result->free_result();
								$connect->close();
								$_SESSION['error2'] = 'Przelew wykonano pomyślnie!';
								$_SESSION['popup'] = true;
								$_SESSION['image'] = '<img src="images/v.png">';
								header('Location: transfer.php');
							}
					}
					else {
						$connect->close();
						$_SESSION['error2'] = 'Brak wystarczającyh środków na koncie!';
						$_SESSION['popup'] = true;
						$_SESSION['image'] = '<img src="images/x.png">';
						header('Location: transfer.php');
						exit();
					}
				}
				else {
				$connect->close();
				$_SESSION['error2'] = 'Podany numer rachunku jest nieprawidłowy!';
				$_SESSION['popup'] = true;
				$_SESSION['image'] = '<img src="images/x.png">';
				header('Location: transfer.php');
				exit();
				}
			}
			else {
			$connect->close();
			$_SESSION['error2'] = 'Podany numer rachunku jest nieprawidłowy!';
			$_SESSION['popup'] = true;
			$_SESSION['image'] = '<img src="images/x.png">';
			header('Location: transfer.php');
			exit();
			}
		}
		else {
			$connect->close();
			$_SESSION['error2'] = 'Podany numer rachunku jest Twoim numerem konta!';
			$_SESSION['popup'] = true;
			$_SESSION['image'] = '<img src="images/x.png">';
			header('Location: transfer.php');
			exit();
		}
	}
?>