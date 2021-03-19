<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$output = [];
$ext = [];
$response = [];
$fileBlocks = '';

if (!isset($_FILES['file']['name'][0])) {
    $response = [
        "status" => false
    ];

    echo json_encode($response);
    die();
} else {
    try{
        foreach ($_FILES['file']['name'] as $key => $fileName) {
            if (move_uploaded_file($_FILES['file']['tmp_name'][$key], '../app/uploads/' . $_SESSION['user']['id'] . '_' . $fileName)) {
                $output = 'app/uploads/'. $_SESSION['user']['id'] . '_' . $fileName;
                //$ext[] = getExtension($fileName);

                $fileBlocks .= '<div class="file list-hor__item">
                                    <div class="btn-close"></div>
                                    <img src="/pictures/icons/file-icons/' . getExtension($fileName) . '.svg" alt="' . $fileName . '" title = "' . $fileName . '" class="file__icon">
                                    <p class="file__name text" title = "' . $fileName . '">' . getSmallFileName($fileName) . '</p>
                                    <a class="file__download text" href="/php/downloadFile.php?filename='.$output.'">скачать</a>
                                </div>';
            }
        }

        $response = [
            "status" => true,
            "files" => $fileBlocks
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

    /* foreach ($ext as $val) {
        echo $val;
    } */

    /* foreach ($output as $value) {
        mysqli_query($connect, "INSERT INTO `file` (`path`) VALUES ('$value')");
    } */
}

