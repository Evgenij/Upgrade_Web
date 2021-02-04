<?php

require_once "../vendor/connect.php";


$period = $_POST['period'];

$perfLastPeriod = 0;
$perfCurrPeriod = 0;

$doneTasksLastPeriod = [];
$failTasksLastPeriod = [];

$doneTasksCurrPeriod = [];
$failTasksCurrPeriod = [];

$labels = [];
$responce = [];

if ($period == 'week') {

    $currMonday = date('d', strtotime("last Monday"));
    $lastMonday = date('d', strtotime("Monday last week"));
    $currWeek = [];
    $lastWeek = [];

    for ($i = 0; $i < 7; $i++) {
        $currWeek[] = $currMonday + $i;
        $lastWeek[] = $lastMonday + $i;
    }

    $responce['currWeek'] = $currWeek;
    $responce['lastWeek'] = $lastWeek;

    for ($i = 0; $i < 7; $i++) {

        // если прошлый понедельник в прошлом месяце
        if ($lastMonday > $currMonday){

            $sql = "SELECT task.id_task FROM task 
                INNER JOIN target ON target.id_target = task.id_target 
                INNER JOIN project ON project.id_project = target.id_project
                INNER JOIN user ON user.id_user = project.id_user
                WHERE user.id_user = :idUser AND task.date = :taskDate AND task.status = 1";
            $query = $db->prepare($sql);
            $params = [
                ':taskDate' => date('Y-m-'.$lastWeek[$i], strtotime("-1 month")),
                ':idUser' => $_SESSION['user']['id']
            ];
            $query->execute($params);
            $doneTasksLastPeriod[] = $query->rowCount();

            $sql = "SELECT task.id_task FROM task 
                INNER JOIN target ON target.id_target = task.id_target 
                INNER JOIN project ON project.id_project = target.id_project
                INNER JOIN user ON user.id_user = project.id_user
                WHERE user.id_user = :idUser AND task.date = :taskDate AND task.status = 0";
            $query = $db->prepare($sql);
            $params = [
                ':taskDate' => date('Y-m-' . $lastWeek[$i], strtotime("-1 month")),
                ':idUser' => $_SESSION['user']['id']
            ];
            $query->execute($params);
            $failTasksLastPeriod[] = $query->rowCount();
        }
        else{

            $sql = "SELECT task.id_task FROM task 
                INNER JOIN target ON target.id_target = task.id_target 
                INNER JOIN project ON project.id_project = target.id_project
                INNER JOIN user ON user.id_user = project.id_user
                WHERE user.id_user = :idUser AND task.date = :taskDate AND task.status = 1";
            $query = $db->prepare($sql);
            $params = [
                ':taskDate' => date('Y-m-' . $lastWeek[$i]),
                ':idUser' => $_SESSION['user']['id']
            ];
            $query->execute($params);
            $doneTasksLastPeriod[] = $query->rowCount();

            $sql = "SELECT task.id_task FROM task 
                INNER JOIN target ON target.id_target = task.id_target 
                INNER JOIN project ON project.id_project = target.id_project
                INNER JOIN user ON user.id_user = project.id_user
                WHERE user.id_user = :idUser AND task.date = :taskDate AND task.status = 0";
            $query = $db->prepare($sql);
            $params = [
                ':taskDate' => date('Y-m-' . $lastWeek[$i]),
                ':idUser' => $_SESSION['user']['id']
            ];
            $query->execute($params);
            $failTasksLastPeriod[] = $query->rowCount();
        }

        $sql = "SELECT task.id_task FROM task 
                INNER JOIN target ON target.id_target = task.id_target 
                INNER JOIN project ON project.id_project = target.id_project
                INNER JOIN user ON user.id_user = project.id_user
                WHERE user.id_user = :idUser AND task.date = :taskDate AND task.status = 1";
        $query = $db->prepare($sql);
        $params = [
            ':taskDate' => date('Y-m-' . $currWeek[$i]),
            ':idUser' => $_SESSION['user']['id']
        ];
        $query->execute($params);
        $doneTasksCurrPeriod[] = $query->rowCount();

        $sql = "SELECT task.id_task FROM task 
                INNER JOIN target ON target.id_target = task.id_target 
                INNER JOIN project ON project.id_project = target.id_project
                INNER JOIN user ON user.id_user = project.id_user
                WHERE user.id_user = :idUser AND task.date = :taskDate AND task.status = 0";
        $query = $db->prepare($sql);
        $params = [
            ':taskDate' => date('Y-m-' . $currWeek[$i]),
            ':idUser' => $_SESSION['user']['id']
        ];
        $query->execute($params);
        $failTasksCurrPeriod[] = $query->rowCount();
    }

    $labels = ["ПН", "ВТ", "СР", "ЧТ", "ПТ", "СБ", "ВС"];
    $responce["type"] = 1;
} else {

    for ($i = 1; $i <= date("t", strtotime("-1 month")); $i++) {

        $sql = "SELECT task.id_task FROM task 
                INNER JOIN target ON target.id_target = task.id_target 
                INNER JOIN project ON project.id_project = target.id_project
                INNER JOIN user ON user.id_user = project.id_user
                WHERE user.id_user = :idUser AND task.date = :taskDate AND task.status = 1";
        $query = $db->prepare($sql);
        $params = [
            ':taskDate' => date('Y-m-' . $i, strtotime("-1 month")),
            ':idUser' => $_SESSION['user']['id']
        ];
        $query->execute($params);
        $doneTasksLastPeriod[] = $query->rowCount();

        $sql = "SELECT task.id_task FROM task 
                INNER JOIN target ON target.id_target = task.id_target 
                INNER JOIN project ON project.id_project = target.id_project
                INNER JOIN user ON user.id_user = project.id_user
                WHERE user.id_user = :idUser AND task.date = :taskDate AND task.status = 0";
        $query = $db->prepare($sql);
        $params = [
            ':taskDate' => date('Y-m-' . $i, strtotime("-1 month")),
            ':idUser' => $_SESSION['user']['id']
        ];
        $query->execute($params);
        $failTasksLastPeriod[] = $query->rowCount();
    }

    for ($i = 1; $i <= date("t"); $i++) {
        $labels[] = $i;

        $sql = "SELECT task.id_task FROM task 
                INNER JOIN target ON target.id_target = task.id_target 
                INNER JOIN project ON project.id_project = target.id_project
                INNER JOIN user ON user.id_user = project.id_user
                WHERE user.id_user = :idUser AND task.date = :taskDate AND task.status = 1";
        $query = $db->prepare($sql);
        $params = [
            ':taskDate' => date('Y-m-' . $i),
            ':idUser' => $_SESSION['user']['id']
        ];
        $query->execute($params);
        $doneTasksCurrPeriod[] = $query->rowCount();

        $sql = "SELECT task.id_task FROM task 
                INNER JOIN target ON target.id_target = task.id_target 
                INNER JOIN project ON project.id_project = target.id_project
                INNER JOIN user ON user.id_user = project.id_user
                WHERE user.id_user = :idUser AND task.date = :taskDate AND task.status = 0";
        $query = $db->prepare($sql);
        $params = [
            ':taskDate' => date('Y-m-' . $i),
            ':idUser' => $_SESSION['user']['id']
        ];
        $query->execute($params);
        $failTasksCurrPeriod[] = $query->rowCount();
    }

    $responce["type"] = 2;
}

if (array_sum($doneTasksLastPeriod) + array_sum($failTasksLastPeriod) != 0) {
    $perfLastPeriod = (array_sum($doneTasksLastPeriod) * 100) / (array_sum($doneTasksLastPeriod) + array_sum($failTasksLastPeriod));
} else {
    $perfLastPeriod = 0;
}

if (array_sum($doneTasksCurrPeriod) + array_sum($failTasksCurrPeriod) != 0) {
    $perfCurrPeriod = (array_sum($doneTasksCurrPeriod) * 100) / (array_sum($doneTasksCurrPeriod) + array_sum($failTasksCurrPeriod));
} else {
    $perfCurrPeriod = 0;
    $responce["empty"] = true;
}

$responce["labels"] = $labels;
$responce["perfLastPeriod"] = round($perfLastPeriod);
$responce["doneTaskCurrPeriod"] = $doneTasksCurrPeriod;
$responce["failTaskCurrPeriod"] = $failTasksCurrPeriod;
$responce["perfCurrPeriod"] = round($perfCurrPeriod);

echo json_encode($responce);