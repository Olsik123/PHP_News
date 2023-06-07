<?php
require_once 'db.php';

session_start();

if (empty($_GET['id'])) {
    header('Location: index.php');
    die();
}
if (!(isset($_SESSION['author'])))
{
    header('Location: index.php');
    die();
}

if (isset($_GET['id'])) {

    $sql = 'SELECT * FROM Articles where Id = :id';

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':id' => $_GET['id']
    ]);
    $article = $stmt->fetch();
    if ($_SESSION['author']['Id'] == $article['IdAuthor'] || $_SESSION['author']['role'] == 1  )
    {
        $sql = 'DELETE FROM Articles where Id = :id';

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':id' => $_GET['id']
        ]);
        header('Location: article_Admin.php');
        die();
    }
    header('Location: article_Admin.php');
    die();

}
?>



