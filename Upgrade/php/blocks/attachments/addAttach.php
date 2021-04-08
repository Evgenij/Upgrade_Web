<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$idProject = $_POST['idProject'];
$files = $_POST['files'];

if(strlen($_POST['comment'])==1){ // 1 - символ это энтер, то есть комментарий пустой
    $comment = 'Отсутствует';
} else {
    $comment = $_POST['comment'];
}

try {
    $sql = "INSERT INTO `attachment` (`id_attach`, `id_project`, `id_user`, `comment`, `date`, `time`) 
            VALUES (NULL, :idProject, :idUser, :comment, :date, :time);";
    $tempSql = $db->prepare($sql);
    $params = [
        ':idProject' => $idProject,
        ':idUser' => $_SESSION['user']['id'],
        ':comment' => $comment,
        ':date' => date('Y-m-d'),
        ':time' => date('H:i:s'),
    ];
    $tempSql->execute($params);
    $idNewAttach = $db->lastInsertId();

    if(count($files)>0){
        for($i = 0; $i<count($files); $i++){
            $sql = "INSERT INTO `file` (`id_file`, `id_attach`, `id_task`, `name`, `path`) 
                    VALUES (NULL, :idAttach, NULL, :fileName, :path);";
            $tempSql = $db->prepare($sql);
            
            $params = [
                ':idAttach' => $idNewAttach,
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
