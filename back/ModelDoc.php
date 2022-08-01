<?php
require ("../back/Model.php");


class Docs extends Model{

    public function __construct(){
        parent::__construct();

    }

    public function recuplesDocs(){
        $id = $_GET['doc'];
        $getDoc = $this->bdd->prepare("SELECT * FROM `documents` WHERE `id` = ?");
        $getDoc->execute(array($id));
        $getDocs = $getDoc->fetchall(PDO::FETCH_ASSOC);
        return $getDocs;
    }

    public function recupUnDoc($id){
        $getDoc = $this->bdd->prepare("SELECT * FROM `documents` WHERE `id` = ?");
        $getDoc->execute(array($id));
        $Doc = $getDoc->fetchall(PDO::FETCH_ASSOC);
        return $Doc;
    }

    public function rLS()
    {
    $recupSection = $this->bdd->prepare("SELECT `nom`, `id`  FROM `sections`");
    $recupSection->execute();
    $recupLesSections = $recupSection->fetchall(PDO::FETCH_ASSOC);
    return $recupLesSections;
    }

    public function mOr($id_section)
    {
        $recupOrdre = $this->bdd->prepare("SELECT min(ordre) FROM articles WHERE id_section = $id_section AND articles.en_ligne = 1;");
        $recupOrdre->execute();
        $recupOrdreMin = $recupOrdre->fetchall(PDO::FETCH_ASSOC);
        //var_dump($recupOrdreMin);
        return $recupOrdreMin;
    }

}
?>