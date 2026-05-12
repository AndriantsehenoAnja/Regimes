<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Exportation PDF - <?= esc($regime['nom']) ?></title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 14px; }
        .header { text-align: center; margin-bottom: 20px; }
        .title { font-size: 24px; font-weight: bold; }
        .details { margin-bottom: 20px; }
        .details p { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .footer { margin-top: 40px; text-align: right; font-size: 12px; }
    </style>
</head>
<body>

    <div class="header">
        <h1 class="title">Rapport de Régime</h1>
        <p>Généré le <?= date('d/m/Y') ?></p>
    </div>

    <div class="details">
        <h3>Informations Utilisateur</h3>
        <p><strong>Nom : </strong> <?= esc($user['nom']) ?></p>
        <p><strong>Date d'achat : </strong> <?= esc($date_achat) ?></p>
    </div>

    <div class="details">
        <h3>Détails du Régime</h3>
        <p><strong>Nom du régime : </strong> <?= esc($regime['nom']) ?></p>
        <p><strong>Prix : </strong> <?= esc($regime['prix']) ?> MGA</p>
    </div>

    <h4>Activités Sportives Associées</h4>
    <?php if (empty($activites)): ?>
        <p>Aucune activité associée à ce régime.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Nom de l'activité</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($activites as $act): ?>
                    <tr>
                        <td><?= esc($act['nom']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <div class="footer">
        <p>Merci pour votre confiance.</p>
    </div>

</body>
</html>
