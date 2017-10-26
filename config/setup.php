<?php
include_once("../verifpage.php");
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
    //$pdo->exec("DROP TABLE IF EXISTS images");
    //$pdo->exec("DROP TABLE IF EXISTS clippers");
    //$pdo->exec("DROP TABLE IF EXISTS comments");
    //$pdo->exec("DROP TABLE IF EXISTS likes_log");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE TABLE IF NOT EXISTS users (
                `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `username` VARCHAR(250) NOT NULL,
                `password` TEXT NOT NULL,
                `email` VARCHAR(250) NOT NULL,
                `key` TEXT NOT NULL,
                `is_active` BOOL NOT NULL,
                `is_admin` BOOL NOT NULL,
                `email_key` TEXT)
                " );
    $pdo->exec("CREATE TABLE IF NOT EXISTS images (
                `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `username` VARCHAR(30) NOT NULL,
                `src` VARCHAR(1000) NOT NULL,
                `time` VARCHAR(30) NOT NULL,
                `likes` INT(8))");
    $pdo->exec("CREATE TABLE IF NOT EXISTS clippers (
        `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `name` VARCHAR(30) NOT NULL,
        `src` VARCHAR(1000) NOT NULL)");
    $pdo->exec("CREATE TABLE IF NOT EXISTS comments (
        `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `id_image` INT(6) NOT NULL,
        `username` VARCHAR(30) NOT NULL,
        `comment` VARCHAR(1000) NOT NULL,
        `timedate` INT(11) UNSIGNED NOT NULL)");
    $pdo->exec("CREATE TABLE IF NOT EXISTS likes_log (
        `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `username` VARCHAR(30) NOT NULL,
        `id_image` INT(6) NOT NULL,
        `vote` INT(6) NOT NULL)");
    $pwd = hash('whirlpool', "root");
    $req_username = $pdo->query('SELECT username FROM users WHERE username="savincen"');
    if ($req_username->fetch() == NULL)
        $pdo->exec("INSERT INTO users values(NULL, 'savincen', '".$pwd."', 'samy.vincentffs@gmail.com', 'nokey', TRUE, TRUE, NULL)");
    $req_clippers = $pdo->query('SELECT id FROM clippers');
    if ($req_clippers->fetchAll() == NULL)
    {
        $pdo->exec("INSERT INTO clippers values
        (null, 'smiley', 'images/clippers/smiley.png'),
        (null, 'beer', 'images/clippers/beer.png'),
        (null, 'chapeau', 'images/clippers/chapeau.png'),
        (null, 'moustache', 'images/clippers/moustache.png'),
        (null, 'censored', 'images/clippers/censored.png')");
    }
} catch (PDOException $e) {
    die("Table Creation Error: ". $e->getMessage());
}
?>