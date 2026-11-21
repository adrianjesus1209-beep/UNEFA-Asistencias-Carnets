# Portal UNEFA (UnefaWeb)

Frontend del Sistema Integral de Asistencias y Carnetizacion Digital, migrado
desde la aplicacion movil `UnefaApp` (Expo/React Native) hacia vistas Blade
adaptadas a escritorio. Las 4 vistas reales de la app tienen equivalencia
directa aqui: landing, login, registro y dashboard multi-rol (una vista por
rol: estudiante, profesor, coordinador y director).

## Estructura

- `resources/views/layouts/`: plantillas base (publico y dashboard).
- `resources/views/partials/`: header, footer, modal QR, selector de entidad,
  banner de sesion y iconos SVG embebidos (lucide, sin CDNs).
- `resources/views/landing/`: landing con 5 secciones (inicio, doctrina,
  carreras, admisiones, servicios).
- `resources/views/auth/`: login SICEU y preinscripcion CINU (wizard 3 pasos).
- `resources/views/dashboard/`: student, teacher, coordinator y director.
- `routes/web.php`: rutas estilo Laravel para el router propio del backend.
- `resources/css/app.css`: directivas Tailwind y ajustes base.
- `public/css/app.css`: CSS compilado (comprometido al repo, sin CDN).
- `tools/preview/`: motor de vista previa Blade (illuminate/view, sin Laravel completo).
- `public/js/`: vanilla JS minimo (cajon de menu, modal QR, tabs, wizard,
  validaciones y flujo simulado de login).
- `public/assets/`: medios existentes (img, video, PDFs, carnet, uploads) y
  las imagenes descargadas de la app en `img/unefaapp/`.

## Compilar el CSS

El CSS compilado esta en el repo, asi que el sitio funciona sin Node. Para
regenerarlo tras editar clases o vistas:

```
npm install   (una sola vez)
npm run build:css      compilacion unica
npm run watch:css      modo observacion durante el desarrollo
```

## Vista previa sin Laravel

Las vistas se pueden revisar en el navegador con el compilador real de
Blade (illuminate/view) sin instalar el framework completo:

```
cd tools/preview
composer install      (una sola vez)
```

Luego, desde la raiz de `UnefaWeb`:

- Windows: `iniciar-vista-previa.bat`
- Linux/macOS: `./iniciar-vista-previa.sh`

Abre http://127.0.0.1:8099 y se redirige a `/landing`. Estan disponibles
las 7 vistas del mapa de rutas (`/landing`, `/login`, `/registro` y
`/dashboard/estudiante|profesor|coordinador|director`), los archivos de
`public/` se sirven con sus tipos MIME correctos y al guardar cualquier
`.blade.php` la pagina se recarga sola. Detener con `Ctrl+C`.

## Vistas y rutas

| Ruta | Vista Blade | Origen en UnefaApp |
| --- | --- | --- |
| `/` (redirect) | - | - |
| `/landing` | `landing/index` | `src/app/landing.tsx` + `src/constants/data.ts` |
| `/login` | `auth/login` | `src/app/login.tsx` |
| `/registro` | `auth/registro` | `src/app/registro.tsx` |
| `/dashboard/estudiante` | `dashboard/student` | `src/app/dashboard.tsx` (rol estudiante) |
| `/dashboard/profesor` | `dashboard/teacher` | `src/app/dashboard.tsx` (rol profesor) |
| `/dashboard/coordinador` | `dashboard/coordinator` | `src/app/dashboard.tsx` (rol coordinador) |
| `/dashboard/director` | `dashboard/director` | `src/app/dashboard.tsx` (rol director) |

Las vistas antiguas de `app/views/` se eliminaron: no tenian equivalente en
`UnefaApp` y el contenido vigente es el migrado.

## Notas de integracion con el backend

- Los datos de sesion, asignaturas y metricas son mock en HTML (los mismos
  valores de `ROLES_DATA` de la app); el backend los reemplazara al derivar
  el rol de la sesion real.
- Los formularios de login y registro usan `action="#"` con comentarios
  `TODO(backend)` en el punto de conexion (POST /login, POST /registro).
- El modal de QR es una interfaz de prueba: la camara no se activara hasta
  integrar el lector real con el backend.
- Los botones de simulacion por rol (login) y el selector de entidad
  (dashboards) desapareceran al activar la autenticacion.
