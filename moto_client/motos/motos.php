<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="shortcut icon" href="../imagenes/Moto_Gp_logo.svg.png">

    <title>MotoGP - Motos</title>
</head>
<style>
    @keyframes moveIcon {
        0% {
            transform: translateX(0);
        }

        50% {
            transform: translateX(300px);
        }

        100% {
            transform: translateX(0);
        }
    }

    .icon-container {
        display: inline-block;
        margin-left: 10px;
        animation: moveIcon 5s ease-in-out infinite;
    }

    .icon-container img {
        width: 55px;
        height: 40px;
    }
</style>

<body>
    <header>

            <h1>MotoGP - <span style="color: red;">Motos</span></h1>
            <nav>
                <ul>
                    <li><a href="../index.php">Inicio</a></li>
                    <li><a href="../pilotos/pilotos.php">Pilotos</a></li>
                    <li><a href="../equipos/equipos.php">Equipos</a></li>
                </ul>
            </nav>
    </header>
    <section>

    <h1>Lista de Motos<span class="icon-container">&nbsp; <img src="../imagenes/honda.png" alt="Icono de moto"></span></h1>
    <table border="1">
        <tr>
            <td>Código moto</td>
            <td>Modelo</td>
            <td>Cilindrada</td>
            <td>Fabricante</td>
            <td>Marca</td>
            <td>Acciones</td>
        </tr>
        <?php
        require_once "../config.php";
        $apiUrl = $webServer . '/moto';

        $curl = curl_init($apiUrl);
        curl_setopt($curl, CURLOPT_ENCODING, "");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($curl);
        $motos = json_decode($json);
        curl_close($curl);

        foreach ($motos as $moto) {
            echo "<tr>";
            echo "<td>";
            echo "<a  href=$urlPrefix/motos/ver.php?CodMoto=$moto->CodMoto>$moto->CodMoto</a>";
            echo "</td>";
            echo "<td>$moto->Modelo</td>";
            echo "<td>$moto->Cilindrada</td>";
            echo "<td>$moto->Fabricante</td>";
            echo "<td>$moto->Marca</td>";
            echo "<td>";
            echo "<a class=boton-nuevo href='$urlPrefix/motos/actualizar.php?CodMoto=$moto->CodMoto'>Editar</a>";
            echo "  ";
            echo "<a class=boton-nuevo href='$urlPrefix/motos/eliminar.php?CodMoto=$moto->CodMoto'>Eliminar</a>";
            echo "  ";
            echo "<a class=boton-nuevo href='$urlPrefix/motos/verPilotos.php?CodMoto=$moto->CodMoto'>Ver Pilotos</a>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
        <a class="boton-nuevo" href="<?=$urlPrefix?>/motos/nuevo.php"> Nueva moto</a>
    </table>

    </section>


</body>

</html>
<footer>
    <p>&copy;MotoGP</p>
</footer>