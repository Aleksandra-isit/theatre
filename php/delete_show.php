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

// Запрос для получения списка всех постановок
$show_query = "SELECT id_show, title FROM show_ChAE";
$show_result = mysqli_query($connect, $show_query);

if (!$show_result) {
    die("Ошибка запроса к базе данных: " . mysqli_error($connect));
}

// Обработка отправки формы удаления
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["show_id"]) && !empty($_POST["show_id"])) {
        $show_id = $_POST["show_id"];

        // Запрос для удаления выбранной постановки
        $delete_query = "DELETE FROM show_ChAE WHERE id_show = $show_id";
        $delete_result = mysqli_query($connect, $delete_query);

        if ($delete_result) {
            header("Location: admin_panel.php"); // Перенаправление на главную страницу администратора
            exit();
        } else {
            echo "Ошибка удаления постановки: " . mysqli_error($connect);
        }
    } else {
        echo "Не выбрана постановка для удаления";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Удаление постановки</title>
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="page">
  <div class="container">
    <h2>Выберите постановку для удаления:</h2>
    <form method="POST" class="form__admin">
      <select class="form__input" name="show_id">
        <?php while ($row = mysqli_fetch_assoc($show_result)) { ?>
          <option value="<?php echo $row['id_show']; ?>"><?php echo $row['title']; ?></option>
        <?php } ?>
      </select>
      <input class="form__input admin__link" type="submit" value="Удалить">
    </form>
    <a class="admin__link" href="admin_panel.php">Панель Администратора</a>
  </div>
</body>
</html>

<?php mysqli_close($connect); ?>
