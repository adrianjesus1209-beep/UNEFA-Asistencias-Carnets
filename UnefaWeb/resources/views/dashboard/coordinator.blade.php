@extends('layouts.dashboard')

@section('title', 'Panel Coordinador | Portal UNEFA')
@section('header-subtitle', 'Panel Coordinador')
@section('descripcion', 'Panel del coordinador del Sistema Integral de Asistencias y Carnetización Digital de la UNEFA. Período académico 2026-I.')

@section('content')
    {{-- Contenido tomado de la vista coordinador del dashboard de UnefaApp (src/app/dashboard.tsx). --}}
    @include('partials.selector-entidad', ['activo' => 'coordinador'])

    <div class="mt-4">
        @include('partials.session-banner', [
            'insignia' => 'COORDINACIÓN DE CARRERA',
            'insigniaFondo' => 'bg-[rgba(180,83,9,0.1)]',
            'insigniaTexto' => 'text-[#b45309]',
            'icono' => 'clipboard-check',
            'acentoFondo' => 'bg-[#b45309]',
            'bordeClase' => 'border-[#b45309]',
            'nombre' => 'Dr. Marcos Peña Colmenares',
            'cedula' => 'V-11.234.567',
            'departamento' => 'Coordinación de Ing. Sistemas y Telemática',
            'subtitulo' => 'Decanato Académico · Núcleo Caracas',
            'matricula' => 'COORD-SIS-2026',
        ])

        <div class="flex flex-col gap-5">
            {{-- Metricas de coordinacion --}}
            <div class="grid grid-cols-2 gap-2.5 lg:grid-cols-4">
                <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5 text-center">
                    <p class="mb-1 text-[22px] font-black text-slate-900">645</p>
                    <p class="text-[11px] font-semibold text-slate-500">Matrícula carrera</p>
                </div>
                <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5 text-center">
                    <p class="mb-1 text-[22px] font-black text-slate-900">22</p>
                    <p class="text-[11px] font-semibold text-slate-500">Docentes adscritos</p>
                </div>
                <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5 text-center">
                    <p class="mb-1 text-[22px] font-black text-[#b45309]">24</p>
                    <p class="text-[11px] font-semibold text-slate-500">Secciones activas</p>
                </div>
                <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5 text-center">
                    <p class="mb-1 text-[22px] font-black text-unefa-green">93.8%</p>
                    <p class="text-[11px] font-semibold text-slate-500">Asistencia global</p>
                </div>
            </div>

            {{-- Modulo de supervision en tiempo real --}}
            <div class="rounded-[18px] border border-slate-200 bg-white p-4">
                <div class="mb-3.5 flex flex-wrap items-start justify-between gap-2">
                    <div>
                        <p class="mb-0.5 text-[10px] font-extrabold uppercase tracking-[0.6px] text-unefa-blue">SUPERVISIÓN DE CARRERA</p>
                        <p class="text-base font-black text-slate-900">cátedras y docentes</p>
                    </div>
                    <span class="rounded-lg bg-[rgba(180,83,9,0.1)] px-2 py-1 text-[11px] font-extrabold text-[#b45309]">Guacara · Activo</span>
                </div>

                <div class="grid gap-2.5 lg:grid-cols-2">
                    <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5">
                        <div class="mb-1.5 flex flex-wrap items-center justify-between gap-2">
                            <p class="text-[13px] font-extrabold text-slate-900">Asistencia de docentes</p>
                            <span class="rounded-lg bg-[rgba(180,83,9,0.1)] px-2 py-0.5 text-[10px] font-extrabold text-[#b45309]">91% Cumplimiento</span>
                        </div>
                        <p class="mb-1 text-[15px] font-black text-[#b45309]">20 de 22 docentes en aula</p>
                        <p class="text-[11px] leading-4 text-slate-500">Registro validado en sistemas y laboratorios de computación.</p>
                    </div>

                    <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5">
                        <div class="mb-1.5 flex flex-wrap items-center justify-between gap-2">
                            <p class="text-[13px] font-extrabold text-slate-900">Inasistencia Estudiantil</p>
                            <span class="rounded-lg bg-[rgba(180,83,9,0.1)] px-2 py-0.5 text-[10px] font-extrabold text-[#b45309]">Atención requerida</span>
                        </div>
                        <p class="mb-1 text-[15px] font-black text-[#b45309]">12 casos en seguimiento</p>
                        <p class="text-[11px] leading-4 text-slate-500">Estudiantes con más de 3 ausencias consecutivas.</p>
                    </div>

                    <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5">
                        <div class="mb-1.5 flex flex-wrap items-center justify-between gap-2">
                            <p class="text-[13px] font-extrabold text-slate-900">Disponibilidad de Laboratorios</p>
                            <span class="rounded-lg bg-[rgba(180,83,9,0.1)] px-2 py-0.5 text-[10px] font-extrabold text-[#b45309]">100% Funcional</span>
                        </div>
                        <p class="mb-1 text-[15px] font-black text-[#b45309]">5 salas y laboratorios operativos</p>
                        <p class="text-[11px] leading-4 text-slate-500">Lab Telemática, Sistemas, Redes, Física y Electrónica en uso.</p>
                    </div>

                    <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5">
                        <div class="mb-1.5 flex flex-wrap items-center justify-between gap-2">
                            <p class="text-[13px] font-extrabold text-slate-900">Consignación de Actas y Cortes</p>
                            <span class="rounded-lg bg-[rgba(180,83,9,0.1)] px-2 py-0.5 text-[10px] font-extrabold text-[#b45309]">En progreso</span>
                        </div>
                        <p class="mb-1 text-[15px] font-black text-[#b45309]">18 de 24 actas registradas</p>
                        <p class="text-[11px] leading-4 text-slate-500">Cierre de actas parciales de evaluación continua 2026-I.</p>
                    </div>
                </div>
            </div>

            {{-- Acciones de coordinacion --}}
            <div class="rounded-[18px] border border-slate-200 bg-white p-4">
                <p class="mb-0.5 text-[10px] font-extrabold uppercase tracking-[0.6px] text-unefa-blue">GESTIÓN DEPARTAMENTAL</p>
                <p class="text-base font-black text-slate-900">Acciones de carrera</p>

                <div class="mt-2.5 grid gap-2 lg:grid-cols-2">
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                        <p class="mb-0.5 text-[13px] font-extrabold text-slate-900">Asignación de Carga Académica</p>
                        <p class="text-[11px] leading-4 text-slate-500">Distribución de horas docentes y aprobación de horarios</p>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                        <p class="mb-0.5 text-[13px] font-extrabold text-slate-900">Validación de Jurados de Grado</p>
                        <p class="text-[11px] leading-4 text-slate-500">Aprobación de Trabajos Especiales de Grado (TEG)</p>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                        <p class="mb-0.5 text-[13px] font-extrabold text-slate-900">Solicitudes de Cambio de Sección</p>
                        <p class="text-[11px] leading-4 text-slate-500">5 solicitudes pendientes por cupo y compatibilidad</p>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                        <p class="mb-0.5 text-[13px] font-extrabold text-slate-900">Reporte al Decanato Académico</p>
                        <p class="text-[11px] leading-4 text-slate-500">Informe mensual de rendimiento y retención estudiantil</p>
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
