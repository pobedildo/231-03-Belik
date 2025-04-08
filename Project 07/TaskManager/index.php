<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .navbar {
            display: flex;
            justify-content: space-around;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .navbar a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
        .hero {
            text-align: center;
            padding: 50px 20px;
        }
        .hero h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        .hero p {
            font-size: 1.2em;
            margin-bottom: 30px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        .cta-button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            font-size: 1.1em;
        }
        .signature {
            margin-top: 50px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="index.php">Главная</a>
        <a href="dashboard.php">Дашборд</a>
        <a href="tariffs.php">Тарифы</a>
        <a href="about.php">О продукте</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="profile.php">Личный кабинет</a>
        <?php else: ?>
            <a href="login.php">Войти\Зарегистрироваться</a>
        <?php endif; ?>
    </div>

    <div class="hero">
        <h1>Организуйте работу и жизнь.</h1>
        <p>Упростите жизнь себе и своей команде, используя менеджер задач и список дел №1 в мире</p>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="dashboard.php" class="cta-button">Начать</a>
        <?php else: ?>
            <a href="login.php" class="cta-button">Начать</a>
        <?php endif; ?>
        <div class="signature"></div>
    </div>
</body>
</html>