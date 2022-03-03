#!/usr/bin/php-cgi
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
        <title>Mostrar Vehicles</title>
        <link rel="stylesheet" href="exemple.css" type="text/css"> 
    </head>
    <body>
        <?php include 'exPHP_cap.php';        
        echo "<h2>Tots els Vehicles</h2>";
        $sentenciaSQL = "SELECT v.codi, v.descripcio, v.color, v.consum, u.nom, u.cognoms, NVL(v.foto, gv.foto) as foto
						 from vehicles v, usuaris u, grupsVehicles gv
						 where v.propietari = u.alias and v.grupVehicle = gv.codi
						 order by v.codi";
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
            echo "  <td>" . ($fila['DESCRIPCIO'] != null ? htmlentities($fila['DESCRIPCIO'], ENT_QUOTES) : "&nbsp;") . "</td>\n";
			echo "  <td>" . ($fila['COLOR'] != null ? htmlentities($fila['COLOR'], ENT_QUOTES) : "&nbsp;") . "</td>\n";
			echo "  <td>" . ($fila['CONSUM'] != null ? htmlentities($fila['CONSUM'], ENT_QUOTES) : "&nbsp;") . "</td>\n";
			echo "  <td>" . ($fila['NOM'] != null ? htmlentities($fila['NOM'], ENT_QUOTES) : "&nbsp;") . "</td>\n";
			echo "  <td>" . ($fila['COGNOMS'] != null ? htmlentities($fila['COGNOMS'], ENT_QUOTES) : "&nbsp;") . "</td>\n";
            if ($fila['FOTO']==null){
              echo "<td><strong>Inexistent</strong></td>";
            } else {
              echo '<td align="center"><img src="data:image/png;base64,'.$fila['FOTO'].'"></td>';
            }
            echo "</tr>\n";
        }
        echo "</table>\n";
        oci_free_statement($comanda);
        include 'exPHP_peu.html';
        ?>
    </body>
</html>