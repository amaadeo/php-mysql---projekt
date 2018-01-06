<?php 
	session_start();
	
	if(empty($_POST['name']) || 
	   empty($_POST['surname']) || 
	   empty($_POST['street']) || 
	   empty($_POST['city']) || 
	   empty($_POST['post_code']) || 
	   empty($_POST['province']) || 
	   empty($_POST['pesel']) ||
	   empty($_POST['telefon'])) {
		    $_SESSION['error2'] = 'Wszystkie pola muszą być wypełnione.';
			header('Location: registration2.php');
			exit();
	}
	
	$_SESSION['popup'] = false;			
	$name = $_POST['name'];
	$surname = $_POST['surname'];
	$full_name = $name . " " . $surname;
	$street = $_POST['street'];
	$city = $_POST['city'];
	$post_code = $_POST['post_code'];
	$province = $_POST['province'];
	$pesel = $_POST['pesel'];
	$telefon = $_POST['telefon'];
	$nick = $_SESSION['nick'];
	$haslo = $_SESSION['haslo'];
	$email = $_SESSION['email'];
	
	if(is_numeric($pesel) && is_numeric($telefon) && strlen($telefon) == 9 && strlen($pesel) == 11){
	
		require_once "connect.php";
		$connect = @new mysqli($host, $db_user, $db_password, $db_name);
		
		if ($connect->connect_errno != 0) {
			echo "Error: ".$connect->connect_errno;
		}
		else {			
			$sprawdzenie_addressid_sql = "(SELECT Address_ID FROM addresses 
										  WHERE Street = '$street'
										  AND City = '$city'
										  AND Postcode = '$post_code'
										  AND Province = '$province')";
										
			if($result=@$connect->query($sprawdzenie_addressid_sql)){
				$liczba_wierszy = $result->num_rows;
				$row = $result->fetch_assoc();
				
				if($liczba_wierszy == 0){
					$nowy_adres_sql = "INSERT INTO addresses (Street, City, Postcode, Province)
									   VALUES ('$street', '$city', '$post_code', '$province')";
					if($result=@$connect->query($nowy_adres_sql)) {
						if($result=@$connect->query($sprawdzenie_addressid_sql)) {
							$liczba_wierszy = $result->num_rows;
							$row = $result->fetch_assoc();
						}
					}
				}
				
				$adres_id = $row['Address_ID'];
				
				$sprawdzenie_pesel_sql = "SELECT * FROM customers 
										  WHERE PESEL = '$pesel'";
					
				if($result=@$connect->query($sprawdzenie_pesel_sql)){
					$liczba_wierszy = $result->num_rows;
					if($liczba_wierszy == 0) {
						$nowy_klient_sql = "INSERT INTO customers (Address_ID, Branch_ID, Name, PESEL, Telephone)
											VALUES ('$adres_id', '1', '$full_name', '$pesel', '$telefon')";
						if($result=@$connect->query($nowy_klient_sql)){
							$customer_id_sql = "SELECT Customer_ID FROM customers
												WHERE PESEL = '$pesel'";
							if($result=@$connect->query($customer_id_sql)){
								$liczba_wierszy = $result->num_rows;
								if($liczba_wierszy == 1) {
									$row = $result->fetch_assoc();
									$customer_id = $row['Customer_ID'];
									$konto = true;
									while($konto){
										$numer_konta = mt_rand(99999999, 999999999);
										$sprawdzenie_numeru_konta_sql = "SELECT Account_Number FROM accounts
																		 WHERE Account_Number = '$numer_konta'";
										
										if($result=@$connect->query($sprawdzenie_numeru_konta_sql)){
											$liczba_wierszy = $result->num_rows;
											if($liczba_wierszy == 0) {
												$dodanie_klienta_sql = "INSERT INTO accounts (Customer_ID, Login, Password, Email, Account_Number)
																		VALUES ('$customer_id', '$nick', '$haslo', '$email', '$numer_konta')";
												if($result=@$connect->query($dodanie_klienta_sql));
												$konto = false;
											}
										}
									}
									$connect->close();
									$_SESSION['popup'] = true;
									header('Location: registration2.php');
									exit();
								}
							}
						}
					}
					else {
						$_SESSION['error2'] = 'Podany numer PESEL jest już w bazie użytkowników.';
						header('Location: registration2.php');
						exit();
					}
				}
			}
		}
	}
	else {
		$_SESSION['error2'] = 'Podany PESEL lub telefon jest nie prawidlowy';
		header('Location: registration2.php');
		exit();
	}
	unset($_SESSION['nick']);
	unset($_SESSION['email']);
	unset($_SESSION['haslo_hash']);
?> 