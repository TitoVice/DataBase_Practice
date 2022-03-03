#!/usr/bin/php-cgi
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional">
<html>
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
      <title>Consulta participants</title>
      <link rel="stylesheet" href="exemple.css" type="text/css"> 
    </head>
    <body>
    <?php include 'exPHP_cap.php'; ?>
	<h2>Selecciona una cursa</h2>
	<form action="consultaParticipants_BD.php" method="post">
	
	<?php $nomCursa = "SELECT nom FROM curses order by 1";
	  echo $tab.'<label>Nom de la cursa: </label><select name="nomCursa">' . "\n";
	  $comanda = oci_parse($connexio, $nomCursa);
	  oci_execute($comanda);
	  while(($fila = oci_fetch_array($comanda, OCI_ASSOC + OCI_RETURN_NULLS)) != false){
		  echo $tab.$tab."<option value=\"" . $fila['NOM'] . "\">" . $fila['NOM'] . "</option>\n";
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