<?php
require ("../back/ModelSection.php");

$admincontenu = new Section();
$recupSections = $admincontenu->recupLesSections();
/*foreach($recupSections as $recupSection) 
{
    $id_section = $recupSection['id'];
    $admincontenu = new Section();
    $minOrdre = $admincontenu->minOrdre($id_section);
    $mO = $minOrdre['0']['min(ordre)'];
    if($mO == NULL)
     {
        
     }
     else {
        $tableaus = [
            "nom" => $recupSection['nom'],
            "id" => $recupSection['id'],
        ];
        var_dump($tableaus);
        //echo $tableaus['id'];
         }
}*/
/*foreach($tableaus as $tableau){
var_dump($tableau['0']['nom']);
}*/

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
    <?php require 'header.php';?>
    <main class="textarea">
    <?php

if(empty($_GET['introduction']) && !isset($_GET['introduction']))
{
    if(isset($_GET["section"]) && !empty($_GET["section"]))
    {
    $section = $_GET["section"];
    }
    else
    {
        $section = NULL;
    }
    
    $admincontenu = new Section();
    $recupLesArticles = $admincontenu->recupLesArticlesParSection($section);
    $admincontenu = new Section();
    $recupSections = $admincontenu->recupLesSections();
    
    //var_dump($recupSections);
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
    
       <a class="sectionVisite" href="section.php?introduction=<?=$recupSection['id']?>"><p><?=$recupSection['nom']?></p></a>
        <?php 
        }
    }
    ?>          
    <div class="cal"></div>

        <div class="ligne"></div>

    </div>
    <?php
}

else
{
    $id_section = $_GET['introduction'];
    $admincontenu = new Section();
    $recupSection = $admincontenu->recupUneSection($id_section);
    $minOrdre = $admincontenu->minOrdre($id_section);
    $mO = $minOrdre['0']['min(ordre)'];
    ?>

        <h1><?=$recupSection[0]['nom']?></h1>
        <p class="texteintro"><?=nl2br($recupSection[0]['introduction'])?> </p>
        

        <?php
        if($mO == NULL)
        {?>
        
            <script> window.location.replace("http://localhost/vivreencolonies/front/section.php")</script>

    
        <?php
        }
        else {?> 
    
       <a class="lienSection" href="articles.php?section=<?=$recupSection[0]['id']?>&article=<?=$mO?>"><p>Continuer votre visite</p></a>
        <?php 
        }
    }
        ?>

    </main>
    <?php require 'footer.php'; ?>

    </body>
    </html>