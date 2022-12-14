<?php
require_once "Model/ProductModel.php";
require_once "View/ApiView.php";

class ApiProductController{

    private $model;
    private $view;

    function __construct(){
        $this->model = new ProductsModel();
        $this->view = new ApiView();
    }

    function getProducts(){
        $productos = $this->model->getProducts();
        // var_dump($productos);
        if (!empty($productos)){
            return $this->view->response($productos, 200);
        } else {
            $this->view->response("no existen productos", 404);
        };
    }

    function getProductsWWW(){
        $order = $this->getOrder();
        $orderBy = $this->getOrderBy();
        $pagination = $this->getPagination();    

        $search = $this->getSearch();
        // var_dump($search);
        $productos = $this->model->getProductsWWWW($orderBy, $order, $pagination, $search);

        // var_dump($productos);
        if (!empty($productos)){
            return $this->view->response($productos, 200);
        } else {
            $this->view->response("no existen productos C", 404);
        };
    }

    function getPagination(){
        if(!empty($_GET['page']) && !empty($_GET['limit'])){
            $page = $_GET['page'];
            $limit = $_GET['limit'];
            $offset = ($page - 1) * $limit;   
            $pagination = array (
                'page' => $page,
                'limit' => $limit,
                'offset' => $offset
            ); 
            return $pagination;        
        } else {
            $pagination = array (
                'page' => 1,
                'limit' => 10,
                'offset' => 0
            );
                        
            return $pagination;
        }
    }

    function getSearch(){
        $search = [];
        if(!empty($_GET['filterBy'])){
            $filterBy = $_GET['filterBy'];
            $search["filterBy"] = strval($filterBy);
        } else {
            $search = null;
        }
        if (!empty($_GET['searchBy'])){
            $searchBy = $_GET['searchBy'];
            $search["searchBy"] = strval($searchBy);
        } else {
            $search = null;
        }
            
        return $search;       
    }

    function getOrder(){
        if(!empty($_GET['order']) ){
            $order = $_GET['order'];
                if($order == 'ASC' || $order == 'asc'){
                    return 'ASC';
                } else if ($order == 'DESC' || $order == 'desc'){
                    return 'DESC';
                }            
        } else {
            return "ASC";
        }
    }

    function getOrderBy (){
        if(!empty($_GET['orderby'])){
            $orderBy = $_GET['orderby'];
            if($orderBy == 'id' || $orderBy == 'name' || $orderBy == 'price' || $orderBy == 'category'){
               return $orderBy;
            } else {
                return 'id';
            }
        } else {
            return 'id';
        }
    }


    function addProducts(){
        $newProducts = $this->model->getProducts();
        return $this->view->response($productos, 200);
    }    

    function getProduct($params = null){
        $id = $params[":ID"];
        $producto = $this->model->getProductById($id);
        if (!empty($producto)){
            return $this->view->response($producto, 200);
        } else {
            $this->view->response("La producto con el id=$id no existe", 404);
        };
    }

    // get producto by category
    function getProductsByCategory($params = null){
        $category = $params[":category"];
        $productos = $this->model->getProductsByCategory($category);
        if (!empty($productos)){
            return $this->view->response($productos, 200);
        } else {
            $this->view->response("La categoria=$category no existe", 404);
        };
    }
    // get categories from products
    function getCategoriesFromProducts(){
        $categories = $this->model->getCategoriesFromProducts();
        if (!empty($categories)){
            return $this->view->response($categories, 200);
        } else {
            $this->view->response("No hay categorias", 404);
        };
    }

    function deleteProduct($params = null) {
        $id = $params[':ID'];
        $product = $this->model->getProducts($id);
        if($product){
            $this->model->deleteProducts($id);
            $this->view->response("El producto con el id=$id fue eliminada", 200);
        } else {
            $this->view->response("El producto con el id=$id no existe", 404);
        };
    }

    function insertProduct($params = null){
        //agarro los datos de request (json)
        $body = $this->getBody();
        // echo $body;
        // verifica si la tarea existe
        if (!empty($body)) {
            $this->model->addProduct($body->id,$body->category,$body->name,$body->description,$body->price);
            // $this->view->response( $this->model->getProductById($id), 200);
        } else {
            $this->view->response("El producto no se pudo insertar", 404);
        };
    }

    private function getBody(){
        $bodystring = file_get_contents("php://input");
        return json_decode($bodystring);
    }

    public function editProduct($params = null){
        $id = $params[':ID'];
        //agarro los datos de request (json)
        $body = $this->getBody();
        echo $body;
        $product = $this->model->getProducts($id);
        // verifica si la tarea existe
        if (!empty($product)) {
            $this->model->updateProductById($body->category,$body->name,$body->description,$body->price,$id);
            $this->view->response( $this->model->getProductById($id), 200);
        } else {
            $this->view->response("El producto no se pudo insertar", 404);
        };
    }

}