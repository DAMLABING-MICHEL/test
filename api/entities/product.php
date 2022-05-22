<?php
class Product{
    public $connexion;
    // public $table = "produits";:

    // proprietes de l'objet
    public $id_product;
    public $title;
    public $price;
    public $libelle;

    // constructeur $db pour la connexion a la base de donnees

    public function __construct($db){
        $this->connexion = $db;
    }
}