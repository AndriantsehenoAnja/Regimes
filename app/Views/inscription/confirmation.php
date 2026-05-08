<?php
$userData = session()->get('user_data') ?? [];
$userSante = session()->get('user_data_sante') ?? [];
$genreLabel = '';
if (($userData['genre_id'] ?? '') === '1') {
    $genreLabel = 'Homme';
} elseif (($userData['genre_id'] ?? '') === '2') {
    $genreLabel = 'Femme';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Confirmations</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>

<div class="container">

    <h2>Confirmations</h2>

    <p><b>Nom(s) :</b> <?= esc($userData['nom'] ?? '') ?></p>

    <p><b>Email :</b> <?= esc($userData['email'] ?? '') ?></p>

    <p><b>Mot de passe :</b> ********</p>

    <p><b>Genre :</b> <?= esc($genreLabel) ?></p>

    <p><b>Tailles :</b> <?= esc($userSante['taille'] ?? '') ?> m</p>

    <p><b>Poids :</b> <?= esc($userSante['poids'] ?? '') ?> kg</p>

    <br>

    <a href="<?= base_url('/inscription2') ?>">Précédent</a>

    <a href="<?= base_url('/insertConfirmation') ?>">Confirmation</a>

</div>

<script>

</script>

</body>
</html>