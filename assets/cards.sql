-- قاعدة البيانات: portfolio_dashboard

-- جدول المشاريع
CREATE TABLE cards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
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
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
);

-- جدول الزائرين
CREATE TABLE visitors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(50) NOT NULL,
    country VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- جدول المستخدمين
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
);