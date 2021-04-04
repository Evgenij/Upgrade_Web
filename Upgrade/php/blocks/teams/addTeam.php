<!-- INSERT INTO `team` (`id_team`, `id_target`, `id_act`, `mark`) VALUES (NULL, '2', '5', '#323232') -->

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$idTarget = $_POST['idTarget'];
$name = $_POST['name'];
$descr = $_POST['descr'];
$mark = $_POST['mark'];


try {
    $sql = "INSERT INTO `team` (`id_team`, `id_target`, `id_act`, `mark`) 
            VALUES (NULL, :idTarget, :idActivity)";
    $tempSql = $db->prepare($sql);
    $params = [
        'idProject' => $idProject,
        ':name' => $name,
        ':descr' => $descr,
        ':mark' => $mark
    ];
    $tempSql->execute($params);
    $idNewTarget = $db->lastInsertId();

    $responce = [
        'status' => true,
        'idTarget' => $idNewTarget
    ];
} catch (PDOException $ex) {
    $responce = [
        'status' => false,
        'message' => $ex->getMessage()
    ];
}

echo json_encode($responce);