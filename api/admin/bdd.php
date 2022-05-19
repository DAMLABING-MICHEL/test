<?php
try{
    $connect = new PDO("mysql:host=localhost;dbname=upload_file","root","");
}
catch(PDOException $e){
    die("erreur de connexion a la base de donnees:".$e->getMessage());
}