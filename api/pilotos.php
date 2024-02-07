<?php
$url = $_SERVER['REQUEST_URI'];
if(strpos($url,"/") !== 0){
    $url = "/$url";
}

$dbInstance = new DB();
$dbConn = $dbInstance->connect($db);

header("Content-Type:application/json");
error_log("URL: " . $url);
error_log("METHOD: " . $_SERVER['REQUEST_METHOD']);

if($url == $urlPrefix . '/piloto' && $_SERVER['REQUEST_METHOD'] == 'GET') {
    error_log("Lista Pilotos");
    $piloto = getAllPilotos($dbConn);
    echo json_encode($piloto);
    return;
}



if($url == $urlPrefix . '/piloto' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    error_log("Crear Piloto");
    $input = $_POST;
    $CodPiloto = addPiloto($input, $dbConn);
    if($CodPiloto){
        $input['CodPiloto'] = $CodPiloto;
        $input['link'] = "/piloto/$CodPiloto";
    }

    echo json_encode($input);

}

if(preg_match("/piloto\/([0-9]+)/", $url, $matches) && $_SERVER['REQUEST_METHOD'] == 'PUT'){
    error_log("Actualizar Piloto");

    $input = $_GET;
    $userId = $matches[1];
    updatePiloto($input, $dbConn, $userId);

    $user = getPiloto($dbConn, $userId);
    echo json_encode($user);
}

if(preg_match("/piloto\/([0-9]+)/", $url, $matches) && $_SERVER['REQUEST_METHOD'] == 'GET'){
    error_log("obtener Piloto");

    $CodPiloto = $matches[1];
    $piloto = getPiloto($dbConn, $CodPiloto);

    echo json_encode($piloto);
}

if(preg_match("/piloto\/([0-9]+)/", $url, $matches) && $_SERVER['REQUEST_METHOD'] == 'DELETE'){

    $CodPiloto = $matches[1];
    error_log("Borrar Piloto: ". $CodPiloto);
    $deletedCount = deletePiloto($dbConn, $CodPiloto);
    $deleted = $deletedCount >0?"true":"false";

    echo json_encode([
        'id'=> $CodPiloto,
        'deleted'=> $deleted
    ]);
}

/**
 * Get record based on ID
 *
 * @param $db
 * @param $id
 *
 * @return mixed Associative Array with statement fetch
 */
function getPiloto($db, $CodPiloto) {
    $statement = $db->prepare("SELECT * FROM piloto where CodPiloto=:CodPiloto");
    $statement->bindValue(':CodPiloto', $CodPiloto);
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
function deletePiloto($db, $CodPiloto) {
    $sql = "DELETE FROM piloto where CodPiloto=:CodPiloto";
    
    $statement = $db->prepare($sql);
    $statement->bindValue(':CodPiloto', $CodPiloto);
    $statement->execute();
    return $statement->rowCount();
}

/**
 * Get all records
 *
 * @param $db
 * @return mixed fetchAll result
 */
function getAllPilotos($db) {
    $statement = $db->prepare("SELECT piloto.*, moto.Marca AS MotoMarca, equipo.NomEquipo
    FROM piloto
    LEFT JOIN moto ON piloto.CodMoto = moto.CodMoto
    LEFT JOIN equipo ON piloto.CodEquipo = equipo.CodEquipo");
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
function addPiloto($input, $db){

    $sql = "INSERT INTO piloto 
        (NomPiloto, FechaNacimiento, Nacionalidad, NumPiloto, NumTitulos, CodEquipo, CodMoto) 
        VALUES 
        (:NomPiloto, :FechaNacimiento, :Nacionalidad, :NumPiloto, :NumTitulos, :CodEquipo, :CodMoto)";

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
function bindAllValues($statement, $params){
    $allowedFields = ['NomPiloto', 'FechaNacimiento', 'Nacionalidad',  'NumPiloto', 'NumTitulos', 'CodEquipo', 'CodMoto'];

    foreach($params as $param => $value){
        if(in_array($param, $allowedFields)){
            error_log("bind $param $value");
            $statement->bindValue(':'.$param, $value);
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
function getParams($input) {
    $allowedFields = ['NomPiloto', 'FechaNacimiento', 'Nacionalidad', 'NumPiloto', 'NumTitulos', 'CodEquipo','CodMoto'];

    foreach($input as $param => $value){
        if(in_array($param, $allowedFields)){
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
function updatePiloto($input, $db, $CodPiloto){

    $fields = getParams($input);

    $sql = "
            UPDATE piloto
            SET $fields 
            WHERE CodPiloto=$CodPiloto
            ";

    $statement = $db->prepare($sql);

    bindAllValues($statement, $input);
    $statement->execute();

    return $CodPiloto;
}

/**
 * Get all posts of the user
 *
 * @param $db
 * @param $userId
 * @return mixed fetchAll result
 */
