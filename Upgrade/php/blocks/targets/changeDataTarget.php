<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$idTarget = $_GET['idTarget'];
$idProject = $_GET['idProject'];
$name =  $_GET['name'];
$descr =  $_GET['descr'];
$mark =  $_GET['mark'];
$teams =  $_GET['teams'];
$activities =  $_GET['activities'];
$newTeams =  $_GET['newTeams'];

try {
    
    $params = [
        ':idTarget' => $idTarget,
        ':idProject' => $idProject,
        ':name' => $name,
        ':descr' => $descr,
        ':mark' => $mark
    ];
    $sql = "UPDATE target SET id_project = :idProject, name = :name, descr = :descr, mark = :mark WHERE target.id_target = :idTarget;";
    $nestedSQL = $db->prepare($sql)->execute($params);

    for($i = 0; $i<count($teams); $i++){
        $params = [
            ':idTeam' => $teams[$i],
            ':idAct' => $activities[$i]];
        $sql = "UPDATE team SET team.id_act = :idAct WHERE team.id_team = :idTeam;";
        $nestedSQL = $db->prepare($sql)->execute($params);
    }

    if(count($newTeams)>0){
        for($i = 0; $i<count($newTeams); $i++){
            $sql = "INSERT INTO `team` (`id_team`, `id_target`, `id_act`) 
                VALUES (NULL, :idTarget, :idActivity)";
            $tempSql = $db->prepare($sql);
            $params = [
                'idTarget' => $idTarget,
                ':idActivity' => $newTeams[$i]];
            $tempSql->execute($params);
        }
        
    }

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
