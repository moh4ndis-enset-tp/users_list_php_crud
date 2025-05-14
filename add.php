<?php
$name =$_POST['name'];
$email = $_POST['email'];
$pass = $_POST['pass'];
$role = $_POST['role'];

$pdo = new PDO(
    "mysql: host=localhost;dbname=enset_2025",
    "root",
    ""
);

$sql = "INSERT INTO users (name,email,pass,role) VALUES('$name', '$email', '$pass', '$role')";
 $stmt = $pdo->query($sql);

 header('Location: /');