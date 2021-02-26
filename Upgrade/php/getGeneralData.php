<?php

require_once "../vendor/connect.php";

$responce = [];

$sql = "SELECT COUNT(*) FROM task INNER JOIN target ON target.id_target = task.id_target INNER JOIN project ON project.id_project = target.id_project INNER JOIN user ON user.id_user = project.id_user WHERE task.date = :dateTask AND user.id_user = :idUser";
$query = $db->prepare($sql);
$params = [
    ':idUser' => $_SESSION['user']['id'],
    ':dateTask' => date('Y-m-d')
];
$query->execute($params);
$responce['countTask'] = $query->fetch()[0];




$sql = "SELECT COUNT(*) FROM project INNER JOIN user ON user.id_user = project.id_user WHERE user.id_user = :idUser";
$query = $db->prepare($sql);
$params = [
    ':idUser' => $_SESSION['user']['id']
];
$query->execute($params);
$responce['countProject'] = $query->fetch()[0];

echo json_encode($responce);
