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

if ($url == $urlPrefix . '/equipo' && $_SERVER['REQUEST_METHOD'] == 'GET') {
    error_log("Lista de equipos");
    $equipo = obtenerTodo($dbConn);
    echo json_encode($equipo);
}


if ($url == $urlPrefix . '/equipo' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    error_log("Crear equipo");
    $input = $_POST;
    $CodEquipo = anadirEquipo($input, $dbConn);
    if ($CodEquipo) {
        $input['CodEquipo'] = $CodEquipo;
        $input['link'] = "/equipo/$CodEquipo";
    }

    echo json_encode($input);
}

if (preg_match("/equipo\/([0-9]+)/", $url, $matches) && $_SERVER['REQUEST_METHOD'] == 'PUT') {
    error_log("actualizar equipo");

    $input = $_GET;
    $CodEquipo = $matches[1];
    actualizarEquipos($input, $dbConn, $CodEquipo);

    $equipo = obtenerEquipo($dbConn, $CodEquipo);
    echo json_encode($CodEquipo);
}

if (preg_match("/equipo\/([0-9]+)\/piloto/", $url, $matches) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    error_log("Lista de pilotos de los equipos");

    $CodEquipo = $matches[1];
    $pilotos = getPilotos($dbConn,$CodEquipo);
    echo json_encode($pilotos);
    return;
}


if (preg_match("/equipo\/([0-9]+)/", $url, $matches) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    error_log("obtener equipo");

    $CodEquipo = $matches[1];
    $equipo = obtenerEquipo($dbConn, $CodEquipo);

    echo json_encode($equipo);
}

if (preg_match("/equipo\/([0-9]+)/", $url, $matches) && $_SERVER['REQUEST_METHOD'] == 'DELETE') {

    $CodEquipo = $matches[1];
    error_log("Delete post: " . $CodEquipo);
    $deletedCount = borrarEquipo($dbConn, $CodEquipo);
    $deleted = $deletedCount > 0 ? "true" : "false";

    echo json_encode([
        'CodEquipo' => $CodEquipo,
        'deleted' => $deleted
    ]);
}

/**
 * Get Record based on ID
 *
 * @param $db
 * @param $id
 *
 * @return mixed Associative Array with statement fetch
 */
function obtenerEquipo($db, $CodEquipo)
{
    $statement = $db->prepare("SELECT * FROM equipo WHERE CodEquipo=:CodEquipo");
    $statement->bindValue(':CodEquipo', $CodEquipo);
    $statement->execute();

    return $statement->fetch(PDO::FETCH_ASSOC);
}

/**
 * Delete record based on ID
 *
 * @param $db
 * @param $id
 * 
 * @return integer number of deleted records
 */
function borrarEquipo($db, $CodEquipo)
{
    $sql = "DELETE FROM equipo where CodEquipo=:CodEquipo";
    $statement = $db->prepare($sql);
    $statement->bindValue(':CodEquipo', $CodEquipo);
    $statement->execute();
    return $statement->rowCount();
}

/**
 * Get all records
 *
 * @param $db
 * @return mixed fetchAll result
 */
function obtenerTodo($db)
{
    $statement = $db->prepare("SELECT * FROM equipo");
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);

    return $statement->fetchAll();
}

/**
 * Add record
 *
 * @param $input
 * @param $db
 * @return integer id of the inserted record
 */
function anadirEquipo($input, $db)
{

    $sql = "INSERT INTO equipo 
            (NomEquipo, PaisEquipo, AnnoFundacion) 
            VALUES 
            (:NomEquipo, :PaisEquipo, :AnnoFundacion)";

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
    $allowedFields = ['CodEquipo', 'NomEquipo', 'PaisEquipo', 'AnnoFundacion'];

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
    $allowedFields = ['CodEquipo', 'NomEquipo', 'PaisEquipo', 'AnnoFundacion'];

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
function actualizarEquipos($input, $db, $CodEquipo)
{

    $fields = getParams($input);

    $sql = "
            UPDATE equipo 
            SET $fields 
            WHERE CodEquipo=$CodEquipo
            ";

    $statement = $db->prepare($sql);

    bindAllValues($statement, $input);
    $statement->execute();

    return $CodEquipo;
}

function getPilotos($db, $CodEquipo)
{
    $statement = $db->prepare( 
        "SELECT piloto.*, equipo.NomEquipo as Nombre_Equipo 
        FROM piloto LEFT JOIN equipo ON piloto.CodEquipo = equipo.CodEquipo WHERE piloto.CodEquipo = :CodEquipo;");

    $statement->bindParam(':CodEquipo', $CodEquipo, PDO::PARAM_INT);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_ASSOC);

    return $statement->fetchAll();
    ;
}
