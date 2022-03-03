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
	echo "<h2>Factures entre les dues dates</h2>";
		$data1 = $_POST['1data'] . " " . $_POST['1hora'];
		$data2 = $_POST['2data'] . " " . $_POST['2hora'];
	
        $sentenciaSQL = "SELECT codi, vehicle, propietari, cursa, tempsCursa, costCombustible, dataFactura, preuServei, iva, total
						 from factura
						 where dataFactura > TO_DATE('" . $data1 . "','YYYY-MM-DD HH24:MI:SS') and dataFactura < TO_DATE('" . $data2 . "','YYYY-MM-DD HH24:MI:SS')
						 order by dataFactura";   
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
            echo "  <td>" . ($fila['CODI'] != null ? htmlentities($fila['CODI'], ENT_QUOTES) : "&nbsp;") . "</td>\n";
            echo "  <td>" . ($fila['VEHICLE'] != null ? htmlentities($fila['VEHICLE'], ENT_QUOTES) : "&nbsp;") . "</td>\n";
			echo "  <td>" . ($fila['PROPIETARI'] != null ? htmlentities($fila['PROPIETARI'], ENT_QUOTES) : "&nbsp;") . "</td>\n";
			echo "  <td>" . ($fila['CURSA'] != null ? htmlentities($fila['CURSA'], ENT_QUOTES) : "&nbsp;") . "</td>\n";
			echo "  <td>" . ($fila['TEMPSCURSA'] != null ? htmlentities($fila['TEMPSCURSA'], ENT_QUOTES) : "&nbsp;") . "</td>\n";
			echo "  <td>" . ($fila['COSTCOMBUSTIBLE'] != null ? htmlentities($fila['COSTCOMBUSTIBLE'], ENT_QUOTES) : "&nbsp;") . "</td>\n";
			echo "  <td>" . ($fila['DATAFACTURA'] != null ? htmlentities($fila['DATAFACTURA'], ENT_QUOTES) : "&nbsp;") . "</td>\n";
			echo "  <td>" . ($fila['PREUSERVEI'] != null ? htmlentities($fila['PREUSERVEI'], ENT_QUOTES) : "&nbsp;") . "</td>\n";
			echo "  <td>" . ($fila['IVA'] != null ? htmlentities($fila['IVA'], ENT_QUOTES) : "&nbsp;") . "</td>\n";
			echo "  <td>" . ($fila['TOTAL'] != null ? htmlentities($fila['TOTAL'], ENT_QUOTES) : "&nbsp;") . "</td>\n";
            echo "</tr>\n";
        }
        echo "</table>\n";
        oci_free_statement($comanda);
        include 'peu_factura.html';
        ?>
    </body>
</html>