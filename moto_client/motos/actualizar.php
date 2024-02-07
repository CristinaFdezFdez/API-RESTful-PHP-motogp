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
            <?php
            require_once "../config.php";
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $CodMoto = $_GET['CodMoto'];
                $apiUrl = $webServer . '/moto/' . $CodMoto;

                $params = array(
                    "Marca" => $_POST['Marca'],
                    "Modelo" => $_POST['Modelo'],
                    "Fabricante" => $_POST['Fabricante'],
                    "Cilindrada" => $_POST['Cilindrada'],

                );
                $apiUrl .= "?" . http_build_query($params);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $apiUrl);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");

                // Receive server response ...
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $server_output = curl_exec($ch);
                curl_close($ch);
                $result = json_decode($server_output);
                $httpCode = 200; // Inicializa httpCode

                if ($httpCode !== 200) {
                    // La moto no existe, manejar el error (redirigir, mostrar mensaje, etc.)
                    echo "<p style='color: red;'>La moto con el código $id no existe.</p>";
                    exit();
                }
                include("verMotos.php");
            } else {
                $id = $_GET["CodMoto"];
                $apiUrl = $webServer . '/moto/' . $id;

                $curl = curl_init($apiUrl);
                curl_setopt($curl, CURLOPT_ENCODING, "");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $json = curl_exec($curl);
                $moto = json_decode($json);
                curl_close($curl);
                // Verificar si la moto no existe y manejar el error
                if (empty($moto)) {
                    echo "<p style='color: red;'>La moto con el código $id no existe.</p>.";
                    exit();
                }
            ?>
                <h1>Actualizar Moto</h1>
                <form method="post">
                    <label for="CodMoto">Código Moto:</label>
                    <input type="text" id="CodMoto" name="CodMoto" value="<?= $moto->CodMoto ?>" disabled>
                    <br>
                    <label for="Marca">Marca:</label>
                    <input type="text" id="Marca" name="Marca" value="<?= $moto->Marca ?>">
                    <br>
                    <label for="Modelo">Modelo:</label>
                    <input type="text" id="Modelo" name="Modelo" value="<?= $moto->Modelo ?>">
                    <br>
                    <label for="Cilindrada">Cilindrada:</label>
                    <input type="text" id="Cilindrada" name="Cilindrada" value="<?= $moto->Cilindrada ?>">
                    <br>
                    <label for="Fabricante">Fabricante:</label>
                    <input type="text" id="Fabricante" name="Fabricante" value="<?= $moto->Fabricante ?>">
                    <br>

                    <input type="submit" value="Guardar">
                    <a class="boton-nuevo" href="motos.php">Salir</a>

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