<?php
session_start();
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Проверка заполнения полей
    if (empty($phone) || empty($password)) {
        $_SESSION['error'] = 'Заполните пустые поля';
        header('Location: login.php');
        exit;
    }

    // Поиск пользователя
    $stmt = $pdo->prepare("SELECT * FROM ivanov_231 WHERE phone = ?");
    $stmt->execute([$phone]);
    $user = $stmt->fetch();

    if (!$user) {
        $_SESSION['error'] = 'Номер телефона не зарегистрирован';
        header('Location: login.php');
        exit;
    }

    // Проверка пароля
    if (!password_verify($password, $user['password'])) {
        $_SESSION['error'] = 'Неверно введён пароль';
        header('Location: login.php');
        exit;
    }

    // Успешная авторизация
    $_SESSION['user'] = $user['phone'];
    header('Location: loading.php');
    exit;
}
?>