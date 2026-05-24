<?php
// ============================================
// CONFIGURACIÓN DEL PORTFOLIO AUTOADMINISTRABLE - MYSQL
// ============================================

session_start();

// Configuración de conexión MySQL
define('DB_HOST', 'localhost');
define('DB_NAME', 'sedwards_db1');
define('DB_USER', 'root');          // Cambia según tu configuración
define('DB_PASS', '');              // Cambia según tu configuración
define('DB_CHARSET', 'utf8mb4');

// Rutas
define('BASE_PATH', dirname(__FILE__));
define('ASSETS_PATH', BASE_PATH . '/assets');

// Timezone
date_default_timezone_set('America/Mexico_City');

// Inicializar conexión a MySQL
require_once BASE_PATH . '/database.php';
?>
