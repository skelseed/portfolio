<?php
require_once 'config.php';

$db = getDB();

// Obtener datos
$bio = $db->query("SELECT * FROM bio LIMIT 1")->fetch();
$skills = $db->query("SELECT * FROM skills WHERE is_active = 1 ORDER BY display_order, id")->fetchAll();
$technologies = $db->query("SELECT * FROM technologies WHERE is_active = 1 ORDER BY display_order, id")->fetchAll();
$projects = $db->query("SELECT * FROM projects WHERE is_active = 1 ORDER BY display_order, id")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skelseed | Portfolio</title>
    <link rel="stylesheet" href="./assets/bootstrap-5.1.3-dist/css/bootstrap.css">
    <link rel="stylesheet" href="./assets/style/style.css">
</head>
<body>
    <div class="urban-background"></div>
    <div class="particles"></div>
    <div class="scanlines"></div>

    <div class="main-container">
        <header class="header">
            <div class="logo">
                &lt;<span>Skel</span>/&gt;
            </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="#inicio">Inicio</a></li>
                    <li><a href="#proyectos">Proyectos</a></li>
                    <li><a href="#habilidades">Skills</a></li>
                    <li><a href="#contacto">Contacto</a></li>
                </ul>
            </nav>
            <a href="login.php" class="btn-login">
                <i class="bi bi-person-lock"></i> Admin
            </a>
        </header>

        <section class="hero" id="inicio">
            <div class="hero-content">
                <span class="hero-badge">&#9679; <?php echo htmlspecialchars($bio['badge_text'] ?? 'Disponible para proyectos'); ?></span>
                <h1>
                    <?php echo htmlspecialchars($bio['name'] ?? 'Sebastian Edwards'); ?><br>
                    <span class="highlight"><?php echo htmlspecialchars($bio['title'] ?? 'skelseed'); ?></span>
                </h1>
                <p class="subtitle"><?php echo htmlspecialchars($bio['subtitle'] ?? 'Desarrollador &'); ?></p>
                <p class="description">
                    <?php echo htmlspecialchars($bio['description'] ?? 'Aficionado a las ciencias de la computación, la electronica y contabilidad. Desarrollador amateur.'); ?>
                </p>
                <div class="btn-group-custom">
                    <a href="#proyectos" class="btn-custom btn-primary-custom">Ver Proyectos</a>
                    <a href="#contacto" class="btn-custom btn-outline-custom">Contactar</a>
                </div>
            </div>
            <div class="hero-visual">
                <div class="hero-circle">
                    <img src="./assets/img/knight_orange.png" alt="Skelseed Mascot">
                </div>
            </div>
        </section>

        <section id="proyectos">
            <h2 class="section-title">// Proyectos</h2>
            <div class="projects-grid">
                <?php if (!empty($projects)): ?>
                <?php foreach ($projects as $project): ?>
                <div class="project-card">
                    <div class="project-icon">&#<?php echo $project['icon']; ?>;</div>
                    <h3><?php echo htmlspecialchars($project['title']); ?></h3>
                    <p><?php echo htmlspecialchars($project['description']); ?></p>
                    <div class="project-tags">
                        <?php foreach (explode(',', $project['tags']) as $tag): ?>
                        <?php if (trim($tag)): ?>
                        <span class="tag"><?php echo htmlspecialchars(trim($tag)); ?></span>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <div class="project-card">
                    <p style="color: var(--text-secondary); text-align: center;">No hay proyectos registrados aún.</p>
                </div>
                <?php endif; ?>
            </div>
        </section>

        <section class="skills-section" id="habilidades">
            <h2 class="section-title">// Skills</h2>
            <div class="skills-grid">
                <?php if (!empty($skills)): ?>
                <?php foreach ($skills as $skill): ?>
                <div class="skill-item">
                    <div class="skill-header">
                        <span><?php echo htmlspecialchars($skill['name']); ?></span>
                        <span style="color: var(--orange-primary);"><?php echo $skill['percentage']; ?>%</span>
                    </div>
                    <div class="skill-bar-bg">
                        <div class="skill-bar-fill" style="width: <?php echo min($skill['percentage'], 100); ?>%;"></div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <div class="skill-item">
                    <p style="color: var(--text-secondary); text-align: center;">No hay habilidades registradas.</p>
                </div>
                <?php endif; ?>
            </div>
        </section>

        <section class="contact-section" id="contacto">
            <h2>// Contacto</h2>
            <a href="mailto:<?php echo htmlspecialchars($bio['email'] ?? 'crazypotato73@aol.com'); ?>" class="contact-email">
                <?php echo htmlspecialchars($bio['email'] ?? 'crazypotato73@aol.com'); ?>
            </a>
        </section>

        <footer class="footer">
            <p>&copy; <?php echo date('Y'); ?> Skelseed | Portfolio Urbano Nocturno</p>
        </footer>
    </div>

    <script src="./assets/bootstrap-5.1.3-dist/js/bootstrap.js"></script>
</body>
</html>