<?php
require ('Model.php');

class Articles extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function recupLesArticles()
    {
        $recupArticles = $this->bdd->prepare("SELECT * FROM `articles`");
        $recupArticles->execute();
        $recupLesArticles = $recupArticles->fetchall(PDO::FETCH_ASSOC);
        return $recupLesArticles;
    }

    public function recupUnArticle($ordreActuel, $sectActuel)
    {

        $recupIdArticle = $this->bdd->prepare("SELECT `id` FROM `articles` WHERE `id_section` = $sectActuel AND `ordre` = $ordreActuel");
        $recupIdArticle->execute();
        $recupUnIdArticle = $recupIdArticle->fetchall(PDO::FETCH_ASSOC);
        /*var_dump($recupUnIdArticle);
        var_dump($recupUnIdArticle['0']['id']);*/
        $id = $recupUnIdArticle['0']['id'];        


        $recupArticle = $this->bdd->prepare("SELECT * FROM `articles` INNER JOIN `images` ON articles.id = images.id_article WHERE images.id_article = $id");
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

    public function boutonArticle($ordreActuel, $sectActuel) /*ajouter id section*/
    {   
        $recupOrdre = $this->bdd->prepare("SELECT max(ordre) FROM articles WHERE id_section = $sectActuel ;");
        $recupOrdre->execute();
        $recupOrdreMax = $recupOrdre->fetchall(PDO::FETCH_ASSOC);
        var_dump($recupOrdreMax);

        $recupOrdre = $this->bdd->prepare("SELECT ordre FROM articles WHERE id_section = $sectActuel ;");
        $recupOrdre->execute();
        $recupOrdres = $recupOrdre->fetchall(PDO::FETCH_ASSOC);
        var_dump($recupOrdres);

        $ordreMax = $recupOrdreMax['0']['max(ordre)'];
        $ordre = [
            'ordreMax' => $ordreMax,
            'ordres' => $recupOrdres
        ];
        return $ordre;

   

    }

}