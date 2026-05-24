<?php
// ============================================
// CONEXIÓN MYSQL - PORTFOLIO
// ============================================

function getDB() {
    static $pdo = null;

    if ($pdo === null) {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            die("Error de conexión a MySQL: " . $e->getMessage());
        }
    }

    return $pdo;
}

// Función para verificar/crear tablas (útil para primera instalación)
function initDatabase() {
    try {
        $db = getDB();

        // Verificar que las tablas existen (si no, el admin debe ejecutar el SQL)
        $tables = ['users', 'bio', 'skills', 'technologies', 'projects'];
        $missing = [];

        foreach ($tables as $table) {
            $stmt = $db->query("SHOW TABLES LIKE '$table'");
            if ($stmt->rowCount() === 0) {
                $missing[] = $table;
            }
        }

        if (!empty($missing)) {
            // No mostrar error fatal, solo un warning que se puede manejar
            // Las tablas deben crearse ejecutando sedwards_db1.sql
            error_log("Tablas faltantes en sedwards_db1: " . implode(', ', $missing));
        }

    } catch (PDOException $e) {
        die("Error al verificar tablas: " . $e->getMessage());
    }
}

initDatabase();
?>
