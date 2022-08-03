<?php
require_once './libs/smarty/Smarty.class.php';

class UserView {
    private $smarty;
    public function __construct() {
        $this->smarty = new Smarty();
    }

    function showLogin($error = ""){
        $this->smarty->assign('titulo', 'Log In');
        $this->smarty->assign('error', $error);
        $this->smarty->display('template/login.tpl');
    }

    function showHome($error = ""){
        header("Location: ".BASE_URL."showProducts");
        $this->smarty->assign('error', $error);
    }

    function showUsers($error = ""){
        header("Location: ".BASE_URL."showUsers");
        $this->smarty->assign('error', $error);
    }

    public function set_user($email){
        $this->smarty->assign('email', $email);
    }

    function showRegister($error = ""){
        $this->smarty->assign('titulo', 'register');
        $this->smarty->assign('error', $error);
        $this->smarty->display('template/register.tpl');
    }

    function viewUsers($users=null){
        $this->smarty->assign('users', $users);
        $this->smarty->assign('titulo', 'Administracion de usuarios');
        $this->setSmartyVariables();
        $this->smarty->display('template/usersAdmin.tpl');
    }

    function viewPageUser($user){
        $this->smarty->assign('user', $user);
        $this->setSmartyVariables();
        $this->smarty->display('template/user.tpl');
    }

    function setSmartyVariables(){
        if (isset($_SESSION["email"])){
            $this->smarty->assign('email', $_SESSION["email"]);
            $this->smarty->assign('rol', $_SESSION["rol"]);
        }
    }    
}