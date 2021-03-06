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
				var zmiennaSesyjna = '<?php echo $_SESSION['popup']; ?>';
				if(zmiennaSesyjna == true) {
					var popup = document.getElementById("myPopup");
					var box = document.getElementById("box");
					box.classList.toggle("zakryj");
					popup.classList.toggle("show");
				}
			}
		</script>
		
		<title>Przelew</title>
		
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
						<form action='getaccountinformations.php' method='post'>
							<button type='submit' name='submit' class='button'>OK</button>
						</form>
				</span>	
				<?php $_SESSION['popup'] = false; ?>
			</div>
			<div class="box" id="box">
				<div class="pasek"><span class="log">Przelew jednorazowy</span></div>
				<form action="transfermoney.php" method="post">
					<div class="leftbox">
						<p><b>Z rachunku:</b><br><br>
						<?php 
							echo $_SESSION['name'].'<br>'.$_SESSION['street'].'<br>'.$_SESSION['postcode']." ".$_SESSION['city']."<br>".$_SESSION['account_number']; 
						?>
						</p>
						<p><b>Dostępne środki:<br></b> 
						<?php 
							echo number_format($_SESSION['current_ballance'], 2); 
						?>
						PLN
						</p>
						<p><b>Kwota: </b> <input type="number" min="1" max="9999999" step="0.01" id="amount" name="amount" class="kwota"/></p>						
					</div>
					<div class="rightbox">
						<p> Nazwa odbiorcy: <input type="text" id="nazwaodbiorcy" name="nazwaodbiorcy" class="labele"/> </p>
						<p> Numer rachunku: <input type="text" id="numerrachunku" name="numerrachunku" class="labele"/> </p>
						<p> Adres odbiorcy: <textarea rows="5"  id="adresodbiorcy" name="adresodbiorcy"></textarea></p>
						<p> Tytuł przelewu (max. 120 znaków): <textarea rows="5" id="tytulprzelewu" name="tytulprzelewu" maxlength="120"></textarea></p>
					</div>
					<div class="buttony">
						<div class="wroc">
							<a onclick="location.href='account.php';"><input type="button" value="Powrót" class="button">
						</div>
						<div class="dalej"> 
							<input type="submit" value="Wykonaj" class="button" onclick="myFunction()"/>
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