<div class="content-block">
    <h1>TaskManager</h1>
    <p class="motto">"Организуй свое время - управляй своей жизнью"</p>
    <p>Наша система помогает командам и отдельным пользователям эффективно управлять задачами, проектами и временем.</p>
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