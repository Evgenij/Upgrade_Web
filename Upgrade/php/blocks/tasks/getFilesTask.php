<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$idTask = $_GET['idTask'];
$response = [
    'status' => false,
    'message' => '',
    'checkFiles' => false,
    'files' => ''
];

try {
    $sql = "SELECT id_file, file.name, file.path FROM file WHERE file.id_task = :idTask";
    $nestedSQL = $db->prepare($sql);
    $params = [
        ':idTask' => $idTask,
    ];
    $nestedSQL->execute($params);

    if($nestedSQL->rowCount() > 0) // если у задачи есть файлы
    {
        $response['checkFiles'] = true;
        $response['status'] = true;
        
        while ($file = $nestedSQL->fetch(PDO::FETCH_BOTH)) {
            $response['files'] .= '<div class="file list-hor__item" id="'. $file['id_file'].'">
                                        <div class="btn-close"></div>
                                        <img src="/pictures/icons/file-icons/' . getExtension($file['name']) . '.svg" alt="' . $file['name'] . '" title = "' . $file['name'] . '" class="file__icon">
                                        <p class="file__name text" title = "' . $file['name'] . '">' . getSmallFileName($file['name']) . '</p>
                                        <a class="file__download text" href="/php/downloadFile.php?filename='.$file['path'].'">скачать</a>
                                    </div>';
        }
    }
    
} catch (PDOException $ex) {
    $response = [
        'status' => false,
        'message' => $ex->getMessage()
    ];
}

echo json_encode($response);

