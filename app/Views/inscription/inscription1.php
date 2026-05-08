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
    <form action="/save_user1" method="post">
        <input type="text" id="nom" name="nom" placeholder="Nom"
        value="<?= $_SESSION["user_data"]['nom'] ?? '' ?>">

        <input type="email" id="email" name="email" placeholder="Email"
        value="<?= $_SESSION["user_data"]['email'] ?? '' ?>">

    <input type="password" id="password" name="password" placeholder="Mot de passe"
    value="<?= $_SESSION["user_data"]['password'] ?? '' ?>">

    <br><br>

    Genre :

    <input type="radio" name="genre" value="Homme"
    <?= (($_SESSION["user_data"]['genre'] ?? '') == 'Homme') ? 'checked' : '' ?>>
    Homme

    <input type="radio" name="genre" value="Femme"
    <?= (($_SESSION["user_data"]['genre'] ?? '') == 'Femme') ? 'checked' : '' ?>>
    Femme

    <br>

    <button type="submit">Suivant</button>
</div>

</body>
</html>