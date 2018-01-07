<?php 
	session_start();
	
	if(!isset($_SESSION['ifLogIn']) && ($_SESSION['ifLogIn'] == false)) {
		header('Location: index.php');
		exit();
	}
?>

<!DOCTYPE HTML>
<html lang="pl">

	<head>
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
		<link href='https://fonts.googleapis.com/css?family=Amatic+SC:700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Twoje konto</title>
	</head>
	
	<body>
		<div class="page_content">
			<header class="header">
					
				<ul class="menu">
					<li> <a href="getaccountinformations.php" title="ZRÓB PRZELEW">PRZELEW</a></li>
					<li> <a href="gettransactionshistory.php" title="ZOBACZ HISTORIĘ KONTA">HISTORIA KONTA</a></li>
					<li> <a href="accountdetails.php" title="SZCZEGÓŁY TWOJEGO KONTA">MOJE KONTO</a></li>
					<li> <a href="logout.php" title="WYLOGUJ SIĘ">WYLOGUJ SIĘ</a></li>				
				</ul>
				
			</header>
				
			<div class="main">
		
				
			</div>
					
			

		</div>
		<footer class="footer">
				&#x24B8; by Amadeusz Janiak | All rights reserverd
			</footer>
	</body>
	
</html>