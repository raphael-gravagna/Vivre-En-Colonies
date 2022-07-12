<?php 
require ("../back/ModelAdmin.php");
session_start();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/styleOrdi.css">
    <title>Boutique</title>
    <style>@import url('https://fonts.googleapis.com/css2?family=Noto+Sans:ital@0;1&display=swap');</style>
</head>
<body>
    <?php /*if($_SESSION["user"] == 42){*/ ?>

    
    <?php /*require 'header.php';*/?>
    <main>
    <form action="admin.php" method="get">
  <button name="element" type="submit" value="documents">Documents</button>
  <button name="element" type="submit" value="utilisateurs">Utilisateurs</button>
  <button name="element" type="submit" value="articles">Articles</button>
  <button name="element" type="submit" value="picto">Picto</button>
  <button name="element" type="submit" value="sections">Sections</button>

    </form>
    <?php 
    
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
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="photo">Choisir une image</label>
            <input type="file" accept="image/png, image/jpeg, image/jpg, image/webp" name="image"> 
            <input type="radio" name="pays" type="checkbox" id="pays" value="vanuatu">Vanuatu
            <input type="radio" name="pays" type="checkbox" id="pays" value="caledonie">Nouvelle-Calédonie
            <input type="submit" class="boutonvalidation" name="valider" value="valider">
        </form>
        
<?php
    
    $admincontenu = new Admin();
    $recupLesPictos = $admincontenu->recupLesPictos();
    foreach($recupLesPictos as $recupLesPicto) 
    {?>
            <div class="polaroid_image">
                <img src="<?php echo $recupLesPicto['lien']; ?>" alt=""> <p><?php echo $recupLesPicto['pays']; ?></p>
            </div>
        <?php 
    } ?>



<?php       if( isset($_POST['pays'])  
            &&  isset($_FILES['image']) //['size'] > 0 /*&& $_FILES['image']['size'] < 400000*/ 
            &&  isset($_POST['valider'])) 
            {            
                var_dump($_FILES);
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
    <form action="admin.php" method="get">
    <button name="element" type="submit" value="creerarticle">Créer un article</button>
    <button name="element" type="submit" value="ordrearticle">Changer l'ordre d'affichage des articles</button>
    </form>
    <?php
    $admincontenu = new Admin();
    $recupSections = $admincontenu->recupLesSections();
    foreach($recupSections as $recupSection) 
    {
    ?>
        <a href="./admin.php?element=articles&amp;section=<?=$recupSection['id']?>"><?=$recupSection['nom']?> / </a>
    <?php
    }

    if($_GET['element'] == 'articles' && $_GET['modif'] !== 0 && !empty($_GET['modif'])) 
    {
        $id = $_GET['modif'];
        //var_dump($_GET['modif']);
        $admincontenu = new Admin();
        $recupUnArticle = $admincontenu->recupUnArticle($id); 

        $idArticle = $recupUnArticle['ArticleImage']['0']['id'];
        $articleEnLigne = $recupUnArticle['ArticleImage']['0']['en_ligne'];
        $sectionArticle = $recupUnArticle['ArticleImage']['0']['id_section'];

        $titreArticle = $recupUnArticle['ArticleImage']['0']['titre'];
        $cartelArticle = $recupUnArticle['ArticleImage']['0']['cartel'];
        $noticeArticle = $recupUnArticle['ArticleImage']['0']['notice'];
        $lienImg = $recupUnArticle['ArticleImage']['0']['lien'];
        $lienImgBd = $recupUnArticle['ArticleImage']['0']['lien_bd'];
        $picto = $recupUnArticle['picto']['0']['lien'];
        //var_dump($recupUnArticle);
        ?>
        <h1>Modification de l'article</h1>
        <form method="POST">
            <input type="submit" name="modifier" value="Modifier">
            <input  type="submit" name="supprimer" value="supprimer" method="POST"> 
        </form>
        <h3>id</h3>
        <p><?=$idArticle ?></p>
        <h3>titre</h3>
        <p><?=$titreArticle?></p>
        <h3>cartel</h3>
        <p><?=$cartelArticle ?></p>
        <h3>notice</h3>
        <p><?=$noticeArticle?></p>
        <img src="<?php print $lienImg ?>">
        <img src="<?php print $picto ?>">

        <?php
        if(isset($_POST['supprimer']) && $_GET['modif'] !== 0 && !empty($_GET['modif'])) 
        {
            $id = $recupUnArticle[0]['id'];
            $admincontenu = new Admin();
            $supprArticle = $admincontenu->supprUnArticle($id); ?>
            <script> window.location.replace("http://localhost/vivreencolonies/front/admin.php?element=articles")</script>
            <?php
                
        }
        ?>
    <?php
    }
    $admincontenu = new Admin();
    $recupLesArticles = $admincontenu->recupLesArticles();

    ?>

    
        <h1>Tous les Articles</h1>
    <table class="tableau-style">
        <thead>
            <th>Titre</th>
            <th>Section</th>
            <th>Id</th>
            
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
                <td> <a href="./admin.php?element=articles&amp;modif=<?= $recupLesArticle['id']; ?>">modification</a></td> 

            </tr>
        <?php
            }
            ?></table><?php

}

