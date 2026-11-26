@extends('layouts.dashboard')

@section('title', 'Panel Director | Portal UNEFA')
@section('header-subtitle', 'Panel Director')
@section('descripcion', 'Panel del director del Sistema Integral de Asistencias y Carnetización Digital de la UNEFA. Período académico 2026-I.')

@section('content')
    {{-- Contenido tomado de la vista director del dashboard de UnefaApp (src/app/dashboard.tsx). --}}
    @include('partials.selector-entidad', ['activo' => 'director'])

    <div class="mt-4">
        @include('partials.session-banner', [
            'insignia' => 'DIRECCIÓN GENERAL DE NÚCLEO',
            'insigniaFondo' => 'bg-[rgba(6,21,42,0.12)]',
            'insigniaTexto' => 'text-unefa-navy',
            'icono' => 'shield-check',
            'acentoFondo' => 'bg-unefa-navy',
            'bordeClase' => 'border-unefa-navy',
            'nombre' => 'Cnel. Roberto Silva Pacheco',
            'cedula' => 'V-09.876.543',
            'departamento' => 'Dirección General de Núcleo · Decanato Militar',
            'subtitulo' => 'Comando y Gestión Académica Institucional',
            'matricula' => 'DIR-UNEFA-001',
        ])

        <div class="flex flex-col gap-5">
            {{-- Metricas institucionales --}}
            <div class="grid grid-cols-2 gap-2.5 lg:grid-cols-4">
                <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5 text-center">
                    <p class="mb-1 text-[22px] font-black text-unefa-navy">3.450</p>
                    <p class="text-[11px] font-semibold text-slate-500">Matrícula total núcleo</p>
                </div>
                <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5 text-center">
                    <p class="mb-1 text-[22px] font-black text-slate-900">210</p>
                    <p class="text-[11px] font-semibold text-slate-500">Personal activo</p>
                </div>
                <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5 text-center">
                    <p class="mb-1 text-[22px] font-black text-unefa-green">95.1%</p>
                    <p class="text-[11px] font-semibold text-slate-500">Asistencia general</p>
                </div>
                <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5 text-center">
                    <p class="mb-1 text-[22px] font-black text-unefa-goldDark">100%</p>
                    <p class="text-[11px] font-semibold text-slate-500">Gratuidad garantizada</p>
                </div>
            </div>

            {{-- Modulo: Supervision general de nucleo --}}
            <div class="rounded-[18px] border border-slate-200 bg-white p-4">
                <div class="mb-3.5 flex flex-wrap items-start justify-between gap-2">
                    <div>
                        <p class="mb-0.5 text-[10px] font-extrabold uppercase tracking-[0.6px] text-unefa-blue">DIRECCIÓN GENERAL Y MANDO</p>
                        <p class="text-base font-black text-slate-900">Supervisión consolidada de sedes</p>
                    </div>
                    <span class="rounded-lg bg-[rgba(6,21,42,0.1)] px-2 py-1 text-[11px] font-extrabold text-unefa-navy">Mando Soberano</span>
                </div>

                {{-- Reporte por carreras --}}
                <div class="mb-3.5 rounded-[14px] border border-slate-200 bg-slate-50 p-3.5">
                    <p class="mb-3 text-[13px] font-extrabold text-slate-900">Asistencia consolidada por facultad</p>

                    <div class="mb-2.5">
                        <div class="mb-1 flex justify-between">
                            <span class="text-[11px] font-semibold text-slate-700">Facultad de Ingeniería</span>
                            <span class="text-[11px] font-extrabold text-unefa-navy">96.2%</span>
                        </div>
                        <div class="h-2 overflow-hidden rounded bg-slate-200">
                            <div class="h-full rounded bg-unefa-navy" style="width: 96%;"></div>
                        </div>
                    </div>

                    <div class="mb-2.5">
                        <div class="mb-1 flex justify-between">
                            <span class="text-[11px] font-semibold text-slate-700">Facultad de Ciencias Sociales</span>
                            <span class="text-[11px] font-extrabold text-unefa-navy">93.5%</span>
                        </div>
                        <div class="h-2 overflow-hidden rounded bg-slate-200">
                            <div class="h-full rounded bg-unefa-navy" style="width: 93%;"></div>
                        </div>
                    </div>

                    <div class="mb-2.5">
                        <div class="mb-1 flex justify-between">
                            <span class="text-[11px] font-semibold text-slate-700">Técnico Superior Universitario</span>
                            <span class="text-[11px] font-extrabold text-unefa-navy">95.0%</span>
                        </div>
                        <div class="h-2 overflow-hidden rounded bg-slate-200">
                            <div class="h-full rounded bg-unefa-navy" style="width: 95%;"></div>
                        </div>
                    </div>

                    <div>
                        <div class="mb-1 flex justify-between">
                            <span class="text-[11px] font-semibold text-slate-700">Curso Integral de Nivelación Universitaria</span>
                            <span class="text-[11px] font-extrabold text-unefa-navy">97.4%</span>
                        </div>
                        <div class="h-2 overflow-hidden rounded bg-slate-200">
                            <div class="h-full rounded bg-unefa-navy" style="width: 97%;"></div>
                        </div>
                    </div>
                </div>

                {{-- Indicadores clave de operatividad --}}
                <div class="grid grid-cols-2 gap-2.5 lg:grid-cols-4">
                    <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3 text-center">
                        <span class="flex justify-center">
                            @include('partials.icon', ['name' => 'building-2', 'clase' => 'h-[22px] w-[22px] text-unefa-navy'])
                        </span>
                        <p class="mb-0.5 mt-1.5 text-base font-black text-slate-900">4 Sedes</p>
                        <p class="text-[10px] font-semibold text-slate-500">Extensiones del núcleo operando</p>
                    </div>
                    <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3 text-center">
                        <span class="flex justify-center">
                            @include('partials.icon', ['name' => 'qr-code', 'clase' => 'h-[22px] w-[22px] text-unefa-blue'])
                        </span>
                        <p class="mb-0.5 mt-1.5 text-base font-black text-slate-900">3.120 lecturas</p>
                        <p class="text-[10px] font-semibold text-slate-500">Accesos por carnet QR hoy</p>
                    </div>
                    <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3 text-center">
                        <span class="flex justify-center">
                            @include('partials.icon', ['name' => 'users', 'clase' => 'h-[22px] w-[22px] text-unefa-green'])
                        </span>
                        <p class="mb-0.5 mt-1.5 text-base font-black text-slate-900">1.450 raciones</p>
                        <p class="text-[10px] font-semibold text-slate-500">Comedor estudiantil solvente</p>
                    </div>
                    <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3 text-center">
                        <span class="flex justify-center">
                            @include('partials.icon', ['name' => 'shield-check', 'clase' => 'h-[22px] w-[22px] text-unefa-goldDark'])
                        </span>
                        <p class="mb-0.5 mt-1.5 text-base font-black text-slate-900">0 Novedades</p>
                        <p class="text-[10px] font-semibold text-slate-500">Doctrina y disciplina militar</p>
                    </div>
                </div>
            </div>

            {{-- Acciones de direccion --}}
            <div class="rounded-[18px] border border-slate-200 bg-white p-4">
                <p class="mb-0.5 text-[10px] font-extrabold uppercase tracking-[0.6px] text-unefa-blue">COMANDO INSTITUCIONAL</p>
                <p class="text-base font-black text-slate-900">Acciones directivas estratégicas</p>

                <div class="mt-2.5 grid gap-2 lg:grid-cols-2">
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                        <p class="mb-0.5 text-[13px] font-extrabold text-slate-900">Reporte al Vicerrectorado Académico</p>
                        <p class="text-[11px] leading-4 text-slate-500">Consolidado de auditoría semestral y rendimiento de núcleos</p>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                        <p class="mb-0.5 text-[13px] font-extrabold text-slate-900">Auditoría Integral del Portal</p>
                        <p class="text-[11px] leading-4 text-slate-500">Supervisión de actas de grado y récord académico nacional</p>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                        <p class="mb-0.5 text-[13px] font-extrabold text-slate-900">Plan Soberanía y Defensa 2026</p>
                        <p class="text-[11px] leading-4 text-slate-500">Seguimiento de convenios tecnológicos con la FANB</p>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                        <p class="mb-0.5 text-[13px] font-extrabold text-slate-900">Aprobación de cupos de ingreso 2026-II</p>
                        <p class="text-[11px] leading-4 text-slate-500">Planificación de cupos para bachilleres de nuevo ingreso</p>
                    </div>
                </div>
            </div>
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
