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
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
		<link href='https://fonts.googleapis.com/css?family=Amatic+SC:700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		<script  type="text/javascript">
			function myFunction() {
					var popup = document.getElementById("myPopup");
					var box = document.getElementById("box");
					box.classList.toggle("zakryj");
					popup.classList.toggle("show");
				}
		</script>
		
		<title>Szczegóły konta</title>
		
	</head>
	
	<body onload="myFunction()">
		<div class="page_content">
			<div class='popup'>
				<span class='popuptext' id='myPopup'>
						<h2>Czy na pewno chcesz zamknąć swoje konto?</h2>
						<form action='delete.php' method='post'>
							<?php $_SESSION['zamknij'] = true; ?>
							<button type='submit' name='submit' class='button'>Potwierdź</button>
						</form>
						<form action='accountdetails.php' method='post'>
							<button type='submit' name='submit' class='button'>Anuluj</button>
						</form>
				</span>	
				<?php $_SESSION['popup'] = false; ?>
			</div>
			<div class="malybox" id="box">
				<div class="pasek"><span class="log">Szczegóły konta</span></div>
				
				<div class="malyleftbox">
					<p><b>Imię i nazwisko: </b>
						<?php 
							echo $_SESSION['name'];
						?>
					
					<br><b>Adres zamieszkania:<br></b>
						<?php 
							echo $_SESSION['street'].'<br>'.$_SESSION['postcode']." ".$_SESSION['city']."<br>".$_SESSION['wojewodztwo'];
						?>
					
					<b><br>PESEL: </b>
						<?php 
							echo $_SESSION['pesel'];
						?>
					
					<b><br>Numer telefonu: </b>
						<?php 
							echo $_SESSION['telefon'];
						?>
					<b><br>Numer rachunku: </b>
						<?php 
							echo $_SESSION['account_number'];
						?>
					<b><br>Adres e-mail: </b>
						<?php 
							echo $_SESSION['email_klienta'];
						?>
					<b><br><br>Bank:<br></b>
						<?php 
							echo $_SESSION['nazwa_banku']." ".$_SESSION['numer_oddzialu']."<br>".$_SESSION['ulica_oddzialu']."<br>".$_SESSION['kodpocztowy_oddzialu']." ".$_SESSION['miasto_oddzialu']."<br>".$_SESSION['wojewodztwo_oddzialu'];
						?>
					</p>
				</div>
				
				<div class="malyrightbox">
					<p><a href="changepassword.php"><h1> Zmień hasło...</h1></a></p>
					<p><a href="deleteaccount.php"><h1> Zamknij konto...</h1></a></p>
					
					<div class="buttony2">
						<div class="wroc4">
							<a onclick="location.href='account.php';"><input type="button" value="Powrót" class="button">
						</div>
					</div>
				</div>

				
			</div>
		</div>
		<footer class="footer">
				&#x24B8; by Amadeusz Janiak | All rights reserverd
			</footer>
	</body>
</html>