<?php
$servername = "localhost:3307";
$username_db = "root";
$password_db = "";
$conn = null;
try {
    $conn = new PDO("mysql:host=$servername;dbname=MiniChat", $username_db, $password_db);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
    die();
}
?>