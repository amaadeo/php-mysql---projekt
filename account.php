<?php 
	session_start();
	
	if(!isset($_SESSION['ifLogIn'])) {
		header('Location: index.php');
		exit();
	}
?>

<!DOCTYPE HTML>
<html lang="pl">

	<head>
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
		<link href='https://fonts.googleapis.com/css?family=Amatic+SC:700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		<meta charset="utf-8" />
		<title>Twoje konto</title>
	</head>
	
	<body>
		<div class="page_content">
			<header class="header">
					
				<ul class="menu">
					<li> <a href="aktualnosci.html" title="AKTUALNOŚCI">STAN KONTA</a></li>
					<li> <a href="getname.php" title="PRZELEW">PRZELEW</a></li>
					<li> <a href="tabelaeast.html" title="TABELA">HISTORIA</a></li>
					<li> <a href="terminarz.html" title="TERMINARZ">MOJE KONTO</a></li>
					<li> <a href="logout.php" title="LOGOUT">WYLOGUJ SIĘ</a></li>				
				</ul>
				
			</header>
				
			<div class="main">
				
			</div>
					
			<footer class="footer">
				<p>&#x24B8; by Amadeusz Janiak | All rights reserverd</p>
			</footer>

		</div>
	</body>
	
</html>