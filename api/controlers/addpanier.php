<?php
include_once("../repositories/Product.php");
include_once("../repositories/Panier.php");
 define("URL", str_replace("addpanier.php","",(isset($_SERVER['HTTPS'])? "https" : "http").
 "://".$_SERVER['HTTP_HOST'].$_SERVER["PHP_SELF"]));
header("Access-Control-Allow-Origin: *");
header("Content-Type:application/json");
    if (isset($_GET["product_id"])) {
        if (empty($_GET["product_id"])) {
            echo json_encode("ce produit n'existe pas!");
        }
        $data_base = new Database();
        $db = $data_base->getConnexion();
        // on instancie un nouveau panier
        $panier = new Panier($db);
        $panier->getProductCart($_GET["product_id"]);
    }
    elseif (isset($_GET["panier"])) {
        if (isset($_GET["del"])) {
            $data_base = new Database();
            $db = $data_base->getConnexion();
            // on instancie un nouveau panier
            $panier = new Panier($db);
            $panier->delete($_GET["del"]);
        }
        elseif (isset($_GET["products"])) {
            $data_base = new Database();
            $db = $data_base->getConnexion();
            // on instancie un nouveau panier
            $panier = new Panier($db);
            $panier->count();
        }
        elseif (isset($_GET["total"])) {
            $data_base = new Database();
            $db = $data_base->getConnexion();
            // on instancie un nouveau panier
            $panier = new Panier($db);
            $panier->total($_GET["total"]);
        }
        else {
            $data_base = new Database();
            $db = $data_base->getConnexion();
            // on instancie un nouveau panier
            $panier = new Panier($db);
            $panier->viewPanier();
        }
    }
    else {
        echo json_encode("vous n'avez pas selectionne de produit a ajouter au panier");
    }
