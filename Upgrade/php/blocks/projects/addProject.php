<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$name = $_POST['name'];
$descr = $_POST['descr'];
$mark = $_POST['mark'];



try {
    $sql = "INSERT INTO `project` (`id_project`, `id_user`, `creator`, `name`, `descr`, `mark`) 
    VALUES (NULL, :idUser, '1', :name, :descr, :mark);";
    $tempSql = $db->prepare($sql);
    $params = [
        'idUser' => $_SESSION['user']['id'],
        ':name' => $name,
        ':descr' => $descr,
        ':mark' => $mark
    ];
    $tempSql->execute($params);

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