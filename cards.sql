CREATE TABLE cards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    description TEXT,
    link VARCHAR(255),
    image1 VARCHAR(255),
    image2 VARCHAR(255),
    image3 VARCHAR(255),
    image4 VARCHAR(255),
    image5 VARCHAR(255),
    image6 VARCHAR(255),
    role VARCHAR(255),
    services TEXT,
    credits TEXT,
    location VARCHAR(255),
    year YEAR,
    extra_text TEXT,
    created_at DATE
);

CREATE TABLE visitors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(50),
    country VARCHAR(100),
    visit_time DATETIME DEFAULT CURRENT_TIMESTAMP
);