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

    $id = "8";
    $admincontenu = new Admin();
    $recupDoc = $admincontenu->recupUnDoc($id);
 ?>
        <main class="textarea">
            <h1><?=$recupDoc[0]['titre']?></h1>
            <?php

    ?>
        <p class="texteintro"><?=nl2br($recupDoc[0]['texte'])?></p>

        </main>
        <div class="boutonintro">
        <a class="btn" href="historique.php">◄</a>

        <a class="btn" href="section.php">►</a>
        </div>

        <?php require 'footer.php'; ?>
</body>
</html>