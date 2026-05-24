<?php
require_once 'config.php';
require_once 'auth.php';
requireAuth();

$db = getDB();
$message = '';
$type = '';
$edit_skill = null;

// Crear nueva habilidad
if (isset($_POST['action']) && $_POST['action'] === 'create') {
    $name = trim($_POST['name'] ?? '');
    $percentage = intval($_POST['percentage'] ?? 50);
    $display_order = intval($_POST['display_order'] ?? 0);

    if (empty($name)) {
        $message = 'El nombre de la habilidad es obligatorio.';
        $type = 'danger';
    } else {
        $stmt = $db->prepare("INSERT INTO skills (name, percentage, display_order) VALUES (?, ?, ?)");
        $stmt->execute([$name, $percentage, $display_order]);
        $message = 'Habilidad creada correctamente.';
        $type = 'success';
    }
}

// Editar habilidad
if (isset($_POST['action']) && $_POST['action'] === 'update') {
    $id = intval($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $percentage = intval($_POST['percentage'] ?? 50);
    $display_order = intval($_POST['display_order'] ?? 0);

    if (empty($name) || $id <= 0) {
        $message = 'Datos inválidos.';
        $type = 'danger';
    } else {
        $stmt = $db->prepare("UPDATE skills SET name = ?, percentage = ?, display_order = ? WHERE id = ?");
        $stmt->execute([$name, $percentage, $display_order, $id]);
        $message = 'Habilidad actualizada correctamente.';
        $type = 'success';
    }
}

// Eliminar habilidad
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $db->prepare("DELETE FROM skills WHERE id = ?");
    $stmt->execute([$id]);
    $message = 'Habilidad eliminada correctamente.';
    $type = 'success';
}

// Toggle activo/inactivo
if (isset($_GET['toggle'])) {
    $id = intval($_GET['toggle']);
    $stmt = $db->prepare("UPDATE skills SET is_active = CASE WHEN is_active = 1 THEN 0 ELSE 1 END WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: admin_skills.php');
    exit;
}

// Obtener habilidad para editar
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $stmt = $db->prepare("SELECT * FROM skills WHERE id = ?");
    $stmt->execute([$id]);
    $edit_skill = $stmt->fetch();
}

