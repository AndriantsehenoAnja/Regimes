CREATE DATABASE regimes;
USE regimes;

-- genre
CREATE TABLE genres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50)
);
-- user table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    genre_id INT,
    is_gold BOOLEAN DEFAULT FALSE,
    solde DECIMAL(10,2) DEFAULT 0, -- tsy azo
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (genre_id) REFERENCES genres(id)
);

-- user sante
CREATE TABLE user_health (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    taille DECIMAL(5,2), -- en mètre
    poids DECIMAL(5,2),  -- en kg
    imc DECIMAL(5,2),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- objectifs possibles
CREATE TABLE objectifs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    description TEXT
);

-- user objectifs
CREATE TABLE user_objectifs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    objectif_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (objectif_id) REFERENCES objectifs(id)
);

-- regimes
CREATE TABLE regimes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    description TEXT,
    prix DECIMAL(10,2),
    duree INT, -- en jours
    variation DECIMAL(5,2),
    type_regime ENUM('perte','prise'),
    pourcentage_viande INT,
    pourcentage_poisson INT,
    pourcentage_volaille INT
);

-- regime genre
CREATE TABLE regime_genre(
    id INT AUTO_INCREMENT PRIMARY KEY,
    genre_id INT,
    regime_id INT,
    FOREIGN KEY (genre_id) REFERENCES genres(id),
    FOREIGN KEY (regime_id) REFERENCES regimes(id)
);


-- activites sportives
CREATE TABLE activites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    description TEXT,
    calories_brulees INT
);

-- regimes - activites
CREATE TABLE regime_activite (
    id INT AUTO_INCREMENT PRIMARY KEY,
    regime_id INT,
    activite_id INT,
    type_activite ENUM('perte','prise'),
    variation DECIMAL(5,2),
    FOREIGN KEY (regime_id) REFERENCES regimes(id),
    FOREIGN KEY (activite_id) REFERENCES activites(id)
);

-- code
CREATE TABLE codes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) UNIQUE,
    montant DECIMAL(10,2),
    utilise BOOLEAN DEFAULT FALSE
);

-- transactions
CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    code_id INT,
    montant DECIMAL(10,2),
    date_transaction TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (code_id) REFERENCES codes(id)
);

-- achat regime
CREATE TABLE achat_regime (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    regime_id INT,
    prix_paye DECIMAL(10,2),
    date_achat TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (regime_id) REFERENCES regimes(id)
);
