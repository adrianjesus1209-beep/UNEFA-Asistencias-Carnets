@extends('layouts.dashboard')

@section('title', 'Panel Estudiante | Portal UNEFA')
@section('header-subtitle', 'Panel Estudiante')
@section('descripcion', 'Panel del estudiante del Sistema Integral de Asistencias y Carnetización Digital de la UNEFA. Período académico 2026-I.')

@section('content')
    {{-- Contenido tomado de la vista estudiante del dashboard de UnefaApp (src/app/dashboard.tsx). --}}
    @include('partials.selector-entidad', ['activo' => 'estudiante'])

    <div class="mt-4">
        <div class="grid items-stretch gap-5 lg:grid-cols-2">
            @include('partials.session-banner', [
                'insignia' => 'ESTUDIANTE REGULAR',
                'insigniaFondo' => 'bg-slate-100',
                'insigniaTexto' => 'text-slate-700',
                'icono' => 'graduation-cap',
                'acentoFondo' => 'bg-unefa-blue',
                'bordeClase' => 'border-slate-200',
                'nombre' => 'Carlos Manuel Mendoza Rojas',
                'cedula' => 'V-28.123.456',
                'departamento' => 'Ingeniería de Sistemas · 7mo Semestre',
                'subtitulo' => 'Matrícula Oficial 2026-I · Modalidad Diurna',
                'matricula' => 'UNEFA-2022-04921',
                'claseContenedor' => 'mb-0 h-full',
                'distribuir' => true,
            ])

            {{-- Carnet digital simulado: simetrico con el banner de sesion (encabezado, cuerpo central y pie) --}}
            <div class="flex h-full flex-col overflow-hidden rounded-[18px] border border-unefa-gold/60 bg-white shadow-sm ring-1 ring-slate-100">
                <div class="h-[3px] w-full shrink-0 bg-unefa-gold" aria-hidden="true"></div>

                <div class="flex flex-1 flex-col p-[18px]">
                    <div class="flex items-start justify-between gap-3 border-b border-slate-200 pb-3">
                        <div class="min-w-0">
                            <p class="text-[10px] font-extrabold tracking-[0.4px] text-slate-700">REPÚBLICA BOLIVARIANA DE VENEZUELA</p>
                            <p class="text-[10px] tracking-[0.3px] text-slate-600">MINISTERIO DEL PODER POPULAR PARA LA DEFENSA</p>
                            <p class="mt-1 text-[13px] font-black tracking-[0.4px] text-unefa-navy">UNEFA · CARNET DE ASISTENCIA DIGITAL</p>
                        </div>
                        <span class="shrink-0 rounded-md bg-unefa-gold px-2.5 py-1 text-xs font-black text-unefa-navy">2026-I</span>
                    </div>

                    <div class="flex flex-1 flex-col items-center gap-3.5 py-4 sm:flex-row sm:items-center">
                        <div class="flex h-24 w-20 shrink-0 flex-col items-center justify-center gap-1 rounded-[10px] border-2 border-unefa-gold bg-slate-50 p-1">
                            @include('partials.icon', ['name' => 'user', 'clase' => 'h-8 w-8 text-slate-500'])
                            <span class="text-center text-[10px] font-extrabold leading-tight text-slate-600">FOTO ESTUDIANTE</span>
                        </div>

                        <div class="min-w-0 flex-1 text-center sm:text-left">
                            <p class="mb-0.5 text-[15px] font-black leading-snug text-unefa-navy">Carlos Manuel Mendoza Rojas</p>
                            <p class="mb-0.5 text-[13px] font-extrabold text-unefa-blue">V-28.123.456</p>
                            <p class="mb-0.5 text-[11px] font-bold text-slate-600">INGENIERÍA DE SISTEMAS</p>
                            <p class="text-[11px] font-extrabold text-emerald-700">CONDICIÓN: REGULAR ACTIVO</p>
                        </div>

                        <button
                            type="button"
                            command="show-modal"
                            commandfor="modal-carnet-qr"
                            class="flex h-24 w-24 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-white p-1.5 shadow-sm transition hover:border-unefa-navy focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-900"
                            aria-label="Ampliar código QR del carnet digital"
                        >
                            @include('partials.carnet-qr-svg', ['clase' => 'h-20 w-20', 'decorativo' => true])
                        </button>
                    </div>

                    <div class="mt-auto flex flex-wrap items-center justify-between gap-2 border-t border-slate-200 pt-3">
                        <p class="flex items-center gap-1.5 text-[11px] font-semibold text-slate-500">
                            MAT:
                            <span class="font-mono text-[11px] font-extrabold text-slate-900">2022-04921-UNEFA</span>
                            <span class="text-slate-400">·</span>
                            <span>QR ilustrativo</span>
                        </p>
                        <button
                            type="button"
                            command="show-modal"
                            commandfor="modal-carnet-qr"
                            class="inline-flex items-center gap-1.5 rounded-lg border border-slate-300 bg-slate-50 px-2.5 py-1 text-[11px] font-extrabold text-unefa-navy transition hover:border-unefa-navy hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-900"
                        >
                            @include('partials.icon', ['name' => 'qr-code', 'clase' => 'h-3.5 w-3.5 text-unefa-navy'])
                            Ampliar QR
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Dialogo nativo para visualizar el QR del carnet en formato amplio y legible --}}
        <dialog
            id="modal-carnet-qr"
            closedby="any"
            aria-labelledby="carnet-qr-titulo"
            class="carnet-qr-dialog m-auto w-[calc(100%-2rem)] max-w-[380px] rounded-[22px] border border-slate-200 bg-white p-6 text-center shadow-2xl"
        >
            <div class="flex flex-col items-center">
                <h1 id="carnet-qr-titulo" class="text-lg font-black text-unefa-navy">Carnet Digital QR</h1>
                <p class="mt-1 text-xs font-bold text-slate-600">Carlos Manuel Mendoza Rojas · V-28.123.456</p>

                <div class="my-4 rounded-2xl border-2 border-unefa-gold/70 bg-white p-4 shadow-sm">
                    @include('partials.carnet-qr-svg', ['clase' => 'h-56 w-56'])
                </div>

                <p class="font-mono text-xs font-extrabold tracking-[0.8px] text-slate-900">MAT: 2022-04921-UNEFA</p>
                <p class="mt-1 text-[11px] font-semibold text-slate-500">Código ilustrativo, no válido para accesos</p>

                <form method="dialog" class="mt-5 w-full">
                    <button
                        type="submit"
                        autofocus
                        class="w-full rounded-[14px] bg-unefa-navy py-3 text-sm font-extrabold text-white transition hover:brightness-110 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-900 focus-visible:ring-offset-2"
                    >
                        Cerrar
                    </button>
                </form>
            </div>
        </dialog>

        <div class="mt-8 flex flex-col gap-5">
            {{-- Metricas del estudiante --}}
            <div class="grid grid-cols-2 gap-2.5 lg:grid-cols-4">
                @include('partials.metric-card', [
                    'valor' => '7mo',
                    'etiqueta' => 'Semestre en curso',
                    'icono' => 'calendar',
                    'acento' => 'text-slate-900',
                    'acentoBarra' => 'bg-slate-300',
                ])
                @include('partials.metric-card', [
                    'valor' => '6',
                    'etiqueta' => 'Materias inscritas',
                    'icono' => 'book-open',
                    'acento' => 'text-slate-900',
                    'acentoBarra' => 'bg-slate-300',
                ])
                @include('partials.metric-card', [
                    'valor' => '17.42',
                    'etiqueta' => 'Promedio general',
                    'icono' => 'award',
                    'acento' => 'text-slate-900',
                    'acentoBarra' => 'bg-slate-500',
                ])
                @include('partials.metric-card', [
                    'valor' => '94.5%',
                    'etiqueta' => 'Asistencia global',
                    'tipo' => 'porcentaje',
                    'porcentaje' => 94.5,
                    'acento' => 'text-unefa-green',
                    'acentoBarra' => 'bg-unefa-green',
                    'nota' => 'Meta ≥ 90%',
                    'notaColor' => 'text-emerald-700',
                ])
            </div>

            {{-- Modulo: Asignaturas y control de asistencias --}}
            <div class="rounded-[18px] border border-slate-200 bg-white p-5 shadow-sm">
                <div class="mb-4 flex flex-wrap items-start justify-between gap-2 border-b border-slate-200 pb-3">
                    <div>
                        <p class="mb-0.5 text-[10px] font-extrabold uppercase tracking-[0.6px] text-amber-700">CONTROL DE ASISTENCIAS</p>
                        <h2 class="text-base font-black text-slate-900">Mis asignaturas inscritas</h2>
                    </div>
                    @include('partials.status-badge', ['texto' => 'Solvente', 'tipo' => 'success'])
                </div>

                <div class="grid gap-3 xl:grid-cols-2">
                    @php
                        $asignaturas = [
                            ['codigo' => 'SIS-701', 'porcentaje' => 96, 'nombre' => 'Sistemas Distribuidos', 'profesor' => 'Prof. Elena Rivas Méndez', 'aula' => 'Lab Telemática 2', 'asistidas' => '24/25 asistidas', 'barra' => 'bg-unefa-green', 'texto' => 'text-emerald-700', 'estado' => 'success'],
                            ['codigo' => 'CIB-702', 'porcentaje' => 100, 'nombre' => 'Ciberseguridad y Soberanía Nacional', 'profesor' => 'Prof. Carlos Morales', 'aula' => 'Aula A-04', 'asistidas' => '20/20 asistidas', 'barra' => 'bg-unefa-green', 'texto' => 'text-emerald-700', 'estado' => 'success'],
                            ['codigo' => 'TEL-703', 'porcentaje' => 88, 'nombre' => 'Redes de Computadoras II', 'profesor' => 'Prof. Luis Sánchez', 'aula' => 'Aula C-10', 'asistidas' => '22/25 asistidas', 'barra' => 'bg-unefa-goldDark', 'texto' => 'text-amber-700', 'estado' => 'warning'],
                            ['codigo' => 'PRY-704', 'porcentaje' => 95, 'nombre' => 'Metodología y Proyecto Especial', 'profesor' => 'Prof. Carmen Gómez', 'aula' => 'Aula A-02', 'asistidas' => '19/20 asistidas', 'barra' => 'bg-unefa-green', 'texto' => 'text-emerald-700', 'estado' => 'success'],
                            ['codigo' => 'SOF-705', 'porcentaje' => 92, 'nombre' => 'Ingeniería de Software Crítico', 'profesor' => 'Dr. Marcos Peña', 'aula' => 'Lab 3', 'asistidas' => '23/25 asistidas', 'barra' => 'bg-slate-500', 'texto' => 'text-slate-700', 'estado' => 'info'],
                        ];
                    @endphp

                    @foreach($asignaturas as $asignatura)
                        <div class="group rounded-[14px] border border-slate-200 bg-slate-50 p-3.5 transition duration-150 hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-md motion-reduce:transform-none motion-reduce:transition-none">
                            <div class="mb-2 flex flex-wrap items-center justify-between gap-2">
                                <span class="rounded-md bg-slate-200 px-1.5 py-0.5 font-mono text-[11px] font-extrabold text-slate-700">{{ $asignatura['codigo'] }}</span>
                                @include('partials.status-badge', ['texto' => $asignatura['porcentaje'] . '%', 'tipo' => $asignatura['estado']])
                            </div>
                            <h3 class="mb-0.5 text-sm font-extrabold text-slate-900">{{ $asignatura['nombre'] }}</h3>
                            <p class="mb-3 text-xs font-semibold text-slate-500">{{ $asignatura['profesor'] }}</p>

                            @include('partials.progress-bar', [
                                'porcentaje' => $asignatura['porcentaje'],
                                'etiqueta' => 'Asistencia',
                                'color' => $asignatura['barra'],
                                'textoColor' => $asignatura['texto'],
                            ])

                            <div class="mt-3 flex flex-wrap items-center justify-between gap-2 border-t border-slate-200 pt-2">
                                <span class="flex min-w-0 items-center gap-1">
                                    @include('partials.icon', ['name' => 'map-pin', 'clase' => 'h-3.5 w-3.5 shrink-0 text-slate-500'])
                                    <span class="truncate text-[11px] font-semibold text-slate-600">{{ $asignatura['aula'] }}</span>
                                </span>
                                <span class="text-[11px] font-bold text-slate-700">{{ $asignatura['asistidas'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Tramites y constancias --}}
            <div class="rounded-[18px] border border-slate-200 bg-white p-5 shadow-sm">
                <div class="mb-4 border-b border-slate-200 pb-3">
                    <p class="mb-0.5 text-[10px] font-extrabold uppercase tracking-[0.6px] text-amber-700">TRÁMITES Y CONSTANCIAS</p>
                    <h2 class="text-base font-black text-slate-900">Servicios digitales disponibles</h2>
                </div>

                <div class="mt-1 grid gap-2.5 lg:grid-cols-2">
                    @php
                        $tramites = [
                            ['titulo' => 'Constancia de Estudio', 'detalle' => 'Descarga inmediata con firma digital y sello QR'],
                            ['titulo' => 'Récord de Calificaciones', 'detalle' => 'Historial acumulado y promedio ponderado'],
                            ['titulo' => 'Horario Semanal 2026-I', 'detalle' => 'Distribución de bloques por aula y laboratorio'],
                            ['titulo' => 'Justificar Inasistencia', 'detalle' => 'Consignación digital de justificativo médico/laboral'],
                        ];
                    @endphp

                    @foreach($tramites as $tramite)
                        <button type="button" aria-disabled="true" title="Disponible al integrar el backend" class="group flex items-start justify-between gap-2 rounded-xl border border-slate-200 bg-slate-50 p-3 text-left transition duration-150 hover:-translate-y-0.5 hover:border-slate-300 hover:bg-white hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-900 motion-reduce:transform-none motion-reduce:transition-none">
                            <span class="min-w-0">
                                <span class="mb-0.5 block text-[13px] font-extrabold text-slate-900">{{ $tramite['titulo'] }}</span>
                                <span class="block text-[11px] leading-4 text-slate-600">{{ $tramite['detalle'] }}</span>
                            </span>
                            @include('partials.icon', ['name' => 'chevron-right', 'clase' => 'h-4 w-4 shrink-0 text-slate-600 transition group-hover:translate-x-0.5 motion-reduce:transition-none'])
                        </button>
                    @endforeach
                </div>
            </div>

            <p class="pb-2 text-center text-[11px] font-semibold text-slate-500">
                Entorno de demostración · Los datos mostrados son simulados
            </p>
        </div>
    </div>
@endsection
