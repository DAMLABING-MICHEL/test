<?php
class Tag{
    // proprietes de l'objet
    public $tag_id;
    public $tag_name;

    // constructeur $db pour la connexion a la base de donnees

    public function __construct($db){
        $this->connexion = $db;
    }

       // recuperation de tous les categories
   public function getTags(){
    // $req_sql = "SELECT id_product,title,price FROM $this->table";
    $req_sql = "SELECT tag_id ,tag_name FROM tags";
    $requete = $this->connexion->prepare($req_sql);
    $requete->execute();       
     // on verifie si on a au moins un produit
     if ($requete->rowCount() > 0) {
         // on initialise un tableau associatif
         $tagsArray = [];
         $tagsArray["tags"] = [];
         while($row = $requete->fetch(PDO::FETCH_ASSOC)) {
             extract($row);
             $tg = [
                 "tag_id" => $tag_id,
                 "tag_name" => $tag_name
             ];
             $tagsArray["tags"][] = $tg;
         }
         // on envoie le code de reponse 200-ok
         http_response_code(200);
         // on encode les donnees et on envoie
         echo json_encode($tagsArray);
     }
}
} 