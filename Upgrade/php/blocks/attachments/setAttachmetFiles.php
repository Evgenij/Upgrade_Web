<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$output = [];
$response = [];
$fileBlocks = '';
$idTask = '';
$idAttach = '';


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


                $files .= '<div class="file list-hor__item">
                                            <div class="btn-close"></div>
                                            <img src="/pictures/icons/file-icons/' . getExtension($fileName) . '.svg" alt="' . $fileName . '" title = "' . $fileName . '" class="file__icon">
                                            <p class="file__name text" title = "' . $fileName . '">' . getSmallFileName($fileName) . '</p>
                                            <a class="file__download text" href="/php/downloadFile.php?filename='.$fileName.'">скачать</a>
                                        </div>';
            }
        }

        $response = [
            "status" => true,
            "files" => $files
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

