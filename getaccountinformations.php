<?php 
	session_start();
	
	if(!isset($_SESSION['ifLogIn']) && ($_SESSION['ifLogIn'] == false)) {
		header('Location: index.php');
		exit();
	}
	else {
		require_once "connect.php";
		$connect = @new mysqli($host, $db_user, $db_password, $db_name);
		
		if ($connect->connect_errno != 0) {
			echo "Error: ".$connect->connect_errno;
		}
		else {
			$connect->query ('SET NAMES utf8');
			$connect->query ('SET CHARACTER_SET utf8_unicode_ci');
			
			$login = $_SESSION['user'];
			
			$name_sql = "SELECT c.Name FROM customers AS c
						 JOIN accounts AS a 
						 ON c.Customer_ID = a.Customer_ID 
						 WHERE Login = '$login'";
						
			$account_number_sql = "SELECT Account_ID, Account_Number, Email FROM accounts 
								   WHERE Login ='$login'";

			$current_ballance_sql = "SELECT Current_Ballance FROM accounts 
									 WHERE Login ='$login'";
			
			$address_sql = "SELECT Street, City, Postcode, Province FROM addresses
							WHERE Address_ID = (
									SELECT Address_ID FROM customers 
										WHERE Customer_ID = (
												SELECT ac.Customer_ID FROM accounts AS ac
												JOIN customers AS c
												ON ac.Customer_ID = c.Customer_ID
												WHERE ac.Login = '$login'
											)
									)";
			$pesel_telefon_branchID_sql = "SELECT c.PESEL, c.Telephone, c.Branch_ID 
											FROM customers as c
											WHERE Customer_ID = (
												SELECT Customer_ID FROM accounts 
												WHERE Login = '$login')";
			
			$result = @$connect->query($name_sql);
			$row = $result->fetch_assoc();
			$_SESSION['name'] = $row['Name'];
				
			$result = @$connect->query($address_sql);
			$row = $result->fetch_assoc();
			$_SESSION['street'] = $row['Street'];
			$_SESSION['city'] = $row['City'];
			$_SESSION['postcode'] = $row['Postcode'];
			$_SESSION['wojewodztwo'] = $row['Province'];
					
			$result = @$connect->query($account_number_sql);
			$row = $result->fetch_assoc();
			$_SESSION['account_number'] = $row['Account_Number'];
			$_SESSION['account_id'] = $row['Account_ID'];
			$_SESSION['email_klienta'] = $row['Email'];

			$result = @$connect->query($current_ballance_sql);
			$row = $result->fetch_assoc();
			$_SESSION['current_ballance'] = $row['Current_Ballance'];
								
			$result = @$connect->query($pesel_telefon_branchID_sql);
			$row = $result->fetch_assoc();
			$_SESSION['pesel'] = $row['PESEL'];
			$_SESSION['telefon'] = $row['Telephone'];
			$branch_ID = $row['Branch_ID'];
			
			$dane_oddzialu_sql = "SELECT * FROM branches
									WHERE Branch_ID = '$branch_ID'";
															
			$result = @$connect->query($dane_oddzialu_sql);
			$row = $result->fetch_assoc();						
			$adresid_oddzialu = $row['Address_ID'];
			$bank_id = $row['Bank_ID'];
			$kod_oddzialu = $row['Branch_Type_ID'];
			
			$adres_odzialu_sql = "SELECT * FROM addresses 
									WHERE Address_ID = '$adresid_oddzialu'";
			$numer_oddzialu_sql = "SELECT Branch_Type_Description FROM branches_type
									WHERE Branch_Type_ID = '$kod_oddzialu'";
										
			$result = @$connect->query($adres_odzialu_sql);
			$row = $result->fetch_assoc();						
			$_SESSION['ulica_oddzialu'] = $row['Street'];
			$_SESSION['miasto_oddzialu'] = $row['City'];
			$_SESSION['kodpocztowy_oddzialu'] = $row['Postcode'];
			$_SESSION['wojewodztwo_oddzialu'] = $row['Province'];

			$result = @$connect->query($numer_oddzialu_sql);
			$row = $result->fetch_assoc();	
			$_SESSION['numer_oddzialu'] = $row['Branch_Type_Description'];
			
			$nazwa_banku_sql = "SELECT Bank_Details FROM banks 
								WHERE Bank_ID = '$bank_id'";
								
			$result = @$connect->query($nazwa_banku_sql);
			$row = $result->fetch_assoc();
			$_SESSION['nazwa_banku'] = $row['Bank_Details'];
								
			$result->free_result();
			
			if($_SESSION['flag']){
				$_SESSION['flag'] = false;	
				header('Location: account.php');
			}
			else if($_SESSION['flag'] == false){
				header('Location: transfer.php');
			}
			$connect->close();
		}
	}
?>