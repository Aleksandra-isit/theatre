<?php
define('FPDF_FONTPATH', '../fpdf/font/');
require('../fpdf/fpdf.php');

// Получаем данные сеанса постановки из POST-параметров
$id_session = $_POST['id_session'];
$duration = $_POST['duration'];
$title = $_POST['title'];
$ticket_price_ = $_POST['ticket_price'];
$contact_info = $_POST['contact_info'];
$theatre_name = $_POST['theatre_name'];
$addres = $_POST['addres'];

// Создаем экземпляр класса FPDF
$pdf = new FPDF();
$pdf->AddPage();

// Добавляем заголовок
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Ticket for Play', 0, 1, 'C');

// Добавляем информацию о спектакле
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Name: ' . $title, 0, 1);
$pdf->Cell(0, 10, 'Duration: ' . $duration, 0, 1);
$pdf->Cell(0, 10, 'Ticket price: ' . $ticket_price, 0, 1);
$pdf->Cell(0, 10, 'Contact_info: ' . $contact_info, 0, 1);
$pdf->Cell(0, 10, 'Theatre name: ' . $theatre_name, 0, 1);
$pdf->Cell(0, 10, 'Addres: ' . $addres, 0, 1);

// Добавляем информацию о сеансе постановки
$pdf->Cell(0, 10, 'Session ID: ' . $id_session, 0, 1);

// Выводим PDF в браузер или сохраняем в файл
$pdf->Output();
