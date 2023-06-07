<?php

require_once 'db.php';
session_start();
if (!isset($_SESSION['author'])) {
    header('Location: index.php');
    die();
}
if (isset($_GET['id'])) {


    $sql = 'SELECT ar.Showned as sh, ar.Id as arId, au.Id as auId, c.Id as cId,
       ar.Headline as Headline, ar.SmallText as Small, ar.BigText as Big, ar.CreatedAt as CTime, 
       au.Name as Name, au.Surname as Surname, c.Name as Category  FROM Articles ar
             INNER JOIN Author au on ar.IdAuthor = au.Id
             INNER JOIN Category c on c.Id = ar.IdCategory
             WHERE ar.Id = :id';
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':id' => $_GET['id']
    ]);
    $article = $stmt->fetch();

    if ($_SESSION['author']['Id'] != $article['auId'] && $_SESSION['author']['role'] != 1) {
        header('Location: article_Admin.php');
        die();
    }

}

$sql = 'SELECT * from Author';
$stmt = $conn->prepare($sql);
$stmt->execute();
$authors = $stmt->fetchAll();

$sql = 'SELECT * from Category';
$stmt = $conn->prepare($sql);
$stmt->execute();
$cats = $stmt->fetchAll();

if (isset($_POST['autor'], $_POST['kategorie'], $_POST['headline'],
    $_POST['smallText'], $_POST['bigText'])) {

    $showned = 0;
    if (isset($_POST['sh'])) {
        $showned = 1;
    }

    $sql = 'UPDATE Articles SET IdAuthor = :autor, IdCategory = :kategorie, Headline = :headline,
                   SmallText = :smallText, BigText = :bigText, Showned = :sh
                   WHERE Id = :id';

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':id' => $_GET['id'],
        ':autor' => $_POST['autor'],
        ':kategorie' => $_POST['kategorie'],
        ':headline' => $_POST['headline'],
        ':smallText' => $_POST['smallText'],
        ':bigText' => $_POST['bigText'],
        ':sh' => $showned
    ]);

    header('Location: article_Admin.php');
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.4.1/tinymce.min.js"
            integrity="sha512-in/06qQzsmVw+4UashY2Ta0TE3diKAm8D4aquSWAwVwsmm1wLJZnDRiM6e2lWhX+cSqJXWuodoqUq91LlTo1EA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        tinymce.init({
            selector: '#smallText'
        });
        tinymce.init({
            selector: '#bigText'
        });
    </script>

    <title>Upravit článek</title>
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
    <h1 class="art">Upravit článek</h1>

    <form action="" method="post">
        <div class="l">
            <div class="up">
                <div>
                    <label>
                        <span>Autor</span>
                        <br>
                        <?php if ($_SESSION['author']['role'] == 1): ?>
                            <select name="autor" required>
                                <?php foreach ($authors as $a): ?>
                                    <?php if ($article['auId'] == $a['Id']) : ?>
                                        <option selected
                                                value="<?= $a['Id'] ?>"><?= $a['Name'] . ' ' . $a['Surname'] ?></option>
                                    <?php else: ?>
                                        <option value="<?= $a['Id'] ?>"><?= $a['Name'] . ' ' . $a['Surname'] ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        <?php else: ?>
                            <select disabled name="autor" required>
                                <option value="<?= $_SESSION['author']['Id'] ?>"><?= $_SESSION['author']['Name'] . ' ' . $_SESSION['author']['Surname'] ?></option>
                            </select>
                        <?php endif; ?>
                    </label>
                </div>
                <div>
                    <label>
                        <span>Kategorie</span>
                        <br>
                        <select name="kategorie" required>
                            <?php foreach ($cats as $c): ?>
                                <?php if ($c['Id'] == $article['cId']): ?>
                                    <option selected value="<?= $c['Id'] ?>"> <?= $c['Name'] ?> </option>
                                <?php else: ?>
                                    <option value="<?= $c['Id'] ?>"> <?= $c['Name'] ?> </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
            </div>
            <div>
                Nadpis
                <div>
                    <textarea class="bigI" name="headline" id="headline" cols="30" rows="5"
                              required><?= $article['Headline'] ?></textarea>
                </div>

            </div>
            Upoutaní na článek
            <div>
                <textarea name="smallText" id="smallText"><?= $article['Small'] ?></textarea>
            </div>
            Celý článek
            <div>
                <textarea name="bigText" id="bigText"><?= $article['Big'] ?></textarea>
            </div>
            <div>
                <label>
                    <label class="container"> Zveřejněno
                        <input type="checkbox"
                            <?php if ($article['sh'] == 1): ?>
                                checked
                            <?php endif; ?>
                               name="sh">
                        <span class="checkmark"></span>
                    </label>
                </label>
            </div>
            <div>
                <button class="button-19">Přidat</button>
            </div>
        </div>
    </form>
</div>

</body>
</html>