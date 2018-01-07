<?php 
	session_start();
	
	if(isset($_SESSION['ifLogIn']) && ($_SESSION['ifLogIn'] == true)) {
		header('Location: account.php');
		exit();
	}
	
	/*if(!isset($_SESSION['nick']) ||
		!isset($_SESSION['haslo'])||
		!isset($_SESSION['email'])){
		header('Location: index.php');
		exit();	
	}*/
?>

<!DOCTYPE HTML>
<html lang="pl">

	<head>
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
		<link href='https://fonts.googleapis.com/css?family=Amatic+SC:700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
		<script  type="text/javascript">
			function myFunction() {
				var zmiennaSesyjna = '<?php echo $_SESSION['popup']; ?>';
				if(zmiennaSesyjna == true) {
					var popup = document.getElementById("myPopup");
					var box = document.getElementById("box");
					box.classList.toggle("zakryj");
					popup.classList.toggle("show");
				}
			}	
		</script>
		
		<title>Rejestracja</title>
	</head>
	
	<body onload="myFunction()">
		<div class="page_content">
			<div class='popup'>
				<span class='popuptext' id='myPopup'>
					<div class='popup-image'>
						<?php 
							if(isset($_SESSION['image'])) {
								echo $_SESSION['image'];
								unset($_SESSION['image']);
							}
						?>
					</div>
						<h2><?php 
							if(isset($_SESSION['error2'])) {
									echo $_SESSION['error2'];
									unset($_SESSION['error2']);
							}
						?></h2>
						<form action='index.php' method='post'>
							<button type='submit' name='submit' class='button'>OK</button>
						</form>
				</span>	
				<?php $_SESSION['popup'] = false; ?>
			</div>
		
			<div class="box" id="box">
				<div class="pasek"><span class="log">Rejestracja (krok 2)</span></div>
				<form action="register2.php" method="post">
					<div class="lewo">
						<label for="name">Imię:</label> 
							<input type="text" id="name" name="name"/>
						<label for="surname">Nazwisko:</label> 
							<input type="text" id="surname" name="surname"/>
						<label for="street">Ulica:</label> 
							<input type="text" id="street" name="street"/>
						<label for="city">Miasto:</label> 
							<input type="text" id="city" name="city"/>
					</div>
					<div class="prawo">
						<label for="post_code">Kod pocztowy:</label> 
							<input type="text" id="post_code" name="post_code"/>
						<label for="province">Województwo:</label> 
							<input type="text" id="province" name="province"/>
						<label for="pesel">PESEL:</label> 
							<input type="text" id="pesel" name="pesel"/>
						<label for="telefon">Telefon:</label> 
							<input type="text" id="telefon" name="telefon"/>	
					</div>
					<div class="buttony">
						<div class="rejestruj">
							<input type="submit" value="Zarejestruj" class="button"/>
						</div>
						<div class="wroc">
								<a onclick="location.href='account.php';"><input type="button" value="Anuluj" class="button">
						</div>
					</div>
				</form>
			</div>
		</div>
		<footer class="footer">
				&#x24B8; by Amadeusz Janiak | All rights reserverd
		</footer>
	</body>
	
</html>