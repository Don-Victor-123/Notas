CREATE DATABASE tu_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tu_app;

-- Usuarios y roles
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  name VARCHAR(100) NOT NULL,
  shift ENUM('Matutino','Vespertino','Nocturno') NOT NULL,
  role ENUM('ADMIN','USER') NOT NULL DEFAULT 'USER'
);

-- Grupos
CREATE TABLE groups (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  required_position VARCHAR(100) DEFAULT NULL,
  created_by INT NOT NULL,
  FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE CASCADE
);

-- Miembros de grupo
CREATE TABLE group_members (
  group_id INT,
  user_id INT,
  PRIMARY KEY(group_id,user_id),
  FOREIGN KEY (group_id) REFERENCES groups(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id)  REFERENCES users(id)  ON DELETE CASCADE
);

-- Notas/mensajes
CREATE TABLE notes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  group_id INT NOT NULL,
  author_id INT NOT NULL,
  content TEXT,
  status ENUM('Pendiente','En Proceso','Realizado') NOT NULL DEFAULT 'Pendiente',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (group_id)  REFERENCES groups(id) ON DELETE CASCADE,
  FOREIGN KEY (author_id) REFERENCES users(id)  ON DELETE CASCADE
);

-- Usuario administrador por defecto
INSERT INTO users (username,password,name,shift,role)
VALUES ('admin', '$2y$12$tU9XMfi/3tOnObACDQPSB.IMqURoAcThGU8oBrVK/Q5zzMTh2URde',
        'Administrador','Matutino','ADMIN');
