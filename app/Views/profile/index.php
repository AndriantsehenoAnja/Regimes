<!-- app/Views/profile/index.php -->

<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Mon Profil
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<style>

.profile-container {
    max-width: 1100px;
    margin: 40px auto;
    padding: 20px;
}

.profile-header {
    background: white;
    border-radius: 12px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.profile-name {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 10px;
}

.profile-info {
    color: #555;
    margin-bottom: 10px;
}

.gold-badge {
    display: inline-block;
    background: gold;
    color: black;
    padding: 6px 14px;
    border-radius: 20px;
    font-weight: bold;
    margin-top: 10px;
}

.solde-box {
    margin-top: 15px;
    font-size: 1.2rem;
    font-weight: bold;
}

.section-title {
    font-size: 1.8rem;
    margin-bottom: 25px;
    color: #2c3e50;
}

.regimes-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 25px;
}

.regime-card {
    background: white;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.regime-title {
    font-size: 1.4rem;
    font-weight: bold;
    margin-bottom: 15px;
}

.regime-info {
    margin-bottom: 10px;
    color: #555;
}

.alert {
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.alert-success {
    background: #d4edda;
    color: #155724;
}

.empty-state {
    background: white;
    padding: 40px;
    border-radius: 12px;
    text-align: center;
    color: #777;
}

</style>

<div class="profile-container">

    <!-- SUCCESS -->
    <?php if(session()->getFlashdata('success')): ?>

        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>

    <?php endif; ?>

    <!-- USER -->
    <div class="profile-header">

        <div class="profile-name">
            <?= esc($user['nom']) ?>
        </div>
        <div>
            <?= $user_info['taille'] ?>
        </div>
        <div>
            <?=  $user_info['poids'] ?>
        </div>
        <div class="profile-info">
            <?= esc($user['email']) ?>
        </div>

        <div class="solde-box">
            Solde :
            <?= number_format($user['solde'], 2, ',', ' ') ?>
            Ar
        </div>

        <?php if($user['is_gold']): ?>

            <div class="gold-badge">
                GOLD MEMBER
            </div>

        <?php endif; ?>

    </div>

    <!-- MES REGIMES -->
    <h2 class="section-title">
        Mes Régimes
    </h2>

    <?php if(!empty($achats)): ?>

        <div class="regimes-grid">

            <?php foreach($achats as $achat): ?>

                <div class="regime-card">

                    <div class="regime-title">
                        <?= esc($achat['regime_nom']) ?>
                    </div>

                    <div class="regime-info">
                        <?= esc($achat['description']) ?>
                    </div>

                    <div class="regime-info">
                        Durée :
                        <?= esc($achat['duree']) ?> jours
                    </div>

                    <div class="regime-info">
                        Type :
                        <?= esc($achat['type_regime']) ?>
                    </div>

                    <div class="regime-info">
                        Prix payé :
                        <?= number_format($achat['prix_paye'], 2, ',', ' ') ?>
                        Ar
                    </div>

                    <div class="regime-info">
                        Achat :
                        <?= esc($achat['date_achat']) ?>
                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    <?php else: ?>

        <div class="empty-state">

            Vous n'avez encore acheté aucun régime.

        </div>

    <?php endif; ?>

</div>

<?= $this->endSection() ?>