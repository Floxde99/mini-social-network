<?php

class Db {
    private static $instance;

    protected static function getInstance(){
        if (self::$instance == null) {
            try {
                self::$instance = new PDO("mysql:host=localhost;dbname=social_network","root","");
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        return self::$instance;
    }

    protected static function disconnect(){
        self::$instance = null;
    }
}