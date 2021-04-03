<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';
$response = [
        "status" => false,
        "message" => '',
        "checkProjects" => false,
        "blocksProject" => ''
    ];

try{
    $sql = 'SELECT project.id_project, project.name, project.descr, project.mark, 
            getProjectPercentComplete(project.id_project) AS "progress", 
            getCountAttachProject(project.id_project) AS "attach",
            getCountParticProject(project.id_project) AS "partic" 
            FROM project INNER JOIN user ON user.id_user = project.id_user 
            WHERE user.id_user = :idUser';

    $nestedSQL = $db->prepare($sql);
    $params = [':idUser' => $_SESSION['user']['id']];
    $nestedSQL->execute($params);

    if($nestedSQL->rowCount() > 0){
        $response["checkProjects"] = true;
        $response["status"] = true;

        while ($project = $nestedSQL->fetch(PDO::FETCH_BOTH)) {

            $sql = 'SELECT DISTINCT user.id_user, user.avatar FROM user 
                    INNER JOIN user_team ON user_team.id_user = user.id_user 
                    INNER JOIN team ON team.id_team = user_team.id_team
                    WHERE team.id_team IN 
                        (SELECT team.id_team FROM team 
                        INNER JOIN target ON target.id_target = team.id_target 
                        INNER JOIN project ON project.id_project = target.id_project
                        WHERE project.id_project = :idProject) LIMIT 0,4';

            $secondSQL = $db->prepare($sql);
            $params = [':idProject' => $project['id_project']];
            $secondSQL->execute($params);

            if($secondSQL->rowCount() > 0){
                $participants = '';
                while ($avatar = $secondSQL->fetch(PDO::FETCH_BOTH)) {
                    $participants .= '<div class="participants-users__item" user-id="'.$avatar['id_user'].'" style="background-image: url('.$avatar['avatar'].');"></div>';
                }
                $participants .= '<div class="participants-users__item text">...</div>';
            } else {
                $participants = '<div class="participants-users__item text">...</div>';
            }
           


            $projects .= '<div class="data-block project-block list-ver__item panel" id="'.$project['id_project'].'">
                                <header class="project-block__header block-head flex">
                                    <div class="block-head__label" style="background-color:'.$project['mark'].';"></div>
                                    <div class="block-head__buttons list-hor">
                                        <svg class="change-data-block svg-fill list-hor__item" width="17" height="20" viewBox="0 0 17 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M16.0257 5.1023C16.4114 4.71657 16.6237 4.2043 16.6237 3.65937C16.6237 3.11444 16.4114 2.60217 16.0257 2.21644L14.4072 0.59799C14.0215 0.212256 13.5092 0 12.9643 0C12.4194 0 11.9071 0.212256 11.5224 0.596969L0.672852 11.4128V15.9182H5.17614L16.0257 5.1023ZM12.9643 2.04092L14.5838 3.65835L12.9612 5.27476L11.3428 3.65733L12.9643 2.04092ZM2.71377 13.8772V12.2598L9.89781 5.09822L11.5163 6.71667L4.33324 13.8772H2.71377ZM0.672852 17.9591H17.0002V20H0.672852V17.9591Z" fill="#DBDCE8"/>
                                        </svg>
                                        <svg class="delete-data-block svg-stroke list-hor__item" width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.8999 4.80005H3.7999H18.9999" stroke="#DBDCE8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M6.6498 4.8V2.9C6.6498 2.39609 6.84998 1.91282 7.2063 1.5565C7.56262 1.20018 8.04589 1 8.5498 1H12.3498C12.8537 1 13.337 1.20018 13.6933 1.5565C14.0496 1.91282 14.2498 2.39609 14.2498 2.9V4.8M17.0998 4.8V18.1C17.0998 18.6039 16.8996 19.0872 16.5433 19.4435C16.187 19.7998 15.7037 20 15.1998 20H5.6998C5.19589 20 4.71262 19.7998 4.3563 19.4435C3.99998 19.0872 3.7998 18.6039 3.7998 18.1V4.8H17.0998Z" stroke="#DBDCE8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M8.5498 9.55005V15.25" stroke="#DBDCE8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M12.3501 9.55005V15.25" stroke="#DBDCE8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg> 
                                    </div>                                            
                                </header>
                                <main class="project-block__content block-content flex f-col">
                                    <div class="block-content__title title title-block">'.$project['name'].'</div>
                                    <div class="block-content__description text regular">'.$project['descr'].'</div>  
                                    <div class="progress block-content__progress arrow empty flex f-col trigger">
                                        <div class="progress-labels flex">
                                            <div class="progress-labels__item text">Прогресс</div>
                                            <div class="progress-labels__item progress-percent text-gradient">'.$project['progress'].'%</div>
                                        </div>
                                        <div class="progress-bar">
                                            <div class="progress-bar__current" style="width:'.$project['progress'].'%;"></div>
                                        </div>
                                    </div>                                 
                                </main>
                                <footer class="project-block__footer block-footer flex">
                                    <div class="block-footer__item participants flex f-col">
                                        <div class="participants-label text">Участников: <span class="participants-value">'.$project['partic'].'</span></div>
                                        <div class="participants-users flex">'.$participants.'</div>
                                    </div>
                                    <div class="block-footer__item flex">
                                        <svg class="project-attach svg-stroke" width="22" height="23" viewBox="0 0 22 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M20.3298 10.876L11.412 19.7938C10.3195 20.8862 8.8378 21.5 7.29278 21.5C5.74776 21.5 4.26603 20.8862 3.17353 19.7938C2.08104 18.7013 1.46729 17.2195 1.46729 15.6745C1.46729 14.1295 2.08104 12.6477 3.17353 11.5553L12.0913 2.6375C12.8196 1.90917 13.8074 1.5 14.8375 1.5C15.8675 1.5 16.8553 1.90917 17.5836 2.6375C18.3119 3.36583 18.7211 4.35365 18.7211 5.38366C18.7211 6.41367 18.3119 7.4015 17.5836 8.12983L8.65616 17.0476C8.292 17.4118 7.79808 17.6163 7.28308 17.6163C6.76807 17.6163 6.27416 17.4118 5.90999 17.0476C5.54583 16.6834 5.34124 16.1895 5.34124 15.6745C5.34124 15.1595 5.54583 14.6656 5.90999 14.3014L14.1485 6.07263" stroke="#DBDCE8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <span class="count-attach text">'.$project['attach'].'</span>
                                    </div>                          
                                </footer>
                            </div>';
        }

        $response['blocksProject'] = $projects;
    } else {
        $response["status"] = false;
    }

} catch(PDOException $ex) {
    $response = [
        "status" => false,
        "message" => $ex->getMessage()
    ]; 
}

