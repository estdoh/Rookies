<?php
require_once 'Conect.php';

class UserModel extends Conectdb{    

    function getUser($email){
        $query = $this->db->prepare('SELECT * FROM users WHERE email=?');
        $query->execute([$email]);
        $user = $query->fetch(PDO::FETCH_OBJ);
        return $user;
    }

    function getUsers(){
        $query = $this->db->prepare('SELECT * FROM users');
        $query->execute();
        $user = $query->fetchAll(PDO::FETCH_OBJ);
        return $user;
    }    

    function getUserById($id) {
        $query = $this->db->prepare('SELECT * FROM `users` WHERE id_user =?');
        $query->execute(array($id));
        $userByID = $query->fetch(PDO::FETCH_OBJ);        
        return $userByID;       
    }

    function addUser($email, $password, $rol){
        $query = $this->db->prepare('INSERT INTO users (id_user,email,password,rol) VALUES (NULL,?,?,?)');
        $query->execute(array($email,$password, $rol));
        $user = $query->fetch(PDO::FETCH_OBJ);
        return $user;
    }

    function updateUserById($rol, $id){
        $query = $this->db->prepare('UPDATE users SET rol=? WHERE id_user=?');
        $query->execute([$rol, $id]);
        $user = $query->fetchAll(PDO::FETCH_OBJ);
        return $user;
    }

    function deleteUser($id) {
        $query = $this->db->prepare('DELETE FROM users WHERE id_user=?');
        $query->execute(array($id));
        $query->fetchAll(PDO::FETCH_OBJ);
        // return $query->rowCount();
    }
}
