<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$idTask = $_GET['idTask'];
$text = $_GET['text'];

try {
    $sql = "INSERT INTO `subtask` (`id_subtask`, `id_task`, `text`, `status`) 
                VALUES (NULL, :idTask, :text, '0');";
    $tempSql = $db->prepare($sql);
    $params = [
        ':idTask' => $idTask,
        ':text' => $text,
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