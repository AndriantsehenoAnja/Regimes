CREATE TABLE IF NOT EXISTS demandes_code (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    code_id INT,
    status INT DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (code_id) REFERENCES codes(id)
);
