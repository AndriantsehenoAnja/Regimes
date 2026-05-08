<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Liste des Régimes</h1>
    <ul>
        <?php foreach ($regimes as $regime): ?>
            <div>
                <li>
                    <h2><?= esc($regime['nom']) ?></h2>
                    <p><?= esc($regime['description']) ?></p>
                    <p>Prix: <?= esc($regime['prix']) ?> €</p>
                    <p>Durée: <?= esc($regime['duree']) ?> jours</p>
                    <p>Variation: <?= esc($regime['variation']) ?> kg</p>
                    <p>Type: <?= esc($regime['type_regime']) ?></p>
                </li>
                <a href="/regimes/edit/<?= esc($regime['id']) ?>">Modifier</a>
                <a href="/regimes/delete/<?= esc($regime['id']) ?>">Supprimer</a>
                <h4>les activites</h4>
                
            </div>
        <?php endforeach; ?>
    </ul>
</body>
</html>
