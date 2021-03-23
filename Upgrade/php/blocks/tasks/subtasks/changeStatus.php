<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$idSubtask = $_GET['idSubtask'];
$status = $_GET['status'];

try {
    $sql = "UPDATE `subtask` SET `status` = :status WHERE `subtask`.`id_subtask` = :idSubtask;";
    $tempSql = $db->prepare($sql);
    $params = [
        ':idSubtask' => $idSubtask,
        ':status' => $status
    ];
    $tempSql->execute($params);

    $responce = [
        'status' => true
    ];
} catch (PDOException $ex) {
    $responce = [
        'status' => false,
        'message' => $ex->getMessage()
    ];
}

echo json_encode($responce);