# ESPECIFICACIÓN DE REQUERIMIENTOS Y MÓDULOS DEL SISTEMA
## Sistema de Asistencias y Carnetización Digital UNEFA

### OBJETIVO DEL SISTEMA
**Objetivo General:** Desarrollar una solución integral para la gestión académica, carnetización digital con código QR único y permanente para el control de asistencia estudiantil y docente de la UNEFA, accesible tanto a través de un portal web institucional desarrollado en **Laravel 11 con vistas Blade** como de una aplicación móvil nativa en **Expo React Native**, bajo estándares rigurosos de seguridad informática, normalización de datos en Tercera Forma Normal (3FN), arquitectura basada en las directrices del 21/11/2026 y ergonomía visual.

---

## 1. ROLES DE USUARIO Y PERMISOS
El sistema se estructura en 5 roles jerárquicos con permisos claramente delimitados, admitiendo **múltiples roles simultáneos por usuario** (ej. Estudiante y Docente/Preparador) con asignación de **un carnet independiente con número de credencial y vigencia propia por cada rol activo**:

### 1. Super Administrador
- Auditoría completa de acciones, intentos de acceso y bitácora del sistema.
- Respaldo y mantenimiento de la base de datos mediante tareas programadas.
- Capacidad exclusiva de restablecer la clave secundaria única del Director.
- Carnet digital y físico oficial de Super Administrador con QR permanente.

### 2. Director (Supervisión general de sede)
- Cuenta con Autenticación de Doble Factor (2FA) obligatoria con envío de código OTP de 6 dígitos al correo electrónico institucional para iniciar sesión.
- Clave Secundaria Única (`security_pin_hash`) para autorizar o modificar actividades institucionales críticas, gestionable por el Director y restablecible por el Superadministrador.
- Supervisión general de la Extensión y visualización de métricas globales de asistencia estudiantil y docente.
- Consulta de reportes ejecutivos en PDF y gráficas de rendimiento institucional.
- Carnet digital oficial de Director con QR permanente.

### 3. Coordinador
- Gestión de periodos académicos (creación, apertura y cierre de ciclos de 16 semanas).
- Administración de carreras, asignaturas, secciones, aulas y horarios.
- Asignación de carga horaria a docentes titulares.
- Módulo de carnetización masiva: aprobación de fotos oficiales, simulador de carnet y emisión de credenciales por rol con serial único.
- Carga, revisión y validación de expedientes de estudiantes en el módulo de documentos.
- Carnet digital oficial de Coordinador con QR permanente.

### 4. Docente
- Visualización de su carga académica y horarios semanales asignados.
- Apertura de sesiones de clase semanales para pase de lista presencial.
- Escaneo directo del código QR único y permanente del carnet del estudiante mediante cámara web o móvil.
- Registro manual y justificación documentada de inasistencias o retardos.
- Generación de actas oficiales de asistencia por corte o período en formato PDF.
- Carnet digital oficial de Docente con QR permanente.

### 5. Estudiante
- Visualización de su carnet digital oficial con fotografía institucional y código QR único y permanente para toda su carrera.
- Consulta de su horario de clases, asignaturas matriculadas y docentes asignados.
- Registro de asistencia en clase mediante la presentación de su carnet QR permanente (o escaneo de sesión en modalidad bidireccional).
- Historial de asistencias e inasistencias por asignatura y porcentaje acumulado por corte.
- Descarga de planilla de inscripción, actualización de foto de perfil y alertas sobre materias arrastradas.

---

## 2. MÓDULOS DEL SISTEMA

