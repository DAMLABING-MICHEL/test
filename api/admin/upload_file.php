<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods:POST");
header("Content-Type:application/json");
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    // include("../config/Database.php");
    // $data_base = new Database();
    // $db = $data_base->getConnexion();
    if (is_uploaded_file($_FILES["product_image"]["tmp_name"])) {
        $tmp_file = $_FILES["product_image"]["tmp_name"];
        $img_name = $_FILES["product_image"]["name"];
        $upload_dir = './images/'.$img_name;
        // requete d'insertion de l'image dans la base de donnees
        $connexion = new PDO("mysql:host=localhost;dbname=upload_file", "root","");
        $code = "INSERT INTO file(name) VALUES($img_name)";
        if (move_uploaded_file($tmp_file, $upload_dir) && $connexion->query($code)) {
            echo("success");
        }
        else {
            echo "failed";
        }
    
    }
}
else {
    echo "la methode n est pas autorisee";
}

