<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/vendor/connect.php";

try{
    $sql = "SELECT project.id_project, project.name FROM project 
        INNER JOIN user ON user.id_user = project.id_user 
        WHERE user.id_user = :idUser";

    $nestedSQL = $db->prepare($sql);
    $params = [
        ':idUser' => $_SESSION['user']['id']
    ];
    $nestedSQL->execute($params);

    if($nestedSQL->rowCount() > 0){
        while ($project = $nestedSQL->fetch(PDO::FETCH_BOTH)) {
            
            $response["projects"] .= "<span class='custom-option undefined' data-value=".$project['id_project'].">".$project['name']."</span>";
        }
    } else {
        $response["projects"] = "<span class='custom-select-trigger custom-select text'>Не найдено</span>";
    }

} catch(PDOException $ex) {
    $response = [
        "status" => false,
        "message" => $ex->getMessage()
    ]; 
}

echo json_encode($response);