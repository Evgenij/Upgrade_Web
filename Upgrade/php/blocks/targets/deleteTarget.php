<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$idTarget = $_GET['idTarget'];

try {
    $params = [':idTarget' => $idTarget];
    $sql = "DELETE FROM target WHERE target.id_target = :idTarget;";
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