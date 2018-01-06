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
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<link rel="stylesheet" href="/resources/demos/style.css">
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script> 	
			$( function() {
				$( "#fromdatepicker" ).datepicker({
					dateFormat: "dd-mm-yy",
					showAnim: "clip"
				});
				$( "#todatepicker" ).datepicker({
					dateFormat: "dd-mm-yy",
					showAnim: "clip"
				});
			});
		</script>
	</head>
	<body>
		<div class="page_content">
				<div class="box">
					<div class="pasek"><span class="log">Historia konta</span></div>
					<form action="gettransactionshistory.php" method="post">
						<div class="pasekdaty">
							<div class="data">
								<div class="napispoddata">Kliknij, aby wybrać datę</div>							
								Od: <input type="text" id="fromdatepicker" name="fromdatepicker" size="10">
								Do: <input type="text" id="todatepicker" name="todatepicker" size="10">
							</div>
							<div class="pokaz">
								<input type="submit" value="Pokaż" class="pokazbut"/>
							</div>
							
						</div>
					</form>
					
					<table class="tabela">
						<tr class="naglowki">
							<td  width="10%" rowspan="2"><font size="5"><b>Data operacji</td>	<td width="10%" rowspan="2" ><font size="5"><b>Rodzaj operacji</b></font></td>	<td width="20%" colspan="2"><font size="5"><b>Stan konta</b></font></td>	<td width="10%" rowspan="2" ><font size="5"><b>Kwota</b></font></td>	<td rowspan="2" ><font size="5"><b>Tytuł operacji</b></font></td>	<td width="20%" rowspan="2" ><font size="5"><b>Odbiorca</b></font></td>	
						</tr>
						<tr class="naglowki">
							<td	>przed</td>	<td>po</td>	
						</tr>
						<?php 
							for($i = 0; $i < $_SESSION['ilosc_wierszy']; $i++)
							{
								echo"<tr>		
										<td>".$_SESSION['datytransakcji'][$i]."</td>
										<td>".$_SESSION['typytransackji'][$i]."</td>
										<td>".number_format($_SESSION['kwotaprzed'][$i], 2)." PLN</td>
										<td>".number_format($_SESSION['kwotapo'][$i], 2)." PLN</td>
										<td>".number_format($_SESSION['kwotytransackji'][$i], 2)."</td>	
										<td>".$_SESSION['tytulytransackji'][$i]."</td>
										<td>".$_SESSION['nazwyodbiorcow'][$i]."<br>".$_SESSION['uliceobiorcow'][$i]."<br>".$_SESSION['miastaodbiorcow'][$i]."<br>"."Nr rachunku: ".$_SESSION['numery'][$i]."</td>
									</tr>";
							}
						?>
					</table>
					<div class="buttony">
						<div class="wroc">
							<a onclick="location.href='account.php';"><input type="button" value="Powrót" class="button">
						</div>
					</div>
			</div>
			
		</div>
		<footer class="footer">
				&#x24B8; by Amadeusz Janiak | All rights reserverd
			</footer>
	</body>
</html>