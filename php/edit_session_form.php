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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из формы
    $session_id = $_POST["session_id"];
    $date_time = $_POST["date_time"];
    $available_seats = $_POST["available_seats"];
    $ticket_price = $_POST["ticket_price"];

    // Обновление записи в базе данных
    $update_query = "UPDATE session_ChAE SET start_date_time='$date_time', available_seats='$available_seats', ticket_price='$ticket_price' WHERE id_session='$session_id'";
    $update_result = mysqli_query($connect, $update_query);

    if ($update_result) {
        echo "Информация о сеансе успешно обновлена!";
    } else {
        echo "Ошибка обновления информации о сеансе: " . mysqli_error($connect);
    }
}

// Получение ID выбранной постановки
$session_id = $_GET['session'];

// Запрос для получения информации о выбранной постановке
$select_query = "SELECT performance_name, start_date_time, available_seats, ticket_price FROM session_ChAE WHERE id_session = $session_id";
$result = mysqli_query($connect, $select_query);

if (!$result) {
    die("Ошибка запроса к базе данных: " . mysqli_error($connect));
}

// Получение данных о постановке
$row = mysqli_fetch_assoc($result);
$title = $row['performance_name'];
$start_date_time = $row['start_date_time'];
$available_seats = $row['available_seats'];
$ticket_price = $row['ticket_price'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Show Form</title>
  <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../css/style.css">

</head>
<body class="page">
  <div class="container">
  <h1>Редактирование сеанса</h1>
    <form action="" method="POST" class="form__admin">
      <input class="form__input" type="hidden" name="session_id" value="<?php echo $session_id; ?>">
      <label for="title">Название:</label>
      <p class="admin__text" type="text" name="title" id="title"><?php echo $title; ?></p>
      <!-- Добавьте остальные поля для редактирования информации о постановке -->

      <label for="date_time">Дата и время:</label>
      <input class="form__input" type="datetime-local" id="date_time" name="date_time" value="<?php echo $start_date_time; ?>" required>

      <label for="available_seats">Количество доступных мест:</label>
      <input class="form__input" type="number" id="available_seats" name="available_seats" value="<?php echo $available_seats; ?>" required>

      <label for="ticket_price">Цена билета:</label>
      <input class="form__input" type="text" id="ticket_price" name="ticket_price" value="<?php echo $ticket_price; ?>" required>

      <button type="submit" class="admin__link form__input">Сохранить изменения</button>
    </form>
    <a class="admin__link" href="edit_show.php">Страница редактирования</a>
  </div>

</body>
</html>

<?php mysqli_close($connect); ?>
