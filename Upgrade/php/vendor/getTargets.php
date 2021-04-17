<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/vendor/connect.php";

$idProject = $_POST['project'];

try{
    $sql = "SELECT target.id_target, target.name FROM target 
            INNER JOIN project ON project.id_project = target.id_project 
            WHERE project.id_project = :idProject";

    $nestedSQL = $db->prepare($sql);
    $params = [
        ':idProject' => $idProject
    ];
    $nestedSQL->execute($params);

    if($nestedSQL->rowCount() > 0){
        while ($target = $nestedSQL->fetch(PDO::FETCH_BOTH)) {
            $response["targets"] .= "<span class='custom-option undefined' data-value=".$target['id_target'].">".$target['name']."</span>";
        }
    } else {
        $response["targets"] = "<span class='custom-option undefined' data-value=''>Не найдено</span>";
    }

} catch(PDOException $ex) {
    $response = [
        "status" => false,
        "message" => $ex->getMessage()
    ]; 
}

echo json_encode($response);