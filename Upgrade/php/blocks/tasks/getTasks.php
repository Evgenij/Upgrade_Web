
<!-- SELECT task.id_task, task.status, task.date, task.duration, task.text, task.descr,
project.name, project.mark, project.id_project,
target.name, target.mark, target.id_target
FROM task 
INNER JOIN target ON target.id_target = task.id_target
INNER JOIN project ON project.id_project = target.id_project
INNER JOIN user ON user.id_user = project.id_user
WHERE user.id_user = 29 
AND task.date = '2021-03-06' 
AND task.status = 0 
AND project.id_project = 8 
AND target.id_target = 24 -->

<?php

//require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$period = $_POST['period'];
$project = $_POST['idProject'];
$target = $_POST['idTarget'];
$status = $_POST['status'];
$executor = $_POST['executor'];

$sql = 'SELECT task.id_task, task.status, task.date, task.duration, task.text, task.descr,
project.name, project.mark, project.id_project,
target.name, target.mark, target.id_target
FROM task 
INNER JOIN target ON target.id_target = task.id_target
INNER JOIN project ON project.id_project = target.id_project
INNER JOIN user ON user.id_user = project.id_user
WHERE ';

if($period == -2){ // прошлая неделя

} else if($period == -1) { // вчера

} else if($period == 0) { // сегодня
    $sql .= 'task.date = \'' . date('Y-m-d') . '\' ';
} else if($period == 1) { // завтра

} else if($period == 2) { // след. неделя

}

// --------------------------

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

//getCountSubtask(task.id_task), getDoneSubtask(task.id_task),

// --------------------------

if($project != 0){ // если был выбран проект
    $sql .= 'AND project.id_project = :idProject 
    AND target.id_target = :idTarget ';

    // $nestedSQL = $db->prepare($sql);
    // $params = [':idUser' => $_SESSION['user']['id']];
    // $nestedSQL->execute($params);
}
else {
    $sql .= 'AND user.id_user = :idUser ';

    // $nestedSQL = $db->prepare($sql);
    // $params = [':idUser' => $_SESSION['user']['id']];
    // $nestedSQL->execute($params);
}


$response['sql'] = $sql;

echo json_encode($response);

// $nestedSQL = $db->prepare($sql);
// $params = [':idUser' => $idTask];
// $nestedSQL->execute($params);