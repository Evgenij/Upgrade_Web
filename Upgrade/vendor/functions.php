<?php

$monthes = array(1 => "января", "февраля", "марта", "апреля", "мая", 
"июня", "июля", "августа", "сентября", "октября", "ноября", "декабря");

$currWeek = [];
$lastWeek = [];
$currMonday = date('d', strtotime("Monday this week"));
$lastMonday = date('d', strtotime("Monday last week"));
for ($i = 0; $i < 7; $i++) {
    $currWeek[] = $currMonday + $i;
    $lastWeek[] = $lastMonday + $i;
}



function FormattingDate($date){
    $date = explode('-', $date);
    return $date[2].'.'.$date[1].'.'.$date[0];
}

function GetDayOfWeek($date){
    $days = array( 1 => "Понедельник" , "Вторник" , "Среда" , 
    "Четверг" , "Пятница" , "Суббота" , "Воскресенье" );

    return $days[date('N', strtotime($date))];   
}

function FormattingTime($time){
    if($time >= 60)
    {
        if($time % 60 == 0){
            return date('G ч', mktime(0, $time ));
        } else {
            return date('G ч i мин', mktime(0, $time ));
        }
    } else {
        return date('i мин', mktime(0, $time ));
    }
}

function getExtension($filename)
{
    return substr(strrchr($filename, '.'), 1);
}

function getSmallFileName($fileName){
    if (strlen($fileName) >= 15) {
        return substr($fileName, 0, 4).'...'.substr($fileName, strlen($fileName) - strlen(getExtension($fileName))*2, strlen(getExtension($fileName))).getExtension($fileName);
    } else {
        return $fileName;
    }
}
