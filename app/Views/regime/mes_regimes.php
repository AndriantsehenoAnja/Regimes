<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h2>Mes Régimes Achetés</h2>
    
    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <?php if (empty($achats)): ?>
        <div class="alert alert-info">Vous n'avez acheté aucun régime.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Nom du Régime</th>
                        <th>Date d'Achat</th>
                        <th>Prix</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($achats as $achat): ?>
                        <tr>
                            <td><?= esc($achat['regime_nom'] ?? 'Régime inconnu') ?></td>
                            <td><?= esc($achat['date_achat'] ?? 'Date inconnue') ?></td>
                            <td><?= esc($achat['prix'] ?? 'N/A') ?> MGA</td>
                            <td>
                                <a href="<?= base_url('mes-regimes/export/' . $achat['regime_id']) ?>" class="btn btn-primary btn-sm">
                                    Exporter PDF
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>