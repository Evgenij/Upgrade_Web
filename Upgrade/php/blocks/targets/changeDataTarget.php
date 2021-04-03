<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$idTarget = $_GET['idTarget'];
$idProject = $_GET['idProject'];
$name =  $_GET['name'];
$descr =  $_GET['descr'];
$mark =  $_GET['mark'];
$activities =  $_GET['activities'];

try {
    
    $params = [
        ':idTarget' => $idTarget,
        ':idProject' => $idProject,
        ':name' => $name,
        ':descr' => $descr,
        ':mark' => $mark
    ];
    $sql = "UPDATE target SET id_project = :idProject, name = :name, descr = :descr, mark = :mark WHERE target.id_target = :idTarget;";
    $nestedSQL = $db->prepare($sql)->execute($params);

    

    $response = [
        "status" => true
    ];

} catch (PDOException $ex) {
    $response = [
        "status" => false,
        "message" => $ex->getMessage()
    ];
}

echo json_encode($response);
