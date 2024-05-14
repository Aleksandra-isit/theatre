<?php
header('Content-Type: text/html; charset=utf-8');

$host = "localhost";
$username = "root";
$password = "";
$database = "theatre";

$connect = mysqli_connect($host, $username, $password, $database);
mysqli_set_charset($connect, "utf8");

$sql = "SELECT * FROM client_ChAE";
$result = mysqli_query($connect, $sql);

$json_array = array();

while($data = mysqli_fetch_assoc($result)) {
    $json_array[] = $data;
}

echo json_encode($json_array, JSON_UNESCAPED_UNICODE);

mysqli_close($connect);
?>
