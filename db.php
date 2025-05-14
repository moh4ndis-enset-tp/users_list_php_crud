
<?php 

$pdo = new PDO(
    "mysql: host=localhost;dbname=enset_2025",
    "root",
    ""
);
 $stmt = $pdo->query("SELECT * FROM users");

 $users = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>


