<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>programme 1</h2>
    <div class="container">
        <form action="<?= base_url('/suggerer') ?>" method="post">
            
            <!-- Sélection du genre -->
            <?php if (!session()->has('user')): ?>
                <fieldset>
                    <legend>Genre :</legend>
                    <label>
                        <input type="radio" name="genre" value="1" required> Homme
                    </label>
                    <label>
                        <input type="radio" name="genre" value="2" required> Femme
                    </label>
                </fieldset>
            <?php endif; ?>

            <!-- Boucle sur les objectifs -->
            <fieldset>
                <legend>Objectif :</legend>
                <?php if (!empty($objectifs) && is_array($objectifs)): ?>
                    <?php foreach ($objectifs as $objectif): ?>
                        <label>
                            <input type="radio" name="objectif" value="<?= esc($objectif['id']) ?>" data-nom="<?= esc(strtolower($objectif['nom'])) ?>" required>
                            <strong><?= esc($objectif['nom']) ?></strong> : <?= esc($objectif['description']) ?>
                        </label><br>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucun objectif trouvé.</p>
                <?php endif; ?>
            </fieldset>

            <!-- Valeur à entrer (ex: poids) -->
            <fieldset>
                <legend id="valeur_legend">Valeur visée:</legend>
                <input type="number" step="0.01" name="valeur" placeholder="Entrez la valeur" required>
            </fieldset>

            <button type="submit">Valider</button>
        </form>
    </div>

    <script>
        document.querySelectorAll('input[name="objectif_id"]').forEach(function(radio) {
            radio.addEventListener('change', function() {
                var nomObjectif = this.getAttribute('data-nom');
                var legendText = 'Valeur visée :';
                
                if (nomObjectif.includes('perte')) {
                    legendText = 'Valeur [diminuer de (kg)] :';
                } else if (nomObjectif.includes('augment') || nomObjectif.includes('prise')) {
                    legendText = 'Valeur [augmenter de (kg)] :';
                } else if (nomObjectif.includes('imc')) {
                    legendText = 'Valeur [votre imc ciblée] :';
                }
                
                document.getElementById('valeur_legend').innerText = legendText;
            });
        });
    </script>
</body>
</html>