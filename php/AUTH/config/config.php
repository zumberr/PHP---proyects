<?php 
  $connection = new PDO("mysql:host=localhost   ;dbname=auth", "root", "");
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try {
        $connection->exec("CREATE DATABASE IF NOT EXISTS auth");
        $connection = null;
    } catch(PDOException $e) {
        die("Error creating database: " . $e->getMessage());
    }
?>