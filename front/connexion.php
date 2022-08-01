<?php
session_start();
require ("../back/ModelUtilisateurs.php");

if(isset($_POST['nom']) && isset($_POST['mdp'])){
    $nom = htmlspecialchars($_POST['nom']);
    $mdp = htmlspecialchars($_POST['mdp']);


    $utilisateur = new Utilisateur();
    $utilisateur->connexion($nom, $mdp);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Connexion</title>
</head>

    <?php require 'header.php'; ?>

<body class='body'>
<main class="main">
    <form class="formContainer" action="" method="post">
        <h1>CONNEXION</h1>
        <p><input type="text" name="nom" class="zonetext" id="nom" placeholder="nom..."></p>
        <p><input type="password" name="mdp" id="mdp" class="zonetext"  placeholder="mot de passe ..."></p>
        <p style="color:red" id="erreur"></p>
        <p><input type="submit" id="#button" class="boutonvalidation" name="submit" value="Envoyer"></p> 
    </form>
    <script type="text/javascript">
        let btnEnvoyer = document.getElementById('#button');

        btnEnvoyer.addEventListener("click", function(e) {
            //récupérer les données du formulaires
            var erreur;
            nom = document.querySelector("#nom")
            mdp = document.querySelector("#mdp")
            console.log(nom.valeu);

            //Vérification si le formulaire n'est pas vide 
          
            if (!mdp.value){
                erreur = "Veuillez renseigner votre mot de passe";
            }

            if (!nom.value){
                erreur = "Veuillez renseigner votre Login";
            }

            if(erreur){
                e.preventDefault();
                document.querySelector("#erreur").innerHTML = erreur;
                return false;
            }else{
                
            }
        })
    </script>
</main>

    <?php /*require 'footer.php';*/ ?>

</body>
</html>
