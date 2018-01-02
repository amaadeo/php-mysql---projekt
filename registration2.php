<?php 
	session_start();
	
	if(isset($_SESSION['ifLogIn']) && ($_SESSION['ifLogIn'] == true)) {
		header('Location: account.php');
		exit();
	}
	
	if(!isset($_SESSION['nick']) ||
		!isset($_SESSION['haslo'])||
		!isset($_SESSION['email'])){
		header('Location: index.php');
		exit();	
	}
?>

<!DOCTYPE HTML>
<html lang="pl">

	<head>
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
		<link href='https://fonts.googleapis.com/css?family=Amatic+SC:700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
		<title>Rejestracja</title>
	</head>
	
	<body>
		<div class="page_content">
				<form action="register2.php" method="post">
					<label for="name">Imię:</label> 
						<input type="text" id="name" name="name"/>
					<label for="surname">Nazwisko:</label> 
						<input type="text" id="surname" name="surname"/>
					<label for="street">Ulica:</label> 
						<input type="text" id="street" name="street"/>
					<label for="city">Miasto:</label> 
						<input type="text" id="city" name="city"/>
					<label for="post_code">Kod pocztowy:</label> 
						<input type="text" id="post_code" name="post_code"/>
					<label for="province">Województwo:</label> 
						<input type="text" id="province" name="province"/>
					<label for="country">Kraj:</label> 
						<input type="text" id="country" name="country"/>
					<label for="pesel">PESEL:</label> 
						<input type="text" id="pesel" name="pesel"/>
					<label for="telefon">Telefon:</label> 
						<input type="text" id="telefon" name="telefon"/>	
					
					<div class="rejestruj">
						<input type="submit" value="Zarejestruj" class="button"/>
					</div>
					<div class="error2">
						<?php
							if(isset($_SESSION['error2'])) {
								echo $_SESSION['error2'];
								unset($_SESSION['error2']);
							}
						?>
					</div>
				</form>
		</div>
	</body>
	
</html>