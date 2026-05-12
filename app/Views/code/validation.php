<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Validation des codes
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container my-5">
    <h2>Demandes d'ajout de solde</h2>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($demandes)): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Utilisateur</th>
                    <th>Code saisi</th>
                    <th>Montant</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($demandes as $demande): ?>
                    <tr>
                        <td><?= esc($demande['user_nom']) ?></td>
                        <td><?= esc($demande['code_val']) ?></td>
                        <td><?= esc($demande['montant']) ?> Ar</td>
                        <td>
                            <form action="<?= base_url('codes/valider/' . $demande['id']) ?>" method="POST" style="display:inline-block;">
                                <button type="submit" class="btn btn-success btn-sm">Valider</button>
                            </form>
                            <form action="<?= base_url('codes/refuser/' . $demande['id']) ?>" method="POST" style="display:inline-block;">
                                <button type="submit" class="btn btn-danger btn-sm">Refuser</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucune demande de validation en attente.</p>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
