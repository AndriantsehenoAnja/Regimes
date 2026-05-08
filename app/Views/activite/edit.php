<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Activité</title>
</head>
<body>

    <h1>Modifier Activité</h1>

    <form action="<?= base_url('activite/update/' . $activite['id']) ?>" method="post">
        <div>
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" value="<?= esc($activite['nom']) ?>">
        </div>
        <div>
            <label for="description">Description</label>
            <textarea id="description" name="description"><?= esc($activite['description']) ?></textarea>
        </div>
        <div>
            <label for="calories_brulees">Calories Brûlées</label>
            <input type="number" id="calories_brulees" name="calories_brulees" value="<?= esc($activite['calories_brulees']) ?>">
        </div>
        <button type="submit">Mettre à jour</button>
    </form>

</body>
</html>
        