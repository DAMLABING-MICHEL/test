<?php
extract($_GET);
  define("URL", str_replace("productsdata.php","",(isset($_SERVER['HTTPS'])? "https" : "http").
  "://".$_SERVER['HTTP_HOST'].$_SERVER["PHP_SELF"]));
header("Access-Control-Allow-Origin: *");
header("Content-Type:application/json");
include("../repositories/Product.php");
include("../repositories/Category.php");
include("../repositories/Brand.php");
include("../repositories/Tag.php");
try{
    if (isset($_GET['products']) && !isset($_GET["product_id"]) && !isset($_GET["categoryList"])) {
        $products = $_GET["products"];
        // on instancie la base de donnees
        $data_base = new Database();
        $db = $data_base->getConnexion();

        // on instancie les produits

        $produit = new Product($db);

        // on recupere les donnees
        $produit->getProducts();
    }
    elseif (isset($_GET['products']) && isset($_GET["product_id"])) {
        $product_id = $_GET["product_id"];
        // on se connecte a la db
        $data_base = new Database();
        $db = $data_base->getConnexion();
        // on instancie la classe categorie
        $product = new Product($db);

        // on recupere les donnees

        $product->getProductById($product_id);
    }
    elseif (isset($_GET["categoryList"])) {
        $data_base = new Database();
        $db = $data_base->getConnexion();
        
        // on instancie les produits
        
        $categ = new Category($db);
        // on recupere les donnees
        
        $categ->getCategories();
    }
    elseif (isset($_GET["brandList"])) {
        $data_base = new Database();
        $db = $data_base->getConnexion();
    
        // on instancie les produits
    
        $brand = new Brand($db);
        // on recupere les donnees
    
        $brand ->getBrands();
    }
    elseif (isset($_GET["tagsList"])) {
        $data_base = new Database();
        $db = $data_base->getConnexion();
    
        // on instancie les produits
    
        $tag = new Tag($db);
        $tag->getTags();
    }
    elseif (isset($_GET["categories"]) && isset($_GET["brand"]) && isset($_GET["tags"])) {
        $categories = $_GET["categories"];
        $brand = $_GET["brand"];
        //   on se connecte a la db
         $data_base = new Database();
         $db = $data_base->getConnexion();
        //   on instancie la classe categorie
         $filter = new Product($db);
        //  on recupere les donnees
          $filter->filteredProducts($categories,$brand,$tags);
    }
    else {
        throw new Exception("erreur de recuperation de donnees verifiez vos parametres!", 1);
        
    }
}
catch(Exception $e){
    $erreur =[
        "message" => $e->getMessage(),
        "code" => $e->getCode()
    ];
    print_r($erreur);
}