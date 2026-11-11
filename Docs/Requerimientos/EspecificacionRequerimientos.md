# ESPECIFICACIÓN DE REQUERIMIENTOS Y MÓDULOS DEL SISTEMA
## Sistema de Asistencias y Carnetización Digital UNEFA

### OBJETIVO DEL SISTEMA
**Objetivo General:** Desarrollar una solución integral para la gestión académica, carnetización digital con código QR de alta resolución par el control de asistencia estudiantil y docente de la UNEFA, accesible tanto a través de un portal web responsive como de una aplicación móvil nativa, bajo estándares rigurosos de seguridad informática, normalización de datos en Tercera Forma Normal (3FN) y ergonomía visual.

---

## 1. ROLES DE USUARIO Y PERMISOS
El sistema se estructura en 5 roles con permisos claramente delimitados:

### 1. Super Administrador
- Auditoría completa de acciones, intentos de acceso y bitácora.
- Respaldo y mantenimiento de la base de datos.
- Capacidad exclusiva de restablecer la clave secundaria del director.

### 2. Director (Supervisión general de sede)
- Cuenta con Autenticación de Doble Factor (2FA) obligatoria con envió de código de 6 dígitos al correo electrónico institucional para iniciar sesión.
- Clave Secundaria Única para autorizar o modificar sus actividades institucionales, editable por el propio director y por el Superadministrador.
- Supervisión general de la Extensión.
- Visualización de métricas globales de asistencia estudiantil y docente.
- Consulta de reportes ejecutivos en PDF y gráficas de rendimiento.

### 3. Coordinador
- Gestión de periodos académicos (creación, apertura y cierre).
- Administración de carreras, asignaturas, secciones y horarios.
- Asignación de carga horaria a docentes.
- Módulo de carnetización masiva: aprobación de fotos, simulador de carnet y emisión.
- Carga y validación de documentos de estudiantes.

### 4. Docente
- Visualización de su carga académica y horarios semanales.
- Apertura de sesiones de clase para toma de asistencia.
- Generación y visualización del código QR dinámico de aula para escaneo.
- Escaneo directo del QR de estudiantes mediante cámara.
- Registro manual y justificación de inasistencias.
- Generación de actas de asistencia por corte o periodo en PDF.

### 5. Estudiante
- Visualización de su carnet digital oficial con fotografía y código QR dinámico.
- Consulta de su horario de clases, materias inscritas y docentes asignados.
- Registro de asistencia escaneando el QR de la sesión del docente.
- Historial de asistencias e inasistencias por asignatura y porcentaje acumulado.
- Descarga de planilla de inscripción y actualización de foto de perfil.

---

## 2. MÓDULOS DEL SISTEMA

### MÓDULO 1: AUTENTICACIÓN, SESIONES Y SEGURIDAD
- **Login único:** Separacion de interfaces de ingreso en dos: Login para Estudiantes, Login para Personal / Docente. Ingreso por cédula o correo electrónico y contraseña cifrada con `password_hash`, en caso de ser Director solicitar codigo 2FA.
- **Doble Factor (2FA):** Al ingresar usuario y contraseña válidos para el rol director, el servidor genera un código aleatorio de 6 dígitos con 10 minutos de vigencia, lo guarda en la tabla de códigos temporales y lo despacha al correo registrado. Se dispone de una vista limpia para ingresar dicho código antes de expedir la sesión.
- **Protección contra ataques:** Bloqueo por fuerza bruta tras 10 intentos fallidos (ventana de 15 minutos). Tokens CSRF obligatorios en formularios POST de la web. Cierre automático de sesión por inactividad tras 10 minutos.
- **Preguntas de Seguridad:** Validación estricta que admite obligatoriamente entre 4 y 16 caracteres de respuesta (mínimo 4, máximo 16). La regla se valida en el formulario y en el servidor antes de aplicar el algoritmo de hash Bcrypt.
- **Manejo para la App Móvil:** Autenticación mediante token JWT o token de sesión seguro enviado en cabecera `Authorization: Bearer`.
- **Registro:** Solicitud de cuenta para nuevos estudiantes con selección de carrera y semestre inicial.

### MÓDULO 2: CARNETIZACIÓN DIGITAL (WEB Y APP)
- **Plantilla Oficial:** Superposición dinámica de los datos del titular sobre la plantilla oficial de la UNEFA según el rol (Estudiante, Docente, Coordinador, Director, Superadmin).
- **Datos y Exportación:** Foto oficial con recorte interactivo, datos institucionales completos, QR dinámico firmado y descarga en formato PDF de alta resolución listo para credencial física. 

### MÓDULO 3: CONTROL DE ASISTENCIAS MEDIANTE CÓDIGO QR
El módulo opera bajo dos modalidades complementarias:

**Modalidad A (Docente genera QR - Estudiante escanea):**
1. El docente inicia sesión y pulsa en "Iniciar Clase" seleccionando su materia y sección.
2. El sistema crea una sesión de clase en la base de datos con tiempo límite de validez.
3. La pantalla del docente proyecta un QR que contiene el token firmado de la sesión.
4. Los estudiantes abren su app móvil, apuntan la cámara al QR y la asistencia queda registrada inmediatamente.

**Modalidad B (Estudiante muestra QR - Docente escanea):**
1. El estudiante abre su carnet digital en la app móvil.
2. El docente usa el lector de la app o cámara web para escanear el carnet de cada estudiante.
3. El sistema valida la matrícula del estudiante en la sección y marca la presencia.

