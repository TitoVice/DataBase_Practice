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
		<?php session_start();
			$millor = "UPDATE curses set millorTemps = 
							 (SELECT MIN(temps) FROM participantsCurses WHERE cursa = '" . $_SESSION['codiCursaTemps'] . "')
							  where codi = '" . $_SESSION['codiCursaTemps'] . "'";
			$lectura = oci_parse($connexio, $millor);
			$exit = oci_execute($lectura);
			
			$millor_temps = "SELECT millorTemps FROM curses
							  WHERE codi = '" . $_SESSION['codiCursaTemps'] . "'";
			$lectura2 = oci_parse($connexio, $millor_temps);
			oci_execute($lectura2);
			$fila = oci_fetch_array($lectura2, OCI_ASSOC + OCI_RETURN_NULLS);
			if ($exit) {
				echo "<p>Millor temps: " . $fila['MILLORTEMPS'] . " (min)</p>\n";
			} else {
				$error = oci_error($lectura);
				$_SESSION['ErrorSentencia'] = $error['sqltext'];
				$_SESSION['ErrorCodi'] = $error[code];
				$_SESSION['ErrorMissatge'] = $error['message'];
				$_SESSION['ErrorOffset'] = $error['offset'];
				header('Location: exPHP_errorExecucio.php');
			}
			$comptador = 0;
			$insert = "INSERT INTO factura (codi, vehicle, propietari, cursa, tempsCursa, costCombustible, dataFactura)
							 SELECT cursa||'_'||vehicle, vehicle, (SELECT usuari from personatges where alias = personatge), cursa, temps, 
							 (SELECT (consum/60)*(SELECT preuUnitat from combustibles where descripcio = combustible) from vehicles where codi = vehicle),
							 (SELECT iniciReal from curses where codi = '" . $_SESSION['codiCursaTemps'] . "')
							 from participantsCurses
							 where cursa = '" . $_SESSION['codiCursaTemps'] . "'";
			$insercio = oci_parse($connexio, $insert);
			$exit = oci_execute($insercio);
			if(!$exit){
				$error = oci_error($insercio);
				$_SESSION['ErrorSentencia'] = $error['sqltext'];
				$_SESSION['ErrorCodi'] = $error[code];
				$_SESSION['ErrorMissatge'] = $error['message'];
				$_SESSION['ErrorOffset'] = $error['offset'];
				header('Location: exPHP_errorExecucio.php');
			}
			
			$tempsMaxim = "(SELECT MAX(temps) from participantsCurses where cursa = '" . $_SESSION['codiCursaTemps'] . "')";
			
			$update2 = "UPDATE factura set tempsCursa =  $tempsMaxim
					   where tempsCursa is NULL and cursa = '" . $_SESSION['codiCursaTemps'] . "'";
			$actualitza2 = oci_parse($connexio, $update2);
			$exit = oci_execute($actualitza2);
			if(!$exit){
				$error = oci_error($actualitza2);
				$_SESSION['ErrorSentencia'] = $error['sqltext'];
				$_SESSION['ErrorCodi'] = $error[code];
				$_SESSION['ErrorMissatge'] = $error['message'];
				$_SESSION['ErrorOffset'] = $error['offset'];
				header('Location: exPHP_errorExecucio.php');
			}
			
			$update = "UPDATE factura set total = costCombustible*tempsCursa + preuServei + (costCombustible*tempsCursa + preuServei) * (iva/100)
					   where cursa = '" . $_SESSION['codiCursaTemps'] . "'";
			$actualitza = oci_parse($connexio, $update);
			$exit = oci_execute($actualitza);
			if(!$exit){
				$error = oci_error($actualitza);
				$_SESSION['ErrorSentencia'] = $error['sqltext'];
				$_SESSION['ErrorCodi'] = $error[code];
				$_SESSION['ErrorMissatge'] = $error['message'];
				$_SESSION['ErrorOffset'] = $error['offset'];
				header('Location: exPHP_errorExecucio.php');
			}
		?>
		<?php include 'exPHP_peu.html'; ?>
    </body>
</html>