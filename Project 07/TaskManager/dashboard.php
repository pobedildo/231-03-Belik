<?php
require_once 'config.php';


if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task_text'])) {
    $taskText = trim($_POST['task_text']);
    $userId = $_SESSION['user_id'];
    
    if (!empty($taskText)) {
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO tasks (user_id, text) VALUES (?, ?)");
        $stmt->execute([$userId, $taskText]);
    }
    header('Location: dashboard.php');
    exit;
}


if (isset($_GET['toggle_task'])) {
    $taskId = (int)$_GET['toggle_task'];
    $userId = $_SESSION['user_id'];
    
    $db = getDB();
    $stmt = $db->prepare("UPDATE tasks SET completed = NOT completed WHERE id = ? AND user_id = ?");
    $stmt->execute([$taskId, $userId]);
    
    header('Location: dashboard.php');
    exit;
}


if (isset($_GET['delete_task'])) {
    $taskId = (int)$_GET['delete_task'];
    $userId = $_SESSION['user_id'];
    
    $db = getDB();
    $stmt = $db->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
    $stmt->execute([$taskId, $userId]);
    
    header('Location: dashboard.php');
    exit;
}


$db = getDB();
$stmt = $db->prepare("SELECT id, text, completed FROM tasks WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Дашборд</title>
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
        .navbar a:nth-child(2) {
            color: #007bff;
        }
        .content {
            padding: 30px;
            max-width: 800px;
            margin: 0 auto;
        }
        .date {
            font-size: 1.5em;
            margin-bottom: 30px;
        }
        .tasks-section {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .tasks-section h2 {
            margin-top: 0;
        }
        .no-tasks {
            color: #6c757d;
            font-style: italic;
            margin: 20px 0;
        }
        .add-task {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }
        .task-list {
            list-style-type: none;
            padding: 0;
        }
        .task-item {
            background: white;
            padding: 10px 15px;
            margin-bottom: 10px;
            border-radius: 4px;
            border-left: 4px solid #007bff;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .task-actions {
            display: flex;
            gap: 10px;
        }
        .task-actions a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
        .task-actions button {
            border: none;
            background: none;
            cursor: pointer;
            font-size: 1em;
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
        .task-item[data-completed="true"] {
            opacity: 0.6;
            text-decoration: line-through;
            border-left-color: #28a745;
        }
        .complete-task {
            color: #28a745 !important;
        }

        .delete-task {
            color: #dc3545 !important;
        }
        .add-task-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            border: none;
            margin-bottom: 20px;
        }
        .task-input-container {
            display: none;
            margin-bottom: 20px;
        }
        
        .task-input {
            width: 70%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-right: 10px;
        }
        
        .save-task {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .cancel-task {
            padding: 10px 20px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
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
        <div class="date">Сегодня</div>
        
        <div class="tasks-section">
            <h2>Мои задачи</h2>
            
            
            <button class="add-task-btn" id="addTaskBtn">Добавить задачу</button>
            
            
            <div class="task-input-container" id="taskInputContainer">
                <form method="POST" action="dashboard.php" style="display: flex; align-items: center;">
                    <input type="text" class="task-input" name="task_text" placeholder="Введите задачу..." required>
                    <button type="submit" class="save-task">Сохранить</button>
                    <button type="button" class="cancel-task" id="cancelTaskBtn">Отмена</button>
                </form>
            </div>
            
            
            <?php if (empty($tasks)): ?>
                <div class="no-tasks">У вас пока нет задач</div>
            <?php else: ?>
                <ul class="task-list">
                    <?php foreach ($tasks as $task): ?>
                        <li class="task-item" data-task-id="<?= $task['id'] ?>">
                            <span style="<?= $task['completed'] ? 'text-decoration: line-through; opacity: 0.6;' : '' ?>">
                                <?= htmlspecialchars($task['text']) ?>
                            </span>
                            <div class="task-actions">
                                <a href="dashboard.php?toggle_task=<?= $task['id'] ?>" class="complete-task">✓</a>
                                <a href="dashboard.php?delete_task=<?= $task['id'] ?>" class="delete-task">✕</a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        
        <div class="signature"></div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const addTaskBtn = document.getElementById('addTaskBtn');
        const taskInputContainer = document.getElementById('taskInputContainer');
        const cancelTaskBtn = document.getElementById('cancelTaskBtn');

        
        addTaskBtn.addEventListener('click', function() {
            taskInputContainer.style.display = 'block';
            addTaskBtn.style.display = 'none';
            taskInputContainer.querySelector('input').focus();
        });

       
        cancelTaskBtn.addEventListener('click', function() {
            taskInputContainer.style.display = 'none';
            addTaskBtn.style.display = 'inline-block';
            taskInputContainer.querySelector('input').value = '';
        });
    });
</script>
    
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="logout.php" class="logout-btn">Выйти</a>
    <?php endif; ?>
</body>
</html>