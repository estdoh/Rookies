<?php
require_once './app/Helpers/AuthHelper.php';
require_once './app/Model/ProductModel.php';
require_once './app/View/ProductView.php';
require_once './app/View/CategoryView.php';
require_once './app/Model/CategoryModel.php';
require_once './app/Model/CommentsModel.php';

class ProductsController {
    private $model;
    private $modelCategories;
    private $modelComments;
    private $view;
    private $authHelper;

    public function __construct() {
        $this->model = new ProductsModel();
        $this->modelCategories = new CategoryModel();
        $this->view = new ProductsView();
        $this->modelComments = new CommentsModel();
    }  
    
    function showHome() {
        // AuthHelper::start(); 
        echo "Welcome to the home page";
        
        // $products = $this->model->getProducts();       
        // $this->view->viewHome($products);
    }

    function addProducts() {
        AuthHelper::start();
        $products = [];
        $categories = $this->modelCategories->getCategories();
        $sub_categories = $this->modelCategories->getSubCategories();
        $description = "";
        $items = 0;
        $total_weight =  0;  
       
       
        // $this->view->viewAddProducts($newProducts);       
        $this->view->viewAddProducts($products, $categories, $sub_categories, $description, $items, $total_weight);
    }

    function showProducts() {
        AuthHelper::start(); 
        $products = $this->model->getProducts();
        $categories = $this->modelCategories->getCategories();
        $sub_categories = $this->modelCategories->getSubCategories();   
        $total_weight = 0;
        foreach ($products as $product) {
            $total_weight += $product->weight;
        }
        $items = count($products);
        $this->view->viewProducts($products, $categories, $sub_categories, $items, $total_weight);
    }

    function delProducts($params = null) {     
        if (AuthHelper::checkLoggedInAdmin()){
            $this->modelComments->deleteCommentsByProduct($params);
            $this->model->deleteProducts($params);
            header("Location: ".BASE_URL."showProducts");
        }
        else{
            $this->showError("Usuario no autorizado");
        }
    }

    function searchProducts($params = null) {
        $products = $this->model->getProducts();
        $ProductsByCategory = $this->modelCategories->getProductsByCategory($params);
        $total_weight = 0;
        foreach ($ProductsByCategory as $product) {
            $total_weight += $product->weight;
        }
        $items = count($ProductsByCategory);
        $this->view->viewProducts($ProductsByCategory, $categories=null, $sub_categories=null, $items, $total_weight);
    }

    function searchProductsByPlace($place = null) {
        // $products = $this->model->getProducts();
        $products = $this->model->getProductsByPlace($place);
        $categories = $this->modelCategories->getCategories();
        $sub_categories = $this->modelCategories->getSubCategories(); 
        $total_weight = 0;
        foreach ($products as $product) {
            $total_weight += $product->weight;
        }
        $items = count($products);
        // echo $items;
        $this->view->viewProducts($products,$categories, $sub_categories, $items, $total_weight);
    }

    function searchProductsBy($params) {    
        $searchBy = $_GET["searchBy"];
        $search = $_GET["search"];
        // $searchBy = $params.get("searchBy");
        // $search = $params.get("search");

        $products = $this->model->getProductsBy($searchBy, $search);
        $categories = $this->modelCategories->getCategories();
        $sub_categories = $this->modelCategories->getSubCategories(); 
        $total_weight = 0;
        foreach ($products as $product) {
            $total_weight += $product->weight;
        }
        $items = count($products);
        // echo $items;
        $this->view->viewProducts($products,$categories, $sub_categories, $items, $total_weight);
    }

    function addProduct() {        
        if (AuthHelper::checkLoggedInAdmin()){     
            $place = $_POST['input_place'];        
            $category = ""; 
            if (isset($_POST['input_category'])){
                $category = $_POST['input_category'];
            }
            $sub_category = ""; 
            if (isset($_POST['input_sub_category'])){
                $sub_category = $_POST['input_sub_category'];
            }
            $description = $_POST['input_description'];
            $weight = $_POST['input_weigth'];
            $motivo = $_POST['input_reason'];
            if($place == "" || $category == "" || $sub_category == "" || $weight == "" || $motivo == ""){
                $this->showError("El nombre o la categoría no pueden ser vacios");
            }            
            $this->model->addProduct($place,$category,$sub_category,$weight,$description,$motivo);
            // header("Location: ".BASE_URL."showProducts");
            header("Location: ".BASE_URL."addProducts");

        } else {
            
            $this->showError("Usuario no autorizado");
        }
    }

    function editProduct($id){
        if (AuthHelper::checkLoggedInAdmin()){
            $name = $_POST['input_name'];
            $category = "";
            $description = $_POST['input_description'];
            if (isset($_POST['input_category'])){
                $category = $_POST['input_category'];
            }

            $price_a = $_POST['input_price_a'];
            $price_b = $_POST['input_price_b'];

            if($name == "" || $category == ""){
                $this->showError("El nombre o la categoría no pueden ser vacios");
            }
            else{
                if($_FILES['input_image']['type'] == "image/jpg" || $_FILES['input_image']['type'] == "image/jpeg" 
                || $_FILES['input_image']['type'] == "image/png" ) {
                    $this->model->updateProductById($category, $name, $description, $price_a, $price_b, $id,$_FILES['input_image']);
                }
                else {
                    $this->model->updateProductById($category, $name, $description, $price_a, $price_b,$id);
                }        
                header("Location: ".BASE_URL."showProducts");
        
            }
        }
        else {
            $this->showError("Usuario no autorizado");
        }
    }

    function viewProduct($id = null){     
        $product = $this->model->getProductById($id);
        $categories = $this->modelCategories->getCategories($id);
        $this->view->viewPageProduct($product, $categories);
    }

    function commentsProducts($product_id){
        $this->view->viewCommentsProduct($product_id);
    }

    public function showError($msg){
        $this->view->showError($msg);
    }

    function showHomeCSR() {
        $products = $this->model->getProducts();     
        // $this->view->viewAddProducts($products, $categories, $sub_categories, $description, $items, $total_weight);
        $this->view->showDatasetsLayout();
    }

    function viewCategoryCSR($params = null){
        $id = $params;
        $category = $this->model->getCategoryById($id);
        $this->view->viewCategoryCSRLayout($category);
    }

       
}