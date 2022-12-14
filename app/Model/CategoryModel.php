<?php

class CategoryModel {
    private $db;
    public function __construct() {
        // $this->db = new PDO('mysql:host=localhost;'.'dbname=datasets_extesion;charset=utf8', 'root', '');
        $this->db = new PDO('mysql:host=localhost;'.'dbname=apirest_ext;charset=utf8', 'apirest_ext', 'II*ZK/g0cD');
        // $this->db = new PDO('mysql:host=localhost;'.'dbname=apirest_ext;charset=utf8', 'apirest_dg', 'II*ZK/g0cD');
    }  
   
    function getCategories() { 
        $query = $this->db->prepare('SELECT category.*,sub_category.name as name_sub_category 
                                    FROM category
                                    JOIN sub_category ON sub_category.id_s_category = category.id_category');
                                   
                                    //  JOIN sub_category ON products.sub_category = sub_category.id_s_category');
        $query->execute();
        $categoryproducts = $query->fetchAll(PDO::FETCH_OBJ);        
        return $categoryproducts;
    }

    function getSubCategories() { 
        $query = $this->db->prepare('SELECT * FROM sub_category');
        $query->execute();
        $categoryproducts = $query->fetchAll(PDO::FETCH_OBJ);        
        return $categoryproducts;
    }

    function addCategory($name, $description) {  
        $query = $this->db->prepare("INSERT INTO category (name,description) VALUES (?,?)");
        $query->execute([$name,$description]);
        return $this->db->lastInsertId();
    }
    
    function deleteCategories($id) {
        $query = $this->db->prepare('DELETE FROM category WHERE id_category=?');
        $query->execute(array($id));
        return $query->rowCount();
    }

    function getProductsByCategory($category = null) {
        $query = $this->db->prepare('SELECT products.*,category.name as name_category, sub_category.name as name_sub_category 
                                     FROM products 
                                     JOIN sub_category ON products.sub_category = sub_category.id_s_category
                                     JOIN category ON products.category = category.id_category WHERE category.name=?
                                    ');
        $query->execute([$category]); // array($category)
        $products = $query->fetchAll(PDO::FETCH_OBJ);
        return $products;
    }

    function getProductsByCategoryId($category = null) {
        $query = $this->db->prepare('SELECT products.*,category.name as name_category FROM products JOIN category ON products.category = category.id_category WHERE category.id_category=?');
        $query->execute([$category]); // array($category)
        $products = $query->fetchAll(PDO::FETCH_OBJ);
        return $products;
    }

    function getCategoryById($id) {
        $query = $this->db->prepare('SELECT * FROM category WHERE id_category=?');
        $query->execute(array($id));
        $category = $query->fetch(PDO::FETCH_OBJ);        
        return $category;       
    }

    function updateCategoryById($name, $description, $id_category){
        $query = $this->db->prepare('UPDATE category SET name=?, description=? WHERE id_category=?');
        $query->execute([$name, $description, $id_category]);
        $category = $query->fetchAll(PDO::FETCH_OBJ);
        return $category;
    }
}
    