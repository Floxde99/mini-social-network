<?php

class Db {
    private static $instance;

    protected static function getInstance(){
        if (self::$instance == null) {
            try {
                // Configuration locale
                $host = "localhost";
                $dbname = `social_network`; // Mets ici le nom de ta base locale
                $username = "root";
                $password = ""; // Mot de passe vide par défaut sur Laragon/XAMPP

                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
                    PDO::ATTR_TIMEOUT => 5,
                ];

                self::$instance = new PDO(
                    "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
                    $username,
                    $password,
                    $options
                );
            } catch (PDOException $e) {
                die("Erreur de connexion à la base de données : " . $e->getMessage());
            }
        }
        return self::$instance;
    }

    protected static function disconnect(){
        self::$instance = null;
    }
}