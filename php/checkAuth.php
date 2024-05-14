<?php
session_start();

$response = [];

if(isset($_SESSION['user_id'])) {
    $response['status'] = 'authorized';
    $response['user_id'] = $_SESSION['user_id'];
} else {
    $response['status'] = 'unauthorized';
}

echo json_encode($response);
?>
