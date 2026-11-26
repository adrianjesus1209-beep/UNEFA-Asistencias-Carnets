@extends('layouts.dashboard')

@php
    $director = $director ?? [
        'nombre'       => 'Director UNEFA',
        'cedula'       => 'V-0',
        'departamento' => 'Dirección General de Núcleo',
        'subtitulo'    => 'Comando y Gestión Académica Institucional',
        'matricula'    => 'DIR-UNEFA-001',
    ];
    $periodo = $periodo ?? ['id' => null, 'nombre' => '2026-1'];
    $metricas = $metricas ?? [
        'matricula_total'    => '0',
        'personal_activo'    => '0',
        'asistencia_general' => '0.0%',
        'gratuidad'          => '100%',
        'lecturas_qr'        => '0 lecturas',
    ];
    $carreras = $carreras ?? [];
    $coordinadores = $coordinadores ?? [];
@endphp

@section('title', 'Panel Director | Portal UNEFA')
@section('header-subtitle', 'Panel Director')

@section('content')
    @include('partials.selector-entidad', ['activo' => 'director'])

    @if(session('director_status'))
        <div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-xs font-bold text-emerald-800" role="status">
            {{ session('director_status') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mt-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-xs font-bold text-red-700" role="alert">
            <p class="mb-1 font-extrabold">Revise los datos ingresados:</p>
            <ul class="list-disc space-y-0.5 pl-4 font-semibold">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mt-4">
        @include('partials.session-banner', [
            'insignia'      => 'DIRECCIÓN GENERAL DE NÚCLEO',
            'insigniaFondo' => 'bg-[rgba(6,21,42,0.12)]',
            'insigniaTexto' => 'text-unefa-navy',
            'icono'         => 'shield-check',
            'acentoFondo'   => 'bg-unefa-navy',
            'bordeClase'    => 'border-unefa-navy',
            'nombre'        => $director['nombre'],
            'cedula'        => $director['cedula'],
            'departamento'  => $director['departamento'],
            'subtitulo'     => $director['subtitulo'],
            'matricula'     => $director['matricula'],
        ])

        <div class="flex flex-col gap-5">
            <div class="grid grid-cols-2 gap-2.5 lg:grid-cols-4">
                <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5 text-center">
                    <p class="mb-1 text-[22px] font-black text-unefa-navy">{{ $metricas['matricula_total'] }}</p>
                    <p class="text-[11px] font-semibold text-slate-500">Matrícula total núcleo</p>
                </div>
                <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5 text-center">
                    <p class="mb-1 text-[22px] font-black text-slate-900">{{ $metricas['personal_activo'] }}</p>
                    <p class="text-[11px] font-semibold text-slate-500">Personal activo</p>
                </div>
                <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5 text-center">
                    <p class="mb-1 text-[22px] font-black text-unefa-green">{{ $metricas['asistencia_general'] }}</p>
                    <p class="text-[11px] font-semibold text-slate-500">Asistencia general</p>
                </div>
                <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3.5 text-center">
                    <p class="mb-1 text-[22px] font-black text-unefa-goldDark">{{ $metricas['gratuidad'] }}</p>
                    <p class="text-[11px] font-semibold text-slate-500">Gratuidad garantizada</p>
                </div>
            </div>

            <div class="rounded-[18px] border border-slate-200 bg-white p-4">
                <div class="mb-3.5 flex flex-wrap items-start justify-between gap-2">
                    <div>
                        <p class="mb-0.5 text-[10px] font-extrabold uppercase tracking-[0.6px] text-unefa-blue">DIRECCIÓN GENERAL Y MANDO</p>
                        <p class="text-base font-black text-slate-900">Supervisión consolidada de carreras</p>
                    </div>
                    <span class="rounded-lg bg-[rgba(6,21,42,0.1)] px-2 py-1 text-[11px] font-extrabold text-unefa-navy">Período {{ $periodo['nombre'] }}</span>
                </div>

                <div class="mb-3.5 rounded-[14px] border border-slate-200 bg-slate-50 p-3.5">
                    <p class="mb-3 text-[13px] font-extrabold text-slate-900">Cobertura y coordinadores por carrera</p>

                    @forelse($carreras as $carrera)
                        <div class="mb-2.5 last:mb-0">
                            <div class="mb-1 flex flex-wrap justify-between gap-2">
                                <span class="text-[11px] font-semibold text-slate-700">{{ $carrera['codigo'] }} · {{ $carrera['nombre'] }} ({{ $carrera['coordinador'] }})</span>
                                <span class="text-[11px] font-extrabold text-unefa-navy">{{ $carrera['alumnos'] }} est. · {{ $carrera['secciones'] }} sec.</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-[11px] font-semibold text-slate-500">No hay carreras registradas en el período actual.</p>
                    @endforelse
                </div>

                <div class="grid grid-cols-2 gap-2.5 lg:grid-cols-4">
                    <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3 text-center">
                        <span class="flex justify-center">
                            @include('partials.icon', ['name' => 'building-2', 'clase' => 'h-[22px] w-[22px] text-unefa-navy'])
                        </span>
                        <p class="mb-0.5 mt-1.5 text-base font-black text-slate-900">{{ count($carreras) }} Carreras</p>
                        <p class="text-[10px] font-semibold text-slate-500">Oferta académica activa</p>
                    </div>
                    <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3 text-center">
                        <span class="flex justify-center">
                            @include('partials.icon', ['name' => 'qr-code', 'clase' => 'h-[22px] w-[22px] text-unefa-blue'])
                        </span>
                        <p class="mb-0.5 mt-1.5 text-base font-black text-slate-900">{{ $metricas['lecturas_qr'] }}</p>
                        <p class="text-[10px] font-semibold text-slate-500">Accesos por carnet QR</p>
                    </div>
                    <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3 text-center">
                        <span class="flex justify-center">
                            @include('partials.icon', ['name' => 'users', 'clase' => 'h-[22px] w-[22px] text-unefa-green'])
                        </span>
                        <p class="mb-0.5 mt-1.5 text-base font-black text-slate-900">{{ $metricas['matricula_total'] }}</p>
                        <p class="text-[10px] font-semibold text-slate-500">Estudiantes registrados</p>
                    </div>
                    <div class="rounded-[14px] border border-slate-200 bg-slate-50 p-3 text-center">
                        <span class="flex justify-center">
                            @include('partials.icon', ['name' => 'shield-check', 'clase' => 'h-[22px] w-[22px] text-unefa-goldDark'])
                        </span>
                        <p class="mb-0.5 mt-1.5 text-base font-black text-slate-900">{{ $metricas['asistencia_general'] }}</p>
                        <p class="text-[10px] font-semibold text-slate-500">Cumplimiento de asistencia</p>
                    </div>
                </div>
            </div>

            <div class="rounded-[18px] border border-slate-200 bg-white p-4">
                <p class="mb-0.5 text-[10px] font-extrabold uppercase tracking-[0.6px] text-unefa-blue">COMANDO INSTITUCIONAL</p>
                <p class="text-base font-black text-slate-900">Asignación de coordinación de carrera</p>

                <form method="POST" action="{{ route('dashboard.director.coordinadores.assign') }}" class="mt-3 grid gap-3 lg:grid-cols-3">
                    @csrf

                    <div>
                        <label for="career_id" class="mb-1 block text-xs font-bold text-slate-700">Carrera</label>
                        <select id="career_id" name="career_id" required class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-xs font-semibold text-slate-800 focus:border-unefa-navy focus:outline-none">
                            <option value="">Seleccione una carrera</option>
                            @foreach($carreras as $carrera)
                                <option value="{{ $carrera['id'] }}" @selected((string) old('career_id') === (string) $carrera['id'])>
                                    {{ $carrera['codigo'] }} · {{ $carrera['nombre'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="coordinator_id" class="mb-1 block text-xs font-bold text-slate-700">Coordinador Académico</label>
                        <select id="coordinator_id" name="coordinator_id" required class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-xs font-semibold text-slate-800 focus:border-unefa-navy focus:outline-none">
                            <option value="">Seleccione un coordinador</option>
                            @foreach($coordinadores as $coord)
                                <option value="{{ $coord['id'] }}" @selected((string) old('coordinator_id') === (string) $coord['id'])>
                                    {{ $coord['nombre'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full rounded-xl bg-unefa-navy px-4 py-2 text-xs font-extrabold text-white transition hover:opacity-95">
                            Asignar coordinador
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mb-2 mt-4 flex justify-center">
            <a href="{{ route('login') }}" class="flex items-center gap-2 rounded-xl border border-slate-300 bg-slate-100 px-5 py-3 text-[13px] font-extrabold text-unefa-navy transition hover:bg-slate-200">
                @include('partials.icon', ['name' => 'arrow-left', 'clase' => 'h-4 w-4 text-unefa-navy'])
                Volver al inicio de sesión
            </a>
        </div>
    </div>
@endsection