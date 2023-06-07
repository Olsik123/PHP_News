<?php

session_start();
require_once 'db.php';
if (!($_SESSION['author']['role'] == 1))
{
    header('Location: index.php');
    die();
}
if (isset($_POST['name'])) {

    $sql = 'INSERT INTO Category SET name = :name';

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':name' => $_POST['name']
    ]);

    header('Location: categories_list.php');
}

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="CSS/index_s.css">
    <title>Přidat kategorii</title>
</head>
<body>
<div class="navbar">
    <div>
        <a href="index.php">
            Zprávy
        </a>
        <div>

        </div>
    </div>
    <div>
        <a href="categories_list.php">
            Kategorie
        </a>
        <div>

        </div>
    </div>
    <div>
        <a href="authors_list.php">
            Autoři
        </a>
        <div>

        </div>
    </div>
    <?php if (isset($_SESSION['author'])): ?>
        <div>
            <a href="article_Admin.php">
                Administrace článků
            </a>
            <div>

            </div>
        </div>
        <div>
            <a href="article_Add.php">
                Přidat článek
            </a>
            <div>
            </div>
        </div>
    <?php endif; ?>
    <?php if (isset($_SESSION['author'])): ?>
        <div class="log">
            <?= $_SESSION['author']['Name'] ?>
            <?= $_SESSION['author']['Surname'] ?>
        </div>

        <div>
            <a href="logout.php"> Odhlásit se</a>
        </div>
    <?php else: ?>
        <div class="log">
            <a href="login.php">
                Přihlášení
            </a>

        </div>

    <?php endif; ?>
</div>
<div class="action">
    <h1 class="art">Přidat Kategorii</h1>
    <form action="" method="post">
        <div>
            <label>
                Název
                <br>
                <input type="text" name="name" required>
            </label>
        </div>
        <div>
            <button class="button-19">Přidat</button>
        </div>
    </form>
</div>


</body>
</html>