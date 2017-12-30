<?php 
	session_start();
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
			<div class="box">
				<div class="pasek"><span class="log">Przelew jednorazowy</span></div>
				<form action="transfermoney.php" method="post">
					<div class="leftbox">
						<p> Z rachunku:
						<?php 
							echo $_SESSION['name'].'<br>'.$_SESSION['account_number']; 
						?>
						</p>
						<p> Dostępne środki: 
						<?php 
							echo number_format($_SESSION['current_ballance'], 2); 
						?>
						PLN
						</p>
						<p> Kwota: <input type="number" id="amount" name="amount"/></p>
					</div>
					<div class="rightbox">
						<p> Nazwa odbiorcy: <input type="text" id="nazwaodbiorcy" name="nazwaodbiorcy"/> </p>
						<p> Numer rachunku: <input type="text" id="numerrachunku" name="numerrachunku"/> </p>
						<p> Adres odbiorcy: <input type="text" id="adresodbiorcy" name="adresodbiorcy"/> </p>
						<p> Tytuł przelewu: <input type="text" id="tytulprzelewu" name="tytulprzelewu"/> </p>
					</div>
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
		</div>
	</body>
</html>