#!/usr/bin/php-cgi
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional">
<html>
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
      <title>Alta cursa</title>
      <link rel="stylesheet" href="exemple.css" type="text/css"> 
    </head>
    <body>
    <?php include 'exPHP_cap.php'; ?>
	<h2>Dades per la nova cursa</h2>
	<form action="altaCursa_BD.php" method="post">
	<label>Codi cursa: </label> <input type="text" name="codi"/> <br>
	<label>Nom cursa: </label> <input type="text" name="nom"/> <br>
	<label>Premi: </label> <input type="number" name="premi"/> <br>
	<label>Inscripció: </label> <input type="number" step="0.01" min="0" name="inscripcio"/> <br>
	<label>Data d'inici prevista: </label><input type="date" name="previst"/> (DD/MM/YYYY)<br>
	<label>Hora d'inici prevista: </label><input type="time" step="1" name="hora"/> (HH:MI:SS)<br>
	</select><br>
	<input type = "submit" value="Inserir"/>
	</form>
		  
<?php
include 'exPHP_peu.html';
?>
</body>
</html>