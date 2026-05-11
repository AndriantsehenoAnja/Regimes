<?php $this->extend('layout/main') ?>
<?php $this->section('title'); ?>Modifier Activite<?php $this->endSection(); ?>
<?php $this->section('content') ?>


    <h1>Modifier Activités</h1>

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

<?php $this->endSection() ?>