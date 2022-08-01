<?php
require ('Model.php');

class Articles extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function recupLesSections($sectActuel)
    {
    $recupSection = $this->bdd->prepare("SELECT * FROM `sections` INNER JOIN articles WHERE articles.id_section = $sectActuel");
    $recupSection->execute();
    $recupLesSections = $recupSection->fetchall(PDO::FETCH_ASSOC);
    return $recupLesSections;
    }

    public function recupLesArticles()
    {
        $recupArticles = $this->bdd->prepare("SELECT * FROM `articles` AND articles.en_ligne = 1 ");
        $recupArticles->execute();
        $recupLesArticles = $recupArticles->fetchall(PDO::FETCH_ASSOC);
        return $recupLesArticles;
    }

    public function recupUnArticle($ordreActuel, $sectActuel)
    {

        $recupIdArticle = $this->bdd->prepare("SELECT `id` FROM `articles` WHERE `id_section` = $sectActuel AND `ordre` = $ordreActuel AND articles.en_ligne = 1");
        $recupIdArticle->execute();
        $recupUnIdArticle = $recupIdArticle->fetchall(PDO::FETCH_ASSOC);

        $id = $recupUnIdArticle['0']['id'];        
        /*if($recupUnIdArticle['0']['id'] == null)
        {
            echo "nopnop";
        }*/

        $recupArticle = $this->bdd->prepare("SELECT * FROM `articles` INNER JOIN `images` ON articles.id = images.id_article WHERE images.id_article = $id AND articles.en_ligne = 1");
        $recupArticle->execute();
        $recupUnArticle = $recupArticle->fetchall(PDO::FETCH_ASSOC);
        $id_picto = $recupUnArticle['0']['id_picto'];
        $recupPicto = $this->bdd->prepare("SELECT * FROM `pictos` WHERE id = $id_picto");
        $recupPicto->execute();
        $recupUnPicto = $recupPicto->fetchall(PDO::FETCH_ASSOC);
        $recupArticleImagePicto = 
        [
        'ArticleImage' => $recupUnArticle,
        'picto' => $recupUnPicto,
        ];
        return $recupArticleImagePicto;
    }

    public function recupUnPicto($id)
    {
        $recupArticle = $this->bdd->prepare("SELECT * FROM `articles` INNER JOIN `images` ON articles.id = images.id_article WHERE images.id_article = $id");
        $recupArticle->execute();
        $recupUnArticle = $recupArticle->fetchall(PDO::FETCH_ASSOC);
        return $recupUnArticle;
    }

    public function minOrdre($sectActuel)
    {
        $recupOrdre = $this->bdd->prepare("SELECT min(ordre) FROM articles WHERE id_section = $sectActuel AND articles.en_ligne = 1;");
        $recupOrdre->execute();
        $recupOrdreMin = $recupOrdre->fetchall(PDO::FETCH_ASSOC);
        return $recupOrdreMin;
    }

    public function boutonArticle($ordreActuel, $sectActuel)
    {   
        $recupOrdre = $this->bdd->prepare("SELECT max(ordre) FROM articles WHERE id_section = ? AND articles.en_ligne = 1 ;");
        $recupOrdre->execute(array($sectActuel));
        $recupOrdreMax = $recupOrdre->fetchall(PDO::FETCH_ASSOC);

        $recupOrdre = $this->bdd->prepare("SELECT ordre FROM articles WHERE id_section = ? AND articles.en_ligne = 1 ;");
        $recupOrdre->execute(array($sectActuel));
        $recupOrdres = $recupOrdre->fetchall(PDO::FETCH_ASSOC);

        $ordreMax = $recupOrdreMax['0']['max(ordre)'];
        $ordre = [
            'ordreMax' => $ordreMax,
            'ordres' => $recupOrdres
        ];
        return $ordre;

   

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