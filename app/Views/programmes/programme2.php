<?= $this->extend('layout/main') ?>

<?= $this->section('title') ?>
Régimes Suggérés
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
.container-regimes {
    max-width: 1000px;
    margin: 40px auto;
    padding: 20px;
}

.regimes-title {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 40px;
    font-size: 2.5rem;
    font-weight: 700;
}

.regimes-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 30px;
}

.regime-card {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
}

.regime-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}

.regime-header {
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    padding: 25px 20px;
    text-align: center;
}

.regime-header h3 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 600;
}

.regime-body {
    padding: 25px 20px;
    flex-grow: 1;
}

.regime-info {
    margin-bottom: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #eee;
    padding-bottom: 10px;
}

.regime-info:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.info-label {
    color: #7f8c8d;
    font-size: 0.9rem;
    font-weight: 500;
}

.info-value {
    color: #2c3e50;
    font-weight: 600;
    font-size: 1.05rem;
}

.regime-footer {
    padding: 20px;
    background: #f8f9fa;
    border-top: 1px solid #eee;
    text-align: center;
}

.price-tag {
    font-size: 1.8rem;
    color: #27ae60;
    font-weight: 700;
}

.currency {
    font-size: 1rem;
    color: #95a5a6;
}

.btn-choose {
    display: inline-block;
    width: 100%;
    padding: 12px 0;
    margin-top: 15px;
    background: #2ecc71;
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-weight: 600;
    transition: background 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn-choose:hover {
    background: #27ae60;
}

.empty-state {
    text-align: center;
    padding: 50px;
    background: #f9f9f9;
    border-radius: 10px;
    color: #7f8c8d;
    font-size: 1.2rem;
}
</style>

<div class="container-regimes">
    <h1 class="regimes-title">Vos Régimes Suggérés</h1>

    <?php if (!empty($regimes)): ?>
        <div class="regimes-grid">
            <?php foreach ($regimes as $regime): ?>
                <div class="regime-card">
                    <div class="regime-header">
                        <h3><?= esc($regime['regime']) ?></h3>
                    </div>
                    
                    <div class="regime-body">
                        <div class="regime-info">
                            <span class="info-label">Variante finale (kg/j)</span>
                            <span class="info-value"><?= esc($regime['variation_finale_unitaire']) ?> kg</span>
                        </div>
                        
                        <div class="regime-info">
                            <span class="info-label">Activités</span>
                            <span class="info-value"><?= esc($regime['activite']) ?></span>
                        </div>
                        
                        <div class="regime-info">
                            <span class="info-label">Multiplicateur (jours)</span>
                            <span class="info-value"><?= esc($regime['multiplicateur']) ?> x</span>
                        </div>
                        
                        <div class="regime-info">
                            <span class="info-label">Durée totale</span>
                            <span class="info-value"><?= esc($regime['duree_totale']) ?> jours</span>
                        </div>
                        
                        <div class="regime-info">
                            <span class="info-label">Poids estimé atteint</span>
                            <span class="info-value"><?= esc($regime['poids_estime_atteint']) ?> kg</span>
                        </div>
                    </div>
                    
                    <div class="regime-footer">
                        <div class="price-tag">
                            <?= number_format($regime['prix_total'], 2, ',', ' ') ?>
                            <span class="currency">Ar</span>
                        </div>
                        <!-- In the future you might link to an action like choosing the diet -->
                        <button class="btn-choose">Choisir ce programme</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="empty-state">
            <p>Aucun régime correspondant à votre objectif n'a été trouvé.</p>
            <a href="<?= base_url('programme1') ?>" style="color: #3498db; text-decoration: none; margin-top: 15px; display: inline-block;">Retour aux objectifs</a>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
