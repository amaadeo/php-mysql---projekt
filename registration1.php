<?php 
	session_start();
	
	if(isset($_SESSION['ifLogIn']) && ($_SESSION['ifLogIn'] == true)) {
		header('Location: account.php');
		exit();
	}
	unset($_SESSION['nick']);
	unset($_SESSION['haslo']);
	unset($_SESSION['email']);

	
?>
<!DOCTYPE HTML>
<html lang="pl">

	<head>
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
		<link href='https://fonts.googleapis.com/css?family=Amatic+SC:700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Rejestracja</title>
	</head>
	
	<body>
		<div class="page_content">
				<form action="register1.php" method="post">
					<label for="nick">Nazwa użytkownika:</label> 
						<input type="text" id="nick" name="nick"/>
					<label for="email">E-mail:</label> 
						<input type="email" id="email" name="email"/>
					<label for="haslo1">Hasło:</label> 
						<input type="password" id="haslo1" name="haslo1"/>
					<label for="haslo2">Powtórz hasło:</label> 
						<input type="password" id="haslo2" name="haslo2"/>
					
					<div class="dalej">
						<input type="submit" value="Dalej" class="button"/>
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