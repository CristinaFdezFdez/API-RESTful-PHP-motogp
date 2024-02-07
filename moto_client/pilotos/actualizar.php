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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $CodPiloto = $_GET['CodPiloto'];
            $apiUrl = $webServer . '/piloto/' . $CodPiloto;

            $params = array(
                "CodEquipo" => $_POST['CodEquipo'],
                "CodMoto" => $_POST['CodMoto'],
                "NomPiloto" => $_POST['NomPiloto'],
                "NumPiloto" => $_POST['NumPiloto'],
                "FechaNacimiento" => $_POST['FechaNacimiento'],
                "Nacionalidad" => $_POST['Nacionalidad'],


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
                // El piloto no existe, manejar el error (redirigir, mostrar mensaje, etc.)
                echo "<p style='color: red;'>El piloto con el código $CodPiloto no existe.</p>";
                exit();
            }
            include("verPilotos.php");
        } else {
            $id = $_GET["CodPiloto"];
            $apiUrl = $webServer . '/piloto/' . $id;
            $curl = curl_init($apiUrl);
            curl_setopt($curl, CURLOPT_ENCODING, "");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $json = curl_exec($curl);
            $piloto = json_decode($json);
            curl_close($curl);
            // Verificar si el piloto no existe y manejar el error
            if (empty($piloto)) {
                echo "<p style='color: red;'>El piloto con el código $id no existe.</p>";
                exit();
            }
            // Obtener lista de equipos
            $apiEquiposUrl = $webServer . '/equipo';
            $curlEquipos = curl_init($apiEquiposUrl);
            curl_setopt($curlEquipos, CURLOPT_ENCODING, "");
            curl_setopt($curlEquipos, CURLOPT_RETURNTRANSFER, true);
            $jsonEquipos = curl_exec($curlEquipos);
            $equipos = json_decode($jsonEquipos);
            curl_close($curlEquipos);

            // Obtener lista de motos
            $apiMotosUrl = $webServer . '/moto';
            $curlMotos = curl_init($apiMotosUrl);
            curl_setopt($curlMotos, CURLOPT_ENCODING, "");
            curl_setopt($curlMotos, CURLOPT_RETURNTRANSFER, true);
            $jsonMotos = curl_exec($curlMotos);
            $motos = json_decode($jsonMotos);
            curl_close($curlMotos);
        ?>

            <h1>Actualizar Piloto</h1>
            <form method="post">
                <label for="CodEquipo"> Equipo:</label>
                <select name="CodEquipo" id="CodEquipo">
                    <?php
                    foreach ($equipos as $equipo) { ?>
                        <option value="<?= $equipo->CodEquipo ?>" <?= ($equipo->CodEquipo == $piloto->CodEquipo) ? 'selected' : '' ?>>
                            <?= $equipo->NomEquipo ?>
                        </option>
                    <?php
                    }
                    ?>
                </select>
                <br>
                <label for="CodMoto"> Moto:</label>
                <select name="CodMoto" id="CodMoto">
                    <?php
                    foreach ($motos as $moto) { ?>
                        <option value="<?= $moto->CodMoto ?>" <?= ($moto->CodMoto == $piloto->CodMoto) ? 'selected' : '' ?>>
                            <?= $moto->Marca ?>
                        </option>
                    <?php
                    }
                    ?>
                </select>
                <br>
                <label for="CodPiloto">Código Piloto:</label>
                <input type="text" id="CodPiloto" name="CodPiloto" value="<?= $piloto->CodPiloto ?>" disabled>
                <br>
                <label for="NomPiloto">Nombre:</label>
                <input type="text" id="NomPiloto" name="NomPiloto" value="<?= $piloto->NomPiloto ?>">
                <br>
                <label for="NumPiloto">Número del piloto:</label>
                <input type="text" id="NumPiloto" name="NumPiloto" value="<?= $piloto->NumPiloto ?>">
                <br>
                <label for="FechaNacimiento">Fecha de nacimiento:</label>
                <input type="date" id="FechaNacimiento" name="FechaNacimiento" value="<?= $piloto->FechaNacimiento ?>">
                <br>
                <label for="Nacionalidad">Nacionalidad:</label>
                <input type="text" id="Nacionalidad" name="Nacionalidad" value="<?= $piloto->Nacionalidad ?>">
                <br>
                <input type="submit" value="Guardar">
                <a class="boton-nuevo" href="pilotos.php">Salir</a>

            </form>

        <?php
        }
        ?>

</section>

</html>
<footer>
    <p>&copy;MotoGP</p>
</footer>