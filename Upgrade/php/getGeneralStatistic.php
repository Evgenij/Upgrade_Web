<?php

require_once "./vendor/connect.php";

$data = [];

$sql = "SELECT COUNT(*) FROM task INNER JOIN target ON target.id_target = task.id_target INNER JOIN project ON project.id_project = target.id_project INNER JOIN user ON user.id_user = project.id_user WHERE task.date = :dateTask AND user.id_user = :idUser";
$query = $db->prepare($sql);
$params = [
    ':idUser' => $_SESSION['user']['id'],
    ':dateTask' => date('Y-m-d')
];
$query->execute($params);
$data['allTask'] = $query->fetch()[0];

$sql = "SELECT COUNT(*) FROM task INNER JOIN target ON target.id_target = task.id_target INNER JOIN project ON project.id_project = target.id_project INNER JOIN user ON user.id_user = project.id_user WHERE task.date = :dateTask AND task.status = 1 AND user.id_user = :idUser";
$query = $db->prepare($sql);
$params = [
    ':idUser' => $_SESSION['user']['id'],
    ':dateTask' => date('Y-m-d')
];
$query->execute($params);
$data['doneTask'] = $query->fetch()[0];

if ($data['allTask'] == 0) {
    $data['performance'] = 0;
} else {
    $data['performance'] = round(($data['doneTask'] * 100) / $data['allTask']);
}

if ($data['performance'] < 20) {
    $data['colorPerf'] = '#EC5050';
    $data['smile'] = 'pictures/icons/smile-bad.svg';
} else if ($data['performance'] >= 20 && $data['performance'] < 40) {
    $data['colorPerf'] = '#EC9150';
    $data['smile'] = 'pictures/icons/smile-bad.svg';
} else if ($data['performance'] >= 40 && $data['performance'] < 60) {
    $data['colorPerf'] = '#ECC950';
    $data['smile'] = 'pictures/icons/smile-middle.svg';
} else if ($data['performance'] >= 60 && $data['performance'] < 80) {
    $data['colorPerf'] = '#70B51A';
    $data['smile'] = 'pictures/icons/smile-good.svg';
} else if ($data['performance'] >= 80 && $data['performance'] <= 100) {
    $data['colorPerf'] = '#44A715';
    $data['smile'] = 'pictures/icons/smile-good.svg';
}



$sql = "SELECT getCurrentPerformance(:idUser)";
$query = $db->prepare($sql);
$params = [
    ':idUser' => $_SESSION['user']['id']
];
$query->execute($params);
$data['currentPerformance'] = $query->fetch()[0];



$sql = "SELECT COUNT(project.id_project) FROM project
INNER JOIN user ON user.id_user = project.id_user
WHERE user.id_user = :idUser";
$query = $db->prepare($sql);
$params = [
    ':idUser' => $_SESSION['user']['id']
];
$query->execute($params);
$data['countProject'] = $query->fetch()[0];



$sql = "SELECT COUNT(project.id_project) FROM project INNER JOIN user ON user.id_user = project.id_user WHERE user.id_user = :idUser AND project.creator = 1";
$query = $db->prepare($sql);
$params = [
    ':idUser' => $_SESSION['user']['id']
];
$query->execute($params);
$data['countProjectOwner'] = $query->fetch()[0];


echo '<div class="row flex">
        <div class="row__title title">Текущая эффективность
            <div class="row__data">
                <p id="current-performance" class="current-performance text-gradient main-value">' . $data['currentPerformance'] . '%</p>
            </div>
        </div>
        <img src="' . $data['smile'] . '" class="header__icon-face"></img>
    </div>
    <div class="row flex f-col">
        <div class="row__title title">Количество задач на сегодня</div>
        <div class="row__data data flex">
            <div class="data__main">
                <div class="block-value flex f-col">
                    <p id="current-progress" class="main-value" style="color: ' . $data['colorPerf'] . ';">' . $data['performance'] . '%</p>
                    <span class="label-value text">прогресс</span>
                </div>
            </div>
            <div class="data__second flex">
                <div class="block-value flex f-col">
                    <p id="all-tasks" class="second-value text-gradient">' . $data['allTask'] . '</p>
                    <span class="label-value text">всего</span>
                </div>
                <div class="block-value flex f-col">
                    <p id="done-tasks" class="second-value gray">' . $data['doneTask'] . '</p>
                    <span class="label-value text">выполнено</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row flex f-col">
        <div class="row__title title">Количество проектов</div>
        <div class="row__data data flex">
            <div class="data__main flex">
                <div class="block-value flex f-col">
                    <p id="owner-project" class="main-value text-gradient">' . $data['countProjectOwner'] . '</p>
                    <span class="label-value text">руководитель в</span>
                </div>
                <div class="block-value flex f-col">
                    <p id="member-project" class="main-value gray">' . $data['countProject'] . '</p>
                    <span class="label-value text">участник в</span>
                </div>
            </div>
        </div>
    </div>';
