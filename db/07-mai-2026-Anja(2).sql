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