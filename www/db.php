<?php
$dbhost = 'mariadb';
$dbname = 'dierenasiel';
$dbuser = 'user';
$dbpass = 'password';

try {
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    header('Location: 500.php');
    exit;
}
