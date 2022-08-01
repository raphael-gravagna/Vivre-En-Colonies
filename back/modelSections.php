<?php
require ('Model.php');

class Section extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function minOrdre($id_section)
    {
        $recupOrdre = $this->bdd->prepare("SELECT min(ordre) FROM articles WHERE id_section = $id_section ;");
        $recupOrdre->execute();
        $recupOrdreMin = $recupOrdre->fetchall(PDO::FETCH_ASSOC);
        //var_dump($recupOrdreMin);
        return $recupOrdreMin;
    }


    
    public function recupLesSections()
    {
        //SELECT sections.id, sections.nom, images.lien FROM `sections` INNER JOIN articles ON articles.id_section = sections.id INNER JOIN images ON images.id_article = articles.id
    $recupSection = $this->bdd->prepare("SELECT `nom`, `id`  FROM `sections`");
    $recupSection->execute();
    $recupLesSections = $recupSection->fetchall(PDO::FETCH_ASSOC);
    return $recupLesSections;
    }

    public function recupLesArticlesParSection($section)
    {
        $recupArticlesParSection = $this->bdd->prepare("SELECT * FROM `articles` INNER JOIN `images` ON articles.id = images.id_article WHERE articles.id_section = $section AND articles.en_ligne = 1");
        $recupArticlesParSection->execute();
        $recupLesArticlesParSection = $recupArticlesParSection->fetchall(PDO::FETCH_ASSOC);
        return $recupLesArticlesParSection;
    }

    public function recupUneSection($id_section)
    {
    $recupSection = $this->bdd->prepare("SELECT * FROM `sections` WHERE `id` = $id_section");
    $recupSection->execute();
    $recupUneSection = $recupSection->fetchall(PDO::FETCH_ASSOC);
    return $recupUneSection;
    //var_dump($recupUneSection);
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