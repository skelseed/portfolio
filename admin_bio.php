<?php
require_once 'config.php';
require_once 'auth.php';
requireAuth();

$db = getDB();
$message = '';
$type = '';

// Actualizar biografía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $title = trim($_POST['title'] ?? '');
    $subtitle = trim($_POST['subtitle'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $badge_text = trim($_POST['badge_text'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if (empty($name) || empty($title)) {
        $message = 'El nombre y título son obligatorios.';
        $type = 'danger';
    } else {
        $stmt = $db->prepare("UPDATE bio SET name = ?, title = ?, subtitle = ?, description = ?, badge_text = ?, email = ?, updated_at = datetime('now') WHERE id = 1");
        $stmt->execute([$name, $title, $subtitle, $description, $badge_text, $email]);
        $message = 'Biografía actualizada correctamente.';
        $type = 'success';
    }
}

$bio = $db->query("SELECT * FROM bio LIMIT 1")->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biografía | Portfolio Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #0a0a0a;
            --bg-card: #111111;
            --bg-sidebar: #0d0d0d;
            --orange-primary: #ff6b1a;
            --orange-glow: #ff8c42;
            --text-primary: #e0e0e0;
            --text-secondary: #a0a0a0;
            --border-subtle: #1f1f1f;
        }
        body {
            background: var(--bg-dark);
            color: var(--text-primary);
            font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
            min-height: 100vh;
        }
        .sidebar {
            background: var(--bg-sidebar);
            border-right: 1px solid var(--border-subtle);
            min-height: 100vh;
            width: 260px;
            position: fixed;
            top: 0; left: 0;
            z-index: 1000;
            padding: 25px 0;
        }
        .sidebar-logo {
            font-size: 1.4rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-align: center;
            margin-bottom: 30px;
            padding: 0 20px;
        }
        .sidebar-logo span { color: var(--orange-primary); }
        .sidebar-logo::after {
            content: '';
            display: block;
            width: 40px;
            height: 2px;
            background: var(--orange-primary);
            margin: 10px auto 0;
            box-shadow: 0 0 10px var(--orange-glow);
        }
        .nav-sidebar {
            list-style: none;
            padding: 0;
        }
        .nav-sidebar li { margin-bottom: 2px; }
        .nav-sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 25px;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.9rem;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }
        .nav-sidebar a:hover, .nav-sidebar a.active {
            color: var(--orange-primary);
            background: rgba(255, 107, 26, 0.05);
            border-left-color: var(--orange-primary);
        }
        .nav-sidebar i { font-size: 1.1rem; }
        .sidebar-footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 20px 25px;
            border-top: 1px solid var(--border-subtle);
        }
        .user-info {
            font-size: 0.8rem;
            color: var(--text-secondary);
            margin-bottom: 10px;
        }
        .user-info strong { color: var(--orange-primary); }
        .main-content {
            margin-left: 260px;
            padding: 30px;
            min-height: 100vh;
        }
        .page-header {
            border-bottom: 1px solid var(--border-subtle);
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .page-header h1 {
            font-size: 1.6rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin: 0;
        }
        .page-header h1::after {
            content: '';
            display: block;
            width: 50px;
            height: 2px;
            background: var(--orange-primary);
            margin-top: 10px;
            box-shadow: 0 0 10px var(--orange-glow);
        }
        .form-card {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            padding: 30px;
        }
        .form-card::before {
            content: '';
            display: block;
            width: 100%;
            height: 2px;
            background: var(--orange-primary);
            margin: -30px -30px 25px -30px;
            width: calc(100% + 60px);
            box-shadow: 0 0 10px var(--orange-glow);
        }
        .form-label-custom {
            color: var(--text-secondary);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }
        .form-control-dark {
            background: #1a1a1a;
            border: 1px solid var(--border-subtle);
            color: var(--text-primary);
            padding: 10px 15px;
        }
        .form-control-dark:focus {
            background: #1a1a1a;
            border-color: var(--orange-primary);
            color: var(--text-primary);
            box-shadow: 0 0 10px rgba(255, 107, 26, 0.2);
        }
        .form-control-dark::placeholder { color: #444; }
        textarea.form-control-dark { min-height: 100px; }
        .btn-save {
            background: var(--orange-primary);
            color: #000;
            border: none;
            padding: 10px 30px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: all 0.3s ease;
            box-shadow: 0 0 20px rgba(255, 107, 26, 0.3);
        }
        .btn-save:hover {
            background: var(--orange-glow);
            box-shadow: 0 0 35px rgba(255, 107, 26, 0.5);
            transform: translateY(-2px);
            color: #000;
        }
        .btn-cancel {
            background: transparent;
            color: var(--text-secondary);
            border: 1px solid var(--border-subtle);
            padding: 10px 25px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .btn-cancel:hover {
            border-color: var(--orange-primary);
            color: var(--orange-primary);
        }
        .alert-custom-success {
            background: rgba(40, 167, 69, 0.1);
            border: 1px solid rgba(40, 167, 69, 0.3);
            color: #28a745;
        }
        .alert-custom-danger {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: #dc3545;
        }
        .btn-logout {
            background: transparent;
            color: var(--text-secondary);
            border: 1px solid var(--border-subtle);
            padding: 6px 16px;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-logout:hover {
            border-color: #dc3545;
            color: #dc3545;
        }
        @media (max-width: 768px) {
            .sidebar { width: 100%; position: relative; min-height: auto; }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-logo">&lt;<span>DEV</span>/&gt;</div>
        <ul class="nav-sidebar">
            <li><a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            <li><a href="admin_bio.php" class="active"><i class="bi bi-person"></i> Biografía</a></li>
            <li><a href="admin_skills.php"><i class="bi bi-bar-chart"></i> Habilidades</a></li>
            <li><a href="admin_tech.php"><i class="bi bi-cpu"></i> Tecnologías</a></li>
            <li><a href="admin_projects.php"><i class="bi bi-folder"></i> Proyectos</a></li>
            <li><a href="index.php" target="_blank"><i class="bi bi-eye"></i> Ver Portfolio</a></li>
        </ul>
        <div class="sidebar-footer">
            <div class="user-info">
                <i class="bi bi-person-circle"></i> Conectado como <strong><?php echo htmlspecialchars($_SESSION['admin_username']); ?></strong>
            </div>
            <a href="logout.php" class="btn-logout"><i class="bi bi-box-arrow-right"></i> Cerrar Sesión</a>
        </div>
    </aside>

    <main class="main-content">
        <div class="page-header d-flex justify-content-between align-items-center">
            <h1>// Biografía</h1>
            <a href="dashboard.php" class="btn-cancel"><i class="bi bi-arrow-left"></i> Volver</a>
        </div>

        <?php if ($message): ?>
        <div class="alert alert-custom-<?php echo $type; ?> alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-<?php echo $type === 'success' ? 'check-circle' : 'exclamation-triangle'; ?>-fill"></i> <?php echo htmlspecialchars($message); ?>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <div class="form-card">
            <form method="POST" action="">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">Nombre Completo</label>
                        <input type="text" name="name" class="form-control form-control-dark" value="<?php echo htmlspecialchars($bio['name'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">Título Profesional</label>
                        <input type="text" name="title" class="form-control form-control-dark" value="<?php echo htmlspecialchars($bio['title'] ?? ''); ?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label-custom">Subtítulo / Lema</label>
                    <input type="text" name="subtitle" class="form-control form-control-dark" value="<?php echo htmlspecialchars($bio['subtitle'] ?? ''); ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label-custom">Descripción</label>
                    <textarea name="description" class="form-control form-control-dark" rows="4"><?php echo htmlspecialchars($bio['description'] ?? ''); ?></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">Texto del Badge</label>
                        <input type="text" name="badge_text" class="form-control form-control-dark" value="<?php echo htmlspecialchars($bio['badge_text'] ?? ''); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">Email de Contacto</label>
                        <input type="email" name="email" class="form-control form-control-dark" value="<?php echo htmlspecialchars($bio['email'] ?? ''); ?>">
                    </div>
                </div>
                <div class="d-flex gap-3 mt-3">
                    <button type="submit" class="btn btn-save"><i class="bi bi-check-lg"></i> Guardar Cambios</button>
                    <a href="dashboard.php" class="btn btn-cancel">Cancelar</a>
                </div>
            </form>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
