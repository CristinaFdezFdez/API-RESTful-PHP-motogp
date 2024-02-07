<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="shortcut icon" href="../imagenes/Moto_Gp_logo.svg.png">
</head>
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

<body>
    <section>
        <div class="container">
            <?php
            require_once "../config.php";

            $CodEquipo = $_GET["CodEquipo"];
            $apiUrl = $webServer . '/equipo/' . $CodEquipo;

            $curl = curl_init($apiUrl);
            curl_setopt($curl, CURLOPT_ENCODING, "");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $json = curl_exec($curl);
            // Obtener el código de respuesta HTTP después de la ejecución de curl
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            curl_close($curl);
            // Verificar si el equipo no existe y manejar el error
            if ($httpCode !== 200 || $json === 'false') {
                echo "<p style='color: red;'>El equipo con el código $CodEquipo no existe.</p>";
                exit();
            }
            $equipo = json_decode($json);
            ?>
            <form>
                <label for="CodEquipo">Código del equipo:</label>
                <input type="text" id="CodEquipo" name="CodEquipo" value="<?= $equipo->CodEquipo ?>" disabled>
                <br>
                <label for="AnnoFundacion">Año fundación:</label>
                <input type="number" id="AnnoFundacion" name="name" value="<?= $equipo->AnnoFundacion ?>" disabled>
                <br>
                <label for="NomEquipo">Nombre Equipo:</label>
                <input type="text" id="NomEquipo" name="name" value="<?= $equipo->NomEquipo ?>" disabled>
                <br>
                <label for="PaisEquipo">Pais del Equipo:</label>
                <input type="text" id="PaisEquipo" name="name" value="<?= $equipo->PaisEquipo ?>" disabled>

            </form>


            <a href="equipos.php">Página anterior</a>
    </section>
    </div>

</body>

</html>
<footer>
    <p>&copy;MotoGP</p>
</footer>