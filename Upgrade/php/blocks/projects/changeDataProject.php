<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$idProject = $_GET['idProject'];
$name =  $_GET['name'];
$descr =  $_GET['descr'];
$mark =  $_GET['mark'];

try {
    
    $params = [
        ':idProject' => $idProject,
        ':name' => $name,
        ':descr' => $descr,
        ':mark' => $mark
    ];
    $sql = "UPDATE project SET name = :name, descr = :descr, mark = :mark WHERE id_project = :idProject;";
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
