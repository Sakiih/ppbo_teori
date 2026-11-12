CREATE DATABASE IF NOT EXISTS db_inventaris;

USE db_inventaris;

CREATE TABLE categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE products (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(150) NOT NULL,
    price DECIMAL(12,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_products_categories
        FOREIGN KEY (category_id)
        REFERENCES categories(id)
        ON DELETE RESTRICT
);

-- Data awal kategori
INSERT INTO categories (name, description)
VALUES
('Elektronik', 'Perangkat elektronik'),
('Alat Tulis', 'Peralatan alat tulis'),
('Peralatan Komputer', 'Perlengkapan komputer');

-- Data awal produk
INSERT INTO products
(category_id, name, price, stock)
VALUES
(1, 'Laptop Lenovo', 7500000, 10),
(1, 'Mouse Logitech', 150000, 25),
(2, 'Buku Catatan', 15000, 100);