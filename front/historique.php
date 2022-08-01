<?php
require ("../back/ModelAdmin.php");

session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Articles</title>
    <style>@import url('https://fonts.googleapis.com/css2?family=Noto+Sans:ital@0;1&display=swap');</style>
</head>
<body>
<?php require 'header.php'; 

$id = "7";
$admincontenu = new Admin();
$recupDoc = $admincontenu->recupUnDoc($id);
?>
     <h1><?=$recupDoc['0']['titre']?></h1>

     <div class="container-carte">
        <div class="carte">
          <div class="image-zoom"></div>
    </div>
    </div>

    <div>



        <main class="textareahistorique">
        <div class="background">
        <p class="texteintro"><?=nl2br($recupDoc['0']['texte'])?></p>
        </div>
        <div class="carteLapita"></div>
        <div class="carteVn"></div>
        </main>

        <div class="boutonintro">

            <a class="btn" href="index.php">◄</a>

            <a class="btn" href="chronologie.php">►</a>
        </div>
    </div>
    <?php require 'footer.php'; ?>

</body>
</html>