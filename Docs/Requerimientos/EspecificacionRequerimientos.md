# ESPECIFICACIÓN DE REQUERIMIENTOS Y MÓDULOS DEL SISTEMA
## Sistema de Asistencias y Carnetización Digital UNEFA

### OBJETIVO DEL SISTEMA
**Objetivo General:** Desarrollar una solución integral para la gestión académica, carnetización digital y control de asistencia estudiantil y docente de la UNEFA mediante códigos QR dinámicos y seguros, accesible tanto vía portal web responsive como a través de una aplicación móvil nativa.

---

## 1. ROLES DE USUARIO Y PERMISOS
El sistema se estructura en 5 roles con permisos claramente delimitados:

### 1. Super Administrador
* Acceso total al sistema.
* Gestión de usuarios y asignación de roles.
* Auditoría completa de acciones, intentos de acceso y bitácora.
* Respaldo y mantenimiento de la base de datos.

### 2. Director
* Supervisión general de la sede o núcleo.
* Visualización de métricas globales de asistencia estudiantil y docente.
* Consulta de reportes ejecutivos en PDF y gráficas de rendimiento.

### 3. Coordinador
* Gestión de periodos académicos (creación, apertura y cierre).
* Administración de carreras, asignaturas, secciones y horarios.
* Asignación de carga horaria a docentes.
* Módulo de carnetización masiva: aprobación de fotos, simulador de carnet y emisión.
* Carga y validación de documentos de estudiantes.

### 4. Docente
* Visualización de su carga académica y horarios semanales.
* Apertura de sesiones de clase para toma de asistencia.
* Generación y visualización del código QR de sesión para escaneo.
* Escaneo directo del QR de estudiantes mediante cámara.
* Registro manual y justificación de inasistencias.
* Generación de actas de asistencia por corte o periodo en PDF.

### 5. Estudiante
* Visualización de su carnet digital oficial con fotografía y código QR personal.
* Consulta de su horario de clases, materias inscritas y docentes asignados.
* Registro de asistencia escaneando el QR de la sesión del docente.
* Historial de asistencias e inasistencias por asignatura y porcentaje acumulado.
* Descarga de planilla de inscripción y actualización de foto de perfil.

---

## 2. MÓDULOS DEL SISTEMA

### MÓDULO 1: AUTENTICACIÓN, SESIONES Y SEGURIDAD
* **Login único:** Ingreso por cédula o correo electrónico y contraseña cifrada con `password_hash`.
* **Protección contra ataques:** Bloqueo por fuerza bruta tras 10 intentos fallidos (ventana de 15 minutos). Tokens CSRF obligatorios en formularios POST de la web. Cierre automático de sesión por inactividad tras 10 minutos.
* **Manejo para la App Móvil:** Autenticación mediante token JWT o token de sesión seguro enviado en cabecera `Authorization: Bearer`.
* **Registro:** Solicitud de cuenta para nuevos estudiantes con selección de carrera y semestre inicial.

### MÓDULO 2: CARNETIZACIÓN DIGITAL (WEB Y APP)
* **Plantilla Oficial:** Superposición dinámica de los datos del titular sobre la plantilla oficial de la UNEFA según el rol (Estudiante, Docente, Coordinador, Director, Superadmin).
* **Elementos del Carnet:** Nombres y Apellidos, Cédula de Identidad, Carrera o Departamento de adscripción, Rol / Condición, Periodo Académico de vigencia, Fotografía oficial en fondo blanco (recortable desde la web o app), y Código QR de alta resolución.
* **Simulador y Exportación:** Vista previa en tiempo real antes de imprimir y descarga en formato PDF de alta calidad listo para credencial física.

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
* Control de duplicidad: un estudiante no puede marcar dos veces la misma clase.
* Estados permitidos: Presente, Ausente, Justificado, Tardío.
* Registro del método utilizado: QR o Manual.

### MÓDULO 4: GESTIÓN ACADÉMICA Y HORARIOS
* **Periodos Académicos:** Control de fechas de inicio, corte y fin de periodo.
* **Malla Curricular:** Registro de materias, prelaciones y unidades de crédito.
* **Matriz de Horarios:** Asignación visual de aulas, días y bloques de horas por sección.
* **Inscripciones:** Vinculación entre estudiante, sección y periodo académico activo.

### MÓDULO 5: REPORTES, ESTADÍSTICAS Y AUDITORÍA
* **Actas de Asistencia:** Generación en PDF del formato institucional con lista de alumnos, porcentajes de asistencia y firmas del docente y coordinador.
* **Bitácora de Auditoría:** Registro automático de cada acción sensible (creación de usuarios, modificaciones de notas/asistencias, inicios de sesión) con IP, fecha y usuario.

---

## 3. DIVISIÓN DE RESPONSABILIDADES POR EQUIPO

### DEPARTAMENTO DE FRONTEND (Web y App Móvil)
**1. Portal Web (UnefaWeb):**
* Vistas HTML/CSS adaptadas a Bootstrap.
* Formularios de login, registro y recuperación.
* Dashboards divididos por rol: `student`, `teacher`, `coordinator`, `director`, `superadmin`.
* Módulo de carnetización: visor del carnet y componente de captura de foto.
* Lector QR integrado en el navegador para docentes.

**2. App Móvil (UnefaApp en Expo React Native):**
* Pantallas de bienvenida, login y registro.
* Pantalla principal con el Carnet Digital y botón para desplegar el QR en pantalla completa.
* Escáner QR rápido con cámara del teléfono para registrar asistencia.
* Vista de horarios y materias inscritas.

### DEPARTAMENTO DE BACKEND (PHP y API REST)
**1. Rutas y Controladores:**
* Atender peticiones del portal web y responder endpoints JSON para la app móvil.

**2. Endpoints Principales requeridos:**

| Método | Endpoint | Descripción |
| :--- | :--- | :--- |
| **POST** | `/api/auth/login` | Validar credenciales y devolver datos de usuario + token. |
| **GET** | `/api/student/carnet` | Obtener datos completos para pintar el carnet. |
| **POST** | `/api/asistencia/iniciar-sesion` | Docente abre clase y recibe token de sesión. |
| **POST** | `/api/asistencia/marcar` | Estudiante o docente envía token QR para registrar asistencia. |
| **GET** | `/api/asistencia/historial` | Lista de asistencias por materia y sección. |
| **GET** | `/api/reportes/asistencia-pdf` | Descarga del acta oficial en PDF. |

### DEPARTAMENTO DE BASE DE DATOS
1. Mantener el esquema relacional normalizado con las tablas base: `usuarios`, `roles`, `estudiantes`, `docentes`, `carreras`, `materias`, `secciones`, `inscripciones`, `sesiones_clase`, `asistencia`, `auditoria`, `periodos_academicos`.
2. Proporcionar la tabla de equivalencias a los desarrolladores.
3. Crear índices en campos críticos de búsqueda (`cedula`, `codigo_qr`, `id_seccion`, `fecha`).

### DEPARTAMENTO DE DOCUMENTACIÓN
1. Mantener este documento actualizado según los avances de cada entrega.
2. Elaborar los diagramas de casos de uso y entidad-relación.
3. Redactar el manual de usuario para el docente y estudiante.