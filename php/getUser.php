<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userId = $_GET['id'];

    // Подключение к базе данных
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $database = "theatre";

    $connect = mysqli_connect($host, $dbUsername, $dbPassword, $database);

    // Запрос на получение данных пользователя
    $sql = "SELECT * FROM client_ChAE WHERE id_client = '$userId'";
    $result = mysqli_query($connect, $sql);

    if(mysqli_num_rows($result) > 0){
        $userData = mysqli_fetch_assoc($result);
        echo json_encode(['status' => 'success', 'data' => $userData]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Пользователь не найден']);
    }

    mysqli_close($connect);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Метод не поддерживается']);
}
?>
