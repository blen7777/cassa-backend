-- Esquema de base de datos - Prueba Tecnica Agricola CASSA
-- Motor: MySQL 8

CREATE TABLE IF NOT EXISTS responsables (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    apellido VARCHAR(150) NULL,
    correo VARCHAR(255) NULL,
    telefono VARCHAR(30) NULL,
    estatus TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE INDEX idx_responsables_estatus ON responsables (estatus);

CREATE TABLE IF NOT EXISTS haciendas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(200) NOT NULL,
    ubicacion VARCHAR(255) NULL,
    estatus TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

CREATE INDEX idx_haciendas_estatus ON haciendas (estatus);

CREATE TABLE IF NOT EXISTS lotes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hacienda_id INT NOT NULL,
    nombre VARCHAR(200) NOT NULL,
    hectareas DECIMAL(12, 2) NULL,
    estatus TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT fk_lotes_hacienda FOREIGN KEY (hacienda_id) REFERENCES haciendas (id)
);

CREATE INDEX idx_lotes_hacienda_id ON lotes (hacienda_id);
CREATE INDEX idx_lotes_estatus ON lotes (estatus);
