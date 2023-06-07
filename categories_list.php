<?php

session_start();
require_once 'db.php';


$sql = 'SELECT * from Category';

$stmt = $conn->prepare($sql);
$stmt->execute();
$cat = $stmt->fetchAll();
$show = 0;
if (isset($_SESSION['author']))
{
    if (($_SESSION['author']['role'] == 1))
    {
        $show = 1;
    }
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
    <title>Autoři</title>
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
    <?php if (($show == 1)): ?>
        <h1 class="art">Kategorie:</h1>
        <a href="categories_Add.php">
            <button class="button-19">Přidat kategorii</button>
        </a>
        <div>
            <table>
                <thead>
                <th>Název</th>
                <th>Upravit</th>
                <th>Smazat</th>
                </thead>
                <tbody>
                <?php foreach ($cat as $c): ?>
                    <tr>
                        <td><a class="bl" href="categories.php?id=<?= $c['Id'] ?>"> <?= $c['Name'] ?>  </a></td>
                        <td><a class="bl" href="categories_Edit.php?id=<?= $c['Id'] ?>"> Upravit </a></td>
                        <td><a class="bl" href="categories_Delete.php?id=<?= $c['Id'] ?>"> Smazat </a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <h1 class="art">Kategorie:</h1>

        <div>
            <table>
                <thead>
                <th>Název</th>

                </thead>
                <tbody>
                <?php foreach ($cat as $c): ?>
                    <tr>
                        <td><a class="bl" href="categories.php?id=<?= $c['Id'] ?>"> <?= $c['Name'] ?>  </a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <?php endif; ?>

</main>

</body>
</html>