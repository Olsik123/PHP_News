<?php

session_start();

require_once 'db.php';

if (isset($_POST['email'],$_POST['password']))
{
    $sql = 'SELECT * FROM Author where email = :email';
    $stmt = $conn->prepare($sql);
    $stmt->execute([
            ':email' => $_POST['email']
    ]);

    $user = $stmt->fetch();

    IF ($user === false)
    {
        die('chybne prihlasovaci udaje');
    }
    $passCor = password_verify($_POST['password'], $user['password']);

    if(!$passCor)
    {
        die('chybne prihlasovaci udaje');
    }

    unset($user['password'],$user[2]);
    $_SESSION['author'] = $user;



    header('Location: index.php');
}



?>



<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Přihlášení</title>

    <link rel="stylesheet" href="CSS/index_s.css">
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
    <h1 class="art">Přihlášení</h1>

    <form action="" method="post">
        <div>
            <label>
                Email
                <br>
                <input type="text" name="email" required>
            </label>
        </div>
        <div>
            <label>
                Heslo
                <br>
                <input type="password" name="password" placeholder="Zadejte heslo" required>
            </label>
        </div>
        <div>
            <button class="button-19">Přihlásit se</button>
            <a href="register.php">
            <button type="button" class="button-19">Nemám účet</button>
            </a>
        </div>
    </form>
</div>

</body>
</html>
