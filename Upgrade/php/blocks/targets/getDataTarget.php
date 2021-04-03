<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$idTarget = $_GET['id'];
$teams = [];

$response = [
    'status' => false,
    'name' => '',
    'descr' => '',
    'idProject' => '',
    'teams' => '',
    'activities' => ''
];

try{
    $sql = 'SELECT target.id_project, target.name, target.descr FROM target 
            WHERE target.id_target = :idTarget';

    $nestedSQL = $db->prepare($sql);
    $params = [':idTarget' => $idTarget];
    $nestedSQL->execute($params);

    if($nestedSQL->rowCount() > 0){
        $response["status"] = true;

        while ($target = $nestedSQL->fetch(PDO::FETCH_BOTH)) {
            $response["name"] = $target['name'];
            $response["descr"] = $target['descr'];
            $response["idProject"] = $target['id_project'];

            $sql = 'SELECT team.id_team, team.id_act FROM team WHERE team.id_target = :idTarget';

            $secondSQL = $db->prepare($sql);
            $params = [':idTarget' => $idTarget];
            $secondSQL->execute($params);

            while ($team = $secondSQL->fetch(PDO::FETCH_BOTH)) {
                $teams[] = $team[0];
                $activities[] = $team[1];
            }

            $response["teams"] = $teams;
            $response["activities"] = $activities;
        }

    } else {
        $response["status"] = false;
    }

} catch(PDOException $ex) {
    $response = [
        "status" => false,
        "message" => $ex->getMessage()
    ]; 
}

echo json_encode($response);
