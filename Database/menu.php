#!/usr/bin/php-cgi
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
        <title>Menu Inicial</title>
        <link rel="stylesheet" href="exemple.css" type="text/css"> 
    </head>
    <body>
        <?php
        $emmagatzemarSessions = exec("pwd") . "/tmp";
        ini_set('session.save_path', $emmagatzemarSessions);
        session_start();
        if (!empty($_POST['fuser'])) {
            $_SESSION['usuari'] = $_POST['fuser'];
            $_SESSION['password'] = $_POST['fpwd'];
            $conn = oci_connect($_SESSION['usuari'], $_SESSION['password'], 'oracleps');
            if (!$conn) {
                $error = oci_error($connexio);
                header('Location: exPHP_errorLogin.php');
            }
        }
        ?>
        <h1>Opcions disponibles</h1>
		<p> <a class="menu" href="donarAltaVeh.php">Donar alta a un vehicle</a></p>
		<p> <a class="menu" href="mostraVehicles.php">Mostra vehicles</a></p>
		<p> <a class="menu" href="compraVehicle.php">Compra de vehicle</a></p>
		<p> <a class="menu" href="altaCursa.php">Donar d'alta una cursa</a></p>
		<p> <a class="menu" href="inscripcioUserCursa.php">Inscriure usuaris en una cursa</a></p>
		<p> <a class="menu" href="consultaParticipants.php">Consultar participants d'una cursa</a></p>
		<p> <a class="menu" href="entrarTemps.php">Entrar temps participants</a></p>
		<p> <a class="menu" href="llistaFactura.php">Consultar les factures</a></p>
        <p class="peu"><a class="peu" href="practica_PHP.html"> Torna a la pàgina de login</p>
    </body>
</html>
