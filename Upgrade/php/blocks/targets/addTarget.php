<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$idProject = $_POST['idProject'];
$teams = $_POST['teams'];
$name = $_POST['name'];
$descr = $_POST['descr'];
$mark = $_POST['mark'];


try {
    $sql = "INSERT INTO `target` (`id_target`, `id_project`, `name`, `descr`, `mark`) 
            VALUES (NULL, :idProject, :name, :descr, :mark)";
    $tempSql = $db->prepare($sql);
    $params = [
        'idProject' => $idProject,
        ':name' => $name,
        ':descr' => $descr,
        ':mark' => $mark
    ];
    $tempSql->execute($params);
    $idNewTarget = $db->lastInsertId();

    for($i = 0; $i<count($teams); $i++)
    {
        $sql = "INSERT INTO `team` (`id_team`, `id_target`, `id_act`) 
                VALUES (NULL, :idTarget, :idActivity)";
        $tempSql = $db->prepare($sql);
        $params = [
            ':idTarget' => $idNewTarget,
            ':idActivity' => $teams[$i],
        ];
        $tempSql->execute($params);
    }

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