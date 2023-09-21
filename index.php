<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>ACME</title>
    <link rel="stylesheet" href="css/main.scss">
</head>
<?php

$connection = mysqli_connect("localhost", "root", "", "news");

if($connection == false){
    echo "Невозможно подключится к базе данных";
    echo mysqli_connect_errno();
    exit();
}

$id = $connection->real_escape_string($_GET['id']);

$query = mysqli_query($connection, "SELECT * FROM news12 ORDER BY id DESC ");

?>
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
<main class="main">
            <?php
            while($title = mysqli_fetch_assoc($query)){
                echo
                '<div class="main-content responsive-wrapper">
                    <article class="widget">';
                echo $title['name'],'<br>';
                echo '<p><a href=page.php?id='.$title['id'].'><img height="300" width="500" src="'.$title['img'].'"></a></p>';
                echo '<p>'.$title['user'].'</p>';
                echo '<p>'.$title['date'].'</p>';
                echo'</article>
                 </div>';
            }
            ?>
</main>
</body>

</html>

