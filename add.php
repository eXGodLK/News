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
if (isset($_POST["name"]) && isset($_POST["user"]) && isset($_POST["text"])&& isset($_POST["img"])) {
    $conn = new mysqli("localhost", "root", "", "news");
    if($conn->connect_error){
        die("Ошибка: " . $conn->connect_error);
    }
    $name = $conn->real_escape_string($_POST["name"]);
    $user = $conn->real_escape_string($_POST["user"]);
    $text = $conn->real_escape_string($_POST["text"]);
    $img = $conn->real_escape_string($_POST["img"]);
    $now = date(" H : i : s d - m - Y "); // дата будет выводиться в формате "время, дата"
    $sql = "INSERT INTO news12 (name, img, user, text, date ) VALUES ('$name', '$img', '$user', '$text', '$now')";
    if($conn->query($sql)){
        echo "Success!<br><a href=add.php>Click here</a> to add more news.<br><a href=edit.php>Click here</a> to edit news.<br><a href=index.php>Click here</a> to return to the main page.')";
    } else{
        echo "Ошибка: " . $conn->error;
    }
    $conn->close();
}else{
    ?>
<main class="main">
    <div class="main-content responsive-wrapper">
        <article class="widget">
           <form name="form1" method="post" action="<? echo $PHP_SELF; ?>">
              <table width="50%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                <td width="50%">Название</td>
                <td><input name="name" type="text" id="name"></td>
                </tr>
                 <tr>
                <td>Фотография</td>
                <td><input name="img" type="text" id="img"></td>
                 </tr>
                  <tr>
                <td> </td>
                <td> </td>
                  </tr>
                  <tr>
                <td>Имя пользователя</td>
                <td><input name="user" type="text" id="user"></td>
                  </tr>
                  <tr>
                <td>Описание</td>
                <td><textarea name="text" id="text"></textarea></td>
                  </tr>
                  <tr>
                <td colspan="2"><div align="center">
                        <input name="hiddenField" type="hidden" value="add_n">
                        <input name="add" type="submit" id="add" value="Submit">
                    </div></td>
                  </tr>
              </table>
           </form>
        </article>
    </div>
</main>

<? } ?>
</body>
</html>