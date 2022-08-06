<?php
require_once "Model/CustomerModel.php";
require_once "View/ApiView.php";

class ApiCustomerController{

    private $model;
    private $view;

    function __construct(){
        $this->model = new CustomerModel();
        $this->view = new ApiView();
    }

    function getCustomers(){
        $customers = $this->model->getCustomers();
        if (!empty($customers)){
            return $this->view->response($customers, 200);
        } else {
            $this->view->response("no existen clientes", 404);
        };
    }
    
    function addCustomers(){
        $newCustomers = $this->model->getCustomers();
        return $this->view->response($customers, 200);
    }    

    function getCustomer($params = null){
        $id = $params[":ID"];
        $customer = $this->model->getCustomerById($id);
        if (!empty($customer)){
            return $this->view->response($customer, 200);
        } else {
            $this->view->response("La customer con el id=$id no existe", 404);
        };
    }
   
    function deleteCustomer($params = null) {
        $id = $params[':ID'];
        $customer = $this->model->getCustomers($id);
        if($customer){
            $this->model->deleteCustomers($id);
            $this->view->response("El customer con el id=$id fue eliminada", 200);
        } else {
            $this->view->response("El customer con el id=$id no existe", 404);
        };
    }

    function insertCustomer($params = null){
        //agarro los datos de request (json)
        $body = $this->getBody();
        // echo $body;
        // verifica si la tarea existe
        if (!empty($body)) {
            $this->model->addCustomer($body->id,$body->category,$body->name,$body->description,$body->price);
            // $this->view->response( $this->model->getCustomerById($id), 200);
        } else {
            $this->view->response("El customer no se pudo insertar", 404);
        };
    }

    private function getBody(){
        $bodystring = file_get_contents("php://input");
        return json_decode($bodystring);
    }

    public function editCustomer($params = null){
        $id = $params[':ID'];
        //agarro los datos de request (json)
        $body = $this->getBody();
        $customer = $this->model->getCustomers($id);
        // verifica si la tarea existe
        if (!empty($customer)) {
            $this->model->updateCustomerById($body->category,$body->name,$body->description,$body->price,$id);
            $this->view->response( $this->model->getCustomerById($id), 200);
        } else {
            $this->view->response("El customer no se pudo insertar", 404);
        };
    }
}