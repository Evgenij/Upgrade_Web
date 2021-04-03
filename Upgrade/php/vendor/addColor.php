<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$valueColor = $_GET['color'];

$response = [
    'status' => false,
    'message' => ''
];

try {
    $sql = "INSERT INTO `colors` (`id_color`, `id_user`, `value`) VALUES (NULL, :idUser, :color)";
    $nestedSQL = $db->prepare($sql);
    $params = [
        ':idUser' => $_SESSION['user']['id'],
        ':color' => $valueColor
    ];
    $nestedSQL->execute($params);

    $response = [
        'status' => true
    ];

} catch (PDOException $ex) {
    $response = [
        'status' => false,
        'message' => $ex->getMessage()
    ];
}

echo json_encode($response);
