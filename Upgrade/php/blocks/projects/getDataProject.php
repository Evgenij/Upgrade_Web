<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$idProject = $_GET['id'];

$response = [
    'status' => false,
    'name' => '',
    'descr' => '',
    'mark' => ''
];

try{
    $sql = 'SELECT name, descr, mark FROM `project` WHERE id_project = :idProject';

    $nestedSQL = $db->prepare($sql);
    $params = [':idProject' => $idProject];
    $nestedSQL->execute($params);

    if($nestedSQL->rowCount() > 0){
        $response["status"] = true;
        while ($project = $nestedSQL->fetch(PDO::FETCH_BOTH)) {
            $response["name"] = $project['name'];
            $response["descr"] = $project['descr'];
            $response["mark"] = strtoupper($project['mark']);
        }
    } else {
        $response["status"] = false;
    }

} catch(PDOException $ex) {
    $response = [
        "status" => false,
        "message" => $ex->getMessage()
    ]; 
}

echo json_encode($response);
