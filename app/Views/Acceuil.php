<?php $this->extend('layout/main') ?>
<?php $this->section('title'); ?>Accueil - Comme J'aime<?php $this->endSection(); ?>
<?php $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('style/acceuil.css') ?>">

<div class="main">
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-title">
            Bienvenue sur Comme J'aime
        </div>
        <div class="hero-subtitle">
            Votre compagnon bien-être pour une vie plus saine et épanouie
        </div>
        <div class="hero-buttons">
            <a href="<?= base_url('/programme1') ?>" class="btn-hero">Commencer maintenant</a>
            <?php if(!session()->has('user')){ ?>
                <a href="<?= base_url('/inscription1') ?>" class="btn-hero btn-hero-outline">S'inscrire gratuitement</a>
            <?php } ?>
        </div>
    </div>

    <!-- Features Section -->
    <div class="features-section">
        <div class="feature-card">
            <div class="feature-icon">🥗</div>
            <h3>Programmes personnalisés</h3>
            <p>Des régimes adaptés à vos objectifs et à votre mode de vie pour des résultats optimaux</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">💪</div>
            <h3>Suivi d'activité</h3>
            <p>Trackez vos progrès et restez motivé avec notre système de suivi intelligent</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">⭐</div>
            <h3>Programme Gold</h3>
            <p>Débloquez des fonctionnalités exclusives et un accompagnement personnalisé</p>
        </div>

        <div class="feature-card">
            <div class="feature-icon">📊</div>
            <h3>Statistiques détaillées</h3>
            <p>Visualisez votre progression avec des graphiques et des rapports complets</p>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="stats-section">
        <div class="stat-item">
            <h2>1000+</h2>
            <p>Utilisateurs actifs</p>
        </div>
        <div class="stat-item">
            <h2>50+</h2>
            <p>Programmes disponibles</p>
        </div>
        <div class="stat-item">
            <h2>95%</h2>
            <p>Taux de satisfaction</p>
        </div>
        <div class="stat-item">
            <h2>24/7</h2>
            <p>Support client</p>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="cta-section">
        <h2>Prêt à transformer votre vie ?</h2>
        <p>Rejoignez des milliers d'utilisateurs qui ont déjà fait le pas vers une meilleure santé</p>
        <?php if(session()->has('user')){ ?>
            <a href="<?= base_url('/programme1') ?>" class="btn-hero" style="background: white; color: #f5576c;">Découvrir nos programmes</a>
        <?php } else { ?>
            <a href="<?= base_url('/inscription1') ?>" class="btn-hero" style="background: white; color: #f5576c;">Créer mon compte gratuit</a>
        <?php } ?>
    </div>
</div>

<?php $this->endSection() ?>
