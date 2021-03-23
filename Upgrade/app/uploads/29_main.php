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
    <link rel="stylesheet" href="styles/modals.css">
    <link rel="stylesheet" href="styles/responsive.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="pictures/icons/favicon.svg" type="image/svg">
    <title>Upgrade - система командной разработки</title>
</head>

<body onload="iniMainWindow();">

    <div class="notification"></div>

    <div class="wrapp-modal hide">
        <div class="modal-window add-task panel">
            <header class="modal-window__head flex">
                <h3 class="head__title title">Создание задачи</h3>
                <svg class="head__btn-close" width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.2875 1.55029L1.38798 11.4498" stroke="#A5A7BC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M1.38806 1.55029L11.2876 11.4498" stroke="#A5A7BC" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </header> 
            <main class="modal-window__content flex f-col">
                <div class="date-picker flex">
                    <svg width="32" height="30" viewBox="0 0 32 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M30.2503 4H27.0003V6H30.0003V28H2.00026V6H5.00026V4H1.75026C1.51649 4.00391 1.28579 4.05383 1.07132 4.14691C0.856857 4.23999 0.662828 4.37441 0.500319 4.54249C0.33781 4.71057 0.210004 4.90902 0.124203 5.1265C0.0384012 5.34398 -0.00371596 5.57624 0.000257051 5.81V28.19C-0.00371596 28.4238 0.0384012 28.656 0.124203 28.8735C0.210004 29.091 0.33781 29.2894 0.500319 29.4575C0.662828 29.6256 0.856857 29.76 1.07132 29.8531C1.28579 29.9462 1.51649 29.9961 1.75026 30H30.2503C30.484 29.9961 30.7147 29.9462 30.9292 29.8531C31.1437 29.76 31.3377 29.6256 31.5002 29.4575C31.6627 29.2894 31.7905 29.091 31.8763 28.8735C31.9621 28.656 32.0042 28.4238 32.0003 28.19V5.81C32.0042 5.57624 31.9621 5.34398 31.8763 5.1265C31.7905 4.90902 31.6627 4.71057 31.5002 4.54249C31.3377 4.37441 31.1437 4.23999 30.9292 4.14691C30.7147 4.05383 30.484 4.00391 30.2503 4Z" fill="#A5A7BC" />
                        <path d="M6.00024 12H8.00024V14H6.00024V12Z" fill="#A5A7BC" />
                        <path d="M12.0002 12H14.0002V14H12.0002V12Z" fill="#A5A7BC" />
                        <path d="M18.0002 12H20.0002V14H18.0002V12Z" fill="#A5A7BC" />
                        <path d="M24.0002 12H26.0002V14H24.0002V12Z" fill="#A5A7BC" />
                        <path d="M6.00024 17H8.00024V19H6.00024V17Z" fill="#A5A7BC" />
                        <path d="M12.0002 17H14.0002V19H12.0002V17Z" fill="#A5A7BC" />
                        <path d="M18.0002 17H20.0002V19H18.0002V17Z" fill="#A5A7BC" />
                        <path d="M24.0002 17H26.0002V19H24.0002V17Z" fill="#A5A7BC" />
                        <path d="M6.00024 22H8.00024V24H6.00024V22Z" fill="#A5A7BC" />
                        <path d="M12.0002 22H14.0002V24H12.0002V22Z" fill="#A5A7BC" />
                        <path d="M18.0002 22H20.0002V24H18.0002V22Z" fill="#A5A7BC" />
                        <path d="M24.0002 22H26.0002V24H24.0002V22Z" fill="#A5A7BC" />
                        <path d="M8.00024 8C8.26546 8 8.51981 7.89464 8.70735 7.70711C8.89489 7.51957 9.00024 7.26522 9.00024 7V1C9.00024 0.734784 8.89489 0.48043 8.70735 0.292893C8.51981 0.105357 8.26546 0 8.00024 0C7.73503 0 7.48067 0.105357 7.29314 0.292893C7.1056 0.48043 7.00024 0.734784 7.00024 1V7C7.00024 7.26522 7.1056 7.51957 7.29314 7.70711C7.48067 7.89464 7.73503 8 8.00024 8Z" fill="#A5A7BC" />
                        <path d="M24.0002 8C24.2655 8 24.5198 7.89464 24.7074 7.70711C24.8949 7.51957 25.0002 7.26522 25.0002 7V1C25.0002 0.734784 24.8949 0.48043 24.7074 0.292893C24.5198 0.105357 24.2655 0 24.0002 0C23.735 0 23.4807 0.105357 23.2931 0.292893C23.1056 0.48043 23.0002 0.734784 23.0002 1V7C23.0002 7.26522 23.1056 7.51957 23.2931 7.70711C23.4807 7.89464 23.735 8 24.0002 8Z" fill="#A5A7BC" />
                        <path d="M11.0002 4H21.0002V6H11.0002V4Z" fill="#A5A7BC" />
                    </svg>
                    <div class="date-picker__label">
                        <div class="date-picker__sublabel text regular">дата</div>
                        <div class="wrapp flex">
                            <input readonly type="text" class="date-picker__date color-bold" id="datepicker" placeholder="Выберите дату">
                        </div>
                    </div>
                </div>
                <div class="list-hor">
                    <select id="projects-task" class="custom-select projects-task projects text">
                         <?php include "php/getProjects.php"; ?>
                    </select>
                    <select id="targets-task" class="custom-select targets-task targets text list-hor__item">
                    </select>
                    <select id="durations-task" class="custom-select durations-task text">
                        <option value="15">15 минут</option>
                        <option value="30">30 минут</option>
                        <option value="45">45 минут</option>
                        <option value="60">1 час</option>
                        <option value="75">1 час 15 минут</option>
                        <option value="90">1 час 30 минут</option>
                        <option value="105">1 час 45 минут</option>
                        <option value="120">2 часа</option>
                        <option value="135">2 часа 15 минут</option>
                        <option value="150">2 часа 30 минут</option>
                        <option value="165">2 часа 45 минут</option>
                        <option value="180">3 часа</option>
                        <option value="195">3 часа 15 минут</option>
                        <option value="210">3 часа 30 минут</option>
                        <option value="225">3 часа 45 минут</option>
                        <option value="240">4 часа</option>
                        <option value="255">4 часа 15 минут</option>
                        <option value="270">4 часа 30 минут</option>
                        <option value="285">4 часа 45 минут</option>
                        <option value="300">5 часов</option>
                        <option value="315">5 часов 15 минут</option>
                        <option value="330">5 часов 30 минут</option>
                        <option value="345">5 часов 45 минут</option>
                        <option value="360">6 часов</option>
                    </select>
                    <select id="executors-task" class="custom-select executors-task text hide">
                    </select>
                </div>
                <input type="text" class="add-task input" placeholder="текст задачи">

            </main>
            <footer class="modal-window__footer">
                <div class="modal-window__message flex hide"></div>
                <p class="text regular">нажмите
                    <span class="color-bold">
                        <svg class="icon-enter" width="13" height="10" viewBox="0 0 13 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0 6.42312C0 6.23384 0.075191 6.05231 0.209032 5.91847C0.342873 5.78463 0.5244 5.70944 0.71368 5.70944H9.27784C9.84567 5.70944 10.3903 5.48386 10.7918 5.08234C11.1933 4.68082 11.4189 4.13624 11.4189 3.5684V0.71368C11.4189 0.5244 11.4941 0.342873 11.6279 0.209032C11.7617 0.0751912 11.9433 0 12.1326 0C12.3218 0 12.5034 0.0751912 12.6372 0.209032C12.771 0.342873 12.8462 0.5244 12.8462 0.71368V3.5684C12.8462 4.5148 12.4703 5.42243 11.8011 6.09164C11.1319 6.76084 10.2242 7.1368 9.27784 7.1368H0.71368C0.5244 7.1368 0.342873 7.06161 0.209032 6.92776C0.075191 6.79392 0 6.6124 0 6.42312Z" fill="#8A66F0" />
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.209078 6.92724C0.0752835 6.7934 0.00012207 6.61191 0.00012207 6.42267C0.00012207 6.23342 0.0752835 6.05193 0.209078 5.91809L3.0638 3.06338C3.1984 2.93337 3.37867 2.86144 3.5658 2.86306C3.75292 2.86469 3.93192 2.93975 4.06425 3.07207C4.19657 3.20439 4.27162 3.38339 4.27325 3.57052C4.27488 3.75764 4.20294 3.93792 4.07294 4.07252L1.72279 6.42267L4.07294 8.77281C4.1411 8.83865 4.19547 8.9174 4.23288 9.00447C4.27028 9.09154 4.28997 9.18519 4.29079 9.27995C4.29161 9.37471 4.27356 9.46869 4.23767 9.5564C4.20179 9.64411 4.14879 9.72379 4.08179 9.7908C4.01478 9.85781 3.93509 9.9108 3.84738 9.94669C3.75968 9.98257 3.6657 10.0006 3.57094 9.99981C3.47617 9.99898 3.38253 9.9793 3.29545 9.94189C3.20838 9.90449 3.12963 9.85012 3.0638 9.78196L0.209078 6.92724Z" fill="#8A66F0" />
                        </svg>Enter
                    </span>,
                    чтобы создать задачу
                </p>
            </footer>
        </div>
    </div>

    <div class="tabs">
        <nav class="menu panel tabs-triggers">
            <header class="flex">
                <img class="logo" src="pictures/icons/logo.svg" alt="logo">
                <h1 class="name-app">Upgrade</h1>
            </header>
            <div class="block-task flex">
                <p class="block-task__text">Создать задачу</p>
                <button class="button small" id="add-task">+</button>
            </div>
            <ul>
                <li value="tab-1" class="tabs-triggers__item flex">
                    <object type="image/svg+xml" data="pictures/icons/home.svg" width="22" height="25">
                    </object>
                    Основное<span></span>
                </li>
                <li value="tab-2" class="tabs-triggers__item flex">
                    <object type="image/svg+xml" data="pictures/icons/tasks.svg" width="24" height="24">
                    </object>
                    Задачи<span></span>
                </li>
                <li value="tab-3" class="tabs-triggers__item flex">
                    <object type="image/svg+xml" data="pictures/icons/projects.svg" width="23" height="30">
                    </object>
                    Проекты<span></span>
                </li>
                <li value="tab-4" class="tabs-triggers__item flex">
                    <object type="image/svg+xml" data="pictures/icons/teams.svg" width="25px" height="26">
                    </object>
                    Команды<span></span>
                </li>
                <li value="tab-5" class="tabs-triggers__item flex">
                    <object type="image/svg+xml" data="pictures/icons/statistic.svg" width="26px" height="25">
                    </object>
                    Статистика<span></span>
                </li>
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
                                <img class="user-avatar__photo" src="<?php if (!empty($_SESSION['user']['avatar'])) {
                                                                            echo $_SESSION['user']['avatar'];
                                                                        } else {
                                                                            echo 'pictures/users_avatar/default-avatar.svg';
                                                                        } ?>" alt="avatar">
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
                            <h2 class="welcome__title title">Привет, <span class="user-name"><?php echo $_SESSION['user']['name'] . " " . $_SESSION['user']['surname']; ?></span></h2>
                            <p class="welcome__text text"></p>
                        </div>
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
                        <select id="periods_stat" class="custom-select text periods_stat">
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
                        <h3 class="title-section__subtitle subtitle">
                            Вы работаете над <span class="subtitle__color count-project">***</span>
                        </h3>
                    </div>
                    <div class="projects-list list-ver">
                        <?php include "php/getListProjects_small.php"; ?>
                    </div>
                </section>

            </div>
            
            <div id="tab-2" class="tabs-content__item">
                <section class="head">
                    <header class="header flex">
                        <div class="title-section flex f-col">
                            <h2 class="title-section__title">Задачи</h2>
                            <h3 class="title-section__subtitle subtitle">
                                Сегодня у вас <span class="subtitle__color count-task">***</span>
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
                                <img class="user-avatar__photo" src="<?php if (!empty($_SESSION['user']['avatar'])) {
                                                                            echo $_SESSION['user']['avatar'];
                                                                        } else {
                                                                            echo 'pictures/users_avatar/default-avatar.svg';
                                                                        } ?>" alt="avatar">
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
                <div class="tasks">
                    <div class="task-filters">
                        <div class="list-hor">
                            <select id="date-filter" class="custom-select date-filter date text with-shadow">
                                <option value="-2">Прошлая неделя</option>
                                <option value="-1">Вчера</option>
                                <option value="0">Сегодня</option>
                                <option value="1">Завтра</option>
                                <option value="2">Текущая неделя</option>
                            </select>
                            <select id="projects-filter" class="custom-select projects-filter projects text with-shadow">
                                <option value="0">Все проекты</option>
                                <?php include "php/getProjects.php"; ?>
                            </select>
                            <select id="targets-filter" class="custom-select targets-filter targets text with-shadow">
                            </select>
                            <select id="status-filter" class="custom-select status-filter status text with-shadow">
                                <option value="0">Все задачи</option>
                                <option value="1">Выполненные</option>
                                <option value="2">В работе</option>
                            </select>
                            <select id="executors-filter" class="custom-select executors-filter executors text with-shadow hide">
                                <option value="0">Все исполнители</option>
                            </select>
                        </div>
                    </div>
                    <div class="task-list flex">
                        <div class="task-block panel" id="1">
                            <header class="task-block__head flex">
                                <label class="task-block__status">
                                    <input type="checkbox" name="checkbox_status" id="checkbox_status" class="checkbox_status">
                                    <span class="rect"></span>
                                </label>
                                <div class="task-block__date text">Воскресенье<span class="date">18.09.2021</span></div>
                            </header>
                            <main class="task-block__content">
                                <div class="task-block__name title title-block">Название задачи</div>
                                <div class="task-block__description text regular">описание задачи...</div>
                                <div class="progress arrow empty flex f-col trigger">
                                    <div class="progress-labels flex">
                                        <div class="progress-labels__item text">Прогресс</div>
                                        <div class="progress-label progress-percent text-gradient">1 <span class="count-subtask text regular">/3</span></div>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress-bar__current" style="width:39%;"></div>
                                    </div>
                                </div>
                            </main>
                            <footer class="task-block__footer flex list-hor">
                                <div class="list-hor__item tag">Project #1</div>
                                <div class="tag list-hor__item">Target #4</div>
                            </footer>
                        </div>
                        <div class="task-block panel">
                            <header class="task-block__head flex">
                                <label class="task-block__status">
                                    <input type="checkbox" name="checkbox_status" id="checkbox_status" class="checkbox_status">
                                    <span class="rect"></span>
                                </label>
                                <div class="task-block__date text">Воскресенье<span class="date">18.09.2021</span></div>
                            </header>
                            <main class="task-block__content">
                                <div class="task-block__name title title-block">Lorem ipsum dolor sit amet, consectetur adipiscing elit ut aliquam</div>
                                <div class="task-block__description text regular">описание задачи...</div>
                                <div class="progress arrow empty flex f-col trigger">
                                    <div class="progress-labels flex">
                                        <div class="progress-labels__item text">Прогресс</div>
                                        <div class="progress-labels__item progress-percent text-gradient">1 <span class="count-subtask">/3</span></div>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress-bar__current" style="width:39%;"></div>
                                    </div>
                                </div>
                            </main>
                            <footer class="task-block__footer flex list-hor">
                                <div class="list-hor__item tag">Project #1</div>
                                <div class="tag list-hor__item">Target #4</div>
                            </footer>
                        </div>
                        <div class="task-block panel">
                            <header class="task-block__head flex">
                                <label class="task-block__status">
                                    <input type="checkbox" name="checkbox_status" id="checkbox_status" class="checkbox_status">
                                    <span class="rect"></span>
                                </label>
                                <div class="task-block__date text">Воскресенье<span class="date">18.09.2021</span></div>
                            </header>
                            <main class="task-block__content">
                                <div class="task-block__name title title-block">Название задачи</div>
                                <div class="task-block__description text regular">описание задачи...</div>
                                <div class="progress arrow empty flex f-col trigger">
                                    <div class="progress-labels flex">
                                        <div class="progress-labels__item text">Прогресс</div>
                                        <div class="progress-label progress-percent text-gradient">1 <span class="count-subtask text regular">/3</span></div>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress-bar__current" style="width:39%;"></div>
                                    </div>
                                </div>
                            </main>
                            <footer class="task-block__footer flex list-hor">
                                <div class="list-hor__item tag">Project #1</div>
                                <div class="tag list-hor__item">Target #4</div>
                            </footer>
                        </div>
                        <div class="task-block panel">
                            <header class="task-block__head flex">
                                <label class="task-block__status">
                                    <input type="checkbox" name="checkbox_status" id="checkbox_status" class="checkbox_status">
                                    <span class="rect"></span>
                                </label>
                                <div class="task-block__date text">Воскресенье<span class="date">18.09.2021</span></div>
                            </header>
                            <main class="task-block__content">
                                <div class="task-block__name title title-block">Название задачи</div>
                                <div class="task-block__description text regular">описание задачи...</div>
                                <div class="progress arrow empty flex f-col trigger">
                                    <div class="progress-labels flex">
                                        <div class="progress-labels__item text">Прогресс</div>
                                        <div class="progress-label progress-percent text-gradient">1 <span class="count-subtask text regular">/3</span></div>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress-bar__current" style="width:39%;"></div>
                                    </div>
                                </div>
                            </main>
                            <footer class="task-block__footer flex list-hor">
                                <div class="list-hor__item tag">Project #1</div>
                                <div class="tag list-hor__item">Target #4</div>
                            </footer>
                        </div>
                        <div class="task-block panel">
                            <header class="task-block__head flex">
                                <label class="task-block__status">
                                    <input type="checkbox" name="checkbox_status" id="checkbox_status" class="checkbox_status">
                                    <span class="rect"></span>
                                </label>
                                <div class="task-block__date text">Воскресенье<span class="date">18.09.2021</span></div>
                            </header>
                            <main class="task-block__content">
                                <div class="task-block__name title title-block">Название задачи</div>
                                <div class="task-block__description text regular">описание задачи...</div>
                                <div class="progress arrow empty flex f-col trigger">
                                    <div class="progress-labels flex">
                                        <div class="progress-labels__item text">Прогресс</div>
                                        <div class="progress-label progress-percent text-gradient">1 <span class="count-subtask text regular">/3</span></div>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress-bar__current" style="width:39%;"></div>
                                    </div>
                                </div>
                            </main>
                            <footer class="task-block__footer flex list-hor">
                                <div class="list-hor__item tag">Project #1</div>
                                <div class="tag list-hor__item">Target #4</div>
                            </footer>
                        </div>
                        <div class="task-block panel">
                            <header class="task-block__head flex">
                                <label class="task-block__status">
                                    <input type="checkbox" name="checkbox_status" id="checkbox_status" class="checkbox_status">
                                    <span class="rect"></span>
                                </label>
                                <div class="task-block__date text">Воскресенье<span class="date">18.09.2021</span></div>
                            </header>
                            <main class="task-block__content">
                                <div class="task-block__name title title-block">Название задачи</div>
                                <div class="task-block__description text regular">описание задачи...</div>
                                <div class="progress arrow empty flex f-col trigger">
                                    <div class="progress-labels flex">
                                        <div class="progress-labels__item text">Прогресс</div>
                                        <div class="progress-label progress-percent text-gradient">1 <span class="count-subtask text regular">/3</span></div>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress-bar__current" style="width:39%;"></div>
                                    </div>
                                </div>
                            </main>
                            <footer class="task-block__footer flex list-hor">
                                <div class="list-hor__item tag">Project #1</div>
                                <div class="tag list-hor__item">Target #4</div>
                            </footer>
                        </div>
                    </div>
                </div>
                <div class="task-data panel"></div>
            </div>
            <div id="tab-3" class="tabs-content__item">3</div>
            <div id="tab-4" class="tabs-content__item">4</div>
            <div id="tab-5" class="tabs-content__item">5</div>
        </main>
    </div>

    <!-- <script type="text/javascript" src="scripts/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="scripts/themes.js"></script>
    <script type="text/javascript" src="scripts/tabs.js"></script>
    <script type="text/javascript" src="scripts/select.js"></script>
    <script type="text/javascript" src="scripts/task-block.js"></script>
    <script src="lib/liteChart.js"></script>
    <script src="lib/datepicker.js"></script> -->

    <script type="text/javascript" src="scripts/main.js"></script>
</body>

</html>