USE regimes;

-- =========================
-- GENRES
-- =========================
INSERT INTO genres (nom) VALUES
('Homme'),
('Femme');

-- =========================
-- USERS
-- password = 1234
-- =========================
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
    '$2y$10$wH6XgQ9v2P8Q8mR2R4fK8u9rM3m3mM8f6p6g8n8QwPz2eJQwJ0D7S',
    1,
    FALSE,
    50000
),
(
    'Rabe',
    'rabe@gmail.com',
    '$2y$10$wH6XgQ9v2P8Q8mR2R4fK8u9rM3m3mM8f6p6g8n8QwPz2eJQwJ0D7S',
    1,
    TRUE,
    120000
),
(
    'Sarah',
    'sarah@gmail.com',
    '$2y$10$wH6XgQ9v2P8Q8mR2R4fK8u9rM3m3mM8f6p6g8n8QwPz2eJQwJ0D7S',
    2,
    FALSE,
    30000
);

-- =========================
-- USER HEALTH
-- =========================
INSERT INTO user_health (
    user_id,
    taille,
    poids,
    imc
) VALUES
(1, 1.70, 85, 29.41),
(2, 1.80, 70, 21.60),
(3, 1.65, 95, 34.89);

-- =========================
-- OBJECTIFS
-- =========================
INSERT INTO objectifs (
    nom,
    description
) VALUES
(
    'Perte de poids',
    'Réduire le poids corporel'
),
(
    'Prise de poids',
    'Augmenter le poids corporel'
),
(
    'IMC idéal',
    'Atteindre un IMC normal'
);

-- =========================
-- USER OBJECTIFS
-- =========================
INSERT INTO user_objectifs (
    user_id,
    objectif_id
) VALUES
(1, 1),
(2, 2),
(3, 3);

-- =========================
-- REGIMES
-- =========================
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
);

-- =========================
-- REGIME GENRE
-- =========================
INSERT INTO regime_genre (
    genre_id,
    regime_id
) VALUES
(1,1),
(2,1),
(1,2),
(2,2),
(1,3),
(1,4);

-- =========================
-- ACTIVITES
-- =========================
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

-- =========================
-- REGIME ACTIVITE
-- =========================
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

-- =========================
-- CODES
-- =========================
INSERT INTO codes (
    code,
    montant,
    utilise
) VALUES

('CODE100',100000,FALSE),
('CODE50',50000,TRUE),
('WELCOME',25000,FALSE);

-- =========================
-- TRANSACTIONS
-- =========================
INSERT INTO transactions (
    user_id,
    code_id,
    montant
) VALUES

(1,1,100000),
(2,2,50000),
(3,3,25000);

-- =========================
-- ACHAT REGIME
-- =========================
INSERT INTO achat_regime (
    user_id,
    regime_id,
    prix_paye
) VALUES

(1,1,120000),
(2,3,150000),
(3,2,80000);