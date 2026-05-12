<?php $this->extend('layout/main') ?>
<?php $this->section('title'); ?>Créer un régime<?php $this->endSection(); ?>
<?php $this->section('content') ?>

<div class="create-regime-container">
    <div class="create-regime-header">
        <h2>✨ Créer un nouveau régime</h2>
        <p>Personnalisez votre programme nutritionnel</p>
    </div>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert-error">
            <span class="alert-icon">⚠️</span>
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="/regimes/store" method="post" class="regime-creation-form">
        <?= csrf_field() ?>
        
        <!-- FIRST FIELDSET : Informations principales du régime -->
        <div class="form-section">
            <div class="section-header">
                <span class="section-icon">📋</span>
                <h3>Informations du régime</h3>
            </div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="nom">Nom du régime <span class="required">*</span></label>
                    <input type="text" id="nom" name="nom" class="form-control" placeholder="Ex: Régime Méditerranéen" required>
                </div>

                <div class="form-group">
                    <label for="prix">Prix <span class="required">*</span></label>
                    <div class="input-with-icon">
                        <input type="number" step="0.01" id="prix" name="prix" class="form-control" placeholder="0.00" required>
                        <span class="input-icon">€</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="duree">Durée <span class="required">*</span></label>
                    <div class="input-with-icon">
                        <input type="number" id="duree" name="duree" class="form-control" placeholder="30" required>
                        <span class="input-icon">jours</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="variation">Variation cible <span class="required">*</span></label>
                    <div class="input-with-icon">
                        <input type="number" step="0.01" id="variation" name="variation" class="form-control" placeholder="-5.00 ou +2.00" required>
                        <span class="input-icon">kg</span>
                    </div>
                    <small class="form-hint">Ex: -5.00 pour perte ou +2.00 pour prise</small>
                </div>

                <div class="form-group">
                    <label for="type_regime">Type de régime <span class="required">*</span></label>
                    <select id="type_regime" name="type_regime" class="form-control" required>
                        <option value="">Sélectionnez un type</option>
                        <option value="perte">📉 Perte de poids</option>
                        <option value="prise">📈 Prise de masse</option>
                    </select>
                </div>

                <div class="form-group full-width">
                    <label for="description">Description <span class="required">*</span></label>
                    <textarea id="description" name="description" class="form-control" rows="4" placeholder="Décrivez les objectifs et les bénéfices de ce régime..." required></textarea>
                </div>
            </div>
        </div>

        <!-- SECOND FIELDSET : Composition du Régime -->
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
                            <input type="number" id="pourcentage_viande" name="pourcentage_viande" class="form-control" max="100" required>
                            <span class="percentage-sign">%</span>
                        </div>
                    </div>
                </div>

                <div class="composition-card">
                    <div class="composition-icon">🐟</div>
                    <div class="composition-content">
                        <label for="pourcentage_poisson">Poisson</label>
                        <div class="percentage-input">
                            <input type="number" id="pourcentage_poisson" name="pourcentage_poisson" class="form-control" max="100" required>
                            <span class="percentage-sign">%</span>
                        </div>
                    </div>
                </div>

                <div class="composition-card">
                    <div class="composition-icon">🐔</div>
                    <div class="composition-content">
                        <label for="pourcentage_volaille">Volaille</label>
                        <div class="percentage-input">
                            <input type="number" id="pourcentage_volaille" name="pourcentage_volaille" class="form-control" max="100" required>
                            <span class="percentage-sign">%</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="total-percentage" id="totalPercentage">
                Total : <span>0</span>%
            </div>
        </div>

        <!-- THIRD FIELDSET : Choix des Activités -->
        <div class="form-section">
            <div class="section-header">
                <span class="section-icon">🏃</span>
                <h3>Activités associées</h3>
                <span class="section-badge">Optionnel</span>
            </div>
            
            <div class="activites-grid">
                <?php foreach($activites as $act): ?>
                    <div class="activite-item">
                        <div class="activite-checkbox-wrapper">
                            <label class="checkbox-label">
                                <input type="checkbox" name="activites[]" value="<?= $act['id'] ?>" class="activite-checkbox">
                                <span class="checkbox-custom"></span>
                                <div class="activite-info">
                                    <strong><?= esc($act['nom']) ?></strong>
                                    <span class="activite-calories">🔥 <?= number_format($act['calories_brulees'], 0, ',', ' ') ?> cal.</span>
                                </div>
                            </label>
                        </div>
                        <div class="activite-variation">
                            <label>Facteur intensité :</label>
                            <input type="number" step="0.01" name="variation_activite[<?= $act['id'] ?>]" 
                                   class="variation-input" placeholder="Ex: 1.5" disabled>
                            <small>x</small>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">
                <span>🚀</span> Créer le régime
            </button>
            <a href="<?= base_url('/regimes') ?>" class="btn-cancel">Annuler</a>
        </div>
    </form>
