<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Créer Activité
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container">

    <h1>
        Nouvelle activité
    </h1>

    <?php if(session()->getFlashdata('success')): ?>

        <div class="alert success">
            <?= session()->getFlashdata('success') ?>
        </div>

    <?php endif; ?>

    <?php if(session()->getFlashdata('errors')): ?>
        <div class="alert error">
            <?php foreach(session()->getFlashdata('errors') as $error): ?>
                <div>
                    <?= $error ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('activite/save') ?>" method="post" class="form">
        <?= csrf_field() ?>
        <!-- NOM -->
        <div class="form-group">
            <label> Nom </label>
            <input type="text" name="nom" value="<?= old('nom') ?>" >
        </div>

        <!-- DESCRIPTION -->
        <div class="form-group">
            <label> Description </label>
            <textarea name="description"><?= old('description') ?></textarea>
        </div>
        <!-- CALORIES -->
        <div class="form-group">
            <label> Calories brûlées </label>
            <input type="number" name="calories_brulees" value="<?= old('calories_brulees') ?>">
        </div>
        <button type="submit">
            Créer activité
        </button>
    </form>

</div>

<?= $this->endSection() ?>