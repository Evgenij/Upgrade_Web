<?php
session_start();
require_once "vendor/connect.php";
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles/light.css" id="theme-link">
    <link rel="stylesheet" href="styles/flex.css">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/index.css">
    <link rel="stylesheet" href="styles/responsive.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="pictures/icons/favicon.svg" type="image/svg">
    <title>Upgrade - система командной разработки</title>
</head>

<body <?php
        if (isset($_SESSION['registered']) == true) {
            echo "onload=\"showNotification('Регистрация прошла успешно!')\"";
            unset($_SESSION['registered']);
        }
        if (isset($_SESSION['rec-pass']) == true) {
            echo "onload=\"showNotification('Новый пароль отправлен на вашу электронную почту!')\"";
            unset($_SESSION['rec-pass']);
        }
        ?>>
    <div class="notification"></div>

    <div class="background">
        <img src="pictures/icons/bg-item1.svg" alt="bg-item1" class="background__item">
        <img src="pictures/icons/bg-item2.svg" alt="bg-item2" class="background__item">
        <img src="pictures/icons/bg-item3.svg" alt="bg-item3" class="background__item">
        <img src="pictures/icons/bg-item4.svg" alt="bg-item4" class="background__item">
    </div>

    <main class="flex content">
        <img src="pictures/icons/img-auth.svg" alt="img-auth" class="img-auth">
        <div class="panel auth">
            <header class="auth-header">
                <h1>Добро пожаловать в систему командной разработки</h1>
                <div class="name-app flex">
                    <img src="pictures/icons/logo.svg" alt="logo" class="logo">
                    <p>Upgrade</p>
                </div>
            </header>
            <form action="#" class="form-auth flex f-col">
                <h2>Авторизация</h2>
                <div class="row">
                    <div class="input-icon icon-email">
                        <input type="email" name="email" class="input with-icon" id="email" placeholder="введите email" value="<?php if (isset($_SESSION['email'])) {
                                                                                                                                    echo $_SESSION['email'];
                                                                                                                                    unset($_SESSION['email']);
                                                                                                                                } ?>">
                    </div>
                </div>
                <div class="row flex f-col">
                    <div class="password input-icon icon-password">
                        <input type="password" name="password" class="input with-icon password-input" id="password" placeholder="введите пароль" value="1">
                        <a href="#" class="password-control flex" onmousedown="mouseDown(this)" onmouseup="mouseUp(this)"></a>
                    </div>
                    <a class="remember-pass text" href="recovery_pass.php">забыли пароль?</a>
                </div>
                <div class="message-block hide"></div>
                <button class="button" id="btn-auth" type="button">Войти</button>
            </form>
            <div class="form-footer flex">
                <svg class="icon-mess info" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 19C14.9706 19 19 14.9706 19 10C19 5.02944 14.9706 1 10 1C5.02944 1 1 5.02944 1 10C1 14.9706 5.02944 19 10 19Z" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M10 6.3999V9.9999" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M10 13.6001H10.01" stroke="#8A66F0" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p class="text">У вас еще нет аккаунта? <a href="registration.php">Зарегистрируйтесь бесплатно</a></p>
            </div>
        </div>
    </main>

    <footer>
        <p class="text">© Разработчик: <a href="https://vk.com/jeka_coffeiok" target="_blank">Ермоленко Е. С.</a></p>
    </footer>

    <script src="scripts/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="scripts/main.js"></script>
</body>

</html>