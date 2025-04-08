<?php
session_start();
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Проверка заполнения полей
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = 'Заполните все поля';
        header('Location: login.php');
        exit;
    }

    // Поиск пользователя
    $stmt = $pdo->prepare("SELECT * FROM belik_231 WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if (!$user) {
        $_SESSION['error'] = 'Неверное имя пользователя или пароль';
        header('Location: login.php');
        exit;
    }

    // Проверка пароля
    if (!password_verify($password, $user['password'])) {
        $_SESSION['error'] = 'Неверное имя пользователя или пароль';
        header('Location: login.php');
        exit;
    }

    // Успешная авторизация
    $_SESSION['user'] = $user['username'];
    header('Location: loading.php');
    exit;
}
?>