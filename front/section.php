<?php
require ("../back/ModelSection.php");

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

foreach($recupSections as $recupSection) 
{
?>

   <a href="articles.php?section=<?=$recupSection['id']?>&article=0"><p><?=$recupSection['nom']?></p></a>

<?php 
}

foreach($recupLesArticles as $recupLesArticle){
                ?>
                <div class="containerProduits">
                    <div class="produits">
                        <a href="articles.php?article=<?= $recupLesArticle['id_article'] ?>"> <img src="<?php print $recupLesArticle['lien'] ?>"></a>
                        <p><?= $recupLesArticle['titre']; ?></p>
                        </div>
                    <?php
                    }
                    ?>
                    </div> 
                </div> 