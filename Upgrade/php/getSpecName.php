<?php 

require_once "./vendor/connect.php";

if(!empty($_SESSION['user']['id_spec']) && $_SESSION['user']['id_spec'] != 1){
    
    $sql = 'SELECT name FROM specialization WHERE id_spec = :idSpec';
    $tempSql = $db->prepare($sql);
    $params = [':idSpec' => $_SESSION['user']['id_spec']];
    $tempSql->execute($params);

    echo '<p class="user-data__spec text">' . $tempSql->fetch()['name'] . '</p>';
}
else{
    echo '<p class="user-data__spec text"></p>';
}

