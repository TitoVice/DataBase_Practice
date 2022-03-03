#!/usr/bin/php-cgi
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
        <title>Inscripció</title>
        <link rel="stylesheet" href="exemple.css" type="text/css"> 
    </head>
    <body>
        <?php include 'exPHP_cap.php'; 
		  session_start();
		  $data = $_POST['data'] . " " . $_POST['hora'];
		  $update_data = "UPDATE curses 
						   set iniciReal = TO_DATE('" . $data . "','YYYY-MM-DD HH24:MI:SS')
						   where codi = '" . $_SESSION['codiCursa'] . "'";
		  $command = oci_parse($connexio, $update_data);
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
			echo "Cursa tancada.";  
		  }
		
		?>
		<?php include 'exPHP_peu.html'; ?>
    </body>
</html>