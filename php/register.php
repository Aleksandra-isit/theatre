<?php
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    $data = json_decode(file_get_contents('php://input'), true);

    $firstName = isset($data['first_name']) ? $data['first_name'] : '';
    $lastName = isset($data['last_name']) ? $data['last_name'] : '';
    $email = isset($data['email']) ? $data['email'] : '';
    $phoneNumber = isset($data['phone_number']) ? $data['phone_number'] : '';
    $password = isset($data['password']) ? $data['password'] : '';

    // Проверка на пустые значения
    if (empty($firstName) || empty($lastName) || empty($email) || empty($phoneNumber) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Все поля должны быть заполнены'], JSON_UNESCAPED_UNICODE);
        exit();
    }

    // Подключение к базе данных
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $database = "theatre";

    $connect = mysqli_connect($host, $dbUsername, $dbPassword, $database);

    // Проверка подключения
    if (!$connect) {
        echo json_encode(['status' => 'error', 'message' => 'Ошибка подключения к базе данных'], JSON_UNESCAPED_UNICODE);
        exit();
    }

    // Хэширование пароля
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Проверка на существование пользователя с таким email
    $sql_check = "SELECT * FROM client_ChAE WHERE email = '$email'";
    $result_check = mysqli_query($connect, $sql_check);

    if (mysqli_num_rows($result_check) > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Пользователь с таким email уже существует'], JSON_UNESCAPED_UNICODE);
        exit();
    }

    // Добавление нового пользователя
    $sql = "INSERT INTO client_ChAE (first_name, last_name, email, phone_number, password_hash) VALUES ('$firstName', '$lastName', '$email', '$phoneNumber', '$hashedPassword')";

    if (mysqli_query($connect, $sql)) {
        $_SESSION['user_id'] = mysqli_insert_id($connect); // Получить ID нового пользователя
        echo json_encode(['status' => 'success', 'user_id' => $_SESSION['user_id']], JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Ошибка регистрации'], JSON_UNESCAPED_UNICODE);
    }

    mysqli_close($connect);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Метод не поддерживается'], JSON_UNESCAPED_UNICODE);
}
?>
