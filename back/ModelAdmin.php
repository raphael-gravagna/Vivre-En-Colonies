<?php
require ('Model.php');

class Admin extends Model{

    public function __construct()
    {
        parent::__construct();
    }

    public function recupLesDoc()
    {
        $recupDoc = $this->bdd->prepare("SELECT * FROM `documents`");
        $recupDoc->execute();
        $recupDocs = $recupDoc->fetchall(PDO::FETCH_ASSOC);
        //var_dump($getDoc);
        return $recupDocs;
    }

    public function recupUnDoc($id)
    {
        $recupDoc = $this->bdd->prepare("SELECT * FROM `documents` WHERE `id` = $id");
        $recupDoc->execute();
        $recupUnDoc = $recupDoc->fetchall(PDO::FETCH_ASSOC);
        //var_dump($getDoc);
        return $recupUnDoc;
    }

    public function modifUnDoc($id, $texte, $titre)
    {

        $contenu = addslashes($texte);
        $contenu = addslashes($titre);
        //$this->bdd->quote($contenu);
        $modifDoc = $this->bdd->prepare("UPDATE documents SET titre = '$titre', texte = '$texte' WHERE id = $id");
        $modifDoc->execute();
    }

        

        public function recupLesSections()
        {
        $recupSection = $this->bdd->prepare("SELECT `nom`, `id`  FROM `sections`");
        $recupSection->execute();
        $recupLesSections = $recupSection->fetchall(PDO::FETCH_ASSOC);
        return $recupLesSections;
        }

        public function recupUneSection($id)
        {
        $recupSection = $this->bdd->prepare("SELECT `nom` FROM `sections` WHERE `id` = $id");
        $recupSection->execute();
        $recupUneSection = $recupSection->fetchall(PDO::FETCH_ASSOC);
        return $recupUneSection;
        }

        public function modifUneSection($id, $nom)
        {
            $modifUneSection = $this->bdd->prepare("UPDATE sections SET nom = '$nom' WHERE id = $id");
            $modifUneSection->execute();
        }

        public function creerUneSection($nom)
        {
            $this->nom = $nom;

            $requetesql1 = "INSERT INTO `sections` (`nom`) VALUES ('$this->nom')";
            $calcul1 = $this->bdd->prepare($requetesql1);
            $calcul1 -> execute();

        }

        public function supprSection($id)
        {
            $supprSection = $this->bdd->prepare("DELETE FROM sections WHERE id=$id");
            $supprSection->execute();
        }

        
        public function recupLesUtilisateurs()
        {
        $recupUtilisateur = $this->bdd->prepare("SELECT * FROM `utilisateurs`");
        $recupUtilisateur->execute();
        $recupUtilisateurs = $recupUtilisateur->fetchall(PDO::FETCH_ASSOC);
        return $recupUtilisateurs;
        }

    public function recupUnUtilisateur($id)
    {
        $recupUnUtilisateur = $this->bdd->prepare("SELECT * FROM `utilisateurs` WHERE `id` = $id");
        $recupUnUtilisateur->execute();
        $recupUtilisateur = $recupUnUtilisateur->fetchall(PDO::FETCH_ASSOC);
        return $recupUtilisateur;
    }

    public function modifUnUtilisateur($id, $nom, $email, $id_droit)
    {
        $modifUtilisateur = $this->bdd->prepare("UPDATE utilisateurs SET nom = '$nom', email = '$email', id_droit = '$id_droit' WHERE id = $id");
        $modifUtilisateur->execute();
    }

    public function supprUnUtilisateur($id)
    {
        $supprUtilisateur = $this->bdd->prepare("DELETE FROM utilisateurs WHERE id=$id");
        $supprUtilisateur->execute();
    }

    public function Inscription($nom, $email, $mdp)
    {
        $this->nom = $nom;
        $this->email = $email;
        $this->mdp = $mdp;
      
        //connexion ?? la base de donn??es pour verifier si le login existe deja 
        $requetesql2 = "SELECT nom FROM `utilisateurs` WHERE nom = '$this->nom'";
        $calcul2 = $this->bdd->prepare($requetesql2);
        $calcul2 -> execute();
        // rowCount permet de compter le nombre d'utilisateur avec ce login
        $resultat2 = $calcul2->rowCount();

        // Si aucun utilisateur n'a ce login alors je le rentre ne base 
        if(($resultat2) == 0){
            $requetesql1 = "INSERT INTO `utilisateurs` (`nom`, `email`, `mdp`, `id_droit`) VALUES ('$this->nom', '$this->email', '$this->mdp', 42)";
            $calcul1 = $this->bdd->prepare($requetesql1);
            $calcul1 -> execute();
            $_SESSION['message'] = '<div class="messageERR">'.'Inscription reussie'.'</div>';
        }else{$_SESSION['message'] = '<div class="messageERR">'.'Login deja existant'.'</div>';}

    }

