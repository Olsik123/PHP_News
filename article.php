<?php

session_start();
require_once 'db.php';
if (isset($_GET['id'])) {


    $sql = 'SELECT ar.Id as arId, au.Id as auId, c.Id as cId, ar.Headline as Headline, ar.SmallText as Small, ar.BigText as Big, ar.CreatedAt as CTime, au.Name as Name, au.Surname as Surname, c.Name as Category FROM Articles ar
             INNER JOIN Author au on ar.IdAuthor = au.Id
             INNER JOIN Category c on c.Id = ar.IdCategory
             where ar.Id = :id';

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':id' => $_GET['id']
    ]);
    $article = $stmt->fetch();
} else {
    header("Location: index.php");
    die();
}
if ($article === false) {
    header("Location: index.php");
    die();
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
    <title>Články</title>
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
<main>
    <h1 class="art"><?= $article['Headline'] ?></h1>
    <div class="info">

        <div> <?= (new DateTime($article["CTime"]))->format("d.m.Y H:i") ?> </div>

        <a class="bl" href="authors.php?id=<?= $article['auId'] ?>">
            <div> <?= $article['Name'] . " " . $article['Surname'] ?> </div>
        </a>
        <div>Kategorie:
            <a class="blu" href="categories.php?id=<?= $article['cId'] ?>">
                <?= $article['Category'] ?>
            </a>
        </div>

    </div>
    <div class="">
        <div class="smallT"><?= $article['Big'] ?></div>


    </div>
</main>

</body>
</html>