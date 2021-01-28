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
    <link rel="shortcut icon" href="pictures/icons/favicon.svg" type="image/svg">
    <title>Upgrade - регистрация</title>
</head>

<body>

    <div class="background">
        <img src="pictures/icons/bg-item1.svg" alt="bg-item1" class="background__item">
        <img src="pictures/icons/bg-item2.svg" alt="bg-item2" class="background__item">
        <img src="pictures/icons/bg-item3.svg" alt="bg-item3" class="background__item">
        <img src="pictures/icons/bg-item4.svg" alt="bg-item4" class="background__item">
    </div>

    <main class="flex content">
        <img src="pictures/icons/img-reg.svg" alt="img-auth" class="img-auth">
        <div class="panel auth">

            <form action="#" class="form-reg flex f-col">
                <h2>Регистрация</h2>
                <div class="row flex">
                    <div class="row__item input-icon icon-smile">
                        <input type="text" name="name" class="input with-icon" id="name" placeholder="введите имя" value="Имя5">
                    </div>
                    <input type="text" name="surname" class="row__item input" id="surname" placeholder="введите фамилию" value="Фамилия5">
                </div>
                <div class="row flex">
                    <div class="row__item input-icon icon-nickname">
                        <input type="text" name="nickname" class="input with-icon" id="nickname" placeholder="введите ник" value="nick">
                        <div class="nick-error hide">ghnyt</div>
                    </div>
                    <select name="specializations" id="specializations" class="custom-select specializations text" placeholder="Специализация">
                        <?php
                        include "php/show-spec.php";
                        ?>
                    </select>
                </div>
                <div class="row flex">
                    <div class="row__item input-icon icon-email">
                        <input type="email" name="email" class="input with-icon" id="email" placeholder="введите электронный адрес" value="email5@mail.ru">
                    </div>
                </div>
                <div class="row flex">
                    <div class="row__item password input-icon icon-password">
                        <input type="password" name="password" class="input with-icon password-input" id="password" placeholder="введите пароль" value="1">
                        <a href="#" class="password-control flex" onmousedown="mouseDown(this)" onmouseup="mouseUp(this)"></a>
                    </div>
                    <input type="password" name="password_confirm" class="row__item input" id="password_confirm" placeholder="введите пароль повторно" value="1">
                </div>
                <div class="message-block hide"></div>
                <button class="button" type="button" id="btn-reg">Зарегистрироваться</button>
            </form>
            <div class="form-footer flex">
                <img src="pictures/icons/info.svg" alt="info">
                <p class="text">У вас уже есть аккаунт? <a href="index.php">Войти</a></p>
            </div>
        </div>
    </main>

    <footer>
        <p class="text">© Разработчик: <a href="https://vk.com/jeka_coffeiok" target="_blank">Ермоленко Е. С.</a></p>
    </footer>

    <script src="scripts/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="scripts/select.js"></script>
    <script type="text/javascript" src="scripts/main.js"></script>
</body>

</html>