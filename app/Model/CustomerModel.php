<?php

class CustomerModel {    
    private $db;
    public function __construct() {
        // $this->db = new PDO('mysql:host=localhost;'.'dbname=datasets_extesion;charset=utf8', 'root', '');
        $this->db = new PDO('mysql:host=localhost;'.'dbname=apirest_ext;charset=utf8', 'apirest_ext', 'II*ZK/g0cD');
    }

    function getCustomer($email){
        $query = $this->db->prepare('SELECT *
                                     FROM `customers`
                                     WHERE client_mail=?');
        $query->execute(array($email));
        $customer = $query->fetch(PDO::FETCH_OBJ);
        return $customer;
    }

    function getCustomers(){
        $query = $this->db->prepare('SELECT *
                                     FROM `customers`');
        $query->execute();
        $customers = $query->fetchAll(PDO::FETCH_OBJ);
        return $customers;
    }    

    function getCustomerById($clientId) {
        $query = $this->db->prepare('SELECT * FROM customers WHERE client_id =?');
        $query->execute(array($clientId));
        $customerByID = $query->fetch(PDO::FETCH_OBJ);        
        return $customerByID;       
    }

    function addCustomer($clientId, $clientName, $clientMail, $clientPhone){
        $query = $this->db->prepare('INSERT INTO customers (client_id,client_name,client_mail,client_phone) VALUES (NULL,?,?,?)');
        $query->execute(array($clientId, $clientName, $clientMail, $clientPhone));
        $customer = $query->fetch(PDO::FETCH_OBJ);
        return $customer;
    }

    function updateCustomerById($rol, $clientId){
        $query = $this->db->prepare('UPDATE customers SET rol=? WHERE client_id=?');
        $query->execute([$rol, $id]);
        $customer = $query->fetchAll(PDO::FETCH_OBJ);
        return $customer;
    }

    function deleteCustomer($id) {
        $query = $this->db->prepare('DELETE FROM customers WHERE client_id=?');
        $query->execute(array($id));
        $query->fetchAll(PDO::FETCH_OBJ);
        // return $query->rowCount();
    }
}
