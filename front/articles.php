<?php

require ("../back/ModelArticles.php");

$sectActuel = $_GET['section'];
$ordreActuel = $_GET['article'];

$admincontenu = new Articles();
$recupUnArticle = $admincontenu->recupUnArticle($ordreActuel, $sectActuel);

$idArticle = $recupUnArticle['ArticleImage']['0']['id'];
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
var_dump($ordre);
$ordreMax = $ordre['ordreMax'];



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="">
    <title>Articles</title>
    <style>@import url('https://fonts.googleapis.com/css2?family=Noto+Sans:ital@0;1&display=swap');</style>
</head>
<body>
    <main>
        <h1><?= $titreArticle;  ?></h1>
        <img src="<?php print $lienImg ?>">
        <img src="<?php print $picto ?>">
        <p><?= $cartelArticle; ?></p>
        <p><?= $noticeArticle; ?></p>
    </main>

    <a href="
    <?php 
    /*echo $ordreMax;*/
    $getAjout = "&";
    if($ordreActuel == 0 ) 
        {
            echo "./section.php";
        }

        else
        {
            $precedent = $ordreActuel - 1;
            echo "articles.php?section=" . $sectActuel . $getAjout . "article=" . $precedent;
        }
    ?>">◄</a>

    <a href="
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
    ?>">►</a>
    


</body>
</html>