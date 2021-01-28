<?php

require_once "./vendor/connect.php";

$sql = 'SELECT project.id_project, project.name FROM project INNER JOIN user ON user.id_user = project.id_user WHERE user.id_user = :idUser';
$query = $db->prepare($sql);
$params = [':idUser' => $_SESSION['user']['id']];
$query->execute($params);

if ($query->rowCount() > 0) {
    while ($row = $query->fetch(PDO::FETCH_BOTH)) {

        $id_project = $row['id_project'];

        $sql = 'SELECT getProjectPercent(:idProject)';
        $nestedSQL = $db->prepare($sql);
        $params = [':idProject' => $id_project];
        $nestedSQL->execute($params);
        $completionProject = $nestedSQL->fetch()[0];

        $sql = 'SELECT getCountTargetProjects(:idProject)';
        $nestedSQL = $db->prepare($sql);
        $params = [':idProject' => $id_project];
        $nestedSQL->execute($params);
        $countTargetProjects = $nestedSQL->fetch()[0];

        $sql = 'SELECT getCountTaskProjects(:idProject)';
        $nestedSQL = $db->prepare($sql);
        $params = [':idProject' => $id_project];
        $nestedSQL->execute($params);
        $countTaskProjects = $nestedSQL->fetch()[0];

        echo '<div class="project__small list-blocks__item container panel">';
            echo '<h3 class="project-name name">' . $row['name'] . '</h3>';
            echo '<div class="progress arrow flex f-col trigger">';
                echo '<div class="progress-labels flex">';
                    echo '<div class="progress-labels__item text">Прогресс</div>';
                    echo '<div class="progress-labels__item percent">' . $completionProject . '%</div>';
                echo '</div>';
                echo '<div class="progress-bar">';
                    echo '<div class="progress-bar__current" style="width:' . $completionProject . '%;"></div>';
                echo '</div>';
            echo '</div>';
            echo '<div class="project-items flex text">';
                echo '<div class="project-targets">Целей: ' . $countTargetProjects . '</div>';
                echo '<div class="project-tasks">Задач: ' . $countTaskProjects . '</div>';
            echo '</div>';  

            $sql = 'SELECT target.id_target, target.name FROM target INNER JOIN project ON project.id_project = target.id_project WHERE project.id_project = :idProject';
            $nestedQuery = $db->prepare($sql);
            $params = [':idProject' => $id_project];
            $nestedQuery->execute($params);

            if ($nestedQuery->rowCount() > 0) {
                echo '<div class="list-targets content">';
                $num_target = 1;
                while ($row = $nestedQuery->fetch(PDO::FETCH_BOTH)) {

                    $sql = 'SELECT getTargetPercent(:idTarget)';
                    $nestedSQL = $db->prepare($sql);
                    $params = [':idTarget' => $row['id_target']];
                    $nestedSQL->execute($params);
                    $completionTarget = $nestedSQL->fetch()[0];

                    echo '<div class="list-targets__item target-item flex">';
                        echo '<div class="target-item__number gray">'. $num_target . '</div>';
                        echo '<div class="target-item__content">';
                            echo '<h2 class="target-name name">' . $row['name'] . '</h2>';
                            echo '<div class="progress flex f-col">';
                                echo '<div class="progress-labels flex">';
                                echo '<div class="progress-labels__item text">Прогресс</div>';
                                    echo '<div class="progress-labels__item percent">'. $completionTarget .'%</div>';
                                echo '</div>';
                                echo '<div class="progress-bar">';
                                    echo '<div class="progress-bar__current" style="width:' . $completionTarget . '%;"></div>';
                                echo '</div>';  
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';

                    $num_target += 1;
                }
                echo '</div>';
            }
        echo '</div>';
    }
}
else{
    echo 'empty';
}





// echo '<div class="project__small list-blocks__item container panel">
//     <h3 class="project-name name">Проект №1</h3>
//     <div class="progress arrow flex f-col trigger">
//         <div class="progress-labels flex">
//             <div class="progress-labels__item text">Прогресс</div>
//             <div class="progress-labels__item percent">45%</div>
//         </div>
//         <div class="progress-bar">
//             <div class="progress-bar__current"></div>
//         </div>
//     </div>
//     <div class="project-items flex text">
//         <div class="project-targets">Целей: 4</div>
//         <div class="project-tasks">Задач: 14</div>
//     </div>
//     <div class="list-targets content">
//         <div class="list-targets__item target-item flex">
//             <div class="target-item__number gray">1
//             </div>
//             <div class="target-item__content">
//                 <h2 class="target-name name">Цель №1</h2>
//                 <div class="progress flex f-col">
//                     <div class="progress-labels flex">
//                         <div class="progress-labels__item text">Прогресс</div>
//                         <div class="progress-labels__item percent">45%</div>
//                     </div>
//                     <div class="progress-bar">
//                         <div class="progress-bar__current"></div>
//                     </div>
//                 </div>
//             </div>
//         </div>
//         <div class="list-targets__item target-item flex">
//             <div class="target-item__number gray">2
//             </div>
//             <div class="target-item__content">
//                 <h2 class="target-name name">Цель №1</h2>
//                 <div class="progress flex f-col">
//                     <div class="progress-labels flex">
//                         <div class="progress-labels__item text">Прогресс</div>
//                         <div class="progress-labels__item percent">45%</div>
//                     </div>
//                     <div class="progress-bar">
//                         <div class="progress-bar__current"></div>
//                     </div>
//                 </div>
//             </div>
//         </div>
//         <div class="list-targets__item target-item flex">
//             <div class="target-item__number gray">3
//             </div>
//             <div class="target-item__content">
//                 <h2 class="target-name name">Цель №1</h2>
//                 <div class="progress flex f-col">
//                     <div class="progress-labels flex">
//                         <div class="progress-labels__item text">Прогресс</div>
//                         <div class="progress-labels__item percent">45%</div>
//                     </div>
//                     <div class="progress-bar">
//                         <div class="progress-bar__current"></div>
//                     </div>
//                 </div>
//             </div>
//         </div>
//         <div class="list-targets__item target-item flex">
//             <div class="target-item__number gray">4
//             </div>
//             <div class="target-item__content">
//                 <h2 class="target-name name">Цель №1</h2>
//                 <div class="progress flex f-col">
//                     <div class="progress-labels flex">
//                         <div class="progress-labels__item text">Прогресс</div>
//                         <div class="progress-labels__item percent">45%</div>
//                     </div>
//                     <div class="progress-bar">
//                         <div class="progress-bar__current"></div>
//                     </div>
//                 </div>
//             </div>
//         </div>
//     </div>
// </div>';