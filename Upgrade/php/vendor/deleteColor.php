<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$idColor = $_GET['id'];

try {
    $params = [':idColor' => $idColor];
    $sql = "DELETE FROM colors WHERE colors.id_color = :idColor;";
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