### MÓDULO 1: AUTENTICACIÓN, SESIONES Y SEGURIDAD
- **Portal Institucional y Login Separado:** Sustitución formal del término "SICEU" por la denominación oficial **"Portal"**. Separación de interfaces de ingreso en dos canales diferenciados: **Login para Estudiantes** (ingreso por Cédula o Correo y Contraseña) y **Login para Personal / Docente** (con solicitud de código 2FA de 6 dígitos en caso de Director).
- **Doble Factor (2FA):** Al ingresar usuario y contraseña válidos para el rol Director, el servidor genera un código aleatorio de 6 dígitos con 10 minutos de vigencia, lo guarda en la tabla `verification_code` y lo despacha al correo institucional registrado. Se dispone de una vista limpia en Blade para ingresar dicho código antes de expedir la sesión.
- **Clave Secundaria Única:** PIN de seguridad cifrado (`security_pin_hash`) en `user_account` requerido al Director para autorizar cambios sensibles (asignar coordinadores, validar periodos).
- **Protección contra ataques:** Bloqueo por fuerza bruta tras 10 intentos fallidos en una ventana de 15 minutos registrado en `failed_attempt`. Tokens CSRF obligatorios provistos por Laravel en todos los formularios POST de Blade. Cierre automático de sesión por inactividad tras 10 minutos.
- **Preguntas de Seguridad:** Validación estricta que admite obligatoriamente entre 4 y 16 caracteres de respuesta (mínimo 4, máximo 16). La regla se valida en el formulario y en el servidor antes de aplicar el algoritmo de hash Bcrypt.
- **Manejo para la App Móvil:** Autenticación mediante tokens de sesión segura enviados en la cabecera HTTP `Authorization: Bearer` consumiendo la API REST de Laravel 11.
- **Registro Convencional de Usuarios:** Creación institucional directa de cuenta universitaria con selección de programa académico, datos civiles y carga de recaudos, reemplazando el esquema de preinscripción CINU. Asignación inmediata del `qr_token` permanente en `user_account`.

### MÓDULO 2: CARNETIZACIÓN DIGITAL (WEB Y APP)
- **Plantilla Oficial UNEFA:** Superposición dinámica de los datos del titular sobre la plantilla oficial reglamentaria de la UNEFA según el rol activo seleccionado (Estudiante, Docente, Coordinador, Director, Superadmin).
- **Múltiples Carnets por Persona:** Soporte para emisión de carnets independientes por cada rol activo asignado en `user_role`, cada uno con su propio serial de credencial (`credential_number`), fecha de emisión y fecha de caducidad.
- **Código QR Único y Permanente:** El código QR de la credencial es generado a partir del campo `user_account.qr_token`, manteniéndose fijo e inmutable para toda la carrera universitaria del titular (sin tablas separadas de códigos temporales).
- **Datos y Exportación:** Fotografía oficial con recorte interactivo, datos institucionales completos, QR permanente y descarga en formato PDF vectorial de alta resolución listo para plastificación física.

### MÓDULO 3: CONTROL DE ASISTENCIAS MEDIANTE CÓDIGO QR
El módulo opera mediante el **código QR único y permanente** de cada usuario bajo dos modalidades complementarias:

**Modalidad A (Docente escanea QR permanente del Estudiante - Principal):**
1. El docente inicia sesión en el Portal Web (Blade) o App Móvil y pulsa en "Abrir Clase", seleccionando su materia, sección y registrando la semana lectiva (`week_number`) y minutos de tolerancia en `class_session`.
2. El estudiante presenta su carnet digital en la app o su credencial física con su QR permanente.
3. El docente usa el lector de la app o cámara web para escanear el QR del carnet; el sistema valida la matrícula activa en la sección y registra la asistencia inmediatamente en `attendance` (`registration_method = 'QR'`).

**Modalidad B (Docente proyecta QR de sesión - Estudiante escanea):**
1. El docente proyecta la pantalla de la sesión abierta con el identificador de la clase.
2. Los estudiantes abren la app móvil, escanean el código de la sesión y la presencia queda asentada.

**Validaciones de Asistencia:**
- Control estricto de no-duplicidad por sesión mediante la restricción única relacional `uniq_session_student (session_id, student_id)`.
- Control de rango de tolerancia con tipificación automática de Retardo (`Late`) transcurrido el tiempo límite.
- Estados permitidos: Presente (`Present`), Ausente (`Absent`), Justificado (`Excused`), Tardío (`Late`).
- Registro del método utilizado: `QR` o `Manual` (con observaciones del docente en caso de contingencia).

