<?php
require_once "connect.php";

if(isset($_COOKIE["password_cookie_token"])){
 
    // $update_password_cookie_token = $mysqli->query("UPDATE users SET password_cookie_token = '' WHERE email = '".$_SESSION["email"]."'");
     
    // if(!$update_password_cookie_token){
    //     echo "Ошибка ".$mysqli->error();
    // }else{
    //     setcookie("password_cookie_token", "", time() - 3600);
    // }

    $sql = "UPDATE user SET password_cookie_token='' WHERE email = :email";
    $nestedSQL = $db->prepare($sql);
    $params = [
        ':email' => $_SESSION['user']['email']
    ];
    $nestedSQL->execute($params);

    unset($_SESSION['user']);
    header('Location: /index.php');
}