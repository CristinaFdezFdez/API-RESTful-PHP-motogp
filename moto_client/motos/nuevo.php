<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="shortcut icon" href="../imagenes/Moto_Gp_logo.svg.png">
    <title>MotoGP - Motos</title>
</head>
<body>
    <header>
        <h1>MotoGP - Motos</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Inicio</a></li>
                <li><a href="../pilotos/pilotos.php">Pilotos</a></li>
                <li><a href="../equipos/equipos.php">Equipos</a></li>
            </ul>
        </nav>
    </header>

    <section>
    <div class="container">


<h1>Nueva moto</h1>
<?php
require_once "../config.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $apiUrl = $webServer . '/moto';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt(
        $ch,
        CURLOPT_POSTFIELDS,
        http_build_query($_POST)
    );
    // Obtiene la respuesta del servidor
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec($ch);
    curl_close($ch);
    $moto = json_decode($server_output);
    // Una vez que hemos insertado la moto incluimos otro fichero que muestra la moto creada
    $_GET["CodMoto"] = $moto->CodMoto;
    include("verMotos.php");
} else {


?>
    <form method="post">

        <label for="Cilindrada">Cilindrada:</label>
        <input type="text" id="Cilindrada" name="Cilindrada">
        <br>
        <label for="Modelo">Modelo:</label>
        <input type="text" id="Modelo" name="Modelo">
        <br>
        <label for="Marca">Marca:</label>
        <input type="text" id=" Marca" name="Marca">
        <br>
        <label for="Fabricante">Fabricante:</label>
        <input type="text" id="Fabricante" name="Fabricante">
        <br>
        <input type="submit" value="Guardar">
    </form>
    <a href="motos.php">Página anterior</a>
<?php
}
?>
    </section>


</body>
</html>
<footer>
    <p>&copy;MotoGP</p>
</footer>