### MÓDULO 4: GESTIÓN ACADÉMICA Y HORARIOS
- **Periodos Académicos:** Control de fechas de inicio, corte y fin de período en `academic_period` con duración estándar de 16 semanas lectivas.
- **Malla Curricular y Prelaciones:** Registro de asignaturas (`subject`), unidades de crédito, semestre y matriz relacional de prerrequisitos en `course_prerequisite`.
- **Control de Materias Arrastradas (Regla Estricta de Bloqueo):** Si un estudiante reprueba una asignatura (`section_enrollment.status = 'Failed'` o `is_dragged = true`), se activa la bandera `profile.has_dragged_subjects = true`. El sistema **bloquea de forma inmediata su avance formal de semestre (`current_semester + 1`)** y restringe la inscripción de materias superiores hasta que repita y apruebe la materia adeudada.
- **Matriz de Horarios:** Asignación visual de aulas, días de la semana y bloques de horas por sección en `section`.
- **Inscripciones:** Vinculación formal entre estudiante, sección y período académico activo en `section_enrollment`.

### MÓDULO 5: REPORTES, ESTADÍSTICAS Y AUDITORÍA
- **Actas de Asistencia Oficiales:** Generación automatizada en PDF institucional con lista de alumnos, porcentajes de asistencia y firmas digitales del docente y coordinador.
- **Bitácora de Auditoría:** Registro automático de cada acción sensible (inicios de sesión, modificaciones de notas/asistencias, emisión de carnets) en `audit_log` con IP (IPv4/IPv6), fecha y usuario.
- **Respaldos Automáticos Rutinarios:** Tarea programada semanalmente mediante Laravel Console / Artisan que ejecuta un volcado completo de la base de datos (.SQL) en `storage/app/backups/backup_unefa_YYYYMMDD_HHMMSS.sql`.
- **Cronograma de Evaluación (Hito Semana 8):** Incorporación en el calendario de la evaluación conjunta del **1er y 2do corte en la Semana 8** del período lectivo (iniciando la semana 7 el 22/11/2026), gestionada a través de `academic_period`, `calendar_event` y `class_session` (`week_number`).

---

## 3. TAREAS ASIGNADAS POR DEPARTAMENTO

### DEPARTAMENTO DE FRONTEND (Web y App Móvil)

**1. General**
- Implementar la separación de canales en la pantalla de Login (Pestañas **Estudiante** y **Personal**).
- Homologar la nomenclatura institucional utilizando el término **"Portal"** en reemplazo del antiguo "SICEU".
- Diseñar la pantalla de ingreso del código temporal 2FA de 6 dígitos para el rol Director.
- Permitir la selección y visualización de carnets diferenciados para usuarios con múltiples roles activos.
- Colocar propiedades `minlength='4'` y `maxlength='16'` en las respuestas a preguntas de seguridad.

**2. Portal Web (Laravel con Vistas Blade):**
- Vistas Blade estructuradas mediante layouts maestros (`layouts/public.blade.php`, `layouts/dashboard.blade.php`, `partials/header.blade.php`, `partials/footer.blade.php`).
- Formularios de autenticación en Blade: `auth/login.blade.php` con pestañas duales y `auth/registro.blade.php` con wizard multi-paso de cuenta convencional.
- Dashboards en Blade segregados por rol: `student.blade.php`, `teacher.blade.php`, `coordinator.blade.php`, `director.blade.php`.
- Módulo de carnetización en Blade: selector de carnet por rol activo, visor oficial con renderizado de QR permanente y descarga en PDF.
- Lector QR integrado en el navegador para pase de lista presencial por parte del docente.

**3. App Móvil (UnefaApp en Expo React Native):**
- Pantallas de bienvenida, login con pestañas Estudiante/Personal y registro de cuenta convencional.
- Pantalla principal con el Carnet Digital oficial y botón para desplegar el QR permanente en pantalla completa.
- Conmutador de credencial para alternar entre carnets en usuarios con múltiples roles (ej. Estudiante y Preparador).
- Escáner QR rápido con cámara del teléfono para registrar asistencia en aula.
- Vista de horarios y materias inscritas, reflejando el estado de materias arrastradas y avisos de bloqueo.

### DEPARTAMENTO DE BACKEND (Laravel 11 PHP y API REST)

