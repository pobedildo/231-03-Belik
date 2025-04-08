<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тарифы</title>
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
        .navbar a:nth-child(3) {
            color: #007bff;
        }
        .content {
            padding: 30px;
            max-width: 1000px;
            margin: 0 auto;
            text-align: center;
        }
        .pricing-title {
            font-size: 2em;
            margin-bottom: 30px;
        }
        .pricing-subtitle {
            font-size: 1.2em;
            margin-bottom: 40px;
            color: #6c757d;
        }
        .pricing-cards {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }
        .pricing-card {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 30px;
            width: 350px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .pricing-card:hover {
            transform: translateY(-5px);
        }
        .pricing-card.premium {
            border-top: 5px solid #007bff;
        }
        .pricing-card.free {
            border-top: 5px solid #28a745;
        }
        .pricing-name {
            font-size: 1.5em;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .pricing-price {
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        .pricing-price .free {
            color: #28a745;
        }
        .pricing-price .premium {
            color: #007bff;
        }
        .pricing-features {
            text-align: left;
            margin-bottom: 30px;
        }
        .pricing-feature {
            margin-bottom: 10px;
            position: relative;
            padding-left: 25px;
        }
        .pricing-feature:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #28a745;
            font-weight: bold;
        }
        .pricing-button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            font-size: 1.1em;
            width: 80%;
            text-align: center;
        }
        .free .pricing-button {
            background-color: #28a745;
        }
        .signature {
            margin-top: 50px;
            font-style: italic;
            text-align: center;
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

    <div class="content">
        <h1 class="pricing-title">Выберите подходящий тариф</h1>
        <p class="pricing-subtitle">Начните бесплатно или получите больше возможностей с Премиум</p>
        
        <div class="pricing-cards">

            
            <div class="pricing-card free">
                <div class="pricing-name">Бесплатный тариф</div>
                <div class="pricing-price"><span class="free">0 ₽</span>/месяц</div>
                <div class="pricing-features">
                    <div class="pricing-feature">До 5 задач одновременно</div>
                    <div class="pricing-feature">Базовые функции управления задачами</div>
                    <div class="pricing-feature">Ограниченная статистика</div>
                    <div class="pricing-feature">Поддержка по email</div>
                    <div class="pricing-feature">До 1 участника в проекте</div>
                </div>
                <a href="login.php" class="pricing-button">Выбрать</a>
            </div>
            
            
            <div class="pricing-card premium">
                <div class="pricing-name">Премиум тариф</div>
                <div class="pricing-price"><span class="premium">990 ₽</span>/месяц</div>
                <div class="pricing-features">
                    <div class="pricing-feature">Неограниченное количество задач</div>
                    <div class="pricing-feature">Расширенные функции управления</div>
                    <div class="pricing-feature">Подробная аналитика и отчеты</div>
                    <div class="pricing-feature">Приоритетная поддержка 24/7</div>
                    <div class="pricing-feature">До 10 участников в проекте</div>
                    <div class="pricing-feature">Экспорт данных в Excel/PDF</div>
                    <div class="pricing-feature">Интеграция с календарем</div>
                    <div class="pricing-feature">Напоминания по SMS и email</div>
                </div>
                <a href="login.php" class="pricing-button">Выбрать</a>
            </div>
        </div>
        
        <div class="signature"></div>
    </div>
</body>
</html>