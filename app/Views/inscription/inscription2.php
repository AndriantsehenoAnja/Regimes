<?php
$userSante = session()->get('user_data_sante') ?? [];
$userData = session()->get('user_data') ?? [];
$currentStep = 2;
$totalSteps = 4;
$progressPercentage = ($currentStep / $totalSteps) * 100;
?>

<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Option Gold
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('/style/inscription1.css') ?>">


<!-- Inclure la navbar -->

<div class="form-wrapper">
    <div class="form-container">
        <!-- Header -->
        <div class="form-header">
            <h2>Vos informations physiques</h2>
            <p>Pour un suivi personnalisé</p>
        </div>

        <!-- Information utilisateur -->
        <?php if(isset($userData['nom'])): ?>
        <div class="user-info-card">
            <div class="user-info-icon">👤</div>
            <div class="user-info-text">
                <div class="label">Connecté en tant que</div>
                <div class="name"><?= esc($userData['nom']) ?></div>
            </div>
            <div class="user-info-icon">✓</div>
        </div>
        <?php endif; ?>
        <!-- Formulaire -->
        <div class="form-body">
            <form action="<?= base_url('/save_user2') ?>" method="post" id="healthForm">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="taille">
                        Taille <span class="required">*</span>
                        <span class="unit">(mètres)</span>
                    </label>
                    <div class="input-wrapper">
                        <input type="number" 
                               step="0.01" 
                               id="taille" 
                               name="taille" 
                               class="form-control"
                               placeholder="1.75"
                               value="<?= esc($userSante['taille'] ?? '') ?>"
                               required>
                        <span class="input-icon">m</span>
                    </div>
                    <div class="error-message" id="tailleError"></div>
                </div>

                <div class="form-group">
                    <label for="poids">
                        Poids <span class="required">*</span>
                        <span class="unit">(kilogrammes)</span>
                    </label>
                    <div class="input-wrapper">
                        <input type="number" 
                               step="0.1" 
                               id="poids" 
                               name="poids" 
                               class="form-control"
                               placeholder="70.5"
                               value="<?= esc($userSante['poids'] ?? '') ?>"
                               required>
                        <span class="input-icon">kg</span>
                    </div>
                    <div class="error-message" id="poidsError"></div>
                </div>

                <!-- Indicateur IMC -->
                <div class="imc-indicator" id="imcIndicator">
                    <div class="imc-value">
                        IMC : <strong id="imcValue">0</strong>
                    </div>
                    <div class="imc-bar">
                        <div class="imc-bar-fill" id="imcBarFill"></div>
                    </div>
                    <div class="imc-category" id="imcCategory"></div>
                </div>

                <div class="form-actions">
                    <a href="<?= base_url('/inscription1') ?>" class="btn btn-secondary">
                        ← Précédent
                    </a>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        Suivant →
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Calcul et affichage de l'IMC en temps réel
function calculateIMC() {
    const taille = parseFloat(document.getElementById('taille').value);
    const poids = parseFloat(document.getElementById('poids').value);
    const imcIndicator = document.getElementById('imcIndicator');
    const imcValue = document.getElementById('imcValue');
    const imcBarFill = document.getElementById('imcBarFill');
    const imcCategory = document.getElementById('imcCategory');

    if (taille && poids && taille > 0 && poids > 0) {
        const imc = poids / (taille * taille);
        imcValue.textContent = imc.toFixed(1);
        imcIndicator.classList.add('show');

        // Déterminer la catégorie et la couleur
        let category = '';
        let color = '';
        let width = 0;

        if (imc < 18.5) {
            category = '⚠️ Insuffisance pondérale';
            color = '#3b82f6';
            width = 25;
        } else if (imc < 25) {
            category = '✅ Poids normal (Plage idéale)';
            color = '#10b981';
            width = 50;
        } else if (imc < 30) {
            category = '⚠️ Surpoids';
            color = '#f59e0b';
            width = 75;
        } else {
            category = '⚠️ Obésité';
            color = '#ef4444';
            width = 100;
        }

        imcCategory.textContent = category;
        imcBarFill.style.backgroundColor = color;
        imcBarFill.style.width = width + '%';

        // Ajouter un message de conseil
        if (imc < 18.5) {
            imcCategory.innerHTML += '<br><small style="color: #6b7280;">▶️ Conseil: Alimentation équilibrée et riche en nutriments</small>';
        } else if (imc < 25) {
            imcCategory.innerHTML += '<br><small style="color: #6b7280;">▶️ Conseil: Excellent! Continuez à maintenir un mode de vie sain</small>';
        } else if (imc < 30) {
            imcCategory.innerHTML += '<br><small style="color: #6b7280;">▶️ Conseil: Augmentez l\'activité physique et surveillez votre alimentation</small>';
        } else {
            imcCategory.innerHTML += '<br><small style="color: #6b7280;">▶️ Conseil: Consultez un professionnel pour un accompagnement personnalisé</small>';
        }
    } else {
        imcIndicator.classList.remove('show');
    }
}

// Validation en temps réel
function validateTaille() {
    const taille = document.getElementById('taille');
    const tailleError = document.getElementById('tailleError');
    const value = parseFloat(taille.value);

    if (isNaN(value)) {
        tailleError.textContent = 'Veuillez entrer une taille valide';
        taille.classList.add('error');
        return false;
    } else if (value < 0.5 || value > 3.0) {
        tailleError.textContent = 'La taille doit être comprise entre 0.5m et 3.0m';
        taille.classList.add('error');
        return false;
    } else {
        tailleError.textContent = '';
        taille.classList.remove('error');
        return true;
    }
}

function validatePoids() {
    const poids = document.getElementById('poids');
    const poidsError = document.getElementById('poidsError');
    const value = parseFloat(poids.value);

    if (isNaN(value)) {
        poidsError.textContent = 'Veuillez entrer un poids valide';
        poids.classList.add('error');
        return false;
    } else if (value < 10 || value > 500) {
        poidsError.textContent = 'Le poids doit être compris entre 10kg et 500kg';
        poids.classList.add('error');
        return false;
    } else {
        poidsError.textContent = '';
        poids.classList.remove('error');
        return true;
    }
}

// Écouteurs d'événements
document.getElementById('taille').addEventListener('input', function() {
    validateTaille();
    calculateIMC();
});

document.getElementById('poids').addEventListener('input', function() {
    validatePoids();
    calculateIMC();
});

// Validation du formulaire
document.getElementById('healthForm').addEventListener('submit', function(e) {
    const isTailleValid = validateTaille();
    const isPoidsValid = validatePoids();

    if (!isTailleValid || !isPoidsValid) {
        e.preventDefault();
    } else {
        const btn = document.getElementById('submitBtn');
        btn.classList.add('loading');
        btn.disabled = true;
        btn.textContent = 'Chargement...';
    }
});

// Calcul initial si des valeurs existent
if (document.getElementById('taille').value && document.getElementById('poids').value) {
    calculateIMC();
}
</script>

<style>
.btn-primary.loading {
    position: relative;
    color: transparent;
}

.btn-primary.loading::after {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    top: 50%;
    left: 50%;
    margin-left: -10px;
    margin-top: -10px;
    border: 2px solid white;
    border-top-color: transparent;
    border-radius: 50%;
    animation: spin 0.6s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}
</style>
<?= $this->endSection() ?>
