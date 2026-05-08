<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Ajouter Argent
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container">

    <h1>
        Ajouter de l'argent
    </h1>

    <?php if(session()->getFlashdata('success')): ?>

        <div class="alert success">
            <?= session()->getFlashdata('success') ?>
        </div>

    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>

        <div class="alert error">
            <?= session()->getFlashdata('error') ?>
        </div>

    <?php endif; ?>

    <form
        action="<?= base_url('code/ajouter') ?>"
        method="post"
        class="code-form"
    >

        <?= csrf_field() ?>

        <label>
            Entrer votre code
        </label>

        <input
            type="text"
            name="code"
            placeholder="CODE123"
            required
        >

        <button type="submit">
            Valider le code
        </button>

    </form>

</div>

<?= $this->endSection() ?>