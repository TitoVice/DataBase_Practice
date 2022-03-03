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
		<h2>Seleccina la cursa</h2>
		<form action="entrarTemps_personatge.php" method="post">
		<?php $codiCursa = "SELECT codi FROM curses where millorTemps is NULL";
		  echo $tab.'<label>Codi de la cursa: </label><select name="codiCursa">' . "\n";
		  $comanda = oci_parse($connexio, $codiCursa);
		  oci_execute($comanda);
		  while(($fila = oci_fetch_array($comanda, OCI_ASSOC + OCI_RETURN_NULLS)) != false){
			  echo $tab.$tab."<option value=\"" . $fila['CODI'] . "\">" . $fila['CODI'] . "</option>\n";
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