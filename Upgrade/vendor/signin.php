<?php

require_once "connect.php";

$email = trim($_POST['email']);
$password = trim($_POST['password']);

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

        $sql = "SELECT * FROM user WHERE email = :userEmail";
        $tempSql = $db->prepare($sql);
        $params = [
            ':userEmail' => $email
        ];
        $tempSql->execute($params);

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

        $response = [
            "status" => true,
            "message" => 'пользователь зарегистрирован'
        ];
        echo json_encode($response);
        die();
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
