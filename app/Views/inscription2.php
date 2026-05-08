<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulaire 2</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>

<div class="container">

    <h2>Formulaire 2</h2>

    <input type="number" id="taille" placeholder="Taille"
    value="<?= $_SESSION['taille'] ?? '' ?>">

    <input type="number" id="poids" placeholder="Poids"
    value="<?= $_SESSION['poids'] ?? '' ?>">

    <br>

    <button onclick="precedent()">Précédent</button>

    <button onclick="suivant()">Suivant</button>

</div>

<script>

function saveData(callback){

    let taille = document.getElementById("taille").value;
    let poids = document.getElementById("poids").value;

    let xhr = new XMLHttpRequest();

    xhr.open("POST","save.php",true);

    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");

    xhr.onload = callback;

    xhr.send(
        "taille="+taille+
        "&poids="+poids
    );
}

function precedent(){

    saveData(function(){
        window.location = "f1.php";
    });

}

function suivant(){

    saveData(function(){
        window.location = "f3.php";
    });

}

</script>

</body>
</html>