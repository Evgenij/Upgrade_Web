<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$text = $_POST['text'];
$date = $_POST['date'][2] . '-' . $_POST['date'][1] . '-' . $_POST['date'][0];
$idTarget = $_POST['target'];
$duration = $_POST['duration'];
$executor = $_POST['executor'];

if ($executor == 0) {
    $executor = $_SESSION['user']['id'];
}



try {
    $sql = "INSERT INTO `task` (`id_task`, `id_target`, `executor`, `text`, `descr`, `date`, `duration`, `status`) 
    VALUES (NULL, :idTarget, :executor, :text, '', :date , :duration, '0');";
    $tempSql = $db->prepare($sql);
    $params = [
        ':idTarget' => $idTarget,
        ':executor' => $executor,
        ':text' => $text,
        ':date' => $date,
        ':duration' => $duration,
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
