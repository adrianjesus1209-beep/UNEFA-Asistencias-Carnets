{{-- Barra de progreso accesible. Parametros: porcentaje, etiqueta, color, textoColor. --}}
@php
    $porcentaje = max(0, min(100, (int) ($porcentaje ?? 0)));
    $color = $color ?? 'bg-slate-500';
    $textoColor = $textoColor ?? 'text-slate-600';
    $etiqueta = $etiqueta ?? 'Progreso';
@endphp
<div>
    <div class="mb-1 flex items-center justify-between gap-2">
        <span class="text-[10px] font-semibold text-slate-500">{{ $etiqueta }}</span>
        <span class="text-[11px] font-black {{ $textoColor }}">{{ $porcentaje }}%</span>
    </div>
    <div class="h-1.5 overflow-hidden rounded-full bg-slate-200" role="progressbar" aria-valuenow="{{ $porcentaje }}" aria-valuemin="0" aria-valuemax="100" aria-label="{{ $etiqueta }}">
        <div class="h-full rounded-full {{ $color }} transition-all duration-500 motion-reduce:transition-none" style="width: {{ $porcentaje }}%"></div>
    </div>
</div>
