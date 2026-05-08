<?php
$userData = session()->get('user_data') ?? [];
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
    <form action="<?= base_url('/save_user1') ?>" method="post">
        <input type="text" id="nom" name="nom" placeholder="Nom"
        value="<?= esc($userData['nom'] ?? '') ?>">

        <input type="email" id="email" name="email" placeholder="Email"
        value="<?= esc($userData['email'] ?? '') ?>">

    <input type="password" id="password" name="password" placeholder="Mot de passe"
    value="">

    <br><br>

    Genre :

    <input type="radio" name="genre_id" value="1"
    <?= (strval($userData['genre_id'] ?? '') === '1') ? 'checked' : '' ?>>
    Homme

    <input type="radio" name="genre_id" value="2"
    <?= (strval($userData['genre_id'] ?? '') === '2') ? 'checked' : '' ?>>
    Femme

    <br>

    <button type="submit">Suivant</button>
</div>

</body>
</html>