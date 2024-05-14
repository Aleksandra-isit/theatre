<?php
session_start();

// Удаление сессии пользователя
unset($_SESSION['user_id']);
session_destroy();

echo json_encode(['status' => 'success']);
?>
