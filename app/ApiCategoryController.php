<?php
require_once "Model/CategoryModel.php";
require_once "View/ApiView.php";

class ApiCategoryController{

    private $model;
    private $view;

    function __construct(){
        $this->model = new CategoryModel();
        $this->view = new ApiView();
    }

    function getCategories(){
        $tareas = $this->model->getCategories();
        return $this->view->response($tareas, 200);
    }

    function getCategory($params = []){
        $id = $params[":ID"];
        $category = $this->model->getCategoryById($id);
        if (!empty($category)) // verifica si la tarea existe
            return $this->view->response($category, 200);
        else
            $this->view->response("La categoria con el id=$id no existe", 404);
    }

    public function deleteCategory($params = null) {
        $id = $params[':ID'];        
        $categories = $this->model->getCategories($id);
        // $result =  $product = $this->model->deleteProducts($id);

        if($categories){
            $this->model->deleteCategories($id);
            $this->view->response("El categoria con el id=$id fue eliminada", 200);
        } else {
            $this->view->response("El categoria con el id=$id no existe", 404);
        };
    }

    
    public function insertCategory($params = null){
        //agarro los datos de request (json)
        $body = $this->getBody();

        // verifica si la tarea existe
        if (!empty($body)) {
            $id = $this->model->addCategory($body->name,$body->description);
            $this->view->response( $this->model->getCategoryById($id), 201);
        } else {
            $this->view->response("El producto no se pudo insertar", 404);
        };
    }

    private function getBody(){
        $bodystring = file_get_contents("php://input");
        return json_decode($bodystring);
    }

    public function editCategory($params = null){
        $id_category = $params[':ID'];
        //agarro los datos de request (json)
        $body = $this->getBody();
        $category = $this->model->getCategories($id_category);

        // verifica si la tarea existe
        if (!empty($category)) {
            $this->model->updateCategoryById($body->name,$body->description,$id_category);
            $this->view->response( $this->model->getCategoryById($id_category), 200);
        } else {
            $this->view->response("El category no se pudo insertar", 404);
        };
    }

    function viewCategory($params = null){
        $id_category = $params[':ID'];
        $body = $this->getBody();     
        // $category = $this->model->getCategoryById($id);
        $category = $this->model->getCategoryById($id_category);
        $this->view->viewPageCategory($category);
    }


}