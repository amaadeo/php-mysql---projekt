<?php 
	session_start();
	
	if(!isset($_SESSION['ifLogIn']) && ($_SESSION['ifLogIn'] == false)) {
		header('Location: index.php');
		exit();
	}
	
	if(!empty($_POST['fromdatepicker']) && !empty($_POST['todatepicker'])){
		$from = date_create($_POST['fromdatepicker']);
		$to = date_create($_POST['todatepicker']);
		$fromdate = date_format($from, 'Y-m-d');
		$todate = date_format($to, 'Y-m-d');
		if($fromdate > $todate) {
			$temp = $fromdate;
			$fromdate = $todate;
			$todate = $temp;
		}
	}
	
	require_once "connect.php";
	$connect = @new mysqli($host, $db_user, $db_password, $db_name);
	
	if ($connect->connect_errno != 0) {
		echo "Error: ".$connect->connect_errno;
	}
	else {
		$connect->query ('SET NAMES utf8');
		$connect->query ('SET CHARACTER_SET utf8_unicode_ci');
		
		$numer_klienta = $_SESSION['account_id'];
		
		if(isset($fromdate) && isset($todate)) {
			$cala_historia_sql = "SELECT * FROM (SELECT * FROM transactions 
								  WHERE Account_ID = '$numer_klienta'
								  OR Customer_ID = '$numer_klienta') AS t
								  WHERE DATE_FORMAT(t.Transaction_Datetime,'%Y-%m-%d') BETWEEN DATE_FORMAT('$fromdate', '%Y-%m-%d')
								  AND DATE_FORMAT('$todate', '%Y-%m-%d')";
		}
		else {
			$cala_historia_sql = "SELECT * FROM transactions 
								  WHERE Account_ID = '$numer_klienta'
								  OR Customer_ID = '$numer_klienta'" ;
		}
		
		if ($result = @$connect->query($cala_historia_sql)) {
			$ilosc_wierszy = $result->num_rows;
			$index = 0;

			foreach ($result as $row) {
				$date = date_create($row['Transaction_Datetime']);
				$numery_transakcji[$index] = date_format($date, 'd-m-Y');
				$typy_transkacji[$index] = $row['Transaction_Type_ID'];
				$kwoty_transakcji[$index] = $row['Transaction_Amount'];
				$tytuly_transakcji[$index] = $row['Transaction_Title'];
				$stan_przed[$index] = $row['Account_Ballance_Before'];
				$stan_po[$index] = $row['Account_Ballance_After'];
				$account_id[$index] = $row['Account_ID'];
				$customer_id[$index] = $row['Customer_ID'];
				$index++;	
			}
			
			$index2 = $index - 1;
			
			
				if($ilosc_wierszy > 5) {
					for($i = 0; $i < 5; $i++) {
						$daty[$i] = $numery_transakcji[$index-1];
						if($typy_transkacji[$index-1] == 0) {
							$transakcje[$i] = "Wpłata";
							$kwoty[$i] = $kwoty_transakcji[$index-1];
						}
						else if($typy_transkacji[$index-1] == 1) {
							$transakcje[$i] = "Wypłata";
							$kwoty[$i] = $kwoty_transakcji[$index-1] * -1;
						}
						else if($typy_transkacji[$index-1] == 2) {
							$transakcje[$i] = "Przelew";
							if($account_id[$index-1] == $_SESSION['account_id']) {
								$kwoty[$i] = $kwoty_transakcji[$index-1] * - 1;
							}
							else {
								$kwoty[$i] = $kwoty_transakcji[$index-1];
							}
							
						}
						$tytuly[$i] = $tytuly_transakcji[$index-1];
						$przed[$i] = $stan_przed[$index-1];
						$po[$i] = $stan_po[$index-1];
						
						
						$dane_odbiorcy_sql = "SELECT Name, Street, City, Account_Number FROM (
								SELECT c.Name, ad.Street, ad.City, a.Account_Number, c.Customer_ID FROM customers AS c 
								JOIN addresses AS ad 
								ON ad.Address_ID = c.Address_ID 
								JOIN accounts as a 
								ON c.Customer_ID = a.Customer_ID) as temp
							  WHERE Customer_ID = '$customer_id[$index2]'";
						if ($result = @$connect->query($dane_odbiorcy_sql)) {
							$row = $result->fetch_assoc();
							$names[$i] = $row['Name'];
							$streets[$i] = $row['Street'];
							$cities[$i] = $row['City'];
							$numery_kont[$i] = $row['Account_Number'];
						}
						$index--;
						$index2--;
					}
					$_SESSION['ilosc_wierszy'] = 5;
				}
				else {
					for($i = 0; $i < $ilosc_wierszy; $i++) {
						$daty[$i] = $numery_transakcji[$index-1];
						if($typy_transkacji[$index-1] == 0) {
							$transakcje[$i] = "Wpłata";
							$kwoty[$i] = $kwoty_transakcji[$index-1];
						}
						else if($typy_transkacji[$index-1] == 1) {
							$transakcje[$i] = "Wypłata";
							$kwoty[$i] = $kwoty_transakcji[$index-1] * -1;
						}
						else if($typy_transkacji[$index-1] == 2) {
							$transakcje[$i] = "Przelew";
							if($account_id[$index-1] == $_SESSION['account_id']) {
								$kwoty[$i] = $kwoty_transakcji[$index-1] * - 1;
							}
							else {
								$kwoty[$i] = $kwoty_transakcji[$index-1];
							}
							
						}
						$tytuly[$i] = $tytuly_transakcji[$index-1];
						$przed[$i] = $stan_przed[$index-1];
						$po[$i] = $stan_po[$index-1];
						
						
						$dane_odbiorcy_sql = "SELECT Name, Street, City, Account_Number FROM (
								SELECT c.Name, ad.Street, ad.City, a.Account_Number, c.Customer_ID FROM customers AS c 
								JOIN addresses AS ad 
								ON ad.Address_ID = c.Address_ID 
								JOIN accounts as a 
								ON c.Customer_ID = a.Customer_ID) as temp
							  WHERE Customer_ID = '$customer_id[$index2]'";
						if ($result = @$connect->query($dane_odbiorcy_sql)) {
							$row = $result->fetch_assoc();
							$names[$i] = $row['Name'];
							$streets[$i] = $row['Street'];
							$cities[$i] = $row['City'];
							$numery_kont[$i] = $row['Account_Number'];
						}
						$index--;
						$index2--;
					}
					$_SESSION['ilosc_wierszy'] = $ilosc_wierszy;
				}
			
			$_SESSION['datytransakcji'] = $daty;
			$_SESSION['typytransackji'] = $transakcje;
			$_SESSION['kwotytransackji'] = $kwoty;
			$_SESSION['tytulytransackji'] = $tytuly;
			$_SESSION['kwotaprzed'] = $przed;
			$_SESSION['kwotapo'] = $po;
			$_SESSION['nazwyodbiorcow'] = $names;
			$_SESSION['uliceobiorcow'] = $streets;
			$_SESSION['miastaodbiorcow'] = $cities;
			$_SESSION['numery'] = $numery_kont;
			header('Location: accounthistory.php');
			exit();

		}
	}	
?>
