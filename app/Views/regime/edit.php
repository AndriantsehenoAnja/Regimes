<?php $this->extend('layout/main') ?>
<?php $this->section('title'); ?>Modifier un régime<?php $this->endSection(); ?>
<?php $this->section('content') ?>

<div class="edit-regime-container">
    <div class="edit-regime-header">
        <h2>✏️ Modifier le régime</h2>
        <p>Mettez à jour les informations de votre programme nutritionnel</p>
    </div>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert-error">
            <span class="alert-icon">⚠️</span>
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="/regimes/update/<?= esc($regime['id']) ?>" method="post" class="regime-edit-form">
        <?= csrf_field() ?>
        
        <!-- SECTION 1 : Informations principales -->
        <div class="form-section">
            <div class="section-header">
                <span class="section-icon">📋</span>
                <h3>Informations générales</h3>
            </div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="nom">Nom du régime <span class="required">*</span></label>
                    <input type="text" id="nom" name="nom" class="form-control" 
                           value="<?= esc($regime['nom']) ?>" required>
                </div>

                <div class="form-group">
                    <label for="prix">Prix <span class="required">*</span></label>
                    <div class="input-with-icon">
                        <input type="number" step="0.01" id="prix" name="prix" class="form-control" 
                               value="<?= esc($regime['prix']) ?>" required>
                        <span class="input-icon">€</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="duree">Durée <span class="required">*</span></label>
                    <div class="input-with-icon">
                        <input type="number" id="duree" name="duree" class="form-control" 
                               value="<?= esc($regime['duree']) ?>" required>
                        <span class="input-icon">jours</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="variation">Variation cible <span class="required">*</span></label>
                    <div class="input-with-icon">
                        <input type="number" step="0.01" id="variation" name="variation" class="form-control" 
                               value="<?= esc($regime['variation']) ?>" required>
                        <span class="input-icon">kg</span>
                    </div>
                    <small class="form-hint">Négatif pour perte de poids, positif pour prise de masse</small>
                </div>

                <div class="form-group">
                    <label for="type_regime">Type de régime <span class="required">*</span></label>
                    <select id="type_regime" name="type_regime" class="form-control" required>
                        <option value="perte" <?= $regime['type_regime'] === 'perte' ? 'selected' : '' ?>>
                            📉 Perte de poids
                        </option>
                        <option value="prise" <?= $regime['type_regime'] === 'prise' ? 'selected' : '' ?>>
                            📈 Prise de masse
                        </option>
                    </select>
                </div>

                <div class="form-group full-width">
                    <label for="description">Description <span class="required">*</span></label>
                    <textarea id="description" name="description" class="form-control" 
                              rows="4" required><?= esc($regime['description']) ?></textarea>
                </div>
            </div>
        </div>

        <!-- SECTION 2 : Composition nutritionnelle -->
        <div class="form-section">
            <div class="section-header">
                <span class="section-icon">🥗</span>
                <h3>Composition nutritionnelle</h3>
                <span class="section-badge">Pourcentages</span>
            </div>
            
            <div class="composition-grid">
                <div class="composition-card">
                    <div class="composition-icon">🥩</div>
                    <div class="composition-content">
                        <label for="pourcentage_viande">Viande</label>
                        <div class="percentage-input">
                            <input type="number" step="0.01" id="pourcentage_viande" name="pourcentage_viande" 
                                   class="form-control" value="<?= esc($regime['pourcentage_viande']) ?>" 
                                   max="100" required>
                            <span class="percentage-sign">%</span>
                        </div>
                    </div>
                </div>

                <div class="composition-card">
                    <div class="composition-icon">🐟</div>
                    <div class="composition-content">
                        <label for="pourcentage_poisson">Poisson</label>
                        <div class="percentage-input">
                            <input type="number" step="0.01" id="pourcentage_poisson" name="pourcentage_poisson" 
                                   class="form-control" value="<?= esc($regime['pourcentage_poisson']) ?>" 
                                   max="100" required>
                            <span class="percentage-sign">%</span>
                        </div>
                    </div>
                </div>

                <div class="composition-card">
                    <div class="composition-icon">🐔</div>
                    <div class="composition-content">
                        <label for="pourcentage_volaille">Volaille</label>
                        <div class="percentage-input">
                            <input type="number" step="0.01" id="pourcentage_volaille" name="pourcentage_volaille" 
                                   class="form-control" value="<?= esc($regime['pourcentage_volaille']) ?>" 
                                   max="100" required>
                            <span class="percentage-sign">%</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="total-percentage" id="totalPercentage">
                <span class="total-label">Total :</span>
                <span class="total-value">0</span>%
                <span class="total-status" id="totalStatus"></span>
            </div>
        </div>

        <!-- SECTION 3 : Actions -->
        <div class="form-actions">
            <a href="<?= base_url('/regimes') ?>" class="btn-cancel">
                ← Annuler
            </a>
            <button type="submit" class="btn-submit">
                <span>💾</span> Mettre à jour
            </button>
        </div>
    </form>
</div>

