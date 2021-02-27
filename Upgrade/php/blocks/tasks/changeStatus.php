<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';
$idTask = $_GET['idTask'];
$status = $_GET['status'];

$responce = [];

if ($status == 'false') { // если у задачи статус - не выполнено

    try {
        $sql = 'UPDATE task SET task.status = 1 WHERE task.id_task = :idTask';
        $nestedSQL = $db->prepare($sql);
        $params = [':idTask' => $idTask];
        $nestedSQL->execute($params);
    } catch (PDOException $ex) {
        $response = [
            "status" => false,
            "message" => $ex->getMessage()
        ];
        echo json_encode($response);
        die();
    }
} else { // если у задачи статус - выполнено
    try {
        $sql = 'UPDATE task SET task.status = 0 WHERE task.id_task = :idTask';
        $nestedSQL = $db->prepare($sql);
        $params = [':idTask' => $idTask];
        $nestedSQL->execute($params);
    } catch (PDOException $ex) {
        $response = [
            "status" => false,
            "message" => $ex->getMessage()
        ];
        echo json_encode($response);
        die();
    }
}
