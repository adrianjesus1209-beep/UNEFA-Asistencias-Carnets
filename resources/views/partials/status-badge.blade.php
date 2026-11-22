{{-- Badge de estado con semantica visual. Parametros: texto, tipo (success|warning|info|neutral). --}}
@php
    $estilos = [
        'success' => 'bg-emerald-100 text-emerald-700 ring-emerald-600/20',
        'warning' => 'bg-amber-100 text-amber-700 ring-amber-600/20',
        'info' => 'bg-slate-100 text-slate-700 ring-slate-500/20',
        'neutral' => 'bg-slate-100 text-slate-600 ring-slate-500/20',
    ];
    $tipo = $tipo ?? 'neutral';
    $clase = $estilos[$tipo] ?? $estilos['neutral'];
@endphp
<span class="inline-flex items-center gap-1 rounded-lg px-2 py-1 text-[11px] font-extrabold ring-1 ring-inset {{ $clase }}">
    {{ $texto }}
</span>
