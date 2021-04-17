<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/vendor/connect.php";

$idProject = $_POST['project'];

$sql = "SELECT target.id_target, target.name FROM target INNER JOIN project ON project.id_project = target.id_project WHERE project.id_project = :idProject";

$query = $db->prepare($sql);
$params = [
    ':idProject' => $idProject
];
$query->execute($params);

while ($row = $query->fetch(PDO::FETCH_BOTH)) {
    echo '<span class="custom-option undefined" data-value="' . $row[0] . '">' . $row[1] . '</span>';
}








// SELECT * FROM user 
// INNER JOIN user_team ON user_team.id_user = user.id_user
// INNER JOIN team ON team.id_team = user_team.id_team
// WHERE team.id_team IN 
// (SELECT team.id_team FROM team 
// INNER JOIN target ON target.id_target = team.id_target
// INNER JOIN project ON project.id_project = target.id_project
// WHERE project.id_project = 8)

// SELECT * FROM user 
// INNER JOIN user_team ON user_team.id_user = user.id_user
// INNER JOIN team ON team.id_team = user_team.id_team
// WHERE team.id_team IN 
// (SELECT team.id_team FROM team 
// INNER JOIN target ON target.id_target = team.id_target
// INNER JOIN project ON project.id_project = target.id_project
// WHERE target.id_target = 22)