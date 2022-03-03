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
		<h2>Elegeix personatge i vehicle</h2>
		<form action="inscripcioUserCursa_insert.php" method="post">
		<?php session_start();
		  $select_alias = "SELECT alias
						   FROM personatges
						   WHERE usuari = '" . $_POST['alias'] . "'";
		  echo $tab.'<label>Alias del personatge: </label><select name="aliasPers">' . "\n";
		  $comanda = oci_parse($connexio, $select_alias);
		  oci_execute($comanda);
		  while(($fila = oci_fetch_array($comanda, OCI_ASSOC + OCI_RETURN_NULLS)) != false){
			  echo $tab.$tab."<option value=\"" . $fila['ALIAS'] . "\">" . $fila['ALIAS'] . "</option>\n";
		  }
		  unset($fila);
		  echo $tab."</select><br>\n";
		  
		  $select_veh = "SELECT codi
						 FROM vehicles
						 WHERE propietari = '" . $_POST['alias'] . "'";
		  echo $tab.'<label>Codi del vehicle: </label><select name="vehicle">' . "\n";
		  $comanda = oci_parse($connexio, $select_veh);
		  oci_execute($comanda);
		  while(($fila = oci_fetch_array($comanda, OCI_ASSOC + OCI_RETURN_NULLS)) != false){
			  echo $tab.$tab."<option value=\"" . $fila['CODI'] . "\">" . $fila['CODI'] . "</option>\n";
		  }
		  unset($fila);
		  echo $tab."</select><br>\n";
		  
		  $update_saldo = "UPDATE usuaris 
						   set saldo = saldo - (SELECT inscripcio from curses where codi = '" . $_SESSION['codiCursa'] . "')
						   where alias = '" . $_POST['alias'] . "'";
		  $command = oci_parse($connexio, $update_saldo);
		  $exit = oci_execute($command);
		  if (!$exit) {
			$error = oci_error($comanda);
			$_SESSION['ErrorSentencia'] = $error['sqltext'];
			$_SESSION['ErrorCodi'] = $error[code];
			$_SESSION['ErrorMissatge'] = $error['message'];
			$_SESSION['ErrorOffset'] = $error['offset'];
			header('Location: exPHP_errorExecucio.php');
		  }
		  else{
			echo "<br>Saldo de ". $_POST['alias'] . " actualitzat<br>";
		  }
		?>
		</select><br>
		<input type = "submit" value="Inserir"/>
		</form>
		<?php include 'exPHP_peu.html'; ?>
    </body>
</html>