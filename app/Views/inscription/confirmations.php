<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Confirmation</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>

<div class="container">

    <h2>Confirmation</h2>

    <p><b>Nom :</b> <?= $_SESSION['nom'] ?? '' ?></p>

    <p><b>Email :</b> <?= $_SESSION['email'] ?? '' ?></p>

    <p><b>Mot de passe :</b> <?= $_SESSION['password'] ?? '' ?></p>

    <p><b>Genre :</b> <?= $_SESSION['genre'] ?? '' ?></p>

    <p><b>Taille :</b> <?= $_SESSION['taille'] ?? '' ?></p>

    <p><b>Poids :</b> <?= $_SESSION['poids'] ?? '' ?></p>

    <br>

    <button onclick="window.location='f2.php'">
        Précédent
    </button>

    <button onclick="confirmForm()">
        Confirmation
    </button>

</div>

<script>

function confirmForm(){

    alert("Formulaire confirmé !");

}

</script>

</body>
</html>