@php
    $rolesConfig = [
        'estudiante' => [
            'tituloRol' => 'Estudiante',
            'marcaHeader' => 'UNEFA · SICEU ESTUDIANTES',
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
                    'tituloPagina' => 'Panel Principal — SICEU Estudiantes UNEFA',
                    'descripcionPagina' => 'Panel principal del estudiante SICEU UNEFA',
                    'breadcrumbs' => [
                        ['texto' => 'Inicio'],
                        ['texto' => 'Panel Principal'],
                    ],
                ],
                'carnet' => [
                    'vista' => 'dashboard.sections.estudiante.carnet',
                    'tituloPagina' => 'Mi Carnet Digital QR — SICEU Estudiantes UNEFA',
                    'descripcionPagina' => 'Carnet Digital Institucional UNEFA con código QR dinámico',
                    'breadcrumbs' => [
                        ['texto' => 'Inicio', 'url' => null],
                        ['texto' => 'Mi Carnet Digital QR'],
                    ],
                ],
                'carnet-foto' => [
                    'vista' => 'dashboard.sections.estudiante.carnet-foto',
                    'tituloPagina' => 'Actualizar Fotografía 3:4 — SICEU Estudiantes UNEFA',
                    'descripcionPagina' => 'Carga y recorte de fotografía institucional 3:4 para el carnet digital',
                    'breadcrumbs' => [
                        ['texto' => 'Inicio', 'url' => null],
                        ['texto' => 'Mi Carnet Digital QR', 'url' => 'carnet'],
                        ['texto' => 'Actualizar Fotografía'],
                    ],
                ],
                'escaner' => [
                    'vista' => 'dashboard.sections.estudiante.escaner',
                    'tituloPagina' => 'Registrar Asistencia QR — SICEU Estudiantes UNEFA',
                    'descripcionPagina' => 'Registro de asistencia por código QR dinámico en aula (Modalidad A)',
                    'breadcrumbs' => [
                        ['texto' => 'Inicio', 'url' => null],
                        ['texto' => 'Registrar Asistencia (Modalidad A)'],
                    ],
                ],
                'horario' => [
                    'vista' => 'dashboard.sections.estudiante.horario',
                    'tituloPagina' => 'Horario y Materias — SICEU Estudiantes UNEFA',
                    'descripcionPagina' => 'Horario semanal de clases y resumen de carga académica inscrita',
                    'breadcrumbs' => [
                        ['texto' => 'Inicio', 'url' => null],
                        ['texto' => 'Horario y Materias'],
                    ],
                ],
                'asistencia' => [
                    'vista' => 'dashboard.sections.estudiante.asistencia',
                    'tituloPagina' => 'Historial de Asistencia — SICEU Estudiantes UNEFA',
                    'descripcionPagina' => 'Seguimiento acumulado de asistencias, tardanzas e inasistencias por asignatura',
                    'breadcrumbs' => [
                        ['texto' => 'Inicio', 'url' => null],
                        ['texto' => 'Historial de Asistencia'],
                    ],
                ],
                'seguridad' => [
                    'vista' => 'dashboard.sections.estudiante.seguridad',
                    'tituloPagina' => 'Seguridad de Cuenta — SICEU Estudiantes UNEFA',
                    'descripcionPagina' => 'Preguntas de seguridad, control de sesión e inactividad del portal',
                    'breadcrumbs' => [
                        ['texto' => 'Inicio', 'url' => null],
                        ['texto' => 'Seguridad de Cuenta'],
                    ],
                ],
            ],
        ],
        'profesor' => [
            'tituloRol' => 'Profesor',
            'marcaHeader' => 'UNEFA · SICEU DOCENTES',
            'subtituloHeader' => 'Vicerrectorado Académico · Gestión de Cátedras',
            'insigniaRol' => 'ROL: PROFESOR',
            'tituloMenu' => 'Navegación Docente',
            'usuario' => [
                'nombreHeader' => 'Elena Rivas',
                'nombreCorto' => 'Prof. Elena Rivas',
                'nombreCompleto' => 'Prof. Ing. Elena Rivas Méndez',
                'cedula' => 'V-14.567.890',
            ],
            'menu' => [
                ['clave' => 'inicio', 'etiqueta' => 'Inicio', 'icono' => 'home'],
            ],
            'notificaciones' => [
                ['titulo' => 'Módulo docente en preparación', 'detalle' => 'Las secciones de cátedra se integrarán aquí.', 'noLeida' => false],
            ],
        ],
        'coordinador' => [
            'tituloRol' => 'Coordinador',
            'marcaHeader' => 'UNEFA · SICEU COORDINACIÓN',
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
            'marcaHeader' => 'UNEFA · SICEU DIRECCIÓN',
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
        'tituloPagina' => 'Panel ' . $rolMeta['tituloRol'] . ' — SICEU UNEFA',
        'descripcionPagina' => 'Panel unificado SICEU para el rol ' . $rolMeta['tituloRol'],
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
            'estudiante' => $usuario,
            'notificaciones' => $notificaciones,
        ])
    @endif
@endsection
