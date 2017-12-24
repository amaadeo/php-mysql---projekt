<?php 
	session_start();
	
	if(isset($_SESSION['ifLogIn']) && ($_SESSION['ifLogIn'] == true)) {
		header('Location: account.php');
		exit();
	}
?>

<!DOCTYPE HTML>
<html lang="pl">

	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
		<link href='https://fonts.googleapis.com/css?family=Amatic+SC:700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		<title>System bankowy</title>
		
	</head>
	
	<body>
		<div class="page_content">
			<div class="main">
				<div id="logowanie">
					<div class="pasek"><span class="log">Logowanie</span></div>
					<form action="login.php" method="post">
							<label for="login">Nazwa użytkownika:</label> 
								<input type="text" id="login" name="login"/>
							<label for="password">Hasło:</label> 
								<input type="password" id="password" name="password"/>
						<div class="dol">
							<div class="error">
								<?php
									if(isset($_SESSION['error'])) {
										echo $_SESSION['error'];
										session_unset();
									}
								?>
							</div>
							<div class="zaloguj">
								 <input type="submit" value="Zaloguj się" class="button"/>
							</div>
							
							
						</div>
					</form>
				</div>
				<div id="rejestracja">
					<div class="pasek2"><span class="log">Nie masz jeszcze konta?</span></div>
					<form action="registration.php" method="post">
						<div class="zarejestruj">
							<input type="submit" value="Zarejestruj się" class = "button"/>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>