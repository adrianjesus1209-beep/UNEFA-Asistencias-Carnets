{{-- Selector de entidades para revisar la maqueta con cada rol; el backend lo sustituira por la sesion real. --}}
@php
    $activo = $activo ?? 'estudiante';
    $estiloActivo = $estiloActivo ?? 'border-unefa-navy bg-unefa-navy text-white';
    $estiloEyebrow = $estiloEyebrow ?? 'text-unefa-navy';
@endphp
<div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
    <div class="mb-2.5">
        <span class="mb-1.5 inline-flex items-center gap-1.5 rounded-md bg-[rgba(242,184,7,0.16)] px-2 py-[3px] text-[10px] font-extrabold tracking-[0.5px] {{ $estiloEyebrow }}">
            @include('partials.icon', ['name' => 'sparkles', 'clase' => 'h-3 w-3 ' . $estiloEyebrow])
            MÓDULOS DE EVALUACIÓN
        </span>
        <p class="text-xs font-bold text-slate-500">Cambiar vista de entidad:</p>
    </div>

    <div class="flex flex-wrap gap-1.5">
        <a href="{{ route('dashboard.estudiante') }}" class="rounded-[10px] border px-3 py-2 text-xs font-bold transition {{ $activo === 'estudiante' ? $estiloActivo : 'border-slate-300 bg-white text-slate-700 hover:bg-slate-100' }}">
            Estudiante
        </a>
        <a href="{{ route('dashboard.profesor') }}" class="rounded-[10px] border px-3 py-2 text-xs font-bold transition {{ $activo === 'profesor' ? $estiloActivo : 'border-slate-300 bg-white text-slate-700 hover:bg-slate-100' }}">
            Profesor
        </a>
        <a href="{{ route('dashboard.coordinador') }}" class="rounded-[10px] border px-3 py-2 text-xs font-bold transition {{ $activo === 'coordinador' ? $estiloActivo : 'border-slate-300 bg-white text-slate-700 hover:bg-slate-100' }}">
            Coordinador
        </a>
        <a href="{{ route('dashboard.director') }}" class="rounded-[10px] border px-3 py-2 text-xs font-bold transition {{ $activo === 'director' ? $estiloActivo : 'border-slate-300 bg-white text-slate-700 hover:bg-slate-100' }}">
            Director
        </a>
    </div>
</div>
