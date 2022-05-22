<?php
class Category{
    // proprietes de l'objet
    public $categ_id;
    public $libelle;

    // constructeur $db pour la connexion a la base de donnees

    public function __construct($db){
        $this->connexion = $db;
    }

       // recuperation de tous les categories
    public function getCategories(){
        // $req_sql = "SELECT id_product,title,price FROM $this->table";
        $req_sql = "SELECT categ_id ,libelle FROM categories";
        $requete = $this->connexion->prepare($req_sql);
        $requete->execute();
        // on verifie si on a au moins un produit
        if ($requete->rowCount() > 0) {
            // on initialise un tableau associatif
            $categoriesArray = [];
            $categoriesArray["categories"] = [];
            while($row = $requete->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $cat = [
                    "categ_id" => $categ_id,
                    "libelle" => $libelle
                ];
                $categoriesArray["categories"][] = $cat;
            }
            // on envoie le code de reponse 200-ok
            http_response_code(200);
            // on encode les donnees et on envoie
            echo json_encode($categoriesArray);
        }
    }
}   