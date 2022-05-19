<?php
class Brand{
    // proprietes de l'objet
    public $id_brand;
    public $brand_name;

    // constructeur $db pour la connexion a la base de donnees

    public function __construct($db){
        $this->connexion = $db;
    }

       // recuperation de tous les categories
    public function getBrands(){
        // $req_sql = "SELECT id_product,title,price FROM $this->table";
        $req_sql = "SELECT brand_id ,brand_name FROM brand";
        $requete = $this->connexion->prepare($req_sql);
        $requete->execute();
        
        // on verifie si on a au moins un produit
        if ($requete->rowCount() > 0) {
            // on initialise un tableau associatif
            $brandsArray = [];
            $brandsArray["brands"] = [];
            while($row = $requete->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $brd = [
                    "brand_id" => $brand_id,
                    "brand_name" => $brand_name
                ];
                $brandsArray["brands"][] = $brd;
            }
            // on envoie le code de reponse 200-ok
            http_response_code(200);
            // on encode les donnees et on envoie
            echo json_encode($brandsArray);
        }
    }
}   