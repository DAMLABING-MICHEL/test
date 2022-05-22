<?php
// classe de connexion a la base de donnees
  class Database{
    //  variables de connexion
    private $host = "localhost";
    private $dbname = "productsdb";
    private $user = "root";
    private $password = "";
    private $connexion;
    
    public function getConnexion(){
        $this->connexion = null;

        try {
           $this->connexion = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname, $this->user,$this->password);
           $this->connexion->exec("set names utf8"); 
        } catch (PDOException $e) {
            echo("erreur de connexion a la base de donnees:") .$e->getMessage();
        }
        return $this->connexion;
    }
 }