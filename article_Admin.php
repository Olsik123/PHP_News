<?php

session_start();
require_once 'db.php';

if (!(isset($_SESSION['author'])))
{
    header('Location: index.php');
    die();
}
$sql = 'SELECT ar.Showned as sh, ar.Id as arId, au.Id as auId, c.Id as cId,  ar.Headline as Headline, ar.SmallText as Small, ar.BigText as Big, ar.CreatedAt as CTime, au.Name as Name, au.Surname as Surname, c.Name as Category  FROM Articles ar
             INNER JOIN Author au on ar.IdAuthor = au.Id
             INNER JOIN Category c on c.Id = ar.IdCategory
             ORDER BY ar.CreatedAt desc ';

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
    <title>Admin člínky</title>
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
    <h1 class="art">Administrace článku</h1>
    <a href="article_Add.php">
        <button class="button-19">Přidat článek</button>
    </a>
    <div>
        <table>
            <thead>
            <th>Nadpis</th>
            <th>Autor</th>
            <th>Datum vytvoření</th>
            <th>Kategorie</th>
            <th>Zveřejněno</th>
            <th>Upravit</th>
            <th>Smazat</th>
            </thead>
            <tbody>
            <?php foreach ($articles as $a): ?>
                <tr>
                    <td><a class="bl" href="article.php?id=<?= $a['arId'] ?>">     <?= $a['Headline'] ?> </a></td>
                    <td><a class="bl"
                           href="authors.php?id=<?= $a['auId'] ?>"> <?= $a['Name'] . ' ' . $a['Surname'] ?>  </a></td>
                    <td><?= (new DateTime($a["CTime"]))->format("d.m.Y H:i") ?> </td>
                    <td><a class="bl" href="categories.php?id=<?= $a['cId'] ?>">  <?= $a['Category'] ?></a></td>
                    <td>
                        <?php if ($a['sh'] == 1): ?>
                            <div class="mid">
                                <img class="ic" src="icons/check.png" alt="">
                            </div>
                        <?php else: ?>
                            <div class="mid">
                                <img class="ic" src="icons/remove.png" alt="">
                            </div>
                        <?php endif; ?>
                    </td>
                    <?php if ($_SESSION['author']['Id'] == $a['auId'] || $_SESSION['author']['role'] == 1 ): ?>
                        <td><a class="bl" href="article_Edit.php?id=<?= $a['arId'] ?>"> Upravit </a></td>
                        <td><a class="bl" href="article_Delete.php?id=<?= $a['arId'] ?>"> Smazat </a></td>
                    <?php else: ?>
                    <td></td>
                    <td></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

</body>
</html>