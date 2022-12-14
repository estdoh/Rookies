<?php

function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64url_decode($data) {
    return rtrim(strtr(base64_decode($data), '+/', '-_'), '=');
}

class AuthApiHelper{
    private $key;
    public function __construct() {
        $this->key = 'ClaveSecreta';
    }

    function getBasic(){
        $header = $this->getHeader();
        //basic base 64 (user:password)
        if(strpos($header, 'Basic') === 0){
            // base64(user:password)
            $usrpass = explode(" ",$header)[1];
            $usrpass = base64url_decode($usrpass);
            $usrpass = explode(":",$usrpass);
            if(count($usrpass) == 2){
                $user = $usrpass[0];
                $pass = $usrpass[1];
                return array ( 
                    'user' => $user,
                    'pass' => $pass
                );
            }
        }
        return null;
    }

    function getUser($params = null){
        $header = $this->getHeader();
        // $bearer = 'Bearer eyJhbGciaUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOjIxLCJuYW1lIjoiZ2FzdG9uQGRvaGVzdHVkaW8uY29tLmFyIiwicm9sIjpbImFkbWluIiwib3RoZXIiXX0.Vs_CA8EqAeD8T0sycW8JSAGWDsh1SD7IEDkfZup7g6U';
        $qwer = strpos($header,'Bearer');
        if($qwer === 0){
            $token = explode(" ", $header)[1];
            $parts = explode(".", $token);
            if (count($parts) === 3){
                $header = $parts[0];
                $payload = $parts[1];
                $signature = $parts[2];
                $new_signature = hash_hmac('SHA256', "$header.$payload", $this->key, true);
                $new_signature = base64url_encode($new_signature);                
                if ($signature === $new_signature){
                    $payload = base64url_decode($payload);
                    $payload = json_decode($payload);                    
                    if(true /* $payload->exp < $now */){
                        return $payload;
                    }
                }
            }
        }
        return null;
    }

    public function createToken($user){
        $header = array(
            'alg' => 'HS256',
            "typ" =>'JWT'            
        );
        $payload = array(
            'sub' => 21,
            'name' => $user["user"],
            'rol' => ["admin", "other"]
        );
        // $header = json_encode($header);
        // $payload = json_encode($payload);
        // $header = base64_encode($header);
        // $payload = base64_encode($payload);
        $header = base64url_encode(json_encode($header));
        $payload = base64url_encode(json_encode($payload));

        $signature = hash_hmac('SHA256', "$header.$payload", $this->key, true);
        $signature = base64url_encode($signature);

        return "$header.$payload.$signature";
    }

    function getHeader(){
        if(isset($_SERVER["REDIRECT_HTTP_AUTHORIZATION"])){
            return $_SERVER["REDIRECT_HTTP_AUTHORIZATION"];
        }
        if(isset($_SERVER["HTTP_AUTHORIZATION"])){
            return $_SERVER["HTTP_AUTHORIZATION"];
        }
        return null;
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

    public static function checkLoggedInApi(){
        self::start();
        if(!isset($_SESSION["email"])){
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