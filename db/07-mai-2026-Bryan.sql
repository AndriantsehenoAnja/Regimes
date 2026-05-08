CREATE DATABASE regimes;
USE regimes;

-- =====================================================
-- GENRES
-- =====================================================

CREATE TABLE genres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL
);

-- =====================================================
-- USERS
-- =====================================================

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,

    nom VARCHAR(100) NOT NULL,

    email VARCHAR(100) NOT NULL UNIQUE,

    password VARCHAR(255) NOT NULL,

    genre_id INT NOT NULL,

    is_gold BOOLEAN DEFAULT FALSE,

    solde DECIMAL(10,2) DEFAULT 0,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (genre_id)
        REFERENCES genres(id)
);

-- =====================================================
-- USER HEALTH
-- =====================================================

CREATE TABLE user_health (
    id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT NOT NULL UNIQUE,

    taille DECIMAL(5,2) NOT NULL,

    poids DECIMAL(5,2) NOT NULL,

    imc DECIMAL(5,2),

    FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);

-- =====================================================
-- OBJECTIFS
-- =====================================================

CREATE TABLE objectifs (
    id INT AUTO_INCREMENT PRIMARY KEY,

    nom VARCHAR(100) NOT NULL,

    description TEXT
);

-- =====================================================
-- USER OBJECTIFS
-- Un utilisateur peut choisir plusieurs objectifs
-- =====================================================

CREATE TABLE user_objectifs (
    id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT NOT NULL,

    objectif_id INT NOT NULL,

    FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE,

    FOREIGN KEY (objectif_id)
        REFERENCES objectifs(id)
        ON DELETE CASCADE
);

-- =====================================================
-- REGIMES
-- =====================================================

CREATE TABLE regimes (
    id INT AUTO_INCREMENT PRIMARY KEY,

    nom VARCHAR(100) NOT NULL,

    description TEXT,

    type_regime ENUM('perte','prise','equilibre') NOT NULL,

    variation_poids_min DECIMAL(5,2) NOT NULL,

    variation_poids_max DECIMAL(5,2) NOT NULL,

    pourcentage_viande INT DEFAULT 0,

    pourcentage_poisson INT DEFAULT 0,

    pourcentage_volaille INT DEFAULT 0,

    CHECK (
        pourcentage_viande +
        pourcentage_poisson +
        pourcentage_volaille <= 100
    )
);

-- =====================================================
-- PRIX DES REGIMES SELON LA DUREE
-- Exigence du PDF
-- =====================================================

CREATE TABLE regime_prix (
    id INT AUTO_INCREMENT PRIMARY KEY,

    regime_id INT NOT NULL,

    duree_jours INT NOT NULL,

    prix DECIMAL(10,2) NOT NULL,

    FOREIGN KEY (regime_id)
        REFERENCES regimes(id)
        ON DELETE CASCADE
);

-- =====================================================
-- REGIME / GENRE
-- =====================================================

CREATE TABLE regime_genre (
    id INT AUTO_INCREMENT PRIMARY KEY,

    genre_id INT NOT NULL,

    regime_id INT NOT NULL,

    FOREIGN KEY (genre_id)
        REFERENCES genres(id)
        ON DELETE CASCADE,

    FOREIGN KEY (regime_id)
        REFERENCES regimes(id)
        ON DELETE CASCADE
);

-- =====================================================
-- ACTIVITES SPORTIVES
-- =====================================================

CREATE TABLE activites (
    id INT AUTO_INCREMENT PRIMARY KEY,

    nom VARCHAR(100) NOT NULL,

    description TEXT,

    calories_brulees INT DEFAULT 0
);

-- =====================================================
-- REGIME / ACTIVITE
-- =====================================================

CREATE TABLE regime_activite (
    id INT AUTO_INCREMENT PRIMARY KEY,

    regime_id INT NOT NULL,

    activite_id INT NOT NULL,

    FOREIGN KEY (regime_id)
        REFERENCES regimes(id)
        ON DELETE CASCADE,

    FOREIGN KEY (activite_id)
        REFERENCES activites(id)
        ON DELETE CASCADE
);

-- =====================================================
-- CODES PORTE MONNAIE
-- =====================================================

CREATE TABLE codes (
    id INT AUTO_INCREMENT PRIMARY KEY,

    code VARCHAR(50) NOT NULL UNIQUE,

    montant DECIMAL(10,2) NOT NULL,

    utilise BOOLEAN DEFAULT FALSE
);

-- =====================================================
-- TRANSACTIONS
-- =====================================================

CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT NOT NULL,

    code_id INT NOT NULL,

    montant DECIMAL(10,2) NOT NULL,

    date_transaction TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)
        REFERENCES users(id),

    FOREIGN KEY (code_id)
        REFERENCES codes(id)
);

-- =====================================================
-- ACHAT REGIME
-- =====================================================

CREATE TABLE achat_regime (
    id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT NOT NULL,

    regime_id INT NOT NULL,

    regime_prix_id INT NOT NULL,

    prix_paye DECIMAL(10,2) NOT NULL,

    reduction_gold DECIMAL(10,2) DEFAULT 0,

    date_achat TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)
        REFERENCES users(id),

    FOREIGN KEY (regime_id)
        REFERENCES regimes(id),

    FOREIGN KEY (regime_prix_id)
        REFERENCES regime_prix(id)
);

-- =====================================================
-- OPTION GOLD
-- =====================================================

CREATE TABLE gold_abonnement (
    id INT AUTO_INCREMENT PRIMARY KEY,

    prix DECIMAL(10,2) NOT NULL,

    description TEXT
);