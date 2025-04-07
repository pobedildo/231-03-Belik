<div class="contact-info">
    <h2>Где нас найти?</h2>
    <p><strong>Юридический адрес:</strong> г. Москва, ул. Примерная, д. 123</p>
    <p><strong>Телефон:</strong> +7 (123) 456-78-90</p>
    <p><strong>Email:</strong> info@taskmanager.ru</p>
    
    <div class="social-links">
        <p>Мы в социальных сетях:</p>
        <a href="https://vk.com/yourprofile" target="_blank">ВКонтакте</a>
        <a href="https://t.me/yourprofile" target="_blank">Telegram</a>
    </div>
</div>

<nav class="main-menu">
    <div class="menu-container">
        <a href="index.php" class="logo-link">
            <img src="logo.png" alt="TaskManager Logo" class="logo">
        </a>
        
        <ul class="nav-links">
            <li><a href="about.php">О нас</a></li>
            <li><a href="services.php">Функции</a></li>
            <li><a href="contacts.php">Где нас найти?</a></li>
        </ul>
        
        <div class="auth-buttons">
            <?php if(!isset($_SESSION['user'])): ?>
                <a href="login.php" class="btn">Авторизация</a>
                <a href="register.php" class="btn">Регистрация</a>
            <?php else: ?>
                <a href="dashboard.php" class="btn">Личный кабинет</a>
            <?php endif; ?>
        </div>
    </div>
</nav>