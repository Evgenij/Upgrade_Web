<?php
require_once "../vendor/connect.php";

$idProject = $_POST['project'];
$responce = [];

// SELECT user.id_user, user.name, user.surname FROM user 
// INNER JOIN user_team ON user_team.id_user = user.id_user 
// INNER JOIN team ON team.id_team = user_team.id_team
// WHERE team.id_team IN 
// (SELECT team.id_team FROM team 
// INNER JOIN target ON target.id_target = team.id_target 
// INNER JOIN project ON project.id_project = target.id_project
// WHERE target.id_target = 22 AND project.creator = 0)

$sql = "SELECT user.id_user, user.name, user.surname FROM user 
        INNER JOIN user_team ON user_team.id_user = user.id_user 
        INNER JOIN team ON team.id_team = user_team.id_team
        WHERE team.id_team IN 
        (SELECT team.id_team FROM team 
        INNER JOIN target ON target.id_target = team.id_target 
        INNER JOIN project ON project.id_project = target.id_project
        WHERE project.id_project = :idProject AND project.creator = 1)";

$query = $db->prepare($sql);
$params = [
    ':idProject' => $idProject
];
$query->execute($params);

if ($query->rowCount() > 0) {

    $rows = '';
    $responce['status'] = true;

    while ($row = $query->fetch(PDO::FETCH_BOTH)) {
        $rows .= '<span class="custom-option undefined" data-value="' . $row[0] . '">' . $row[1] . ' ' . $row[2] . '</span>';
    }

    $responce['rows'] = $rows;
} else {
    $responce['status'] = false;
}


echo json_encode($responce);
