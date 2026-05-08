<?php
$userSante = session()->get('user_data_sante') ?? [];
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
    <form action="<?= base_url('/save_user2') ?>" method="post">
        <input type="number" step="0.01" id="taille" name="taille" placeholder="Taille (m)"
        value="<?= esc($userSante['taille'] ?? '') ?>">

        <input type="number" step="0.1" id="poids" name="poids" placeholder="Poids (kg)"
        value="<?= esc($userSante['poids'] ?? '') ?>">
        <button type="submit">suivant</button>
        <a href="<?= base_url('/inscription1') ?>">Précédent</a>
    </form>

</div>

<script>
</script>

</body>
</html>