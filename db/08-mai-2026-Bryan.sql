CREATE TABLE imc_details(
    id INT AUTO_INCREMENT PRIMARY KEY,
    intervalle_min DECIMAL(5,2),
    intervalle_max DECIMAL(5,2),
    categorie VARCHAR(50)
);

insert into imc_details (intervalle_min, intervalle_max, categorie) values
(0, 18.5, 'Maigreur'),
(18.5, 24.9, 'Normal'),
(25, 29.9, 'Surpoids'),
(30, 34.9, 'Obésité modérée'),
(35, 39.9, 'Obésité sévère'),
(40, 100, 'Obésité morbide');