<?php
require_once "../config.php";

$CodPiloto = $_GET["CodPiloto"];
$apiUrl = $webServer . '/piloto/' . $CodPiloto;

$curl = curl_init($apiUrl);
curl_setopt($curl, CURLOPT_ENCODING, "");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$json = curl_exec($curl);
$piloto = json_decode($json);
curl_close($curl);


// Obtener el nombre del equipo
$apiEquipoUrl = $webServer . '/equipo/' . $piloto->CodEquipo;
$curlEquipo = curl_init($apiEquipoUrl);
curl_setopt($curlEquipo, CURLOPT_ENCODING, "");
curl_setopt($curlEquipo, CURLOPT_RETURNTRANSFER, true);
$jsonEquipo = curl_exec($curlEquipo);
// Obtener el código de respuesta HTTP después de la ejecución de curl
$httpCode = curl_getinfo($curlEquipo, CURLINFO_HTTP_CODE);

curl_close($curlEquipo);


// Verificar si el equipo no existe y manejar el error
if ($httpCode !== 200 || $json === 'false') {
    echo "<p style='color: red;'>El equipo con el código $CodEquipo no existe.</p>";
    exit();
}
$equipo = json_decode($jsonEquipo);


// Obtener el nombre de la moto
$apiMotoUrl = $webServer . '/moto/' . $piloto->CodMoto;
$curlMoto = curl_init($apiMotoUrl);
curl_setopt($curlMoto, CURLOPT_ENCODING, "");
curl_setopt($curlMoto, CURLOPT_RETURNTRANSFER, true);
$jsonMoto = curl_exec($curlMoto);
$moto = json_decode($jsonMoto);
curl_close($curlMoto);
?>

<form>
    <label for="id">Código del piloto:</label>
    <input type="text" id="id" name="id" value="<?= $piloto->CodPiloto ?>" disabled>
    <br>
    <label for="NomPiloto">Nombre:</label>
    <input type="text" id="NomPiloto" name="name" value="<?= $piloto->NomPiloto ?>" disabled>
    <br>
    <label for="NumPiloto">Número del piloto:</label>
    <input type="text" id="NumPiloto" name="name" value="<?= $piloto->NumPiloto ?>" disabled>
    <br>
    <label for="Nacimiento">Fecha de nacimiento:</label>
    <input type="text" id="Nacimiento" name="name" value="<?= $piloto->FechaNacimiento ?>" disabled>
    <br>
    <label for="Nacionalidad">Nacionalidad:</label>
    <input type="text" id="Nacionalidad" name="name" value="<?= $piloto->Nacionalidad ?>" disabled>

    <label for="NumTitulos">Número de titulos:</label>
    <input type="text" id="NumTitulos" name="name" value="<?= $piloto->NumTitulos ?>" disabled>
    <br>
    <label for="Equipo">Equipo:</label>
    <input type="text" id="Equipo" name="name" value="<?= $equipo->NomEquipo ?>" disabled>
    <br>
    <label for="Moto">Moto:</label>
    <input type="text" id="Moto" name="name" value="<?= $moto->Marca ?>" disabled>
</form>
<a href="pilotos.php">Página anterior</a>
</section>