<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$idProject = $_GET['idProject'];

try {
    $params = [':idProject' => $idProject];
    $sql = "DELETE FROM project WHERE project.id_project = :idProject;";
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