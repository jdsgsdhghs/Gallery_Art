-- Create database
CREATE DATABASE IF NOT EXISTS galerie_oselo;
USE galerie_oselo;

-- Create tables
CREATE TABLE warehouses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE artworks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    year INT,
    artist_name VARCHAR(255),
    width FLOAT,
    height FLOAT,
    warehouse_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (warehouse_id) REFERENCES warehouses(id) ON DELETE SET NULL
);

-- Insert sample data
INSERT INTO warehouses (name, address) VALUES
('Main Warehouse', '123 Art Street, Paris, France'),
('Secondary Storage', '456 Gallery Avenue, Paris, France'),
('Restoration Workshop', '789 Conservation Boulevard, Paris, France');

INSERT INTO artworks (title, year, artist_name, width, height, warehouse_id) VALUES
('Sunflowers', 1888, 'Vincent van Gogh', 92.1, 73, 1),
('Starry Night', 1889, 'Vincent van Gogh', 73.7, 92.1, 1),
('Water Lilies', 1916, 'Claude Monet', 200, 180, 2),
('The Persistence of Memory', 1931, 'Salvador Dalí', 24, 33, 2),
('Guernica', 1937, 'Pablo Picasso', 349, 776, 3),
('The Scream', 1893, 'Edvard Munch', 91, 73.5, NULL),
('Girl with a Pearl Earring', 1665, 'Johannes Vermeer', 44.5, 39, NULL);