<?php
session_start();
//session_destroy();

unset($_SESSION['author']);

header('Location: index.php');

?>
