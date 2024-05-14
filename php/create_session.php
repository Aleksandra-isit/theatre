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

// Запрос для получения списка театров
$theatre_query = "SELECT id_theatre, name FROM theatre_ChAE";
$theatre_result = mysqli_query($connect, $theatre_query);

// Запрос для получения списка спектаклей
$show_query = "SELECT id_show, title FROM show_ChAE";
$show_result = mysqli_query($connect, $show_query);

// Проверка наличия театров
if (!$theatre_result || !$show_result) {
    die("Ошибка запроса к базе данных: " . mysqli_error($connect));
}

// Обработка отправки формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из формы
    $show_id = $_POST["performance_id"]; // Название спектакля
    $date_time = $_POST["date_time"]; // Дата и время
    $theatre_id = $_POST["theatre_id"]; // ID театра
    $available_seats = $_POST["available_seats"]; // Количество доступных мест
    $ticket_price = $_POST["ticket_price"]; // Цена билета
    $status = "active"; // По умолчанию active
    $duration = "";
    $venue = "";
    $performance_name = "";

    // Получение названия спектакля из таблицы show_ChAE
    $show_query = "SELECT title FROM show_ChAE WHERE id_show = '$show_id'";
    $show_result = mysqli_query($connect, $show_query);

    if (!$show_result) {
        die("Ошибка запроса к базе данных: " . mysqli_error($connect));
    }

    if (mysqli_num_rows($show_result) > 0) {
        $row = mysqli_fetch_assoc($show_result);
        $performance_name = $row['title'];

        // Получение длительности спектакля из таблицы show_ChAE
        $duration_query = "SELECT duration FROM show_ChAE WHERE title = '$performance_name'";
        $duration_result = mysqli_query($connect, $duration_query);

        if (!$duration_result) {
            die("Ошибка запроса к базе данных: " . mysqli_error($connect));
        }

        if (mysqli_num_rows($duration_result) > 0) {
            $row = mysqli_fetch_assoc($duration_result);
            $duration = $row['duration'];

            // Получение места проведения из таблицы theatre_ChAE
            $venue_query = "SELECT name FROM theatre_ChAE WHERE id_theatre = '$theatre_id'";
            $venue_result = mysqli_query($connect, $venue_query);

            if (!$venue_result) {
                die("Ошибка запроса к базе данных: " . mysqli_error($connect));
            }

            if (mysqli_num_rows($venue_result) > 0) {
                $row = mysqli_fetch_assoc($venue_result);
                $venue = $row['name'];

                // Добавление нового сеанса в базу данных
                $insert_query = "INSERT INTO session_ChAE (performance_name, start_date_time, duration, venue, theatre_ChAE_id_theatre, available_seats, ticket_price, status, show_ChAE_id_show)
                                 VALUES ('$performance_name', '$date_time', '$duration', '$venue', '$theatre_id', '$available_seats', '$ticket_price', '$status', '$show_id')";
                $insert_result = mysqli_query($connect, $insert_query);

                if ($insert_result) {
                    echo "Сеанс успешно добавлен!";

                    // Получение последнего вставленного идентификатора сеанса
                    $session_id = mysqli_insert_id($connect);

                    // Добавление записи в таблицу theatre_ChAE_has_show_ChAE
                    $relation_query = "INSERT INTO theatre_ChAE_has_show_ChAE (theatre_ChAE_id_theatre, show_ChAE_id_show)
                                       VALUES ('$theatre_id', '$show_id')";
                    $relation_result = mysqli_query($connect, $relation_query);

                    if (!$relation_result) {
                        echo "Ошибка при добавлении записи в таблицу: " . mysqli_error($connect);
                    }
                } else {
                    echo "Ошибка добавления сеанса: " . mysqli_error($connect);
                }
            } else {
                echo "Ошибка получения места проведения из базы данных.";
            }
        } else {
            echo "Ошибка получения длительности спектакля из базы данных.";
        }
    } else {
        echo "Спектакль с данным идентификатором не найден.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создание сеанса</title>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="page">
  <div class="container">
    <h2>Создать новый сеанс</h2>
    <form method="POST" class="form__admin">
      <label for="performance_name">Название спектакля:</label>
      <select class="form__input" id="performance_id" name="performance_id">
        <?php while ($row = mysqli_fetch_assoc($show_result)) { ?>
          <option value="<?php echo $row['id_show']; ?>"><?php echo $row['title']; ?></option>
        <?php } ?>
      </select>

      <label for="date_time">Дата и время:</label>
      <input class="form__input" type="datetime-local" id="date_time" name="date_time" required>

      <label for="theatre_id">Театр:</label>
      <select class="form__input" id="theatre_id" name="theatre_id">
        <?php while ($row = mysqli_fetch_assoc($theatre_result)) { ?>
          <option value="<?php echo $row['id_theatre']; ?>"><?php echo $row['name']; ?></option>
        <?php } ?>
      </select>

      <label for="available_seats">Количество доступных мест:</label>
      <input class="form__input" type="number" id="available_seats" name="available_seats" required>

      <label for="ticket_price">Цена билета:</label>
      <input class="form__input" type="text" id="ticket_price" name="ticket_price" required>

      <input class="form__input admin__link" type="submit" value="Создать">
    </form>

    <a class="admin__link" href="admin_panel.php">Панель Администратора</a>

  </div>
</body>
</html>

<?php mysqli_close($connect); ?>
