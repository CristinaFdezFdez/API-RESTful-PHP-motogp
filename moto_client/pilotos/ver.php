<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Piloto - MotoGP</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="shortcut icon" href="../imagenes/Moto_Gp_logo.svg.png">
</head>

<body>
    <header>
        <h1>MotoGP - Pilotos</h1>
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
            <?php
            require_once "../config.php";

            $CodPiloto = $_GET["CodPiloto"];
            $apiUrl = $webServer . '/piloto/' . $CodPiloto;
            $curl = curl_init($apiUrl);
            curl_setopt($curl, CURLOPT_ENCODING, "");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $json = curl_exec($curl);

            // Obtener el código de respuesta HTTP después de la ejecución de curl
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            curl_close($curl);

            // Verificar si el piloto no existe y manejar el error
            if ($httpCode !== 200 || $json === 'false') {
                echo "<p style='color: red;'>El piloto con el código $CodPiloto no existe.</p>";
                exit();
            }

            // El piloto existe, procesar la información
            $piloto = json_decode($json);
            ?>
                <form>
                    <label for="id">Código del piloto:</label>
                    <input type="text" id="id" name="id" value="<?= $piloto->CodPiloto ?>" disabled>
                    <br>
                    <label for="NomPiloto">Nombre:</label>
                    <input type="text" id="NomPiloto" name="name" value="<?= $piloto->NomPiloto ?>" disabled>
                    <br>
                    <label for="NumPiloto">Número del piloto:</label>
                    <input type="text" id="NumPiloto" name="NumPiloto" value="<?= $piloto->NumPiloto ?>" disabled>
                    <br>
                    <label for="Nacimiento">Fecha de nacimiento:</label>
                    <input type="text" id="Nacimiento" name="Nacimiento" value="<?= $piloto->FechaNacimiento ?>" disabled>
                    <br>
                    <label for="Nacionalidad">Nacionalidad:</label>
                    <input type="text" id="Nacionalidad" name="Nacionalidad" value="<?= $piloto->Nacionalidad ?>" disabled>
                    <br>
                    <label for="NumTitulos">Número de títulos:</label>
                    <input type="text" id="NumTitulos" name="NumTitulos" value="<?= $piloto->NumTitulos ?>" disabled>
                    <br>
                    <label for="Equipo">Equipo:</label>
                    <input type="text" id="Equipo" name="Equipo" value="<?= $piloto->CodEquipo ?>" disabled>
                    <br>
                    <label for="Moto">Moto:</label>
                    <input type="text" id="Moto" name="Moto" value="<?= $piloto->CodMoto ?>" disabled>
                </form>
                <a href="pilotos.php">Página anterior</a>
            <?php
            ?>
        </div>
    </section>
    <footer>
        <p>&copy;MotoGP</p>
    </footer>
</body>

</html>