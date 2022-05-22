<?php
//chemin d'accès à la page de connexion administrateur
//www.monsite.fr/admin
try{
    if (!empty($_GET['demande'])) {
        $url = explode("/", filter_var($_GET['demande'],FILTER_SANITIZE_URL));
        switch ($url[0]) {
            case 'manage':
               if (!empty($url[1])) {
                   echo("parametres valides");
               }
               else{
                   throw new Exception("veuillez renseigner le second parametre");
                   
               }
                break;
            
            default:
                # code...
                break;
        }
    }
    else{
        throw new Exception("impossible d'acceder a la page");
    }
}
catch(Exception $e){
    $erreur = ["message:" => $e->getMessage()];
    echo json_encode($erreur);
}