<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="shortcut icon" href="../imagenes/Moto_Gp_logo.svg.png">
    <title>MotoGP - Pilotos</title>
</head>
<body>
    <header>
        <h1>MotoGP - Pilotos</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Inicio</a></li>
                <li><a href="../motos/motos.php">Motos</a></li>
                <li><a href="../equipos/equipos.php">Equipos</a></li>
            </ul>
        </nav>
    </header>

    <section>
    <div class="container">

<h1>Nuevo Piloto</h1>
<?php
require_once "../config.php";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $apiUrl = $webServer . '/piloto';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt(
        $ch,
        CURLOPT_POSTFIELDS,
        http_build_query($_POST)
    );
    // Obtiene la respuesta del servidor
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec($ch);
    curl_close($ch);
    $piloto = json_decode($server_output);
    
    // Una vez que hemos insertado el piloto incluimos otro fichero que muestra el piloto creado
    $_GET["CodPiloto"] = $piloto->CodPiloto;
    
    include("verPilotos.php");
    } else {


    $apiUrl = $webServer . '/equipo';

    $curl = curl_init($apiUrl);
    curl_setopt($curl, CURLOPT_ENCODING, "");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($curl);
    $equipos = json_decode($json);
    curl_close($curl);

    $apiUrl = $webServer . '/moto';

    $curl = curl_init($apiUrl);
    curl_setopt($curl, CURLOPT_ENCODING, "");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($curl);
    $motos = json_decode($json);
    curl_close($curl);

?>
    <form method="post">

        <label for="CodEquipo"> Equipo:</label>
        <select name="CodEquipo" id="CodEquipo">
            <?php
            foreach ($equipos as $equipo) { ?>
                <option value="<?= $equipo->CodEquipo ?>"><?= $equipo->NomEquipo ?></option>
            <?php
            }
            ?>
        </select>
        <br>
        <label for="CodMoto"> Moto:</label>
        <select name="CodMoto" id="CodMoto">
            <?php
            foreach ($motos as $moto) { ?>
                <option value="<?= $moto->CodMoto ?>"><?= $moto->Marca ?></option>
            <?php
            }
            ?>
        </select>
        <br>
        <br>
        <label for="NomPiloto">Nombre:</label>
        <input type="text" id="NomPiloto" name="NomPiloto">
        <br>
        <label for="NumPiloto">Número:</label>
        <input type="text" id="NumPiloto" min="0" name="NumPiloto">
        <br>
        <label for="Nacionalidad">Nacionalidad:</label>
        <select id="Nacionalidad" name="Nacionalidad">
        <option value="Afgano">Afgano</option>
        <option value="Albanés">Albanés</option>
        <option value="Alemán">Alemán</option>
        <option value="Andorrano">Andorrano</option>
        <option value="Angoleño">Angoleño</option>
        <option value="Anguiano">Anguiano</option>
        <option value="Antártico">Antártico</option>
        <option value="Antiguano">Antiguano</option>
        <option value="Neerlandés">Neerlandés</option>
        <option value="Saudita">Saudita</option>
        <option value="Argelino">Argelino</option>
        <option value="Argentino">Argentino</option>
        <option value="Armenio">Armenio</option>
        <option value="Arubeño">Arubeño</option>
        <option value="Australiano">Australiano</option>
        <option value="Austríaco">Austríaco</option>
        <option value="Azerbaiyano">Azerbaiyano</option>
        <option value="Bahameño">Bahameño</option>
        <option value="Bareiní">Bareiní</option>
        <option value="Bangladesí">Bangladesí</option>
        <option value="Barbadense">Barbadense</option>
        <option value="Belga">Belga</option>
        <option value="Beliceño">Beliceño</option>
        <option value="Beninés">Beninés</option>
        <option value="Bermudeño">Bermudeño</option>
        <option value="Bielorruso">Bielorruso</option>
        <option value="Birmano">Birmano</option>
        <option value="Boliviano">Boliviano</option>
        <option value="Bosnio">Bosnio</option>
        <option value="Botsuanés">Botsuanés</option>
        <option value="Brasileño">Brasileño</option>
        <option value="Bruneano">Bruneano</option>
        <option value="Búlgaro">Búlgaro</option>
        <option value="Burkinés">Burkinés</option>
        <option value="Burundés">Burundés</option>
        <option value="Butanés">Butanés</option>
        <option value="Caboverdiano">Caboverdiano</option>
        <option value="Camboyano">Camboyano</option>
        <option value="Camerunés">Camerunés</option>
        <option value="Canadiense">Canadiense</option>
        <option value="Chadiano">Chadiano</option>
        <option value="Chileno">Chileno</option>
        <option value="Chino">Chino</option>
        <option value="Chipriota">Chipriota</option>
        <option value="Vaticano">Vaticano</option>
        <option value="Colombiano">Colombiano</option>
        <option value="Comorense">Comorense</option>
        <option value="Congoleño">Congoleño</option>
        <option value="Congolesa">Congolesa</option>
        <option value="Surcoreano">Surcoreano</option>
        <option value="Norcoreano">Norcoreano</option>
        <option value="Marfileño">Marfileño</option>
        <option value="Costarricense">Costarricense</option>
        <option value="Croata">Croata</option>
        <option value="Cubano">Cubano</option>
        <option value="Danés">Danés</option>
        <option value="Yibutiano">Yibutiano</option>
        <option value="Dominiqués">Dominiqués</option>
        <option value="Ecuatoriano">Ecuatoriano</option>
        <option value="Egipcio">Egipcio</option>
        <option value="Salvadoreño">Salvadoreño</option>
        <option value="Emiratí">Emiratí</option>
        <option value="Eritreo">Eritreo</option>
        <option value="Esloveno">Esloveno</option>
        <option value="Español" selected>Español</option>
        <option value="Estadounidense">Estadounidense</option>
        <option value="Estonio">Estonio</option>
        <option value="Etíope">Etíope</option>
        <option value="Fiyiano">Fiyiano</option>
        <option value="Filipino">Filipino</option>
        <option value="Finlandés">Finlandés</option>
        <option value="Francés">Francés</option>
        <option value="Gabonés">Gabonés</option>
        <option value="Gambiano">Gambiano</option>
        <option value="Georgiano">Georgiano</option>
        <option value="Ghanés">Ghanés</option>
        <option value="Gibraltareño">Gibraltareño</option>
        <option value="Granadino">Granadino</option>
        <option value="Griego">Griego</option>
        <option value="Groenlandés">Groenlandés</option>
        <option value="Guadalupense">Guadalupense</option>
        <option value="Guameño">Guameño</option>
        <option value="Guatemalteco">Guatemalteco</option>
        <option value="Guyanés">Guyanés</option>
        <option value="Guyanés Francés">Guyanés Francés</option>
        <option value="Guineano">Guineano</option>
        <option value="Ecuatoguineano">Ecuatoguineano</option>
        <option value="Guineano-Bissauense">Guineano-Bissauense</option>
        <option value="Haitiano">Haitiano</option>
        <option value="Hondureño">Hondureño</option>
        <option value="Húngaro">Húngaro</option>
        <option value="Indio">Indio</option>
        <option value="Indonesio">Indonesio</option>
        <option value="Iraquí">Iraquí</option>
        <option value="Iraní">Iraní</option>
        <option value="Irlandés">Irlandés</option>
        <option value="Bouvetiano">Bouvetiano</option>
        <option value="Islandés">Islandés</option>
        <option value="Caimanés">Caimanés</option>
        <option value="Cookiano">Cookiano</option>
        <option value="Cocos (Keeling)">Cocos (Keeling)</option>
        <option value="Feroés">Feroés</option>
        <option value="Heardense y McDonaldense">Heardense y McDonaldense</option>
        <option value="Malvinense">Malvinense</option>
        <option value="Marianense del Norte">Marianense del Norte</option>
        <option value="Marshalense">Marshalense</option>
        <option value="Estadounidense de las Islas Menores del Pacífico">Estadounidense de las Islas Menores del Pacífico</option>
        <option value="Palaosense">Palaosense</option>
        <option value="Salomonense">Salomonense</option>
        <option value="Svalbardense y Jan Mayenero">Svalbardense y Jan Mayenero</option>
        <option value="Tokelauense">Tokelauense</option>
        <option value="Turcose">Turcose</option>
        <option value="Estadounidense de las Islas Vírgenes">Estadounidense de las Islas Vírgenes</option>
        <option value="Británico de las Islas Vírgenes">Británico de las Islas Vírgenes</option>
        <option value="Wallisino y Futunense">Wallisino y Futunense</option>
        <option value="Israelí">Israelí</option>
        <option value="Italiano">Italiano</option>
        <option value="Jamaicano">Jamaicano</option>
        <option value="Japonés">Japonés</option>
        <option value="Jordano">Jordano</option>
        <option value="Kazajo">Kazajo</option>
        <option value="Keniano">Keniano</option>
        <option value="Kirguís">Kirguís</option>
        <option value="Kiribatiano">Kiribatiano</option>
        <option value="Kuwaití">Kuwaití</option>
        <option value="Laosiano">Laosiano</option>
        <option value="Lesotense">Lesotense</option>
        <option value="Letón">Letón</option>
        <option value="Libanés">Libanés</option>
        <option value="Liberiano">Liberiano</option>
        <option value="Libio">Libio</option>
        <option value="Liechtensteiniano">Liechtensteiniano</option>
        <option value="Lituano">Lituano</option>
        <option value="Luxemburgués">Luxemburgués</option>
        <option value="Macedonio">Macedonio</option>
        <option value="Malgache">Malgache</option>
        <option value="Malayo">Malayo</option>
        <option value="Malawiano">Malawiano</option>
        <option value="Maldivo">Maldivo</option>
        <option value="Maliense">Maliense</option>
        <option value="Maltés">Maltés</option>
        <option value="Marroquí">Marroquí</option>
        <option value="Martiniqués">Martiniqués</option>
        <option value="Mauriciano">Mauriciano</option>
        <option value="Mauritano">Mauritano</option>
        <option value="Mahorais">Mahorais</option>
        <option value="Mexicano">Mexicano</option>
        <option value="Micronesio">Micronesio</option>
        <option value="Moldavo">Moldavo</option>
        <option value="Monegasco">Monegasco</option>
        <option value="Mongol">Mongol</option>
        <option value="Montserratense">Montserratense</option>
        <option value="Mozambiqueño">Mozambiqueño</option>
        <option value="Namibio">Namibio</option>
        <option value="Nauruano">Nauruano</option>
        <option value="Nepalés">Nepalés</option>
        </select>
        <label for="FechaNacimiento">Fecha de Nacimiento:</label>
        <input type="date" id="FechaNacimiento" name="FechaNacimiento">
        <br>
        <label for="NumTitulos">Número de titulos:</label>
        <input type="text" id=" NumTitulos" min="0" name="NumTitulos">
        <br>
        <input type="submit" value="Guardar">
    </form>
    <a href="pilotos.php">Página anterior</a>
<?php
}
?>
</section>

</body>
</html>
<footer>
    <p>&copy;MotoGP</p>
</footer>