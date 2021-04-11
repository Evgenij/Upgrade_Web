<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$idAttach = $_GET['id'];

$response = [
    'status' => false,
    'idProject' => '',
    'commemt' => ''
];

try{
    $sql = 'SELECT attachment.id_project, attachment.comment FROM attachment 
            WHERE attachment.id_attach = :idAttach';

    $nestedSQL = $db->prepare($sql);
    $params = [':idAttach' => $idAttach];
    $nestedSQL->execute($params);

    if($nestedSQL->rowCount() > 0){
        $response["status"] = true;
        while ($attach = $nestedSQL->fetch(PDO::FETCH_BOTH)) {
            $response["idProject"] = $attach['id_project'];
            $response["comment"] = $attach['comment'];
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
