<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$response = [
    'status' => false,
    'message' => '',
    'colors' => ''
];
$colorBlock = '';

try {
    $sql = "SELECT * FROM `colors` WHERE colors.id_user = :idUser";
    $nestedSQL = $db->prepare($sql);
    $params = [
        ':idUser' => $_SESSION['user']['id']
    ];
    $nestedSQL->execute($params);

    if($nestedSQL->rowCount() > 0){
        $response["status"] = true;

        while ($color = $nestedSQL->fetch(PDO::FETCH_BOTH)) {
            $colorBlock .= '<div class="color-block list-hor__item" id="'.$color[0].'">
                                <label class="color-block__status">
                                    <input type="radio" name="color_status" id="color_status" class="color_status" checked>
                                    <span class="color-rect" style="background-color:'.$color['value'].';"></span>
                                </label>
                                <div class="btn-delete-color"></div>
                            </div>';
        }

        $response["colors"] = $colorBlock;

    } else {
        $response["status"] = false;
    }

} catch (PDOException $ex) {
    $response = [
        'status' => false,
        'message' => $ex->getMessage()
    ];
}

echo json_encode($response);