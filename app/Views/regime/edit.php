<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Modifier le Régime</h1>
    <?php if (session()->getFlashdata('error')) : ?>
        <div style="color: red;">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>
    <form action="/regimes/update/<?= esc($regime['id']) ?>" method="post">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" value="<?= esc($regime['nom']) ?>" required><br><br>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?= esc($regime['description']) ?></textarea><br><br>
        <label for="prix">Prix:</label>
        <input type="number" step="0.01" id="prix" name="prix" value="<?= esc($regime['prix']) ?>" required><br><br>
        <label for="duree">Durée (en jours):</label>
        <input type="number" id="duree" name="duree" value="<?= esc($regime['duree']) ?>" required><br><br>
        <label for="variation">Variation (ex: -5.00 pour perte ou +2.00 pour prise):</label>
        <input type="number" step="0.01" id="variation" name="variation" value="<?= esc($regime['variation']) ?>" required><br><br>
        <label for="type_regime">Type de régime:</label>
        <select id="type_regime" name="type_regime" required>
            <option value="perte" <?= $regime['type_regime'] === 'perte' ? 'selected' : '' ?>>Perte</option>
            <option value="prise" <?= $regime['type_regime'] === 'prise' ? 'selected' : '' ?>>Prise</option>
        </select><br><br>
        <label for="pourcentage_viande">Pourcentage viande:</label>
        <input type="number" step="0.01" id="pourcentage_viande" name="pourcentage_viande" value="<?= esc($regime['pourcentage_viande']) ?>" required><br><br>
        <label for="pourcentage_poisson">Pourcentage poisson:</label>
        <input type="number" step="0.01" id="pourcentage_poisson" name="pourcentage_poisson" value="<?= esc($regime['pourcentage_poisson']) ?>" required><br><br>
        <label for="pourcentage_volaille">Pourcentage volaille:</label>
        <input type="number" step="0.01" id="pourcentage_volaille" name="pourcentage_volaille" value="<?= esc($regime['pourcentage_volaille']) ?>" required><br><br>

        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>
