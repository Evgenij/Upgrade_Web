<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$idSubtask = $_GET['idSubtask'];

try {
    $sql = "DELETE FROM subtask WHERE id_subtask = :idSubtask";
    $tempSql = $db->prepare($sql);
    $params = [
        ':idSubtask' => $idSubtask
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