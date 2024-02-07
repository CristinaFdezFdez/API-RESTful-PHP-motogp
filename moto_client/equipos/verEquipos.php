<?php
require_once "../config.php";

$CodEquipo = $_GET["CodEquipo"];
$apiUrl = $webServer . '/equipo/' . $CodEquipo;

$curl = curl_init($apiUrl);
curl_setopt($curl, CURLOPT_ENCODING, "");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$json = curl_exec($curl);
// Obtener el código de respuesta HTTP después de la ejecución de curl
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);
// Verificar si el equipo no existe y manejar el error
if ($httpCode !== 200 || $json === 'false') {
    echo "<p style='color: red;'>El equipo con el código $CodEquipo no existe.</p>";
    exit();
}
$equipo = json_decode($json);

?>
<section>
    <div class="container">
        <form>
            <label for="CodEquipo">Código del equipo:</label>
            <input type="text" id="CodEquipo" name="CodEquipo" value="<?= $equipo->CodEquipo ?>" disabled>
            <br>
            <label for="AnnoFundacion">Año fundación:</label>
            <input type="number" id="AnnoFundacion" name="name" value="<?= $equipo->AnnoFundacion ?>" disabled>
            <br>
            <label for="NomEquipo">Nombre Equipo:</label>
            <input type="text" id="NomEquipo" name="name" value="<?= $equipo->NomEquipo ?>" disabled>
            <br>
            <label for="PaisEquipo">Pais del Equipo:</label>
            <input type="text" id="PaisEquipo" name="name" value="<?= $equipo->PaisEquipo ?>" disabled>
            <br>
        </form>


        <a href="equipos.php">Página anterior</a>
    </div>

</section>
</body>

</html>