</div>

<script>
    // Activer/désactiver le champ variation en fonction de la checkbox
    document.querySelectorAll('.activite-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const variationInput = this.closest('.activite-item').querySelector('.variation-input');
            variationInput.disabled = !this.checked;
            if (!this.checked) {
                variationInput.value = '';
            }
        });
    });

    // Calcul du total des pourcentages
    const viandeInput = document.getElementById('pourcentage_viande');
    const poissonInput = document.getElementById('pourcentage_poisson');
    const volailleInput = document.getElementById('pourcentage_volaille');
    const totalSpan = document.querySelector('#totalPercentage span');

    function updateTotal() {
        let total = 0;
        total += parseFloat(viandeInput.value) || 0;
        total += parseFloat(poissonInput.value) || 0;
        total += parseFloat(volailleInput.value) || 0;
        totalSpan.textContent = total;
        
        if (total === 100) {
            document.querySelector('#totalPercentage').style.background = '#d1fae5';
            document.querySelector('#totalPercentage').style.color = '#065f46';
        } else if (total > 100) {
            document.querySelector('#totalPercentage').style.background = '#fee2e2';
            document.querySelector('#totalPercentage').style.color = '#991b1b';
        } else {
            document.querySelector('#totalPercentage').style.background = '#fef3c7';
            document.querySelector('#totalPercentage').style.color = '#92400e';
        }
    }

    viandeInput.addEventListener('input', updateTotal);
    poissonInput.addEventListener('input', updateTotal);
    volailleInput.addEventListener('input', updateTotal);
    updateTotal();
</script>

<style>
/* Styles pour la page Créer un régime */
.create-regime-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
}

.create-regime-header {
    text-align: center;
    margin-bottom: 40px;
}

.create-regime-header h2 {
    font-size: 32px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 12px;
}

.create-regime-header p {
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
}

.alert-icon {
    font-size: 20px;
}

/* Sections du formulaire */
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

/* Grille formulaire */
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

.total-percentage {
    background: #fef3c7;
    padding: 12px 20px;
    border-radius: 12px;
    text-align: center;
    font-weight: 700;
    font-size: 16px;
    transition: all 0.3s;
}

.total-percentage span {
    font-size: 20px;
    font-weight: 800;
}

/* Activités */
.activites-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 16px;
}

.activite-item {
    background: #f9fafb;
    border-radius: 12px;
    padding: 16px;
    transition: all 0.3s;
}

.activite-item:hover {
    background: #f3f4f6;
}

.checkbox-label {
    display: flex;
    align-items: flex-start;
    cursor: pointer;
    position: relative;
    padding-left: 32px;
}

.checkbox-label input {
    position: absolute;
    opacity: 0;
}

.checkbox-custom {
    position: absolute;
    left: 0;
    top: 2px;
    width: 20px;
    height: 20px;
    background: white;
    border: 2px solid #d1d5db;
    border-radius: 6px;
    transition: all 0.2s;
}

.checkbox-label input:checked ~ .checkbox-custom {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-color: #667eea;
}

.checkbox-custom:after {
    content: "";
    position: absolute;
    display: none;
    left: 6px;
    top: 2px;
    width: 4px;
    height: 9px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

.checkbox-label input:checked ~ .checkbox-custom:after {
    display: block;
}

.activite-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex: 1;
    width: 100%;
}

.activite-info strong {
    color: #111827;
    font-size: 14px;
}

.activite-calories {
    font-size: 12px;
    color: #ef4444;
    font-weight: 600;
}

.activite-variation {
    margin-top: 12px;
    margin-left: 32px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.activite-variation label {
    font-size: 12px;
    color: #6b7280;
}

.variation-input {
    width: 100px;
    padding: 6px 10px;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    font-size: 13px;
}

.variation-input:disabled {
    background: #f3f4f6;
    cursor: not-allowed;
}

.variation-input:enabled {
    border-color: #667eea;
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
    padding: 14px 28px;
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

.btn-cancel {
    background: #f3f4f6;
    color: #374151;
    border: none;
    padding: 14px 28px;
    font-size: 15px;
    font-weight: 600;
    border-radius: 12px;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s;
}

.btn-cancel:hover {
    background: #e5e7eb;
}

/* Responsive */
@media (max-width: 768px) {
    .create-regime-container {
        padding: 20px 15px;
    }
    
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .form-group.full-width {
        grid-column: span 1;
    }
    
    .composition-grid {
        grid-template-columns: 1fr;
        gap: 12px;
    }
    
    .activites-grid {
        grid-template-columns: 1fr;
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
</style>

<?php $this->endSection() ?>