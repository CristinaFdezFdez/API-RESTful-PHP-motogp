<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="shortcut icon" href="../imagenes/Moto_Gp_logo.svg.png">
    <title>MotoGP - Equipos</title>
</head>

<body>
    <header>
        <h1>MotoGP - Equipos</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Inicio</a></li>
                <li><a href="../pilotos/pilotos.php">Pilotos</a></li>
                <li><a href="../motos/motos.php">Motos</a></li>
            </ul>
        </nav>
    </header>

    <section>

        <div class="container">

</html>
<?php
require_once "../config.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $CodEquipo = $_GET['CodEquipo'];
    $apiUrl = $webServer . '/equipo/' . $CodEquipo;

    $params = array(
        "NomEquipo" => $_POST['NomEquipo'],
        "AnnoFundacion" => $_POST['AnnoFundacion'],
        "NomEquipo" => $_POST['NomEquipo'],
        "PaisEquipo" => $_POST['PaisEquipo']
    );
    $apiUrl .= "?" . http_build_query($params);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($server_output);
    $httpCode = 200; // Inicializa httpCode

    if ($httpCode !== 200) {
        // El equipo no existe, manejar el error 
        echo "<p style='color: red;'>El equipo con el código $CodEquipo no existe.</p>";
        exit();
    }
    include("verEquipos.php");
} else {
    $id = $_GET["CodEquipo"];
    $apiUrl = $webServer . '/equipo/' . $id;

    $curl = curl_init($apiUrl);
    curl_setopt($curl, CURLOPT_ENCODING, "");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($curl);
    $equipo = json_decode($json);
    curl_close($curl);
      // Verificar si equipo no existe y manejar el error
        if (empty($equipo)) {
        echo "<p style='color: red;'>El equipo con el código $id no existe.</p>";
        exit();
    }

?>
    <h1>Actualizar Equipo</h1>
    <form method="post">
        <label for="CodEquipo">Código Equipo:</label>
        <input type="text" CodEquipo="CodEquipo" name="CodEquipo" value="<?= $equipo->CodEquipo ?>" disabled>
        <br>
        <label for="NomEquipo">Nombre del Equipo:</label>
        <input type="text" id="NomEquipo" name="NomEquipo" value="<?= $equipo->NomEquipo ?>">
        <br>
        <label for="AnnoFundacion">Año de fundación:</label>
        <input type="number" id="AnnoFundacion" name="AnnoFundacion" min="1900" value="<?= $equipo->AnnoFundacion ?>">
        <br>
        <label for="PaisEquipo">Pais del equipo:</label>
        <input type="text" id="PaisEquipo" name="PaisEquipo" value="<?= $equipo->PaisEquipo ?>">
        <br>
        <br>
        <input type="submit" value="Guardar">
        <a class="boton-nuevo" href="equipos.php">Salir</a>
    </form>

    </body>
<?php
}
?>
</section>


</body>

</html>
<footer>
    <p>&copy;MotoGP</p>
</footer>