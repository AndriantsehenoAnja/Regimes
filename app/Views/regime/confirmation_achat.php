<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Confirmation de l'achat
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container my-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h2 class="mb-0">Détails de votre régime</h2>
        </div>
        <div class="card-body">
            <h3><?= esc($regime['nom']) ?></h3>
            <p><strong>Description:</strong> <?= esc($regime['description']) ?></p>
            
            <h5 class="mt-4">Informations</h5>
            <ul class="list-group list-group-flush mb-4">
                <li class="list-group-item"><strong>Durée par cycle:</strong> <?= esc($regime['duree']) ?> jours</li>
                <li class="list-group-item"><strong>Multiplicateur (cycles):</strong> <?= esc($multiplicateur) ?></li>
                <li class="list-group-item"><strong>Prix Total:</strong> <?= number_format($prixTotal, 2, ',', ' ') ?> Ar</li>
            </ul>

            <h5 class="mt-4">Activités incluses</h5>
            <?php if (!empty($activites)): ?>
                <ul class="list-group mb-4">
                    <?php foreach ($activites as $act): ?>
                        <li class="list-group-item">- <?= esc($act['nom']) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Aucune activité spécifiée.</p>
            <?php endif; ?>

            <?php
                $user = session()->get('user');
                $prixFinal = $prixTotal;
                if ($user['is_gold']) {
                    $prixFinal = $prixFinal - ($prixFinal * 0.15);
                    echo "<div class='alert alert-info'><strong>Avantage Gold:</strong> Vous bénéficiez d'une réduction de 15%. Prix final: " . number_format($prixFinal, 2, ',', ' ') . " Ar</div>";
                }
                $soldeSuffisant = $user['solde'] >= $prixFinal;
            ?>

            <div class="d-flex justify-content-between mt-4">
                <form action="<?= base_url('/suggerer') ?>" method="post">
                    <input type="hidden" name="valeur" value="<?= session()->get('valeur') ?>">
                    <input type="hidden" name="objectif" value="<?= session()->get('objectif') ?>">

                    <button type="submit" class="btn btn-secondary">Précédent</button>
                </form>
                
                <form action="<?= base_url('/acheter') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="regime_id" value="<?= esc($regime['id']) ?>">
                    <input type="hidden" name="multiplicateur" value="<?= esc($multiplicateur) ?>">
                    <input type="hidden" name="prix" value="<?= esc($prixTotal) ?>">
                    
                    <button type="submit" class="btn btn-success" <?= !$soldeSuffisant ? 'disabled' : '' ?>>
                        <?= $soldeSuffisant ? 'Confirmer l\'achat' : 'Solde insuffisant' ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
