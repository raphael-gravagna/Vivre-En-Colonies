<?php
session_start();
require ("../back/ModelUsers.php");
$message = '';
if(isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['mdp']) && isset($_POST['confirmation_mdp'])){
    $login = htmlspecialchars($_POST['login']);
    $email = htmlspecialchars($_POST['email']);
    $mdp = htmlspecialchars($_POST['mdp']);
    $confirmation_mdp = htmlspecialchars($_POST['confirmation_mdp']);

    //Si le password et le password_retype identiques alors je crypte le mdp et j'appel la fonction d'inscription 
    if($mdp === $confirmation_mdp){
        $password = password_hash($password, PASSWORD_BCRYPT);
        $user = new User();
        $user->Inscription($login, $email, $password);
    }
    else{
        $message = 'Passwords non-identiques';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/styleOrdi.css">
    <title>Inscription</title>
</head>
<body class='body'>

    <?php require 'header.php';?>

<main class="main">
    <form class="formContainer" action="" method="post">
        <h1>INSCRIPTION</h1>
        <?php echo $message; ?>
        <?php if(isset($_SESSION['message'])){echo $_SESSION['message'];} ?>
        <p><input type="text" id="login" name="login" class="zonetext" placeholder="Login..."></p>
        <p><input type="text" id="email" name="email" class="zonetext" placeholder="Mail ..."></p>
        <p><input type="password" id="password" name="password" class="zonetext" placeholder="Password ..."></p>
        <p><input type="password" id="password_retype" name="password_retype" class="zonetext"  placeholder="Password Confirmation ..."></p>
        <p style="color:red" id="erreur"></p>
        <p><input type="submit" id="#button" class="boutonvalidation" name="submit" value="Envoyer"></p> 
    </form>
    <a id="lienCo" href="connexion.php">Vous avez déjà un compte? Cliquez ici !</a>
    <script type="text/javascript">
        let btnEnvoyer = document.getElementById('#button');

        btnEnvoyer.addEventListener("click", function(e) {
            //récupérer les données du formulaires
            var erreur;
            login = document.querySelector("#login")
            email = document.querySelector("#email")
            password = document.querySelector("#password")
            password_retype = document.querySelector("#password_retype")
            console.log(login.valeu);

            //Vérification si le formulaire n'est pas vide 
            if (!password_retype.value){
                erreur = "Veuillez renseigner votre password_retype";
            }

            if (!password.value){
                erreur = "Veuillez renseigner votre password";
            }

            if (!email.value){
                erreur = "Veuillez renseigner votre email";
            }
            
            if (!login.value){
                erreur = "Veuillez renseigner votre Login";
            }

            if(password.value != password_retype.value){
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
</main>

<?php require 'footer.php'; ?>

</body>
</html>