-- Create the database and student registration table for the Elimu Bora website.
CREATE DATABASE IF NOT EXISTS trainee_data
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE trainee_data;

CREATE TABLE IF NOT EXISTS trainees (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    full_name VARCHAR(120) NOT NULL,
    email VARCHAR(190) NOT NULL,
    phone VARCHAR(30) NOT NULL,
    department VARCHAR(100) NOT NULL,
    course VARCHAR(150) NOT NULL,
    intake VARCHAR(30) NOT NULL,
    accommodation VARCHAR(80) NOT NULL,
    registered_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    INDEX idx_trainees_email (email),
    INDEX idx_trainees_intake (intake)
) ENGINE=InnoDB;