<?php

session_start();
require_once 'db.php';


$sql = 'SELECT ar.Showned as sh, ar.Id as arId, au.Id as auId, c.Id as cId,  ar.Headline as Headline, ar.SmallText as Small, ar.BigText as Big, ar.CreatedAt as CTime, au.Name as Name, au.Surname as Surname, c.Name as Category  FROM Articles ar
             INNER JOIN Author au on ar.IdAuthor = au.Id
             INNER JOIN Category c on c.Id = ar.IdCategory
             WHERE ar.Showned = 1
             ORDER BY ar.CreatedAt desc 
             LIMIT 5';

$stmt = $conn->prepare($sql);
$stmt->execute();
$articles = $stmt->fetchAll();
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
    <h1 class="art">Články</h1>
    <h2 class="undertext">Nejžhavější novinky!</h2>
    <div class="whole">
        <?php foreach ($articles as $a): ?>
            <div class="articles">

                <div class="headline">
                    <a href="article.php?id=<?= $a['arId'] ?>">
                        <div>
                            <?= $a['Headline'] ?>
                        </div>
                    </a>
                </div>

                <div class="info">

                    <div> <?= (new DateTime($a["CTime"]))->format("d.m.Y H:i") ?> </div>

                    <a class="bl" href="authors.php?id=<?= $a['auId'] ?>">
                        <div> <?= $a['Name'] . " " . $a['Surname'] ?> </div>
                    </a>

                </div>
                <div class="smallT"><?= $a['Small'] ?></div>
                <div class="underArt">
                    <div class="">

                        <div>Kategorie:
                            <a class="blu" href="categories.php?id=<?= $a['cId'] ?>">
                                <?= $a['Category'] ?>
                            </a>
                        </div>

                    </div>
                    <div>
                        <a class="blu" href="article.php?id=<?= $a['arId'] ?>">
                            Číst dál →
                        </a>
                    </div>
                </div>

            </div>

        <?php endforeach; ?>
    </div>
</main>

</body>
</html>