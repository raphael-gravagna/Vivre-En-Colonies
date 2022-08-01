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

    public function minOrdre($id_section)
    {
        $recupOrdre = $this->bdd->prepare("SELECT min(ordre) FROM articles WHERE id_section = $id_section AND articles.en_ligne = 1;");
        $recupOrdre->execute();
        $recupOrdreMin = $recupOrdre->fetchall(PDO::FETCH_ASSOC);
        //var_dump($recupOrdreMin);
        return $recupOrdreMin;
    }

        public function recupLesSections()
        {
        $recupSection = $this->bdd->prepare("SELECT `nom`, `id`, `introduction` FROM `sections`");
        $recupSection->execute();
        $recupLesSections = $recupSection->fetchall(PDO::FETCH_ASSOC);
        return $recupLesSections;
        }

        public function recupUneSection($id_section)
        {
        $recupSection = $this->bdd->prepare("SELECT * FROM `sections` WHERE `id` = $id_section");
        $recupSection->execute();
        $recupUneSection = $recupSection->fetchall(PDO::FETCH_ASSOC);
        return $recupUneSection;
        //var_dump($recupUneSection);
        }

        public function modifUneSection($id, $nom, $introduction)
        {
            $nom = addslashes($nom);
            $introduction = addslashes($introduction);
            $modifUneSection = $this->bdd->prepare("UPDATE sections SET nom = '$nom', introduction = '$introduction' WHERE id = $id");
            $modifUneSection->execute();

        }

        public function creerUneSection($nom, $introduction)
        {

            $nom = addslashes($nom);
            $introduction = addslashes($introduction);
            
            $requetesql1 = "INSERT INTO `sections` (`nom`, `introduction`) 
                            VALUES (?, ?)";
            $calcul1 = $this->bdd->prepare($requetesql1);
            $calcul1 -> execute(array(
                $nom,
                $introduction
            ));
            
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
      
        //connexion à la base de données pour verifier si le login existe deja 
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

    public function creerUnArticle( $titre, $cartel, $notice,$id_section, $donnésImageTmp, $donnéesImageLien, $id_picto)
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

        if(mime_content_type($donnésImageTmp) == "image/jpg"
                ||  mime_content_type($donnésImageTmp) == "image/jpeg"
                ||  mime_content_type($donnésImageTmp) == "image/png" 
                ||  mime_content_type($donnésImageTmp) == "image/webp") 
        {
            move_uploaded_file($donnésImageTmp, $donnéesImageLien);
            $addImage = $this->bdd->prepare("INSERT INTO images (lien, lien_bd, id_article) VALUES (?, 'en attente', ?)");
            $addImage->execute(array($donnéesImageLien, $dernierIdArticle));
        }
    }

    public function recupOrdre($sectionArticle)
    {
        $recupOrdre = $this->bdd->prepare("SELECT ordre FROM articles WHERE id_section= $sectionArticle ;");
        $recupOrdre->execute();
        $recupOrdreArt = $recupOrdre->fetchall(PDO::FETCH_ASSOC);
        return $recupOrdreArt;
    }

    public function modifUnOrdre($ordreN, $id)
    {
        foreach ($ordreN as $id => $ordreN)
        {              
            $modifOrdre = $this->bdd->prepare("UPDATE articles SET ordre = ? WHERE id = ?");
            $modifOrdre->execute(array($ordreN, $id));

        }

    }
    

    public function modifOrdre($id, $ordreModif)
    {   // je récup l'ordre avant modification je le charge en var ordreAncien
        $recupOrdre = $this->bdd->prepare("SELECT ordre, id_section FROM articles WHERE id= $id ;");
        $recupOrdre->execute();
        $recupOrdreArt = $recupOrdre->fetchall(PDO::FETCH_ASSOC);
        $ordreAncien = $recupOrdreArt['0']['ordre'];
        $section = $recupOrdreArt['0']['id_section'];
        //var_dump($section);
        //var_dump($ordreAncien);

        //
        $recupIdOrdre = $this->bdd->prepare("SELECT id FROM articles WHERE ordre = $ordreModif AND id_section = $section ;");
        $recupIdOrdre->execute();
        $recupIdOrdreArt = $recupIdOrdre->fetchall(PDO::FETCH_ASSOC);
        $id2 = $recupIdOrdreArt['0']['id'];

        $modifOrdre = $this->bdd->prepare("UPDATE articles SET ordre = ? WHERE id = ?");
        $modifOrdre->execute(array($ordreModif, $id));

        $modifOrdre2 = $this->bdd->prepare("UPDATE articles SET ordre = ? WHERE id = ?");
        $modifOrdre2->execute(array($ordreAncien, $id2));
        
    }

    public function recupOrdreMax($id_section)
    {
        $recupOrdre = $this->bdd->prepare("SELECT max(ordre) FROM articles WHERE id_section = $id_section ;");
        $recupOrdre->execute();
        $recupOrdreMax = $recupOrdre->fetchall(PDO::FETCH_ASSOC);
        $ordreMax = $recupOrdreMax['0']['max(ordre)'];
        return $ordreMax;
    }
        public function modifSectionOrdreArticle($id, $id_section) 
        {
            $recupOrdre = $this->bdd->prepare("SELECT max(ordre) FROM articles WHERE id_section = $id_section ;");
            $recupOrdre->execute();
            $recupOrdreMax = $recupOrdre->fetchall(PDO::FETCH_ASSOC);
            $ordreMax = $recupOrdreMax['0']['max(ordre)'];

            $nouvelOrdre = $ordreMax + 1;
            $modifUneSection = $this->bdd->prepare("UPDATE articles SET ordre = '$nouvelOrdre' WHERE id = $id");
            $modifUneSection->execute();

        }

    public function modifUnArticle($id, $titre, $cartel, $notice, $id_section, $id_pictoMA, $id_picto_actuel/*, $donnésImageTmp, $donnéesImageLien, $id_picto*/)
    {
        $titre = addslashes($titre);
        $cartel = addslashes($cartel);
        $notice = addslashes($notice);
        $id_section = addslashes($id_section);

        $recupOrdre = $this->bdd->prepare("SELECT ordre FROM articles WHERE id= $id ;");
        $recupOrdre->execute();
        $recupOrdreArt = $recupOrdre->fetchall(PDO::FETCH_ASSOC);
        $ordreArt = $recupOrdreArt['0']['ordre'];


        if(empty($id_pictoMA))
        {

            $id_pictoMA = $id_picto_actuel;
        }


        $requetesql1 = "UPDATE articles 
        SET titre = '$titre', cartel = '$cartel', notice = '$notice', id_section = '$id_section', id_picto = '$id_pictoMA'
        WHERE id = $id";
        $calcul1 = $this->bdd->prepare($requetesql1);
        $calcul1 -> execute();

        /*$dernierIdArticle = $this->bdd->lastInsertId();

        if(mime_content_type($donnésImageTmp) == "image/jpg"
                ||  mime_content_type($donnésImageTmp) == "image/jpeg"
                ||  mime_content_type($donnésImageTmp) == "image/png" 
                ||  mime_content_type($donnésImageTmp) == "image/webp") 
        {
            move_uploaded_file($donnésImageTmp, $donnéesImageLien);
            $addImage = $this->bdd->prepare("INSERT INTO images (lien, lien_bd, id_article) VALUES (?, 'en attente', ?)");
            $addImage->execute(array($donnéesImageLien, $dernierIdArticle));
        }*/
    }

    public function publierArticle($idArticle)
    {
        $publierArticle = $this->bdd->prepare("UPDATE articles SET en_ligne = '1' WHERE id = $idArticle");
        $publierArticle->execute();
    }

    public function inserImageBd($donnésImageTMP, $donnéesImageLien, $id)
    {
        if(     mime_content_type($donnésImageTMP) == "image/jpg"
                ||  mime_content_type($donnésImageTMP) == "image/jpeg"
                ||  mime_content_type($donnésImageTMP) == "image/png" 
                ||  mime_content_type($donnésImageTMP) == "image/webp"  ) 
        {
            move_uploaded_file($donnésImageTMP, $donnéesImageLien);
            $inserImageBd = $this->bdd->prepare("UPDATE images SET lien_bd = ? WHERE id_article = ?");
            $inserImageBd->execute(array($donnéesImageLien, $id));
        }
    }

    public function remplacerImage($donnésImageTMP, $donnéesImageLien, $id)
    {
        if(     mime_content_type($donnésImageTMP) == "image/jpg"
                ||  mime_content_type($donnésImageTMP) == "image/jpeg"
                ||  mime_content_type($donnésImageTMP) == "image/png" 
                ||  mime_content_type($donnésImageTMP) == "image/webp"  ) 
        {
            move_uploaded_file($donnésImageTMP, $donnéesImageLien);
            $addImage = $this->bdd->prepare("UPDATE images SET lien = ? WHERE id_article = ?");
            $addImage->execute(array($donnéesImageLien, $id));
        }
    }

    public function remplacerImagebd($donnésImageTMP, $donnéesImageLien, $id)
    {
        if(     mime_content_type($donnésImageTMP) == "image/jpg"
                ||  mime_content_type($donnésImageTMP) == "image/jpeg"
                ||  mime_content_type($donnésImageTMP) == "image/png" 
                ||  mime_content_type($donnésImageTMP) == "image/webp"  ) 
        {
            move_uploaded_file($donnésImageTMP, $donnéesImageLien);
            $addImage = $this->bdd->prepare("UPDATE images SET lien_bd = ? WHERE id_article = ?");
            $addImage->execute(array($donnéesImageLien, $id));
        }
    }

    public function supprUneImage($id)
    {
        $supprImage = $this->bdd->prepare("DELETE FROM images WHERE id_article=$id");
        $supprImage->execute();
    }

    public function modifPictoArticle($id_picto, $id)
    {
        $requetesql1 = "UPDATE articles 
        SET id_picto = '$id_picto' 
        WHERE id = $id";
        $calcul1 = $this->bdd->prepare($requetesql1);
        $calcul1 -> execute();


    }

    public function recupLesArticles()
    {
        $recupArticles = $this->bdd->prepare(
        "SELECT *, articles.id, sections.nom 
        FROM `articles`
        INNER JOIN `sections`
        WHERE articles.id_section = sections.id 
        ORDER BY 'sections'");
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
        $recupSection = $this->bdd->prepare("SELECT id_section FROM `articles` WHERE id = $id");
        $recupSection->execute();
        $recupLesSections = $recupSection->fetchall(PDO::FETCH_ASSOC);
        $section = $recupLesSections['0']['id_section'];

        $supprArticle = $this->bdd->prepare("DELETE FROM articles WHERE id=$id");
        $supprArticle->execute();
        return $section;
    }

    public function recupLesArticlesParSection($section)
    {
        $recupArticlesParSection = $this->bdd->prepare("SELECT * FROM `articles` WHERE articles.id_section = $section");
        $recupArticlesParSection->execute();
        $recupLesArticlesParSection = $recupArticlesParSection->fetchall(PDO::FETCH_ASSOC);
        return $recupLesArticlesParSection;
    }

    public function creerUnPicto( $pays, $donnésImageTmp, $donnéesImageLien)
    {                echo $pays;
        echo $donnéesImageLien;
        echo $donnésImageTmp;
        $pays = addslashes($pays);
        
        if(     mime_content_type($donnésImageTmp) == "image/jpg"
                ||  mime_content_type($donnésImageTmp) == "image/jpeg"
                ||  mime_content_type($donnésImageTmp) == "image/png" 
                ||  mime_content_type($donnésImageTmp) == "image/webp"  ) 
        {
            move_uploaded_file($donnésImageTmp, $donnéesImageLien);
            $addImage = $this->bdd->prepare("INSERT INTO pictos (lien, pays) VALUES (?, ?)");
            $addImage->execute(array($donnéesImageLien, $pays));
        }
    }

    public function recupLesPictos()
    {
        $recupPictos = $this->bdd->prepare("SELECT * FROM `pictos` ORDER BY pays");
        $recupPictos->execute();
        $recupLesPictos = $recupPictos->fetchall(PDO::FETCH_ASSOC);
        return $recupLesPictos;
    }


/*public function imgProd($nom, $donnésImage, $donnés, $typeImage){
    $calculid = $this->bdd->prepare("SELECT id FROM `produits` WHERE titre = '$name'");
    $calculid -> execute();
    $id_Art = $calculid->fetch(PDO::FETCH_ASSOC);
    $idArt = $id_Art['id'];
    var_dump($id_Art);


    if(mime_content_type($dataImage['img_file']) == "image/jpeg" || mime_content_type($dataImage['img_file']) == "image/png" || mime_content_type($dataImage['img_file']) == "image/webp") {
        move_uploaded_file($dataImage['img_file'], $dataImage['img_link']); //https://www.php.net/manual/fr/function.move-uploaded-file.php la première variable 'imgfile' est le from, la seconde 'imglink' est le to, la fonction moveupladedfile déplace from, to. Ainsi le fichier temp va du dossier tmp de l'ordinateur au chemin indiqué dans to (imglink) donc le dossier image qui a été choisi.
        $addImage = $this->bdd->prepare("INSERT INTO images (link, id_produit, id_mesure) VALUES (:img_link, $idArt, $typeimage)");
        $addImage->execute($data);
        }


}

public function deleteOneProd($id) {
    $deleteOneProd = $this->bdd->prepare("DELETE FROM produits WHERE id=$id");
    $deleteOneProd->execute();
}*/
public function rLS()
{
$recupSection = $this->bdd->prepare("SELECT `nom`, `id`  FROM `sections`");
$recupSection->execute();
$recupLesSections = $recupSection->fetchall(PDO::FETCH_ASSOC);
return $recupLesSections;
}

public function mOr($id_section)
{
    $recupOrdre = $this->bdd->prepare("SELECT min(ordre) FROM articles WHERE id_section = $id_section AND articles.en_ligne = 1;");
    $recupOrdre->execute();
    $recupOrdreMin = $recupOrdre->fetchall(PDO::FETCH_ASSOC);
    //var_dump($recupOrdreMin);
    return $recupOrdreMin;
}

}
?>