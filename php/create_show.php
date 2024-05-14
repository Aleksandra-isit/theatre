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

// Проверка наличия театров
if (!$theatre_result) {
    die("Ошибка запроса к базе данных: " . mysqli_error($connect));
}

// Обработка отправки формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получение данных из формы
    $title = $_POST["title"];
    $description = $_POST["description"];
    $genre = $_POST["genre"];
    $rating = $_POST["rating"];
    $image_url = $_POST["image_url"];
    $direction = $_POST["direction"];
    $cast = $_POST["cast"];
    $duration = $_POST["duration"];
    $theatre_id = $_POST["theatre_id"]; // ID театра

    // Добавление новой постановки в базу данных
    $insert_query = "INSERT INTO show_ChAE (title, description, gendre, rating, image_url, direction, cast, duration)
                     VALUES ('$title', '$description', '$genre', '$rating', '$image_url', '$direction', '$cast', '$duration')";
    $insert_result = mysqli_query($connect, $insert_query);

    if ($insert_result) {
        echo "Постановка успешно добавлена!";
    } else {
        echo "Ошибка добавления постановки: " . mysqli_error($connect);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создание постановки</title>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="page">
  <div class="container">
    <h2>Создать новую постановку</h2>
    <form method="POST" class="form__admin">
      <label for="title">Название:</label>
      <input class="form__input" type="text" id="title" name="title" required>

      <label for="description">Описание:</label>
      <textarea class="form__textarea form__input" id="description" name="description" required></textarea>

      <label for="genre">Жанр:</label>
      <input class="form__input" type="text" id="genre" name="genre" required>

      <label for="rating">Рейтинг:</label>
      <input class="form__input" type="text" id="rating" name="rating" required>

      <label for="rating">Ссылка на изображение:</label>
      <input class="form__input" type="text" id="image_url" name="image_url" required>

      <label for="direction">Режиссер:</label>
      <input class="form__input" type="text" id="direction" name="direction" required>

      <label for="cast">Актерский состав:</label>
      <textarea class="form__textarea form__input" id="cast" name="cast" required></textarea>

      <label for="duration">Длительность:</label>
      <input class="form__input" type="text" id="duration" name="duration" required>

      <label for="theatre_id">Театр:</label>
      <select class="form__input" id="theatre_id" name="theatre_id">
        <?php while ($row = mysqli_fetch_assoc($theatre_result)) { ?>
          <option value="<?php echo $row['id_theatre']; ?>"><?php echo $row['name']; ?></option>
        <?php } ?>
      </select>

      <input class="form__input admin__link" type="submit" value="Создать">
    </form>

    <a class="admin__link" href="admin_panel.php">Панель Администратора</a>

  </div>
</body>
</html>

<?php mysqli_close($connect); ?>
