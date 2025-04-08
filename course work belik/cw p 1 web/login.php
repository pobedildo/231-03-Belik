<?php
require_once 'config.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    
    $errors = [];
    
    if (empty($name)) {
        $errors[] = 'Имя обязательно для заполнения';
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Укажите корректный email';
    }
    
    if (strlen($password) < 6) {
        $errors[] = 'Пароль должен содержать не менее 6 символов';
    }
    
    if ($password !== $confirm_password) {
        $errors[] = 'Пароли не совпадают';
    }
    
    
    $db = getDB();
    $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->fetch()) {
        $errors[] = 'Пользователь с таким email уже зарегистрирован';
    }
    
    
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $db->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $hashed_password]);
        
        $_SESSION['user_id'] = $db->lastInsertId();
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;
        
        header('Location: dashboard.php');
        exit;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login-email'])) {
    $email = trim($_POST['login-email']);
    $password = $_POST['login-password'];
    
    $db = getDB();
    $stmt = $db->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        
        header('Location: dashboard.php');
        exit;
    } else {
        $errors[] = 'Неверный email или пароль';
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
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
            text-align: center;
        }
        .auth-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .auth-form {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 300px;
        }
        .auth-form h2 {
            margin-top: 0;
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .form-submit {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1em;
        }
        .form-submit:hover {
            background-color: #0069d9;
        }
        .form-footer {
            text-align: center;
            margin-top: 15px;
            font-size: 0.9em;
        }
        .form-footer a {
            color: #007bff;
            text-decoration: none;
            cursor: pointer;
        }
        .login-form {
            display: none;
        }
        .register-form {
            display: block;
        }
    </style>
</head>

<?php if (!empty($errors)): ?>
    <div style="color: red; margin: 20px auto; max-width: 300px; text-align: center;">
        <?php foreach ($errors as $error): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<body>
    <div class="navbar">
        <a href="index.php">Главная</a>
        <a href="dashboard.php">Дашборд</a>
        <a href="tariffs.php">Тарифы</a>
        <a href="about.php">О продукте</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="dashboard.php">Личный кабинет</a>
        <?php else: ?>
            <a href="login.php">Войти\Зарегистрироваться</a>
        <?php endif; ?>
    </div>

    <div class="hero">
        <h1>Добро пожаловать!</h1>
        <p>Присоединяйтесь к нашему сервису и получите доступ ко всем возможностям</p>
    </div>

    <div class="auth-container">
        
<div class="auth-form register-form" id="registerForm">
    <h2>Регистрация</h2>
    <form action="login.php" method="POST">  
        <div class="form-group">
            <label for="reg-name">Имя</label>
            <input type="text" id="reg-name" name="name" required>
        </div>
        <div class="form-group">
            <label for="reg-email">Email</label>
            <input type="email" id="reg-email" name="email" required>
        </div>
        <div class="form-group">
            <label for="reg-password">Пароль</label>
            <input type="password" id="reg-password" name="password" required>
        </div>
        <div class="form-group">
            <label for="reg-confirm">Подтвердите пароль</label>
            <input type="password" id="reg-confirm" name="confirm_password" required>
        </div>
        <button type="submit" class="form-submit">Зарегистрироваться</button>
    </form>
    <div class="form-footer">
        Уже есть аккаунт? <a id="showLogin">Войдите</a>
    </div>
</div>


<div class="auth-form login-form" id="loginForm">
    <h2>Вход</h2>
    <form action="login.php" method="POST">  
        <div class="form-group">
            <label for="login-email">Email</label>
            <input type="email" id="login-email" name="login-email" required>
        </div>
        <div class="form-group">
            <label for="login-password">Пароль</label>
            <input type="password" id="login-password" name="login-password" required>  
        </div>
        <button type="submit" class="form-submit">Войти</button>
    </form>
    <div class="form-footer">
        Нет аккаунта? <a id="showRegister">Зарегистрируйтесь</a>
    </div>
</div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const registerForm = document.getElementById('registerForm');
            const loginForm = document.getElementById('loginForm');
            const showLogin = document.getElementById('showLogin');
            const showRegister = document.getElementById('showRegister');
            
            // Показываем форму входа при нажатии на "Уже есть аккаунт? Войдите"
            showLogin.addEventListener('click', function(e) {
                e.preventDefault();
                registerForm.style.display = 'none';
                loginForm.style.display = 'block';
            });
            
            // Показываем форму регистрации при нажатии на "Нет аккаунта? Зарегистрируйтесь"
            showRegister.addEventListener('click', function(e) {
                e.preventDefault();
                loginForm.style.display = 'none';
                registerForm.style.display = 'block';
            });
        });
    </script>
</body>
</html>