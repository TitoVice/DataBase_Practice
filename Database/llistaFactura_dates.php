#!/usr/bin/php-cgi
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional">
<html>
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
      <title>Llistat Factures</title>
      <link rel="stylesheet" href="exemple.css" type="text/css"> 
    </head>
    <body>
    <?php include 'exPHP_cap.php'; ?>
	<h2>Les factures es buscaran entre aquestes dues dates</h2>
	<form action="llistaFactura_dates_BD.php" method="post">
	<label>Primera data: </label><input type="date" name="1data"/> (DD/MM/YYYY)<br>
	<label>Primera hora: </label><input type="time" step="1" name="1hora"/> (HH:MI:SS)<br>
	<label>Segona data: </label><input type="date" name="2data"/> (DD/MM/YYYY)<br>
	<label>Segona hora: </label><input type="time" step="1" name="2hora"/> (HH:MI:SS)<br>
	</select><br>
	<input type = "submit" value="Inserir"/>
	</form>
		  
<?php include 'exPHP_peu.html'; ?>
</body>
</html>