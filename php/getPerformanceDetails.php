<?php
header('Content-Type: application/json; charset=utf-8');

$host = "localhost";
$username = "root";
$password = "";
$database = "theatre";

$connect = mysqli_connect($host, $username, $password, $database);

if (!$connect) {
    echo json_encode(['status' => 'error', 'message' => 'Ошибка подключения к базе данных']);
    exit();
}

$id_session = $_GET['id_session'];

$sql = "SELECT s.*, t.name AS theatre_name, t.addres, t.contact_info,
               se.start_date_time, se.duration, s.image_url, se.available_seats, se.ticket_price
        FROM session_ChAE AS se
        JOIN show_ChAE AS s ON se.show_ChAE_id_show = s.id_show
        JOIN theatre_ChAE_has_show_ChAE AS ts ON s.id_show = ts.show_ChAE_id_show
        JOIN theatre_ChAE AS t ON ts.theatre_ChAE_id_theatre = t.id_theatre
        WHERE se.id_session = $id_session AND se.status = 'active'";

$result = mysqli_query($connect, $sql);

if (!$result) {
    echo json_encode(['status' => 'error', 'message' => 'Ошибка выполнения запроса']);
    exit();
}

$data = mysqli_fetch_assoc($result);

echo json_encode(['status' => 'success', 'data' => $data]);

mysqli_close($connect);
?>
