<?php $this->extend('layout/main') ?>
<?php $this->section('title'); ?>Programme de régimes<?php $this->endSection(); ?>
<?php $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('/style/programme1.css') ?>">
<div class="programmes-container">
    <h2>Choisis ton programme</h2>
    
    <!-- Section principale avec IMC et Objectif côte à côte -->
    <div class="main-grid">
        
        <!-- Bloc IMC à gauche -->
        <div class="imc-block">
            <div class="imc-block-title">📊 Classification IMC</div>
            <div class="imc-grid">
                <?php foreach ($imc as $index => $im): ?>
                    <div class="imc-card">
                        <div class="imc-category"><?= esc($im['categorie']) ?></div>
                        <div class="imc-range">
                            <?= esc($im['intervalle_min']) ?> - <?= esc($im['intervalle_max']) ?>
                        </div>
                        <div class="imc-bar">
                            <div class="imc-bar-fill" style="width: <?= (($im['intervalle_max'] ?? 30) / 40) * 100 ?>%"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Formulaire à droite avec sélection objectif -->
        <div class="form-card">
            <div class="form-title">🎯 Sélection de l'objectif</div>
            <form action="<?= base_url('/suggerer') ?>" method="post">
                <?= csrf_field() ?>
                
                <!-- Sélection du genre (si non connecté) -->
                <?php if (!session()->has('user')): ?>
                    <div class="form-group">
                        <label class="form-label">Genre</label>
                        <div class="radio-group">
                            <label class="radio-option">
                                <input type="radio" name="genre" value="1" required> 
                                <span>👨 Homme</span>
                            </label>
                            <label class="radio-option">
                                <input type="radio" name="genre" value="2" required> 
                                <span>👩 Femme</span>
                            </label>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Objectifs -->
                <div class="form-group">
                    <label class="form-label">Objectif</label>
                    <div class="objectifs-list">
                        <?php if (!empty($objectifs) && is_array($objectifs)): ?>
                            <?php foreach ($objectifs as $objectif): ?>
                                <label class="objectif-item">
                                    <input type="radio" name="objectif" value="<?= esc($objectif['id']) ?>" 
                                           data-nom="<?= esc(strtolower($objectif['nom'])) ?>" required>
                                    <div class="objectif-content">
                                        <strong><?= esc($objectif['nom']) ?></strong>
                                        <span class="objectif-desc"><?= esc($objectif['description']) ?></span>
                                    </div>
                                </label>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Aucun objectif trouvé.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Valeur visée -->
                <div class="form-group">
                    <label class="form-label" id="valeur_legend">Valeur visée</label>
                    <div class="input-wrapper">
                        <input type="number" step="0.01" name="valeur" placeholder="Entrez votre valeur cible" required>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Valider mon programme</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('input[name="objectif"]').forEach(function(radio) {
        radio.addEventListener('change', function() {
            var nomObjectif = this.getAttribute('data-nom');
            var legendText = 'Valeur visée';
            var placeholder = 'Entrez votre valeur cible';
            
            if (nomObjectif.includes('perte')) {
                legendText = '🎯 Perte de poids';
                placeholder = 'Nombre de kg à perdre';
            } else if (nomObjectif.includes('augment') || nomObjectif.includes('prise')) {
                legendText = '💪 Prise de masse';
                placeholder = 'Nombre de kg à gagner';
            } else if (nomObjectif.includes('imc')) {
                legendText = '📊 IMC cible';
                placeholder = 'Votre IMC idéal (18.5 - 25)';
            }
            
            document.getElementById('valeur_legend').innerHTML = legendText;
            document.querySelector('input[name="valeur"]').placeholder = placeholder;
        });
    });
</script>



<?php $this->endSection() ?>