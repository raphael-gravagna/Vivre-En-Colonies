<?php
require ('Model.php');

class Section extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function recupLesSections()
    {
    $recupSection = $this->bdd->prepare("SELECT `nom`, `id`  FROM `sections`");
    $recupSection->execute();
    $recupLesSections = $recupSection->fetchall(PDO::FETCH_ASSOC);
    return $recupLesSections;
    }

    public function recupLesArticlesParSection($section)
    {
        $recupArticlesParSection = $this->bdd->prepare("SELECT * FROM `articles` INNER JOIN `images` ON articles.id = images.id_article WHERE articles.id_section = $section");
        $recupArticlesParSection->execute();
        $recupLesArticlesParSection = $recupArticlesParSection->fetchall(PDO::FETCH_ASSOC);
        return $recupLesArticlesParSection;
    }


}