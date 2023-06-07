<?php

require_once 'db.php';


if (isset($_POST['email'], $_POST['password'])) {
    $sql = 'INSERT INTO Author set email = :email, password = :password, Name = :name, Surname = :surname, role = 0';

    $passHash = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':email' => $_POST['email'],
        ':password' => $passHash,
        ':name' => $_POST['name'],
        ':surname' => $_POST['surname']
    ]);
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
    <title>Registrace</title>

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
    <div class="log">
        <a href="login.php">
            Login
        </a>
        <div>
        </div>
    </div>
</div>
<div class="action">
    <form action="" method="post">
    <h1 class="art">Registrace</h1>
    <div>
        <label>
            Přihlašovací email
            <br>
            <input type="email" required name="email" placeholder="Zadejte email">
        </label>
    </div>
    <div>
        <label>
            Heslo
            <br>
            <input type="password" required name="password" placeholder="Zadejte heslo">
        </label>
    </div>
    <div>
        <label>
            Jméno
            <br>
            <input type="text" required name="name">
        </label>
    </div>
    <div>
        <label>
            Příjmení
            <br>
            <input type="text" required name="surname">
        </label>
    </div>
    <div>
        <button type="submit" class="button-19">Registrovat se</button>
        <a href="login.php" class="button-19">
            <!--            <button type="button" class="button-19">Mám účet</button>-->
            Mám ucet
        </a>
    </div>
    </form>

</body>
</html>
