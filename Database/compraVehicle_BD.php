#!/usr/bin/php-cgi
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional">
<html>
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
      <title>Compra d'un vehicle</title>
      <link rel="stylesheet" href="exemple.css" type="text/css"> 
    </head>
    <body>
    <?php include 'exPHP_cap.php'; ?>
	  
	<?php session_start();
	$data = $_POST['data'] . " " . $_POST['hora'];
	$alias_comp = " SELECT alias 
						from usuaris 
						where alias = '" . $_SESSION['comp'] . "'";
		$alias_c = oci_parse($connexio, $alias_comp);
		oci_execute($alias_c);
		$fila_alias_comp = oci_fetch_array($alias_c, OCI_ASSOC + OCI_RETURN_NULLS);
		
	$alias_ven = " SELECT alias 
						from usuaris 
						where alias = '" . $_SESSION['ven'] . "'";
		$alias_v = oci_parse($connexio, $alias_ven);
		oci_execute($alias_v);
		$fila_alias_ven = oci_fetch_array($alias_v, OCI_ASSOC + OCI_RETURN_NULLS);
	
	$saldo = "SELECT saldo from usuaris where alias = '" . $fila_alias_comp['ALIAS'] . "'";
	$comanda = oci_parse($connexio, $saldo);
	oci_execute($comanda);
	$fila_saldo_comp = oci_fetch_array($comanda, OCI_ASSOC + OCI_RETURN_NULLS);
	
	
	if($fila_saldo_comp['SALDO'] >=  $_POST['preu']){
		$agafar = " SELECT descripcio, color, consum, preu, grupVehicle, combustible, foto
			  from vehicles 
			  where codi = '" . $_POST['vehicle'] . "'";
		$agafar_valors = oci_parse($connexio, $agafar);
		oci_execute($agafar_valors);
		$fila = oci_fetch_array($agafar_valors, OCI_ASSOC + OCI_RETURN_NULLS);
		
		$insertar = "INSERT INTO vehicles
			  (codi, descripcio, color, consum, dataCompra, preu, grupVehicle, combustible, propietari, foto, habilitat) 
			  VALUES('" . $_POST['nouCodi'] . "', '" . $fila['DESCRIPCIO'] . "', '" . $fila['COLOR'] . "', " . $fila['CONSUM'] . ", 
					 TO_DATE('" . $data . "','YYYY-MM-DD HH24:MI:SS'),
					 " . $fila['PREU'] . ", '" . $fila['GRUPVEHICLE'] . "', '" . $fila['COMBUSTIBLE'] . "', '" . $fila_alias_comp['ALIAS'] . "',
					 '" . $fila['FOTO'] . "', 'apte')";
		$insert = oci_parse($connexio, $insertar);
		$exit = oci_execute($insert);
		if ($exit) {
			echo "<p>Vehicle: " . $_POST['vehicle'] . " comprat</p>\n";
		} else {
			$error = oci_error($insert);
			$_SESSION['ErrorSentencia'] = $error['sqltext'];
			$_SESSION['ErrorCodi'] = $error[code];
			$_SESSION['ErrorMissatge'] = $error['message'];
			$_SESSION['ErrorOffset'] = $error['offset'];
			header('Location: exPHP_errorExecucio.php');
		}
		
		
		$update = "UPDATE vehicles set habilitat = 'no apte' where codi = '" . $_POST['vehicle'] . "'";
		$comanda = oci_parse($connexio, $update);
		$exit = oci_execute($comanda);
		if (!$exit) {
			$error = oci_error($comanda);
			$_SESSION['ErrorSentencia'] = $error['sqltext'];
			$_SESSION['ErrorCodi'] = $error[code];
			$_SESSION['ErrorMissatge'] = $error['message'];
			$_SESSION['ErrorOffset'] = $error['offset'];
			header('Location: exPHP_errorExecucio.php');
		}
		
		$saldoComprador = "UPDATE usuaris set saldo = saldo - " . $_POST['preu'] . " where alias = '" . $fila_alias_comp['ALIAS'] . "'";
		$comanda = oci_parse($connexio, $saldoComprador);
		oci_execute($comanda);
		
		
		$saldo = "SELECT saldo from usuaris where alias = '" . $fila_alias_ven['ALIAS'] . "'";
		$comanda = oci_parse($connexio, $saldo);
		oci_execute($comanda);
		$fila_saldo_ven = oci_fetch_array($comanda, OCI_ASSOC + OCI_RETURN_NULLS);
		
		if(is_null($fila_saldo_ven['SALDO'])){
			$saldoVenedor = "UPDATE usuaris set saldo = 0 + " . $_POST['preu'] . " where alias = '" . $fila_alias_ven['ALIAS'] . "'";
			$comanda = oci_parse($connexio, $saldoVenedor);
			oci_execute($comanda);
			$fila_ven = oci_fetch_array($comanda, OCI_ASSOC + OCI_RETURN_NULLS);
		}	
		else{
			$saldoVenedor = "UPDATE usuaris set saldo = saldo + " . $_POST['preu'] . " where alias = '" . $fila_alias_ven['ALIAS'] . "'";
			$comanda = oci_parse($connexio, $saldoVenedor);
			oci_execute($comanda);
		}
	}
	else {
		echo "El comprador no té el saldo necessari per fer la compra.";	
	}
	?> 
<?php
include 'exPHP_peu.html';
?>
</body>
</html>