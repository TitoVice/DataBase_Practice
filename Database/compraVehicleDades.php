#!/usr/bin/php-cgi
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional">
<html>
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
      <title>Compra d'un vehicle</title>
      <link rel="stylesheet" href="exemple.css" type="text/css"> 
    </head>
    <body>
    <?php include 'exPHP_cap.php'; ?>
	<h2>Dades de la transacció</h2>
	<form action="compraVehicle_BD.php" method="post">
	  
	  <?php 
      session_start();
      if (!empty($_POST['venedor'])){
          $_SESSION['ven'] = $_POST['venedor'];
          $_SESSION['comp'] = $_POST['comprador'];
      }
	  
	  $vehicle = "SELECT v.codi 
						FROM vehicles v, usuaris u 
						where v.propietari = u.alias and u.alias = (SELECT alias from usuaris where alias = '" . $_POST['venedor'] . "') and v.habilitat = 'apte'";
	  echo $tab.'<label>Vehicle a vendre: </label><select name="vehicle">' . "\n";
	  $comanda = oci_parse($connexio, $vehicle);
	  oci_execute($comanda);
	  while(($fila = oci_fetch_array($comanda, OCI_ASSOC + OCI_RETURN_NULLS)) != false){
		  echo $tab.$tab."<option value=\"" . $fila['CODI'] . "\">" . $fila['CODI'] . "</option>\n";
	  }
	  unset($fila);
	  echo $tab."</select><br>\n";
	?>
	<label>Nou codi vehicle: </label> <input type="text" name="nouCodi"/> <br>
	<label>Preu vehicle: </label> <input type="number" step="0.01" min="0" name="preu"/> <br>
	<label>Data transacció: </label><input type = "date" name="data"/> (DD/MM/YYYY)<br>
	<label>Hora transacció: </label><input type="time" step="1" name="hora"/> (HH:MI:SS)<br>
	</select><br>
	<input type = "submit" value="Inserir"/>
	</form>
		  
<?php
include 'exPHP_peu.html';
?>
</body>
</html>