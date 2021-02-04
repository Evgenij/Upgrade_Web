<?php

require_once "../vendor/connect.php";

$responce = [];

$sql = "SELECT COUNT(id_task) FROM task 
INNER JOIN target ON target.id_target = task.id_target 
INNER JOIN project ON project.id_project = target.id_project
INNER JOIN user ON user.id_user = project.id_user
WHERE user.id_user = :idUser AND task.date = :dateTask";
$query = $db->prepare($sql);
$params = [
    ':idUser' => $_SESSION['user']['id'],
    ':dateTask' => date('Y-m-d')
];
$query->execute($params);
$responce['countTaskToday'] = $query->fetch()[0];


$sql = "SELECT getCurrentPerformance(:idUser)";
$query = $db->prepare($sql);
$params = [
    ':idUser' => $_SESSION['user']['id']
];
$query->execute($params);
$responce['currentPerformance'] = $query->fetch()[0];



echo json_encode($responce);