**1. Rutas y Controladores:**
- Atender peticiones web mediante rutas en `routes/web.php` resolviendo vistas Blade y exponer endpoints JSON en `routes/api.php` para la app móvil.
- Implementar controladores de autenticación con separación de canales (Estudiante y Personal) y verificación 2FA para Directores vía `verification_code`.
- Controladores para apertura de sesiones de clase (`class_session`) y pase de lista mediante escaneo del QR permanente (`attendance`).
- Controladores académicos con validación de bloqueo de avance de semestre ante materias reprobadas (`has_dragged_subjects = true`).

**2. Validaciones:**
- FormRequests de Laravel para validar inputs de registro, respuestas de seguridad (longitud estricta de 4 a 16 caracteres) y asignaciones docentes.

**3. Respaldo de Database:**
- Programar script o comando Artisan en `routes/console.php` para ejecución semanal de respaldo automático mediante mysqldump en `storage/app/backups/`.

**4. Inicio de Sesión por Roles:**
- Procesar inicio de sesión diferenciando el canal de acceso (Estudiante o Personal), derivando los roles activos de `user_role` y solicitando 2FA en caso de rol Director.

**5. Endpoints Principales requeridos:**

| Método | Endpoint | Descripción |
| :--- | :--- | :--- |
| **POST** | `/api/auth/login` | Validar credenciales con separación de canal (Estudiante/Personal) y devolver token Bearer + perfil. |
| **POST** | `/api/auth/verify-2fa` | Verifica el código OTP de 6 dígitos enviado al correo del Director para completar el inicio de sesión. |
| **POST** | `/api/auth/register` | Registro de nueva cuenta universitaria convencional con asignación de `qr_token` permanente. |
| **PUT** | `/api/users/security-pin` | Actualiza la Clave Secundaria Única del Director (o restablecida por el Superadmin). |
| **GET** | `/api/credentials/my-cards` | Obtener listado de carnets emitidos para los roles activos del usuario. |
| **GET** | `/api/student/id-card` | Obtener datos completos y token QR permanente para renderizar el carnet oficial. |
| **POST** | `/api/attendance/sessions` | Docente abre sesión de clase semanal (`week_number`, tolerancia) en `class_session`. |
| **POST** | `/api/attendance/scan` | Registrar asistencia en clase escaneando el QR permanente del carnet del estudiante. |
| **POST** | `/api/attendance/manual` | Asentar o justificar asistencia manualmente por parte del docente con observaciones. |
| **GET** | `/api/attendance/history` | Lista y porcentaje de asistencias acumuladas por materia y sección. |
| **GET** | `/api/reports/attendance-pdf` | Descarga del acta oficial de asistencia del corte en formato PDF. |

### DEPARTAMENTO DE BASE DE DATOS
1. Mantener y administrar el esquema relacional normalizado en 3FN estructurado en 22 tablas en las migraciones de Laravel (`database/migrations/`).
2. Garantizar que `user_account.qr_token` permanezca como identificador único y permanente por usuario, sin tablas auxiliares de QR temporal.
3. Mantener la tabla asociativa `user_role` con los campos `credential_number`, `credential_issued_at` y `credential_expires_at` para la emisión independiente de carnets por rol.
4. Mantener la tabla `verification_code` para códigos OTP temporales (`2FA_Login`, `Password_Reset`) y el campo `security_pin_hash` en `user_account` para la clave secundaria del Director.
5. Preservar los índices de rendimiento y validación crítica (`idx_profile_semester`, `idx_enrollment_dragged`, `uniq_session_student`, `idx_vc_lookup`).
6. Mantener sincronizado el script DDL maestro [database/schema.sql](../../database/schema.sql) y el seeder inicial idempotente [UnefaInitialDataSeeder.php](../../database/seeders/UnefaInitialDataSeeder.php).

### DEPARTAMENTO DE DOCUMENTACIÓN
1. Mantener este documento y la [documentación de base de datos](../Base%20de%20datos/documentacion-base-de-datos.md) sincronizados con la rama `develop` y las directrices del 21/11/2026.
2. Elaborar y actualizar los diagramas de casos de uso y entidad-relación reflejando el QR permanente, múltiples carnets y el bloqueo por materias arrastradas.
3. Consignar manuales de usuario y evidencias técnicas requeridas para la **evaluación sumativa de cortes 1 y 2 en la Semana 8**.