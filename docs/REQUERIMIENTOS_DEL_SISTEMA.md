# ESPECIFICACION DE REQUERIMIENTOS Y MODULOS DEL SISTEMA
## SISTEMA DE ASISTENCIAS Y CARNETIZACION DIGITAL UNEFA

---

### OBJETIVO DEL SISTEMA
Desarrollar una solucion integral para la gestion academica, carnetizacion digital y control de asistencia estudiantil y docente de la UNEFA mediante codigos QR dinamicos y seguros, accesible tanto via portal web responsive como a traves de una aplicacion movil nativa.

---

### 1. ROLES DE USUARIO Y PERMISOS

El sistema se estructura en 5 roles con permisos claramente delimitados:

1. **Super Administrador**
   - Acceso total al sistema.
   - Gestion de usuarios y asignacion de roles.
   - Auditoria completa de acciones, intentos de acceso y bitacora.
   - Respaldo y mantenimiento de la base de datos.

2. **Director**
   - Supervision general de la sede / nucleo.
   - Visualizacion de metricas globales de asistencia estudiantil y docente.
   - Consulta de reportes ejecutivos en PDF y graficas de rendimiento.

3. **Coordinador**
   - Gestion de periodos academicos (creacion, apertura y cierre).
   - Administracion de carreras, asignaturas, secciones y horarios.
   - Asignacion de carga horaria a docentes.
   - Modulo de carnetizacion masiva: aprobacion de fotos, simulador de carnet y emision.
   - Carga y validacion de documentos de estudiantes.

4. **Docente**
   - Visualizacion de su carga academica y horarios semanales.
   - Apertura de sesiones de clase para toma de asistencia.
   - Generacion y visualizacion del codigo QR de sesion para escaneo.
   - Escaneo directo del QR de estudiantes mediante camara.
   - Registro manual y justificacion de inasistencias.
   - Generacion de actas de asistencia por corte o periodo en PDF.

5. **Estudiante**
   - Visualizacion de su carnet digital oficial con fotografia y codigo QR personal.
   - Consulta de su horario de clases, materias inscritas y docentes asignados.
   - Registro de asistencia escaneando el QR de la sesion del docente.
   - Historial de asistencias e inasistencias por asignatura y porcentaje acumulado.
   - Descarga de planilla de inscripcion y actualizacion de foto de perfil.

---

### 2. MODULOS DEL SISTEMA

#### MODULO 1: AUTENTICACION, SESIONES Y SEGURIDAD
- **Login unico:** Ingreso por cedula o correo electronico y contrasea cifrada con password_hash.
- **Proteccion contra ataques:**
  - Bloqueo por fuerza bruta tras 10 intentos fallidos (ventana de 15 minutos).
  - Tokens CSRF obligatorios en formularios POST.
  - Cierre automatico de sesion por inactividad tras 10 minutos.
- **Manejo de API / Movil:** Autenticacion mediante token JWT o token de sesion seguro enviado en cabecera `Authorization: Bearer <token>`.
- **Registro:** Solicitud de cuenta para nuevos estudiantes con seleccion de carrera y semestre inicial.

#### MODULO 2: CARNETIZACION DIGITAL (WEB Y APP)
- **Plantilla Oficial:** Superposicion dinamica de los datos del titular sobre la plantilla oficial de la UNEFA segun el rol (Estudiante, Docente, Coordinador, Director, Superadmin).
- **Elementos del Carnet:**
  - Nombres y Apellidos.
  - Cedula de Identidad.
  - Carrera o Departamento de adscripcion.
  - Rol / Condicion.
  - Periodo Academico de vigencia.
  - Fotografia oficial en fondo blanco (recortable desde la web o app).
  - Codigo QR de alta resolucion.
- **Simulador y Exportacion:** Vista previa en tiempo real antes de imprimir y descarga en formato PDF de alta calidad listo para credencial fisica.

#### MODULO 3: CONTROL DE ASISTENCIAS MEDIANTE CODIGO QR
El modulo opera bajo dos modalidades complementarias:

