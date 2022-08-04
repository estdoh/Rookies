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
        return $this->view->response($productos, 200);
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

    function getProductsByPlace($params = null){
        // get url params Api
        // $sort = $params[":sort"];
        $place = $params[":place"];
        // $category = $params[":category"];
        $productos = $this->model->getProductsByPlace($place);
        return $this->view->response($productos, 200);
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