# 🌃 Portfolio Urbano Nocturno - Autoadministrable (MySQL)
[Uso de la IA](https://github.com/skelseed/portfolio/blob/main/docs/uso_ia.md)

Sistema de portfolio web autoadministrable con tema urbano nocturno, panel de administración completo y base de datos **MySQL**.

---

## Estructura de Archivos

```
portfolio_php/
├── index.php              # Portfolio público (frontend)
├── login.php              # Página de inicio de sesión
├── logout.php             # Cierre de sesión
├── dashboard.php          # Panel principal del admin
├── admin_bio.php          # CRUD de Biografía
├── admin_skills.php       # CRUD de Habilidades
├── admin_tech.php         # CRUD de Tecnologías
├── admin_projects.php     # CRUD de Proyectos
├── config.php             # Configuración global (MySQL)
├── database.php           # Conexión PDO MySQL
├── auth.php               # Funciones de autenticación
├── sedwards_db1.sql       # Script SQL para crear la base de datos
├── MYSQL_SETUP.md         # Guía de configuración MySQL
├── assets/
│   └── euHDM2Xg_4x.jpg   # Imagen de fondo urbano
└── data/                  # (obsoleto, era para SQLite)
```

---

## Requisitos

- **PHP 7.4+** con extensión **PDO MySQL** habilitada
- **MySQL 5.7+** o **MariaDB 10.2+**
- Servidor web (Apache, Nginx, etc.)
- Navegador moderno

---

## Instalación

### 1. Crear la base de datos

Ejecuta el script SQL en tu servidor MySQL:

```bash
mysql -u root -p < bd.sql
```

O importa `bd.sql` desde phpMyAdmin.

### 2. Configurar conexión

Edita `config.php` con tus credenciales MySQL:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'mybd');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### 3. Desplegar

Copia todos los archivos a tu servidor web (`htdocs/`, `www/`, etc.) y abre `index.php`.

### 4. Acceder al admin

Haz clic en **Admin** en la esquina superior derecha e inicia sesión con:
- **Usuario:** `admin`
- **Contraseña:** `admin123`

---

## Funcionalidades del Sistema

### Sistema de Inicio de Sesión
- ✅ Login funcional con PHP + sesiones
- ✅ Validación de credenciales con `password_hash()`
- ✅ Protección de rutas administrativas
- ✅ Cierre de sesión seguro

### Dashboard Administrativo
- ✅ **Biografía**: Editar nombre, título, descripción, email, badge
- ✅ **Habilidades**: CRUD con porcentajes y orden
- ✅ **Tecnologías**: CRUD con selector de iconos Bootstrap
- ✅ **Proyectos**: CRUD con emojis, tags y descripciones
- ✅ Toggle activo/inactivo
- ✅ Ordenamiento personalizable

---

## Características del Diseño

- Fondo urbano nocturno con imagen real
- Tema oscuro con acentos naranja neón
- Bootstrap 5 + Bootstrap Icons
- Animaciones CSS
- Totalmente responsive

---

## Seguridad

- Contraseñas hasheadas con bcrypt
- Validación de sesiones en todas las páginas admin
- Escape de output con `htmlspecialchars()`
- Conexiones PDO preparadas (protección contra SQL Injection)

---

## Esquema de la base de datos (sedwards_db1)

| Tabla | Descripción |
|-------|-------------|
| `users` | Usuarios administrativos |
| `bio` | Información personal del portfolio |
| `skills` | Habilidades con porcentajes |
| `technologies` | Stack tecnológico |
| `projects` | Proyectos del portfolio |

---

**© 2026 Portfolio Urbano Nocturno | Desarrollado con PHP + MySQL + Bootstrap 5**
