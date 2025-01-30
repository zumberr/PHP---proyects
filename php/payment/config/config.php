<?php
///host

   define("DB_HOST", "localhost");
   //usuario
   define("DB_USER", "root");
    //contraseña
   define("DB_PASS", "");
    //base de datos
   define("DB_NAME", "payment");

   $connection = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
   $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
    $connection->exec("CREATE DATABASE IF NOT EXISTS ".DB_NAME);
    $connection = null;
} catch(PDOException $e) {
    die("Error creating database: " . $e->getMessage());
}

    // Checar la conexión 
   // if($connection == true){
     //   echo("Connectado exitosamente");
     //} else {
      //  echo("ERROR: No se pudo conectar por el motivo de:" . mysqli_connect_error());
    //}