<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>ACME</title>
    <link rel="stylesheet" href="css/main.scss">
</head>
<header class="header-outer">
    <div class="header-inner responsive-wrapper">
        <div class="header-logo">
            <img src="https://assets.codepen.io/285131/acme-2.svg" />
        </div>
        <nav class="header-navigation">
            <a href="index.php">Главная</a>
            <a href="add.php">Создать новость</a>
            <a href="edit.php">Редактирование новости</a>
            <a href="edit.php">Удаление новости</a>
            <button>Menu</button>
        </nav>
    </div>
</header>
<body>
<?php
$host = 'localhost';  // Хост, у нас все локально
$user = 'root';    // Имя созданного вами пользователя
$pass = ''; // Установленный вами пароль пользователю
$db_name = 'news';   // Имя базы данных
$link = mysqli_connect($host, $user, $pass, $db_name); // Соединяемся с базой

// Ругаемся, если соединение установить не удалось
if (!$link) {
    echo 'Не могу соединиться с БД. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error();
    exit;
}

//Если переменная Name передана
if (isset($_POST["Name"])) {
    //Если это запрос на обновление, то обновляем
    if (isset($_GET['red_id'])) {
        $name = $link->real_escape_string($_POST["name"]);
        $user = $link->real_escape_string($_POST["user"]);
        $text = $link->real_escape_string($_POST["text"]);
        $img = $link->real_escape_string($_POST["img"]);
        $sql = mysqli_query($link, "UPDATE `news12` SET `Name` = '{$_POST['Name']}',`user` = '{$_POST['user']}' ,`text` = '{$_POST['text']}' ,`img` = '{$_POST['img']}' ,`date` = '{$_POST['date']}' WHERE `ID`={$_GET['red_id']}");
    } else {
        //Иначе вставляем данные, подставляя их в запрос
        $sql = mysqli_query($link, "INSERT INTO `news12` (`Name`, `user`, `text`, `img`, `date`) VALUES ('{$_POST['Name']}', '{$_POST['user']}', '{$_POST['text']}', '{$_POST['img']}', '{$_POST['date']}')");
    }

    //Если вставка прошла успешно
    if ($sql) {
        echo '<p>Успешно!</p>';
    } else {
        echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
    }
}

if (isset($_GET['del_id'])) {
    //проверяем, есть ли переменная
    //удаляем строку из таблицы
    $id = $link->real_escape_string($_GET['del_id']);
    $sql = mysqli_query($link, "DELETE FROM `news12` WHERE `ID` = {$_GET['del_id']}");
    if ($sql) {
        echo "<p>Новость удалена.</p>";
    } else {
        echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';
    }
}

//Если передана переменная red_id, то надо обновлять данные. Для начала достанем их из БД
if (isset($_GET['red_id'])) {
    $id = $link->real_escape_string($_GET['red_id']);
    $sql = mysqli_query($link, "SELECT `ID`, `Name`, `user`, `text`, `img`, `date` FROM `news12` WHERE `ID`={$_GET['red_id']}");
    $news12 = mysqli_fetch_array($sql);
}
?>
<main class="main">
    <div class="main-content responsive-wrapper">
        <article class="widget">
<form action="" method="post">
    <table>
        <tr>
            <td>Название новости:</td>
            <td><input type="text" name="Name" value="<?= isset($_GET['red_id']) ? $news12['Name'] : ''; ?>"></td>
        </tr>
        <tr>
            <td>Пользователь:</td>
            <td><input type="text" name="user" value="<?= isset($_GET['red_id']) ? $news12['user'] : ''; ?>"></td>
        </tr>
        <tr>
            <td>Текст новости:</td>
            <td><input type="text" name="text" value="<?= isset($_GET['red_id']) ? $news12['text'] : ''; ?>"></td>
        </tr>
        <tr>
            <td>Превью новости:</td>
            <td><input type="text" name="img" value="<?= isset($_GET['red_id']) ? $news12['img'] : ''; ?>"></td>
        </tr>
        <tr>
            <td>Дата созданиея новости:</td>
            <td><input type="text" name="date"  value="<?= isset($_GET['red_id']) ? $news12['date'] : ''; ?>"></td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" value="OK"></td>
        </tr>
    </table>
</form>
        </article>
    </div>
</main>
<table border='1'>
    <tr>
        <td>Идентификатор</td>
        <td>Название новости</td>
        <td>Пользователь</td>
        <td>Текст новости</td>
        <td>Превью новости</td>
        <td>Дата созданиея новости</td>
        <td>Удаление</td>
        <td>Редактирование</td>
    </tr>
    <?php
    $sql = mysqli_query($link, 'SELECT `ID`, `Name`, `user`, `text`, `img`, `date` FROM `news12`');
    while ($result = mysqli_fetch_array($sql)) {
        echo '<tr>' .
            "<td>{$result['ID']}</td>" .
            "<td>{$result['Name']}</td>" .
            "<td>{$result['user']}</td>" .
            "<td>{$result['text']}</td>" .
            "<td>{$result['img']}</td>" .
            "<td>{$result['date']}</td>" .
            "<td><a href='?del_id={$result['ID']}'>Удалить</a></td>" .
            "<td><a href='?red_id={$result['ID']}'>Изменить</a></td>" .
            '</tr>';
    }
    ?>
</table>
</body>
</html>