<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods:POST");
header("Content-Type:application/json");
// if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    // on inclut les fichiers de configuration et l'acces aux donnees
    include("../repositories/Product.php");
    // on instancie la base de donnees
    $data_base = new Database();
    $db = $data_base->getConnexion();

    // on instancie les produits

    $produit = new Product($db);
    // on recupere les informations envoyees
    // $donnees = json_decode(file_get_contents("php://input"));
    if (isset($_GET["title"]) && isset($_GET["image"]) && isset($_GET["price"]) && isset($_GET["description"]) && isset($_GET["categ_id"]) && isset($_GET["brand_id"]) && isset($_GET["tags"])) { 
        $produit->addProduct($_GET["title"],$_GET["image"],$_GET["price"],$_GET["description"],$_GET["categ_id"],$_GET["brand_id"],$_GET["tags"]);
            // la creation a fonctionne
            // on envoie un code de reponse
            http_response_code(201);
            echo json_encode("l'ajout a fonctionne");
    }
      else {
            echo json_encode("l'ajout n'a pas fonctionne");
        }

// }
// else {
//     http_response_code(405);
//     echo json_encode(["message" => "la methode n est pas autorisee"]);
// }