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
		<h2>Selecciona l'usuari del que vols saber les factures</h2>
		<form action="llistaFactura_usuari_BD.php" method="post">
		<?php $select_personatge = "SELECT DISTINCT propietari 
								    FROM factura
								    order by propietari";
		  echo $tab.'<label>Usuaris: </label><select name="usuari">' . "\n";
		  $comanda = oci_parse($connexio, $select_personatge);
		  oci_execute($comanda);
		  while(($fila = oci_fetch_array($comanda, OCI_ASSOC + OCI_RETURN_NULLS)) != false){
			  echo $tab.$tab."<option value=\"" . $fila['PROPIETARI'] . "\">" . $fila['PROPIETARI'] . "</option>\n";
		  }
		  unset($fila);
		  echo $tab."</select><br>\n";
		?>
		</select><br>
		<input type = "submit" value="Inserir"/>
		</form>
		<?php include 'exPHP_peu.html'; ?>
    </body>
</html>