# Uso de la Inteligencia Artificial en este proyecto

La IA utilizada es Deepseek, la cual tuvo la mayor parte de participación en el proyecto, requerido por el curso.
[DeepSeek](https://chat.deepseek.com)

También se utilizó Kimi.ai para integraciones adicionales.

## 1. Generación del README.md

Se solicitó a una IA (DeepSeek) la creación de un archivo `README.md` para un gestor de tareas con JavaScript y tabla Kanban. La IA generó una estructura inicial que incluía:

- Título del proyecto con enlace a requerimientos
- Lista de funcionalidades (crear tareas con prioridad, columnas Pendientes/En Proceso/Completadas)
- Tecnologías utilizadas (HTML, CSS, JS, Drag & Drop API, localStorage)
- Instrucciones de uso y estructura de carpetas
- Mejoras futuras sugeridas

Prompt utilizado:  
> *"generame un simple README.md para un sitio con js gestor de tareas siguiendo esta estructura: [estructura proporcionada]"*

## 2. Generación del gestor de tareas

Solicité a la IA que tomara la estructura base del formulario y me generara un tablero kanban funcional usando javascript. La IA generó un sitio funcional conservando mis avances en la estructura HTML e ícono.

Prompt utilizado:
> *"Analiza [estructura html] y generame un tablero kanban funcional"*

## 3. Generación del estilo CSS

Usé la misma estructura para generar un css, cambiando variables del HTML para que pueda asignar un estilo conforme a los requerimientos de este examen.
La IA respetó las peticiones de estilo y me generó el resultado final.

Prompt utilizado:
> *"Genera un css aplicable a este sitio, si es necesario remplaza tags HTML pero no toques las clases ya establecidas. Tomate el tiempo que sea necesario: "[código HTML]""*

## 4. Generación del portfolio

El sitio comenzó con un prompt que definió toda la estética de mi portfolio.

Prompt utilizado:
> *"Necesito que generes código html con css embebido para un portfolio, tiene que tener estética con colores negro y naranja como los sonic erikson walman, y un fondo urbano como el dashboard de noche de xbox 360"*

Naturalmente luego separé el código css por separado, pero consideré que la plantilla entregada fue realmente linda.

## 5. Integraciones con Kimi.ai

Luego le pedí a Kimi.ai que:
- Integrara de fondo una imagen que tengo preparada de antemano con la misma estética del sitio entregado por Deepseek
- Integrara Bootstrap por medio de la etiqueta link y la url de bootstrap (pienso en dejarlo como archivo para que se ejecute de manera local)

Prompt utilizado:
> *"Pon el fondo en el sitio, e integra Bootstrap en el código. Además, agrega un botón de login en la esquina superior derecha, este se va a tratar de un portfolio 'autoadministrable'"*

## 6. Estado actual del proyecto

Ahora queda hacerlo autoadministrable integrando un login por PHP y rellenar la plantilla con información necesaria, borrando puntos si es necesario.

Un snippet de la plantilla entregada por Deepseek está disponible en la carpeta `docs` de este proyecto.