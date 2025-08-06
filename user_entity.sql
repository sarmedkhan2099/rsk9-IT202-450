CREATE TABLE user_entity (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    entity_id INT NOT NULL,
    created DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (user_id, entity_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (entity_id) REFERENCES films(id) ON DELETE CASCADE
);
