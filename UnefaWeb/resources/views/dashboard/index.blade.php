@php
    $rolesConfig = [
        'estudiante' => [
            'tituloRol' => 'Estudiante',
            'marcaHeader' => 'UNEFA · ESTUDIANTES',
            'subtituloHeader' => 'Vicerrectorado Académico · Control de Estudios',
            'insigniaRol' => 'ROL: ESTUDIANTE',
            'tituloMenu' => 'Navegación Académica',
            'usuario' => [
                'nombreHeader' => 'Carlos González',
                'nombreCorto' => 'Carlos E. González M.',
                'nombreCompleto' => 'Carlos Eduardo González Márquez',
                'cedula' => 'V-28.450.123',
                'carrera' => 'Ingeniería de Sistemas',
                'carreraCodigo' => 'ING-SIS-10',
                'nucleo' => 'Núcleo Carabobo',
                'semestre' => 'Semestre 6',
                'turno' => 'Diurno',
                'serial' => 'UNEFA-2026-EST-008492',
                'vigencia' => '31/12/2026',
            ],
            'menu' => [
                ['clave' => 'inicio', 'etiqueta' => 'Inicio', 'icono' => 'home'],
                ['clave' => 'carnet', 'etiqueta' => 'Mi Carnet Digital QR', 'icono' => 'id-card', 'activos' => ['carnet', 'carnet-foto']],
                ['clave' => 'escaner', 'etiqueta' => 'Registrar Asistencia', 'icono' => 'scan-qr'],
                ['clave' => 'horario', 'etiqueta' => 'Horario y Materias', 'icono' => 'calendar'],
                ['clave' => 'asistencia', 'etiqueta' => 'Historial de Asistencia', 'icono' => 'check-square'],
                ['clave' => 'seguridad', 'etiqueta' => 'Seguridad de Cuenta', 'icono' => 'shield'],
            ],
            'notificaciones' => [
                [
                    'titulo' => 'Asistencia registrada: Bases de Datos II',
                    'detalle' => 'Estado actualizado a PRESENTE (Modalidad A) · Hoy, 08:52 AM',
                    'noLeida' => true,
                ],
                [
                    'titulo' => 'Fotografía de carnet aprobada',
                    'detalle' => 'Coordinación validó tu foto. PDF 300 DPI y Modalidad B habilitados · Ayer',
                    'noLeida' => true,
                ],
                [
                    'titulo' => 'Planilla de Inscripción 2026-II disponible',
                    'detalle' => 'Descarga oficial habilitada en Horario y Materias · 24 Nov',
                    'noLeida' => false,
                ],
            ],
            'secciones' => [
                'inicio' => [
                    'vista' => 'dashboard.sections.estudiante.inicio',
                    'tituloPagina' => 'Panel Principal — UNEFA Estudiantes',
                    'descripcionPagina' => 'Panel principal del estudiante del portal UNEFA',
                    'breadcrumbs' => [
                        ['texto' => 'Inicio'],
                        ['texto' => 'Panel Principal'],
                    ],
                ],
                'carnet' => [
                    'vista' => 'dashboard.sections.estudiante.carnet',
                    'tituloPagina' => 'Mi Carnet Digital QR — UNEFA Estudiantes',
                    'descripcionPagina' => 'Carnet Digital Institucional UNEFA con código QR dinámico',
                    'breadcrumbs' => [
                        ['texto' => 'Inicio', 'url' => null],
                        ['texto' => 'Mi Carnet Digital QR'],
                    ],
                ],
                'carnet-foto' => [
                    'vista' => 'dashboard.sections.estudiante.carnet-foto',
                    'tituloPagina' => 'Actualizar Fotografía 3:4 — UNEFA Estudiantes',
                    'descripcionPagina' => 'Carga y recorte de fotografía institucional 3:4 para el carnet digital',
                    'breadcrumbs' => [
                        ['texto' => 'Inicio', 'url' => null],
                        ['texto' => 'Mi Carnet Digital QR', 'url' => 'carnet'],
                        ['texto' => 'Actualizar Fotografía'],
                    ],
                ],
                'escaner' => [
                    'vista' => 'dashboard.sections.estudiante.escaner',
                    'tituloPagina' => 'Registrar Asistencia QR — UNEFA Estudiantes',
                    'descripcionPagina' => 'Registro de asistencia por código QR dinámico en aula (Modalidad A)',
                    'breadcrumbs' => [
                        ['texto' => 'Inicio', 'url' => null],
                        ['texto' => 'Registrar Asistencia (Modalidad A)'],
                    ],
                ],
                'horario' => [
                    'vista' => 'dashboard.sections.estudiante.horario',
                    'tituloPagina' => 'Horario y Materias — UNEFA Estudiantes',
                    'descripcionPagina' => 'Horario semanal de clases y resumen de carga académica inscrita',
                    'breadcrumbs' => [
                        ['texto' => 'Inicio', 'url' => null],
                        ['texto' => 'Horario y Materias'],
                    ],
                ],
                'asistencia' => [
                    'vista' => 'dashboard.sections.estudiante.asistencia',
                    'tituloPagina' => 'Historial de Asistencia — UNEFA Estudiantes',
                    'descripcionPagina' => 'Seguimiento acumulado de asistencias, tardanzas e inasistencias por asignatura',
                    'breadcrumbs' => [
                        ['texto' => 'Inicio', 'url' => null],
                        ['texto' => 'Historial de Asistencia'],
                    ],
                ],
                'seguridad' => [
                    'vista' => 'dashboard.sections.estudiante.seguridad',
                    'tituloPagina' => 'Seguridad de Cuenta — UNEFA Estudiantes',
                    'descripcionPagina' => 'Preguntas de seguridad, control de sesión e inactividad del portal',
                    'breadcrumbs' => [
                        ['texto' => 'Inicio', 'url' => null],
                        ['texto' => 'Seguridad de Cuenta'],
                    ],
                ],
            ],
        ],
        'profesor' => [
            'tituloRol' => 'Docente',
            'marcaHeader' => 'UNEFA · DOCENTES',
            'subtituloHeader' => 'Vicerrectorado Académico · Control de Cátedra',
            'insigniaRol' => 'ROL: DOCENTE',
            'insigniaClase' => 'border-unefa-gold bg-unefa-gold text-unefa-navy font-black',
            'tituloMenu' => 'Gestión de Cátedra',
            'canalBadge' => 'STAFF',
            'tituloNotificaciones' => 'Sala Docente (Socket.IO)',
            'tituloLogout' => '¿Cerrar sesión docente?',
            'mensajeLogout' => 'Se revocará su sesión activa en Redis y se desconectará su suscripción a las salas de aula en tiempo real.',
            'mensajeExpirada' => 'Tu sesión docente se cerró automáticamente tras 10 minutos de inactividad (RF-05). Inicia sesión nuevamente por la pestaña Personal.',
            'usuario' => [
                'nombreHeader' => 'Prof. Elena Rivas',
                'nombreMovil' => 'Prof. Elena C. Rivas M.',
                'nombreCorto' => 'Prof. Elena C. Rivas M.',
                'nombreCompleto' => 'Elena Carolina Rivas Mendoza',
                'nombreConTitulo' => 'Prof. Elena Carolina Rivas Mendoza',
                'cedula' => 'V-14.230.890',
                'subtituloMovil' => 'V-14.230.890 · Canal STAFF',
                'cargo' => 'Docente Titular · Ing. de Sistemas',
                'carrera' => 'Ingeniería de Sistemas',
                'nucleo' => 'Núcleo Carabobo',
                'serial' => 'UNEFA-2026-DOC-001248',
                'vigencia' => '31/12/2026',
                'avatarSvg' => "data:image/svg+xml;utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 180 240'%3E%3Crect width='180' height='240' fill='%23e9eef6'/%3E%3Ccircle cx='90' cy='82' r='34' fill='%230b2545'/%3E%3Cpath d='M48 92 C48 56 64 42 90 42 C116 42 132 56 132 92 L136 122 L44 122 Z' fill='%2306152a' opacity='0.35'/%3E%3Cpath d='M26 240 C34 174 58 148 90 148 C122 148 146 174 154 240 Z' fill='%23002855'/%3E%3Cpath d='M70 150 L90 192 L110 150 Z' fill='%23ffffff'/%3E%3Crect x='84' y='182' width='12' height='10' rx='2' fill='%23f2b807'/%3E%3C/svg%3E",
            ],
            'menu' => [
                ['clave' => 'inicio', 'etiqueta' => 'Inicio', 'icono' => 'home'],
                ['clave' => 'sesion-activa', 'etiqueta' => 'Sesión y QR Aula (Mod. A)', 'icono' => 'qr-grid'],
                ['clave' => 'escaner-mod-b', 'etiqueta' => 'Escanear Carnets (Mod. B)', 'icono' => 'scan-line'],
                ['clave' => 'carga', 'etiqueta' => 'Carga Horaria y Secciones', 'icono' => 'calendar'],
                ['clave' => 'actas', 'etiqueta' => 'Actas de Asistencia (PDF)', 'icono' => 'file-lines'],
                ['clave' => 'carnet', 'etiqueta' => 'Mi Carnet Docente', 'icono' => 'id-card'],
                ['clave' => 'seguridad', 'etiqueta' => 'Seguridad de Cuenta', 'icono' => 'shield'],
            ],
            'notificaciones' => [
                [
                    'titulo' => 'Escaneo recibido: Carlos González',
                    'detalle' => 'ING-SIS-601 (01S-2610-D1) · PRESENTE · Hace 1 min',
                    'noLeida' => true,
                ],
                [
                    'titulo' => 'Escaneo recibido: María Alejandra Ruiz',
                    'detalle' => 'ING-SIS-601 (01S-2610-D1) · PRESENTE · Hace 2 min',
                    'noLeida' => true,
                ],
                [
                    'titulo' => 'Cierre automático programado',
                    'detalle' => 'Recuerda cerrar las sesiones abiertas al finalizar tu bloque de clase.',
                    'noLeida' => true,
                ],
            ],
            'secciones' => [
                'inicio' => [
                    'vista' => 'dashboard.sections.profesor.inicio',
                    'tituloPagina' => 'Panel Principal — UNEFA Docentes',
                    'descripcionPagina' => 'Panel principal del docente del portal UNEFA',
                    'breadcrumbs' => [
                        ['texto' => 'Inicio'],
                        ['texto' => 'Panel Principal'],
                    ],
                ],
                'sesion-activa' => [
                    'vista' => 'dashboard.sections.profesor.sesion-activa',
                    'tituloPagina' => 'Sesión Activa y QR Aula — UNEFA Docentes',
                    'descripcionPagina' => 'Control de sesión de clase en vivo y QR dinámico de aula (Modalidad A)',
                    'breadcrumbs' => [
                        ['texto' => 'Inicio', 'url' => null],
                        ['texto' => 'Sesión y QR Aula (Mod. A)'],
                    ],
                ],
                'escaner-mod-b' => [
                    'vista' => 'dashboard.sections.profesor.escaner-mod-b',
                    'tituloPagina' => 'Escáner Carnets (Mod. B) — UNEFA Docentes',
                    'descripcionPagina' => 'Validación presencial de carnets estudiantiles QR (Modalidad B)',
                    'breadcrumbs' => [
                        ['texto' => 'Inicio', 'url' => null],
                        ['texto' => 'Escanear Carnets (Mod. B)'],
                    ],
                ],
                'carga' => [
                    'vista' => 'dashboard.sections.profesor.carga',
                    'tituloPagina' => 'Carga Horaria y Secciones — UNEFA Docentes',
                    'descripcionPagina' => 'Carga horaria semanal, aulas asignadas y resumen de secciones del docente',
                    'breadcrumbs' => [
                        ['texto' => 'Inicio', 'url' => null],
                        ['texto' => 'Carga Horaria y Secciones'],
                    ],
                ],
                'actas' => [
                    'vista' => 'dashboard.sections.profesor.actas',
                    'tituloPagina' => 'Actas de Asistencia PDF — UNEFA Docentes',
                    'descripcionPagina' => 'Consulta de acumulados y emisión de Actas de Asistencia oficiales en PDF (RF-13)',
                    'breadcrumbs' => [
                        ['texto' => 'Inicio', 'url' => null],
                        ['texto' => 'Actas de Asistencia (PDF)'],
                    ],
                ],
                'carnet' => [
                    'vista' => 'dashboard.sections.profesor.carnet',
                    'tituloPagina' => 'Mi Carnet Docente — UNEFA Docentes',
                    'descripcionPagina' => 'Credencial digital institucional del personal docente UNEFA con QR dinámico',
                    'breadcrumbs' => [
                        ['texto' => 'Inicio', 'url' => null],
                        ['texto' => 'Mi Carnet Docente'],
                    ],
                ],
                'seguridad' => [
                    'vista' => 'dashboard.sections.profesor.seguridad',
                    'tituloPagina' => 'Seguridad de Cuenta — UNEFA Docentes',
                    'descripcionPagina' => 'Preguntas de seguridad, control de sesión STAFF y auditoría de accesos',
                    'breadcrumbs' => [
                        ['texto' => 'Inicio', 'url' => null],
                        ['texto' => 'Seguridad de Cuenta'],
                    ],
                ],
            ],
        ],
        'coordinador' => [
            'tituloRol' => 'Coordinador',
            'marcaHeader' => 'UNEFA · COORDINACIÓN',
            'subtituloHeader' => 'Decanato Académico · Supervisión de Carrera',
            'insigniaRol' => 'ROL: COORDINADOR',
            'tituloMenu' => 'Gestión Académica',
            'usuario' => [
                'nombreHeader' => 'Marcos Peña',
                'nombreCorto' => 'Dr. Marcos Peña',
                'nombreCompleto' => 'Dr. Marcos Peña Colmenares',
                'cedula' => 'V-11.234.567',
            ],
            'menu' => [
                ['clave' => 'inicio', 'etiqueta' => 'Inicio', 'icono' => 'home'],
            ],
            'notificaciones' => [
                ['titulo' => 'Módulo de coordinación en preparación', 'detalle' => 'Las secciones de supervisión se integrarán aquí.', 'noLeida' => false],
            ],
        ],
        'director' => [
            'tituloRol' => 'Director',
            'marcaHeader' => 'UNEFA · DIRECCIÓN',
            'subtituloHeader' => 'Dirección General de Núcleo · Mando Institucional',
            'insigniaRol' => 'ROL: DIRECTOR',
            'tituloMenu' => 'Dirección de Núcleo',
            'usuario' => [
                'nombreHeader' => 'Roberto Silva',
                'nombreCorto' => 'Cnel. Roberto Silva',
                'nombreCompleto' => 'Cnel. Roberto Silva Pacheco',
                'cedula' => 'V-09.876.543',
            ],
            'menu' => [
                ['clave' => 'inicio', 'etiqueta' => 'Inicio', 'icono' => 'home'],
            ],
            'notificaciones' => [
                ['titulo' => 'Módulo directivo en preparación', 'detalle' => 'Las secciones ejecutivas se integrarán aquí.', 'noLeida' => false],
            ],
        ],
    ];

    $rol = array_key_exists($rol ?? 'estudiante', $rolesConfig) ? $rol : 'estudiante';
    $rolMeta = $rolesConfig[$rol];
    $usuario = $rolMeta['usuario'];
    $notificaciones = $rolMeta['notificaciones'];
    $seccionesRol = $rolMeta['secciones'] ?? [];
    $seccion = array_key_exists($seccion ?? 'inicio', $seccionesRol) ? $seccion : 'inicio';
    $seccionMeta = $seccionesRol[$seccion] ?? [
        'vista' => null,
        'tituloPagina' => 'Panel ' . $rolMeta['tituloRol'] . ' — UNEFA',
        'descripcionPagina' => 'Panel unificado de UNEFA para el rol ' . $rolMeta['tituloRol'],
        'breadcrumbs' => [['texto' => 'Inicio'], ['texto' => 'Panel ' . $rolMeta['tituloRol']]],
    ];

    // Resuelve enlaces de breadcrumbs internos del mismo rol.
    $breadcrumbs = array_map(function ($crumb) use ($rol) {
        if (!array_key_exists('url', $crumb)) {
            return $crumb;
        }
        $destSeccion = $crumb['url'] ?? 'inicio';
        return [
            'texto' => $crumb['texto'],
            'url' => route('dashboard', ['rol' => $rol, 'seccion' => $destSeccion]),
        ];
    }, $seccionMeta['breadcrumbs']);
@endphp
@extends('layouts.dashboard')

@section('title', $seccionMeta['tituloPagina'])
@section('descripcion', $seccionMeta['descripcionPagina'])

@section('sidebar')
    @include('partials.dashboard.sidebar', [
        'rol' => $rol,
        'seccionActiva' => $seccion,
        'usuario' => $usuario,
        'menu' => $rolMeta['menu'],
        'tituloMenu' => $rolMeta['tituloMenu'],
        'canalBadge' => $rolMeta['canalBadge'] ?? 'v2.0',
    ])
@endsection

@section('breadcrumbs')
    @include('partials.dashboard.breadcrumbs', ['items' => $breadcrumbs])
@endsection

@section('content')
    @if(!empty($seccionMeta['vista']))
        @include($seccionMeta['vista'], [
            'rol' => $rol,
            'seccion' => $seccion,
            'titular' => $usuario,
            'estudiante' => $usuario,
            'docente' => $usuario,
            'notificaciones' => $notificaciones,
        ])
    @endif
@endsection
