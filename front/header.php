<?php

if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
    $url = "https"; 
  else
    $url = "http"; 
    
  $url .= "://"; 
    
  $url .= $_SERVER['HTTP_HOST']; 
    
  $url .= $_SERVER['PHP_SELF']; 
      

  if($url == "http://localhost/vivreencolonies/front/sections.php") {
    $objet = "Section";
  }
  elseif($url == "http://localhost/vivreencolonies/front/admin.php" || $url == "http://localhost/vivreencolonies/front/historique.php" || $url == "http://localhost/vivreencolonies/front/chronologie.php" ){
    $objet = "Admin";
  }
  elseif($url == "http://localhost/vivreencolonies/front/section.php"){
    $objet = "Section";
  }
  elseif($url == "http://localhost/vivreencolonies/front/articles.php"){
    $objet = "Articles";
  }
  elseif($url == "http://localhost/vivreencolonies/front/index.php"){
    $objet = "Docs";
  }
  elseif($url == "http://localhost/vivreencolonies/front/documents.php"){
    $objet = "Docs";
  }
  elseif($url == "http://localhost/vivreencolonies/front/connexion.php"){
    $objet = "Utilisateur";
  }
  

?>

    
    <header>
    <nav id='menu'>
    <input type='checkbox' id='responsive-menu'><label></label>

                    <ul>
                        <li><a href="index.php">Accueil</a></li>
                        <li><a href="historique.php">Visite de l'exposition</a></li>
                        <li><a class="dropdown-arrow" href="sections.php">Sections</a>
                        <ul class='sub-menus' >
                         <li>   <?php   
                         $admincontenu = new $objet();
                         $recupSections = $admincontenu->rLS();
                         foreach($recupSections as $recupSection) 
{   
    $id_section = $recupSection['id'];
    $admincontenu = new $objet();
    $minOrdre = $admincontenu->mOr($id_section);
    $mO = $minOrdre['0']['min(ordre)'];

    if($mO == NULL)
    {
    }
    else {?> 

   <a class="sectionVisite" href="sections.php?section=<?=$recupSection['id']?>"><p><?=$recupSection['nom']?></p></a>
    <?php 
    }
}
?> 
 
     <?php 
     
 ?></li>

                        </ul>
                    </li>
                    

                        <?php 

                        if(!isset($_SESSION['utilisateur']) && empty($_SESSION['utilisateur']))
                        {
                        }
                        else{
                            ?>
                            <li><a href="<?='admin.php'?>">Admin</a></li>
                            <li><a href="<?='deconnexion.php'?>">Déconnexion</a></li>
                        </ul>
                            <?php
                        }

                        ?>
                    </ul>
                    
    </nav>
    </header>
