#!/usr/bin/php-cgi
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
        <title>Entrada temps</title>
        <link rel="stylesheet" href="exemple.css" type="text/css"> 
    </head>
    <body>
        <?php include 'exPHP_cap.php'; ?>
		<h2>Selecciona el personatge i el seu temps en la carrera</h2>
		<form action="entrarTemps_temps.php" method="post">
		<?php session_start();
		  if (!empty($_POST['codiCursa'])){
			  $_SESSION['codiCursaTemps'] = $_POST['codiCursa'];
		  }
		  $select_personatge = "SELECT personatge FROM participantsCurses where cursa = '" . $_SESSION['codiCursaTemps'] . "'
								and temps is NULL";
		  echo $tab.'<label>Participants: </label><select name="personatge">' . "\n";
		  $comanda = oci_parse($connexio, $select_personatge);
		  oci_execute($comanda);
		  while(($fila = oci_fetch_array($comanda, OCI_ASSOC + OCI_RETURN_NULLS)) != false){
			  echo $tab.$tab."<option value=\"" . $fila['PERSONATGE'] . "\">" . $fila['PERSONATGE'] . "</option>\n";
		  }
		  unset($fila);
		  echo $tab."</select><br>\n";
		?>
		<label>Temps: </label> <input type="number" step="0.01" min="0" name="temps"/> <br>
		</select><br>
		<input type = "submit" value="Inserir"/>
		</form>
		<?php include 'exPHP_peu.html'; ?>
    </body>
</html>