<?php $this->extend('layout/main') ?>
<?php $this->section('title'); ?>Liste des Régimes<?php $this->endSection(); ?>
<?php $this->section('content') ?>
<a href="<?= base_url('/regimes/create') ?>">Ajouter un régime</a>
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
<?php $this->endSection() ?>

