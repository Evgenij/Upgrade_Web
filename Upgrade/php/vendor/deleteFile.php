<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$idFile = $_GET['idFile'];
$response = [
    'status' => false,
    'message' => ''
];

try {
    $sql = "DELETE FROM file WHERE id_file = :idFile";
    $nestedSQL = $db->prepare($sql);
    $params = [
        ':idFile' => $idFile,
    ];
    $nestedSQL->execute($params);

    $response = [
        'status' => true
    ];

} catch (PDOException $ex) {
    $response = [
        'status' => false,
        'message' => $ex->getMessage()
    ];
}

echo json_encode($response);