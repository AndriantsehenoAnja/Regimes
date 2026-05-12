<?php
$userData = session()->get('user_data') ?? [];
$userSante = session()->get('user_data_sante') ?? [];
$genreLabel = '';
if (($userData['genre_id'] ?? '') === '1') {
    $genreLabel = 'Homme';
} elseif (($userData['genre_id'] ?? '') === '2') {
    $genreLabel = 'Femme';
}

// Calcul de l'IMC
$imc = '';
$imcCategory = '';
$imcColor = '';
if (!empty($userSante['taille']) && !empty($userSante['poids'])) {
    $taille = floatval($userSante['taille']);
    $poids = floatval($userSante['poids']);
    if ($taille > 0 && $poids > 0) {
        $imc = $poids / ($taille * $taille);
        $imc = number_format($imc, 1);
        
        if ($imc < 18.5) {
            $imcCategory = 'Insuffisance pondérale';
            $imcColor = '#3b82f6';
        } elseif ($imc < 25) {
            $imcCategory = 'Poids normal';
            $imcColor = '#10b981';
        } elseif ($imc < 30) {
            $imcCategory = 'Surpoids';
            $imcColor = '#f59e0b';
        } else {
            $imcCategory = 'Obésité';
            $imcColor = '#ef4444';
        }
    }
}
?>
<link rel="stylesheet" href="style/gold.css">
<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Option Gold
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container">
    
    <link rel="stylesheet" href="<?= base_url('/style/confirmation1.css') ?>">
<!-- Inclure la navbar -->

<div class="confirmation-wrapper">
    <div class="confirmation-container">
        <!-- Header -->
        <div class="confirmation-header">
            <div class="success-icon">✓</div>
            <h2>Vérification des informations</h2>
            <p>Veuillez confirmer que toutes les informations sont correctes</p>
        </div>

        <!-- Corps -->
        <div class="confirmation-body">
            <!-- Section Informations personnelles -->
            <div class="info-section">
                <div class="section-title">
                    <span class="icon">👤</span>
                    <span>Informations personnelles</span>
                </div>
                <div class="info-grid">
                    <div class="info-card">
                        <div class="info-label">Nom complet</div>
                        <div class="info-value"><?= esc($userData['nom'] ?? 'Non renseigné') ?></div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Adresse email</div>
                        <div class="info-value"><?= esc($userData['email'] ?? 'Non renseigné') ?></div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Mot de passe</div>
                        <div class="info-value password">••••••••</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Genre</div>
                        <div class="info-value">
                            <?php if($genreLabel == 'Homme'): ?>
                                👨 <?= esc($genreLabel) ?>
                            <?php elseif($genreLabel == 'Femme'): ?>
                                👩 <?= esc($genreLabel) ?>
                            <?php else: ?>
                                <?= esc($genreLabel) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Données physiques -->
            <div class="info-section">
                <div class="section-title">
                    <span class="icon">📊</span>
                    <span>Données physiques</span>
                </div>
                <div class="info-grid">
                    <div class="info-card">
                        <div class="info-label">Taille</div>
                        <div class="info-value">
                            <?= esc($userSante['taille'] ?? 'Non renseigné') ?>
                            <?php if(!empty($userSante['taille'])): ?>m<?php endif; ?>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Poids</div>
                        <div class="info-value">
                            <?= esc($userSante['poids'] ?? 'Non renseigné') ?>
                            <?php if(!empty($userSante['poids'])): ?>kg<?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Affichage IMC si disponible -->
                <?php if($imc): ?>
                <div class="imc-card">
                    <div class="info-label">Indice de Masse Corporelle (IMC)</div>
                    <div class="imc-value"><?= $imc ?></div>
                    <div class="imc-category" style="background: <?= $imcColor ?>20; color: <?= $imcColor ?>;">
                        <?= $imcCategory ?>
                    </div>
                    <div class="imc-bar-container">
                        <div class="imc-bar" style="width: <?= min(($imc / 40) * 100, 100) ?>%; background: <?= $imcColor ?>;"></div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Avertissement -->
            <div class="alert-warning">
                <div class="icon">⚠️</div>
                <div class="text">
                    <strong>Attention :</strong> Veuillez vérifier que toutes vos informations sont correctes avant de confirmer. 
                    Vous ne pourrez pas modifier ces informations après validation.
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="form-actions">
                <a href="<?= base_url('/inscription2') ?>" class="btn btn-secondary">
                    ← Modifier
                </a>
                <a href="<?= base_url('/insertConfirmation') ?>" class="btn btn-primary">
                    Confirmer l'inscription →
                </a>
            </div>
        </div>
    </div>
</div>

<script>
// Animation de la barre IMC au chargement
document.addEventListener('DOMContentLoaded', function() {
    const imcBar = document.querySelector('.imc-bar');
    if (imcBar) {
        const width = imcBar.style.width;
        imcBar.style.width = '0%';
        setTimeout(() => {
            imcBar.style.width = width;
        }, 100);
    }
});
</script>

<?= $this->endSection() ?>
