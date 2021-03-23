<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$idTask = $_GET['idTask'];
$response = [
    'status' => false,
    'message' => '',
    'checkSubtasks' => false,
    'countSubtasks' => 0,
    'countDoneSubtasks' => 0,
    'progress' => 0,
    'subtasks' => '',
];

try {
    $sql = "SELECT id_subtask, text, status, getCountSubtask(id_task), getDoneSubtask(id_task) 
                FROM subtask WHERE subtask.id_task = :idTask";
    $nestedSQL = $db->prepare($sql);
    $params = [
        ':idTask' => $idTask,
    ];
    $nestedSQL->execute($params);

    if($nestedSQL->rowCount() > 0) // если у задачи есть подзадачи
    {
        $response['checkSubtasks'] = true;

        while ($subtask = $nestedSQL->fetch(PDO::FETCH_BOTH)) {
            $response['countSubtasks'] = $subtask[3];
            $response['countDoneSubtasks'] = $subtask[4];
            $response['progress'] = ($subtask[4]*100)/$subtask[3];

            if($subtask[2] == 1){
                $status = 'checked';
            } else {
                $status = 'unchecked';
            }

            $response['subtasks'] .= '<div class="subtask list-ver__item flex" id="'.$subtask[0].'">
                                        <div class="btn-subtask-delete"></div>
                                        <label class="task-status flex text">
                                            <input type="checkbox" name="checkbox_status" id="checkbox_status" class="checkbox_status" '.$status.'>
                                            <div class="rect"></div>
                                            <div class="subtask-text">'.$subtask[1].'</div>
                                        </label>
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