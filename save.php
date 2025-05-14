<?php
$id = $_POST['idd'];
$name =$_POST['name'];
$email = $_POST['email'];
$pass = $_POST['pass'];
$role = $_POST['role'];

$pdo = new PDO(
    "mysql: host=localhost;dbname=enset_2025",
    "root",
    ""
);

$sql = "UPDATE  users SET name='$name', email='$email', pass='$pass', role='$role' WHERE idd=$id";
 $stmt = $pdo->query($sql);

 header('Location: /');

