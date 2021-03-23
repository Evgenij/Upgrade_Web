<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$idTask = $_GET['idTask'];
$idProject = $_GET['idProject'];
$idTarget = $_GET['idTarget'];
$duration = $_GET['duration'];
$executor = $_GET['executor'];
$text = $_GET['text'];
$description = $_GET['description'];

if($executor == 0){
    $executor = $_SESSION['user']['id'];
}

try {
    $params = [':idTask' => $idTask,
                ':taskText' => $text,
                ':taskDescr' => $description,
                ':taskDur' => $duration,
                ':taskExecutor' => $executor,
                ':idTarget' => $idTarget,
                ':idProject' => $idProject];
    $sql = "UPDATE task SET task.text = :taskText, task.descr = :taskDescr, task.duration = :taskDur, task.executor = :taskExecutor, task.id_target = :idTarget WHERE task.id_task = :idTask;
            UPDATE target SET target.id_project = :idProject WHERE target.id_target = :idTarget;";
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
