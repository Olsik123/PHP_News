<?php
require_once 'db.php';
session_start();
if (!($_SESSION['author']['role'] == 1))
{
    header('Location: index.php');
    die();
}
if (empty($_GET['id'])) {
    header('Location: index.php');
    die();
}
if (isset($_GET['id'])) {


    $sql = 'SELECT IdAuthor FROM Articles
            where IdAuthor = :id';

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':id' => $_GET['id']
    ]);
    $author = $stmt->fetchAll();

}
if ($author[0] == null) {
    $sql = 'DELETE FROM Author WHERE Id = :id';
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':id' => $_GET['id'],
    ]);
    header('Location: authors_list.php');
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
    <title>Smazaz autora</title>
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
<div class="m">
    <div class="alert">
        <span class="closebtn""></span>
        <h2>Autor má články! Vymažte je.</h2>
    </div>

    <div class="but">
        <a href="index.php">
            <button class="button-19">Články</button>
        </a>
        <a href="authors_list.php">
            <button class="button-19">Autoři</button>
        </a>
    </div>
</div>
</body>
</html>


