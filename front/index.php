<?php
session_start();

require ("../back/ModelDoc.php");

$id = 6;
$doc = new Docs();
$recupDocs = $doc->recupUnDoc($id);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Articles</title>
</head>
<body>
<div class="backgroundIndex">

<?php require 'header.php'; ?>
<div id="h1index"><?=nl2br($recupDocs[0]['titre'])?></div>

    <main class="textareaIndex">
        <img class="imgIndex" src="images/affiche.webp">
        <p class="texteintro"><?=nl2br($recupDocs[0]['texte'])?></p>

<img class="boutondroit">

    </main>
    </div>
    <?php require 'footer.php'; ?>

</body>
</html>