<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$idAttach = $_GET['idAttach'];

try {
    $params = [':idAttach' => $idAttach];
    $sql = "DELETE FROM attachment WHERE attachment.id_attach = :idAttach;";
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