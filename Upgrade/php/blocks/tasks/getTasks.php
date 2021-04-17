<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$period = $_POST['period'];
$project = $_POST['project'];
$target = $_POST['target'];
$status = $_POST['status'];
$executor = $_POST['executor'];

$block = '';

$sql = 'SELECT task.id_task, task.status, task.date, task.duration, task.text, task.descr,
getDoneSubtask(task.id_task), getCountSubtask(task.id_task), 
project.name, project.mark, project.id_project,
target.name, target.mark, target.id_target
FROM task 
INNER JOIN target ON target.id_target = task.id_target
INNER JOIN project ON project.id_project = target.id_project
INNER JOIN user ON user.id_user = project.id_user
WHERE ';

if($period == -2){ // прошлая неделя
    $sql .= 'task.date BETWEEN \'' . date('Y-m-') . $lastWeek[0] . '\' AND \'' . date('Y-m-') . $lastWeek[6] . '\'';
} else if($period == -1) { // вчера
    $sql .= 'task.date = \'' . date('Y-m-d', strtotime('yesterday')) . '\' ';
} else if($period == 0) { // сегодня
    $sql .= 'task.date = \'' . date('Y-m-d') . '\' ';
} else if($period == 1) { // завтра
    $sql .= 'task.date = \'' . date('Y-m-d', strtotime('tomorrow')) . '\' ';
} else if($period == 2) { // след. неделя
    $sql .= 'task.date BETWEEN \'' . date('Y-m-') . $currWeek[0] . '\' AND \'' . date('Y-m-') . $currWeek[6] . '\'';
}

// --------------------------

if($status == 1 || $status == 0){ // status = 0 or status = 1
    $sql .= 'AND task.status = :taskStatus '; 
}
else { // status = -1
    $sql .= 'AND (task.status BETWEEN :taskStatus AND 1) '; //task.status BETWEEN -1 AND 1
}

// --------------------------

if($project != 0){ // если был выбран проект
    $sql .= 'AND project.id_project = :idProject 
    AND target.id_target = :idTarget ';

    if($executor != 0){

        try{
            $sql .= 'AND task.executor = :Executor ORDER BY task.status ';
            if($period == -2 || $period == 2){
                $sql .= ', task.date';
            }

            $nestedSQL = $db->prepare($sql);
            $params = [':Executor' => $executor,
                        ':idProject' => $project,
                        ':idTarget' => $target,
                        ':taskStatus' => $status];
            $nestedSQL->execute($params);
        }
        catch(PDOException $ex){
            $response = [
                "sql" => $sql,
                "status" => false,
                "message" => $ex->getMessage()
            ];
            echo json_encode($response);
            die();
        }
    }
    else{
        try{
            $sql .= 'AND user.id_user = :idUser ORDER BY task.status '; 
            if($period == -2 || $period == 2){
                $sql .= ', task.date';
            }

            $nestedSQL = $db->prepare($sql);
            $params = [':idUser' => $_SESSION['user']['id'],
                        ':idProject' => $project,
                        ':idTarget' => $target,
                        ':taskStatus' => $status];
            $nestedSQL->execute($params);
            
        }
        catch(PDOException $ex){
            $response = [
                "sql" => $sql,
                "status" => false,
                "message" => $ex->getMessage()
            ];
            echo json_encode($response);
            die();
        }
    }
    SetBlocks($nestedSQL, $sql); 
}
else {
    try{
        $sql .= 'AND user.id_user = :idUser ORDER BY task.status ';
        if($period == -2 || $period == 2){
            $sql .= ', task.date';
        }
    
        $nestedSQL = $db->prepare($sql);
        $params = [
            ':idUser' => $_SESSION['user']['id'],
             ':taskStatus' => $status];
        $nestedSQL->execute($params);

        SetBlocks($nestedSQL, $sql);
    }
    catch(PDOException $ex){
        $response = [
            "sql" => $sql,
            "status" => false,
            "message" => $ex->getMessage()
        ];
        echo json_encode($response);
        die();
    }
}


function SetBlocks($nestedSQL, $sql){
    if ($nestedSQL->rowCount() > 0) {
        while ($task = $nestedSQL->fetch(PDO::FETCH_BOTH)) {

            $status = '';
            if($task[1] == 0){
                $status = '<label class="task-status">
                                <input type="checkbox" name="checkbox_status" id="checkbox_status" class="checkbox_status">
                                <span class="rect"></span>
                            </label>';
            }
            else{
                $status = '<label class="task-status">
                                <input type="checkbox" name="checkbox_status" id="checkbox_status" class="checkbox_status" checked>
                                <span class="rect"></span>
                            </label>';
            }

            $progress = '';
            if($task[7] != 0){
                $progress = '<div class="progress block-content__progress arrow empty flex f-col trigger">
                                <div class="progress-labels flex">
                                    <div class="progress-labels__item text">Прогресс</div>
                                    <div class="progress-label progress-percent text-gradient">'.$task[6].'<span class="count-subtask text regular">/'.$task[7].'</span></div>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-bar__current" style="width:'.($task[6]*100)/$task[7].'%;"></div>
                                </div>
                            </div>';
            }


            $block .= '<div class="data-block task-block panel" id="'.$task[0].'">
                            <header class="task-block__head block-head flex">
                                '.$status.'
                                <div class="task-block__date text">'.GetDayOfWeek($task[2]).'<span class="date">'.FormattingDate($task[2]).'</span></div>
                            </header>
                            <main class="task-block__content block-content">
                                <div class="block-content__title title title-block">'.$task[4].'</div>
                                <div class="block-content__description text regular">'.$task[5].'</div>
                                '.$progress.'
                            </main>
                            <footer class="task-block__footer block-footer flex list-hor">
                                <div class="task-block__tags flex list-hor">
                                    <div class="list-hor__item tag" title="'.$task[8].'" style="background:'.ColoringTagBackground($task[9]).'; color:'.ColoringTagText($task[9]).';">'.$task[8].'</div>
                                    <div class="list-hor__item tag" title="'.$task[11].'" style="background:'.ColoringTagBackground($task[12]).'; color:'.ColoringTagText($task[12]).';">'.$task[11].'</div>
                                </div>
                                <div class="task-block__duration text">
                                ' . FormattingTimeTask($task[3]) . '
                                </div>     
                            </footer>
                        </div>';
        }

        $response = [
            "sql" => $sql,
            "status" => true,
            "tasks" => $block
        ];
        echo json_encode($response);
    }
    else{
        $response = [
            "sql" => $sql,
            "status" => false,
            "tasks" => null
        ];
        echo json_encode($response);
    }
}
