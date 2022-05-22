<?php
class Category{
    // public $connexion;

    // proprietes de l'objet
    public $id_categ;
    public $libelle;

    // constructeur $db pour la connexion a la base de donnees

    public function __construct($db){
        $this->connexion = $db;
    }
}
