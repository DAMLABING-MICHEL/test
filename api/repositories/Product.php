<?php
include_once("../config/Database.php");
class Product{
    // proprietes de l'objet
    public $product_id;
    public $image;
    public $title;
    public $price;
    public $description;
    public $libelle;
    public $categ_id;
    public $brand_name;
    public $brand_id;
    public $tag_id;
    // constructeur $db pour la connexion a la base de donnees

    public function __construct($db){
        $this->connexion = $db;
    }
       // recuperation de tous les produits
    public function getProducts(){
        // $result = $req_last_id->fetchAll(PDO::FETCH_ASSOC);
        // print_r($result);
        $req_sql = "SELECT p.product_id,p.image,p.title,p.price,p.description,c.libelle,p.categ_id,b.brand_name,pt.tag_id FROM products p  left join products_tags pt on p.product_id = pt.product_id inner join categories c on p.categ_id = c.categ_id inner join brand b on p.brand_id = b.brand_id";
        $requete = $this->connexion->prepare($req_sql);
        $requete->execute();
        $productsArray = [];
        $productsArray["products"] = [];
            while($row = $requete->fetch(PDO::FETCH_ASSOC)) {
                $row['image'] = URL."images/".$row['image'];
                extract($row);
                $prod = [
                    "product_id" => $product_id,
                    "image" =>$image,
                    "title" => $title,
                    "price" => $price,
                    "description" => $description,
                    "libelle" => $libelle,
                    "categ_id" => $categ_id,
                    "brand_name" => $brand_name,
                    "tag_id" => $tag_id
                ];
                $productsArray["products"][] = $prod;
                                
            }

            $requete->closeCursor();
            // on envoie le code de reponse 200-ok
            http_response_code(200);
            // on encode les donnees et on envoie
            echo json_encode($productsArray);
        // return $requete;
    }
    // requete de filtre de produits
    function filteredProducts($categ,$brd,$tg){
        if (!empty($categ) && !empty($brd) && !empty($tg)) {
            $code = "SELECT p.product_id,p.image,p.title,p.price,p.description,c.libelle,b.brand_name,t.tag_name FROM products p left join categories c on p.categ_id = c.categ_id left join brand b on p.brand_id = b.brand_id left join products_tags pt on p.product_id = pt.product_id left join tags t on pt.tag_id = t.tag_id WHERE c.categ_id IN($categ) AND b.brand_id IN($brd) AND t.tag_id IN($tg)";
        }
        if (!empty($categ) && empty($brd) && empty($tg)) {
            $code = "SELECT p.product_id,p.image,p.title,p.price,p.description,c.libelle,b.brand_name,t.tag_name FROM products p left join categories c on p.categ_id = c.categ_id left join brand b on p.brand_id = b.brand_id left join products_tags pt on p.product_id = pt.product_id left join tags t on pt.tag_id = t.tag_id  WHERE c.categ_id IN($categ)";
        }
        if (!empty($categ) && !empty($brd) && empty($tg)) {
            $code = "SELECT p.product_id,p.image,p.title,p.price,p.description,c.libelle,b.brand_name,t.tag_name FROM products p left join categories c on p.categ_id = c.categ_id left join brand b on p.brand_id = b.brand_id left join products_tags pt on p.product_id = pt.product_id left join tags t on pt.tag_id = t.tag_id WHERE c.categ_id IN($categ) AND b.brand_id IN($brd)";
        }
        if (!empty($categ) && empty($brd) && !empty($tg)) {
            $code = "SELECT p.product_id,p.image,p.title,p.price,p.description,c.libelle,b.brand_name,t.tag_name FROM products p left join categories c on p.categ_id = c.categ_id left join brand b on p.brand_id = b.brand_id left join products_tags pt on p.product_id = pt.product_id left join tags t on pt.tag_id = t.tag_id WHERE c.categ_id IN($categ) AND t.tag_id IN($tg)";
        }
        if (empty($categ) && !empty($brd) && !empty($tg)) {
            $code = "SELECT p.product_id,p.image,p.title,p.price,p.description,c.libelle,b.brand_name,t.tag_name FROM products p left join categories c on p.categ_id = c.categ_id left join brand b on p.brand_id = b.brand_id left join products_tags pt on p.product_id = pt.product_id left join tags t on pt.tag_id = t.tag_id WHERE b.brand_id IN($brd) AND pt.tag_id IN($tg)";
        }
        if (empty($categ) && !empty($brd) && empty($tg)) {
            $code = "SELECT p.product_id,p.image,p.title,p.price,p.description,c.libelle,b.brand_name,p.brand_id,t.tag_id,t.tag_name FROM products p left join categories c on p.categ_id = c.categ_id left join brand b on p.brand_id = b.brand_id left join products_tags pt on p.product_id = pt.product_id left join tags t on pt.tag_id = t.tag_id WHERE b.brand_id IN($brd)";
        }
        if (empty($categ) && empty($brd) && !empty($tg)) {
            $code = "SELECT p.product_id,p.image,p.title,p.price,p.description,c.libelle,b.brand_name,t.tag_name FROM products p left join categories c on p.categ_id = c.categ_id left join brand b on p.brand_id = b.brand_id left join products_tags pt on p.product_id = pt.product_id left join tags t on pt.tag_id = t.tag_id WHERE pt.tag_id IN($tg)";
        }
        $requete = $this->connexion->prepare($code);
        $requete->execute();
        
        // on verifie si on a au moins un produit
        if ($requete->rowCount() > 0) {
            // on initialise un tableau associatif
            $productsArray = [];
            $productsArray["products"] = [];
            while($row = $requete->fetch(PDO::FETCH_ASSOC)) {
                $row['image'] = URL."images/".$row['image'];
                extract($row);
                $prod = [
                    "product_id" => $product_id,
                    "image" =>$image,
                    "title" => $title,
                    "price" => $price,
                    "description" => $description,
                    "libelle" => $libelle,
                    "brand_name" => $brand_name,
                    "tag_name" => $tag_name
                ];
                $productsArray["products"][] = $prod;
            }
            $requete->closeCursor();
            // on envoie le code de reponse 200-ok
            http_response_code(200);
            // on encode les donnees et on envoie
            echo json_encode($productsArray);
        }
    }
       // recuperer les informations d'un produit
       public function getProductById($id_p){
        $req_sql = "SELECT p.product_id,p.image,p.title,p.price,p.description,c.libelle,b.brand_name,t.tag_name FROM products p left join categories c on p.categ_id = c.categ_id left join brand b on p.brand_id = b.brand_id left join products_tags pt on p.product_id = pt.product_id left join tags t on pt.tag_id = t.tag_id WHERE p.product_id = :id_p";
        $requete = $this->connexion->prepare($req_sql);
        $requete->bindValue(":id_p",$id_p,PDO::PARAM_STR);
        $requete->execute();
        if ($requete->rowCount() > 0) {
            $productArray = [];
            $productArray["product"] = [];
            $row = $requete->fetch(PDO::FETCH_ASSOC);
            $row['image'] = URL."images/".$row['image'];
            extract($row);
            $prod = [
                "product_id" => $product_id,
                "image" =>$image,
                "title" => $title,
                "price" => $price,
                "description" => $description,
                "libelle" => $libelle,
                "brand_name" => $brand_name,
                "tag_name" => $tag_name,
            ];
            $productArray["product"][] = $prod;
            $requete->closeCursor();
            // on envoie le code de reponse 200-ok
            http_response_code(200);
            // on encode les donnees et on envoie
            echo json_encode($productArray);
        }
    }
    // public function getProductCart($prd){
    //     $code = "SELECT product_id FROM products WHERE product_id = :product_id";
    //     $req = $this->connexion->prepare($code);
    //     $req->bindValue(":product_id",$prd,PDO::PARAM_STR);
    //     $req->execute();
    //     $prdt = $req->fetchAll(PDO::FETCH_OBJ);
    //     var_dump($prdt);
    // }
    // ajout d'un produit dans la base de donnees

