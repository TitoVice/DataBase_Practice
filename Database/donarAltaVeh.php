#!/usr/bin/php-cgi
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional">
<html>
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
      <title>Alta vehicles</title>
      <link rel="stylesheet" href="exemple.css" type="text/css"> 
    </head>
    <body>
    <?php include 'exPHP_cap.php'; ?>
	  <h2>Dades a entrar del vehicle</h2>
      <form action="donarAltaVeh_BD.php" method="post">
	  <label>Descripció vehicle: </label> <input type="text" name="descripcio"> <br>
	  <label>Color: </label> <input type="text" name="color"> <br>
	  <label>Consum: </label> <input type="number" step="0.01" min="0" name="consum"> <br>
	  <label>Data alta: </label><input type = "date" name="data"/> (DD/MM/YYYY)<br>
	  <label>Hora alta: </label><input type="time" step="1" name="hora"/> (HH:MI:SS)<br>
	  <label>Preu: </label> <input type="number" step="0.01" min="0" name="preu"> <br>
    <?php $grup = 'SELECT codi from grupsVehicles order by 1';
	  echo $tab.'<label>Grups de vehicles: </label><select name="grup">' . "\n";
	  $comanda = oci_parse($connexio, $grup);
	  oci_execute($comanda);
	  while(($fila = oci_fetch_array($comanda, OCI_ASSOC + OCI_RETURN_NULLS)) != false){
		  echo $tab.$tab."<option value=\"" . $fila['CODI'] . "\">" . $fila['CODI'] . "</option>\n";
	  }
	  unset($fila);
	  echo $tab."</select><br>\n";
	
	  $comb = 'SELECT descripcio from combustibles order by 1';
	  echo $tab.'<label>Combustible: </label><select name="comb">' . "\n";
	  $comanda = oci_parse($connexio, $comb);
	  oci_execute($comanda);
	  while(($fila = oci_fetch_array($comanda, OCI_ASSOC + OCI_RETURN_NULLS)) != false){
		  echo $tab.$tab."<option value=\"" . $fila['DESCRIPCIO'] . "\">" . $fila['DESCRIPCIO'] . "</option>\n";
	  }
	  unset($fila);
	  echo $tab."</select><br>\n";
	  $usuaris = 'SELECT alias FROM usuaris order by alias';
      echo $tab.'<label>Propietari: </label><select name="usuaris">' . "\n";
      $comanda = oci_parse($connexio, $usuaris);
      oci_execute($comanda);
      while (($fila = oci_fetch_array($comanda, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
          echo $tab.$tab."<option value=\"" . $fila['ALIAS'] . "\">" . $fila['ALIAS'] . "</option>\n";
      }
    ?>
      </select><br>
      <input type = "submit" value="Inserir"/>
      </form>
<?php
include 'exPHP_peu.html';
?>
</body>
</html>