<script>
    // Calcul du total des pourcentages
    const viandeInput = document.getElementById('pourcentage_viande');
    const poissonInput = document.getElementById('pourcentage_poisson');
    const volailleInput = document.getElementById('pourcentage_volaille');
    const totalValueSpan = document.querySelector('.total-value');
    const totalStatusSpan = document.getElementById('totalStatus');

    function updateTotal() {
        let total = 0;
        total += parseFloat(viandeInput.value) || 0;
        total += parseFloat(poissonInput.value) || 0;
        total += parseFloat(volailleInput.value) || 0;
        totalValueSpan.textContent = total.toFixed(2);
        
        const totalDiv = document.getElementById('totalPercentage');
        
        if (Math.abs(total - 100) < 0.01) {
            totalDiv.classList.remove('warning', 'error');
            totalDiv.classList.add('success');
            totalStatusSpan.textContent = '✓ Parfait !';
        } else if (total > 100) {
            totalDiv.classList.remove('success', 'warning');
            totalDiv.classList.add('error');
            totalStatusSpan.textContent = '⚠️ Dépassement de 100%';
        } else {
            totalDiv.classList.remove('success', 'error');
            totalDiv.classList.add('warning');
            totalStatusSpan.textContent = '⚠️ Total inférieur à 100%';
        }
    }

    viandeInput.addEventListener('input', updateTotal);
    poissonInput.addEventListener('input', updateTotal);
    volailleInput.addEventListener('input', updateTotal);
    updateTotal();
</script>

<style>
/* Styles pour la page Modifier un régime */
.edit-regime-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 40px 20px;
}

.edit-regime-header {
    text-align: center;
    margin-bottom: 40px;
}

.edit-regime-header h2 {
    font-size: 32px;
    font-weight: 700;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 12px;
}

.edit-regime-header p {
    font-size: 16px;
    color: #6b7280;
}

/* Alertes */
.alert-error {
    background: #fee2e2;
    border-left: 4px solid #ef4444;
    padding: 16px 20px;
    border-radius: 12px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 12px;
    color: #991b1b;
    font-weight: 500;
    animation: slideIn 0.3s ease;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.alert-icon {
    font-size: 20px;
}

/* Sections */
.form-section {
    background: white;
    border-radius: 20px;
    padding: 28px;
    margin-bottom: 28px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    border: 1px solid #e5e7eb;
    transition: all 0.3s;
}

.form-section:hover {
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
}

.section-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 24px;
    padding-bottom: 12px;
    border-bottom: 2px solid #f3f4f6;
}

.section-icon {
    font-size: 28px;
}

.section-header h3 {
    font-size: 20px;
    font-weight: 700;
    color: #111827;
    margin: 0;
}

.section-badge {
    background: #f3f4f6;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    color: #6b7280;
    margin-left: auto;
}

/* Grille */
.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.form-group.full-width {
    grid-column: span 2;
}

.form-group label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
    font-size: 14px;
}

.required {
    color: #ef4444;
}

.form-control {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    font-size: 14px;
    transition: all 0.3s;
    font-family: inherit;
}

.form-control:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

textarea.form-control {
    resize: vertical;
    min-height: 100px;
}

.input-with-icon {
    position: relative;
}

.input-with-icon .form-control {
    padding-right: 50px;
}

.input-icon {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    font-size: 12px;
    font-weight: 500;
}

.form-hint {
    display: block;
    margin-top: 6px;
    font-size: 11px;
    color: #9ca3af;
}

/* Composition */
.composition-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 20px;
}

.composition-card {
    background: #f9fafb;
    border-radius: 16px;
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    transition: all 0.3s;
}

.composition-card:hover {
    background: #f3f4f6;
    transform: translateY(-2px);
}

.composition-icon {
    font-size: 40px;
}

.composition-content {
    flex: 1;
}

.composition-content label {
    display: block;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
    font-size: 14px;
}

.percentage-input {
    position: relative;
}

.percentage-input .form-control {
    padding-right: 35px;
}

.percentage-sign {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #6b7280;
    font-weight: 600;
}

/* Total pourcentage */
.total-percentage {
    padding: 14px 20px;
    border-radius: 12px;
    text-align: center;
    font-weight: 600;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.total-percentage.success {
    background: #d1fae5;
    color: #065f46;
}

.total-percentage.warning {
    background: #fef3c7;
    color: #92400e;
}

.total-percentage.error {
    background: #fee2e2;
    color: #991b1b;
}

.total-label {
    font-size: 14px;
}

.total-value {
    font-size: 20px;
    font-weight: 800;
}

.total-status {
    font-size: 12px;
    margin-left: 8px;
}

/* Boutons */
.form-actions {
    display: flex;
    gap: 16px;
    justify-content: flex-end;
    margin-top: 20px;
}

.btn-submit {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 14px 32px;
    font-size: 15px;
    font-weight: 600;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
}

.btn-submit:active {
    transform: translateY(0);
}

.btn-cancel {
    background: #f3f4f6;
    color: #374151;
    border: none;
    padding: 14px 32px;
    font-size: 15px;
    font-weight: 600;
    border-radius: 12px;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
}

.btn-cancel:hover {
    background: #e5e7eb;
    transform: translateY(-2px);
}

/* Responsive */
@media (max-width: 768px) {
    .edit-regime-container {
        padding: 20px 15px;
    }
    
    .edit-regime-header h2 {
        font-size: 24px;
    }
    
    .form-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    
    .form-group.full-width {
        grid-column: span 1;
    }
    
    .composition-grid {
        grid-template-columns: 1fr;
        gap: 12px;
    }
    
    .form-section {
        padding: 20px;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn-submit, .btn-cancel {
        width: 100%;
        justify-content: center;
    }
}

/* Animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.form-section {
    animation: fadeIn 0.4s ease backwards;
}

.form-section:nth-child(1) {
    animation-delay: 0.1s;
}

.form-section:nth-child(2) {
    animation-delay: 0.2s;
}

.composition-card {
    animation: fadeIn 0.3s ease backwards;
}

.composition-card:nth-child(1) { animation-delay: 0.1s; }
.composition-card:nth-child(2) { animation-delay: 0.2s; }
.composition-card:nth-child(3) { animation-delay: 0.3s; }
</style>

<?php $this->endSection() ?>