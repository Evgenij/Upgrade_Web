<?php
session_start();

if (!isset($_SESSION["theme"])) {
    $_SESSION["theme"] = "light";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles/<?php echo $_SESSION["theme"]; ?>.css" id="theme-link">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/flex.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="./pictures/favicon.svg" type="image/svg">
    <title>Upgrade - система командной разработки</title>
</head>

<body>

    <div class="tabs">
        <nav class="menu panel tabs-triggers">
            <header class="flex">
                <img class="logo" src="pictures/logo.svg" alt="logo">
                <p class="name-app">Upgrade</p>
            </header>
            <ul>
                <li value="tab-1" class="tabs-triggers__item title">Основное<span></span></li>
                <li value="tab-2" class="tabs-triggers__item title">Задачи<span></span></li>
                <li value="tab-3" class="tabs-triggers__item title">Проекты<span></span></li>
                <li value="tab-4" class="tabs-triggers__item title">Команды<span></span></li>
                <li value="tab-5" class="tabs-triggers__item title">Статистика<span></span></li>
            </ul>
        </nav>
        <main class="panel tabs-content">
            <div id="tab-1" class="tabs-content__item">1</div>
            <div id="tab-2" class="tabs-content__item">2</div>
            <div id="tab-3" class="tabs-content__item">3</div>
            <div id="tab-4" class="tabs-content__item">4</div>
            <div id="tab-5" class="tabs-content__item">5</div>
        </main>
    </div>

    <!-- <button class="theme-button" id="theme-button">Change theme</button> -->
    <script type="text/javascript" src="scripts/themes.js"></script>
    <script type="text/javascript" src="scripts/tabs.js"></script>
</body>

</html>