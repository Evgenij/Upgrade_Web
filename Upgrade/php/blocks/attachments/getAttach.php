<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/connect.php';

$response = [
        "status" => false,
        "message" => '',
        "checkAttach" => false,
        "blocksAttach" => '',
        "checkFiles" => false,
        "blocksFile" => '',
    ];

try{
    if($_POST['idProject'] != 0){
        $sql = 'SELECT attachment.id_attach, user.name, user.surname, user.avatar, 
                specialization.name, attachment.comment, attachment.date, 
                attachment.time, project.name, project.mark 
                FROM attachment 
                INNER JOIN project ON project.id_project = attachment.id_project
                INNER JOIN user ON user.id_user = attachment.id_user
                INNER JOIN specialization ON specialization.id_spec = user.id_spec
                WHERE project.id_project = :idProject';

        $nestedSQL = $db->prepare($sql);
        $params = [':idProject' => $_POST['idProject']];
        $nestedSQL->execute($params);
    } else {
        $sql = 'SELECT attachment.id_attach, user.name, user.surname, user.avatar, 
                specialization.name, attachment.comment, attachment.date, 
                attachment.time, project.name, project.mark 
                FROM attachment 
                INNER JOIN project ON project.id_project = attachment.id_project
                INNER JOIN user ON user.id_user = attachment.id_user
                INNER JOIN specialization ON specialization.id_spec = user.id_spec
                WHERE project.id_project IN (
                    SELECT project.id_project FROM project WHERE project.id_user = :idUser)';

        $nestedSQL = $db->prepare($sql);
        $params = [':idUser' => $_SESSION['user']['id']];
        $nestedSQL->execute($params);
    }

    if($nestedSQL->rowCount() > 0){
        $response["checkAttach"] = true;
        $response["status"] = true;

        while ($attach = $nestedSQL->fetch(PDO::FETCH_BOTH)) {

            $sql = 'SELECT file.id_file, file.name, file.path 
                    FROM file WHERE file.id_attach = :idAttach';

            $secondSQL = $db->prepare($sql);
            $params = [':idAttach' => $attach[0]];
            $secondSQL->execute($params);

            if($secondSQL->rowCount() > 0){
                $response["checkFiles"] = true;

                while ($file = $secondSQL->fetch(PDO::FETCH_BOTH)) {
                    $files .= '<div class="file list-hor__item" id="'. $file['id_file'].'">
                                    <div class="btn-close"></div>
                                    <img src="/pictures/icons/file-icons/' . getExtension($file['name']) . '.svg" alt="' . $file['name'] . '" title = "' . $file['name'] . '" class="file__icon">
                                    <p class="file__name text" title = "' . $file['name'] . '">' . getSmallFileName($file['name']) . '</p>
                                    <a class="file__download text" href="/php/downloadFile.php?filename='.$file['path'].'">скачать</a>
                                </div>';
                }

                $file_wrapp = '<div class="content-wrapper__item files">
                                    <article class="attach-block__content block-content">
                                        <div class="block-content__title title title-block">Файлы</div>
                                        <div class="files-list list-hor flex">'.$files.'</div>  
                                    </article>
                                </div>';
            } else {
                $files = '';
                $file_wrapp = '';
            }
           
            $attachments .= '<div class="data-block attach-block panel list-hor-big__item" id='.$attach[0].'>
                                <div class="attach-block__wrapper content-wrapper flex">
                                    <div class="content-wrapper__item main-data">
                                        <header class="attach-block__header block-head flex">
                                            <div class="user-select-data flex">
                                                <div style="background-image:url('.$attach['avatar'].'); background-position: center; background-size: cover; background-repeat: no-repeat;" class="user-select-avatar">
                                                </div>
                                                <div class="flex f-col">
                                                    <p class="user-select-name title-block">'.$attach[1].' '.$attach[2].'</p>
                                                    <span class="user-select-spec text regular">'.$attach[4].'</span>
                                                </div>
                                            </div>
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
                                        <main class="attach-block__content block-content">
                                            <div class="block-content__title title title-block">Комментарий</div>
                                            <div class="block-content__description comment text regular">'.$attach[5].'</div>  
                                        </main>
                                    </div>
                                    '.$file_wrapp.'
                                </div>
                                <footer class="attach-block__footer block-footer flex">
                                    <div class="block-footer__item attach-block__tags flex list-hor">
                                        <div class="list-hor__item tag" style="background:'.ColoringTagBackground($attach[9]).'; color:'.ColoringTagText($attach[9]).';">'.$attach[8].'</div>
                                    </div>
                                    <div class="block-footer__item attach-block__date flex">
                                        <p class="time text regular">'.FormattingTime($attach['time']).'</p>
                                        <p class="date">'.FormattingDate($attach['date']).'</p>
                                    </div>              
                                </footer>
                            </div>';
        }

        $response['blocksAttach'] = $attachments;
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
