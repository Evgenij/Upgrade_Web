<?php

session_start();
$driver = 'mysql';
$host = 'localhost';
$dbName = 'upgrade_db';
$dbUser = 'root';
$dbPassword = 'root';
$charset = 'utf8';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
];

try {
    $db = new PDO(
        "$driver:host=$host;dbname=$dbName;charset=$charset",
        $dbUser,
        $dbPassword,
        $options
    );
} catch (PDOException $e) {
    die("Не удалось подключиться к базе данных..." . $e->getMessage());
}
