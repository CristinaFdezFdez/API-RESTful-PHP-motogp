
<?php
require_once "../config.php";


$CodMoto = $_GET["CodMoto"];
$apiUrl = $webServer . '/moto/' . $CodMoto;

$curl = curl_init($apiUrl);
curl_setopt($curl, CURLOPT_ENCODING, "");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$json = curl_exec($curl);
// Obtener el código de respuesta HTTP después de la ejecución de curl
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

curl_close($curl);
$moto = json_decode($json);

?>

<form>
    <label for="id">Código de la Moto:</label>
    <input type="text" id="id" name="id" value="<?= $moto->CodMoto ?>" disabled>
    <br>
    <label for="Marca">Marca:</label>
    <input type="text" id="Marca" name="name" value="<?= $moto->Marca ?>" disabled>
    <br>
    <label for="Modelo">Modelo:</label>
    <input type="text" id="Modelo" name="name" value="<?= $moto->Modelo ?>" disabled>
    <br>
    <label for="Cilindrada">Cilindrada:</label>
    <input type="text" id="Cilindrada" name="name" value="<?= $moto->Cilindrada ?>" disabled>
    <br>
    <label for="Fabricante">Fabricante:</label>
    <input type="text" id="Fabricante" name="name" value="<?= $moto->Fabricante ?>" disabled>
    <br>
</form>
<a href="motos.php">Página anterior</a>
