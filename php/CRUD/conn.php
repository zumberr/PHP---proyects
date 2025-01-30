<?php 
  try {
    $connection = new PDO("mysql:host=localhost;dbname=payment", "root", "");
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(PDOException $e) {
    die("Error creating database: " . $e->getMessage());
  }

?>