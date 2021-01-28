<?php

require_once "connect.php";

$email = trim($_POST['email']);

$error = false;

if (strlen($email) === 0 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = true;
}

if ($error) {
    $response = [
        "status" => false,
        "type" => 1,
        "message" => "Проверьте корректность электронной почты",
    ];

    echo json_encode($response);
    die();
} else {
    try {

        $sql = "SELECT id_user FROM user WHERE email = :userEmail";
        $tempSql = $db->prepare($sql);
        $params = [
            ':userEmail' => $email
        ];
        $tempSql->execute($params);
        
        if($tempSql->rowCount() > 0){

            $new_password = gen_password(8);

            try{
                $sql = "UPDATE user SET password=:password WHERE email=:email";
                $tempSql = $db->prepare($sql);
                $params = [
                        ':password' => password_hash($new_password, PASSWORD_DEFAULT),
                        ':email' => $email
                    ];
                $tempSql->execute($params);

                mail($email, "Новый пароль", $new_password); 

                $_SESSION['rec-pass'] = true;
                $_SESSION['email'] = $email;

                $response = [
                    "status" => true
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

        } else {
            $response = [
                "status" => false,
                "type" => 2,
                "message" => "Пользователя с данным email не существует"
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

function gen_password($length = 6)
{
    $password = '';
    $arr = array(
        'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
        'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
        'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
        'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        '1', '2', '3', '4', '5', '6', '7', '8', '9', '0'
    );

    for ($i = 0; $i < $length; $i++) {
        $password .= $arr[random_int(0, count($arr) - 1)];
    }
    return $password;
}