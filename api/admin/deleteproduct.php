<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE");
header("Content-Type:application/json");
// if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    // on inclut les fichiers de configuration et l'acces aux donnees

    include("../repositories/Product.php");
    // on instancie la base de donnees
    $data_base = new Database();
    $db = $data_base->getConnexion();

    // on instancie les produits

    $product = new Product($db);
    // on recupere l'id du produit
    // $data = json_decode(file_get_contents("php://input"));
    try {
        if ($_SERVER["REQUEST_METHOD"] == 'DELETE' ) {
            if (!empty($_GET["request"])) {
                $url = explode("/",filter_var($_GET["request"],FILTER_SANITIZE_URL));
                switch ($url[0]) {
                    case 'products':
                        if (isset($url[1])) {
                            if ($product->deleteProduct($url[1])) {
                                echo json_encode("la suppression a fonctionne");
                            }
                            else {
                                echo json_encode("la suppression n a pas fonctionne");
                            }
                        }
                        break;
                    
                    default:
                        throw new Exception("la demande n' est pas valide,verifiez l'url");
                        break;
                }
            }
        }
        else {
            throw new Exception("la methode n'est pas autorisée");
            
        }
    } 
    catch (Exception $e) {
        $erreur = [
            "message" => $e->getMessage(),
            "code" => $e->getCode()
        ];
        echo(json_encode($erreur));
    }