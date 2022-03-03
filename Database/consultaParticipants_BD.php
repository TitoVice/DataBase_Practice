#!/usr/bin/php-cgi
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
        <title>Mostrar participants</title>
        <link rel="stylesheet" href="exemple.css" type="text/css"> 
    </head>
    <body>
        <?php
        include 'exPHP_cap.php';        
        echo "<h2>Tots els Participants</h2>";
        $sentenciaSQL = "SELECT vehicle, personatge, temps
						 from participantsCurses
						 where cursa = (SELECT codi from curses where nom = '" . $_POST['nomCursa'] . "')";
        $comanda = oci_parse($connexio, $sentenciaSQL);
        if ($comanda == false) {
            $_SESSION['ErrorParser'] = $sentenciaSQL;
            header('Location: exPHP_errorParser.php');
        }
        $exit = oci_execute($comanda);
        if (!$exit) {
            $error = oci_error($comanda);
            $_SESSION['ErrorSentencia'] = $error['sqltext'];
            $_SESSION['ErrorCodi'] = $error['code'];
            $_SESSION['ErrorMissatge'] = $error['message'];
            $_SESSION['ErrorOffset'] = $error['offset'];
            header('Location: exPHP_errorExecucio.php');
        }
		
		$sentenciaSQL2 = "SELECT millorTemps
						 from curses
						 where nom = '" . $_POST['nomCursa'] . "'";
        $command = oci_parse($connexio, $sentenciaSQL2);
        if ($command == false) {
            $_SESSION['ErrorParser'] = $sentenciaSQL2;
            header('Location: exPHP_errorParser.php');
        }
        $exit2 = oci_execute($command);
        if (!$exit2) {
            $error = oci_error($command);
            $_SESSION['ErrorSentencia'] = $error['sqltext'];
            $_SESSION['ErrorCodi'] = $error['code'];
            $_SESSION['ErrorMissatge'] = $error['message'];
            $_SESSION['ErrorOffset'] = $error['offset'];
            header('Location: exPHP_errorExecucio.php');
        }
		$acabat = oci_fetch_array($command, OCI_ASSOC + OCI_RETURN_NULLS);
		
		echo "<table>\n";
        $columnes = oci_num_fields($comanda);
        echo "<tr>\n";
        for ($i = 1; $i <= $columnes; $i++) {
            echo "<th>" . htmlentities(oci_field_name($comanda, $i), ENT_QUOTES) . "</th>\n";
        }
        echo "</tr>\n";
         while (($fila = oci_fetch_array($comanda, OCI_ASSOC + OCI_RETURN_NULLS)) != false) {
            echo "<tr>\n";
            echo "  <td>" . ($fila['VEHICLE'] != null ? htmlentities($fila['VEHICLE'], ENT_QUOTES) : "&nbsp;") . "</td>\n";
            echo "  <td>" . ($fila['PERSONATGE'] != null ? htmlentities($fila['PERSONATGE'], ENT_QUOTES) : "&nbsp;") . "</td>\n";
            if ($acabat['MILLORTEMPS']==null){
              echo "<td><strong>Cursa no acabada</strong></td>";
            } else {
			  if($fila['TEMPS']!=null){	
				echo "  <td>" . ($fila['TEMPS'] != null ? htmlentities($fila['TEMPS'], ENT_QUOTES) : "&nbsp;") . "</td>\n";
			  }
			  else{
				  echo "<td><strong>ABANDONAT</strong></td>";
			  }
            }
            echo "</tr>\n";
        }
        echo "</table>\n";
        oci_free_statement($comanda);
		oci_free_statement($command);
        include 'exPHP_peu.html';
        ?>
    </body>
</html>