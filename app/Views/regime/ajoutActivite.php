<?php $this->extend('layout/main') ?>
<?php $this->section('title'); ?>Creer un regime<?php $this->endSection(); ?>
<?php $this->section('content') ?>

<form action="<?= base_url('regimes/ajouterActivite/' . $regime['id']) ?>" method="post">
<?php foreach ($activites as $activite): ?>
    <div>
        <h3><?= esc($activite['nom']) ?></h3>
        <p><?= esc($activite['description']) ?></p>
        <label>
                    <input type="checkbox" name="activites[]" value="<?= $activite['id'] ?>">
                    <strong><?= esc($activite['nom']) ?></strong> (<?= esc($activite['calories_brulees']) ?> cal.)
        </label>
                &nbsp;|&nbsp; 
        <label>Variation :</label>
        <input type="number" step="0.01" name="variation_activite[<?= $activite['id'] ?>]" placeholder="Ex: 1.5"><br>
    </div>
    <?php endforeach; ?>    
    <button type="submit">Ajouter l'activité au régime</button>
</form>


<?php $this->endSection() ?>
