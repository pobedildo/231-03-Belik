<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskManager - Система управления задачами</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f7fa;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .logo {
            width: 64px;
            height: 64px;
        }
        /* Дополнительные стили */
    </style>
</head>
<body>
    <div class="container">
        <header>
            <img src="logo.png" alt="TaskManager Logo" class="logo">
            <h1>TaskManager</h1>
            <p>Организуйте свои задачи эффективно</p>
        </header>

        <div class="auth-forms">
            <div class="login-form">
                <h2>Вход</h2>
                <form action="login.php" method="POST">
                    <div class="form-group">
                        <label for="phone">Телефон:</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Пароль:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit">Войти</button>
                </form>
            </div>

            <div class="register-form">
                <h2>Регистрация</h2>
                <form action="register.php" method="POST">
                    <div class="form-group">
                        <label for="reg-phone">Телефон:</label>
                        <input type="tel" id="reg-phone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="reg-password">Пароль:</label>
                        <input type="password" id="reg-password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Повторите пароль:</label>
                        <input type="password" id="confirm-password" name="confirm_password" required>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="policy" name="policy" required>
                        <label for="policy">Согласен с <a href="policy.pdf" target="_blank">политикой обработки персональных данных</a></label>
                    </div>
                    <button type="submit">Зарегистрироваться</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>