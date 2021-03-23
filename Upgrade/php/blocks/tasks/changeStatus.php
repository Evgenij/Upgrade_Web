<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';
$idTask = $_GET['idTask'];
$status = $_GET['status'];

$responce = [];

try {
    $sql = 'UPDATE task SET task.status = :status WHERE task.id_task = :idTask';
    $nestedSQL = $db->prepare($sql);
    $params = [':idTask' => $idTask,
                ':status' => $status];
    $nestedSQL->execute($params);

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