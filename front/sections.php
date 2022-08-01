<?php
require ("../back/ModelSections.php");

if(isset($_GET["section"]) && !empty($_GET["section"]))
{
$section = $_GET["section"];
}
else
{
    $section = NULL;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Accueil</title>
</head>
<body>
<?php require 'header.php'; ?>

    <main class="textareaSections">

<?php
if(isset($_GET["section"]) && !empty($_GET["section"]))
{
    $id_section = $_GET["section"];
    $admincontenu = new Section();
    $recupSection = $admincontenu->recupUneSection($id_section);
    $admincontenu = new Section();
$recupLesArticles = $admincontenu->recupLesArticlesParSection($section);
    ?>
    <a href="sections.php"><h1><?=$recupSection[0]['nom'];?></h1></a>

    <div class="containerProduits">

    <?php

foreach($recupLesArticles as $recupLesArticle){
    //var_dump($recupLesArticle);
                ?>
                    <div class="produits">
                        <a href="articles.php?section=<?= $recupLesArticle['id_section'] ?>&article=<?= $recupLesArticle['ordre'] ?>"><img src="<?php print $recupLesArticle['lien'] ?>"></a>
                        <p class="titreArtSect"><?= $recupLesArticle['titre']; ?></p>
                        </div>
                    <?php
                    }
                    ?>
                </div> 
                <?php
            }

else {
$admincontenu = new Section();
$recupLesArticles = $admincontenu->recupLesArticlesParSection($section);
$admincontenu = new Section();
$recupSections = $admincontenu->recupLesSections();



?>
    <div class="sectionConteneur">
        <div class="ligne"></div>
        <div class="cal"></div>
<?php
foreach($recupSections as $recupSection) 
{
    $id_section = $recupSection['id'];
    $admincontenu = new Section();
    $minOrdre = $admincontenu->minOrdre($id_section);
    $mO = $minOrdre['0']['min(ordre)'];
    //var_dump($mO);
    if($mO == NULL)
    {?>
        <a href=""></a>

    <?php
    }
    else {?> 

   <a class="sectionVisite" href="sections.php?section=<?=$recupSection['id']?>"><p><?=$recupSection['nom']?></p></a>
    <?php 
    }
}
?>
    <div class="cal"></div>

<div class="ligne"></div>

</div>
<?php
}
?>
    </main>
    <?php require 'footer.php'; ?>
</body>
</html>
