<?php

$dsn = 'mysql:host=localhost; dbname=blogger';
$user = 'root';
$pass = 'secret';

try {
    $pdo = new PDO($dsn, $user, $pass);
    echo "connect";
} catch (PDOException $e) {
    echo 'connection error!' .  $e;
}
