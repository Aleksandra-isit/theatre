<?php
// Подключение к базе данных
$host = "localhost";
$username = "root";
$password = "";
$database = "theatre";

$connect = mysqli_connect($host, $username, $password, $database);

if (!$connect) {
    die("Ошибка подключения к базе данных: " . mysqli_connect_error());
}

// Получение id_session из POST-запроса
$id_session = $_POST['id_session'];
$title = $_POST['Title'];
$duration = $_POST['Duration'];
$ticket_price = $_POST['Ticket_price'];
$contact_info = $_POST['Contact_info'];
$theatre_name = $_POST['Theatre_name'];
$addres = $_POST['Addres'];

session_start();
$response = [];
$client_id = "";
$insert_relation_query = "";

if (isset($_SESSION['user_id'])) {
    $response['status'] = 'authorized';
    $response['user_id'] = $_SESSION['user_id'];
    $client_id = $response['user_id'];
} else {
    $response['status'] = 'unauthorized';
}

// Создание записи о покупке в базе данных
$insert_query = "INSERT INTO session_ChAE_has_client_ChAE (session_ChAE_id_session, client_ChAE_id_client) VALUES ($id_session, $client_id)";
$insert_query_result = mysqli_query($connect, $insert_query);

// Обновление количества билетов в базе данных
$update_query = "UPDATE session_ChAE SET available_seats = available_seats - 1 WHERE id_session = $id_session";
$update_result = mysqli_query($connect, $update_query);

$check_relation_query = "SELECT * FROM client_ChAE_has_theatre_ChAE WHERE client_ChAE_id_client = $client_id AND theatre_ChAE_id_theatre IN (SELECT theatre_ChAE_id_theatre FROM session_ChAE WHERE id_session = $id_session)";
$result = mysqli_query($connect, $check_relation_query);
if (mysqli_num_rows($result) == 0) {
    // Связь между клиентом и театром не существует, создаем её
    $insert_relation_query = "INSERT INTO client_ChAE_has_theatre_ChAE (client_ChAE_id_client, theatre_ChAE_id_theatre) SELECT $client_id, theatre_ChAE_id_theatre FROM session_ChAE WHERE id_session = $id_session";
    $insert_relation_query_result = mysqli_query($connect, $insert_relation_query);
} else {
    $insert_relation_query_result = true; // связь уже существует
}

if ($update_result && $insert_query_result && $insert_relation_query_result) {
    define('FPDF_FONTPATH', "../fpdf/font/");
    // Создание PDF с информацией о билете
    require('../fpdf/fpdf.php');

    // Создаем уникальное имя файла для каждого пользователя или покупки
    $pdf_filename = '../pdf/ticket_' . $client_id . '_' . time() . '.pdf';

    // Создаем экземпляр класса FPDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFillColor(199, 218, 254);
    $pdf->Rect(0, 0, $pdf->GetPageWidth(), $pdf->GetPageHeight(), 'F');

    $pdf->AddFont('Arial', '', 'arial.php');
    $pdf->SetFont('Arial');

    // Добавляем заголовок
    $pdf->Cell(0, 10, 'Билет', 0, 1, 'C');

    // Добавляем информацию о спектакле
    $pdf->Cell(0, 10, 'Название спектакля: ' . $title, 0, 1);
    $pdf->Cell(0, 10, 'Продолжительность: ' . $duration, 0, 1);
    $pdf->Cell(0, 10, 'Цена билета: ' . $ticket_price, 0, 1);
    $pdf->Cell(0, 10, 'Место проведения: ' . $theatre_name, 0, 1);
    $pdf->Cell(0, 10, 'Адрес: ' . $addres, 0, 1);
    $pdf->Cell(0, 10, 'Контактная информация: ' . $contact_info, 0, 1);

    $pdf->Image('../img/control.png', 15, $pdf->GetY() + 10, 180);

    // Сохраняем PDF на сервере
    $pdf->Output('F', $pdf_filename); // Сохраняем PDF с уникальным названием

    // Проверяем, создался ли файл
    if (file_exists($pdf_filename)) {
        // Возвращаем JSON-ответ на клиент
        echo json_encode(['status' => 'success', 'file' => $pdf_filename]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Не удалось создать файл PDF']);
    }
} else {
    // Ошибка при обновлении
    echo json_encode(['status' => 'error', 'message' => 'Ошибка при обновлении количества билетов']);
}

// Закрытие соединения с базой данных
mysqli_close($connect);
?>
