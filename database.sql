-- Database: Sistem Informasi Inventaris Barang
CREATE DATABASE IF NOT EXISTS db_inventaris CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_inventaris;

DROP TABLE IF EXISTS barang;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id_user INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  nama_lengkap VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE barang (
  id_barang INT AUTO_INCREMENT PRIMARY KEY,
  kode_barang VARCHAR(20) NOT NULL UNIQUE,
  nama_barang VARCHAR(100) NOT NULL,
  kategori VARCHAR(50) NOT NULL,
  jumlah INT NOT NULL DEFAULT 0,
  harga DECIMAL(12,2) NOT NULL DEFAULT 0,
  lokasi VARCHAR(100) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Login default: username = admin, password = admin123
INSERT INTO users (username, password, nama_lengkap) VALUES
('admin', '$2y$10$PtGJxUV.tpPgmZPEBx5XMOo/mkmpbSM7BFDTKG2Utdv/0rs9mQiLa', 'Administrator');

INSERT INTO barang (kode_barang, nama_barang, kategori, jumlah, harga, lokasi) VALUES
('BRG-001', 'Laptop Asus Vivobook', 'Elektronik', 10, 7500000, 'Lab Komputer 1'),
('BRG-002', 'Proyektor Epson', 'Elektronik', 4, 5200000, 'Ruang Multimedia'),
('BRG-003', 'Kursi Kuliah', 'Furnitur', 120, 350000, 'Gedung A'),
('BRG-004', 'Spidol Whiteboard', 'ATK', 50, 12000, 'Gudang');
