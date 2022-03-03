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
        <h1>Tipus de llistat disponible</h1>
		<p> <a class="menu" href="llistaFactura_dates.php">Llistat entre dues dates</a></p>
		<p> <a class="menu" href="llistaFactura_usuari.php">Llistat d'un usuari</a></p>
	
	<?php include 'exPHP_peu.html';?>
    </body>
</html>
