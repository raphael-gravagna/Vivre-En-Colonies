
<nav id='menu'>
  <input type='checkbox' id='responsive-menu'><label></label>
  <ul>
    <li><a href="index.php">Accueil</a></li>
    <li><a href="historique.php">Visite de l'exposition</a></li>
    <li><a href="sections.php">Sections</a>
        <ul class='sub-menus'>
       <li> <?php     foreach($recupSections as $recupSection) 
 
 {
     $id_section = $recupSection['id'];

     $mO = $minOrdre['0']['min(ordre)'];
     if($mO == NULL)
     {?>
         <a href="section.php"></a>
 
     <?php
     }
     else {?> 
 
    <a href="section.php?introduction=<?=$recupSection['id']?>"><p><?=$recupSection['nom']?></p></a></li>
     <?php 
     }
 ?>
      </ul>
    </li>
    
    <?php
 }
 
 if(!isset($_SESSION['utilisateur']) && empty($_SESSION['utilisateur']))
 {
 }
 else{
     ?>
     <li><a href="<?='admin.php'?>">Admin</a></li>
     <li><a href="<?='deconnexion.php'?>">Déconnexion</a></li>
     <?php
 }

 ?>
 



</nav>