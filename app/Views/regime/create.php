<?php $this->extend('layout/main') ?>
<?php $this->section('title'); ?>Creer un regime<?php $this->endSection(); ?>
<?php $this->section('content') ?>

    <h2>Créer un nouveau Régime</h2>

    <?php if (session()->getFlashdata('error')) : ?>
        <div style="color: red;"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="/regimes/store" method="post">
        
        <!-- FIRST FIELDSET : Informations principales du régime -->
        <fieldset>
            <legend>Informations du Régime</legend>
            <label>Nom :</label>
            <input type="text" name="nom" required><br><br>

            <label>Description :</label>
            <textarea name="description" required></textarea><br><br>

            <label>Prix :</label>
            <input type="number" step="0.01" name="prix" required><br><br>

            <label>Durée (en jours) :</label>
            <input type="number" name="duree" required><br><br>

            <!-- La variation est demandée ! -->
            <label>Variation (ex: -5.00 pour perte ou +2.00 pour prise) :</label>
            <input type="number" step="0.01" name="variation" required><br><br>

            <label>Type de régime :</label>
            <select name="type_regime" required>
                <option value="perte">Perte</option>
                <option value="prise">Prise</option>
            </select>
        </fieldset>
        
        <br>

        <!-- SECOND FIELDSET : Composition du Régime -->
        <fieldset>
            <legend>Composition Nutritionnelle (en %)</legend>
            
            <label>Viande :</label>
            <input type="number" name="pourcentage_viande" max="100" required><br><br>

            <label>Poisson :</label>
            <input type="number" name="pourcentage_poisson" max="100" required><br><br>

            <label>Volaille :</label>
            <input type="number" name="pourcentage_volaille" max="100" required>
        </fieldset>
        
        <br>

        <!-- THIRD FIELDSET : Choix des Activités -->
        <fieldset>
            <legend>Activités Liées au Régime</legend>
            <p>Sélectionnez les activités adaptées à ce régime :</p>
            
            <?php foreach($activites as $act): ?>
                <label>
                    <input type="checkbox" name="activites[]" value="<?= $act['id'] ?>">
                    <strong><?= esc($act['nom']) ?></strong> (<?= esc($act['calories_brulees']) ?> cal.)
                </label>
                &nbsp;|&nbsp; 
                <label>Variation :</label>
                <input type="number" step="0.01" name="variation_activite[<?= $act['id'] ?>]" placeholder="Ex: 1.5"><br>
            <?php endforeach; ?>
        </fieldset>
        
        <br>
        <button type="submit">Créer le régime</button>
    </form>
<?php $this->endSection() ?>