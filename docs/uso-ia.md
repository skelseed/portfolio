# Uso de la Inteligencia Artificial en este proyecto

La IA utilizada es Deepseek e Kimi, las cuales tuvieron la mayor parte de participación en el proyecto, requerido por el curso.
Kimi para IA agentica.
[DeepSeek](https://chat.deepseek.com)[Kimi](https://www.kimi.com)

## 1. Generación del README.md

Se solicitó a una IA (DeepSeek) la creación de un archivo `README.md` para un gestor de tareas con JavaScript y tabla Kanban. La IA generó una estructura inicial que incluía:

- Título del proyecto con enlace a requerimientos
- Lista de funcionalidades (crear tareas con prioridad, columnas Pendientes/En Proceso/Completadas)
- Tecnologías utilizadas (HTML, CSS, JS, Drag & Drop API, localStorage)
- Instrucciones de uso y estructura de carpetas
- Mejoras futuras sugeridas

Prompt utilizado:  
> *"generame un simple README.md para un sitio con js gestor de tareas siguiendo esta estructura: [estructura proporcionada]"*

## 2. Generación del portfolio

El sitio comenzó con un prompt que definió toda la estética de mi portfolio.

Prompt utilizado:
> *"Necesito que generes código html con css embebido para un portfolio, tiene que tener estética con colores negro y naranja como los sonic erikson walman, y un fondo urbano como el dashboard de noche de xbox 360"*

Naturalmente luego separé el código css por separado, pero consideré que la plantilla entregada fue realmente linda.

## 3. Imagen de fondo y Bootstrap para Login

Luego le pedí a Kimi.ai que:
- Integrara de fondo una imagen que tengo preparada de antemano con la misma estética del sitio entregado por Deepseek
- Integrara Bootstrap por medio de la etiqueta link y la url de bootstrap (pienso en dejarlo como archivo para que se ejecute de manera local)

Prompt utilizado:
> *"Pon el fondo en el sitio, e integra Bootstrap en el código. Además, agrega un botón de login en la esquina superior derecha, este se va a tratar de un portfolio autoadministrable"*

## 4. Informacion y datos

Ahora queda hacerlo autoadministrable integrando un login por PHP y rellenar la plantilla con información necesaria, borrando puntos si es necesario.

Un snippet de la plantilla entregada por Deepseek está disponible en la carpeta `docs` de este proyecto.

## 5. Code Dashboard PHP

Decidí usar la IA agentica gratuita de kimi, para la generación del código PHP para los distintos módulos de login y CRUD
Lo bueno es que ya poseía un formulario login hecho con Bootstrap

para eso usé el siguente prompt:

> *"ahora integra funcionalidad login por php, dame uno o mas archivos php de ser necesario"*

## ANEXO 1: Procrastinación y Logos

Mientras la IA agentica pensaba, decidí crear un logo lindo para mi página usando GIMP.
Tenía planeado usar un simple rombo naranjo, ya que le da a la estetica.

## 5.1. Resultado del Dashboard

Resulta que Kimi generó todo
aqui su output:

¡Listo! El sistema de portfolio autoadministrable con PHP está completo. Aquí tienes todo el resumen:
📦 Archivos creados (13 archivos + assets)
| Archivo                  | Descripción                                                   |
| ------------------------ | ------------------------------------------------------------- |
| `index.php`              | Portfolio público — lee todo de la base de datos              |
| `login.php`              | Página de login con validación real                           |
| `logout.php`             | Cierre de sesión seguro                                       |
| `dashboard.php`          | Panel principal con estadísticas y accesos rápidos            |
| `admin_bio.php`          | CRUD de Biografía (nombre, título, descripción, email, badge) |
| `admin_skills.php`       | CRUD de Habilidades con barras de progreso                    |
| `admin_tech.php`         | CRUD de Tecnologías con selector de iconos Bootstrap          |
| `admin_projects.php`     | CRUD de Proyectos con selector de emojis y tags               |
| `config.php`             | Configuración global y rutas                                  |
| `database.php`           | Inicialización automática de SQLite + datos de ejemplo        |
| `auth.php`               | Funciones de autenticación (`login`, `logout`, `requireAuth`) |
| `assets/euHDM2Xg_4x.jpg` | Imagen de fondo urbano nocturno                               |
| `README.md`              | Guía de instalación completa                                  |
...