     function addProduct($title,$image,$price,$description,$categ_id,$brand_id,$tags){
        $code_create = "INSERT INTO products SET image=:image,title=:title,price=:price,description=:description,categ_id=:categ_id,brand_id=:brand_id";
        $req_create = $this->connexion->prepare($code_create);
        $image = htmlspecialchars(strip_tags($image));
        $title = htmlspecialchars(strip_tags($title));
        $price = htmlspecialchars(strip_tags($price));
        $description = htmlspecialchars(strip_tags($description));
        $categ_id = htmlspecialchars(strip_tags($categ_id));
        $brand_id = htmlspecialchars(strip_tags($brand_id));

        $req_create->bindParam(":image", $image);
        $req_create->bindParam(":title", $title);
        $req_create->bindParam(":price",$price);
        $req_create->bindParam(":description",$description);
        $req_create->bindParam(":categ_id",$categ_id);
        $req_create->bindParam(":brand_id",$brand_id);
        $req_create->execute();
        $req_create->closeCursor();
        
        
        $code_last_id =  "SELECT LAST_INSERT_ID()";
        $req_last_id = $this->connexion->prepare($code_last_id);
        $req_last_id->execute();
        $result = $req_last_id->fetch();
        $tagsList = explode("-",$tags);
        foreach ($tagsList as $key => $tag_id) { 
            $this->tag_id = $tag_id;
            $code_tags = "INSERT INTO products_tags SET product_id=$result[0],tag_id=:tag_id";
            $req_tags = $this->connexion->prepare($code_tags);
            $this->tag_id = htmlspecialchars(strip_tags($this->tag_id));
            $req_tags->bindParam(":tag_id",$this->tag_id);
            $req_tags->execute();
            $req_tags->closeCursor();
        }
    }
    public function deleteProduct($id){
        $code_delete = "DELETE FROM products WHERE product_id = $id";
        $req_delete = $this->connexion->prepare($code_delete);
        // $this->product_id = htmlspecialchars(strip_tags($this->product_id));
        // $req_delete->bindParam(1,$this->product_id);
        if ($req_delete->execute()) {
            return true;
        }
        else {
            return false;
        }
    }
    // function deleteProduct(){
    //     $code_delete = "DELETE FROM products WHERE product_id = ?";
    //     $req_delete = $this->connexion->prepare($code_delete);
    //     $this->product_id = htmlspecialchars(strip_tags($this->product_id));
    //     $req_delete->bindParam(1,$this->product_id);
    //     if ($req_delete->execute()) {
    //         return true;
    //     }
    //     else {
    //         return false;
    //     }
    // }
}