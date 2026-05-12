<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Activités
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<style>

.activite-container {
    max-width: 1000px;
    margin: 40px auto;
    padding: 20px;
}

.top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.page-title {
    font-size: 2rem;
    font-weight: bold;
}

.btn-add {
    background: #111827;
    color: white;
    padding: 12px 18px;
    border-radius: 8px;
    text-decoration: none;
}

.activite-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px,1fr));
    gap: 25px;
}

.activite-card {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.activite-title {
    font-size: 1.4rem;
    font-weight: bold;
    margin-bottom: 15px;
}

.activite-description {
    color: #555;
    margin-bottom: 20px;
}

.activite-calories {
    color: #27ae60;
    font-weight: bold;
}

.empty-state {
    background: white;
    padding: 40px;
    border-radius: 12px;
    text-align: center;
}

.alert-success {
    background: #d4edda;
    color: #155724;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
}

</style>

<div class="activite-container">

    <?php if(session()->getFlashdata('success')): ?>

        <div class="alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>

    <?php endif; ?>

    <div class="top-bar">

        <div class="page-title">
            Liste des Activités
        </div>
<?php if(session()->get('isAdmin')): ?>
        <a
            href="<?= base_url('activite/form') ?>"
            class="btn-add"
        >
            Ajouter une activité
        </a>
 <?php endif; ?>
    </div>

    <?php if(!empty($activites)): ?>

        <div class="activite-grid">

            <?php foreach($activites as $activite): ?>

                <div class="activite-card">

                    <div class="activite-title">
                        <?= esc($activite['nom']) ?>
                    </div>

                    <div class="activite-description">
                        <?= esc($activite['description']) ?>
                    </div>

                    <div class="activite-calories">
                        Calories brûlées :
                        <?= esc($activite['calories_brulees']) ?>
                    </div>
                    <?php if(session()->get('isAdmin')): ?>
                    <a href="<?= base_url('activite/edit/' . $activite['id']) ?>">
                        Modifier
                    </a>
                    <a href="<?= base_url('activite/delete/' . $activite['id']) ?>" class="btn-delete">Supprimer</a>
                    <?php endif; ?>

                </div>

            <?php endforeach; ?>

        </div>

    <?php else: ?>

        <div class="empty-state">

            Aucune activité trouvée.

        </div>

    <?php endif; ?>

</div>

<?= $this->endSection() ?>