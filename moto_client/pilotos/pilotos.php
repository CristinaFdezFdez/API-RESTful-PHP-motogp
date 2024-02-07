<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="shortcut icon" href="../imagenes/Moto_Gp_logo.svg.png">
    <title>MotoGP - Pilotos</title>
</head>
<style>
    .icon-container {
        display: inline-block;
        margin-left: 10px;
    }

    .icon-container img {
        width: 40px;
        height: 50px;
    }

    td.num-piloto {
        padding: 10px;
        text-align: center;
        color: black;
        font-size: larger;
        border-radius: 5px;
    }

</style>

<body>
    <header>
        <h1>MotoGP - <span style="color: red;">Pilotos</span></h1>
        <nav>
            <ul>
                <li><a href="../index.php">Inicio</a></li>
                <li><a href="../motos/motos.php">Motos</a></li>
                <li><a href="../equipos/equipos.php">Equipos</a></li>
            </ul>
        </nav>
    </header>

    <section>
        <h1>Lista de Pilotos &nbsp;<span class="icon-container"> <img src="../imagenes/piloto.png" alt="Icono de piloto"></span></h1>
        <table border="1">
            <tr>
                <td>Código piloto</td>
                <td>Nombre del piloto</td>
                <td>Número del piloto</td>
                <td>Fecha de nacimiento</td>
                <td>Nacionalidad</td>
                <td>Número de títulos</td>
                <td>Equipo</td>
                <td>Moto</td>
                <td>Acciones</td>
            </tr>

            <?php
            require_once "../config.php";
            $apiUrl = $webServer . '/piloto';

            $curl = curl_init($apiUrl);
            curl_setopt($curl, CURLOPT_ENCODING, "");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $json = curl_exec($curl);
            $pilotos = json_decode($json);
            curl_close($curl);

            foreach ($pilotos as $piloto) {
                echo "<tr>";
                echo "<td><a href='$urlPrefix/pilotos/ver.php?CodPiloto=$piloto->CodPiloto'>$piloto->CodPiloto</a></td>";
                echo "<td>$piloto->NomPiloto</td>";
                echo "<td class='num-piloto'>$piloto->NumPiloto</td>";
                echo "<td>$piloto->FechaNacimiento</td>";
                echo "<td>$piloto->Nacionalidad</td>";
                echo "<td class='num-titulos'>$piloto->NumTitulos</td>";
                echo "<td>" . (isset($piloto->NomEquipo) ? $piloto->NomEquipo : 'N/A') . "</td>";
                echo "<td>" . (isset($piloto->MotoMarca) ? $piloto->MotoMarca : 'N/A') . "</td>";
                echo "<td>";
                echo "<a class='boton-nuevo' href='$urlPrefix/pilotos/actualizar.php?CodPiloto=$piloto->CodPiloto'>Editar</a>";
                echo "  ";
                echo "<a class='boton-nuevo' href='$urlPrefix/pilotos/eliminar.php?CodPiloto=$piloto->CodPiloto'>Eliminar</a>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
            <a class="boton-nuevo" href="<?= $urlPrefix ?>/pilotos/nuevo.php"> Nuevo piloto</a>

        </table>

    </section>

    <footer>
        <p>&copy;MotoGP</p>
    </footer>
</body>

</html>