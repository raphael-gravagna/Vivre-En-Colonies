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
        $recupOrdre = $this->bdd->prepare("SELECT min(ordre) FROM articles WHERE id_section = $id_section AND articles.en_ligne = 1;");
        $recupOrdre->execute();
        $recupOrdreMin = $recupOrdre->fetchall(PDO::FETCH_ASSOC);
        //var_dump($recupOrdreMin);
        return $recupOrdreMin;
    }
    

    public function recupLesSections()
    {
    $recupSection = $this->bdd->prepare("SELECT `nom`, `id`  FROM `sections`");
    $recupSection->execute();
    $recupLesSections = $recupSection->fetchall(PDO::FETCH_ASSOC);
    return $recupLesSections;
    }

    /*public function recupLesSectionsPleines()
    {
    $recupSection = $this->bdd->prepare("SELECT `nom`, `id`  FROM `sections`");
    $recupSection->execute();
    $recupSections = $recupSection->fetchall(PDO::FETCH_ASSOC);
    //var_dump($recupSections);

    foreach($recupSections as $recupSection) 
    {
        $id_section = $recupSection['id'];
        $recupOrdre = $this->bdd->prepare("SELECT min(ordre) FROM articles WHERE id_section = $id_section AND articles.en_ligne = 1;");
        $recupOrdre->execute();
        $recupOrdreMin = $recupOrdre->fetchall(PDO::FETCH_ASSOC);

        foreach($recupOrdreMin as $recupOrdreMins)
        {
        $tableau = [
            $recupSection['id'] => $recupOrdreMin,
        ];
        var_dump($tableau);
        return $tableau;

        }
    }
    }*/

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