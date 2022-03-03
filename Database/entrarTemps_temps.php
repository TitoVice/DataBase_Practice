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
			$sentenciaSQL = "UPDATE participantsCurses set temps = '" . $_POST['temps'] . "' 
							 where personatge = '" . $_POST['personatge'] . "' and cursa = '" . $_SESSION['codiCursaTemps'] . "'";
			$lectura = oci_parse($connexio, $sentenciaSQL);
			$exit = oci_execute($lectura);
			if ($exit) {
				echo "<p>Temps inserit.</p>\n";
			} else {
				$error = oci_error($lectura);
				$_SESSION['ErrorSentencia'] = $error['sqltext'];
				$_SESSION['ErrorCodi'] = $error[code];
				$_SESSION['ErrorMissatge'] = $error['message'];
				$_SESSION['ErrorOffset'] = $error['offset'];
				header('Location: exPHP_errorExecucio.php');
			}
		?>
		<?php include 'peu_temps.html'; ?>
    </body>
</html>