<?php
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
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="./pictures/favicon.svg" type="image/svg">
    <title>Upgrade - система командной разработки</title>
</head>

<body>

    <div class="background">
        <img src="pictures/bg-item1.svg" alt="bg-item1" class="background__item">
        <img src="pictures/bg-item2.svg" alt="bg-item2" class="background__item">
        <img src="pictures/bg-item3.svg" alt="bg-item3" class="background__item">
        <img src="pictures/bg-item4.svg" alt="bg-item4" class="background__item">
    </div>

    <main class="flex content">
        <img src="pictures/img-auth.svg" alt="img-auth" class="img-auth">
        <div class="panel auth">
            <header class="auth-header">
                <h1>Добро пожаловать в систему командной разработки</h1>
                <div class="name-app flex">
                    <img src="pictures/logo.svg" alt="logo" class="logo">
                    <p>Upgrade</p>
                </div>
            </header>
            <form action="" class="form-auth flex f-col">
                <h2>Авторизация</h2>
                <div class="row">
                    <div class="input-icon icon-email">
                        <input type="email" name="email" class="input with-icon" id="email" placeholder="введите email">
                    </div>
                </div>
                <div class="row">
                    <div class="password input-icon icon-password">
                        <input type="password" name="password" class="input with-icon password-input" id="password" placeholder="введите пароль">
                        <a href="#" class="password-control flex" onmousedown="mouseDown(this)" onmouseup="mouseUp(this)"></a>
                    </div>
                    <span class="remember-pass text">забыли пароль?</span>
                </div>
                <button class="button" type="button">Войти</button>
            </form>
            <div class="auth-footer flex">
                <img src="pictures/info.svg" alt="info">
                <p class="text">У вас еще нет аккаунта? <a href="registration.php">Зарегистрируйтесь бесплатно</a></p>
            </div>
        </div>
    </main>

    <footer>
        <p class="text">Разработчик: <a href="https://vk.com/jeka_coffeiok" target="_blank">Евгений Ермоленко</a></p>
    </footer>

    <script type="text/javascript" src="scripts/main.js"></script>
</body>

</html>