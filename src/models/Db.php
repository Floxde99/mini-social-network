<?php

class Db {
    private static $instance;

    protected static function getInstance(){
        if (self::$instance == null) {
            try {
                // Database configuration
                $host = "sql202.infinityfree.com"; // Vérifie ce nom d'hôte
                // Alternative : essaie avec l'adresse IP directe
                // $host = "185.27.134.10"; // Exemple d'IP, utilise celle fournie par InfinityFree

                $dbname = "if0_38832300_cnc";
                $username = "if0_38832300";
                $password = "1t10yb3YN2S";

                // Ajout d'options PDO supplémentaires pour le débogage
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
                    PDO::ATTR_TIMEOUT => 5, // Timeout de 5 secondes
                ];

                self::$instance = new PDO(
                    "mysql:host={$host};dbname={$dbname};port=3306",
                    $username,
                    $password,
                    $options
                );

            } catch (PDOException $e) {
                // Amélioration du message d'erreur
                die("Erreur de connexion à la base de données : " . $e->getMessage() . 
                    "<br>Vérifiez vos paramètres de connexion et que le serveur est accessible.");
            }
        }
        return self::$instance;
    }

    protected static function disconnect(){
        self::$instance = null;
    }
}