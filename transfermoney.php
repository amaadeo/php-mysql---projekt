<?php 
	session_start();
	
	if(!isset($_SESSION['ifLogIn']) && ($_SESSION['ifLogIn'] == false)) {
		header('Location: index.php');
		exit();
	}
	
	if  (empty($_POST['amount']) ||
		empty($_POST['nazwaodbiorcy']) ||
		empty($_POST['numerrachunku']) ||
		empty($_POST['adresodbiorcy']) ||
		empty($_POST['tytulprzelewu'])){
			$_SESSION['error2'] = 'Wszystkie pola muszą być wypełnione.';
			header('Location: transfer.php');
			exit();
	}
	require_once "connect.php";
	$connect = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($connect->connect_errno != 0) {
		echo "Error: ".$connect->connect_errno;
	}
	else {
		$kwota = $_POST['amount'];
		$user = $_POST['nazwaodbiorcy'];
		$account_number = $_POST['numerrachunku'];
		$address = $_POST['adresodbiorcy'];
		$transfertitle = $_POST['tytulprzelewu'];
		
		$konto_nadawcy = $_SESSION['account_number'];
		$stan_konta_nadawcy = $_SESSION['current_ballance'];
		
		$stan_konta_odbirocy_sql = "SELECT a.Current_Ballance FROM accounts as a
								JOIN customers as c
								ON c.Customer_ID = a.Customer_ID
								WHERE c.Name = '$user' 
								AND a.Account_Number = '$account_number'"; 

		if(floatval($stan_konta_nadawcy) >= floatval($kwota) && floatval($kwota) > 0) {
			if ($result=@$connect->query($stan_konta_odbirocy_sql)) {
				$liczba_wierszy = $result->num_rows;
				
				if ($liczba_wierszy == 1) {
					$row = $result->fetch_assoc();
					$stan_konta_odbirocy = $row['Current_Ballance'];
					$new_ballance = floatval($stan_konta_odbirocy) + floatval($kwota);
					
					$nowy_stan_konta_odbiorcy_sql = "UPDATE accounts 
						SET Current_Ballance= '$new_ballance'
						WHERE Account_Number = '$account_number'";
						
			
					if(@$connect->query($nowy_stan_konta_odbiorcy_sql)) {
						$new_ballance2 = $stan_konta_nadawcy - $kwota;

						$nowy_stan_konta_nadawcy_sql = "UPDATE accounts 
											SET Current_Ballance= '$new_ballance2'
											WHERE Account_Number = '$konto_nadawcy'";
											
						$new_transaction_sql = "INSERT INTO transactions (Account_ID, Customer_ID, Transaction_Type_ID, Transaction_Datetime, Transaction_Amount) VALUES ('1', '1', '2', now(), '$kwota')";
						
						if(@$connect->query($nowy_stan_konta_nadawcy_sql));
						if(@$connect->query($new_transaction_sql ));
					
					}
				}
				else {
					$_SESSION['error2'] = 'Nieprawidłowe dane odbiorcy';
					header('Location: transfer.php');
					exit();
				}

				$result->free_result();
				header('Location: account.php');
			}
		
			else{
				$_SESSION['error2'] = 'jakis rerroo';
				header('Location: transfer.php');
				exit();
			}
			$connect->close();
		}
		else {
			$_SESSION['error2'] = 'Brak wystarczającyh środków na koncie.';
			header('Location: transfer.php');
			exit();
		}
	}
?>