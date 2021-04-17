<?php

require_once "connect.php";

$email = trim($_POST['email']);
$password = trim($_POST['password']);
$remember_me = $_POST["remember_me"];

// валидация полей
$error_fields = [];

if (strlen($password) === 0) {
    $error_fields[] = 'password';
}

if (strlen($email) === 0 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error_fields[] = 'email';
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
} else {
    try {

        //======= Обработка галочки " запомнить меня " =======
 
        //Проверяем, если галочка была поставлена
        if($remember_me == 1){
    
            //Создаём токен
            $password_cookie_token = md5($password.time());

            $params = [
                ':token' => $password_cookie_token,
                ':email' => $email
            ];
            $sql = 'UPDATE user SET password_cookie_token=:token WHERE email = :email';
            $nestedSQL = $db->prepare($sql)->execute($params);
        
            //Устанавливаем куку с токеном
            setcookie("password_cookie_token", $password_cookie_token, time() + (1000 * 60 * 60 * 24 * 30), '/');
        
        }else if ($remember_me == 0){
        
            if(isset($_COOKIE["password_cookie_token"])){
                $params = [
                    ':email' => $email
                ];
                $sql = "UPDATE user SET password_cookie_token='' WHERE email = :email";
                $nestedSQL = $db->prepare($sql)->execute($params);

                //Удаляем куку password_cookie_token
                setcookie("password_cookie_token","",time()-3600*24);
            }
        }
        
        //место для добавления данных в сессию

        $sql = "SELECT * FROM user WHERE email = :userEmail";
        $tempSql = $db->prepare($sql);
        $params = [
            ':userEmail' => $email
        ];
        $tempSql->execute($params);

        if($tempSql->rowCount() > 0)
        {
            $userData = $tempSql->fetch(PDO::FETCH_BOTH);

            if (password_verify($password, $userData['password'])) {

                $_SESSION['user'] = [
                    "id" => $userData['id_user'],
                    "id_spec" => $userData['id_spec'],
                    "email" => $userData['email'],
                    "password" => $userData['password'],
                    "nickname" => $userData['nickname'],
                    "name" => $userData['name'],
                    "surname" => $userData['surname'],
                    "avatar" => $userData['avatar']
                ];

                $response = [
                    "status" => true
                ];
                echo json_encode($response);
                die();
            } else {
                $error_fields[] = 'password';
                $response = [
                    "status" => false,
                    "type" => 2,
                    "message" => 'пароль неверный',
                    "fields" => $error_fields
                ];
                echo json_encode($response);
                die();
            }
        } else {
            $response = [
                "status" => false,
                "type" => 4,
                "message" => 'Пользователя с данным email не существует... Пройдите регистрацию'
            ];
            echo json_encode($response);
            die();
        }

    } catch (PDOException $ex) {
        $response = [
            "status" => false,
            "type" => 3,
            "message" => $ex->getMessage()
        ];
        echo json_encode($response);
        die();
    }
}
