<?php
require_once './app/Model/UserModel.php';
require_once './app/Model/CommentsModel.php';
require_once './app/View/UserView.php';
include_once './app/Helpers/AuthHelper.php';

class UserController {
    private $model;
    private $view;
    private $model_comments;    

    public function __construct(){
        $this->model = new UserModel();
        $this->view = new UserView();
        $this->model_comments = new CommentsModel();
    }  

    function login(){
        $this->view->showLogin();
    }

    function logout(){        
        session_start();
        session_destroy();
        $this->view->showHome();
    }

    function verifyLogin() {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $email = $_POST['email']; 
            $password = $_POST['password'];             
            //traigo el user de la base de datos
            $user = $this->model->getUser($email);            
            //verifica coincidencias
            if (!empty($user) && password_verify($password, $user->password)) {
                $rol = $user->rol;
                AuthHelper::login($email,$rol,$user->id_user);
                //$_SESSION['email'] = $email;
                //$this->view->set_user($email);
                 $this->view->showHome();
            } else {
                $this->view->showLogin("Acceso denegado2");
            }      
        }                
    }

    function viewRegister() {
        if (AuthHelper::checkLoggedOut()) {   
            $this->view->showRegister();
        }
    }  

    function registerUser() {  
        if (AuthHelper::checkLoggedOut()){
            $email = $_POST['email'];
            $contraseña = $_POST['password'];
            $rol = "USER";
            $hash = password_hash($contraseña, PASSWORD_BCRYPT);
            $this->model->addUser($email, $hash, $rol);
            $this->verifyLogin();
        }
    }

    function addUser() {   
        if (AuthHelper::checkLoggedInAdmin()) {    
            $email = $_POST['email'];
            $contraseña = $_POST['password'];
            $rol = $_POST['rol'];
            $hash = password_hash($contraseña, PASSWORD_BCRYPT);
            $this->model->addUser($email, $hash, $rol);
            $this->view->showUsers();
        }
    }

    function showUsers() {
        if (AuthHelper::checkLoggedInAdmin()) {                    
            $users = $this->model->getUsers();
            $this->view->viewUsers($users);
        } else {
            $this->view->showLogin("Acceso denegado");
        }
    }

    function viewUser($id = null) {       
        if (AuthHelper::checkLoggedInAdmin()) {
            $user = $this->model->getUserById($id);
            $this->view->viewPageUser($user);
        } else {
            $this->view->showLogin("Acceso denegado");
        }        
    }
    
    function editUser($id) {       
        if (AuthHelper::checkLoggedInAdmin()) {
            $rol = $_POST['input_rol'];
            $this->model->updateUserById($rol,$id);
            header("Location: ".BASE_URL."showUsers");
        } else {
            $this->view->showLogin("Acceso denegado");
        }        
    }

    function delUser($params = null) {     
        if (AuthHelper::checkLoggedInAdmin()){
             //aca hay que llamar al deleteCommentsByUser porque si no no puedo borrar al usuario.
            $this->model_comments->deleteCommentsByUser($params);
            $this->model->deleteUser($params);
            // $products = $this->model->getProducts();
            // $this->view->viewProducts($products);
            header("Location: ".BASE_URL."showUsers");
        } else {
            $this->view->showLogin("Acceso denegado");
        }
    }


}