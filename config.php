<?php
    // Paramètres de connexion (surchargeables par variables d'environnement)
    $dsn      = getenv("DB_DSN")  ?: "mysql:host=localhost;dbname=l2BD;charset=utf8mb4";
    $username = getenv("DB_USER") ?: "root";
    $password = getenv("DB_PASS") ?: "";

    try{
        $db = new PDO($dsn, $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $ex){
        die("Erreur de connexion à la base de données : " . htmlspecialchars($ex->getMessage()));
    }
?>
