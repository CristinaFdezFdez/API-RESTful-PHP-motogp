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

            if (isset($_GET["CodMoto"])) {
                $id = $_GET["CodMoto"];
                $apiUrl = $webServer . '/moto/' . $id;

                // Verificar si el usuario ha confirmado eliminar
                if (isset($_GET["confirmar"]) && $_GET["confirmar"] == "true") {
                    // El usuario ha confirmado, proceder a eliminar
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $apiUrl);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    $respuesta_servidor = curl_exec($ch);

                    curl_close($ch);

                    $resultado = json_decode($respuesta_servidor);

                    // Verifica si se eliminó correctamente
                    if (isset($resultado->deleted) && $resultado->deleted == "true") {
                        echo "La moto $id ha sido eliminada";
            ?>
                        <br>
                        <a href="motos.php">Volver</a>
                    <?php
                    } else {
                        echo "ERROR: No se puede borrar la moto $id porque no existe";
                    ?>
                        <br>
                        <a href="motos.php">Volver</a>
            <?php
                    }
                } else {
                    // Mostrar mensaje de confirmación
                    echo "¿Estás seguro de que deseas eliminar la moto $id?";
                    echo "<br>";
                    echo "<a href='eliminar.php?CodMoto=$id&confirmar=true'>Sí, estoy seguro</a>";
                    echo "<br>";
                    echo "<a href='motos.php'>No, volver a la página anterior</a>";
                }
            } else {
                echo "ERROR: Falta el parámetro CodMoto";
            }
            ?>
    </section>
</body>
</div>

</html>