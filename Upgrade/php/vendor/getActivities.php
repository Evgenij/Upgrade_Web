<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$response = [
    'status' => false,
    'message' => '',
    'activities' => ''
];
$colorBlock = '';

try {
    $result = $db->query("SELECT activity.id_act, activity.name FROM activity");

    if($result->rowCount() > 0){
        $response["status"] = true;

        while ($row = $result->fetch(PDO::FETCH_BOTH)) {
            $activity .= '<option value=' . $row[0] . '>' . $row[1] . '</option>';
        }

        $response["activities"] = $activity;

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