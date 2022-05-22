<?php
 session_start();
include_once("../config/Database.php");
class Panier{
//    public function __construct($db){
//         if (!isset($_SESSION)) {
           
//         }
//         if (!isset($_SESSION["panier"])) {
//             $_SESSION["panier"] = array();
//         }
//     }
    public function __construct($db){
        $this->connexion = $db;
    }
    public function getProductCart($prd){
        $code = "SELECT product_id FROM products WHERE product_id = :product_id";
        $req = $this->connexion->prepare($code);
        $req->bindValue(":product_id",$prd,PDO::PARAM_STR);
        $req->execute();
        $prdt = $req->fetchAll(PDO::FETCH_OBJ);
        if (!isset($_SESSION["panier"])) {
            $_SESSION["panier"] = array();
        }
        if (isset($_SESSION["panier"][$prdt[0]->product_id])) {
            $_SESSION["panier"][$prdt[0]->product_id]++;
        }
        else {
            $_SESSION["panier"][$prdt[0]->product_id] = 1;
        }
        $quantity = $_SESSION["panier"][$prdt[0]->product_id];
        echo json_encode("quantity:" . $quantity);
    }
    public function viewPanier(){
        $keys = array_keys($_SESSION["panier"]);
        $keysList = implode(",",$keys);
        if (empty($keys)) {
            $_SESSION["panier"] = array();
        }
        else {
            $code = "SELECT product_id,title,price,image,description FROM products WHERE product_id IN($keysList)";
        }
        $req = $this->connexion->prepare($code);
        $req->execute();
        if ($req->rowCount() > 0) {
            $productArray = [];
            $productArray["products"] = [];
            while ($rep = $req->fetch(PDO::FETCH_ASSOC)) {
                $rep['image'] = URL."images/".$rep['image'];
                extract($rep);
                $prod = [
                          "product_id"=>$product_id,
                          "title"=>$title,
                          "price"=>$price,
                          "image"=>$image,
                          "description"=>$description
                ];
                $productArray["products"][] = $prod;
            }
            $req->closeCursor();
            echo json_encode($productArray);
        }
    }
    public function delete($prodCart){
        unset($_SESSION["panier"][$prodCart]);
    }
    public function count(){
        $count_products = array_sum($_SESSION["panier"]);
        echo json_encode($count_products);
    }
    public function total(){
        $total = 0;
        $keys = array_keys($_SESSION["panier"]);
        $keysList = implode(",",$keys);
        if (empty($keys)) {
            $_SESSION["panier"] = array();
        }
        else {
            $code = "SELECT product_id,price FROM products WHERE product_id IN($keysList)";
        }
        $req = $this->connexion->prepare($code);
        $req->execute();
        $rep = $req->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rep as $key => $product) {
            $total += $product["price"]*$_SESSION["panier"][$product["product_id"]];
        }
        echo json_encode($total);
    }
} 