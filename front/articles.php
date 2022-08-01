<?php

require ("../back/ModelArticles.php");

$sectActuel = $_GET['section'];
$ordreActuel = $_GET['article'];

$admincontenu = new Articles();
$recupUnArticle = $admincontenu->recupUnArticle($ordreActuel, $sectActuel);



$idArticle = $recupUnArticle['ArticleImage']['0']['id'];

if($idArticle == null)
{
    $ordreActuel = $_GET['article'] + 1;
    ?>
        <script> window.location.replace("http://localhost/vivreencolonies/front/articles.php?section=<?php echo $sectActuel;?>&article=<?php echo $ordreActuel;?>")</script>
    <?php
}
else
{

$admincontenu = new Articles();
$recupSect = $admincontenu->recupLesSections($sectActuel);

$admincontenu = new Articles();
$recupMinOrdre = $admincontenu->minOrdre($sectActuel);

$minOrdre = $recupMinOrdre['0']['min(ordre)'];
$articleEnLigne = $recupUnArticle['ArticleImage']['0']['en_ligne'];
$sectionArticle = $recupUnArticle['ArticleImage']['0']['id_section'];

$titreArticle = $recupUnArticle['ArticleImage']['0']['titre'];
$cartelArticle = $recupUnArticle['ArticleImage']['0']['cartel'];
$noticeArticle = $recupUnArticle['ArticleImage']['0']['notice'];
$lienImg = $recupUnArticle['ArticleImage']['0']['lien'];
$lienImgBd = $recupUnArticle['ArticleImage']['0']['lien_bd'];
$picto = $recupUnArticle['picto']['0']['lien'];

$admincontenu = new Articles();
$ordre = $admincontenu->boutonArticle($ordreActuel, $sectActuel);
//var_dump($ordre);
$ordreMax = $ordre['ordreMax'];

if($ordreActuel > $ordreMax)
{ 
    ?>
    <script> window.location.replace("http://localhost/vivreencolonies/front/section.php")</script>
    <?php
}
}




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Articles</title>
    <style>@import url('https://fonts.googleapis.com/css2?family=Noto+Sans:ital@0;1&display=swap');</style>
</head>
<body>
<?php require 'header.php'; ?>

    <main classe="mainart">
        <?php
        $taille = getimagesize($lienImg);
        $largeur = $taille[0];
        $hauteur = $taille[1];

        if($hauteur > $largeur) {
            $cssConteneur = "articleVertical";
            $cssImage = "imgVertical";
            $cssCartel = "cartelVertical";
            $cssPicto = "imgPictoArtVertical";

        }
        else {
            $cssConteneur = "articleCarre";
            $cssImage = "imgCarre";
            $cssCartel = "cartelCarre";
            $cssPicto = "imgPictoArtCarre";
        }

        ?>
        <div id="h1index" ><?= $titreArticle;  ?></div>
        <div class="<?= $cssConteneur;  ?>">
        <picture>
            <source media="(max-width:600px)" srcset="<?php print $lienImgBd; ?>" alt="<?= $cartelArticle;  ?>">
            <img class="<?= $cssImage; ?>" src="<?php print $lienImg; ?>" alt="<?= $cartelArticle;  ?>">
        </picture>

                    <div class="<?= $cssCartel;  ?>">
        <img class="<?= $cssPicto;  ?>" src="<?php print $picto ?>">
        <p><?php echo nl2br(stripslashes($cartelArticle)); ?></p>
        </div>



        </div>
        <p class="texteintroArt"><?= $noticeArticle; ?></p>
        </main>

        <?php
        $minOrdre = $minOrdre[0]['min(ordre)'];
         ?>
         <div class="pag">
    <a class="flechegauche" href="
    <?php 
    $getAjout = "&";
    if($ordreActuel == $minOrdre ) 
        {
            echo "./section.php";
        }

        else
        {
            $precedent = $ordreActuel - 1;
            echo "articles.php?section=" . $sectActuel . $getAjout . "article=" . $precedent;
        }
    ?>"></a>

    <a class="flechedroite" href="
    <?php 
    if($ordreActuel >= $ordreMax ) 
        {
            echo "./section.php";
        }

        else
        {
            $ordreActuel = $ordreActuel + 1;
            echo "articles.php?section=" . $sectActuel . $getAjout . "article=" . $ordreActuel;
        }
    ?>"></a>
    </div>
    

    <?php require 'footer.php'; ?>

</body>
</html>