- **Modalidad A (Docente genera QR - Estudiante escanea):**
  1. El docente inicia sesion y pulsa en "Iniciar Clase" seleccionando su materia y seccion.
  2. El sistema crea una sesion de clase en la base de datos con tiempo limite de validez.
  3. La pantalla del docente proyecta un QR que contiene el token firmado de la sesion.
  4. Los estudiantes abren su app movil, apuntan la camara al QR y la asistencia queda registrada inmediatamente.

- **Modalidad B (Estudiante muestra QR - Docente escanea):**
  1. El estudiante abre su carnet digital en la app movil.
  2. El docente usa el lector de la app o camara web para escanear el carnet de cada estudiante.
  3. El sistema valida la matricula del estudiante en la seccion y marca la presencia.

- **Validaciones de Asistencia:**
  - Control de duplicidad: un estudiante no puede marcar dos veces la misma clase.
  - Estados permitidos: Presente, Ausente, Justificado, Tardio.
  - Registro del metodo utilizado: QR o Manual.

#### MODULO 4: GESTION ACADEMICA Y HORARIOS
- **Periodos Academicos:** Control de fechas de inicio, corte y fin de periodo.
- **Malla Curricular:** Registro de materias, prelaciones y unidades de credito.
- **Matriz de Horarios:** Asignacion visual de aulas, dias y bloques de horas por seccion.
- **Inscripciones:** Vinculacion entre estudiante, seccion y periodo academico activo.

#### MODULO 5: REPORTES, ESTADISTICAS Y AUDITORIA
- **Actas de Asistencia:** Generacion en PDF del formato institucional con lista de alumnos, porcentajes de asistencia y firmas del docente y coordinador.
- **Bitacora de Auditoria:** Registro automatico de cada accion sensible (creacion de usuarios, modificaciones de notas/asistencias, inicios de sesion) con IP, fecha y usuario.

---

### 3. DIVISION DE RESPONSABILIDADES POR EQUIPO

#### DEPARTAMENTO DE FRONTEND (Web y App Movil)
1. **Portal Web (`UnefaWeb/`):**
   - Vistas HTML/CSS limpias y adaptadas a Bootstrap.
   - Formularios de login, registro y recuperacion.
   - Dashboards divididos por rol: `student`, `teacher`, `coordinator`, `director`, `superadmin`.
   - Modulo de carnetizacion: visor del carnet y componente de captura de foto.
   - Lector QR integrado en el navegador para docentes.
2. **App Movil (`UnefaApp/` en Expo React Native):**
   - Pantallas de bienvenida, login y registro.
   - Pantalla principal con el Carnet Digital y boton para desplegar el QR en pantalla completa.
   - Escaner QR rapido con camara del telefono para registrar asistencia.
   - Vista de horarios y materias inscritas.

#### DEPARTAMENTO DE BACKEND (PHP y API REST)
1. **Rutas y Controladores:**
   - Atender peticiones del portal web y responder endpoints JSON para la app movil.
2. **Endpoints Principales requeridos:**
   - `POST /api/auth/login`: Validar credenciales y devolver datos de usuario + token.
   - `GET /api/student/carnet`: Obtener datos completos para pintar el carnet.
   - `POST /api/asistencia/iniciar-sesion`: Docente abre clase y recibe token de sesion.
   - `POST /api/asistencia/marcar`: Estudiante o docente envia token QR para registrar asistencia.
   - `GET /api/asistencia/historial`: Lista de asistencias por materia y seccion.
   - `GET /api/reportes/asistencia-pdf`: Descarga del acta oficial en PDF.

#### DEPARTAMENTO DE BASE DE DATOS
1. Mantener el esquema relacional normalizado con las tablas base:
   - `usuarios`, `roles`, `estudiantes`, `docentes`, `carreras`, `materias`, `secciones`, `inscripciones`, `sesiones_clase`, `asistencia`, `auditoria`, `periodos_academicos`.
2. Proporcionar la tabla de equivalencias a los desarrolladores.
3. Crear indices en campos criticos de busqueda (`cedula`, `codigo_qr`, `id_seccion`, `fecha`).

#### DEPARTAMENTO DE DOCUMENTACION
1. Mantener este documento actualizado segun los avances de cada entrega.
2. Elaborar los diagramas de casos de uso y entidad-relacion.
3. Redactar el manual de usuario para el docente y estudiante.
