CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    date DATETIME NOT NULL
);

CREATE TABLE applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255),
    phone VARCHAR(20),
    email VARCHAR(255),
    work_experience VARCHAR(10),
    education VARCHAR(10),
    applying_role VARCHAR(50),
    resume VARCHAR(255),
    submit_time DATETIME
);

CREATE TABLE videos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    title VARCHAR(255) NOT NULL,
    filepath VARCHAR(255) NOT NULL
);

CREATE TABLE photos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(15) NOT NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(64),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Add indexes for better performance
CREATE INDEX idx_username ON users(username);
CREATE INDEX idx_email ON users(email);
CREATE INDEX idx_remember_token ON users(remember_token);
