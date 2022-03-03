#!/usr/bin/php-cgi
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
        <title>Inscripció</title>
        <link rel="stylesheet" href="exemple.css" type="text/css"> 
    </head>
    <body>
        <?php include 'exPHP_cap.php'; ?>
		<h2>Elegeix la data d'inici real</h2>
		<form action="inscripcioUserCursa_data_BD.php" method="post">
		<label>Data d'inici real: </label><input type = "date" name="data"/> (DD/MM/YYYY)<br>
		<label>Hora d'inici real: </label><input type="time" step="1" name="hora"/> (HH:MI:SS)<br>
		</select><br>
		<input type = "submit" value="Inserir"/>
		</form>
		<?php include 'exPHP_peu.html'; ?>
    </body>
</html>
