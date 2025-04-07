<div class="slider-container">
    <div class="slider">
        <div class="slide">
            <img src="images/feature1.jpg" alt="Создание задач">
            <p>Интуитивное создание задач</p>
        </div>
        <div class="slide">
            <img src="images/feature2.jpg" alt="Категории задач">
            <p>Группировка задач по категориям</p>
        </div>
        <!-- Добавьте еще 8 слайдов -->
    </div>
    <button class="prev">←</button>
    <button class="next">→</button>
</div>

<script>
// JavaScript для слайдера
let currentSlide = 0;
const slides = document.querySelectorAll('.slide');
const totalSlides = slides.length;

function showSlide(n) {
    slides.forEach(slide => slide.style.display = 'none');
    currentSlide = (n + totalSlides) % totalSlides;
    slides[currentSlide].style.display = 'block';
}

document.querySelector('.prev').addEventListener('click', () => showSlide(currentSlide - 1));
document.querySelector('.next').addEventListener('click', () => showSlide(currentSlide + 1));

// Автоматическое переключение каждые 2 секунды
setInterval(() => showSlide(currentSlide + 1), 2000);

// Инициализация
showSlide(0);
</script>

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