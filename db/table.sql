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
    pourcentage_volaille INT,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
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
    type_regime ENUM ('perte','prise'),
    prix_paye DECIMAL(10,2),
    date_achat TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (regime_id) REFERENCES regimes(id)
);

CREATE TABLE imc_details(
    id INT AUTO_INCREMENT PRIMARY KEY,
    intervalle_min DECIMAL(5,2),
    intervalle_max DECIMAL(5,2),
    categorie VARCHAR(50)
);

CREATE TABLE is_admin (
    id_admin SERIAL PRIMARY KEY,
    id_user INT,
    FOREIGN KEY (id_user) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS demandes_code (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    code_id INT,
    status INT DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (code_id) REFERENCES codes(id)
);

INSERT INTO objectifs (nom,description) VALUES
('Perte de poids','Réduire le poids corporel'),
('Prise de poids','Augmenter le poids corporel'),
('IMC idéal','Atteindre un IMC normal');

INSERT INTO genres (nom) VALUES
('Homme'),
('Femme');
/* Password User = 1234 */
INSERT INTO users (
    nom,
    email,
    password,
    genre_id,
    is_gold,
    solde
) VALUES
(
    'Rakoto',
    'rakoto@gmail.com',
    '$2y$10$UY.Wzq14uhKX.7hWaunbH.mx4YgYSYhOEKLPUIOn9pp450kiwH5Mq',
    1,
    FALSE,
    50000
),
(
    'Rabe',
    'rabe@gmail.com',
    '$2y$10$UY.Wzq14uhKX.7hWaunbH.mx4YgYSYhOEKLPUIOn9pp450kiwH5Mq',
    1,
    TRUE,
    120000
),
(
    'Sarah',
    'sarah@gmail.com',
    '$2y$10$UY.Wzq14uhKX.7hWaunbH.mx4YgYSYhOEKLPUIOn9pp450kiwH5Mq',
    2,
    FALSE,
    30000
),
(
    'Bonhomme',
    'bonhomme@gmail.com',
    '$2y$10$UY.Wzq14uhKX.7hWaunbH.mx4YgYSYhOEKLPUIOn9pp450kiwH5Mq',
    1,
    FALSE,
    30000
),
(
    'Sauce',
    'sauce@gmail.com',
    '$2y$10$UY.Wzq14uhKX.7hWaunbH.mx4YgYSYhOEKLPUIOn9pp450kiwH5Mq',
    2,
    FALSE,
    30000
)
;
INSERT INTO is_admin (id_user) VALUES
(5); -- Rabe est admin

INSERT INTO regimes (
    nom,
    description,
    prix,
    duree,
    variation,
    type_regime,
    pourcentage_viande,
    pourcentage_poisson,
    pourcentage_volaille
) VALUES

(
    'Keto Express',
    'Régime faible en glucides',
    120000,
    30,
    10,
    'perte',
    40,
    30,
    20
),

(
    'Low Carb',
    'Réduction progressive des glucides',
    80000,
    20,
    5,
    'perte',
    30,
    40,
    20
),

(
    'Fitness Mass',
    'Programme de prise de masse',
    150000,
    45,
    12,
    'prise',
    50,
    20,
    20
),

(
    'Power Bulk',
    'Prise de poids rapide',
    200000,
    60,
    18,
    'prise',
    60,
    20,
    10
),
(
    'Cutting',
    'Perte de poids rapide',
    200000,
    60,
    18,
    'perte',
    60,
    20,
    10
);

INSERT INTO activites (
    nom,
    description,
    calories_brulees
) VALUES

(
    'Course',
    'Course à pied quotidienne',
    500
),

(
    'Natation',
    'Natation intensive',
    700
),

(
    'Musculation',
    'Exercices de force',
    400
),

(
    'Cyclisme',
    'Vélo cardio',
    600
),

(
    'Yoga',
    'Relaxation et souplesse',
    200
);

INSERT INTO regime_activite (
    regime_id,
    activite_id,
    type_activite,
    variation
) VALUES

(1,1,'perte',2),
(1,2,'perte',3),
(1,4,'perte',2),

(2,1,'perte',1),
(2,5,'perte',1),

(3,3,'prise',4),

(4,3,'prise',5);

INSERT INTO codes (
    code,
    montant,
    utilise
) VALUES

('CODE001',100000,FALSE),
('CODE002',50000,TRUE),
('CODE003',25000,FALSE),
('CODE004',100000,FALSE),
('CODE005',50000,TRUE),
('CODE006',25000,FALSE),
('CODE007',100000,FALSE),
('CODE008',50000,TRUE),
('CODE009',25000,FALSE),
('CODE010',100000,FALSE),
('CODE011',50000,TRUE),
('CODE012',25000,FALSE),
('CODE013',100000,FALSE),
('CODE014',50000,TRUE),
('CODE015',25000,FALSE);



insert into imc_details (intervalle_min, intervalle_max, categorie) values
(0, 18.5, 'Maigreur'),
(18.5, 24.9, 'Normal'),
(25, 29.9, 'Surpoids'),
(30, 34.9, 'Obésité modérée'),
(35, 39.9, 'Obésité sévère'),
(40, 100, 'Obésité morbide');

INSERT INTO user_health (
    user_id,
    taille,
    poids,
    imc
) VALUES
(
    1,
    1.70,
    65.00,
    ROUND(65 / (1.70 * 1.70), 2)
),
(
    2,
    1.80,
    85.00,
    ROUND(85 / (1.80 * 1.80), 2)
),
(
    3,
    1.65,
    55.00,
    ROUND(55 / (1.65 * 1.65), 2)
),
(
    4,
    1.75,
    78.00,
    ROUND(78 / (1.75 * 1.75), 2)
),
(
    5,
    1.60,
    50.00,
    ROUND(50 / (1.60 * 1.60), 2)
);