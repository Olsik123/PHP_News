<?php

session_start();
require_once 'db.php';


$sql = 'SELECT * from Author';

$stmt = $conn->prepare($sql);
$stmt->execute();
$author = $stmt->fetchAll();
$show =0;
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
    <?php if ($show == 1): ?>
        <h1 class="art">Autoři:</h1>
        <div>
            <table>
                <thead>
                <th>Jméno a přijmení</th>
                <th>Upravit</th>
                <th>Smazat</th>
                </thead>
                <tbody>
                <?php foreach ($author as $a): ?>
                    <tr>
                        <td><a class="bl"
                               href="authors.php?id=<?= $a['Id'] ?>"> <?= $a['Name'] . ' ' . $a['Surname'] ?>  </a></td>
                        <td><a class="bl" href="authors_Edit.php?id=<?= $a['Id'] ?>"> Upravit </a></td>
                        <td><a class="bl" href="authors_Delete.php?id=<?= $a['Id'] ?>"> Smazat </a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <h1 class="art">Autoři:</h1>
        <div>
            <table>
                <thead>
                <th>Jméno a přijmení</th>

                </thead>
                <tbody>
                <?php foreach ($author as $a): ?>
                    <tr>
                        <td><a class="bl"
                               href="authors.php?id=<?= $a['Id'] ?>"> <?= $a['Name'] . ' ' . $a['Surname'] ?>  </a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <?php endif; ?>

</main>

</body>
</html>