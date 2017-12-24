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
		<?php 
			echo "<p>Witaj ".$_SESSION['user']."</p>";
		?> 
		<form action="logout.php" method="post">
			<input type="submit" value="Wyloguj" />
	    </form>
		
	</body>
	
</html>