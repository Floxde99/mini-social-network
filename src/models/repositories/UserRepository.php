<?php
abstract class UserRepository extends Db{
    private static function request($request){
        $result = self::getInstance()->query($request);
        return $result;
    }
    public static function getAllUsers(){
        $request = "SELECT * FROM users";
        $result = self::request($request);
        return $result->fetchAll(PDO::FETCH_CLASS, 'User');
    }
    public static function getUserByEmail($email){
        $request = "SELECT * FROM users WHERE email = '$email'";
        $result = self::request($request);
        return $result->fetchObject('User');
    }
    public static function addUser($user){
        $request = "INSERT INTO users (name, email, password, date_inscription) VALUES ('$user->name', '$user->email', '$user->password', NOW())";
        $result = self::request($request);
        return $result;
    }
}