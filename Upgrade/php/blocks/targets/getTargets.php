<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$response = [
        "status" => false,
        "message" => '',
        "checkTargets" => false,
        "blocksTarget" => ''
    ];

try{
    $sql = 'SELECT target.id_target, target.name, target.descr, target.mark, 
            project.name, project.mark, 
            getTargetPercentComplete(target.id_target) AS "progress"
            FROM target
            INNER JOIN project ON project.id_project = target.id_project 
            INNER JOIN user ON user.id_user = project.id_user 
            WHERE user.id_user = :idUser';

    $nestedSQL = $db->prepare($sql);
    $params = [':idUser' => $_SESSION['user']['id']];
    $nestedSQL->execute($params);

    if($nestedSQL->rowCount() > 0){
        $response["checkTargets"] = true;
        $response["status"] = true;

        while ($target = $nestedSQL->fetch(PDO::FETCH_BOTH)) {

            $sql = 'SELECT DISTINCT user.id_user, user.avatar FROM user 
                    INNER JOIN user_team ON user_team.id_user = user.id_user 
                    INNER JOIN team ON team.id_team = user_team.id_team
                    WHERE team.id_team IN 
                        (SELECT team.id_team FROM team 
                        INNER JOIN target ON target.id_target = team.id_target 
                        WHERE target.id_target = :idTarget) LIMIT 0,3';

            $secondSQL = $db->prepare($sql);
            $params = [':idTarget' => $target['id_target']];
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
           

            $targets .= '<div class="data-block target-block list-hor-big__item flex f-col panel" id="'.$target['id_target'].'">
                            <header class="target-block__header block-head flex">
                                <div class="block-head__label" style="background-color:'.$target[3].';"></div>
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
                            <main class="target-block__content block-content">
                                <div class="block-content__title title title-block">'.$target[1].'</div>
                                <div class="block-content__description text regular">'.$target['descr'].'</div>  
                                <div class="progress block-content__progress arrow empty flex f-col trigger">
                                    <div class="progress-labels flex">
                                        <div class="progress-labels__item text">Прогресс</div>
                                        <div class="progress-labels__item progress-percent text-gradient">'.$target['progress'].'%</div>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress-bar__current" style="width:'.$target['progress'].'%;"></div>
                                    </div>
                                </div>                                 
                            </main>
                            <footer class="target-block__footer block-footer flex">
                                <div class="block-footer__item target-block__tags flex list-hor">
                                    <div class="list-hor__item tag" style="background:'.ColoringTagBackground($target[5]).'; color:'.ColoringTagText($target[5]).';">'.$target[4].'</div>
                                </div>
                                <div class="block-footer__item participants flex f-col">
                                    <div class="participants-users flex">'.$participants.'</div>
                                </div>                   
                            </footer>
                        </div>';
        }

        $response['blocksTarget'] = $targets;
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