// Listar habilidades
$skills = $db->query("SELECT * FROM skills ORDER BY display_order, id")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habilidades | Portfolio Admin</title>
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
            --bs-body-bg: #0a0a0a;
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
            padding: 25px;
            margin-bottom: 30px;
        }
        .form-card::before {
            content: '';
            display: block;
            width: 100%;
            height: 2px;
            background: var(--orange-primary);
            margin: -25px -25px 20px -25px;
            width: calc(100% + 50px);
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
        .btn-save {
            background: var(--orange-primary);
            color: #000;
            border: none;
            padding: 10px 25px;
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
            padding: 10px 20px;
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
        .table-dark-custom {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
        }
        .table-dark-custom thead th {
            background: #0d0d0d;
            color: var(--orange-primary);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid var(--border-subtle);
            padding: 12px 15px;
        }
        .table-dark-custom tbody td {
            color: var(--text-secondary);
            border-bottom: 1px solid var(--border-subtle);
            padding: 12px 15px;
            font-size: 0.9rem;
        }
        .table-dark-custom tbody tr:hover td {
            color: var(--text-primary);
            background: rgba(255, 107, 26, 0.03);
        }
        .skill-bar {
            width: 100%;
            height: 6px;
            background: #1f1f1f;
            overflow: hidden;
        }
        .skill-bar-fill {
            height: 100%;
            background: var(--orange-primary);
            box-shadow: 0 0 8px var(--orange-glow);
        }
        .btn-action {
            padding: 4px 10px;
            font-size: 0.75rem;
            border: none;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-edit {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }
        .btn-edit:hover {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
        }
        .btn-delete {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }
        .btn-delete:hover {
            background: rgba(220, 53, 69, 0.2);
            color: #dc3545;
        }
        .btn-toggle {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }
        .btn-toggle.inactive {
            background: rgba(108, 117, 125, 0.1);
            color: #6c757d;
            border: 1px solid rgba(108, 117, 125, 0.3);
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
            <li><a href="admin_bio.php"><i class="bi bi-person"></i> Biografía</a></li>
            <li><a href="admin_skills.php" class="active"><i class="bi bi-bar-chart"></i> Habilidades</a></li>
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
            <h1>// Habilidades</h1>
            <a href="dashboard.php" class="btn-cancel"><i class="bi bi-arrow-left"></i> Volver</a>
        </div>

        <?php if ($message): ?>
        <div class="alert alert-custom-<?php echo $type; ?> alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-<?php echo $type === 'success' ? 'check-circle' : 'exclamation-triangle'; ?>-fill"></i> <?php echo htmlspecialchars($message); ?>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <!-- Formulario -->
        <div class="form-card">
            <h4 style="color: var(--orange-primary); font-size: 0.95rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px;">
                <i class="bi bi-<?php echo $edit_skill ? 'pencil' : 'plus-circle'; ?>"></i>
                <?php echo $edit_skill ? 'Editar Habilidad' : 'Nueva Habilidad'; ?>
            </h4>
            <form method="POST" action="">
                <input type="hidden" name="action" value="<?php echo $edit_skill ? 'update' : 'create'; ?>">
                <?php if ($edit_skill): ?>
                <input type="hidden" name="id" value="<?php echo $edit_skill['id']; ?>">
                <?php endif; ?>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label-custom">Nombre</label>
                        <input type="text" name="name" class="form-control form-control-dark" value="<?php echo htmlspecialchars($edit_skill['name'] ?? ''); ?>" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label-custom">Porcentaje (%)</label>
                        <input type="number" name="percentage" class="form-control form-control-dark" min="0" max="100" value="<?php echo $edit_skill['percentage'] ?? 50; ?>" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label-custom">Orden</label>
                        <input type="number" name="display_order" class="form-control form-control-dark" min="0" value="<?php echo $edit_skill['display_order'] ?? 0; ?>">
                    </div>
                    <div class="col-md-2 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-save w-100">
                            <i class="bi bi-<?php echo $edit_skill ? 'check-lg' : 'plus-lg'; ?>"></i> <?php echo $edit_skill ? 'Actualizar' : 'Agregar'; ?>
                        </button>
                    </div>
                </div>
                <?php if ($edit_skill): ?>
                <a href="admin_skills.php" class="btn btn-cancel"><i class="bi bi-x-lg"></i> Cancelar Edición</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Tabla -->
        <div class="table-responsive">
            <table class="table table-dark-custom">
                <thead>
                    <tr>
                        <th>Orden</th>
                        <th>Habilidad</th>
                        <th>Nivel</th>
                        <th>Barra</th>
                        <th>Estado</th>
                        <th style="width: 180px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($skills as $skill): ?>
                    <tr>
                        <td><?php echo $skill['display_order']; ?></td>
                        <td><strong style="color: var(--text-primary);"><?php echo htmlspecialchars($skill['name']); ?></strong></td>
                        <td><?php echo $skill['percentage']; ?>%</td>
                        <td style="width: 150px;">
                            <div class="skill-bar">
                                <div class="skill-bar-fill" style="width: <?php echo $skill['percentage']; ?>%;"></div>
                            </div>
                        </td>
                        <td>
                            <span style="font-size: 0.75rem; padding: 3px 8px; background: <?php echo $skill['is_active'] ? 'rgba(40,167,69,0.1)' : 'rgba(108,117,125,0.1)'; ?>; color: <?php echo $skill['is_active'] ? '#28a745' : '#6c757d'; ?>; border: 1px solid <?php echo $skill['is_active'] ? 'rgba(40,167,69,0.3)' : 'rgba(108,117,125,0.3)'; ?>;">
                                <?php echo $skill['is_active'] ? 'Activo' : 'Inactivo'; ?>
                            </span>
                        </td>
                        <td>
                            <a href="?toggle=<?php echo $skill['id']; ?>" class="btn-action btn-toggle <?php echo !$skill['is_active'] ? 'inactive' : ''; ?>">
                                <i class="bi bi-<?php echo $skill['is_active'] ? 'eye' : 'eye-slash'; ?>"></i>
                            </a>
                            <a href="?edit=<?php echo $skill['id']; ?>" class="btn-action btn-edit"><i class="bi bi-pencil"></i></a>
                            <a href="?delete=<?php echo $skill['id']; ?>" class="btn-action btn-delete" onclick="return confirm('¿Eliminar esta habilidad?')"><i class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($skills)): ?>
                    <tr><td colspan="6" class="text-center py-4">No hay habilidades registradas.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
