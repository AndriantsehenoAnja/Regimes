<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Créer un Code
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="code-container">
    <div class="code-box">
        <h2>🏷️ Créer un nouveau code</h2>
        <p>Générez un code contenant de l'argent pour alimenter les portefeuilles virtuels</p>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger" style="margin-bottom: 20px; padding: 15px; border-radius: 8px; background: #fee2e2; color: #991b1b;">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success" style="margin-bottom: 20px; padding: 15px; border-radius: 8px; background: #d1fae5; color: #065f46;">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('codes/store') ?>" method="POST">
            <div class="form-group" style="margin-bottom: 20px;">
                <label for="code" style="display: block; margin-bottom: 8px; font-weight: bold;">Code (ex: PROMO50, GIFT2026)</label>
                <input type="text" name="code" id="code" class="form-control" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px; text-transform: uppercase;" required>
            </div>
            
            <div class="form-group" style="margin-bottom: 30px;">
                <label for="montant" style="display: block; margin-bottom: 8px; font-weight: bold;">Montant (Ar)</label>
                <input type="number" name="montant" id="montant" class="form-control" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px;" step="0.01" min="1" required>
            </div>

            <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px; border: none; border-radius: 8px; width: 100%; cursor: pointer; font-size: 16px; font-weight: bold;">Saisir le Code dans la base</button>
        </form>
    </div>
</div>

<style>
.code-container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 70vh;
    padding: 20px;
}
.code-box {
    background: white;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    max-width: 500px;
    width: 100%;
}
.code-box h2 {
    margin-bottom: 10px;
    color: #111827;
}
.code-box p {
    color: #6b7280;
    margin-bottom: 30px;
}
</style>
<?= $this->endSection() ?>