**Validaciones de Asistencia:**
- Control estricto de no-duplicidad por clase.
- Control de rango de tolerancia.
- Estados permitidos: Presente, Ausente, Justificado, Tardío.
- Registro del método utilizado: QR o Manual.

### MÓDULO 4: GESTIÓN ACADÉMICA Y HORARIOS
- **Periodos Académicos:** Control de fechas de inicio, corte y fin de periodo.
- **Malla Curricular:** Registro de materias, prelaciones y unidades de crédito.
- **Matriz de Horarios:** Asignación visual de aulas, días y bloques de horas por sección.
- **Inscripciones:** Vinculación entre estudiante, sección y periodo académico activo.

### MÓDULO 5: REPORTES, ESTADÍSTICAS Y AUDITORÍA
- **Actas de Asistencia:** Generación en PDF del formato institucional con lista de alumnos, porcentajes de asistencia y firmas del docente y coordinador.
- **Bitácora de Auditoría:** Registro automático de cada acción sensible (creación de usuarios, modificaciones de notas/asistencias, inicios de sesión) con IP, fecha y usuario.
- **Respaldos Automáticos Rutinarios:** Respaldos programado semanalmente que ejecuta un volcado completo de la base de datos (.SQL) en la carpeta protegida backups con sello temporal: backup_unefa_YYYYMMDD_HHMMSS.sql.

---

## 3. TAREAS ASIGNADAS POR DEPARTAMENTO

### DEPARTAMENTO DE FRONTEND (Web y App Móvil)

**1. General**
- Implementar la separación de canales en la pantalla de Login (Pestañas Estudiante y Personal).
- Diseñar la pantalla de ingreso del código temporal 2FA de 6 dígitos.
- Mostrar visiblemente el rol del usuario conectado en la cabecera del sistema.
- Aumentar el tamaño de textos, inputs y botones de navegación, con mayor contraste visual.
- Colocar propiedades minlength='4' y maxlength='16' en las respuestas a preguntas de seguridad.

**2. Portal Web (UnefaWeb):**
- Vistas HTML/CSS adaptadas a Bootstrap.
- Formularios de login, registro y recuperación.
- Dashboards divididos por rol: `student`, `teacher`, `coordinator`, `director`, `superadmin`.
- Módulo de carnetización: visor del carnet y componente de captura de foto.
- Lector QR integrado en el navegador para docentes.

**3. App Móvil (UnefaApp en Expo React Native):**
- Pantallas de bienvenida, login y registro.
- Pantalla principal con el Carnet Digital y botón para desplegar el QR en pantalla completa.
- Escáner QR rápido con cámara del teléfono para registrar asistencia.
- Vista de horarios y materias inscritas.

### DEPARTAMENTO DE BACKEND (PHP y API REST)
**1. Rutas y Controladores:**
- Atender peticiones del portal web y responder endpoints JSON para la app móvil.

**2. Validaciones:**
- Validar longitud de 4 a 16 caracteres en respuestas de seguridad antes de generar el hash.

**3. Respaldo de Database:**
- Programar script de respaldo semanal automático mediante mysqldump.

**4. Inicio de Sesión por Roles:**
- Procesar inicio de sesión diferenciando el canal de acceso (Estudiante o Personal).

**5. Endpoints Principales requeridos:**

| Método | Endpoint | Descripción |
| :--- | :--- | :--- |
| **POST** | `/api/auth/login` | Validar credenciales y devolver datos de usuario + token. |
| **POST** | `/api/auth/verify-2fa` | Verifica el código enviado al correo institucional del Director para completar el inicio de sesión. |
| **PUT** | `/api/users/secondary-key` | Actualiza la Clave Secundaria Única del Director (o gestionada por el Superadmin). |
| **GET** | `/api/student/id-card` | Obtener datos completos para pintar el carnet. |
| **POST** | `/api/attendance/sessions` | Docente abre clase y recibe token de sesión. |
| **POST** | `/api/attendance/records` | Estudiante o docente envía token QR para registrar asistencia. |
| **GET** | `/api/attendance/history` | Lista de asistencias por materia y sección. |
| **GET** | `/api/reports/attendance-pdf` | Descarga del acta oficial en PDF. |

### DEPARTAMENTO DE BASE DE DATOS
1. Mantener el esquema relacional normalizado con las tablas base: `usuarios`, `roles`, `estudiantes`, `docentes`, `carreras`, `materias`, `secciones`, `inscripciones`, `sesiones_clase`, `asistencia`, `auditoria`, `periodos_academicos`.
2. Crear la tabla dedicada para códigos temporales `two_factor_code` con: `id`, `user_id`, `code` (VARCHAR 10), `type` (ENUM '2FA_Login', 'Recovery'), `expires_at` (DATETIME), `is_used` (BOOLEAN).
3. Proporcionar la tabla de equivalencias a los desarrolladores.
4. Crear índices en campos críticos de búsqueda.
5. Agregar en `user_account` el campo para la clave secundaria del Director `director_security_pin`.
6. Mantener el campo `answer_hash` en VARCHAR(255) para almacenar el hash seguro.
7. Incorporar `career_id` en la tabla `profile` con clave foranea a career(id).
8. Incluir usuario administrador inicial en el archivo SQL para arranque del sistema.

### DEPARTAMENTO DE DOCUMENTACIÓN
1. Mantener este documento actualizado según los avances de cada entrega.
2. Elaborar los diagramas de casos de uso y entidad-relación.
3. Actualizar el diccionario de datos con la nueva tabla de códigos temporales y campos adicionales.
4. Levantar los diagramas de casos de uso y modelo entidad-relación reflejando el flujo de 2FA y asistencia.
5. Redactar el manual de usuario para el docente y estudiante.