if($_GET['element'] == 'articles' && isset($_GET['section']) && !empty($_GET['section']))
{   $section = $_GET['section'];
    $admincontenu = new Admin();
    $recupArticlesParSections = $admincontenu->recupLesArticlesParSection($section); 

    ?>
        <h1>Articles Par section</h1>
    <table class="tableau-style">
        <thead>
            <th>Titre</th>
            <th>Id</th>
            <th>modif</th>
            
        </thead>
        <tbody>
            <?php
            foreach($recupArticlesParSections as $recupArticlesParSection) 
            {
            ?>
            <tr>
            <td data-label="Date"><?=$recupArticlesParSection['titre']; ?></td>
            <td data-label="Date"><?=$recupArticlesParSection['id']; ?></td>
            <td> <a href="./admin.php?element=articles&amp;modif=<?= $recupArticlesParSection['id']; ?>">modification</a></td> 
            </tr>
    </table> 
            <?php
            }
}  
/*if($_GET['element'] == 'ordrearticle') 
{
    $admincontenu = new Admin();
    $recupSections = $admincontenu->recupLesSections();
    ?>
    <?php
    foreach($recupSections as $recupSection) 
    {
    ?>
        <a href="./admin.php?element=ordrearticle&amp;section=<?=$recupSection['id']?>"><?=$recupSection['nom']?></a>
    <?php
    }
    if($_GET['element'] == 'ordrearticle' && isset($_GET['section']))
    {   $section = $_GET['section'];
        $admincontenu = new Admin();
        $recupArticlesParSections = $admincontenu->recupLesArticlesParSection($section); 
        ?>
            <h1>Articles</h1>
        <table class="tableau-style">
            <thead>
                <th>Titre</th>
                <th>ordre</th>
                <th>Id</th>
                
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
                        <label for="quantity">ordre d'affichage</label>
                        <input type="number" id="ordre" name="ordre" min="0" max="5" value="<?=$recupArticlesParSection['ordre']; ?>">
                        <input type="submit" class="boutonvalidation" name="valider" value="valider">
                        </form>
                    </td>
                </tr>
                </table>
            <?php
                        if($recupArticlesParSection['ordre'] != $_POST['ordre'])
                        {  
                            var_dump($recupArticlesParSection['ordre']);
                            var_dump($_POST['ordre']);
                            echo "une modification";
                        }
                    
                }
                ?>

<?php
        if(isset($_POST['valider']))
        {   var_dump($_POST["ordre"]);
            var_dump($recupArticlesParSection['id']);
            /*$id = $recupArticlesParSection['id'];
            $ligne = '0';
            while ($ligne <= 2)
            {   
                $idArt = $id[$ligne];
                $ordre = $_POST["ordre"][$ligne];
                echo $ordre;
                echo $idArt;
                $ligne++;

            }
        }
    }
    ?>


    <?php
}*/
if($_GET['element'] == 'creerarticle')
{
    $admincontenu = new Admin();
    $recupSections = $admincontenu->recupLesSections();
    $admincontenu = new Admin();
    $recupLesPictos = $admincontenu->recupLesPictos();

?>
    <h1>Création d'un article</h1>
    <form action="" method="POST" enctype="multipart/form-data">

        <p>Titre de l'article</p>
        <input type="text" id="titre" name="titre">

        <p>Cartel</p>
        <textarea id="cartel" name="cartel"></textarea>


        <p>Notice</p>
        <textarea id="notice" name="notice"></textarea> 

        <select name="section">
            <?php foreach($recupSections as $recupSection) 
            {?>

                <option value="<?=$recupSection['id']?>"><?=$recupSection['nom']?></option>
            <?php 
            }?>
        </select>

        <label for="photo">Choisir une image</label>

        <input type="file" accept="image/png, image/jpeg, image/jpg, image/webp" name="image"> 
        <!-- accept="image/png, image/jpeg, image/jpg, image/webp" -->
        <input type="submit" class="boutonvalidation" name="valider" value="valider">
        <?php
        foreach($recupLesPictos as $recupLesPicto) 
        {?>
        <div>
                <img src="<?php echo $recupLesPicto['lien']; ?>" alt=""> <p><?php echo $recupLesPicto['pays']; ?></p>
                <input type="checkbox" id="id_picto" name="id_picto" value="<?php echo $recupLesPicto['id']; ?>">
        </div>
        <?php
        } ?>
    </form>
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
    <form action="admin.php" method="get">
    <button name="element" type="submit" value="creersection">Créer une section</button>
    </form>
    <?php
    $admincontenu = new Admin();
    $recupSections = $admincontenu->recupLesSections(); ?>
    <h1>Sections</h1>
    <table class="tableau-style">
      <thead>
          <th>Nom</th>
          <th>Id</th>
          
      </thead>
      <tbody>
          <?php
          foreach($recupSections as $recupSection)
          {
          ?>
          <tr>
          <td data-label="Date"><?=$recupSection['nom'] ?></td>
              <td data-label="Date"><?=$recupSection['id'] ?></td>
              <td> <a href="./admin.php?element=sections&amp;modif=<?= $recupSection['id']; ?>">modification</a></td> 

          </tr>
          <?php
          }
          if($_GET['element'] == 'sections' && $_GET['modif'] !== 0 && !empty($_GET['modif'])) {
            $_GET['modif'] = $id;
            $admincontenu = new Admin();
            $recupUneSection = $admincontenu->recupUneSection($id);
            ?>
        <h1>Modification de la section</h1>
        <form method="POST">
            <label for="nom">nom de section</label>
            <input type="text" id="nom" name="nom" class="form-control" value="<?=$recupUneSection['0']['nom'] ?>">
            <input type="submit" name="modifier" value="Modifier">
            <input  type="submit" name="supprimer" value="supprimer" method="POST"> 
        </form>

        <?php     
        if(isset($_POST['nom']) && isset($_POST['modifier'])) 
        {
            $nom = $_POST['nom'];
            $admincontenu = new Admin();
            $modifUneSection = $admincontenu->modifUneSection($id, $nom);
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
    $nom = $_POST['nom'];
    $nom = stripslashes($nom);
    ?>
        <form method="POST">
            <label for="nom">nom de section</label>
            <input type="text" id="nom" name="nom" class="form-control" value=" ">
            <input type="submit" name="creer" value="Créer">
        </form> 
        
        <?php
        if(isset($_POST['nom']) && strlen($nom) > 1)
        {
            $admincontenu = new Admin();
            $creerUneSection = $admincontenu->creerUneSection($nom);
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
        <h1>Documents</h1>
        <table class="tableau-style">
            <thead>
                <th>id</th>
                <th>titre</th>
                <th>texte</th>
            </thead>
            <tbody>
                <?php
                foreach($recupDocs as $recupDoc)
                {
                ?>
                  <tr>
                    <td data-label="Date"><?=$recupDoc['id'] ?></td>
                    <td data-label="Date"><?=$recupDoc['titre'] ?></td>
                    <td data-label="Date"><?=$recupDoc['texte'] ?></td>
                    <td> <a href="./admin.php?element=document&amp;modif=<?= $recupDoc['id']; ?>">modification</a></td> 
                  </tr>

                  <?php
                  //var_dump($getDoc);
                }
                  ?>
                  </table>

                  
                  
<?php 
} 

if($_GET['element'] == 'document' && $_GET['modif'] !== 0 && !empty($_GET['modif'])) 
{
    $admincontenu = new Admin();
    $recupUnDoc = $admincontenu->recupUnDoc($id);  
    //var_dump($getOnedoc); ?>
        <h1>Modification de la documentation</h1>
        <form method="POST">
            <textarea name="titre" class="texterg">
                <?php $titre = $recupUnDoc[0]['titre'];
                echo stripslashes($titre);
                ?>
            </textarea>
                <h1></h1>
                <textarea name="texte" class="texterg">
                    <?php $document = $recupUnDoc[0]['texte'];
                    echo stripslashes($document); ?>
                </textarea>

                    <input type="submit" name="modifier" value="Modifier">
            </form>
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
    <form action="admin.php" method="get">
        <button name="element" type="submit" value="creerutilisateur">Créer un utilisateur</button>
    </form>
    <?php
    $admincontenu = new Admin();
    $recupUtilisateurs = $admincontenu->recupLesUtilisateurs(); ?>
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
        <a id="lienCo" href="connexion.php">Vous avez déjà un compte? Cliquez ici !</a>
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





                  

                
                
?>

                
                
                  
                  
</main>

<?php /*require 'footer.php'; ?>
<?php ;}else{ 
header('Location: index.php');
}*/
?>

</body>
</html>