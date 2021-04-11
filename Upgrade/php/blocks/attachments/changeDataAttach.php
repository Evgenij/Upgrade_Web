<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$idAttach= $_POST['idAttach'];
$idProject = $_POST['idProject'];
$files = $_POST['files'];

if(strlen($_POST['comment'])==1){ // 1 - символ это энтер, то есть комментарий пустой
    $comment = 'Отсутствует';
} else {
    $comment = $_POST['comment'];
}

try {
    $sql = "UPDATE attachment SET attachment.id_project = :idProject, attachment.comment = :comment 
    WHERE attachment.id_attach = :idAttach";
    $tempSql = $db->prepare($sql);
    $params = [
        ':idProject' => $idProject,
        ':comment' => $comment,
        ':idAttach' => $idAttach
    ];
    $tempSql->execute($params);

    if(count($files)>0){
        for($i = 0; $i<count($files); $i++){
            $sql = "INSERT INTO `file` (`id_file`, `id_attach`, `id_task`, `name`, `path`) 
                    VALUES (NULL, :idAttach, NULL, :fileName, :path);";
            $tempSql = $db->prepare($sql);
            
            $params = [
                ':idAttach' => $idAttach,
                ':fileName' => $files[$i],
                ':path' => '/app/uploads/' . $_SESSION['user']['id'] . '_' . $files[$i]
            ];
            $tempSql->execute($params);
        }
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
