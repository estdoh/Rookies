<?php

class ProductsModel {
    
    private $db;
    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;'.'dbname=api-dg;charset=utf8', 'root', '');
        // $this->db = new PDO('mysql:host=localhost;'.'dbname=apirest_ext;charset=utf8', 'apirest_ext', 'II*ZK/g0cD');
        //  $this->db = new PDO('mysql:host=localhost;'.'dbname=apirest_ext;charset=utf8', 'apirest_ext', 'II*ZK/g0cD');
    }
    
    function getProducts() {        
        $query = $this->db->prepare('SELECT *
                                    FROM products                                    
                                    ORDER BY products.id ASC');
        $query->execute();
        $products = $query->fetchAll(PDO::FETCH_OBJ);
        return $products;
    }

    function getProductsWWWW($orderBy, $order, $pagination, $search) {
        if (isset($search['searchBy']) && isset($search['orderBy']) ) {  
            $queryFiltering = 'WHERE products.' . $search['searchBy'] . ' LIKE "' . $search['filterBy'] . '"';            
        } else {
            $queryFiltering = '';
        }
        if (isset($orderBy)) {  
            $queryOrdering = 'ORDER BY products.' . $orderBy . " " . $order . " ";            
        } else {
            $queryOrdering = 'ORDER BY products.id ASC ';
        }
        
        if (isset($pagination)) {              
            $queryPagination = "LIMIT " . $pagination["limit"] . " OFFSET " . $pagination["offset"];            
        } 

        $query = $this->db->prepare("SELECT * FROM products "
                                    . $queryFiltering
                                    . $queryOrdering
                                    . $queryPagination
                                    );
                                    // var_dump($query);
        $query->execute();
        $products = $query->fetchAll(PDO::FETCH_OBJ);
        return $products;
    }

    function getProductById($id) {
        $query = $this->db->prepare('SELECT * 
                                     FROM products 
                                     WHERE id=?
                                     ');
        $query->execute(array($id));
        $product = $query->fetch(PDO::FETCH_OBJ);        
        return $product;       
    }

    // function getProductsByCategory()
    function getProductsByCategory($category) {
        $query = $this->db->prepare("SELECT * 
                                     FROM products 
                                     WHERE category=?
                                     ");
        $query->execute([$category]);
        $products = $query->fetchAll(PDO::FETCH_OBJ);
        return $products;       
    }
    
    // select distinct category from products
    function getCategoriesFromProducts() {
        $query = $this->db->prepare("SELECT distinct category
                                     FROM products
                                     ORDER BY category ASC
                                     ");
        $query->execute();
        $categories = $query->fetchAll(PDO::FETCH_OBJ);
        return $categories;
    }

    function getProductsBy($orderBy, $order) {
        $querys = [
            "place" => "WHERE place=$search",
            "id" => "WHERE id=$search",
            "category" => "WHERE category=$search",
            "sub_category" => "WHERE sub_category=$search"
        ];
        $orderBy = $querys[$searchBy];

        $query = $this->db->prepare("SELECT products.*,category.name as name_category, sub_category.name as name_sub_category 
                                     FROM products 
                                     JOIN sub_category ON products.sub_category = sub_category.id_s_category
                                     JOIN category ON products.category = category.id_category $searchQuery
                                     ");
        $query->execute([$searchBy]);
        $products = $query->fetchAll(PDO::FETCH_OBJ);
        return $products;       
    }

    function deleteProducts($id) {
        $query = $this->db->prepare('DELETE FROM products WHERE id=?');
        $query->execute(array($id));
        return $query->rowCount();
    } 

    function orderProductsBy($orderby){
        $query = $this->db->prepare("SELECT products.*,category.name as name_category 
                                     FROM products 
                                     JOIN category ON products.category = category.id_category 
                                     ORDER BY ? ASC");
        $query->execute(array($orderby));
        $products = $query->fetchAll(PDO::FETCH_OBJ);
        return $products;
    }

    function addProduct($id,$category,$name,$description,$price) {   
       $query = $this->db->prepare('INSERT INTO products (id,category,name,description,price) 
                                    VALUES (?,?,?,?,?)');
        $query->execute([$id,$category,$name,$description,$price]);
        $product = $query->fetch(PDO::FETCH_OBJ);
        return $product;    
        // return $this->db->lastInsertId();
    }

    function updateProductById($category, $name, $description,$price, $id){       
        $query = $this->db->prepare('UPDATE products SET category=?, name=?, description=?, price=? WHERE id=?');
        $query->execute([$category, $name, $description, $price, $id]);    
        $product = $query->fetchAll(PDO::FETCH_OBJ);
        return $product;
    }

}