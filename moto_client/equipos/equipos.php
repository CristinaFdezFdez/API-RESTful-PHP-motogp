<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="shortcut icon" href="../imagenes/Moto_Gp_logo.svg.png">
    <title>MotoGP - Equipos</title>
</head>
<style>

    .icon-container {
        display: inline-block;
        margin-left: 10px;
    }

    .icon-container img {
        width: 50px;
        height: 35px;
    }
</style>
<body>
    <header>
        <h1>MotoGP - <span style="color: red;">Equipos</span></h1>
        <nav>
            <ul>
                <li><a href="../index.php">Inicio</a></li>
                <li><a href="../pilotos/pilotos.php">Pilotos</a></li>
                <li><a href="../motos/motos.php">Motos</a></li>
            </ul>
        </nav>
    </header>
    <section>

        <h1>Lista de Equipos &nbsp;<span class="icon-container"> <img src="../imagenes/equipos.png" alt="Icono de equipo"></span></h1>
    <table border= "1">
    <tr>
        <td>Código del Equipo</td>
        <td>Nombre del Equipo</td>
        <td>Pais del Equipo</td>
        <td>Año de Fundación</td>
        <td>Acciones</td>

    </tr>
    
    <?php
        require_once "../config.php";

        $apiUrl = $webServer . '/equipo';
    
        $curl = curl_init($apiUrl);
        curl_setopt($curl, CURLOPT_ENCODING ,"");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($curl);
        $equipos = json_decode($json);
        curl_close($curl);
    
    foreach ($equipos as $equipo) {
        echo "<tr>";
        echo "<td>";
        echo "<a href=$urlPrefix/equipos/ver.php?CodEquipo=$equipo->CodEquipo>$equipo->CodEquipo</a>";
        echo "</td>";
        echo "<td>$equipo->NomEquipo</td>";
        echo "<td>$equipo->PaisEquipo</td>";
        echo "<td>$equipo->AnnoFundacion</td>";
        echo "<td>";
        echo "<a class=boton-nuevo href='$urlPrefix/equipos/actualizar.php?CodEquipo=$equipo->CodEquipo'>Editar</a>";
        echo "  ";
        echo "  ";
        echo "<a class=boton-nuevo href='$urlPrefix/equipos/eliminar.php?CodEquipo=$equipo->CodEquipo'>Eliminar</a>";
        echo "  ";
        echo "  ";
        echo "<a  class=boton-nuevo href='$urlPrefix/equipos/verPilotos.php?CodEquipo=$equipo->CodEquipo'>Ver Pilotos</a>";
        echo "  ";
        echo "  ";
        echo "<a class=boton-nuevo href='$urlPrefix/equipos/nuevoPiloto.php?CodEquipo=$equipo->CodEquipo'>Añadir piloto</a>";
        echo "</td>";
        echo "</tr>";
    }
    ?>
        <a class="boton-nuevo" href="<?=$urlPrefix?>/equipos/nuevo.php">Nuevo equipo</a>
        </table>

    </section>


</body>
</html>
<footer>
        <p>&copy;MotoGP</p>
    </footer>
