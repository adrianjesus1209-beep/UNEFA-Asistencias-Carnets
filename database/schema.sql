-- ========================================================
-- SISTEMA UNIFICADO DE CREDENCIAL Y ASISTENCIA DIGITAL (UNEFA)
-- Base de Datos: attendance_credential_db
-- ========================================================

CREATE DATABASE IF NOT EXISTS attendance_credential_db
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE attendance_credential_db;

SET FOREIGN_KEY_CHECKS = 0;

-- ========================================================
-- 1. MODULO DE SEGURIDAD, ROLES, PERMISOS Y AUTENTICACION
-- ========================================================

-- Roles del sistema --
CREATE TABLE IF NOT EXISTS system_role (
    id INT NOT NULL AUTO_INCREMENT,
    role_name VARCHAR(50) NOT NULL,
    hierarchy_level TINYINT UNSIGNED NOT NULL,
    description VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_role_name (role_name),
    KEY idx_role_hierarchy (hierarchy_level)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Catalogo de permisos del sistema --
CREATE TABLE IF NOT EXISTS permission (
    id INT NOT NULL AUTO_INCREMENT,
    permission_key VARCHAR(80) NOT NULL,
    permission_name VARCHAR(100) NOT NULL,
    module VARCHAR(50) NOT NULL,
    description VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_permission_key (permission_key),
    KEY idx_permission_module (module)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Permisos asignados a cada rol --
CREATE TABLE IF NOT EXISTS role_permission (
    id INT NOT NULL AUTO_INCREMENT,
    role_id INT NOT NULL,
    permission_id INT NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_role_permission (role_id, permission_id),
    KEY idx_rp_permission (permission_id),
    CONSTRAINT fk_rp_role FOREIGN KEY (role_id) REFERENCES system_role (id) ON DELETE CASCADE,
    CONSTRAINT fk_rp_permission FOREIGN KEY (permission_id) REFERENCES permission (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Perfiles de usuario y control de avance de semestre --
CREATE TABLE IF NOT EXISTS profile (
    id INT NOT NULL AUTO_INCREMENT,
    career_id INT DEFAULT NULL,
    id_number VARCHAR(20) NOT NULL,
    id_type VARCHAR(2) NOT NULL DEFAULT 'V',
    first_name VARCHAR(50) NOT NULL,
    middle_name VARCHAR(50) DEFAULT NULL,
    last_name VARCHAR(50) NOT NULL,
    second_last_name VARCHAR(50) DEFAULT NULL,
    current_semester TINYINT UNSIGNED NOT NULL DEFAULT 1,
    has_dragged_subjects TINYINT(1) NOT NULL DEFAULT 0,
    address VARCHAR(255) DEFAULT NULL,
    phone VARCHAR(20) DEFAULT NULL,
    job_title VARCHAR(100) DEFAULT NULL,
    profile_picture VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_id_number (id_number),
    KEY idx_profile_career (career_id),
    KEY idx_profile_semester (current_semester, has_dragged_subjects)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Cuentas de acceso y QR unico permanente --
CREATE TABLE IF NOT EXISTS user_account (
    id INT NOT NULL AUTO_INCREMENT,
    profile_id INT NOT NULL,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    qr_token VARCHAR(128) NOT NULL,
    security_pin_hash VARCHAR(255) DEFAULT NULL,
    pin_expires_at DATETIME DEFAULT NULL,
    pin_updated_at DATETIME DEFAULT NULL,
    status ENUM('Pending', 'Approved', 'Rejected', 'Inactive') NOT NULL DEFAULT 'Pending',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_username (username),
    UNIQUE KEY uniq_email (email),
    UNIQUE KEY uniq_profile_id (profile_id),
    UNIQUE KEY uniq_user_qr_token (qr_token),
    KEY idx_user_status (status),
    KEY idx_user_pin_expiration (pin_expires_at),
    CONSTRAINT fk_user_profile FOREIGN KEY (profile_id) REFERENCES profile (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Roles asignados por usuario y emision de carnet por cada rol --
CREATE TABLE IF NOT EXISTS user_role (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    role_id INT NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    credential_number VARCHAR(50) DEFAULT NULL,
    credential_issued_at DATETIME DEFAULT NULL,
    credential_expires_at DATETIME DEFAULT NULL,
    assigned_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_user_role (user_id, role_id),
    UNIQUE KEY uniq_credential_number (credential_number),
    KEY idx_ur_role_active (role_id, is_active),
    CONSTRAINT fk_ur_user FOREIGN KEY (user_id) REFERENCES user_account (id) ON DELETE CASCADE,
    CONSTRAINT fk_ur_role FOREIGN KEY (role_id) REFERENCES system_role (id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Preguntas de seguridad --
CREATE TABLE IF NOT EXISTS security_question (
    id INT NOT NULL AUTO_INCREMENT,
    question_text VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Respuestas de seguridad --
CREATE TABLE IF NOT EXISTS user_security_answer (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    question_id INT NOT NULL,
    answer_hash VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_user_question (user_id, question_id),
    KEY idx_answer_question (question_id),
    CONSTRAINT fk_answer_user FOREIGN KEY (user_id) REFERENCES user_account (id) ON DELETE CASCADE,
    CONSTRAINT fk_answer_question FOREIGN KEY (question_id) REFERENCES security_question (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Codigos de verificacion por correo --
CREATE TABLE IF NOT EXISTS verification_code (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    code VARCHAR(10) NOT NULL,
    code_type ENUM('2FA_Login', 'Password_Reset', 'Security_Questions_Reset', 'Pin_Reset') NOT NULL DEFAULT 'Password_Reset',
    expires_at DATETIME NOT NULL,
    is_used TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_vc_lookup (user_id, code_type, is_used, expires_at),
    KEY idx_vc_code (code),
    CONSTRAINT fk_vc_user FOREIGN KEY (user_id) REFERENCES user_account (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Documentos de estudiantes --
CREATE TABLE IF NOT EXISTS document_registration (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    file_type ENUM('Word', 'PDF', 'Image', 'Excel') NOT NULL DEFAULT 'PDF',
    status ENUM('Pending', 'Approved', 'Rejected') NOT NULL DEFAULT 'Pending',
    observations VARCHAR(500) DEFAULT NULL,
    uploaded_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_doc_user_status (user_id, status),
    KEY idx_doc_status (status),
    CONSTRAINT fk_doc_user FOREIGN KEY (user_id) REFERENCES user_account (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================
-- 2. MODULO ACADEMICO Y PENSUM
-- ========================================================

-- Carreras --
CREATE TABLE IF NOT EXISTS career (
    id INT NOT NULL AUTO_INCREMENT,
    career_code VARCHAR(20) NOT NULL,
    career_name VARCHAR(100) NOT NULL,
    coordinator_id INT DEFAULT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_career_code (career_code),
    KEY idx_career_coordinator (coordinator_id),
    CONSTRAINT fk_career_coordinator FOREIGN KEY (coordinator_id) REFERENCES user_account (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE profile
    ADD CONSTRAINT fk_profile_career FOREIGN KEY (career_id) REFERENCES career (id) ON DELETE SET NULL;

-- Asignaturas --
CREATE TABLE IF NOT EXISTS subject (
    id INT NOT NULL AUTO_INCREMENT,
    career_id INT DEFAULT 1,
    subject_code VARCHAR(20) NOT NULL,
    subject_name VARCHAR(100) NOT NULL,
    semester TINYINT UNSIGNED DEFAULT NULL,
    credit_units TINYINT UNSIGNED NOT NULL DEFAULT 3,
    display_order TINYINT UNSIGNED NOT NULL DEFAULT 1,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_subject_code (subject_code),
    KEY idx_subject_career_semester (career_id, semester),
    KEY idx_subject_semester (semester),
    CONSTRAINT fk_subject_career FOREIGN KEY (career_id) REFERENCES career (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Prelaciones --
CREATE TABLE IF NOT EXISTS course_prerequisite (
    id INT NOT NULL AUTO_INCREMENT,
    subject_id INT NOT NULL,
    prerequisite_id INT NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_subject_prereq (subject_id, prerequisite_id),
    KEY idx_prereq_required (prerequisite_id),
    CONSTRAINT fk_prereq_subject FOREIGN KEY (subject_id) REFERENCES subject (id) ON DELETE CASCADE,
    CONSTRAINT fk_prereq_required FOREIGN KEY (prerequisite_id) REFERENCES subject (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Periodos academicos --
CREATE TABLE IF NOT EXISTS academic_period (
    id INT NOT NULL AUTO_INCREMENT,
    period_name VARCHAR(50) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE DEFAULT NULL,
    duration_weeks TINYINT UNSIGNED NOT NULL DEFAULT 16,
    status ENUM('Active', 'Closed', 'Planned') NOT NULL DEFAULT 'Active',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_period_name (period_name),
    KEY idx_period_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Eventos de calendario --
CREATE TABLE IF NOT EXISTS calendar_event (
    id INT NOT NULL AUTO_INCREMENT,
    period_id INT NOT NULL,
    year SMALLINT UNSIGNED NOT NULL,
    category VARCHAR(50) NOT NULL,
    description VARCHAR(300) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_event_period_dates (period_id, start_date, end_date),
    CONSTRAINT fk_event_period FOREIGN KEY (period_id) REFERENCES academic_period (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================
-- 3. GESTION DE CLASES E INSCRIPCIONES
-- ========================================================

-- Docentes por materia --
CREATE TABLE IF NOT EXISTS teacher_subject (
    id INT NOT NULL AUTO_INCREMENT,
    teacher_id INT NOT NULL,
    subject_id INT NOT NULL,
    assigned_by_id INT DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_teacher_subject (teacher_id, subject_id),
    KEY idx_ts_subject (subject_id),
    KEY idx_ts_assigned_by (assigned_by_id),
    CONSTRAINT fk_ts_teacher FOREIGN KEY (teacher_id) REFERENCES user_account (id) ON DELETE CASCADE,
    CONSTRAINT fk_ts_subject FOREIGN KEY (subject_id) REFERENCES subject (id) ON DELETE CASCADE,
    CONSTRAINT fk_ts_assigned_by FOREIGN KEY (assigned_by_id) REFERENCES user_account (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Secciones y horarios --
CREATE TABLE IF NOT EXISTS section (
    id INT NOT NULL AUTO_INCREMENT,
    subject_id INT NOT NULL,
    teacher_id INT NOT NULL,
    period_id INT NOT NULL,
    section_name VARCHAR(30) NOT NULL,
    day_of_week ENUM('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday') NOT NULL DEFAULT 'Monday',
    start_time TIME NOT NULL DEFAULT '08:00:00',
    end_time TIME NOT NULL DEFAULT '10:00:00',
    tolerance_minutes TINYINT UNSIGNED NOT NULL DEFAULT 15,
    classroom VARCHAR(50) NOT NULL DEFAULT 'Aula 01',
    status ENUM('Active', 'Inactive') NOT NULL DEFAULT 'Active',
    PRIMARY KEY (id),
    KEY idx_section_subject (subject_id),
    KEY idx_section_teacher (teacher_id),
    KEY idx_section_period_status (period_id, status),
    KEY idx_section_schedule (day_of_week, start_time),
    CONSTRAINT fk_section_subject FOREIGN KEY (subject_id) REFERENCES subject (id) ON DELETE CASCADE,
    CONSTRAINT fk_section_teacher FOREIGN KEY (teacher_id) REFERENCES user_account (id) ON DELETE CASCADE,
    CONSTRAINT fk_section_period FOREIGN KEY (period_id) REFERENCES academic_period (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Inscripciones por seccion y control de materias arrastradas --
CREATE TABLE IF NOT EXISTS section_enrollment (
    id INT NOT NULL AUTO_INCREMENT,
    student_id INT NOT NULL,
    section_id INT NOT NULL,
    period_id INT NOT NULL,
    status ENUM('Pending', 'Enrolled', 'Approved', 'Failed', 'Withdrawn', 'Rejected') NOT NULL DEFAULT 'Pending',
    is_dragged TINYINT(1) NOT NULL DEFAULT 0,
    final_grade TINYINT UNSIGNED NOT NULL DEFAULT 0,
    validated_by_coordinator TINYINT(1) NOT NULL DEFAULT 0,
    is_cycle_closed TINYINT(1) NOT NULL DEFAULT 0,
    assigned_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_student_section (student_id, section_id),
    KEY idx_enrollment_section (section_id),
    KEY idx_enrollment_period (period_id),
    KEY idx_enrollment_status (status),
    KEY idx_enrollment_dragged (student_id, status, is_dragged),
    CONSTRAINT fk_enroll_student FOREIGN KEY (student_id) REFERENCES user_account (id) ON DELETE CASCADE,
    CONSTRAINT fk_enroll_section FOREIGN KEY (section_id) REFERENCES section (id) ON DELETE CASCADE,
    CONSTRAINT fk_enroll_period FOREIGN KEY (period_id) REFERENCES academic_period (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================
-- 4. ASISTENCIAS Y SESIONES
-- ========================================================

-- Sesiones de clase --
CREATE TABLE IF NOT EXISTS class_session (
    id INT NOT NULL AUTO_INCREMENT,
    section_id INT NOT NULL,
    period_id INT NOT NULL,
    opened_by_id INT NOT NULL,
    session_date DATE NOT NULL,
    start_time TIME DEFAULT NULL,
    end_time TIME DEFAULT NULL,
    tolerance_minutes TINYINT UNSIGNED NOT NULL DEFAULT 15,
    session_type ENUM('Regular', 'Extraordinary') NOT NULL DEFAULT 'Regular',
    week_number TINYINT UNSIGNED DEFAULT NULL,
    status ENUM('Open', 'Closed') NOT NULL DEFAULT 'Open',
    observations VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_session_section_status (section_id, status, session_date),
    KEY idx_session_period (period_id),
    KEY idx_session_date (session_date),
    KEY idx_session_opener (opened_by_id),
    CONSTRAINT fk_session_section FOREIGN KEY (section_id) REFERENCES section (id) ON DELETE CASCADE,
    CONSTRAINT fk_session_period FOREIGN KEY (period_id) REFERENCES academic_period (id) ON DELETE CASCADE,
    CONSTRAINT fk_session_opener FOREIGN KEY (opened_by_id) REFERENCES user_account (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Asistencias por sesion --
CREATE TABLE IF NOT EXISTS attendance (
    id INT NOT NULL AUTO_INCREMENT,
    session_id INT NOT NULL,
    student_id INT NOT NULL,
    registered_by_id INT DEFAULT NULL,
    attendance_status ENUM('Present', 'Absent', 'Excused', 'Late') NOT NULL DEFAULT 'Present',
    registration_method ENUM('QR', 'Manual') NOT NULL DEFAULT 'QR',
    observation VARCHAR(255) DEFAULT NULL,
    recorded_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uniq_session_student (session_id, student_id),
    KEY idx_attendance_student_status (student_id, attendance_status),
    KEY idx_attendance_registrar (registered_by_id),
    KEY idx_attendance_method (registration_method),
    CONSTRAINT fk_attendance_session FOREIGN KEY (session_id) REFERENCES class_session (id) ON DELETE CASCADE,
    CONSTRAINT fk_attendance_student FOREIGN KEY (student_id) REFERENCES user_account (id) ON DELETE CASCADE,
    CONSTRAINT fk_attendance_registrar FOREIGN KEY (registered_by_id) REFERENCES user_account (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================
-- 5. AUDITORIA Y CONTROL
-- ========================================================

-- Bitacora del sistema --
CREATE TABLE IF NOT EXISTS audit_log (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT DEFAULT NULL,
    action VARCHAR(100) NOT NULL,
    detail VARCHAR(500) DEFAULT NULL,
    ip_address VARCHAR(45) DEFAULT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_audit_user_date (user_id, created_at),
    KEY idx_audit_timestamp (created_at),
    KEY idx_audit_action (action),
    CONSTRAINT fk_audit_user FOREIGN KEY (user_id) REFERENCES user_account (id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Intentos fallidos de autenticacion --
CREATE TABLE IF NOT EXISTS failed_attempt (
    id INT NOT NULL AUTO_INCREMENT,
    ip_address VARCHAR(45) NOT NULL,
    attempt_type VARCHAR(20) NOT NULL DEFAULT 'login',
    identifier VARCHAR(100) DEFAULT NULL,
    attempted_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_failed_lookup (ip_address, attempt_type, attempted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================================
-- 6. DATOS INICIALES DEL SISTEMA
-- ========================================================

-- Roles del sistema --
INSERT INTO system_role (id, role_name, hierarchy_level, description) VALUES
(1, 'Super Administrator', 1, 'Soporte Tecnico Central / TI - Acceso exclusivo a Auditoria, Bitacora y Configuracion Global'),
(2, 'Director', 2, 'Rector / Administrador de la Institucion - Asigna Coordinadores de Carrera y valida con clave secundaria'),
(3, 'Academic Coordinator', 3, 'Control de Estudios - Valida Expedientes, Registra Horarios y Emite Carnets Digitales'),
(4, 'Teacher', 4, 'Docente / Titular de Materia - Gestiona Sesiones de Clase y Asistencias mediante Escaneo QR'),
(5, 'Student', 5, 'Alumno Regular Aprobado - Acceso a Carnet Digital, QR y Horario Academico');

-- Permisos del sistema --
INSERT INTO permission (id, permission_key, permission_name, module, description) VALUES
(1, 'audit.view', 'Ver Bitacora y Auditoria', 'Seguridad', 'Acceso al registro de auditoria del sistema'),
(2, 'system.backup', 'Gestionar Respaldos', 'Seguridad', 'Ejecutar y descargar respaldos de base de datos'),
(3, 'coordinator.assign', 'Asignar Coordinadores', 'Direccion', 'Asignar coordinadores de carrera con clave secundaria'),
(4, 'metrics.global', 'Ver Metricas Globales', 'Direccion', 'Visualizar estadisticas institucionales'),
(5, 'student.validate_docs', 'Validar Expedientes', 'Coordinacion', 'Aprobar o rechazar documentos de estudiantes'),
(6, 'credential.issue', 'Emitir Carnets', 'Coordinacion', 'Autorizar y emitir carnets por rol'),
(7, 'schedule.manage', 'Gestionar Horarios y Secciones', 'Coordinacion', 'Crear secciones, asignar docentes e inscribir alumnos'),
(8, 'session.manage', 'Abrir y Cerrar Clases', 'Docencia', 'Iniciar y finalizar sesiones de clase'),
(9, 'attendance.scan', 'Escanear QR y Registrar Asistencia', 'Docencia', 'Pasar asistencia mediante lector QR o manual'),
(10, 'credential.view_own', 'Ver Carnets Propios y QR', 'General', 'Visualizar carnets activos asociados a sus roles'),
(11, 'schedule.view_own', 'Ver Horario y Materias', 'Estudiantes', 'Consultar horario inscrito y record de materias');

-- Asignacion de permisos por rol --
INSERT INTO role_permission (role_id, permission_id) VALUES
(1, 1), (1, 2), (1, 3), (1, 4), (1, 5), (1, 6), (1, 7), (1, 8), (1, 9), (1, 10), (1, 11),
(2, 3), (2, 4), (2, 10),
(3, 4), (3, 5), (3, 6), (3, 7), (3, 10),
(4, 8), (4, 9), (4, 10),
(5, 10), (5, 11);

-- Preguntas de seguridad --
INSERT INTO security_question (id, question_text) VALUES
(1, '¿Cual es el nombre de tu primera mascota?'),
(2, '¿Cual es tu ciudad de nacimiento?'),
(3, '¿Cual es el segundo nombre de tu madre?'),
(4, '¿Cual fue tu primer colegio o escuela?'),
(5, '¿Cual es tu comida favorita?');

-- Carrera inicial --
INSERT INTO career (id, career_code, career_name, coordinator_id) VALUES
(1, 'SYS-ING', 'Ingenieria de Sistemas', NULL);

-- Periodo academico activo inicial --
INSERT INTO academic_period (id, period_name, start_date, end_date, duration_weeks, status) VALUES
(1, '2026-1', '2026-02-01', '2026-06-30', 16, 'Active');

-- Usuario Administrador Base --
-- Usuario: admin | Clave: admin123 --
INSERT INTO profile (id, career_id, id_number, id_type, first_name, middle_name, last_name, second_last_name, current_semester, has_dragged_subjects, address, phone, job_title, profile_picture) VALUES
(1, 1, '00000000', 'V', 'Administrador', 'Principal', 'Sistemas', 'UNEFA', 1, 0, 'Sede Central UNEFA', '04120000000', 'Super Administrador TI', 'default.svg');

INSERT INTO user_account (id, profile_id, username, email, password_hash, qr_token, security_pin_hash, pin_expires_at, pin_updated_at, status) VALUES
(1, 1, 'admin', 'admin@unefa.edu.ve', '$2y$10$peaPjpuh3tDAveT2cTWmYuiAZETwJgHADt26P.O71DxxGoN/Be0D.', 'UNEFA-QR-V00000000', NULL, NULL, NULL, 'Approved');

INSERT INTO user_role (id, user_id, role_id, is_active, credential_number, credential_issued_at, credential_expires_at) VALUES
(1, 1, 1, 1, 'CARNET-ADMIN-0001', NOW(), DATE_ADD(NOW(), INTERVAL 1 YEAR));

SET FOREIGN_KEY_CHECKS = 1;
