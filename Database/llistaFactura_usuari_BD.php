#!/usr/bin/php-cgi
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional">
<html>
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
      <title>Llistat Factures</title>
      <link rel="stylesheet" href="exemple.css" type="text/css"> 
    </head>
    <body>
	<?php include 'exPHP_cap.php'; 
	echo "<h2>Factures de l'usuari</h2>";
        $sentenciaSQL = "SELECT vehicle, SUM(total) as total_factura, count(*) as comptador
						 from factura
						 where propietari = '" . $_POST['usuari'] . "'
						 GROUP BY vehicle
						 order by 2";   
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
			echo "  <td>" . ($fila['TOTAL_FACTURA'] != null ? htmlentities($fila['TOTAL_FACTURA'], ENT_QUOTES) : "&nbsp;") . "</td>\n";
			echo "  <td>" . ($fila['COMPTADOR'] != null ? htmlentities($fila['COMPTADOR'], ENT_QUOTES) : "&nbsp;") . "</td>\n";
            echo "</tr>\n";
        }
        echo "</table>\n";
        oci_free_statement($comanda);
        include 'peu_factura.html';
        ?>
    </body>
</html>