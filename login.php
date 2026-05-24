<?php
require_once 'config.php';
require_once 'auth.php';

// Si ya está logueado, redirigir al dashboard
if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($username) || empty($password)) {
        $error = 'Por favor completa todos los campos.';
    } else {
        if (login($username, $password)) {
            flashMessage('success', '¡Bienvenido al panel de administración!');
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Usuario o contraseña incorrectos.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Portfolio Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #0a0a0a;
            --bg-card: #111111;
            --orange-primary: #ff6b1a;
            --orange-glow: #ff8c42;
            --text-primary: #e0e0e0;
            --text-secondary: #a0a0a0;
            --border-subtle: #1f1f1f;
        }
        body {
            background: url('assets/euHDM2Xg_4x.jpg') center center / cover no-repeat;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(10, 10, 10, 0.85);
            z-index: 0;
        }
        .login-card {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: 8px;
            padding: 40px;
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 1;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        }
        .login-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 3px;
            background: var(--orange-primary);
            box-shadow: 0 0 15px var(--orange-glow);
        }
        .logo-login {
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: 3px;
            color: var(--text-primary);
            text-transform: uppercase;
            text-align: center;
            margin-bottom: 8px;
        }
        .logo-login span { color: var(--orange-primary); }
        .subtitle-login {
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.85rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 30px;
        }
        .form-control-dark {
            background: #1a1a1a;
            border: 1px solid var(--border-subtle);
            color: var(--text-primary);
            padding: 12px 15px;
        }
        .form-control-dark:focus {
            background: #1a1a1a;
            border-color: var(--orange-primary);
            color: var(--text-primary);
            box-shadow: 0 0 10px rgba(255, 107, 26, 0.2);
        }
        .form-control-dark::placeholder { color: #555; }
        .form-label-custom {
            color: var(--text-secondary);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }
        .btn-login-submit {
            background: var(--orange-primary);
            color: #000;
            border: none;
            padding: 12px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 0 20px rgba(255, 107, 26, 0.3);
        }
        .btn-login-submit:hover {
            background: var(--orange-glow);
            box-shadow: 0 0 35px rgba(255, 107, 26, 0.5);
            transform: translateY(-2px);
        }
        .back-link {
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.8rem;
            letter-spacing: 1px;
            transition: color 0.3s;
        }
        .back-link:hover { color: var(--orange-primary); }
        .alert-custom {
            background: rgba(255, 107, 26, 0.1);
            border: 1px solid rgba(255, 107, 26, 0.3);
            color: var(--orange-primary);
            font-size: 0.85rem;
        }
        .icon-lock {
            font-size: 3rem;
            color: var(--orange-primary);
            text-align: center;
            display: block;
            margin-bottom: 15px;
            text-shadow: 0 0 20px rgba(255, 107, 26, 0.4);
        }
    </style>
</head>
<body>
    <div class="login-card">
        <i class="bi bi-shield-lock icon-lock"></i>
        <div class="logo-login">&lt;<span>DEV</span>/&gt;</div>
        <div class="subtitle-login">Panel de Administración</div>

        <?php if ($error): ?>
        <div class="alert alert-custom alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill"></i> <?php echo htmlspecialchars($error); ?>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label-custom">Usuario</label>
                <input type="text" name="username" class="form-control form-control-dark" placeholder="admin" required autofocus>
            </div>
            <div class="mb-4">
                <label class="form-label-custom">Contraseña</label>
                <input type="password" name="password" class="form-control form-control-dark" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn btn-login-submit">
                <i class="bi bi-box-arrow-in-right"></i> Ingresar
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="index.php" class="back-link"><i class="bi bi-arrow-left"></i> Volver al Portfolio</a>
        </div>
        <div class="text-center mt-2">
            <small style="color: #444; font-size: 0.7rem;">Usuario por defecto: <strong>admin</strong> / Contraseña: <strong>admin123</strong></small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
