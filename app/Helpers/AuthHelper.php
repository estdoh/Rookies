<?php

class AuthHelper{
    public function __construct() {
    }

    //inicia sesion.
    static public function start() {
        if (session_status() != PHP_SESSION_ACTIVE){
            session_start();
        }
    }

    static public function login($email, $rol,$user_id) {
        self::start();
        $_SESSION['IS_LOGGED'] = true;
        $_SESSION['email'] = $email;
        $_SESSION['rol'] = $rol;
        $_SESSION['user_id'] = $user_id;
    }

    public static function checkLoggedIn(){
        self::start();
        if(!isset($_SESSION["email"])){
            header("Location: ".BASE_URL."login");
            return false;
        }
        return true;
    }

    public static function checkLoggedInApi(){
        self::start();
        if(!isset($_SESSION["email"])){
            return false;
        }
        return true;
    }

    public static function checkLoggedInAdmin(){
        self::start();        
        if(!isset($_SESSION["email"])){
            header("Location: ".BASE_URL."login");
            return false;
        }
        if(!isset($_SESSION["rol"])){
            return false;
        }
        if ($_SESSION["rol"] != "ADMIN" && $_SESSION["rol"] != "SUPER-ADMIN"){
            return false;
        }
        return true;
    }

    public static function checkLoggedInAdminApi(){
        self::start();
        
        if(!isset($_SESSION["email"])){
            return false;
        }        
        if(!isset($_SESSION["rol"])){
            return false;
        }
        if ($_SESSION["rol"] != "ADMIN" && $_SESSION["rol"] != "SUPER-ADMIN"){
            return false;
        }
        return true;
    }    

    public static function checkLoggedOut(){
        self::start();
        if(isset($_SESSION['email'])){
            header("Location: ". BASE_URL."");
            return false;
        }
        return true;
    }
}