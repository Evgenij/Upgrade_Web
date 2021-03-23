<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$idTask = $_GET['idTask'];
$response = [
    'status' => false,
    'taskText' => '',
    'taskDescr' => '',
    'taskDur' => '',
    'taskStatus' => '',
    'idTarget' => '',
    'idProject' => '',
    'checkExecutor' => false,
    'idExecutor' => 0,
    'executors' => ''
];


try {
    $sql = "SELECT task.id_task, task.text, task.descr, 
            task.duration, task.status, project.id_project, target.id_target, task.executor FROM task 
            INNER JOIN target ON target.id_target = task.id_target
            INNER JOIN project ON project.id_project = target.id_project
            WHERE task.id_task = :idTask;";
    $tempSQL = $db->prepare($sql);
    $params = [
        ':idTask' => $idTask,
    ];
    $tempSQL->execute($params);

    while ($task = $tempSQL->fetch(PDO::FETCH_BOTH)) {

        // $sql = "SELECT id_subtask, text, status, getCountSubtask(id_task), getDoneSubtask(id_task) 
        //     FROM subtask WHERE subtask.id_task = :idTask";
        // $nestedSQL = $db->prepare($sql);
        // $params = [
        //     ':idTask' => $task['id_task'],
        // ];
        // $nestedSQL->execute($params);

        // if($nestedSQL->rowCount() > 0) // если у задачи есть подзадачи
        // {
        //     $response['checkSubtasks'] = true;

        //     while ($subtask = $nestedSQL->fetch(PDO::FETCH_BOTH)) {
        //         $response['countSubtasks'] = $subtask[3];
        //         $response['countDoneSubtasks'] = $subtask[4];
        //         $response['progress'] = ($subtask[4]*100)/$subtask[3];

        //         if($subtask[2] == 1){
        //             $status = 'checked';
        //         } else {
        //             $status = 'unchecked';
        //         }

        //         $response['subtasks'] .= '<div class="subtask list-ver__item flex" id="'.$subtask[0].'">
        //                                     <div class="btn-subtask-delete"></div>
        //                                     <label class="task-status flex text">
        //                                         <input type="checkbox" name="checkbox_status" id="checkbox_status" class="checkbox_status" '.$status.'>
        //                                         <div class="rect"></div>
        //                                         <div class="subtask-text">'.$subtask[1].'</div>
        //                                     </label>
        //                                 </div>';

        //     }
        // }
        
        if($task['executor'] != $_SESSION['user']['id']){
            
            $response['checkExecutor'] = true;
            $response['idExecutor'] = $task['executor'];

            $sql = "SELECT user.id_user, user.name, user.surname, user.avatar, specialization.name FROM user 
                    INNER JOIN user_team ON user_team.id_user = user.id_user 
                    INNER JOIN team ON team.id_team = user_team.id_team
                    INNER JOIN specialization ON specialization.id_spec = user.id_spec
                    WHERE team.id_team IN 
                        (SELECT team.id_team FROM team 
                        INNER JOIN target ON target.id_target = team.id_target 
                        INNER JOIN project ON project.id_project = target.id_project
                        WHERE project.id_project = :idProject)";
            $nestedSQL = $db->prepare($sql);
            $params = [
                ':idProject' => $task['id_project'],
            ];
            $nestedSQL->execute($params);

            if($nestedSQL->rowCount() > 0) // если у задачи есть подзадачи
            {
                while ($executor = $nestedSQL->fetch(PDO::FETCH_BOTH)) {
                    $response['executors'] .= '<div class="custom-option undefined" data-value="'.$executor[0].'"><div class="user-select-data flex"><div style="background-image:url('.$executor[3].'); background-position: center; background-size: contain;" class="user-select-avatar"></div><div class="flex f-col"><p class="user-select-name">'.$executor[1].' '.$executor[2].'</p><span class="text regular">'.$executor[4].'</span></div></div></div>';
                }
            }
        } 

        $response['status'] = true;
        $response['taskText'] = $task['text'];
        $response['taskDescr'] = $task['descr'];
        $response['taskDur'] = $task['duration'];
        $response['taskStatus'] = $task['status'];
        $response['idTarget'] = $task['id_target'];
        $response['idProject'] = $task['id_project'];                                       
    }
} catch (PDOException $ex) {
    $response = [
        'status' => false,
        'message' => $ex->getMessage()
    ];
}

echo json_encode($response);


