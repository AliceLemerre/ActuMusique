<?php
$host = 'bdd';
$db   = 'postgres';
$user = 'postgres';
$pass = 'postgres';

$dsn = "pgsql:host=$host;port=5432;dbname=$db;";

try {
    $pdo = new PDO($dsn, $user, $pass);
    echo "Connected successfully to the database.\n";

    $stmt = $pdo->query("SELECT table_name FROM information_schema.tables WHERE table_schema='public'");
    echo "Tables in the database:\n";
    while ($row = $stmt->fetch()) {
        echo $row['table_name'] . "\n";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
}