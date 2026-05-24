-- ============================================
-- BASE DE DATOS MYSQL - PORTFOLIO AUTOADMINISTRABLE
-- Nombre: sedwards_db1
-- ============================================

-- Crear la base de datos (si no existe)
CREATE DATABASE IF NOT EXISTS sedwards_db1 
    CHARACTER SET utf8mb4 
    COLLATE utf8mb4_unicode_ci;

USE sedwards_db1;

-- ============================================
-- TABLA: users (Usuarios administrativos)
-- ============================================
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLA: bio (Biografía / Información personal)
-- ============================================
CREATE TABLE IF NOT EXISTS bio (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL DEFAULT '[Tu Nombre]',
    title VARCHAR(150) NOT NULL DEFAULT 'skelseed',
    subtitle VARCHAR(255) DEFAULT 'Desarrollador &',
    description TEXT DEFAULT 'Aficionado a las ciencias de la computación, la electronica y contabilidad. Desarrollador amateur.',
    badge_text VARCHAR(100) DEFAULT 'Disponible para proyectos',
    email VARCHAR(100) DEFAULT 'crazypotato73@aol.com',
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLA: skills (Habilidades / Skills)
-- ============================================
CREATE TABLE IF NOT EXISTS skills (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    percentage INT NOT NULL DEFAULT 50,
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLA: technologies (Tecnologías / Tech Stack)
-- ============================================
CREATE TABLE IF NOT EXISTS technologies (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    icon VARCHAR(50) DEFAULT 'bi-code-slash',
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLA: projects (Proyectos)
-- ============================================
CREATE TABLE IF NOT EXISTS projects (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    icon VARCHAR(20) DEFAULT '128187',
    tags VARCHAR(255) DEFAULT '',
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- DATOS INICIALES - Actualizados según index.html
-- ============================================

-- Usuario admin por defecto (contraseña: admin123)
-- Hash bcrypt generado con PHP: password_hash('admin123', PASSWORD_DEFAULT)
INSERT INTO users (username, password_hash) VALUES
    ('admin', '$2b$10$Lt5d9XL504iZ1yAzEOy1hOFV61sujShW64Kr7m97Y/lhYssPahqIy');

-- Biografía actualizada con datos de index.html
INSERT INTO bio (name, title, subtitle, description, badge_text, email) VALUES
    ('Sebastian Edwards', 'skelseed', 'Desarrollador &',
    'Aficionado a las ciencias de la computación, la electronica y contabilidad. Desarrollador amateur.',
    'Disponible para proyectos', 'crazypotato73@aol.com');

-- Habilidades actualizadas según index.html
INSERT INTO skills (name, percentage, display_order) VALUES
    ('Frontend Development', 90, 1),
    ('Backend & APIs', 20, 2),
    ('Spreadsheets', 100, 3),
    ('DevOps & Cloud', 70, 4);

-- Tecnologías por defecto
INSERT INTO technologies (name, icon, display_order) VALUES
    ('HTML5', 'bi-filetype-html', 1),
    ('CSS3', 'bi-filetype-css', 2),
    ('JavaScript', 'bi-filetype-js', 3),
    ('PHP', 'bi-filetype-php', 4),
    ('React', 'bi-bootstrap', 5),
    ('Node.js', 'bi-server', 6),
    ('Python', 'bi-filetype-py', 7),
    ('MySQL', 'bi-database', 8);

-- Proyectos actualizados según index.html
INSERT INTO projects (title, description, icon, tags, display_order) VALUES
    ('Gestor de Tareas', 'Plataforma web tablero kanban', '128187', 'Javascript,HTML', 1),
    ('MirandaPET', 'Asistente virtual basado en un personaje mitológico', '128241', 'Javascript,CSS', 2),
    ('Albion Visualizer', 'Visualizador utilizando la API de Albion Online', '9889', 'Next.js,Stripe,PostgreSQL', 3);
