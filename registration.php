<!DOCTYPE HTML>
<html lang="pl">

	<head>
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
		<link href='https://fonts.googleapis.com/css?family=Amatic+SC:700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		<meta charset="utf-8" />
		<title>Rejestracja</title>
	</head>
	
	<body>
		<form action="register.php" method="post">
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
				
			<div class="rejestruj">
				<input type="submit" value="Zarejestruj" class="button"/>
			</div>
		</form>
	</body>
	
</html>