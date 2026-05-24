<?php
require_once 'config.php';
require_once 'auth.php';
requireAuth();

$db = getDB();

// Contadores
$skills_count = $db->query("SELECT COUNT(*) FROM skills WHERE is_active = 1")->fetchColumn();
$projects_count = $db->query("SELECT COUNT(*) FROM projects WHERE is_active = 1")->fetchColumn();
$tech_count = $db->query("SELECT COUNT(*) FROM technologies WHERE is_active = 1")->fetchColumn();
$bio = $db->query("SELECT * FROM bio LIMIT 1")->fetch();

$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Portfolio Admin</title>
    <lVink href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
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
            --bs-body-bg: #0a0a0a !important;
        }
        body {
            background: var(--bg-dark);
            color: var(--text-primary);
            font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
            min-height: 100vh;
        }
        /* Sidebar */
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
        /* Main content */
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
        /* Cards */
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            padding: 25px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 2px;
            background: var(--orange-primary);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
            box-shadow: 0 0 10px var(--orange-glow);
        }
        .stat-card:hover::before { transform: scaleX(1); }
        .stat-card:hover {
            border-color: rgba(255, 107, 26, 0.3);
            transform: translateY(-3px);
        }
        .stat-icon {
            font-size: 2.2rem;
            color: var(--orange-primary);
            margin-bottom: 10px;
        }
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
        }
        .stat-label {
            font-size: 0.8rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        /* Quick actions */
        .action-card {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            padding: 20px;
            text-decoration: none;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 15px;
            transition: all 0.3s ease;
        }
        .action-card:hover {
            border-color: rgba(255, 107, 26, 0.4);
            color: var(--orange-primary);
            transform: translateX(5px);
        }
        .action-icon {
            width: 45px;
            height: 45px;
            background: rgba(255, 107, 26, 0.1);
            border: 1px solid rgba(255, 107, 26, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            color: var(--orange-primary);
        }
        .action-text h4 {
            font-size: 0.95rem;
            margin: 0;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .action-text p {
            font-size: 0.75rem;
            color: var(--text-secondary);
            margin: 0;
        }
        /* Alert */
        .alert-custom-success {
            background: rgba(40, 167, 69, 0.1);
            border: 1px solid rgba(40, 167, 69, 0.3);
            color: #28a745;
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
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar { width: 100%; position: relative; min-height: auto; }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            &lt;<span>Skel</span>/&gt;
        </div>
        <ul class="nav-sidebar">
            <li><a href="dashboard.php" class="active"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            <li><a href="admin_bio.php"><i class="bi bi-person"></i> Biografía</a></li>
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

    <!-- Main Content -->
    <main class="main-content">
        <div class="page-header d-flex justify-content-between align-items-center">
            <h1>// Dashboard</h1>
            <span style="color: var(--text-secondary); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">
                Portfolio Autoadministrable
            </span>
        </div>

        <?php if ($flash): ?>
        <div class="alert alert-custom-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> <?php echo htmlspecialchars($flash['message']); ?>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <!-- Stats -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="stat-card">
                    <i class="bi bi-bar-chart stat-icon"></i>
                    <div class="stat-number"><?php echo $skills_count; ?></div>
                    <div class="stat-label">Habilidades Activas</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <i class="bi bi-folder stat-icon"></i>
                    <div class="stat-number"><?php echo $projects_count; ?></div>
                    <div class="stat-label">Proyectos Activos</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <i class="bi bi-cpu stat-icon"></i>
                    <div class="stat-number"><?php echo $tech_count; ?></div>
                    <div class="stat-label">Tecnologías</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <h3 style="font-size: 1.1rem; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 20px; color: var(--text-secondary);">
            <i class="bi bi-lightning-charge" style="color: var(--orange-primary);"></i> Acciones Rápidas
        </h3>
        <div class="row g-3">
            <div class="col-md-6">
                <a href="admin_bio.php" class="action-card">
                    <div class="action-icon"><i class="bi bi-person"></i></div>
                    <div class="action-text">
                        <h4>Editar Biografía</h4>
                        <p>Nombre, título, descripción y contacto</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="admin_skills.php" class="action-card">
                    <div class="action-icon"><i class="bi bi-bar-chart"></i></div>
                    <div class="action-text">
                        <h4>Gestionar Skills</h4>
                        <p>Porcentajes y orden de habilidades</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="admin_tech.php" class="action-card">
                    <div class="action-icon"><i class="bi bi-cpu"></i></div>
                    <div class="action-text">
                        <h4>Tecnologías</h4>
                        <p>Stack tecnológico del portfolio</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="admin_projects.php" class="action-card">
                    <div class="action-icon"><i class="bi bi-folder"></i></div>
                    <div class="action-text">
                        <h4>Proyectos</h4>
                        <p>CRUD completo de proyectos</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Info -->
        <div class="mt-5 p-4" style="background: var(--bg-card); border: 1px solid var(--border-subtle); border-left: 3px solid var(--orange-primary);">
            <h5 style="color: var(--orange-primary); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px;">
                <i class="bi bi-info-circle"></i> Información del Portfolio
            </h5>
            <p style="color: var(--text-secondary); font-size: 0.85rem; margin: 0;">
                <strong>Nombre actual:</strong> <?php echo htmlspecialchars($bio['name'] ?? '[Tu Nombre]'); ?> |
                <strong>Email:</strong> <?php echo htmlspecialchars($bio['email'] ?? 'tuemail@dominio.com'); ?> |
                <strong>Última actualización:</strong> <?php echo htmlspecialchars($bio['updated_at'] ?? 'Nunca'); ?>
            </p>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
