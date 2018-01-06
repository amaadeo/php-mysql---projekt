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
			$login = $_SESSION['user'];
			
			$name_sql = "SELECT c.Name FROM customers AS c
						 JOIN accounts AS a 
						 ON c.Customer_ID = a.Customer_ID 
						 WHERE Login = '$login'";
						
			$account_number_sql = "SELECT Account_ID, Account_Number FROM accounts 
								   WHERE Login ='$login'";

			$current_ballance_sql = "SELECT Current_Ballance FROM accounts 
									 WHERE Login ='$login'";
			
			$address_sql = "SELECT Street, City, Postcode FROM addresses
							WHERE Address_ID = (
									SELECT Address_ID FROM customers 
										WHERE Customer_ID = (
												SELECT ac.Customer_ID FROM accounts AS ac
												JOIN customers AS c
												ON ac.Customer_ID = c.Customer_ID
												WHERE ac.Login = '$login'
											)
									)";
			
			if ($result = @$connect->query($name_sql)) {
				$row = $result->fetch_assoc();
				$_SESSION['name'] = $row['Name'];
				
				if ($result = @$connect->query($address_sql)) {
					$row = $result->fetch_assoc();
					$_SESSION['street'] = $row['Street'];
					$_SESSION['city'] = $row['City'];
					$_SESSION['postcode'] = $row['Postcode'];
					
					if ($result = @$connect->query($account_number_sql)) {
						$row = $result->fetch_assoc();
						$_SESSION['account_number'] = $row['Account_Number'];
						$_SESSION['account_id'] = $row['Account_ID'];

						if ($result = @$connect->query($current_ballance_sql)) {
							$row = $result->fetch_assoc();
							$_SESSION['current_ballance'] = $row['Current_Ballance'];

							$result->free_result();
							
							if($_SESSION['flag']){
								$_SESSION['flag'] = false;	
								header('Location: account.php');
							}
							else {
								header('Location: transfer.php');
							}
							
						}
					} 
				}
			}
			$connect->close();
		}
	}
?>