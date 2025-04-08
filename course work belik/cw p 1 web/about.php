<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>О продукте</title>
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
        .navbar a:nth-child(4) {
            color: #007bff;
        }
        .content {
            padding: 30px;
            max-width: 800px;
            margin: 0 auto;
        }
        .section-title {
            font-size: 2em;
            margin-bottom: 20px;
            text-align: center;
        }
        .section-subtitle {
            font-size: 1.2em;
            color: #6c757d;
            margin-bottom: 30px;
            text-align: center;
        }
        .about-text {
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .features {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 40px;
        }
        .feature {
            flex: 1 1 300px;
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .feature h3 {
            margin-top: 0;
            color: #007bff;
        }
        .reviews {
            margin-top: 50px;
        }
        .review-list {
            list-style-type: none;
            padding: 0;
        }
        .review-item {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            position: relative;
            padding-left: 80px;
        }
        .review-avatar {
            position: absolute;
            left: 20px;
            top: 20px;
            width: 50px;
            height: 50px;
            background-color: #007bff;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2em;
        }
        .review-author {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .review-date {
            color: #6c757d;
            font-size: 0.9em;
            margin-bottom: 10px;
        }
        .review-text {
            line-height: 1.5;
        }
        .signature {
            margin-top: 50px;
            font-style: italic;
            text-align: center;
        }
        .app-badge {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 30px 0;
        }
        .app-badge img {
            height: 50px;
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
        <h1 class="section-title">О нашем продукте</h1>
        <p class="section-subtitle">Упрощаем управление задачами и повышаем продуктивность</p>
        
        <div class="about-text">
            <p>Наша система управления задачами создана для того, чтобы помочь вам организовать работу и личные дела, повысить продуктивность и снизить уровень стресса от перегрузки задачами.</p>
            <p>Сервис доступен как веб-версия, так и мобильное приложение, что позволяет вам управлять задачами в любом месте и в любое время.</p>
        </div>
        
        <div class="app-badge">
            <img src="https://upload.wikimedia.org/wikipedia/commons/3/3c/Download_on_the_App_Store_Badge.svg" alt="App Store">
            <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Google Play">
        </div>
        
        <h2>Ключевые возможности</h2>
        <div class="features">
            <div class="feature">
                <h3>Простое управление задачами</h3>
                <p>Создавайте, редактируйте и отмечайте выполненные задачи в несколько кликов. Настраивайте категории и приоритеты для лучшей организации.</p>
            </div>
            <div class="feature">
                <h3>Синхронизация между устройствами</h3>
                <p>Ваши задачи автоматически синхронизируются между всеми вашими устройствами, включая компьютеры, планшеты и смартфоны.</p>
            </div>
            <div class="feature">
                <h3>Напоминания и уведомления</h3>
                <p>Никогда не пропускайте важные дела с настраиваемыми напоминаниями через email, push-уведомления и SMS.</p>
            </div>
            <div class="feature">
                <h3>Совместная работа</h3>
                <p>Делитесь задачами с коллегами, друзьями или семьей, назначайте ответственных и отслеживайте прогресс.</p>
            </div>
            <div class="feature">
                <h3>Аналитика продуктивности</h3>
                <p>Получайте отчеты о вашей продуктивности, анализируйте статистику выполнения задач и находите возможности для улучшения.</p>
            </div>
            <div class="feature">
                <h3>Безопасность данных</h3>
                <p>Все ваши данные надежно защищены с использованием современных технологий шифрования и регулярного резервного копирования.</p>
            </div>
        </div>
        
        <div class="reviews">
            <h2 class="section-title">Отзывы наших пользователей</h2>
            <ul class="review-list">
                <li class="review-item">
                    <div class="review-avatar">АК</div>
                    <div class="review-author">Алексей К.</div>
                    <div class="review-date">15 января 2025</div>
                    <div class="review-text">
                        Использую этот сервис уже больше года для управления рабочими проектами. Очень удобно, что можно делиться задачами с коллегами и видеть прогресс по каждому проекту. Особенно нравится функция напоминаний - больше ничего не забываю!
                    </div>
                </li>
                <li class="review-item">
                    <div class="review-avatar">МС</div>
                    <div class="review-author">Марина С.</div>
                    <div class="review-date">3 марта 2025</div>
                    <div class="review-text">
                        Перепробовала множество приложений для управления задачами, но остановилась на этом. Простой и интуитивно понятный интерфейс, при этом все необходимые функции. Мобильное приложение работает стабильно, синхронизация мгновенная.
                    </div>
                </li>
                <li class="review-item">
                    <div class="review-avatar">ДП</div>
                    <div class="review-author">Дмитрий П.</div>
                    <div class="review-date">22 мая 2025</div>
                    <div class="review-text">
                        Отличный сервис! Использую как для работы, так и для личных дел. Особенно ценю возможность экспорта задач в календарь. Премиум-версия полностью оправдывает свою стоимость - дополнительные функции действительно полезны.
                    </div>
                </li>
                <li class="review-item">
                    <div class="review-avatar">ЕЛ</div>
                    <div class="review-author">Елена Л.</div>
                    <div class="review-date">10 июля 2025</div>
                    <div class="review-text">
                        Начала использовать сервис по рекомендации друзей и не пожалела. Помог организовать не только рабочие процессы, но и домашние дела. Теперь вся семья в курсе планов и обязанностей. Поддержка отвечает быстро и помогает решить любые вопросы.
                    </div>
                </li>
            </ul>
        </div>
        
        <div class="signature"></div>
    </div>
</body>
</html>