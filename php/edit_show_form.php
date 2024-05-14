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
    $show_id = $_POST["show_id"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $genre = $_POST["genre"];
    $rating = $_POST["rating"];
    $image_url = $_POST["image_url"];
    $direction = $_POST["direction"];
    $cast = $_POST["cast"];
    $duration = $_POST["duration"];

    // Обновление записи в базе данных
    $update_query = "UPDATE show_ChAE SET title='$title', description='$description', genre='$genre', rating='$rating',
    image_url='$image_url', direction='$direction', cast='$cast', duration='$duration' WHERE id_show='$show_id'";
    $update_result = mysqli_query($connect, $update_query);

    if ($update_result) {
        echo "Информация о постановке успешно обновлена!";
    } else {
        echo "Ошибка обновления информации о постановке: " . mysqli_error($connect);
    }
}

// Получение ID выбранной постановки
$show_id = $_GET['show'];

// Запрос для получения информации о выбранной постановке
$select_query = "SELECT * FROM show_ChAE WHERE id_show = $show_id";
$result = mysqli_query($connect, $select_query);

if (!$result) {
    die("Ошибка запроса к базе данных: " . mysqli_error($connect));
}

// Получение данных о постановке
$row = mysqli_fetch_assoc($result);
$title = $row['title'];
$description = $row['description'];
$genre = $row['gendre'];
$rating = $row['rating'];
$image_url = $row['image_url'];
$direction = $row['direction'];
$cast = $row['cast'];
$duration = $row['duration'];
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
  <h1>Редактирование постановки</h1>
    <form action="" method="POST" class="form__admin">
      <input class="form__input" type="hidden" name="show_id" value="<?php echo $show_id; ?>">
      <label for="title">Название:</label>
      <input class="form__input" type="text" name="title" value="<?php echo $title; ?>" required>
      <!-- Добавьте остальные поля для редактирования информации о постановке -->

      <label for="description">Описание:</label>
      <textarea class="form__textarea form__input" id="description" name="description" required>
        <?php echo $description; ?>
      </textarea>

      <label for="genre">Жанр:</label>
      <input class="form__input" type="text" id="genre" name="genre" value="<?php echo $genre; ?>" required>

      <label for="rating">Рейтинг:</label>
      <input class="form__input" type="text" id="rating" name="rating" value="<?php echo $rating; ?>" required>

      <label for="rating">Ссылка на изображение:</label>
      <input class="form__input" type="text" id="image_url" name="image_url" value="<?php echo $image_url; ?>" required>

      <label for="direction">Режиссер:</label>
      <input class="form__input" type="text" id="direction" name="direction" value="<?php echo $direction; ?>" required>

      <label for="cast">Актерский состав:</label>
      <textarea class="form__textarea form__input" id="cast" name="cast" required>
      <?php echo $cast; ?>
      </textarea>

      <label for="duration">Длительность:</label>
      <input class="form__input" type="text" id="duration" name="duration" value="<?php echo $duration; ?>" required>

      <button type="submit" class="admin__link form__input">Сохранить изменения</button>
    </form>
    <a class="admin__link" href="edit_show.php">Страница редактирования</a>
  </div>

</body>
</html>

<?php mysqli_close($connect); ?>
