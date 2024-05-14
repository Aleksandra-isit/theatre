<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Подключение к базе данных
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $database = "theatre";

    $connect = mysqli_connect($host, $dbUsername, $dbPassword, $database);

    if (!$connect) {
        echo json_encode(['status' => 'error', 'message' => 'Ошибка подключения к базе данных']);
        exit();
    }

    // Запрос на получение данных пользователя по email
    $sql = "SELECT * FROM client_ChAE WHERE email = '$email'";
    $result = mysqli_query($connect, $sql);

    if(mysqli_num_rows($result) > 0){
        $userData = mysqli_fetch_assoc($result);

        if(password_verify($password, $userData['password_hash'])){
            $_SESSION['user_id'] = $userData['id_client'];
            echo json_encode(['status' => 'success', 'user_id' => $_SESSION['user_id']]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Неверный пароль']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Пользователь с таким email не найден']);
    }

    mysqli_close($connect);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Метод не поддерживается']);
}
?>
