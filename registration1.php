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
		<script  type="text/javascript">
			function myFunction() {
				var zmiennaSesyjna = '<?php echo $_SESSION['popup']; ?>';
				if(zmiennaSesyjna == true) {
					var popup = document.getElementById("myPopup");
					var box = document.getElementById("box");
					box.classList.toggle("zakryj2");
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
						<form action='registration1.php' method='post'>
							<button type='submit' name='submit' class='button'>OK</button>
						</form>
				</span>	
				<?php $_SESSION['popup'] = false; ?>
			</div>
			<div class="rejestracja" id="box">
				<div class="pasek"><span class="log">Rejestracja (krok 1)</span></div>
				<form action="register1.php" method="post">
					
					<label for="nick">Login:</label> 
						<input type="text" id="nick" name="nick"/>
					<label for="email">E-mail:</label> 
						<input type="email" id="email" name="email"/>
					<label for="haslo1">Hasło:</label> 
						<input type="password" id="haslo1" name="haslo1"/>
					<label for="haslo2">Powtórz hasło:</label> 
						<input type="password" id="haslo2" name="haslo2"/>
						
						
					<div class="buttony">
						<div class="rejestruj">
							<input type="submit" value="Dalej" class="dalejbutton"/>
						</div>
						<div class="wroc2">
								<a onclick="location.href='account.php';"><input type="button" value="Anuluj" class="anulujbutton">
						</div>
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
		</div>
		<footer class="footer">
				&#x24B8; by Amadeusz Janiak | All rights reserverd
		</footer>
	</body>
	
</html>