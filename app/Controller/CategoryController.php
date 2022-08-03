<?php
require_once './app/View/CategoryView.php';
require_once './app/Model/CategoryModel.php';

class CategoryController {
    private $model;
    private $view;
    private $authHelper;

    public function __construct() {
        $this->model = new CategoryModel();
        $this->view = new CategoryView();
        $this->authHelper = new AuthHelper();
    }

    function showCategories() {
        AuthHelper::start();   
        $categories = $this->model->getCategories();   
        $sub_categories = $this->model->getSubCategories();     
        $this->view->viewCategories($categories, $sub_categories);
    }

    function delCategories($params = null) {
        if (AuthHelper::checkLoggedInAdmin()){
            $products = $this->model->getProductsByCategoryId($params);
            if (count($products)==0){
                $this->model->deleteCategories($params);
                header("Location: ".BASE_URL."showCategories");
            }
            else{
                $this->showError("No se puede borrar la categoría, existen productos asociados");
            } 
        }
        else{
            $this->showError("Usuario no autorizado");
        }
    }

    function addCategory (){
        if (AuthHelper::checkLoggedInAdmin()){
            $name = $_POST['input_name'];
            $description = $_POST['input_description'];
            if ($name == "") { 
                $this->showError("El nombre no puede estar vacío");
            }
            else{
                $this->model->addCategory($name,$description);
                header("Location: ".BASE_URL."showCategories");
            }
        }
        else{
            $this->showError("Usuario no autorizado");
        }
    }

    
    function viewCategory($params = null){
        if (AuthHelper::checkLoggedInAdmin()){
            $id = $params;
            $category = $this->model->getCategoryById($id);
            $this->view->viewPageCategory($category);
        } 
        else{
            $this->showError("Usuario no autorizado");
        }
    }

    function editCategory($id_category){
        if (AuthHelper::checkLoggedInAdmin()){
            $this->authHelper->checkLoggedIn();        
            $name = $_POST['input_name'];
            $description = $_POST['input_description'];
            $this->model->updateCategoryById($name, $description, $id_category);
            header("Location: ".BASE_URL."showCategories");
        }
        else{
            $this->showError("Usuario no autorizado");
        }
    }

    function showHomeCSR() {
        $categories = $this->model->getCategories();     
        $this->view->showCategoriesLayout();
    }

    function viewCategoryCSR($params = null){
        $id = $params;
        $category = $this->model->getCategoryById($id);
        $this->view->viewCategoryCSRLayout($category);
    }

    public function showError($msg){
        $this->view->showError($msg);
    }
}