    public function creerUnArticle( $titre, $cartel, $notice,$id_section, $donn??sImageTmp, $donn??esImageLien, $id_picto)
    {
        $titre = addslashes($titre);
        $cartel = addslashes($cartel);
        $notice = addslashes($notice);
        $id_section = addslashes($id_section);

        $recupOrdre = $this->bdd->prepare("SELECT max(ordre) FROM articles WHERE id_section = $id_section ;");
        $recupOrdre->execute();
        $recupOrdreMax = $recupOrdre->fetchall(PDO::FETCH_ASSOC);
        $ordreMax = $recupOrdreMax['0']['max(ordre)'];
        $ordre = $ordreMax + 1;

        $requetesql1 = "INSERT INTO `articles` (`titre`, `cartel`, `notice`, `en_ligne`, `id_section`, `id_picto`, `ordre`) 
                        VALUES (?, ?, ?, 0, ?, ?, ?)";
        $calcul1 = $this->bdd->prepare($requetesql1);
        $calcul1 -> execute(array(
            $titre,
            $cartel,
            $notice,
            $id_section,
            $id_picto,
            $ordre
        ));

        $dernierIdArticle = $this->bdd->lastInsertId();

        if(mime_content_type($donn??sImageTmp) == "image/jpg"
                ||  mime_content_type($donn??sImageTmp) == "image/jpeg"
                ||  mime_content_type($donn??sImageTmp) == "image/png" 
                ||  mime_content_type($donn??sImageTmp) == "image/webp") 
        {
            move_uploaded_file($donn??sImageTmp, $donn??esImageLien);
            $addImage = $this->bdd->prepare("INSERT INTO images (lien, lien_bd, id_article) VALUES (?, 'en attente', ?)");
            $addImage->execute(array($donn??esImageLien, $dernierIdArticle));
        }
    }

    public function recupLesArticles()
    {
        $recupArticles = $this->bdd->prepare("SELECT *, articles.id, sections.nom FROM `articles` INNER JOIN `sections` WHERE articles.id_section = sections.id ORDER BY 'sections'");
        $recupArticles->execute();
        $recupLesArticles = $recupArticles->fetchall(PDO::FETCH_ASSOC);
        //var_dump($recupLesArticles);
        return $recupLesArticles;
    }

    public function recupUnArticle($id)
    {
        /*$recupArticle = $this->bdd->prepare("SELECT * FROM `articles` WHERE `id` = $id");
        $recupArticle->execute();
        $recupUnArticle = $recupArticle->fetchall(PDO::FETCH_ASSOC);
        //var_dump($getDoc);
        return $recupUnArticle;*/

        $recupArticle = $this->bdd->prepare("SELECT *, articles.id FROM `articles` INNER JOIN `images` ON articles.id = images.id_article WHERE images.id_article = $id");
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

    public function supprUnArticle($id)
    {
        $supprArticle = $this->bdd->prepare("DELETE FROM articles WHERE id=$id");
        $supprArticle->execute();
    }

    public function recupLesArticlesParSection($section)
    {
        $recupArticlesParSection = $this->bdd->prepare("SELECT *, articles.id FROM `articles` INNER JOIN `images` ON articles.id = images.id_article WHERE articles.id_section = $section");
        $recupArticlesParSection->execute();
        $recupLesArticlesParSection = $recupArticlesParSection->fetchall(PDO::FETCH_ASSOC);
        return $recupLesArticlesParSection;
    }

    public function creerUnPicto( $pays, $donn??sImageTmp, $donn??esImageLien)
    {                echo $pays;
        echo $donn??esImageLien;
        echo $donn??sImageTmp;
        $pays = addslashes($pays);
        
        if(     mime_content_type($donn??sImageTmp) == "image/jpg"
                ||  mime_content_type($donn??sImageTmp) == "image/jpeg"
                ||  mime_content_type($donn??sImageTmp) == "image/png" 
                ||  mime_content_type($donn??sImageTmp) == "image/webp"  ) 
        {
            move_uploaded_file($donn??sImageTmp, $donn??esImageLien);
            $addImage = $this->bdd->prepare("INSERT INTO pictos (lien, pays) VALUES (?, ?)");
            $addImage->execute(array($donn??esImageLien, $pays));
        }
    }

    public function recupLesPictos()
    {
        $recupPictos = $this->bdd->prepare("SELECT * FROM `pictos`");
        $recupPictos->execute();
        $recupLesPictos = $recupPictos->fetchall(PDO::FETCH_ASSOC);
        return $recupLesPictos;
    }


/*public function imgProd($nom, $donn??sImage, $donn??s, $typeImage){
    $calculid = $this->bdd->prepare("SELECT id FROM `produits` WHERE titre = '$name'");
    $calculid -> execute();
    $id_Art = $calculid->fetch(PDO::FETCH_ASSOC);
    $idArt = $id_Art['id'];
    var_dump($id_Art);


    if(mime_content_type($dataImage['img_file']) == "image/jpeg" || mime_content_type($dataImage['img_file']) == "image/png" || mime_content_type($dataImage['img_file']) == "image/webp") {
        move_uploaded_file($dataImage['img_file'], $dataImage['img_link']); //https://www.php.net/manual/fr/function.move-uploaded-file.php la premi??re variable 'imgfile' est le from, la seconde 'imglink' est le to, la fonction moveupladedfile d??place from, to. Ainsi le fichier temp va du dossier tmp de l'ordinateur au chemin indiqu?? dans to (imglink) donc le dossier image qui a ??t?? choisi.
        $addImage = $this->bdd->prepare("INSERT INTO images (link, id_produit, id_mesure) VALUES (:img_link, $idArt, $typeimage)");
        $addImage->execute($data);
        }


}

public function deleteOneProd($id) {
    $deleteOneProd = $this->bdd->prepare("DELETE FROM produits WHERE id=$id");
    $deleteOneProd->execute();
}*/
   
}
?>