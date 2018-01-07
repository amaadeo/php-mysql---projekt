<?php 

	function filtruj($zmienna)
	{
		if(get_magic_quotes_gpc())
			$zmienna = stripslashes($zmienna); // usuwamy slashe
	 
	   // usuwamy spacje, tagi html oraz niebezpieczne znaki
		return htmlentities(trim($zmienna), ENT_QUOTES, "UTF-8");
	}

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
	$name = filtruj($_POST['name']);
	$surname = filtruj($_POST['surname']);
	$full_name = $name . " " . $surname;
	$street = filtruj($_POST['street']);
	$city = filtruj($_POST['city']);
	$post_code = filtruj($_POST['post_code']);
	$province = filtruj($_POST['province']);
	$pesel = filtruj($_POST['pesel']);
	$telefon = filtruj($_POST['telefon']);
	$nick = filtruj($_SESSION['nick']);
	$haslo = filtruj($_SESSION['haslo']);
	$email = filtruj($_SESSION['email']);
	
	if(is_numeric($pesel) && is_numeric($telefon) && strlen($telefon) == 9 && strlen($pesel) == 11){
	
		require_once "connect.php";
		$connect = @new mysqli($host, $db_user, $db_password, $db_name);
		
		if ($connect->connect_errno != 0) {
			echo "Error: ".$connect->connect_errno;
		}
		else {	
			$connect->query ('SET NAMES utf8');
			$connect->query ('SET CHARACTER_SET utf8_unicode_ci');	
			//sprawdzenie czy adres jest juz w bazie
			if($result=@$connect->query(sprintf("SELECT Address_ID FROM addresses 
												  WHERE Street = '%s'
												  AND City = '%s'
												  AND Postcode = '%s'
												  AND Province = '%s'",
										$street, $city, $post_code, $province))) {
				$liczba_wierszy = $result->num_rows;
				$row = $result->fetch_assoc();
				
				if($liczba_wierszy == 0){
					// dodanie nowego adresu do bazy
					if($result=@$connect->query(sprintf("INSERT INTO addresses (Street, City, Postcode, Province)
														VALUES ('%s', '%s', '%s', '%s')",
												$street, $city, $post_code, $province))) {
						if($result=@$connect->query(sprintf("SELECT Address_ID FROM addresses 
												  WHERE Street = '%s'
												  AND City = '%s'
												  AND Postcode = '%s'
												  AND Province = '%s'",
										$street, $city, $post_code, $province))) {
							$liczba_wierszy = $result->num_rows;
							$row = $result->fetch_assoc();
						}
					}
				}
				$adres_id = $row['Address_ID'];
				//sprawdzenie czy pesel jest w bazie	
				if($result=@$connect->query(sprintf("SELECT * FROM customers 
										  WHERE PESEL = '%s'", $pesel))){
					$liczba_wierszy = $result->num_rows;
					if($liczba_wierszy == 0) {
						//dodanie nowego klienta do bazy
						if($result=@$connect->query(sprintf("INSERT INTO customers (Address_ID, Branch_ID, Name, PESEL, Telephone)
															VALUES ('%s', '1', '%s', '%s', '%s')", 
													$adres_id, $full_name, $pesel, $telefon))){
							//pobranie z bazy id nowego klienta
							if($result=@$connect->query(sprintf("SELECT Customer_ID FROM customers
												WHERE PESEL = '%s'", $pesel))){
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
												@$connect->query($dodanie_klienta_sql);
												$konto = false;
											}
										}
									}
									$connect->close();
									$_SESSION['error2'] = 'Rejestracja przebiegła pomyślnie!';
									$_SESSION['popup'] = true;
									$_SESSION['image'] = '<img src="images/v.png">';
									header('Location: registration2.php');
									exit();
								}
							}
						}
					}
					else {
						$_SESSION['error2'] = 'Podany numer PESEL jest już w bazie użytkowników.';
						$_SESSION['popup'] = true;
						$_SESSION['image'] = '<img src="images/x.png">';
						header('Location: registration2.php');
						exit();
					}
				}
			}
			echo $street;
		}
	}
	else {
		$_SESSION['error2'] = 'Podany PESEL lub telefon jest nie prawidlowy';
		$_SESSION['popup'] = true;
		$_SESSION['image'] = '<img src="images/x.png">';
		header('Location: registration2.php');
		exit();
	}
	unset($_SESSION['nick']);
	unset($_SESSION['email']);
	unset($_SESSION['haslo_hash']);
?> 