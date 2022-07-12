<?php
require ('Model.php');
class Utilisateur extends Model{
        private $id;
        public $nom;
        public $email;
        protected $mdp;
    
    
    public function __construct(){
        parent::__construct();
    }

    public function Inscription($nom, $email, $mdp){
            $this->nom = $nom;
            $this->email = $email;
            $this->mdp = $mdp;
          
            //connexion à la base de données pour verifier si le login existe deja 
            $requetesql2 = "SELECT nom FROM `utilisateurs` WHERE nom = '$this->nom'";
            $calcul2 = $this->bdd->prepare($requetesql2);
            $calcul2 -> execute();
            // rowCount permet de compter le nombre d'utilisateur avec ce login
            $resultat2 = $calcul2->rowCount();

            // Si aucun utilisateur n'a ce login alors je le rentre ne base 
            if(($resultat2) == 0){
                $requetesql1 = "INSERT INTO `utilisateurs` (`nom`, `email`, `mdp`, `id_droit`) VALUES ('$this->nom', '$this->email', '$this->mdp', 1)";
                $calcul1 = $this->bdd->prepare($requetesql1);
                $calcul1 -> execute();
                $_SESSION['message'] = '<div class="messageERR">'.'Inscription reussie'.'</div>';
                header('Refresh: 3; url=connexion.php');
            }else{$_SESSION['message'] = '<div class="messageERR">'.'Login deja existant'.'</div>';}

    }

    public function connexion($nom, $mdp){
            $this->nom = $nom;
            $this->mdp = $mdp;

            //recupération du login dans BDD
            $request = "SELECT nom FROM `utilisateurs` WHERE nom = '$this->nom'";
            $calcul = $this->bdd->prepare($request);
            $calcul -> execute();
            $resultat = $calcul->rowCount();

             //recupération du password dans BDD
            $request2 = "SELECT mdp FROM `utilisateurs` WHERE nom = '$this->nom'";
            $calcul2 = $this->bdd->prepare($request2);
            $calcul2 -> execute();
            // On utilise fetchColumn car la fonction password_verify a besoin d'un résultat sous forme de string
            $resultat2 = $calcul2-> fetchColumn();
           

            // Création variable récupération décryptage password
            $check_mdp = $resultat2;
            


            //Vérification que le login existe bien 
            if(($resultat) == 1){
                //vérification du password
                if(password_verify($mdp, $check_mdp)){
                    // Si le password est vérifié alors on récupère toutes les infos user et on les met dans la session
                    $request3 = "SELECT*FROM `utilisateurs` WHERE nom = '$this->nom'";
                    $calcul3 = $this->bdd->prepare($request3);
                    $calcul3 -> execute();
                    $resultat3 = $calcul3-> fetch(PDO::FETCH_ASSOC);
                    
                    $_SESSION['utilisateur'] = $resultat3['id_utilisateur'];
                    $_SESSION['message'] = '<div class="messageERR">'.'Connexion reussie'.'</div>';
                    if($resultat3['id_droit'] == 42){
                        $_SESSION['utilisateur'] = $resultat3['id_droit'];
                        header('Location: admin.php');
                    }
                    else if(isset($_SESSION["panier"])){
                        header('Refresh: 1; url=panier.php');
                    }else{
                        header('Refresh: 1; url=index.php');  
                    }
                    
                }else{$_SESSION['message'] = '<div class="messageERR">'.'Password incorrect'.'</div>';}
            }else{$_SESSION['message'] = '<div class="messageERR">'.'Login inexistant'.'</div>';}
    }
}
?>