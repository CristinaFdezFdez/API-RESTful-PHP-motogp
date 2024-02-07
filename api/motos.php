<?php
$url = $_SERVER['REQUEST_URI'];
if (strpos($url, "/") !== 0) {
    $url = "/$url";
}

$dbInstance = new DB();
$dbConn = $dbInstance->connect($db);

header("Content-Type:application/json");
error_log("URL: " . $url);
error_log("METHOD: " . $_SERVER['REQUEST_METHOD']);



if ($url == $urlPrefix . '/moto' && $_SERVER['REQUEST_METHOD'] == 'GET') {
    error_log("Lista de motos");
    $moto = obtenerTodo($dbConn);
    echo json_encode($moto);
}

if (preg_match("/moto\/([0-9]+)\/piloto/", $url, $matches) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    error_log("Lista de pilotos que llevan una moto");

    $CodMoto = $matches[1];
    $pilotos = getPilotos($dbConn,$CodMoto);
    echo json_encode($pilotos);
    return;
}

if ($url == $urlPrefix . '/moto' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    error_log("Crear moto");

    $input = $_POST;
    $CodMoto = addMoto($input, $dbConn);
    if ($CodMoto) {
        $input['CodMoto'] = $CodMoto;
    }

    echo json_encode($input);
    return;
}


if (preg_match("/moto\/([0-9]+)/", $url, $matches) && $_SERVER['REQUEST_METHOD'] == 'PUT') {
    error_log("Actualizar moto");

    $input = $_GET;
    $CodMoto = $matches[1];
    updateMoto($input, $dbConn, $CodMoto);

    $moto = getMoto($dbConn, $CodMoto);
    echo json_encode($moto);
    return;
}

if (preg_match("/moto\/([0-9]+)/", $url, $matches) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    error_log("Get moto");

    $CodMoto = $matches[1];
    $moto = getMoto($dbConn, $CodMoto);

    echo json_encode($moto);
    return;
}

if (preg_match("/moto\/([0-9]+)/", $url, $matches) && $_SERVER['REQUEST_METHOD'] == 'DELETE') {

    $CodMoto = $matches[1];
    error_log("Delete moto: " . $CodMoto);
    $deletedCount = deleteMoto($dbConn, $CodMoto);
    $deleted = $deletedCount > 0 ? "true" : "false";

    echo json_encode([
        'CodMoto' => $CodMoto,
        'deleted' => $deleted
    ]);
    return;
}

/**
 * Get record based on ID
 *
 * @param $db
 * @param $id
 *
 * @return mixed Associative Array with statement fetch
 */
function getMoto($db, $CodMoto)
{
    $statement = $db->prepare(
        "SELECT * FROM moto
        WHERE CodMoto=:CodMoto"
    );
    $statement->bindValue(':CodMoto', $CodMoto);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}
/**
 * Get all records
 *
 * @param $db
 * @return mixed fetchAll result
 */
function obtenerTodo($db)
{
    $statement = $db->prepare("SELECT * FROM moto");
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);

    return $statement->fetchAll();
}

/**
 * Delete record based on ID
 *
 * @param $db
 * @param $id
 * 
 * @return integer number of deleted records
 */
function deleteMoto($db, $CodMoto)
{
    $sql = "DELETE FROM moto where CodMoto=:CodMoto";
    $statement = $db->prepare($sql);
    $statement->bindValue(':CodMoto', $CodMoto);
    $statement->execute();
    return $statement->rowCount();
}

/**
 * Add record
 *
 * @param $input
 * @param $db
 * @return integer id of the inserted record
 */
function addMoto($input, $db)
{

    $sql = "INSERT INTO moto 
    ( Modelo, Fabricante, Cilindrada, Marca) 
    VALUES 
    ( :Modelo, :Fabricante, :Cilindrada, :Marca)";


    $statement = $db->prepare($sql);

    bindAllValues($statement, $input);

    $statement->execute();

    return $db->lastInsertId();
}

/**
 * @param $statement
 * @param $params
 * @return PDOStatement
 */
function bindAllValues($statement, $params)
{
    $allowedFields = ['Modelo', 'Fabricante', 'Cilindrada', 'Marca'];

    foreach ($params as $param => $value) {
        if (in_array($param, $allowedFields)) {
            error_log("bind $param $value");
            $statement->bindValue(':' . $param, $value);
        }
    }
    return $statement;
}

/**
 * Get fields as parameters to set in record
 *
 * @param $input
 * @return string
 */
function getParams($input)
{
    $allowedFields = ['Modelo', 'Fabricante', 'Cilindrada', 'Marca'];

    foreach ($input as $param => $value) {
        if (in_array($param, $allowedFields)) {
            $filterParams[] = "$param=:$param";
        }
    }

    return implode(", ", $filterParams);
}


/**
 * Update Record
 *
 * @param $input
 * @param $db
 * @param $id
 * @return integer number of updated records
 */
function updateMoto($input, $db, $CodMoto)
{

    $fields = getParams($input);

    $sql = "
        UPDATE moto 
        SET $fields 
        WHERE CodMoto=$CodMoto
        ";

    $statement = $db->prepare($sql);

    bindAllValues($statement, $input);
    $statement->execute();

    return $CodMoto;
}
function getPilotos($db, $CodMoto)
{
    $statement = $db->prepare( 
        "SELECT piloto.*, moto.Marca as Nombre_Marca 
        FROM piloto LEFT JOIN moto ON piloto.CodMoto = moto.CodMoto WHERE piloto.CodMoto = :CodMoto;");

    $statement->bindParam(':CodMoto', $CodMoto, PDO::PARAM_INT);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);

    return $statement->fetchAll();
    ;
}
