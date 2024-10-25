<?php
$host = 'localhost';
$db = 'kelambim_yacinta';
$user = 'kelambim_yacinta';
$pass = 'KelambimYacinta';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error connecting to database: " . $e->getMessage());
}
