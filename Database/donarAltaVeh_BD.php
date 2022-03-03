#!/usr/bin/php-cgi
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
        <title>Alta vehicles</title>
        <link rel="stylesheet" href="exemple.css" type="text/css"> 
    </head>
    <body>
        <?php
        include 'exPHP_cap.php';
		$data = $_POST['data'] . " " . $_POST['hora'];
		$codiVeh_a = "SELECT descripcio from grupsVehicles where codi = '" . $_POST['grup'] . "'";
		$codiVeh_b = oci_parse($connexio, $codiVeh_a);
		oci_execute($codiVeh_b);
		$codiVeh_c = oci_fetch_array($codiVeh_b, OCI_ASSOC + OCI_RETURN_NULLS);
		$codiVeh = substr($codiVeh_c['DESCRIPCIO'], 0, 1);

		$lletra = Substr(str_replace(" ","", "" . $_POST['descripcio'] . ""), 0, 4);
		$codiVeh = $codiVeh . $lletra;
		
		$compte = 2;
		$repost = $codiVeh;
		$aux_a = "SELECT codi from vehicles where codi = '". $codiVeh ."'";
		$aux_b = oci_parse($connexio, $aux_a);
		oci_execute($aux_b);
		$aux_c = oci_fetch_array($aux_b, OCI_ASSOC + OCI_RETURN_NULLS);
		$aux = $aux_c['CODI'];
		
		while($aux == $repost){
			$repost = $codiVeh . "_" . $compte;
			$compte+1;
			$aux_a = "SELECT codi from vehicles where codi = '". $repost ."'";
			$aux_b = oci_parse($connexio, $aux_a);
			oci_execute($aux_b);
			$aux_c = oci_fetch_array($aux_b, OCI_ASSOC + OCI_RETURN_NULLS);
			$aux = $aux_c['CODI'];
		}
		$codiVeh = $repost;
		
        $sentenciaSQL = "INSERT INTO vehicles
          (codi, descripcio, color, consum, dataCompra, preu, grupVehicle, combustible, propietari, habilitat) 
          VALUES ('$codiVeh', '" . $_POST['descripcio'] . "', '" . $_POST['color'] . "', " . $_POST['consum'] . ", TO_DATE('" . $data . "'
          ,'YYYY-MM-DD HH24:MI:SS'), " . $_POST['preu'] . ", '" . $_POST['grup'] . "', '" . $_POST['comb'] . "', '" . $_POST['usuaris'] . "', 'apte')";
        $comanda = oci_parse($connexio, $sentenciaSQL);
        $exit = oci_execute($comanda);
        if ($exit) {
            echo "<p>Nou vehicle " . $codiVeh . " inserit</p>\n";
        } else {
            $error = oci_error($comanda);
            $_SESSION['ErrorSentencia'] = $error['sqltext'];
            $_SESSION['ErrorCodi'] = $error[code];
            $_SESSION['ErrorMissatge'] = $error['message'];
            $_SESSION['ErrorOffset'] = $error['offset'];
            header('Location: exPHP_errorExecucio.php');
        }
        include 'exPHP_peu.html';
        ?>
    </body>
</html>