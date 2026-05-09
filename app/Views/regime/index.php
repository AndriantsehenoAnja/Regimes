<?php $this->extend('layout/main') ?>
<?php $this->section('title'); ?>Liste des Régimes<?php $this->endSection(); ?>
<?php $this->section('content') ?>

<div class="regimes-container">
    <div class="regimes-header">
        <div class="header-left">
            <h1>📋 Liste des régimes</h1>
            <p>Gérez tous vos programmes nutritionnels</p>
        </div>
        <a href="<?= base_url('/regimes/create') ?>" class="btn-add">
            <span>➕</span> Ajouter un régime
        </a>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert-success">
            <span class="alert-icon">✅</span>
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert-error">
            <span class="alert-icon">⚠️</span>
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (empty($regimes)): ?>
        <div class="empty-state">
            <div class="empty-icon">📭</div>
            <h3>Aucun régime trouvé</h3>
            <p>Commencez par créer votre premier régime</p>
            <a href="<?= base_url('/regimes/create') ?>" class="btn-add-empty">
                Créer un régime
            </a>
        </div>
    <?php else: ?>
        <div class="regimes-grid">
            <?php foreach ($regimes as $regime): ?>
                <div class="regime-card">
                    <!-- Badge type -->
                    <div class="regime-badge <?= $regime['type_regime'] === 'perte' ? 'badge-perte' : 'badge-prise' ?>">
                        <?= $regime['type_regime'] === 'perte' ? '📉 Perte' : '📈 Prise' ?>
                    </div>
                    
                    <!-- En-tête -->
                    <div class="card-header">
                        <h2><?= esc($regime['nom']) ?></h2>
                        <div class="price"><?= number_format($regime['prix'], 0, ',', ' ') ?> €</div>
                    </div>
                    
                    <!-- Description -->
                    <p class="description"><?= esc($regime['description']) ?></p>
                    
                    <!-- Informations -->
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-icon">⏱️</span>
                            <div>
                                <div class="info-label">Durée</div>
                                <div class="info-value"><?= esc($regime['duree']) ?> jours</div>
                            </div>
                        </div>
                        <div class="info-item">
                            <span class="info-icon">⚖️</span>
                            <div>
                                <div class="info-label">Variation</div>
                                <div class="info-value <?= $regime['variation'] < 0 ? 'negative' : 'positive' ?>">
                                    <?= $regime['variation'] > 0 ? '+' : '' ?><?= esc($regime['variation']) ?> kg
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Composition -->
                    <div class="composition">
                        <div class="composition-title">🥗 Composition</div>
                        <div class="composition-bars">
                            <div class="composition-item">
                                <span class="composition-label">Viande</span>
                                <div class="bar-container">
                                    <div class="bar-fill" style="width: <?= esc($regime['pourcentage_viande']) ?>%; background: #ef4444;"></div>
                                </div>
                                <span class="composition-percent"><?= esc($regime['pourcentage_viande']) ?>%</span>
                            </div>
                            <div class="composition-item">
                                <span class="composition-label">Poisson</span>
                                <div class="bar-container">
                                    <div class="bar-fill" style="width: <?= esc($regime['pourcentage_poisson']) ?>%; background: #3b82f6;"></div>
                                </div>
                                <span class="composition-percent"><?= esc($regime['pourcentage_poisson']) ?>%</span>
                            </div>
                            <div class="composition-item">
                                <span class="composition-label">Volaille</span>
                                <div class="bar-container">
                                    <div class="bar-fill" style="width: <?= esc($regime['pourcentage_volaille']) ?>%; background: #10b981;"></div>
                                </div>
                                <span class="composition-percent"><?= esc($regime['pourcentage_volaille']) ?>%</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Activités -->
                    <?php if (!empty($regime['activites'])): ?>
                        <div class="activites-section">
                            <div class="activites-title">🏃 Activités associées</div>
                            <div class="activites-list">
                                <?php foreach ($regime['activites'] as $activite): ?>
                                    <span class="activite-tag">
                                        <?= esc($activite['nom']) ?>
                                        <?php if (isset($activite['pivot']['variation'])): ?>
                                            <span class="activite-variation">×<?= esc($activite['pivot']['variation']) ?></span>
                                        <?php endif; ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Actions -->
                    <div class="card-actions">
                        <a href="/regimes/edit/<?= esc($regime['id']) ?>" class="btn-edit">
                            ✏️ Modifier
                        </a>
                        <a href="/regimes/ajouterActivite/<?= esc($regime['id']) ?>" class="btn-activities">
                            🏃 Activités
                        </a>
                        <a href="/regimes/delete/<?= esc($regime['id']) ?>" 
                           class="btn-delete"
                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce régime ?')">
                            🗑️ Supprimer
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
/* Styles pour la liste des régimes */
.regimes-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 40px 20px;
}

/* Header */
.regimes-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 40px;
    flex-wrap: wrap;
    gap: 20px;
}

.header-left h1 {
    font-size: 32px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 8px;
}

.header-left p {
    font-size: 16px;
    color: #6b7280;
}

.btn-add {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 12px 24px;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s;
}

.btn-add:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
}

/* Alertes */
.alert-success, .alert-error {
    padding: 16px 20px;
    border-radius: 12px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 12px;
    animation: slideIn 0.3s ease;
}

.alert-success {
    background: #d1fae5;
    color: #065f46;
    border-left: 4px solid #10b981;
}

