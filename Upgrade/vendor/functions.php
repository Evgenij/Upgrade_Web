<?php

$monthes = array(1 => "января", "февраля", "марта", "апреля", "мая", 
"июня", "июля", "августа", "сентября", "октября", "ноября", "декабря");

$currWeek = [];
$lastWeek = [];
$currMonday = date('d', strtotime("Monday this week"));
$lastMonday = date('d', strtotime("Monday last week"));
for ($i = 0; $i < 7; $i++) {
    $currWeek[] = date("d",strtotime('+'.$i.' day', $currMonday));
    $lastWeek[] = date("d",strtotime('+'.$i.' day', $lastMonday));
}



function FormattingDate($date){
    $date = explode('-', $date);
    return $date[2].'.'.$date[1].'.'.$date[0];
}

function FormattingTime($time){
    $time = explode(':', $time);
    return $time[0].':'.$time[1];
}

function GetDayOfWeek($date){
    $days = array( 1 => "Понедельник" , "Вторник" , "Среда" , 
    "Четверг" , "Пятница" , "Суббота" , "Воскресенье" );

    return $days[date('N', strtotime($date))];   
}

function FormattingTimeTask($time){
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



function ColoringTagBackground($color){
    if($_SESSION['theme'] == "light"){
        return adjustBrightness($color, 0.75);
    } else {
        return adjustBrightness($color, -0.75);   
    }
}

function ColoringTagText($color){
    if($_SESSION['theme'] == "light"){
        return adjustBrightness($color, 0);
    } else {
        return adjustBrightness($color, 0.2);   
    }
}


function adjustBrightness($hexCode, $adjustPercent) {
    $hexCode = ltrim($hexCode, '#');

    if (strlen($hexCode) == 3) {
        $hexCode = $hexCode[0] . $hexCode[0] . $hexCode[1] . $hexCode[1] . $hexCode[2] . $hexCode[2];
    }

    $hexCode = array_map('hexdec', str_split($hexCode, 2));

    foreach ($hexCode as & $color) {
        $adjustableLimit = $adjustPercent < 0 ? $color : 255 - $color;
        $adjustAmount = ceil($adjustableLimit * $adjustPercent);

        $color = str_pad(dechex($color + $adjustAmount), 2, '0', STR_PAD_LEFT);
    }

    return '#' . implode($hexCode);
}
