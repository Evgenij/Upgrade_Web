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
    <title>Upgrade - восстановление доступа</title>
</head>

<body>

    <div class="background">
        <img src="pictures/icons/bg-item1.svg" alt="bg-item1" class="background__item">
        <img src="pictures/icons/bg-item2.svg" alt="bg-item2" class="background__item">
        <img src="pictures/icons/bg-item3.svg" alt="bg-item3" class="background__item">
        <img src="pictures/icons/bg-item4.svg" alt="bg-item4" class="background__item">
    </div>

    <main class="flex content">
        <img src="pictures/icons/img-recovery_pass.svg" alt="img-auth" class="img-auth">
        <div class="panel auth">

            <form action="#" class="form-rec_pass flex f-col">
                <h2>Восстановление данных</h2>
                <div class="row flex">
                    <div class="row__item input-icon icon-email">
                        <input type="email" name="email" class="input with-icon" id="email" placeholder="введите электронную почту">
                    </div>
                </div>
                <div class="message-block hide"></div>
                <button class="button" type="button" id="btn-rec_pass">Восстановить пароль</button>
            </form>
            <div class="form-footer flex">
                <img src="pictures/icons/info.svg" alt="info">
                <p class="text">Вернуться <a href="index.php">на авторизацию</a></p>
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