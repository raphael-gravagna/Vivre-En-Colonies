<?php 
require ("../back/ModelAdmin.php");
session_start();



if($_SESSION['utilisateur'] != '42')
{
?>
    <script> window.location.replace("http://localhost/vivreencolonies/front/section.php")</script>
<?php
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <link rel="stylesheet" href="./css/style.css">
    <title>Boutique</title>
    <style>@import url('https://fonts.googleapis.com/css2?family=Noto+Sans:ital@0;1&display=swap');</style>
</head>
<body>
<?php require 'header.php'; ?>

    <?php /*if($_SESSION["user"] == 42){*/ ?>

    
    <?php /*require 'header.php';*/?>
    <main>
    <form class="boutonadmin" action="admin.php" method="get">
  <button name="element" type="submit" value="documents">Documents</button>
  <button name="element" type="submit" value="utilisateurs">Utilisateurs</button>
  <button name="element" type="submit" value="articles">Articles</button>
  <button name="element" type="submit" value="picto">Picto</button>
  <button name="element" type="submit" value="sections">Sections</button>

    </form>
    <?php 
    if(empty($_POST['id_picto']))
    {
        $_POST['id_picto'] = null;
    }    
    if(empty($_POST['introduction'])) 
    {
        $_POST['introduction'] = null;
    }
    if(empty($_POST['ordre'])) 
    {
        $_POST['ordre'] = null;
    }
    if(empty($_GET['element'])) 
    {
        $_GET['element'] = null;
    }

    if(empty($_GET['modif'])) 
    {
        $_GET['modif'] = null;
    }
    if(empty($_POST['nom'])) 
    {
        $_POST['nom'] = null;
    }
    if((isset($_POST['document'])) && !empty($_POST['document'])) 
    {
        $texte = $_POST['texte'];
        $titre = $_POST['titre'];
    }
    else 
    {
        $texte = null;
        $titre = null;
    }

    if((isset($_GET['modif'])) && !empty($_GET['modif'])) 
    {
        $id = $_GET['modif'];
    }
    else 
    {
        $id = null;
    }

    ///*Picto*////
if(isset($_GET['element']) && $_GET['element'] == 'picto' ) 
{ ?>
        <form class="textareaadmin" action="" method="POST" enctype="multipart/form-data">
            <label for="photo">Choisir une image</label>
            <input type="file" accept="image/png, image/jpeg, image/jpg, image/webp" name="image"> 
            <input type="radio" name="pays" type="checkbox" id="pays" value="vanuatu">Vanuatu
            <input type="radio" name="pays" type="checkbox" id="pays" value="caledonie">Nouvelle-Calédonie
            <input type="submit" class="boutonvalidation" name="valider" value="valider">
        </form>
        <div id="pictopad">
        <div class="flexpicto">

        
<?php
    
    $admincontenu = new Admin();
    $recupLesPictos = $admincontenu->recupLesPictos();
    foreach($recupLesPictos as $recupLesPicto) 
    {?>
                <img class="pictoadmin" src="<?php echo $recupLesPicto['lien']; ?>" alt="">
        <?php 

    } ?>
                </div>
                </div>




<?php       if( isset($_POST['pays'])  
            &&  isset($_FILES['image']) //['size'] > 0 /*&& $_FILES['image']['size'] < 400000*/ 
            &&  isset($_POST['valider'])) 
            {            
                //var_dump($_FILES);
                $donnéesImageLien = 'images\\'.$_FILES['image']['name'];//.$_FILES['image']['name'];
                $donnéesImageTmp = $_FILES['image']['tmp_name'];
                $pays = $_POST['pays'];

                $admincontenu = new Admin();
                $admincontenu->creerUnPicto( $pays, $donnéesImageTmp, $donnéesImageLien);?>
                <script> window.location.replace("http://localhost/vivreencolonies/front/admin.php?element=picto")</script>
<?php
            }
}


///*Articles*////

if($_GET['element'] == 'articles' && !isset($_GET['section']) && empty($_GET['section']))
{ ?>
    <form class="boutonadmin" action="admin.php" method="get">
    <button name="element" type="submit" value="creerarticle">Créer un article</button>
    <button name="element" type="submit" value="ordrearticle">Changer l'ordre d'affichage des articles</button>
    </form>
    <div class="">
    <?php
    $admincontenu = new Admin();
    $recupSections = $admincontenu->recupLesSections();
    foreach($recupSections as $recupSection) 
    {
    ?>  
        <a class="textareaadmin" href="./admin.php?element=articles&amp;section=<?=$recupSection['id']?>"><?=$recupSection['nom']?> / </a>
    <?php
    }
    ?>
    </div>

    <?php

    if($_GET['element'] == 'articles' && $_GET['modif'] !== 0 && !empty($_GET['modif'])) 
    {
        $id = $_GET['modif'];
        //var_dump($_GET['modif']);
        $admincontenu = new Admin();
        $recupUnArticle = $admincontenu->recupUnArticle($id);

        //var_dump($recupUnArticle);

        $idArticle = $recupUnArticle['ArticleImage']['0']['id'];
        $articleEnLigne = $recupUnArticle['ArticleImage']['0']['en_ligne'];
        $sectionArticle = $recupUnArticle['ArticleImage']['0']['id_section'];

        $titreArticle = $recupUnArticle['ArticleImage']['0']['titre'];
        $cartelArticle = $recupUnArticle['ArticleImage']['0']['cartel'];
        $noticeArticle = $recupUnArticle['ArticleImage']['0']['notice'];
        $lienImg = $recupUnArticle['ArticleImage']['0']['lien'];
        $lienImgBd = $recupUnArticle['ArticleImage']['0']['lien_bd'];
        $ordreArt = $recupUnArticle['ArticleImage']['0']['ordre'];
        $picto = $recupUnArticle['picto']['0']['lien'];
        $id_picto_actuel = $recupUnArticle['picto']['0']['id'];
        //var_dump($recupUnArticle);

        $admincontenu = new Admin();
        $recupOrdres = $admincontenu->recupOrdre($sectionArticle);
        //var_dump($recupOrdres);

        //var_dump($recupUnArticle);
        ?>
        <div class="textareaadmin">
        <h1>Modification de l'article</h1>
        <h3>Ordre d'affichage</h3>
        <form method="post">
            <select name="ordre">
            <option value="<?=$ordreArt?>"><?=$ordreArt?></option>
                <?php foreach($recupOrdres as $recupOrdre) 
                {?>

                    <option value="<?=$recupOrdre['ordre']?>"><?=$recupOrdre['ordre']?></option>
                <?php         $ordreAncien = $recupOrdre['ordre'];

                }?>
            </select>
            <input type="submit" name="modifierordre" value="Modifier" method="POST"> 
        </form>
        <?php if(isset($_POST['modifierordre']))
        {   
            $ordreModif = $_POST['ordre'];
            //var_dump($ordreModif);
            $admincontenu = new Admin();
            $recupOrdres = $admincontenu->modifOrdre($id, $ordreModif);
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <h3>Titre</h3>
            <input type="text" id="titre" name="titre" value="<?=$titreArticle?>">
            
            <h3>Cartel</h3>
            <textarea id="cartel" name="cartel" class="texterg" rows="4"><?=$cartelArticle ?></textarea>


            <h3>Notice</h3>
            <textarea id="notice" name="notice" class="texterg"><?=$noticeArticle?></textarea> 
            <h1></h1>

            <select name="section">
            <?php 
                $id_section = $sectionArticle;
                $admincontenu = new Admin();
                $recupSection = $admincontenu->recupUneSection($id_section); 
                //var_dump($id_section);
                //var_dump($recupSection);
            ?>
            <option value="<?=$recupSection[0]['id']?>"><?=$recupSection[0]['nom']?></option>
                <?php foreach($recupSections as $recupSection) 
                {?>

                <option value="<?=$recupSection['id']?>"><?=$recupSection['nom']?></option>
            <?php 
                }?>
            </select>
            <h1></h1>
            <input type="submit" name="modifier" value="Modifier" method="POST">
            <input  type="submit" name="supprimer" value="supprimer" method="POST"> 
            <h1></h1>
            <img src="<?php print $lienImg ?>">
            <h3>Remplacer l'image</h3>
        <form action="" method="POST" enctype="multipart/form-data">
        <label for="photo">Choisir une image</label>

        <input type="file" accept="image/png, image/jpeg, image/jpg, image/webp" name="image"> 
        <!-- accept="image/png, image/jpeg, image/jpg, image/webp" -->
        <input type="submit" class="boutonvalidation" name="changerimage" value="changerimage">
        <h1></h1>
        <?php
        if($lienImgBd != "en_attente") 
        {
        ?>
            <img src="<?php print $lienImgBd ?>">

        <?php
        }?>
        <h3>Remplacer l'image basse définition</h3>
        <form action="" method="POST" enctype="multipart/form-data">
        <label for="photo">Choisir une image</label>

        <input type="file" accept="image/png, image/jpeg, image/jpg, image/webp" name="image"> 
        <!-- accept="image/png, image/jpeg, image/jpg, image/webp" -->
        <input type="submit" class="boutonvalidation" name="changerimagebd" value="changerimage">
        <h1></h1>


        <h1></h1>
        <img class="pictoadmin" src="<?php print $picto ?>">

        <?php
        if(isset($_POST['changerimage']) && isset($_FILES['image']))
        {   
            $id = $_GET['modif'];
            $donnéesImageLien = 'images\\'.$_FILES['image']['name'];//.$_FILES['image']['name'];
            //var_dump($donnéesImageLien);
            $donnésImageTMP = $_FILES['image']['tmp_name'];
            $admincontenu = new Admin();
            $rempImage = $admincontenu->remplacerImage($donnésImageTMP, $donnéesImageLien, $id);
        }
        
        if(isset($_POST['changerimagebd']) && isset($_FILES['image']))
        {   
            $id = $_GET['modif'];
            $donnéesImageLien = 'images\\'.$_FILES['image']['name'];//.$_FILES['image']['name'];
            //var_dump($donnéesImageLien);
            $donnésImageTMP = $_FILES['image']['tmp_name'];
            $admincontenu = new Admin();
            $rempImage = $admincontenu->remplacerImagebd($donnésImageTMP, $donnéesImageLien, $id);
        }
            
        ?>
        <div class="flexpicto">

        <?php   
                $admincontenu = new Admin();
                $recupLesPictos = $admincontenu->recupLesPictos();
                ?>
                <?php
                foreach($recupLesPictos as $recupLesPicto) 
                {?>
                <div class="pictoadmin1">
                        <img class="pictoadmin" src="<?php echo $recupLesPicto['lien']; ?>" alt=""> <p><?php echo $recupLesPicto['pays']; ?></p>
                        <input type="radio" id="id_picto" name="id_picto" value="<?php echo $recupLesPicto['id']; ?>">
                </div>
                <?php
                } 
                ?>
                </div>
                <?php 
                /*if(isset($_POST['validerIdPicto']) && isset($_POST['id_picto']) && !empty($_POST['id_picto']));
                {   
                    $id_picto = $_POST['id_picto'];

                }*/
            /*if(isset($_POST['modifierpicto']))
            {    
                $admincontenu = new Admin();
                $recupLesPictos = $admincontenu->recupLesPictos();
                ?>
                <form action="" method="POST">
                <?php
                foreach($recupLesPictos as $recupLesPicto) 
                {?>
                <div>
                        <img src="<?php echo $recupLesPicto['lien']; ?>" alt=""> <p><?php echo $recupLesPicto['pays']; ?></p>
                        <input type="checkbox" id="id_picto" name="id_picto" value="<?php echo $recupLesPicto['id']; ?>">
                </div>
                <?php
                } 
                ?>
                <input type="submit" class="boutonvalidation" name="validerIdPicto" value="validerIdPicto">
                </form>
                <?php 
                if(isset($_POST['validerIdPicto']));
                {   $id_picto = $_POST['id_picto'];
                    $admincontenu = new Admin();
                    $recupSections = $admincontenu->modifPictoArticle($id_picto, $id);
                    var_dump($id);
                    var_dump($id_picto);
                    var_dump($_POST['id_picto']);
                    var_dump($_POST);
                    echo "coucou";
                }
            }*/
        ?>
        </form>
        </div>

        <?php
        if( isset($_POST['titre']) 
        && isset($_POST['cartel']) 
        &&  isset($_POST['section']) 
        &&  isset($_POST['notice']) 
        &&  isset($_POST['modifier'])) 
    {   
        $id = $_GET['modif'];
        $id_section = $_POST['section'];
        $titre = $_POST['titre'];
        $cartel = $_POST['cartel'];
        $notice = $_POST['notice'];
        /*if(empty($_POST['id_picto'])) 
        {
            $_POST['id_picto'] = $id_picto_actuel;
        }*/
            if($_POST['section'] != $sectionArticle)
            { 
                $admincontenu = new Admin();
            $modifArticle = $admincontenu->modifSectionOrdreArticle($id, $id_section);
    

            }
        $id_pictoMA = $_POST['id_picto'];
        //var_dump($_POST);
        //var_dump($_POST['id_picto']);
        //var_dump($id_pictoMA);
        $admincontenu = new Admin();
        $modifArticle = $admincontenu->modifUnArticle($id, $titre, $cartel, $notice, $id_section, $id_pictoMA, $id_picto_actuel/*, $donnésImageTmp, $donnéesImageLien, $id_picto*/);
        ?>
        <?php

    }

    
        
        if(isset($_POST['supprimer']) && $_GET['modif'] !== 0 && !empty($_GET['modif'])) 
        {
            $id = $recupUnArticle['ArticleImage']['0']['id'];
            $admincontenu = new Admin();
            $section = $admincontenu->supprUnArticle($id);
            
            ?>
            <script> window.location.replace("http://localhost/vivreencolonies/front/admin.php?element=ordrearticle&section=<?php echo $section;?>")</script>
            <?php
                
        }
        ?>
    <?php
    }
    $admincontenu = new Admin();
    $recupLesArticles = $admincontenu->recupLesArticles();
    //var_dump($recupLesArticles);

    ?>

        <div class="textareaadmin">
        <h1>Tous les Articles</h1>
    <table class="tableau-style">
        <thead>
            <th>Titre</th>
            <th>Section</th>
            <th>Id</th>
            <th>Modification</th>
            <th> </th>
            
        </thead>
        <tbody>
            <?php
            foreach($recupLesArticles as $recupLesArticle) 
            {
            ?>
            <tr>
                <td data-label="Date"><?=$recupLesArticle['titre']; ?></td>
                <td data-label="Date"><?=$recupLesArticle['nom']; ?></td>
                <td data-label="Date"><?=$recupLesArticle['id']; ?></td>
                <td data-label="Date"> <a href="./admin.php?element=articles&amp;modif=<?= $recupLesArticle['id']; ?>">modification</a></td> 
                <?php if($recupLesArticle['en_ligne'] == '0' ) { ?>
                <td data-label="Date"> <a href="./admin.php?element=publiart&amp;modif=<?= $recupLesArticle['id']; ?>">publier</a></td> 
                <?php }?>
            </tr>
        <?php
            }
            ?>
            </table>
            </div>
            <?php

}

if($_GET['element'] == 'articles' && isset($_GET['section']) && !empty($_GET['section']))
{   $section = $_GET['section'];
    $admincontenu = new Admin();
    $recupArticlesParSections = $admincontenu->recupLesArticlesParSection($section);
    $admincontenu = new Admin();
    $recupSections = $admincontenu->recupLesSections();
    ?>
    <div class="">
    <?php
    foreach($recupSections as $recupSection) 
    {
    ?>
        <a class="textareaadmin" href="./admin.php?element=articles&amp;section=<?=$recupSection['id']?>"><?=$recupSection['nom']?> / </a>
    <?php
    }
    ?>
    </div>
    <?php


    ?>
    <div class="">
        <h1>Articles Par section</h1>
    <table class="tableau-style">
        <thead>
            <th>Titre</th>
            <th>Id</th>
            <th>Ordre</th>
            <th>modif</th>
            <th> </th>
            
        </thead>
        <tbody>
            <?php
            foreach($recupArticlesParSections as $recupArticlesParSection) 
            {
            ?>
            <tr>
            <td data-label="Date"><?=$recupArticlesParSection['titre']; ?></td>
            <td data-label="Date"><?=$recupArticlesParSection['id']; ?></td>
            <td data-label="Date"><?=$recupArticlesParSection['ordre']; ?></td>
            <td data-label="Date"> <a href="./admin.php?element=articles&amp;modif=<?= $recupArticlesParSection['id']; ?>">modification</a></td> 
            </tr>
        </tbody>
        <?php
            }
            ?>
    </table> 
    </div>
<?php
}  
if($_GET['element'] == 'ordrearticle') 
{
    $admincontenu = new Admin();
    $recupSections = $admincontenu->recupLesSections();
    ?>
    <div class="">
        <?php
        foreach($recupSections as $recupSection) 
        {
        ?> 
            <a class="textareaadmin" href="./admin.php?element=ordrearticle&amp;section=<?=$recupSection['id']?>"><?=$recupSection['nom']?>/</a>
        <?php
        } ?>
    </div>

    <?php
    if($_GET['element'] == 'ordrearticle' && isset($_GET['section']))
    {   $section = $_GET['section'];
        $admincontenu = new Admin();
        $recupArticlesParSections = $admincontenu->recupLesArticlesParSection($section); 

        $admincontenu = new Admin();
        $ordreMax = $admincontenu->recupOrdreMax($section);
        //echo $ordreMax;
        ?>
            <h1>Ordre des Articles</h1>
        <table class="tableau-style">
            <thead>
                <th>Titre</th>
                <th>Id</th>
                <th>Ordre</th>
                
            </thead>
            <tbody>
                <?php
                foreach($recupArticlesParSections as $recupArticlesParSection) 
                {
                ?>
                <tr>
                    <td data-label="Date"><?=$recupArticlesParSection['titre']; ?></td>
                    <td data-label="Date"><?=$recupArticlesParSection['id']; ?></td>
                    <td data-label="Date">
                        <form method="post">
                        <label for="quantity"></label>
                        <input type="number" id="ordre" name="ordre[<?=$recupArticlesParSection['id']; ?>]" min="1" max="<?php echo $ordreMax;?>" value="<?=$recupArticlesParSection['ordre']; ?>">
                    </td>
                </tr>
                    
            <?php   //var_dump($recupArticlesParSection);
                        /*$ordre = [
                            'id' => $recupArticlesParSection['id'],
                            'ordreN' => $_POST['ordre']
                        ];
                        $id = $recupArticlesParSection['id'];*/

                        

                        //$ordreN = $_POST['ordre'];
                        if(isset($_POST['valider']))
                        {  
            
                            $id = $recupArticlesParSection['id'];
                                $ordreN = $_POST['ordre'];
                                
                            $admincontenu = new Admin();
                            $recupArticlesParSections = $admincontenu->modifUnOrdre($ordreN, $id); 
                            
                         } 
                    


                    
                }
                ?>
                                </table>

                                        <input class="bouton-admin" type="submit" class="boutonvalidation" name="valider" value="valider">
                        </form>

<?php
        /*if(isset($_POST['valider']))
        {   var_dump($_POST["ordre"]);
            var_dump($recupArticlesParSection['id']);
            $id = $recupArticlesParSection['id'];
            $ligne = '0';
            while ($ligne <= 2)
            {   
                $idArt = $id[$ligne];
                $ordre = $_POST["ordre"][$ligne];
                echo $ordre;
                echo $idArt;
                $ligne++;

            }
        }*/
    }
    ?>


    <?php
}


if($_GET['element'] == 'creerarticle')
{
    $admincontenu = new Admin();
    $recupSections = $admincontenu->recupLesSections();
    $admincontenu = new Admin();
    $recupLesPictos = $admincontenu->recupLesPictos();

?>
    <div class="textareaadmin">
        <h1>Création d'un article</h1>
        <form action="" method="POST" enctype="multipart/form-data">

            <p>Titre de l'article</p>
            <input type="text" id="titre" name="titre">

            <p>Cartel</p>
            <textarea id="cartel" name="cartel" class="texterg" rows="4"></textarea>


            <p>Notice</p>
            <textarea id="notice" name="notice" class="texterg" rows="4"></textarea> 
            <h1></h1>
            <select  name="section">
                <?php foreach($recupSections as $recupSection) 
                {?>

                    <option value="<?=$recupSection['id']?>"><?=$recupSection['nom']?></option>
                <?php 
                }?>
            </select>
            <h1></h1>

            <label for="photo">Choisir une image</label>

            <input type="file" accept="image/png, image/jpeg, image/jpg, image/webp" name="image"> 
            <!-- accept="image/png, image/jpeg, image/jpg, image/webp" -->
            <input type="submit" class="boutonvalidation" name="valider" value="valider">
            <div class="flexpicto">
            <?php
            foreach($recupLesPictos as $recupLesPicto) 
            {?>
            <div class="pictoadmin1">
                    <img class="pictoadmin" src="<?php echo $recupLesPicto['lien']; ?>" alt=""> <p><?php echo $recupLesPicto['pays']; ?></p>
                    <input type="radio" id="id_picto" name="id_picto" value="<?php echo $recupLesPicto['id']; ?>">
            </div>
        <?php
        } ?>
            </div>
    </form>
    </div>
<?php
    if( isset($_POST['titre']) 
        && isset($_POST['cartel']) 
        &&  isset($_POST['section']) 
        &&  isset($_POST['notice']) 
        &&  isset($_POST['id_picto']) 
        &&  isset($_POST['section']) 
        &&  isset($_FILES['image']) //['size'] > 0 /*&& $_FILES['image']['size'] < 400000*/ 
        &&  isset($_POST['valider'])) 
    {
        $id_section = $_POST['section'];
        $titre = $_POST['titre'];
        $cartel = $_POST['cartel'];
        $section = $_POST['section'];
        $notice = $_POST['notice'];
        $donnésImageLien = 'images\\'.$_FILES['image']['name'];//.$_FILES['image']['name'];
        $donnésImageTMP = $_FILES['image']['tmp_name'];
        $id_picto = $_POST['id_picto'];

        $admincontenu = new Admin();
        $admincontenu->creerUnArticle(  $titre, $cartel, $notice, 
                                        $id_section, $donnésImageTMP, $donnésImageLien, $id_picto);
        ?>
        <script> window.location.replace("http://localhost/vivreencolonies/front/admin.php?element=articles")</script>
        <?php


    }
}


///*Sections*///
if(isset($_GET['element']) && $_GET['element'] == 'sections' ) 
{ ?>
    <form class="boutonadmin" action="admin.php" method="get">
    <button name="element" type="submit" value="creersection">Créer une section</button>
    </form>

    <?php
    $admincontenu = new Admin();
    $recupSections = $admincontenu->recupLesSections();
    ?>
    <div class="textareaadmin">
    <h1>Sections</h1>
    </div>
    <table class="tableau-style">
      <thead>
          <th>Nom</th>
          <th>Id</th>
          <th>Introduction</th>
          <th>Modification</th>
          
      </thead>
      <tbody>
          <?php
          foreach($recupSections as $recupSection)
          {
          ?>
          <tr>
          <td data-label="Date"><?=$recupSection['nom'] ?></td>
              <td data-label="Date"><?=$recupSection['id'] ?></td>
              <td data-label="Date"><?=substr($recupSection['introduction'], 0, 100) ?>...</td>
              <td> <a href="./admin.php?element=sections&amp;modif=<?= $recupSection['id']; ?>">modification</a></td> 

          </tr>
          <?php
          }
          if($_GET['element'] == 'sections' && $_GET['modif'] !== 0 && !empty($_GET['modif'])) {
            $_GET['modif'] = $id;
            $admincontenu = new Admin();
            $recupUneSection = $admincontenu->recupUneSection($id);
            ?>
        <div class="textareaadmin">

        <h1>Modification de la section</h1>
            <form method="POST">
                <label for="nom">nom de section</label>
                <input type="text" id="nom" name="nom" class="form-control" class="texterg" value="<?=$recupUneSection['0']['nom'] ?>">
                <h1></h1>
                <textarea id="introduction" name="introduction" class="texterg" rows="12">
                    <?php $document = $recupUneSection['0']['introduction'];
                    echo stripslashes($document); ?>
                </textarea>
                <h1></h1>
                <input type="submit" name="modifier" value="Modifier">
                <input  type="submit" name="supprimer" value="supprimer" method="POST"> 
            </form>
        </div>

        <?php     
        if(isset($_POST['nom']) && isset($_POST['introduction']) && isset($_POST['modifier'])) 
        {   
            $introduction = $_POST['introduction'];
            $nom = $_POST['nom'];
            $admincontenu = new Admin();
            $modifUneSection = $admincontenu->modifUneSection($id, $nom, $introduction);
                  }

        }

        if(isset($_POST['supprimer']) && $_GET['modif'] !== 0 && !empty($_GET['modif'])) 
        {
            $admincontenu = new Admin();
            $supprSection = $admincontenu->supprSection($id); ?>
            <script> window.location.replace("http://localhost/vivreencolonies/front/admin.php?element=sections")</script>
            <?php
                
        }

}


if($_GET['element'] == 'creersection') 
{
    $introduction = $_POST['introduction'];
    $nom = $_POST['nom'];
    $nom = stripslashes($nom);
    ?>
    <div class="textareaadmin">
        <form method="POST">
            <label for="nom">nom de section</label>
            <h1></h1>
            <input class="texterg" type="text" id="nom" name="nom" class="form-control" value=" ">
            <h1></h1>
            <p>Introduction de section</p>
            <textarea class="texterg" id="introduction" name="introduction">
            </textarea>
            <h1></h1>
            <input type="submit" name="creer" value="Créer">
        </form>
    </div>
        
        <?php
        if(isset($_POST['nom']) && isset($_POST['introduction']) && strlen($nom) > 1)
        {
            $admincontenu = new Admin();
            $creerUneSection = $admincontenu->creerUneSection($nom, $introduction);
        ?>
            <script> window.location.replace("http://localhost/vivreencolonies/front/admin.php?element=sections")</script>
            <?php

        }

}
    ////*Documents*/////
if(isset($_GET['element']) && $_GET['element'] == 'documents' ) 
{ 
    $admincontenu = new Admin();
    $recupDocs = $admincontenu->recupLesDoc($id); ?>
        <div class="textareaadmin">
        <h1>Documents</h1>
        <table class="tableau-style">
            <thead>
                <th>id</th>
                <th>titre</th>
                <th>texte</th>
                <th>modification</th>
            </thead>
            <tbody>
                <?php
                foreach($recupDocs as $recupDoc)
                {
                ?>
                  <tr>
                    <td data-label="Date"><?=$recupDoc['id'] ?></td>
                    <td data-label="Date"><?=$recupDoc['titre'] ?></td>
                    <td data-label="Date"><?=substr($recupDoc['texte'], 0, 100) ?>...</td>
                    <td> <a href="./admin.php?element=document&amp;modif=<?= $recupDoc['id']; ?>">modification</a></td> 
                  </tr>

                  <?php
                  //var_dump($getDoc);
                }
                  ?>
                  </table>
                  </div>

                  
                  
<?php 
} 

if($_GET['element'] == 'document' && $_GET['modif'] !== 0 && !empty($_GET['modif'])) 
{
    $admincontenu = new Admin();
    $recupUnDoc = $admincontenu->recupUnDoc($id);  
    //var_dump($getOnedoc); ?>
    <div class="textareaadmin">
        <h1>Modification de la documentation</h1>
        <form method="POST">
            <textarea name="titre" class="texterg">
                <?php $titre = $recupUnDoc[0]['titre'];
                echo stripslashes($titre);
                ?>
            </textarea>
                <h1></h1>
                <textarea name="texte" class="texterg" rows="12">
                    <?php $document = $recupUnDoc[0]['texte'];
                    echo stripslashes($document); ?>
                </textarea>
                
                <h1></h1>
                    <input type="submit" name="modifier" value="Modifier">
            </form>
        </div>
        <?php

    if(isset($_POST['titre']) && isset($_POST['texte']) && isset($_POST['modifier'])  && strlen($texte) <= 10000) 
    {
        $texte = $_POST['texte'];
        $titre = $_POST['titre'];
        echo $id;
        $admincontenu = new Admin();
        $modifDoc = $admincontenu->modifUnDoc($id, $texte, $titre);
        ?>
        <script> window.location.replace("http://localhost/vivreencolonies/front/admin.php?element=documents")</script>
<?php
    }

}?>

    <?php
    ///*Utilisateurs*///
    if(isset($_GET['element']) && $_GET['element'] == 'utilisateurs' ) 
    {
    ?>   
    <form class="boutonadmin" action="admin.php" method="get">
        <button name="element" type="submit" value="creerutilisateur">Créer un utilisateur</button>
    </form>
    <?php
    $admincontenu = new Admin();
    $recupUtilisateurs = $admincontenu->recupLesUtilisateurs(); ?>
    <div class="textareaadmin">
    <h1>Utilisateurs</h1>
    <table class="tableau-style">
    <thead>
        <th>id</th>
        <th>nom</th>
        <th>email</th>
        <th>droits</th>
        <th>lien</th>
    </thead>

    <tbody>
        <?php
        foreach($recupUtilisateurs as $recupUtilisateur)
        {
            ?>
            <tr>
            <td data-label="Date"><?=$recupUtilisateur['id'] ?></td>
                <td data-label="Date"><?=$recupUtilisateur['nom'] ?></td>
                <td data-label="Date"><?=$recupUtilisateur['email'] ?></td>
                <td data-label="Date"><?=$recupUtilisateur['id_droit'] ?></td>
                <td> <a href="./admin.php?element=utilisateurs&amp;modif=<?= $recupUtilisateur['id']; ?>">Modifier un utilisateur</a></td> 
            </tr>

            <?php
        //var_dump($getDoc);
        }
    }
        ?>
        </table>
        </div>

<?php if($_GET['element'] == 'utilisateurs' && isset($_GET['modif'])) 
{
    $_GET['modif'] = $id;
    $admincontenu = new Admin();
    $recupUtilisateur = $admincontenu->recupUnUtilisateur($id);
    if(empty($recupUtilisateur)) 
    {
        $recupUtilisateur['0']['id_droit'] = " ";
        $recupUtilisateur['0']['nom'] = " ";
        $recupUtilisateur['0']['email'] = " ";
        echo "Cet utilisateur n'existe pas";
    }?>
    <div class="textareaadmin">
        <h1>Modification de l'utilisateur</h1>
        <form method="POST">
                    
            <label for="nom">nom d'utilisateur</label>
            <input type="text" id="nom" name="nom" class="form-control" value="<?=$recupUtilisateur['0']['nom'] ?>">
        
        
            <label for="email">email</label>
            <input type="text" id="email" name="email"  class="form-control" value="<?= $recupUtilisateur['0']['email'] ?>">
        
            <label for="id_droits">id_droits</label>
            <input type="text" id="id_droit" name="id_droit"  class="form-control" value="<?= $recupUtilisateur['0']['id_droit'] ?>">

            <input type="submit" name="modifier" value="Modifier">
            <input  type="submit" name="supprimer" value="supprimer" method="POST"> 

        </form>
    </div>

    <?php if(isset($_POST['modifier']) && !empty($_POST['nom']) && !empty($_POST['email']) && !empty($_POST['id_droit'])) 
    {
        $id = $_GET['modif'];
        $nom = $_POST['nom'];
        $email = $_POST['email'];
        $id_droit = $_POST['id_droit'];
        $admincontenu = new Admin();
        $modifUser = $admincontenu->modifUnUtilisateur($id, $nom, $email, $id_droit);

    }
    if(isset($_POST['supprimer']) && $_GET['modif'] !== 0 && !empty($_GET['modif'])) 
    {
        $admincontenu = new Admin();
        $supprUtilisateur = $admincontenu->supprUnUtilisateur($id);
        unset($_GET); ?>
                <script> window.location.replace("http://localhost/vivreencolonies/front/admin.php?element=utilisateurs")</script>
        <?php
        
    }
}
if($_GET['element'] == 'creerutilisateur') 
{ ?>
    <div class="">
    <form class="formContainer" action="" method="post">
    <h1>INSCRIPTION</h1>
        <?php /*echo $message;*/ ?>
        <?php if(isset($_SESSION['message'])){echo $_SESSION['message'];} ?>
        <p><input type="text" id="nom" name="nom" class="zonetext" placeholder="Login..."></p>
        <p><input type="text" id="email" name="email" class="zonetext" placeholder="Mail ..."></p>
        <p><input type="mdp" id="mdp" name="mdp" class="zonetext" placeholder="Mot de passe ..."></p>
        <p><input type="password" id="confirmation_mdp" name="confirmation_mdp" class="zonetext"  placeholder="Password Confirmation ..."></p>
        <p style="color:red" id="erreur"></p>
        <p><input type="submit" id="#button" class="boutonvalidation" name="submit" value="Envoyer"></p> 
        </form>
        
    <script type="text/javascript">
    let btnEnvoyer = document.getElementById('#button');

    btnEnvoyer.addEventListener("click", function(e) {
        //récupérer les données du formulaires
        var erreur;
        nom = document.querySelector("#nom")
        email = document.querySelector("#email")
        mdp = document.querySelector("#mdp")
        confirmation_mdp = document.querySelector("#confirmation_mdp")
        console.log(nom.value);

        //Vérification si le formulaire n'est pas vide 
        if (!confirmation_mdp.value){
            erreur = "Veuillez renseigner votre password_retype";
        }

        if (!mdp.value){
            erreur = "Veuillez renseigner votre password";
        }

        if (!email.value){
            erreur = "Veuillez renseigner votre email";
        }
        
        if (!nom.value){
            erreur = "Veuillez renseigner votre Login";
        }

        if(mdp.value != confirmation_mdp.value){
            erreur = "Veuillez rentrer des Passwords indentiques";
        }

        if(erreur){
            e.preventDefault();
            document.querySelector("#erreur").innerHTML = erreur;
            return false;
        }else{
            
        }
    })
</script>
    </div>
        <?php
    if(isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['mdp']) && isset($_POST['confirmation_mdp']) && strlen($_POST['nom']) > 1)
    {
        $nom = htmlspecialchars($_POST['nom']);
        $email = htmlspecialchars($_POST['email']);
        $mdp = htmlspecialchars($_POST['mdp']);
        $confirmation_mdp = htmlspecialchars($_POST['confirmation_mdp']);

        //Si le password et le password_retype identiques alors je crypte le mdp et j'appel la fonction d'inscription 
            if($mdp === $confirmation_mdp){
            $mdp = password_hash($mdp, PASSWORD_BCRYPT);
            $utilisateur = new Admin();
            $utilisateur->Inscription($nom, $email, $mdp);
            ?>
                <script> window.location.replace("http://localhost/vivreencolonies/front/admin.php?element=utilisateurs")</script>
        <?php
        }
        else{
        $message = 'Passwords non-identiques';
        }
    }




}


if($_GET['element'] == 'publiart' && isset($_GET['modif']) && !empty($_GET['modif']))
{
    $id = $_GET['modif'];
    //var_dump($_GET['modif']);
    $admincontenu = new Admin();
    $recupUnArticle = $admincontenu->recupUnArticle($id); 

    //var_dump($recupUnArticle);

    $idArticle = $recupUnArticle['ArticleImage']['0']['id'];
    $articleEnLigne = $recupUnArticle['ArticleImage']['0']['en_ligne'];
    $sectionArticle = $recupUnArticle['ArticleImage']['0']['id_section'];

    $titreArticle = $recupUnArticle['ArticleImage']['0']['titre'];
    $cartelArticle = $recupUnArticle['ArticleImage']['0']['cartel'];
    $noticeArticle = $recupUnArticle['ArticleImage']['0']['notice'];
    $lienImg = $recupUnArticle['ArticleImage']['0']['lien'];
    $lienImgBd = $recupUnArticle['ArticleImage']['0']['lien_bd'];
    $picto = $recupUnArticle['picto']['0']['lien'];
    $id_picto_actuel = $recupUnArticle['picto']['0']['id'];
    //var_dump($recupUnArticle);

    ?>
            <h1><?= $titreArticle;  ?></h1>
        <img src="<?php print $lienImg ?>">
        <form action="" method="POST" enctype="multipart/form-data">
        <label for="photo">Choisir une image</label>

        <input type="file" accept="image/png, image/jpeg, image/jpg, image/webp" name="image"> 
        <!-- accept="image/png, image/jpeg, image/jpg, image/webp" -->
        <input type="submit" class="boutonvalidation" name="valider" value="valider">
        </form>
        <img src="<?php print $picto ?>">
        <p><?= $cartelArticle; ?></p>
        <p><?= $noticeArticle; ?></p>
        <a href="./admin.php?element=articles&amp;modif=<?= $idArticle; ?>">modification</a>
        <form method="post">
        <input type="submit" class="boutonvalidation" name="publier" value="publier">
        </form>

    <?php
    if(isset($_POST['valider']) && isset($_FILES['image']))
    {   
        echo "coucou";
        $id = $_GET['modif'];
        $donnéesImageLien = 'images\\'.$_FILES['image']['name'];//.$_FILES['image']['name'];
        //var_dump($donnéesImageLien);
        $donnésImageTMP = $_FILES['image']['tmp_name'];
        $admincontenu = new Admin();
        $admincontenu->inserImageBd($donnésImageTMP, $donnéesImageLien, $id);
    }


    if(isset($_POST['publier'])) 
    {
        $admincontenu = new Admin();
        $admincontenu->publierArticle($idArticle);
        ?>
        <script> window.location.replace("http://localhost/vivreencolonies/front/admin.php?element=articles")</script>
        <?php
    }

 
        ?>

        <?php
    

    /*if(isset($_POST['changerimage']) && isset($_FILES['image']))
    {   
        $id = $_GET['modif'];
        $donnéesImageLien = 'images\\'.$_FILES['image']['name'];//.$_FILES['image']['name'];
        var_dump($donnéesImageLien);
        $donnésImageTMP = $_FILES['image']['tmp_name'];
        $admincontenu = new Admin();
        $rempImage = $admincontenu->remplacerImage($donnésImageTMP, $donnéesImageLien, $id);
    }*/



//publierArticle($idArticle)
}



                  

                
                
?>

                
                
                  
                  
</main>


</body>
</html>