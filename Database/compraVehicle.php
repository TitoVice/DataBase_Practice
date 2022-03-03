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
	<h2>Usuaris que faran la compra/venda del vehicle</h2>
	<form action="compraVehicleDades.php" method="post">
	  
	  <?php $comprador = 'SELECT alias, nom || \' \' || cognoms as "Nom" 
						  FROM usuaris 
						  order by 2';
	  echo $tab.'<label>Usuari comprador: </label><select name="comprador">' . "\n";
	  $comanda = oci_parse($connexio, $comprador);
	  oci_execute($comanda);
	  while(($fila = oci_fetch_array($comanda, OCI_ASSOC + OCI_RETURN_NULLS)) != false){
		  echo $tab.$tab."<option value=\"" . $fila['ALIAS'] . "\">" . $fila['Nom'] . "</option>\n";
	  }
	  unset($fila);
	  echo $tab."</select><br>\n";
		
	  $venedor = 'SELECT alias, nom || \' \' || cognoms as "Nom" 
				  FROM usuaris 
				  order by 2';
	  echo $tab.'<label>Usuari venedor: </label><select name="venedor">' . "\n";
	  $comanda = oci_parse($connexio, $venedor);
	  oci_execute($comanda);
	  while(($fila = oci_fetch_array($comanda, OCI_ASSOC + OCI_RETURN_NULLS)) != false){
		  echo $tab.$tab."<option value=\"" . $fila['ALIAS'] . "\">" . $fila['Nom'] . "</option>\n";
	  }
	  unset($fila);
	  echo $tab."</select><br>\n";
	?>
	</select><br>
	<input type = "submit" value="Inserir"/>
	</form>
		  
<?php
include 'exPHP_peu.html';
?>
</body>
</html>