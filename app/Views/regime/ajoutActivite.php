<?php $this->extend('layout/main') ?>
<?php $this->section('title'); ?>Créer un régime<?php $this->endSection(); ?>
<?php $this->section('content') ?>

<div class="regime-container">
    <div class="regime-header">
        <h2>📋 Créer un régime personnalisé</h2>
        <p>Sélectionnez les activités à inclure dans votre programme "<strong><?= esc($regime['nom'] ?? '') ?></strong>"</p>
    </div>

    <form action="<?= base_url('regimes/ajouterActivite/' . $regime['id']) ?>" method="post" class="regime-form">
        <?= csrf_field() ?>
        
        <div class="activites-grid">
            <?php foreach ($activites as $activite): ?>
                <div class="activite-card">
                    <div class="activite-header">
                        <div class="activite-icon">
                            <?php 
                            $icons = ['🏃', '💪', '🧘', '🚴', '🏊', '⚽', '🏋️', '🚶', '🧗', '🤸'];
                            $icon = $icons[array_rand($icons)];
                            echo $icon;
                            ?>
                        </div>
                        <div class="activite-info">
                            <h3><?= esc($activite['nom']) ?></h3>
                            <p><?= esc($activite['description']) ?></p>
                        </div>
                    </div>
                    
                    <div class="activite-body">
                        <div class="checkbox-wrapper">
                            <label class="checkbox-label">
                                <input type="checkbox" name="activites[]" value="<?= $activite['id'] ?>" class="activite-checkbox">
                                <span class="checkbox-custom"></span>
                                <span class="checkbox-text">
                                    <strong><?= esc($activite['nom']) ?></strong>
                                    <span class="calories">🔥 <?= number_format($activite['calories_brulees'], 0, ',', ' ') ?> cal.</span>
                                </span>
                            </label>
                        </div>
                        
                        <div class="variation-wrapper">
                            <label class="variation-label">
                                <span class="variation-icon">📊</span>
                                <span>Facteur de variation :</span>
                            </label>
                            <div class="variation-input-group">
                                <input type="number" 
                                       step="0.01" 
                                       name="variation_activite[<?= $activite['id'] ?>]" 
                                       placeholder="Ex: 1.5"
                                       class="variation-input"
                                       disabled>
                                <span class="variation-unit">x</span>
                            </div>
                            <small class="variation-hint">Multiplicateur d'intensité (1 = normal)</small>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn-submit">
                <span>➕</span> Ajouter les activités au régime
            </button>
        </div>
    </form>
</div>

<script>
    // Activer/désactiver le champ variation en fonction de la checkbox
    document.querySelectorAll('.activite-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const variationInput = this.closest('.activite-card').querySelector('.variation-input');
            variationInput.disabled = !this.checked;
            
            if (!this.checked) {
                variationInput.value = '';
            }
        });
    });
</script>

<style>
/* Styles pour la page Créer un régime */
.regime-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 40px 20px;
}

.regime-header {
    text-align: center;
    margin-bottom: 40px;
}

.regime-header h2 {
    font-size: 32px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 12px;
    position: relative;
    display: inline-block;
}

.regime-header h2:after {
    content: '';
    display: block;
    width: 60px;
    height: 4px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    margin: 15px auto 0;
    border-radius: 2px;
}

.regime-header p {
    font-size: 16px;
    color: #6b7280;
    margin-top: 20px;
}

.regime-header p strong {
    color: #667eea;
    font-weight: 700;
}

/* Grille des activités */
.activites-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
    gap: 24px;
    margin-bottom: 40px;
}

/* Carte activité */
.activite-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.02);
    transition: all 0.3s ease;
    border: 1px solid #e5e7eb;
}

.activite-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.02);
    border-color: #d1d5db;
}

/* En-tête activité */
.activite-header {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 20px;
    background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
    border-bottom: 1px solid #e5e7eb;
}

.activite-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.activite-info {
    flex: 1;
}

.activite-info h3 {
    font-size: 18px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 4px;
}

