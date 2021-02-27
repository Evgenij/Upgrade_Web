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

                    <!-- <svg viewPort width="22" height="25" viewBox="0 0 22 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.5918 18.5608V12.1609H14.1836V18.5608" stroke="#332F2F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M7.59178 23.5048C3.63671 23.5048 3.19724 23.5048 2.09861 23.5048C0.999983 23.5048 1 21.5329 1 20.9501V8.86521L10.8877 1.1748L20.7753 8.86521V20.9501C20.7753 21.5329 20.7753 23.5048 19.6767 23.5048C19.1274 23.5048 18.5781 23.5048 14.1836 23.5048" stroke="#332F2F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg> -->
                    <object type="image/svg+xml" data="pictures/icons/home.svg" width="22" height="25">
                    </object>
                    Основное<span></span>
                </li>
                <li value="tab-2" class="tabs-triggers__item flex">
                    <!-- <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22 12.0049C22 14.2928 21.2527 16.5181 19.8718 18.3423C18.4909 20.1665 16.552 21.4897 14.35 22.1107C12.148 22.7317 9.8034 22.6165 7.67289 21.7826C5.54237 20.9487 3.74253 19.4417 2.54715 17.4909C1.35177 15.5401 0.826269 13.2523 1.05059 10.9754C1.27491 8.69851 2.23678 6.55721 3.78987 4.8772C5.34296 3.1972 7.40228 2.07044 9.65457 1.66833C11.9069 1.26622 14.2289 1.61076 16.2673 2.64954" stroke="#332F2F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <rect x="7.4024" y="10.6106" width="6.54686" height="2.09091" rx="1" transform="rotate(45 7.4024 10.6106)" fill="#332F2F" />
                        <rect x="23.4847" y="4.12109" width="17.8151" height="2.09091" rx="1" transform="rotate(135 23.4847 4.12109)" fill="#332F2F" />
                    </svg> -->
                    <object type="image/svg+xml" data="pictures/icons/tasks.svg" width="24" height="24">
                    </object>
                    Задачи<span></span>
                </li>
                <li value="tab-3" class="tabs-triggers__item flex">
                    <!-- <svg width="23" height="30" viewBox="0 0 23 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.5 24.6765L3.78784 24.9817C2.4681 25.5473 1 24.5793 1 23.1434V7.26601C1 6.3354 1.64187 5.52776 2.54845 5.31765L16.5485 2.07305C17.8022 1.78249 19 2.73447 19 4.02141V6.67651" stroke="#332F2F" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M10.6498 21.1813L8.64983 21.9289C8.25903 22.075 8 22.4484 8 22.8656V26.7304C8 27.4282 8.69658 27.9115 9.35017 27.6671L11.3502 26.9194C11.741 26.7733 12 26.4 12 25.9828V22.1179C12 21.4202 11.3034 20.9369 10.6498 21.1813Z" stroke="#332F2F" stroke-width="2" />
                        <path d="M10.7585 12.4854L8.75852 12.9831C8.31284 13.094 8 13.4943 8 13.9535V16.8925C8 17.5427 8.61059 18.0199 9.24148 17.8629L11.2415 17.3653C11.6872 17.2544 12 16.8541 12 16.3949V13.4558C12 12.8057 11.3894 12.3285 10.7585 12.4854Z" stroke="#332F2F" stroke-width="2" />
                        <path d="M16 12.0196L16 24.8921C16 25.5423 16.6109 26.0196 17.2418 25.8624L21.2418 24.8655C21.6873 24.7544 22 24.3543 22 23.8952L22 11.3561C22 10.7384 21.4457 10.2685 20.8363 10.3696L16.8363 11.0331C16.3538 11.1132 16 11.5305 16 12.0196Z" stroke="#332F2F" stroke-width="2" />
                    </svg> -->
                    <object type="image/svg+xml" data="pictures/icons/projects.svg" width="23" height="30">
                    </object>
                    Проекты<span></span>
                </li>
                <li value="tab-4" class="tabs-triggers__item flex">
                    <!-- <svg width="25" height="26" viewBox="0 0 25 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12.4999 17.6726C11.511 17.6726 10.5443 17.3794 9.72204 16.83C8.89979 16.2806 8.25892 15.4997 7.88048 14.5861C7.50204 13.6724 7.40303 12.6671 7.59595 11.6972C7.78888 10.7273 8.26509 9.83635 8.96435 9.13708C9.66362 8.43782 10.5545 7.96161 11.5244 7.76868C12.4944 7.57576 13.4997 7.67477 14.4133 8.05321C15.327 8.43165 16.1079 9.07252 16.6573 9.89477C17.2067 10.717 17.4999 11.6837 17.4999 12.6726C17.4999 13.9987 16.9731 15.2705 16.0354 16.2082C15.0978 17.1459 13.826 17.6726 12.4999 17.6726ZM12.4999 9.33928C11.8406 9.33928 11.1962 9.53478 10.648 9.90105C10.0998 10.2673 9.67258 10.7879 9.42029 11.397C9.168 12.0061 9.10198 12.6763 9.2306 13.3229C9.35922 13.9695 9.67669 14.5635 10.1429 15.0297C10.609 15.4958 11.203 15.8133 11.8496 15.9419C12.4962 16.0705 13.1664 16.0045 13.7755 15.7522C14.3846 15.4999 14.9052 15.0727 15.2715 14.5245C15.6377 13.9764 15.8332 13.3319 15.8332 12.6726C15.8332 11.7886 15.4821 10.9407 14.8569 10.3156C14.2318 9.69047 13.384 9.33928 12.4999 9.33928V9.33928Z" fill="#332F2F" />
                        <path d="M16.6669 25.1719H8.33353C7.44947 25.1719 6.60162 24.8207 5.9765 24.1956C5.35137 23.5705 5.00018 22.7226 5.00018 21.8386V19.7135C5.00168 19.5481 5.05241 19.3868 5.14591 19.2502C5.23941 19.1137 5.37144 19.0081 5.52519 18.9469L8.55853 17.7302C8.66135 17.6846 8.77234 17.6603 8.8848 17.6588C8.99726 17.6572 9.10887 17.6785 9.21291 17.7212C9.31695 17.7639 9.41126 17.8273 9.49016 17.9074C9.56907 17.9876 9.63093 18.0829 9.67202 18.1876C9.71311 18.2923 9.73258 18.4042 9.72926 18.5166C9.72594 18.6291 9.6999 18.7396 9.6527 18.8417C9.6055 18.9438 9.53812 19.0353 9.45463 19.1107C9.37113 19.186 9.27325 19.2437 9.16687 19.2802L6.66686 20.2802V21.8386C6.66686 22.2806 6.84245 22.7045 7.15501 23.0171C7.46758 23.3296 7.8915 23.5052 8.33353 23.5052H16.6669C17.1089 23.5052 17.5328 23.3296 17.8454 23.0171C18.158 22.7045 18.3336 22.2806 18.3336 21.8386V20.2802L15.8336 19.2802C15.628 19.1984 15.4634 19.0384 15.3759 18.8352C15.2883 18.632 15.2851 18.4024 15.3669 18.1969C15.4487 17.9913 15.6087 17.8267 15.8119 17.7392C16.0151 17.6517 16.2447 17.6484 16.4502 17.7302L19.4836 18.9469C19.6373 19.0081 19.7693 19.1137 19.8628 19.2502C19.9563 19.3868 20.0071 19.5481 20.0086 19.7135V21.8386C20.0086 22.277 19.9221 22.7111 19.754 23.1161C19.586 23.5211 19.3397 23.8889 19.0293 24.1985C18.7189 24.5082 18.3505 24.7535 17.9451 24.9206C17.5397 25.0876 17.1053 25.173 16.6669 25.1719V25.1719Z" fill="#332F2F" />
                        <path d="M6.66632 8.50524C5.84223 8.50524 5.03664 8.26087 4.35143 7.80303C3.66623 7.34518 3.13217 6.69444 2.81681 5.93308C2.50144 5.17172 2.41892 4.33394 2.5797 3.52568C2.74047 2.71742 3.13731 1.97499 3.72003 1.39227C4.30275 0.809549 5.04518 0.412711 5.85344 0.251938C6.66169 0.0911662 7.49947 0.17368 8.26084 0.489047C9.0222 0.804413 9.67294 1.33847 10.1308 2.02367C10.5886 2.70888 10.833 3.51447 10.833 4.33856C10.833 4.88573 10.7252 5.42755 10.5158 5.93308C10.3064 6.4386 9.99952 6.89793 9.6126 7.28485C9.22569 7.67176 8.76636 7.97867 8.26084 8.18807C7.75531 8.39746 7.21349 8.50524 6.66632 8.50524V8.50524ZM6.66632 1.83855C6.17186 1.83855 5.68851 1.98517 5.27739 2.25988C4.86626 2.53458 4.54583 2.92503 4.35661 3.38185C4.16739 3.83866 4.11788 4.34133 4.21435 4.82629C4.31081 5.31124 4.54891 5.7567 4.89854 6.10633C5.24818 6.45596 5.69364 6.69407 6.17859 6.79053C6.66354 6.88699 7.16621 6.83748 7.62303 6.64826C8.07985 6.45905 8.47029 6.13861 8.745 5.72749C9.0197 5.31636 9.16632 4.83301 9.16632 4.33856C9.16632 3.67551 8.90293 3.03963 8.43409 2.57078C7.96525 2.10194 7.32936 1.83855 6.66632 1.83855Z" fill="#332F2F" />
                        <path d="M5.83335 15.497H3.33335C2.44929 15.497 1.60144 15.1458 0.976315 14.5207C0.351191 13.8955 3.90664e-07 13.0477 3.90664e-07 12.1636V10.7053C-0.000161178 10.5384 0.0497963 10.3753 0.143402 10.2371C0.237007 10.0989 0.369947 9.99205 0.525002 9.9303L3.18335 8.88863C3.3858 8.80826 3.61166 8.81036 3.81259 8.89447C4.01351 8.97857 4.17352 9.13801 4.25835 9.33863C4.29894 9.44039 4.31907 9.54916 4.31758 9.65871C4.31609 9.76827 4.29301 9.87645 4.24967 9.97707C4.20632 10.0777 4.14356 10.1688 4.06497 10.2451C3.98639 10.3215 3.89352 10.3816 3.79168 10.422L1.66667 11.272V12.1636C1.66667 12.6057 1.84227 13.0296 2.15483 13.3422C2.46739 13.6547 2.89132 13.8303 3.33335 13.8303H5.83335C6.05437 13.8303 6.26633 13.9181 6.42261 14.0744C6.57889 14.2307 6.66669 14.4426 6.66669 14.6636C6.66669 14.8847 6.57889 15.0966 6.42261 15.2529C6.26633 15.4092 6.05437 15.497 5.83335 15.497V15.497Z" fill="#332F2F" />
                        <path d="M18.3332 8.50524C17.5091 8.50524 16.7035 8.26087 16.0183 7.80303C15.3331 7.34518 14.799 6.69444 14.4837 5.93308C14.1683 5.17172 14.0858 4.33394 14.2466 3.52568C14.4073 2.71742 14.8042 1.97499 15.3869 1.39227C15.9696 0.809549 16.7121 0.412711 17.5203 0.251938C18.3286 0.0911662 19.1663 0.17368 19.9277 0.489047C20.6891 0.804413 21.3398 1.33847 21.7977 2.02367C22.2555 2.70888 22.4999 3.51447 22.4999 4.33856C22.4999 5.44363 22.0609 6.50344 21.2795 7.28485C20.4981 8.06625 19.4383 8.50524 18.3332 8.50524V8.50524ZM18.3332 1.83855C17.8387 1.83855 17.3554 1.98517 16.9443 2.25988C16.5331 2.53458 16.2127 2.92503 16.0235 3.38185C15.8343 3.83866 15.7848 4.34133 15.8812 4.82629C15.9777 5.31124 16.2158 5.7567 16.5654 6.10633C16.915 6.45596 17.3605 6.69407 17.8455 6.79053C18.3304 6.88699 18.8331 6.83748 19.2899 6.64826C19.7467 6.45905 20.1372 6.13861 20.4119 5.72749C20.6866 5.31636 20.8332 4.83301 20.8332 4.33856C20.8332 3.67551 20.5698 3.03963 20.101 2.57078C19.6321 2.10194 18.9962 1.83855 18.3332 1.83855Z" fill="#332F2F" />
                        <path d="M21.6668 15.4963H19.1668C18.9458 15.4963 18.7338 15.4085 18.5775 15.2522C18.4212 15.0959 18.3334 14.884 18.3334 14.6629C18.3334 14.4419 18.4212 14.23 18.5775 14.0737C18.7338 13.9174 18.9458 13.8296 19.1668 13.8296H21.6668C22.1088 13.8296 22.5327 13.654 22.8453 13.3415C23.1579 13.0289 23.3335 12.605 23.3335 12.1629V11.2713L21.2084 10.4379C21.1066 10.3975 21.0137 10.3374 20.9352 10.2611C20.8566 10.1847 20.7938 10.0937 20.7505 9.99303C20.7071 9.89241 20.684 9.78423 20.6825 9.67468C20.6811 9.56512 20.7012 9.45635 20.7418 9.35459C20.8218 9.14944 20.9799 8.98432 21.1813 8.89531C21.3827 8.80631 21.6112 8.80065 21.8168 8.87959L24.4751 9.92126C24.6302 9.98301 24.7631 10.0899 24.8567 10.2281C24.9503 10.3663 25.0003 10.5294 25.0001 10.6963V12.1546C25.0012 12.593 24.9158 13.0274 24.7488 13.4328C24.5818 13.8382 24.3364 14.2066 24.0268 14.517C23.7171 14.8274 23.3493 15.0737 22.9443 15.2418C22.5394 15.4098 22.1052 15.4963 21.6668 15.4963Z" fill="#332F2F" />
                    </svg> -->
                    <object type="image/svg+xml" data="pictures/icons/teams.svg" width="25px" height="26">
                    </object>
                    Команды<span></span>
                </li>
                <li value="tab-5" class="tabs-triggers__item flex">
                    <!-- <svg width="26" height="25" viewBox="0 0 26 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M23.6402 22.2971C23.4701 22.4673 23.2437 22.5611 23.0028 22.5611C22.7619 22.5611 22.5356 22.4673 22.365 22.2967C21.9438 21.8758 21.4694 21.4014 21.0482 20.98C20.8778 20.8096 20.784 20.5831 20.784 20.3424C20.784 20.1043 20.8755 19.8805 21.0418 19.7113C21.044 19.7091 21.0461 19.707 21.0483 19.7048C21.2185 19.5345 21.4449 19.4408 21.6857 19.4408C21.9266 19.4408 22.153 19.5345 22.3232 19.7048C22.7444 20.1256 23.2191 20.6004 23.6403 21.0218C23.8107 21.1923 23.9046 21.4187 23.9046 21.6594C23.9046 21.9001 23.8107 22.1265 23.6402 22.2971ZM10.4393 17.0386C8.24961 14.8488 8.24961 11.2857 10.4393 9.09586C11.4993 8.03582 12.9097 7.45207 14.4107 7.45207C15.9117 7.45207 17.3221 8.03582 18.3821 9.09586C20.5719 11.2857 20.5719 14.8488 18.3821 17.0386C17.3221 18.0986 15.9117 18.6824 14.4107 18.6824C12.9097 18.6824 11.4993 18.0986 10.4393 17.0386ZM9.36175 3.94074C8.74467 3.94074 8.24272 3.43879 8.24272 2.82172C8.24272 2.20469 8.74467 1.70269 9.36175 1.70269C9.97882 1.70269 10.4808 2.20469 10.4808 2.82172C10.4808 3.43879 9.97882 3.94074 9.36175 3.94074ZM2.64994 13.4629C2.03282 13.4629 1.53081 12.961 1.53081 12.3439C1.53081 11.7269 2.03282 11.2249 2.64994 11.2249C3.26696 11.2249 3.76902 11.7269 3.76902 12.3439C3.76902 12.961 3.26696 13.4629 2.64994 13.4629ZM22.7855 5.37256C23.4025 5.37256 23.9046 5.87457 23.9046 6.49159C23.9046 7.10892 23.4025 7.61112 22.7855 7.61112C22.1684 7.61112 21.6664 7.10892 21.6664 6.49159C21.6664 5.87457 22.1684 5.37256 22.7855 5.37256ZM23.4059 18.6226C22.9466 18.163 22.3357 17.9099 21.6857 17.9099C21.3185 17.9099 20.9639 17.991 20.6419 18.1441L20.0085 17.5109C21.8877 15.147 22.0533 11.8595 20.5051 9.33283L21.2434 8.64493C21.6782 8.95727 22.2105 9.14194 22.7855 9.14194C24.2466 9.14194 25.4354 7.95301 25.4354 6.49159C25.4354 5.03048 24.2466 3.84175 22.7855 3.84175C21.3243 3.84175 20.1356 5.03048 20.1356 6.49159C20.1356 6.82041 20.1962 7.13519 20.3061 7.42595L19.565 8.11645C19.5319 8.0819 19.4986 8.04741 19.4646 8.01342C18.1155 6.66426 16.3206 5.92126 14.4107 5.92126C14.1421 5.92126 13.8759 5.93646 13.6127 5.9655L11.7789 3.90558C11.928 3.57447 12.0116 3.20779 12.0116 2.82172C12.0116 1.3606 10.8229 0.171875 9.36175 0.171875C7.90058 0.171875 6.71191 1.3606 6.71191 2.82172C6.71191 3.37429 6.88208 3.88767 7.17248 4.31273L3.31187 9.77779C3.10021 9.72314 2.87839 9.69405 2.64994 9.69405C1.18873 9.69405 0 10.8828 0 12.3439C0 13.8051 1.18873 14.9937 2.64994 14.9937C4.11105 14.9937 5.29983 13.8051 5.29983 12.3439C5.29983 11.6653 5.04306 11.0456 4.62199 10.5763L8.3658 5.27663C8.67349 5.4019 9.00956 5.47156 9.36175 5.47156C9.87666 5.47156 10.3573 5.32347 10.7645 5.06834L11.3419 5.71695L11.9193 6.36555C10.9678 6.71835 10.0955 7.2748 9.3569 8.01342C6.57036 10.8001 6.57031 15.3343 9.3569 18.121C10.706 19.4702 12.5008 20.2132 14.4107 20.2132C16.0801 20.2132 17.6615 19.6455 18.9343 18.6016L19.5355 19.2026C19.3511 19.5494 19.2532 19.9383 19.2532 20.3424C19.2532 20.9919 19.5061 21.6027 19.9655 22.0622C20.387 22.4839 20.8616 22.9585 21.2827 23.3792C21.742 23.8388 22.3529 24.0919 23.0028 24.0919C23.6527 24.0919 24.2637 23.8388 24.7231 23.3792C25.1824 22.9196 25.4354 22.3089 25.4354 21.6594C25.4354 21.0099 25.1824 20.3992 24.7231 19.9396C24.3018 19.5181 23.8273 19.0436 23.4059 18.6226Z" fill="#332F2F" />
                        <path d="M17.5418 11.2324C17.1191 11.2324 16.7764 11.5751 16.7764 11.9978V13.8935C16.7764 14.3162 17.1191 14.6589 17.5418 14.6589C17.9645 14.6589 18.3072 14.3162 18.3072 13.8935V11.9978C18.3072 11.5751 17.9645 11.2324 17.5418 11.2324Z" fill="#332F2F" />
                        <path d="M11.591 11.2151C11.1683 11.2151 10.8256 11.5578 10.8256 11.9805V13.9109C10.8256 14.3336 11.1683 14.6763 11.591 14.6763C12.0137 14.6763 12.3564 14.3336 12.3564 13.9109V11.9805C12.3564 11.5578 12.0137 11.2151 11.591 11.2151Z" fill="#332F2F" />
                        <path d="M14.5664 9.80469C14.1437 9.80469 13.801 10.1474 13.801 10.5701V15.3151C13.801 15.7378 14.1437 16.0805 14.5664 16.0805C14.9891 16.0805 15.3318 15.7378 15.3318 15.3151V10.5701C15.3318 10.1474 14.9891 9.80469 14.5664 9.80469Z" fill="#332F2F" />
                    </svg> -->
                    <!-- <embed src="pictures/icons/statistic.svg" width="26px"></embed> -->
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
                        <!-- <button class="button small">
                            <svg width="23" height="34" viewBox="0 0 23 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 31V3C0 1.35191 1.88153 0.411145 3.2 1.4L21.8667 15.4C22.9333 16.2 22.9333 17.8 21.8667 18.6L3.2 32.6C1.88153 33.5889 0 32.6481 0 31Z" fill="white" />
                            </svg>
                        </button> -->
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


    <script src="scripts/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="scripts/themes.js"></script>
    <script type="text/javascript" src="scripts/tabs.js"></script>
    <script type="text/javascript" src="scripts/select.js"></script>
    <script type="text/javascript" src="scripts/task-block.js"></script>
    <script src="lib/liteChart.js"></script>
    <script src="lib/datepicker.js"></script>

    <script type="text/javascript" src="scripts/main.js"></script>
</body>

</html>