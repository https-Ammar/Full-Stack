CREATE TABLE cards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    description TEXT,
    link VARCHAR(255),
    cover_image VARCHAR(255),
    second_image VARCHAR(255),
    created_at DATE
);

CREATE TABLE visitors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(50),
    country VARCHAR(100),
    visit_time DATETIME DEFAULT CURRENT_TIMESTAMP
);