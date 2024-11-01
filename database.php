<?php
// Настройки для подключения к базе данных
$host = 'localhost';       // Сервер базы данных
$db_user = 'newadmin';     // Имя пользователя MySQL
$db_password = 'password'; // Пароль для MySQL
$db_name = 'shop';         // Имя базы данных

// Создаем подключение к базе данных
$mysqli = new mysqli($host, $db_user, $db_password, $db_name);

// Проверяем подключение на наличие ошибок
if ($mysqli->connect_error) {
    die("Ошибка подключения: " . $mysqli->connect_error);
}