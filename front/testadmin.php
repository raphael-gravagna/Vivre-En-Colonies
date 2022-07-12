<?php




if($_GET['element'] == 'articles')
{ ?>
    <form action="admin.php" method="get">
    <button name="element" type="submit" value="creerarticle">Créer un article</button>
    </form>
    <?php
    $admincontenu = new Admin();
    $recupLesArticles = $admincontenu->recupLesArticles(); 
    ?>
        <h1>Articles</h1>
    <table class="tableau-style">
        <thead>
            <th>Nom</th>
            <th>Id</th>
            
        </thead>
        <tbody>
            <?php
            foreach($recupLesArticles as $recupLesArticle) 
            {
            ?>
            <tr>
            <td data-label="Date"><?=$recupLesArticle['titre']; ?></td>
                <td data-label="Date"><?=$recupLesArticle['id']; ?></td>
                <td> <a href="./admin.php?element=articles&amp;modif=<?= $recupLesArticle['id']; ?>">modification</a></td> 

            </tr>
    <?php}
}

    if($_GET['element'] == 'articles' && $_GET['modif'] !== 0 && !empty($_GET['modif'])) 
    {
        $id = $_GET['modif'];
        $admincontenu = new Admin();
        $recupUnArticle = $admincontenu->recupUnArticle($id); 
    }    
}
}

if($_GET['element'] == 'creerarticle')
{
    $admincontenu = new Admin();
    $recupSections = $admincontenu->recupLesSections();

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

    }
}
}
