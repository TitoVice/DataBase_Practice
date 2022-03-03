#!/usr/bin/php-cgi
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional">
<html>
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
      <title>Alta cursa</title>
      <link rel="stylesheet" href="exemple.css" type="text/css"> 
    </head>
    <body>
	<?php include 'exPHP_cap.php'; ?>
	<?php $data = $_POST['previst'] . " " . $_POST['hora'];
	$insert = "INSERT INTO curses
			  (codi, nom, premi, inscripcio, iniciPrevist) 
			  VALUES ('" . $_POST['codi'] . "', '" . $_POST['nom'] . "', " . $_POST['premi'] . ", " . $_POST['inscripcio'] . ",
			  TO_DATE('" . $data . "','YYYY-MM-DD HH24:MI:SS'))";
		$comanda = oci_parse($connexio, $insert);
		$exit = oci_execute($comanda);
		if ($exit) {
			echo "<p>Cursa: " . $_POST['codi'] . " creada</p>\n";
		} else {
			$error = oci_error($comanda);
			$_SESSION['ErrorSentencia'] = $error['sqltext'];
			$_SESSION['ErrorCodi'] = $error[code];
			$_SESSION['ErrorMissatge'] = $error['message'];
			$_SESSION['ErrorOffset'] = $error['offset'];
			header('Location: exPHP_errorExecucio.php');
		}
	?>
<?php
include 'exPHP_peu.html';
?>
</body>
</html>