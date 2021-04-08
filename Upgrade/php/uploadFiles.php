<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$output = [];
$response = [];
$fileBlocks = '';
$idTask = '';
$idAttach = '';

if(strlen($_POST['idTask']) != 0){
    $idTask = $_POST['idTask'];
} else {
    $idTask = null;
}

if(strlen($_POST['idAttach']) != 0){
    $idAttach = $_POST['idAttach'];
} else {
    $idAttach = null;
}

if (!isset($_FILES['file']['name'][0])) {
    $response = [
        "status" => false
    ];

    echo json_encode($response);
    die();
} else {
    try{
        foreach ($_FILES['file']['name'] as $key => $fileName) {
            if (move_uploaded_file($_FILES['file']['tmp_name'][$key],$_SERVER['DOCUMENT_ROOT'].'/app/uploads/' . $_SESSION['user']['id'] . '_' . $fileName)) {
                $output = '/app/uploads/'. $_SESSION['user']['id'] . '_' . $fileName;

                $sql = "INSERT INTO `file` (`id_file`, `id_attach`, `id_task`, `name`, `path`) 
                            VALUES (NULL, :idAttach, :idTask, :fileName, :path);";
                
                $tempSql = $db->prepare($sql);
                $params = [
                    ':idAttach' => $idAttach,
                    ':idTask' => $idTask,
                    ':fileName' => $fileName,
                    ':path' => $output
                ];
                $tempSql->execute($params);
            }
        }

        $response = [
            "status" => true
        ];

        echo json_encode($response);

    } catch (Exception $ex){
        $response = [
            "status" => false,
            "message" => $ex->getMessage()
        ];
        echo json_encode($response);
        die();
    }
}

