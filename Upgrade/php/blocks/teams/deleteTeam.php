<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$idTeam = $_GET['id'];

try {
    $params = [':idTeam' => $idTeam];
    $sql = "DELETE FROM team WHERE team.id_team = :idTeam;";
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