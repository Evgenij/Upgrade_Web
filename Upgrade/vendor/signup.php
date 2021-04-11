<?php

require_once "connect.php";

$name = trim($_POST['name']);
$surname = trim($_POST['surname']);
$nickname = trim($_POST['nickname']);
$id_spec = $_POST['specialization'];
$email = trim($_POST['email']);
$password = trim($_POST['password']);
$password_confirm = trim($_POST['password_confirm']);

$sql = 'SELECT * FROM user WHERE name = :userName AND surname = :userSurname AND email = :userEmail';
$tempSql = $db->prepare($sql);
$params = [':userName' => $name, ':userSurname' => $surname, ':userEmail' => $email];
$tempSql->execute($params);

if ($tempSql->rowCount() > 0) {
    $response = [
        "status" => false,
        "type" => 0,
        "message" => "Такой пользователь уже существует"
    ];
    echo json_encode($response);
    die();
} else {

    // валидация полей
    $error_fields = [];

    if (strlen($name) === 0) {
        $error_fields[] = 'name';
    }

    if (strlen($surname) === 0) {
        $error_fields[] = 'surname';
    }

    if (strlen($nickname) === 0 || ret_num($nickname) == true) {
        $error_fields[] = 'nickname';
    }

    if($id_spec == 0){
        $error_fields[] = 'specializations';
    }

    if (strlen($password) === 0) {
        $error_fields[] = 'password';
    }

    if (strlen($email) === 0 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_fields[] = 'email';
    }

    if (strlen($password_confirm) === 0) {
        $error_fields[] = 'password_confirm';
    }

    if (!empty($error_fields)) {
        $response = [
            "status" => false,
            "type" => 1,
            "message" => "Проверьте правильность полей",
            "fields" => $error_fields
        ];

        echo json_encode($response);
        die();
    }
    else{

        if($password === $password_confirm){

            try{
                $sql = "INSERT INTO user (id_user, id_spec, email, password, password_cookie_token, nickname, name, surname, avatar) 
                        VALUES(NULL, :idSpec, :userEmail, :userPassword, '', :userNickname, :userName, :userSurname, '/pictures/users_avatar/default-avatar.svg')";
                $tempSql = $db->prepare($sql);
                $params = [
                    ':idSpec' => $id_spec,
                    ':userEmail' => $email,
                    ':userPassword' => password_hash($password, PASSWORD_DEFAULT),
                    ':userNickname' => $nickname,
                    ':userName' => $name,
                    ':userSurname' => $surname
                ];
                $tempSql->execute($params);

                //регистрация пользователя выполнена успешно
                $_SESSION['registered'] = true;
                $_SESSION['email'] = $email;

                $response = [
                    "status" => true
                ];
                echo json_encode($response);
                die();
            }
            catch(PDOException $ex){
                $response = [
                    "status" => false,
                    "type" => 3,
                    "message" => $ex->getMessage()
                ];
                echo json_encode($response);
                die();
            }
        }  
        else{
            $error_fields[] = 'password';
            $error_fields[] = 'password_confirm';

            $response = [
                "status" => false,
                "type" => 2,
                "message" => "Введенные пароли не совпадают",
                "fields" => $error_fields
            ];

            echo json_encode($response);
            die();
        } 
    }
}

function ret_num($str) // проверка строки на наличие цифры
{   // принимаем значение переменной
    preg_match("/[\d]+/", $str, $match); // проверяем наличие в этой переменной цифры
    if ($match[0] === NULL) {
        return false;
    } else {
        return true;
    } // возвращаем boolean значение
}