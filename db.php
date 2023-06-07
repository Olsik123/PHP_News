<?php

$conn = new PDO('mysql:host=host;dbname=db', 'name', '123456', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);
$conn->query('SET NAMES utf8');
