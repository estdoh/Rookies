<?php

require_once './libs/smarty/Smarty.class.php';

class CategoryView {  
    private $smarty; 
    function __construct() {
        $this->smarty = new Smarty();   
        $this->smarty->assign('titulo', 'Carga de productos');     
        $this->smarty->assign('email', '');  
    }

    function viewCategories($categories, $sub_categories) {      
        $this->setSmartyVariables();  
        $this->smarty->assign('categories', $categories);      
        $this->smarty->assign('sub_categories', $sub_categories);  
        $this->smarty->display('template/body-categories.tpl');
    }
    
    function viewPageCategory($category){      
        $this->setSmartyVariables();   
        $this->smarty->assign('category', $category);
        $this->smarty->display('template/category.tpl');
    }

    function renderError(){echo "error";}
    
    function showCategoriesLayout() {
        $this->setSmartyVariables();
        $this->smarty->display('template/body-categoriesCSR.tpl');
    }

    function setSmartyVariables(){
        if (isset($_SESSION["email"])){   
            $this->smarty->assign('email', $_SESSION["email"]);
            $this->smarty->assign('rol', $_SESSION["rol"]);
            $this->smarty->assign('user_id', $_SESSION["user_id"]);
        } else {
            $this->smarty->assign('rol', 'noLog');
            $this->smarty->assign('user_id','0');
        }
    }

    public function showError($error){
        $this->smarty->assign('error', "Error");
        $this->smarty->assign('subtitle', $error);
        $this->smarty->display('template/showError.tpl');
    }
}