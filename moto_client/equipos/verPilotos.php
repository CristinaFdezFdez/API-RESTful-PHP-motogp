<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MotoGP - Equipos</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="shortcut icon" href="../imagenes/Moto_Gp_logo.svg.png">
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
            <?php
            require_once "../config.php";

            if (isset($_GET["CodEquipo"])) {
                $id = $_GET["CodEquipo"];
                $apiUrl = $webServer . "/equipo/$id";  // Endpoint para traer los equipos
                $pilotosApiUrl = $webServer . "/equipo/$id/piloto";  // Endpoint para traer los pilotos de un equipo

                $curl = curl_init($apiUrl);
                curl_setopt($curl, CURLOPT_ENCODING, "");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $json = curl_exec($curl);
                // Obtener el código de respuesta HTTP después de la ejecución de curl
                $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
                $equipo = json_decode($json);
                curl_close($curl);

                // Verificar si la moto no existe y manejar el error
                if ($httpCode !== 200 || $json === 'false') {
                    echo "<p style='color: red;'>El equipo con el código $id no existe.</p>";
                    exit();
                }
                $equipo = json_decode($json);

                $curl = curl_init($pilotosApiUrl);
                curl_setopt($curl, CURLOPT_ENCODING, "");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $json = curl_exec($curl);
                $pilotos = json_decode($json);
                curl_close($curl);
            }
            ?>

            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Pilotos de un equipo</title>
            </head>

            <div class="container">
                <body>
                    
                <h1>Pilotos del equipo <?= $equipo->NomEquipo ?></h1>

                <?php
                if (empty($pilotos)) {
                    echo "<p>Este equipo aún no tiene pilotos.</p>";
                } else {
                ?>
                    <table border="1">
                        <tr>
                            <td>Código Piloto</td>
                            <td>Nombre</td>
                            <td>Dorsal</td>
                            <td>Nacionalidad</td>
                        </tr>
                        <section>
                            <?php
                            foreach ($pilotos as $piloto) {
                                echo "<tr>";
                                echo "<td>" . $piloto->CodPiloto . "</td>";
                                echo "<td>" . $piloto->NomPiloto . "</td>";
                                echo "<td class='num-piloto'>" . $piloto->NumPiloto . "</td>";
                                echo "<td>" . $piloto->Nacionalidad . "</td>";
                                echo "</tr>";
                            }
                            ?>
                    </table>
                <?php
                }
                ?>
                <a href="equipos.php">Página anterior</a>
            </div>
</body>


</body>

</html>