<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/vendor/connect.php";

$response = [
    "status" => false,
    "projects" => ''
];

$sql = 'SELECT project.id_project, project.name, 
        getProjectPercentComplete(project.id_project), 
        getCountTargetProjects(project.id_project),
        getCountTaskProjects(project.id_project) 
        FROM project INNER JOIN user ON user.id_user = project.id_user WHERE user.id_user = :idUser';
$query = $db->prepare($sql);
$params = [':idUser' => $_SESSION['user']['id']];
$query->execute($params);

if ($query->rowCount() > 0) {
    while ($project = $query->fetch(PDO::FETCH_BOTH)) {

        $completionProject = $project[2];
        $countTargetProjects = $project[3];
        $countTaskProjects = $project[4];

        // $id_project = $row['id_project'];

        // $sql = 'SELECT getProjectPercentComplete(:idProject)';
        // $nestedSQL = $db->prepare($sql);
        // $params = [':idProject' => $id_project];
        // $nestedSQL->execute($params);
        // $completionProject = $nestedSQL->fetch()[0];

        // $sql = 'SELECT getCountTargetProjects(:idProject)';
        // $nestedSQL = $db->prepare($sql);
        // $params = [':idProject' => $id_project];
        // $nestedSQL->execute($params);
        // $countTargetProjects = $nestedSQL->fetch()[0];

        // $sql = 'SELECT getCountTaskProjects(:idProject)';
        // $nestedSQL = $db->prepare($sql);
        // $params = [':idProject' => $id_project];
        // $nestedSQL->execute($params);
        // $countTaskProjects = $nestedSQL->fetch()[0];

        $sql = 'SELECT target.id_target, target.name, getTargetPercentComplete(target.id_target) 
                FROM target INNER JOIN project ON project.id_project = target.id_project 
                WHERE project.id_project = :idProject';
        $nestedQuery = $db->prepare($sql);
        $params = [':idProject' => $project[0]];
        $nestedQuery->execute($params);

        if ($nestedQuery->rowCount() > 0) {
            $num_target = 1;
            $targets = '';
            while ($target = $nestedQuery->fetch(PDO::FETCH_BOTH)) {

                $completionTarget = $target[2];
                // $sql = 'SELECT getTargetPercentComplete(:idTarget)';
                // $nestedSQL = $db->prepare($sql);
                // $params = [':idTarget' => $row['id_target']];
                // $nestedSQL->execute($params);
                // $completionTarget = $nestedSQL->fetch()[0];

                $targets.='<div class="list-targets__item target-item flex">
                                <div class="target-item__number gray">' . $num_target . '</div>
                                <div class="target-item__content">
                                    <h2 class="target-name title title-block">' . $target['name'] . '</h2>
                                    <div class="progress flex f-col">
                                        <div class="progress-labels flex">
                                            <div class="progress-labels__item text">Прогресс</div>
                                            <div class="progress-labels__item progress-percent text-gradient">' . $completionTarget . '%</div>
                                        </div>
                                        <div class="progress-bar">
                                            <div class="progress-bar__current" style="width:' . $completionTarget . '%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>';

                // echo '<div class="list-targets__item target-item flex">';
                // echo '<div class="target-item__number gray">' . $num_target . '</div>';
                // echo '<div class="target-item__content">';
                // echo '<h2 class="target-name title title-block">' . $target['name'] . '</h2>';
                // echo '<div class="progress flex f-col">';
                // echo '<div class="progress-labels flex">';
                // echo '<div class="progress-labels__item text">Прогресс</div>';
                // echo '<div class="progress-labels__item progress-percent text-gradient">' . $completionTarget . '%</div>';
                // echo '</div>';
                // echo '<div class="progress-bar">';
                // echo '<div class="progress-bar__current" style="width:' . $completionTarget . '%;"></div>';
                // echo '</div>';
                // echo '</div>';
                // echo '</div>';
                // echo '</div>';

                $num_target += 1;
            }
        } else {
            $targets = '';
        }

        $projects.='<div class="project__small list-ver__item container panel">
                        <h3 class="project-name title">' . $project['name'] . '</h3>
                        <div class="progress arrow empty flex f-col trigger">
                            <div class="progress-labels flex">
                                <div class="progress-labels__item text">Прогресс</div>
                                <div class="progress-labels__item progress-percent text-gradient">' . $completionProject . '%</div>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-bar__current" style="width:' . $completionProject . '%;"></div>
                            </div>
                        </div>
                        <div class="project-items flex text">
                            <div class="project-targets">Целей: ' . $countTargetProjects . '</div>
                            <div class="project-tasks">Задач: ' . $countTaskProjects . '</div>
                        </div>
                        <div class="list-targets content">'.$targets.'</div>
                    </div>';

        // echo '<div class="project__small list-ver__item container panel">';
        // echo '<h3 class="project-name title">' . $project['name'] . '</h3>';
        // echo '<div class="progress arrow empty flex f-col trigger">';
        // echo '<div class="progress-labels flex">';
        // echo '<div class="progress-labels__item text">Прогресс</div>';
        // echo '<div class="progress-labels__item progress-percent text-gradient">' . $completionProject . '%</div>';
        // echo '</div>';
        // echo '<div class="progress-bar">';
        // echo '<div class="progress-bar__current" style="width:' . $completionProject . '%;"></div>';
        // echo '</div>';
        // echo '</div>';
        // echo '<div class="project-items flex text">';
        // echo '<div class="project-targets">Целей: ' . $countTargetProjects . '</div>';
        // echo '<div class="project-tasks">Задач: ' . $countTaskProjects . '</div>';
        // echo '</div>';

        // $sql = 'SELECT target.id_target, target.name, getTargetPercentComplete(target.id_target) FROM target INNER JOIN project ON project.id_project = target.id_project WHERE project.id_project = :idProject';
        // $nestedQuery = $db->prepare($sql);
        // $params = [':idProject' => $id_project];
        // $nestedQuery->execute($params);

        // if ($nestedQuery->rowCount() > 0) {
        //     echo '<div class="list-targets content">';
        //     $num_target = 1;
        //     while ($target = $nestedQuery->fetch(PDO::FETCH_BOTH)) {

        //         $completionTarget = $target[2];
        //         // $sql = 'SELECT getTargetPercentComplete(:idTarget)';
        //         // $nestedSQL = $db->prepare($sql);
        //         // $params = [':idTarget' => $row['id_target']];
        //         // $nestedSQL->execute($params);
        //         // $completionTarget = $nestedSQL->fetch()[0];

        //         echo '<div class="list-targets__item target-item flex">';
        //         echo '<div class="target-item__number gray">' . $num_target . '</div>';
        //         echo '<div class="target-item__content">';
        //         echo '<h2 class="target-name title title-block">' . $target['name'] . '</h2>';
        //         echo '<div class="progress flex f-col">';
        //         echo '<div class="progress-labels flex">';
        //         echo '<div class="progress-labels__item text">Прогресс</div>';
        //         echo '<div class="progress-labels__item progress-percent text-gradient">' . $completionTarget . '%</div>';
        //         echo '</div>';
        //         echo '<div class="progress-bar">';
        //         echo '<div class="progress-bar__current" style="width:' . $completionTarget . '%;"></div>';
        //         echo '</div>';
        //         echo '</div>';
        //         echo '</div>';
        //         echo '</div>';

        //         $num_target += 1;
        //     }
        //     echo '</div>';
        // } else {
        //     echo '<div class="list-targets content" style="display:none;"></div>';
        // }
        // echo '</div>';

        $response = [
            "status" => true,
            "projects" => $projects
        ];
    }
} else {
    $response = [
        "status" => false
    ];
}

echo json_encode($response);


