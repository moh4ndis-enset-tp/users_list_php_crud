<?php 

$id = $_GET['idd'];
$pdo = new PDO(
    "mysql: host=localhost;dbname=enset_2025",
    "root",
    ""
);

$sql = "DELETE FROM users WHERE idd=$id";

$stmt = $pdo->exec($sql);

header("location:/");