.alert-error {
    background: #fee2e2;
    color: #991b1b;
    border-left: 4px solid #ef4444;
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

/* Empty state */
.empty-state {
    text-align: center;
    padding: 80px 20px;
    background: white;
    border-radius: 24px;
    border: 2px dashed #e5e7eb;
}

.empty-icon {
    font-size: 64px;
    margin-bottom: 20px;
}

.empty-state h3 {
    font-size: 20px;
    color: #374151;
    margin-bottom: 8px;
}

.empty-state p {
    color: #6b7280;
    margin-bottom: 24px;
}

.btn-add-empty {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 12px 24px;
    border-radius: 12px;
    text-decoration: none;
    display: inline-block;
}

/* Grille des cartes */
.regimes-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
    gap: 28px;
}

/* Carte régime */
.regime-card {
    background: white;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    border: 1px solid #e5e7eb;
    transition: all 0.3s;
    position: relative;
}

.regime-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
}

/* Badge */
.regime-badge {
    position: absolute;
    top: 20px;
    right: 20px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    z-index: 1;
}

.badge-perte {
    background: #fee2e2;
    color: #dc2626;
}

.badge-prise {
    background: #d1fae5;
    color: #059669;
}

/* Card header */
.card-header {
    padding: 24px 24px 16px;
    background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%);
    border-bottom: 1px solid #f3f4f6;
}

.card-header h2 {
    font-size: 22px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 8px;
    padding-right: 80px;
}

.price {
    font-size: 24px;
    font-weight: 800;
    color: #667eea;
}

/* Description */
.description {
    padding: 16px 24px;
    color: #6b7280;
    font-size: 14px;
    line-height: 1.5;
    border-bottom: 1px solid #f3f4f6;
}

/* Info grid */
.info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    padding: 16px 24px;
    border-bottom: 1px solid #f3f4f6;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 12px;
}

.info-icon {
    font-size: 24px;
}

.info-label {
    font-size: 11px;
    color: #9ca3af;
    text-transform: uppercase;
    font-weight: 600;
}

.info-value {
    font-size: 16px;
    font-weight: 700;
    color: #111827;
}

.info-value.positive {
    color: #10b981;
}

.info-value.negative {
    color: #ef4444;
}

/* Composition */
.composition {
    padding: 16px 24px;
    border-bottom: 1px solid #f3f4f6;
}

.composition-title {
    font-size: 13px;
    font-weight: 600;
    color: #6b7280;
    margin-bottom: 12px;
}

.composition-bars {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.composition-item {
    display: flex;
    align-items: center;
    gap: 10px;
}

.composition-label {
    width: 60px;
    font-size: 12px;
    color: #374151;
    font-weight: 500;
}

.bar-container {
    flex: 1;
    height: 8px;
    background: #f3f4f6;
    border-radius: 4px;
    overflow: hidden;
}

.bar-fill {
    height: 100%;
    border-radius: 4px;
    transition: width 0.5s ease;
}

.composition-percent {
    width: 40px;
    font-size: 12px;
    color: #6b7280;
    text-align: right;
}

/* Activités */
.activites-section {
    padding: 16px 24px;
    border-bottom: 1px solid #f3f4f6;
}

.activites-title {
    font-size: 13px;
    font-weight: 600;
    color: #6b7280;
    margin-bottom: 12px;
}

.activites-list {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.activite-tag {
    background: #f3f4f6;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 11px;
    color: #374151;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.activite-variation {
    background: #e5e7eb;
    padding: 2px 6px;
    border-radius: 8px;
    font-size: 10px;
    font-weight: 600;
    color: #667eea;
}

/* Actions */
.card-actions {
    display: flex;
    gap: 8px;
    padding: 16px 24px;
    background: #f9fafb;
}

.card-actions a {
    flex: 1;
    padding: 10px 12px;
    border-radius: 10px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    text-align: center;
    transition: all 0.2s;
}

.btn-edit {
    background: #f3f4f6;
    color: #374151;
}

.btn-edit:hover {
    background: #e5e7eb;
}

.btn-activities {
    background: #e0e7ff;
    color: #4338ca;
}

.btn-activities:hover {
    background: #c7d2fe;
}

.btn-delete {
    background: #fee2e2;
    color: #dc2626;
}

.btn-delete:hover {
    background: #fecaca;
}

/* Responsive */
@media (max-width: 768px) {
    .regimes-container {
        padding: 20px 15px;
    }
    
    .regimes-header {
        flex-direction: column;
        text-align: center;
    }
    
    .header-left h1 {
        font-size: 24px;
    }
    
    .regimes-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .card-header h2 {
        font-size: 18px;
        padding-right: 70px;
    }
    
    .price {
        font-size: 20px;
    }
    
    .card-actions {
        flex-wrap: wrap;
    }
    
    .card-actions a {
        flex: auto;
        min-width: calc(33.33% - 8px);
    }
}

/* Animation des cartes */
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

.regime-card {
    animation: fadeInUp 0.4s ease backwards;
}

.regime-card:nth-child(1) { animation-delay: 0.05s; }
.regime-card:nth-child(2) { animation-delay: 0.1s; }
.regime-card:nth-child(3) { animation-delay: 0.15s; }
.regime-card:nth-child(4) { animation-delay: 0.2s; }
</style>

<?php $this->endSection() ?>