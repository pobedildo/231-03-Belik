<?php
require_once 'config.php';


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}


$db = getDB();
$stmt = $db->prepare("SELECT name, email FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_account'])) {
    
    $stmt = $db->prepare("DELETE FROM tasks WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    
    
    $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    
    
    session_destroy();
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
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
        .navbar a:nth-child(5) {
            color: #007bff;
        }
        .content {
            padding: 30px;
            max-width: 800px;
            margin: 0 auto;
        }
        .profile-header {
            text-align: center;
            margin-bottom: 40px;
        }
        .profile-title {
            font-size: 2em;
            margin-bottom: 10px;
        }
        .profile-subtitle {
            color: #6c757d;
            margin-bottom: 30px;
        }
        .profile-card {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .profile-info {
            margin-bottom: 20px;
        }
        .profile-info label {
            font-weight: bold;
            display: inline-block;
            width: 100px;
        }
        .profile-actions {
            margin-top: 30px;
            text-align: center;
        }
        .delete-btn {
            padding: 10px 20px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }
        .delete-btn:hover {
            background-color: #c82333;
        }
        .signature {
            margin-top: 50px;
            font-style: italic;
            text-align: center;
        }
        .logout-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            z-index: 1000;
        }
        .logout-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="index.php">Главная</a>
        <a href="dashboard.php">Дашборд</a>
        <a href="tariffs.php">Тарифы</a>
        <a href="about.php">О продукте</a>
        <a href="profile.php">Личный кабинет</a>
    </div>

    <div class="content">
        <div class="profile-header">
            <h1 class="profile-title">Личный кабинет</h1>
            <p class="profile-subtitle">Управление вашим профилем</p>
        </div>
        
        <div class="profile-card">
            <div class="profile-info">
                <label>Имя:</label>
                <span><?= htmlspecialchars($user['name']) ?></span>
            </div>
            <div class="profile-info">
                <label>Email:</label>
                <span><?= htmlspecialchars($user['email']) ?></span>
            </div>
            
            <div class="profile-actions">
                <form method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить свой профиль? Это действие нельзя отменить.');">
                    <button type="submit" name="delete_account" class="delete-btn">Удалить профиль</button>
                </form>
            </div>
        </div>
        
        <div class="signature"></div>
    </div>
    
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="logout.php" class="logout-btn">Выйти</a>
    <?php endif; ?>
</body>
</html>