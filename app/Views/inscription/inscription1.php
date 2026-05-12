<?php
$userData = session()->get('user_data') ?? [];
$currentStep = 1;
$totalSteps = 4; // À ajuster selon votre nombre total d'étapes
$progressPercentage = ($currentStep / $totalSteps) * 100;
?>

<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Option Gold
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('/style/inscription1.css') ?>">

<div class="form-wrapper">
    <div class="form-container">
        <!-- Header -->
        <div class="form-header">
            <h2>Créer votre compte</h2>
            <p>Rejoignez l'aventure Comme J'aime</p>
        </div>

        <!-- Formulaire -->
        <div class="form-body">
            <form action="<?= base_url('/save_user1') ?>" method="post" id="registrationForm">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="nom">
                        Nom complet <span class="required">*</span>
                    </label>
                    <input type="text" 
                           id="nom" 
                           name="nom" 
                           class="form-control"
                           placeholder="Jean Dupont"
                           value="<?= esc($userData['nom'] ?? '') ?>"
                           required>
                    <div class="error-message" id="nomError"></div>
                </div>

                <div class="form-group">
                    <label for="email">
                        Adresse email <span class="required">*</span>
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           class="form-control"
                           placeholder="jean.dupont@email.com"
                           value="<?= esc($userData['email'] ?? '') ?>"
                           required>
                    <div class="error-message" id="emailError"></div>
                </div>

                <div class="form-group">
                    <label for="password">
                        Mot de passe <span class="required">*</span>
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="form-control"
                           placeholder="••••••••"
                           required>
                    <div class="error-message" id="passwordError"></div>
                    <small style="color: #6b7280; font-size: 12px; margin-top: 6px; display: block;">
                        Minimum 8 caractères
                    </small>
                </div>

                <div class="form-group">
                    <label>Genre <span class="required">*</span></label>
                    <div class="radio-group">
                        <div class="radio-option">
                            <input type="radio" 
                                   name="genre_id" 
                                   value="1"
                                   id="homme"
                                   <?= (strval($userData['genre_id'] ?? '') === '1') ? 'checked' : '' ?>
                                   required>
                            <label for="homme">👨 Homme</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" 
                                   name="genre_id" 
                                   value="2"
                                   id="femme"
                                   <?= (strval($userData['genre_id'] ?? '') === '2') ? 'checked' : '' ?>
                                   required>
                            <label for="femme">👩 Femme</label>
                        </div>
                    </div>
                    <div class="error-message" id="genreError"></div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        Suivant →
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Validation en temps réel
document.getElementById('registrationForm').addEventListener('submit', function(e) {
    let isValid = true;
    
    // Validation du nom
    const nom = document.getElementById('nom');
    const nomError = document.getElementById('nomError');
    if (nom.value.trim().length < 2) {
        nomError.textContent = 'Le nom doit contenir au moins 2 caractères';
        nom.classList.add('error');
        isValid = false;
    } else {
        nomError.textContent = '';
        nom.classList.remove('error');
    }
    
    // Validation de l'email
    const email = document.getElementById('email');
    const emailError = document.getElementById('emailError');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email.value)) {
        emailError.textContent = 'Veuillez entrer une adresse email valide';
        email.classList.add('error');
        isValid = false;
    } else {
        emailError.textContent = '';
        email.classList.remove('error');
    }
    
    // Validation du mot de passe
    const password = document.getElementById('password');
    const passwordError = document.getElementById('passwordError');
    if (password.value.length < 8) {
        passwordError.textContent = 'Le mot de passe doit contenir au moins 8 caractères';
        password.classList.add('error');
        isValid = false;
    } else {
        passwordError.textContent = '';
        password.classList.remove('error');
    }
    
    // Validation du genre
    const genre = document.querySelector('input[name="genre_id"]:checked');
    const genreError = document.getElementById('genreError');
    if (!genre) {
        genreError.textContent = 'Veuillez sélectionner un genre';
        isValid = false;
    } else {
        genreError.textContent = '';
    }
    
    if (!isValid) {
        e.preventDefault();
    } else {
        // Ajouter un effet de chargement
        const btn = document.getElementById('submitBtn');
        btn.classList.add('loading');
        btn.disabled = true;
    }
});

// Validation en direct
document.getElementById('nom').addEventListener('input', function() {
    if (this.value.trim().length >= 2) {
        document.getElementById('nomError').textContent = '';
        this.classList.remove('error');
    }
});

document.getElementById('email').addEventListener('input', function() {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (emailRegex.test(this.value)) {
        document.getElementById('emailError').textContent = '';
        this.classList.remove('error');
    }
});

document.getElementById('password').addEventListener('input', function() {
    if (this.value.length >= 8) {
        document.getElementById('passwordError').textContent = '';
        this.classList.remove('error');
    }
});

document.querySelectorAll('input[name="genre_id"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.getElementById('genreError').textContent = '';
    });
});
</script>
<?= $this->endSection() ?>