echo json_encode($response);



// <div class="data-block project-block list-ver__item panel">
//     <header class="project-block__header block-head flex">
//         <div class="block-head__label"></div>
//         <div class="block-head__buttons list-hor">
//             <svg class="list-hor__item" width="17" height="20" viewBox="0 0 17 20" fill="none" xmlns="http://www.w3.org/2000/svg">
//                 <path d="M16.0257 5.1023C16.4114 4.71657 16.6237 4.2043 16.6237 3.65937C16.6237 3.11444 16.4114 2.60217 16.0257 2.21644L14.4072 0.59799C14.0215 0.212256 13.5092 0 12.9643 0C12.4194 0 11.9071 0.212256 11.5224 0.596969L0.672852 11.4128V15.9182H5.17614L16.0257 5.1023ZM12.9643 2.04092L14.5838 3.65835L12.9612 5.27476L11.3428 3.65733L12.9643 2.04092ZM2.71377 13.8772V12.2598L9.89781 5.09822L11.5163 6.71667L4.33324 13.8772H2.71377ZM0.672852 17.9591H17.0002V20H0.672852V17.9591Z" fill="#DBDCE8"/>
//             </svg>
//             <svg class="delete-data-block list-hor__item" width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
//                 <path d="M1.8999 4.80005H3.7999H18.9999" stroke="#DBDCE8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
//                 <path d="M6.6498 4.8V2.9C6.6498 2.39609 6.84998 1.91282 7.2063 1.5565C7.56262 1.20018 8.04589 1 8.5498 1H12.3498C12.8537 1 13.337 1.20018 13.6933 1.5565C14.0496 1.91282 14.2498 2.39609 14.2498 2.9V4.8M17.0998 4.8V18.1C17.0998 18.6039 16.8996 19.0872 16.5433 19.4435C16.187 19.7998 15.7037 20 15.1998 20H5.6998C5.19589 20 4.71262 19.7998 4.3563 19.4435C3.99998 19.0872 3.7998 18.6039 3.7998 18.1V4.8H17.0998Z" stroke="#DBDCE8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
//                 <path d="M8.5498 9.55005V15.25" stroke="#DBDCE8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
//                 <path d="M12.3501 9.55005V15.25" stroke="#DBDCE8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
//             </svg> 
//         </div>                                            
//     </header>
//     <main class="project-block__content block-content flex f-col">
//         <div class="block-content__title title title-block">Some project</div>
//         <div class="block-content__description text regular">
//             Lorem ipsum dolor sit amet consectetur, 
//             adipisicing elit. Aliquam assumenda aliquid cupiditate 
//             suscipit illo. Non quam magnam quaerat deleniti ipsa nam magni. Earum nihil quos dolor, 
//             officia quod doloribus eum?
//         </div>  
//         <div class="progress block-content__progress arrow empty flex f-col trigger">
//             <div class="progress-labels flex">
//                 <div class="progress-labels__item text">Прогресс</div>
//                 <div class="progress-label progress-percent text-gradient">1 <span class="count-subtask text regular">/3</span></div>
//             </div>
//             <div class="progress-bar">
//                 <div class="progress-bar__current" style="width:39%;"></div>
//             </div>
//         </div>                                 
//     </main>
//     <footer class="project-block__footer block-footer flex">
//         <div class="block-footer__item participants flex f-col">
//             <div class="participants-label text">Участников: <span class="participants-value">6</span></div>
//             <div class="participants-users flex">
//                 <div class="participants-users__item"></div>
//                 <div class="participants-users__item"></div>
//                 <div class="participants-users__item"></div>
//                 <div class="participants-users__item"></div>
//                 <div class="participants-users__item text">...</div>
//             </div>
//         </div>
//         <div class="block-footer__item flex">
//             <svg class="project-attach" width="22" height="23" viewBox="0 0 22 23" fill="none" xmlns="http://www.w3.org/2000/svg">
//                 <path d="M20.3298 10.876L11.412 19.7938C10.3195 20.8862 8.8378 21.5 7.29278 21.5C5.74776 21.5 4.26603 20.8862 3.17353 19.7938C2.08104 18.7013 1.46729 17.2195 1.46729 15.6745C1.46729 14.1295 2.08104 12.6477 3.17353 11.5553L12.0913 2.6375C12.8196 1.90917 13.8074 1.5 14.8375 1.5C15.8675 1.5 16.8553 1.90917 17.5836 2.6375C18.3119 3.36583 18.7211 4.35365 18.7211 5.38366C18.7211 6.41367 18.3119 7.4015 17.5836 8.12983L8.65616 17.0476C8.292 17.4118 7.79808 17.6163 7.28308 17.6163C6.76807 17.6163 6.27416 17.4118 5.90999 17.0476C5.54583 16.6834 5.34124 16.1895 5.34124 15.6745C5.34124 15.1595 5.54583 14.6656 5.90999 14.3014L14.1485 6.07263" stroke="#DBDCE8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
//             </svg>
//             <span class="count-attach text">3</span>
//         </div>                          
//     </footer>
// </div>