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
$select_query = "SELECT id_show, title FROM show_ChAE";
$result = mysqli_query($connect, $select_query);

if (!$result) {
    die("Ошибка запроса к базе данных: " . mysqli_error($connect));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Show</title>
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="page">
  <div class="container">
    <h1>Edit Show</h1>
    <form action="edit_show_form.php" method="GET" class="form__admin">
      <label for="show">Выберите постановку для редактирования:</label>
      <select class="form__input" name="show" id="show">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
          <option value="<?php echo $row['id_show']; ?>"><?php echo $row['title']; ?></option>
        <?php } ?>
      </select>
      <button class="form__input admin__link" type="submit">Редактировать</button>
    </form>
    <a class="admin__link" href="admin_panel.php">Панель Администратора</a>

  </div>
</body>
</html>

<?php mysqli_close($connect); ?>
