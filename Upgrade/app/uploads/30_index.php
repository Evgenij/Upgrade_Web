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
    <title>Upgrade - восстановление доступа</title>
</head>

<body>

    <form action="/recovery_password.php" class="form-rec_pass flex f-col" method="GET">
        <h2>Восстановление данных</h2>
        <div class="row flex">
            <div class="row__item input-icon icon-email">
                <input type="email" name="email" class="input with-icon" id="email" placeholder="почта">
            </div>
        </div>
        <div class="message-block hide"></div>
        <button class="button" type="button" id="btn-rec_pass">Восстановить пароль</button>
    </form>
            
            
</body>

</html>