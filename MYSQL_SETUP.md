# 🗄️ Configuración MySQL - Portfolio SkelSeed

## Paso 1: Crear la base de datos

Ejecuta el archivo SQL en tu servidor MySQL:

Desde phpMyAdmin / MySQL Workbench, importa el archivo `bd.sql`.

## Paso 2: Configurar credenciales de conexión

Edita el archivo `config.php` y ajusta los valores según tu entorno:

```php
define('DB_HOST', 'localhost');     // Servidor MySQL
define('DB_NAME', 'sedwards_db1');  // Nombre de la base de datos
define('DB_USER', 'root');          // Usuario de MySQL
define('DB_PASS', '');              // Contraseña de MySQL
define('DB_CHARSET', 'utf8mb4');
```

### Ejemplos comunes:

**Hosting compartido:**
```php
define('DB_HOST', 'tu_host_mysql.com');
define('DB_NAME', 'sedwards_db1');
define('DB_USER', 'tu_usuario_mysql');
define('DB_PASS', 'tu_contraseña_mysql');
```

## Paso 3: Probar la conexión

Abre `index.php` en tu navegador. Si todo está correcto, verás el portfolio con los datos de la base de datos.

## 🔐 Credenciales de acceso

- **Usuario:** `admin`
- **Contraseña:** `admin123`

## ⚠️ Notas importantes

1. El hash de la contraseña se generó con `password_hash('admin123', PASSWORD_DEFAULT)` de PHP.
2. Si necesitas cambiar la contraseña, ejecuta en PHP:
   ```php
   echo password_hash('nueva_contraseña', PASSWORD_DEFAULT);
   ```
   Y actualiza el campo `password_hash` en la tabla `users`.
3. La carpeta `data/` ya no se usa (era para SQLite), puedes eliminarla si quieres.