.activite-info p {
    font-size: 13px;
    color: #6b7280;
    line-height: 1.4;
}

/* Corps activité */
.activite-body {
    padding: 20px;
}

/* Checkbox personnalisée */
.checkbox-wrapper {
    margin-bottom: 20px;
}

.checkbox-label {
    display: flex;
    align-items: center;
    cursor: pointer;
    position: relative;
    padding-left: 35px;
    user-select: none;
}

.checkbox-label input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
}

.checkbox-custom {
    position: absolute;
    left: 0;
    height: 22px;
    width: 22px;
    background-color: #fff;
    border: 2px solid #d1d5db;
    border-radius: 6px;
    transition: all 0.2s;
}

.checkbox-label:hover input ~ .checkbox-custom {
    border-color: #667eea;
}

.checkbox-label input:checked ~ .checkbox-custom {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: #667eea;
}

.checkbox-custom:after {
    content: "";
    position: absolute;
    display: none;
}

.checkbox-label input:checked ~ .checkbox-custom:after {
    display: block;
}

.checkbox-label .checkbox-custom:after {
    left: 7px;
    top: 3px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

.checkbox-text {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex: 1;
    font-size: 14px;
}

.checkbox-text strong {
    color: #111827;
}

.calories {
    color: #ef4444;
    font-weight: 600;
    font-size: 13px;
    background: #fef2f2;
    padding: 4px 8px;
    border-radius: 8px;
}

/* Variation input */
.variation-wrapper {
    padding-top: 15px;
    border-top: 1px solid #f3f4f6;
}

.variation-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 10px;
}

.variation-icon {
    font-size: 16px;
}

.variation-input-group {
    position: relative;
    display: flex;
    align-items: center;
    margin-bottom: 8px;
}

.variation-input {
    width: 100%;
    padding: 10px 40px 10px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 14px;
    transition: all 0.3s;
    background: #f9fafb;
}

.variation-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    background: white;
}

.variation-input:enabled {
    background: white;
    border-color: #667eea;
}

.variation-input:disabled {
    background: #f3f4f6;
    cursor: not-allowed;
    opacity: 0.6;
}

.variation-unit {
    position: absolute;
    right: 14px;
    font-weight: 700;
    color: #9ca3af;
    font-size: 14px;
}

.variation-hint {
    font-size: 11px;
    color: #9ca3af;
    display: block;
}

/* Bouton submit */
.form-actions {
    text-align: center;
    margin-top: 20px;
}

.btn-submit {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 16px 40px;
    font-size: 16px;
    font-weight: 700;
    border-radius: 50px;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(102, 126, 234, 0.4);
}

.btn-submit:active {
    transform: translateY(0);
}

.btn-submit span {
    font-size: 18px;
}

/* Responsive */
@media (max-width: 768px) {
    .regime-container {
        padding: 20px 15px;
    }
    
    .regime-header h2 {
        font-size: 24px;
    }
    
    .activites-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    
    .activite-header {
        padding: 16px;
    }
    
    .activite-icon {
        width: 40px;
        height: 40px;
        font-size: 22px;
    }
    
    .activite-body {
        padding: 16px;
    }
    
    .checkbox-text {
        flex-direction: column;
        align-items: flex-start;
        gap: 6px;
    }
    
    .btn-submit {
        padding: 14px 30px;
        font-size: 14px;
        width: 100%;
        justify-content: center;
    }
}

/* Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.activite-card {
    animation: fadeInUp 0.4s ease backwards;
}

.activite-card:nth-child(1) { animation-delay: 0.05s; }
.activite-card:nth-child(2) { animation-delay: 0.1s; }
.activite-card:nth-child(3) { animation-delay: 0.15s; }
.activite-card:nth-child(4) { animation-delay: 0.2s; }
.activite-card:nth-child(5) { animation-delay: 0.25s; }
.activite-card:nth-child(6) { animation-delay: 0.3s; }

/* Scrollbar personnalisée */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: #764ba2;
}
</style>

<?php $this->endSection() ?>