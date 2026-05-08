<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Option Gold
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container">

    <h1>
        Option Gold
    </h1>

    <p>
        Prix :
        <strong>
            <?= number_format(50000, 0, ',', ' ') ?> Ar
        </strong>
    </p>

    <p>
        Réduction de 15% sur tous les régimes.
    </p>

    <p>
        Votre solde :
        <strong>
            <?= number_format(session()->get('solde'), 0, ',', ' ') ?> Ar
        </strong>
    </p>

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

    <?php if(session()->get('is_gold')): ?>

        <div class="gold-active">
            Vous êtes déjà Gold.
        </div>

    <?php else: ?>

        <form
            action="<?= base_url('gold/activer') ?>"
            method="post"
        >

            <?= csrf_field() ?>

            <button type="submit">
                Activer Gold
            </button>

        </form>

    <?php endif; ?>

</div>

<?= $this->endSection() ?>