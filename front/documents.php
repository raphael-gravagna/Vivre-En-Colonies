<?php
require ("../back/ModelDoc.php");

session_start();


$docs = new Docs();
$recupDocs = $docs->recuplesDocs();
//var_dump($getDocs);
$id = $recupDocs[0]['id'];
?>

<html>
<?php 
     require 'header.php'; ?>
<link rel="stylesheet" href="./css/style.css">
<body>

<div class="background">
    <h1><?php 
    $titre = $recupDocs[0]['titre'];
    echo $titre;?>
    </h1>
    <div class="textareaDocs">
    <p class="texteintro"><?php
    $document = $recupDocs[0]['texte'];
    echo nl2br(stripslashes($document)); 
    ?> </p>
    </div>
</div>
</body>
</html>

<?php 
     require 'footer.php'; ?>