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
		<h2>Elegeix l'usuari</h2>
		<form action="inscripcioUserCursa_dades.php" method="post">
		<?php session_start();
		  if (!empty($_POST['codiCursa'])){
			  $_SESSION['codiCursa'] = $_POST['codiCursa'];
		  }
		  $select_alias = "SELECT alias FROM usuaris where alias not in 
						   (SELECT usuari from personatges where alias in 
						   (SELECT personatge from participantsCurses where cursa = '" . $_SESSION['codiCursa'] . "'))
						    and alias in (SELECT usuari from personatges) 
							and saldo >= (SELECT inscripcio from curses where codi = '" . $_SESSION['codiCursa'] . "')
							order by alias";
		  echo $tab.'<label>Alias usuari: </label><select name="alias">' . "\n";
		  $comanda = oci_parse($connexio, $select_alias);
		  oci_execute($comanda);
		  while(($fila = oci_fetch_array($comanda, OCI_ASSOC + OCI_RETURN_NULLS)) != false){
			  echo $tab.$tab."<option value=\"" . $fila['ALIAS'] . "\">" . $fila['ALIAS'] . "</option>\n";
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
