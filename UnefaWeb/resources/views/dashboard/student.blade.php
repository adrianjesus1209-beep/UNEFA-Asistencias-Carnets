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

            {{-- Carnet digital simulado: pieza de identidad del panel --}}
            <div class="relative flex h-full flex-col overflow-hidden rounded-[18px] border border-unefa-gold/60 bg-white p-5 shadow-sm ring-1 ring-slate-100">
                <div class="relative flex flex-1 flex-col justify-center">
                    <div class="flex flex-wrap items-start justify-between gap-3 border-b border-slate-200 pb-3">
                        <div>
                            <p class="text-[11px] font-extrabold tracking-[0.4px] text-slate-700">REPÚBLICA BOLIVARIANA DE VENEZUELA</p>
                            <p class="text-[11px] tracking-[0.3px] text-slate-600">MINISTERIO DEL PODER POPULAR PARA LA DEFENSA</p>
                            <p class="mt-1 text-sm font-black tracking-[0.5px] text-unefa-navy">UNEFA · CARNET DE ASISTENCIA DIGITAL</p>
                        </div>
                        <span class="rounded-md bg-unefa-gold px-2.5 py-1 text-xs font-black text-unefa-navy">2026-I</span>
                    </div>

                    <div class="my-4 border-t border-dashed border-slate-200" aria-hidden="true"></div>

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-center">
                        <div class="mx-auto flex h-28 w-24 shrink-0 flex-col items-center justify-center gap-1 rounded-[10px] border-2 border-unefa-gold bg-slate-50 p-1 sm:mx-0">
                            @include('partials.icon', ['name' => 'user', 'clase' => 'h-10 w-10 text-slate-500'])
                            <span class="text-center text-[11px] font-extrabold text-slate-600">FOTO ESTUDIANTE</span>
                        </div>

                        <div class="min-w-0 flex-1">
                            <p class="mb-1 text-base font-black text-unefa-navy">Carlos Manuel Mendoza Rojas</p>
                            <p class="mb-1 text-[13px] font-extrabold text-unefa-blue">V-28.123.456</p>
                            <p class="mb-1 text-[11px] font-bold text-slate-600">INGENIERÍA DE SISTEMAS</p>
                            <p class="mb-3 text-[11px] font-extrabold text-emerald-700">CONDICIÓN: REGULAR ACTIVO</p>

                            <div class="flex items-center gap-3 rounded-lg bg-slate-50 p-2">
                                <svg viewBox="0 0 25 25" class="h-14 w-14 shrink-0 rounded-[3px] bg-white" role="img" aria-label="Código QR de demostración de la matrícula 2022-04921">
                                    <rect width="25" height="25" fill="#ffffff"></rect>
                                    <g fill="#1f2937">
                                        <rect x="1" y="1" width="7" height="7"></rect>
                                        <rect x="17" y="1" width="7" height="7"></rect>
                                        <rect x="1" y="17" width="7" height="7"></rect>
                                    </g>
                                    <g fill="#ffffff">
                                        <rect x="2" y="2" width="5" height="5"></rect>
                                        <rect x="18" y="2" width="5" height="5"></rect>
                                        <rect x="2" y="18" width="5" height="5"></rect>
                                    </g>
                                    <g fill="#1f2937">
                                        <rect x="3" y="3" width="3" height="3"></rect>
                                        <rect x="19" y="3" width="3" height="3"></rect>
                                        <rect x="3" y="19" width="3" height="3"></rect>
                                    </g>
                                    <g fill="#1f2937">
                                        <rect x="9" y="1" width="1" height="1"></rect><rect x="11" y="1" width="2" height="1"></rect><rect x="14" y="1" width="1" height="1"></rect>
                                        <rect x="9" y="3" width="2" height="1"></rect><rect x="13" y="3" width="1" height="1"></rect><rect x="15" y="3" width="2" height="1"></rect>
                                        <rect x="10" y="5" width="1" height="1"></rect><rect x="12" y="5" width="3" height="1"></rect>
                                        <rect x="9" y="6" width="1" height="1"></rect><rect x="11" y="6" width="1" height="1"></rect><rect x="13" y="6" width="2" height="1"></rect><rect x="16" y="6" width="1" height="1"></rect>
                                        <rect x="1" y="9" width="1" height="2"></rect><rect x="3" y="9" width="2" height="1"></rect><rect x="6" y="9" width="1" height="1"></rect>
                                        <rect x="9" y="8" width="2" height="1"></rect><rect x="12" y="8" width="1" height="2"></rect><rect x="15" y="8" width="2" height="1"></rect><rect x="18" y="8" width="1" height="1"></rect><rect x="21" y="8" width="2" height="1"></rect>
                                        <rect x="9" y="10" width="1" height="2"></rect><rect x="11" y="11" width="2" height="1"></rect><rect x="14" y="10" width="1" height="2"></rect><rect x="17" y="10" width="2" height="1"></rect><rect x="21" y="10" width="1" height="2"></rect>
                                        <rect x="9" y="12" width="3" height="1"></rect><rect x="14" y="13" width="2" height="1"></rect><rect x="18" y="12" width="1" height="2"></rect><rect x="22" y="13" width="1" height="1"></rect>
                                        <rect x="1" y="14" width="2" height="1"></rect><rect x="4" y="14" width="1" height="2"></rect><rect x="6" y="15" width="1" height="1"></rect>
                                        <rect x="9" y="15" width="1" height="2"></rect><rect x="12" y="14" width="2" height="2"></rect><rect x="16" y="15" width="3" height="1"></rect><rect x="21" y="15" width="1" height="1"></rect>
                                        <rect x="9" y="18" width="2" height="1"></rect><rect x="12" y="17" width="1" height="2"></rect><rect x="15" y="18" width="1" height="2"></rect><rect x="18" y="17" width="2" height="1"></rect><rect x="22" y="18" width="1" height="2"></rect>
                                        <rect x="10" y="20" width="3" height="1"></rect><rect x="15" y="21" width="2" height="1"></rect><rect x="19" y="20" width="1" height="2"></rect><rect x="22" y="21" width="2" height="1"></rect>
                                        <rect x="9" y="22" width="1" height="2"></rect><rect x="12" y="23" width="2" height="1"></rect><rect x="16" y="22" width="1" height="2"></rect><rect x="19" y="23" width="3" height="1"></rect>
                                    </g>
                                </svg>
                                <div class="min-w-0">
                                    <span class="block font-mono text-[11px] font-bold tracking-[1px] text-slate-900">QR DEMO · 2022-04921</span>
                                    <span class="mt-0.5 block font-mono text-[11px] font-bold text-slate-500">MAT: 2022-04921-UNEFA</span>
                                    <span class="mt-1 block text-[11px] font-semibold text-slate-500">Código ilustrativo, no válido para accesos</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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

        {{-- Retorno al inicio de sesion --}}
        <div class="mb-2 mt-4 flex justify-center">
            <a href="{{ route('login') }}" class="flex items-center gap-2 rounded-xl border border-slate-300 bg-slate-100 px-5 py-3 text-[13px] font-extrabold text-unefa-navy transition hover:bg-slate-200">
                @include('partials.icon', ['name' => 'arrow-left', 'clase' => 'h-4 w-4 text-unefa-navy'])
                Volver al inicio de sesión
            </a>
        </div>
    </div>
@endsection
