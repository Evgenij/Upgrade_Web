<?php

session_start();
if (!isset($_SESSION["theme"])) {
    $_SESSION["theme"] = "light";
}

$days = array(1 => "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота", "Воскресенье");
$monthes = array(1 => "января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря");


?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles/<?php echo $_SESSION["theme"]; ?>.css" id="theme-link">
    <link rel="stylesheet" href="styles/flex.css">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="pictures/icons/favicon.svg" type="image/svg">
    <title>Upgrade - система командной разработки</title>
</head>

<body onload="iniMainWindow();">

    <div class="tabs">
        <nav class="menu panel tabs-triggers">
            <header class="flex">
                <img class="logo" src="pictures/icons/logo.svg" alt="logo">
                <h1 class="name-app">Upgrade</h1>
            </header>
            <div class="block-task flex">
                <p class="block-task__text">Создать задачу</p>
                <button class="button small add-task">+</button>
            </div>
            <ul>
                <li value="tab-1" class="tabs-triggers__item">Основное<span></span></li>
                <li value="tab-2" class="tabs-triggers__item">Задачи<span></span></li>
                <li value="tab-3" class="tabs-triggers__item">Проекты<span></span></li>
                <li value="tab-4" class="tabs-triggers__item">Команды<span></span></li>
                <li value="tab-5" class="tabs-triggers__item">Статистика<span></span></li>
            </ul>
        </nav>
        <main class="tabs-content">
            <div id="tab-1" class="tabs-content__item">
                <section class="head">
                    <header class="header flex">
                        <div class="title-section flex f-col">
                            <h2 class="title-section__title">Основная информация</h2>
                            <h3 class="title-section__subtitle subtitle">
                                <span class="subtitle__color"><?php echo $days[date("N")]; ?>,</span>
                                <?php echo date("d") . " " . $monthes[date("n")] . " " . date("Y"); ?>
                            </h3>
                        </div>
                    </header>
                    <div class="user-panel flex">
                        <div class="user-panel-wrapper flex">
                            <div class="user-data flex f-col">
                                <span class="user-data__nickname text-gradient"><?php echo $_SESSION['user']['nickname']; ?></span>
                                <h3 class="user-data__fullname"><?php echo $_SESSION['user']['name'] . " " . $_SESSION['user']['surname']; ?></h3>
                                <?php
                                include "php/getSpecName.php";
                                ?>
                            </div>
                            <div class="user-avatar flex f-col">
                                <img class="user-avatar__photo" src="<?php if (!empty($_SESSION['user']['avatar'])) {echo $_SESSION['user']['avatar'];} else {echo 'pictures/users_avatar/default-avatar.svg';} ?>" alt="avatar">
                            </div>
                            <div class="user-menu panel">
                                <ul>
                                    <li class="user-menu__item menu-item">
                                        <img src="pictures/icons/icon-settings.svg" alt="icon-settings" class="menu-item__icon"><span class="menu-item__title">Настройки профиля</span>
                                    </li>
                                    <li class="user-menu__item menu-item flex">
                                        <img src="pictures/icons/icon-sun.svg" alt="icon-sun" class="menu-item__icon">
                                        <span class="menu-item__title theme-label">Светлая тема</span>
                                        <div class="checkbox-theme r" id="checkbox-theme">
                                            <input type="checkbox" class="checkbox">
                                            <div class="knobs"></div>
                                            <div class="layer"></div>
                                        </div>
                                    </li>
                                    <li class="user-menu__item menu-item">
                                        <img src="pictures/icons/icon-logout.svg" alt="icon-logout" class="menu-item__icon"><span class="menu-item__title">Выход</span>
                                    </li>
                                    <li class="user-menu__item menu-item">
                                        <img src="pictures/icons/icon-email.svg" alt="icon-email" class="menu-item__icon">
                                        <span class="menu-item__title">
                                            <a href="https://vk.com/jeka_coffeiok" target="_blank">Связь с разработчиком</a>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="panel welcome flex">
                    <img class="peoples" src="pictures/icons/img-peoples.svg" alt="img-peoples">
                    <div class="welcome-content flex">
                        <div class="data">
                            <h2 class="welcome__title title">Привет, <span class="user-name">Евгений Ермоленко</span></h2>
                            <p class="welcome__text text"></p>
                        </div>
                        <button class="button small"></button>
                    </div>
                </section>

                <section class="panel panel-big week-statistic flex f-col">
                    <div class="week-statistic__header header flex">
                        <div class="header__text">
                            <p class="current-performance title">Эффективность за неделю
                                <span class="current-performance__value text-gradient"></span>
                            </p>
                            <p class="last-performance text">Эффективность за прошлую неделю
                                <span class="last-performance__value"></span>
                            </p>
                        </div>
                        <select name="periods_stat" id="periods_stat" class="custom-select text periods_stat">
                            <option value="week">Неделя</option>
                            <option value="month">Месяц</option>
                        </select>
                    </div>
                    <div class="week-statistic__chart" id="week-stat__chart">
                    </div>
                </section>

                <section class="panel panel-big general-statistic flex f-col">
                    <?php include "php/getGeneralStatistic.php"; ?>
                </section>

                <section class="projects-progress">
                    <div class="title-section flex f-col">
                        <h2 class="title-section__title">Прогресс проектов</h2>
                    </div>
                    <div class="projects-list list-blocks">
                        <?php include "php/getListProjects_small.php"; ?>
                    </div>
                </section>

            </div>
            <div id="tab-2" class="tabs-content__item">2</div>
            <div id="tab-3" class="tabs-content__item">3</div>
            <div id="tab-4" class="tabs-content__item">4</div>
            <div id="tab-5" class="tabs-content__item">5</div>
        </main>
    </div>


    <script src="scripts/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="scripts/themes.js"></script>
    <script type="text/javascript" src="scripts/tabs.js"></script>
    <script type="text/javascript" src="scripts/select.js"></script>
    <script src="lib/liteChart.js"></script>
    <script type="text/javascript" src="scripts/main.js"></script>
</body>

</html>