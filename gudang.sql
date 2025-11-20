-- gudang database
DROP DATABASE IF EXISTS gudang;
CREATE DATABASE gudang CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE gudang;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  nama_lengkap VARCHAR(100),
  foto VARCHAR(255),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE barang (
  id INT AUTO_INCREMENT PRIMARY KEY,
  kode_barang VARCHAR(50) NOT NULL UNIQUE,
  nama_barang VARCHAR(100) NOT NULL,
  kategori VARCHAR(50),
  satuan VARCHAR(20),
  stok INT DEFAULT 0,
  stok_minimum INT DEFAULT 0,
  foto VARCHAR(255),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE pemasukan_barang (
  id INT AUTO_INCREMENT PRIMARY KEY,
  barang_id INT NOT NULL,
  jumlah INT NOT NULL,
  tanggal_masuk DATE,
  supplier VARCHAR(100),
  user_id INT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (barang_id) REFERENCES barang(id)
);

CREATE TABLE pengeluaran_barang (
  id INT AUTO_INCREMENT PRIMARY KEY,
  barang_id INT NOT NULL,
  jumlah INT NOT NULL,
  tanggal_keluar DATE,
  tujuan VARCHAR(100),
  user_id INT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (barang_id) REFERENCES barang(id)
);

CREATE TABLE barang_rijek (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_barang INT,
  jumlah INT NOT NULL,
  keterangan VARCHAR(255),
  foto VARCHAR(255),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_barang) REFERENCES barang(id)
);

-- sample admin (password: admin123)
INSERT INTO users (username, password, nama_lengkap, created_at) VALUES
('admin', '$2y$10$Wf2x8sQwQmK0HnG6n4g4xO8K4hF8q3sYVYgY1u2kq5GZ1b9r0ZC1K', 'Administrator', NOW());

-- sample barang
INSERT INTO barang (kode_barang,nama_barang,kategori,satuan,stok,stok_minimum,created_at) VALUES
('BRG001','Botol Plastik','Alat Minum','Unit',50,5,NOW()),
('BRG002','Tissue','Kebersihan','Box',20,2,NOW());
