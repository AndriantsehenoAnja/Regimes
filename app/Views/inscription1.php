<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulaire 1</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>

<div class="container">
    <h2>Formulaire 1</h2>

    <input type="text" id="nom" placeholder="Nom"
    value="<?= $_SESSION['nom'] ?? '' ?>">

    <input type="email" id="email" placeholder="Email"
    value="<?= $_SESSION['email'] ?? '' ?>">

    <input type="password" id="password" placeholder="Mot de passe"
    value="<?= $_SESSION['password'] ?? '' ?>">

    <br><br>

    Genre :

    <input type="radio" name="genre" value="Homme"
    <?= (($_SESSION['genre'] ?? '') == 'Homme') ? 'checked' : '' ?>>
    Homme

    <input type="radio" name="genre" value="Femme"
    <?= (($_SESSION['genre'] ?? '') == 'Femme') ? 'checked' : '' ?>>
    Femme

    <br>

    <button onclick="suivant()">Suivant</button>
</div>

<script>
function suivant(){

    let nom = document.getElementById("nom").value;
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;

    let genre = document.querySelector('input[name="genre"]:checked');

    genre = genre ? genre.value : "";

    let xhr = new XMLHttpRequest();

    xhr.open("POST","save.php",true);

    xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");

    xhr.onload = function(){
        window.location = "f2.php";
    }

    xhr.send(
        "nom="+nom+
        "&email="+email+
        "&password="+password+
        "&genre="+genre
    );
}
</script>

</body>
</html>