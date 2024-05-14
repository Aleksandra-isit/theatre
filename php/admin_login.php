<?php
session_start();

// Проверка имени пользователя и пароля
if ($_POST['username'] === 'admin' && $_POST['password'] === '1') {
    // Установка сессии администратора
    $_SESSION['admin'] = true;
    header('Location: admin_panel.php');
    exit();
} else {
    echo "Invalid username or password";
}
?>
