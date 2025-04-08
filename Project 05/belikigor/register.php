<?php
$username = $_POST['username'];
$phone = $_POST['phone'];
session_start();
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $policy = isset($_POST['policy']) ? true : false;

    // Проверка заполнения полей
    if (empty($phone) || empty($password) || empty($confirm_password)) {
        $_SESSION['error'] = 'Заполните пустые поля';
        header('Location: register.php');
        exit;
    }

    // Проверка совпадения паролей
    if ($password !== $confirm_password) {
        $_SESSION['error'] = 'Пароли не совпадают';
        header('Location: register.php');
        exit;
    }

    if (!preg_match('/^\+?\d{10,15}$/', $phone)) {
        $_SESSION['error'] = 'Некорректный формат телефона';
        header('Location: register.php');
        exit;
    }

    // Проверка согласия с политикой
    if (!$policy) {
        $_SESSION['error'] = 'Необходимо согласиться с нашей политикой';
        header('Location: register.php');
        exit;
    }

    // Проверка существующего телефона
    $stmt = $pdo->prepare("SELECT * FROM belik_231 WHERE phone = ?");
    $stmt->execute([$phone]);
    if ($stmt->fetch()) {
        $_SESSION['error'] = 'Этот номер телефона уже занят';
        header('Location: register.php');
        exit;
    }

    // Хеширование пароля
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Добавление пользователя
    $stmt = $pdo->prepare("INSERT INTO belik_231 (username, phone, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $phone, $hashed_password]);
    if ($stmt->execute([$phone, $hashed_password])) {
        $_SESSION['user'] = $phone;
        header('Location: loading.php');
        exit;
    } else {
        $_SESSION['error'] = 'Ошибка регистрации';
        header('Location: index.php');
        exit;
    }
}
?>