<?php
try {
    $dbh = new PDO("mysql:host=localhost", $DB_USER, $DB_PASSWORD);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->exec('CREATE DATABASE IF NOT EXISTS '.$DB_NAME);
} catch (PDOException $e) {
    die("DB ERROR: ". $e->getMessage());
}
try {
    $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    //$pdo->exec("DROP TABLE IF EXISTS users");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(30) NOT NULL,
                password TEXT NOT NULL, 
                email VARCHAR(50) NOT NULL,
                is_admin BOOL NOT NULL)
                " );
    $pwd = hash('whirlpool', "root");
    $req = $pdo->query('SELECT username FROM users WHERE username="savincen"');
    if ($req->fetch() == NULL)
        $pdo->exec("INSERT INTO users values('', 'savincen', '".$pwd."', 'samy.vincentffs@gmail.com', TRUE)");
} catch (PDOException $e) {
    die("Table Creation Error: ". $e->getMessage());
}
?>