{{-- Tarjeta de metrica del panel. Parametros: valor, etiqueta, acento (color texto),
     acentoBarra (color filete), icono (opcional), tipo/porcentaje (opcional). --}}
@php
    $tipo = $tipo ?? 'numero';
    $acento = $acento ?? 'text-slate-900';
    $acentoBarra = $acentoBarra ?? 'bg-slate-300';
    $porcentaje = (float) ($porcentaje ?? 0);
    $circunferencia = 94.25;
    $relleno = round(($porcentaje / 100) * $circunferencia, 2);
@endphp
<div class="relative overflow-hidden rounded-[14px] border border-slate-200 bg-white p-3.5 text-center shadow-sm ring-1 ring-slate-100 transition duration-150 hover:-translate-y-0.5 hover:shadow-md motion-reduce:transform-none motion-reduce:transition-none">
    <span class="absolute inset-x-0 top-0 h-[3px] {{ $acentoBarra }}" aria-hidden="true"></span>

    @if($tipo === 'porcentaje')
        <div class="mb-1 flex justify-center">
            <svg viewBox="0 0 36 36" class="h-9 w-9 -rotate-90" role="img" aria-label="Progreso: {{ $porcentaje }}%">
                <circle cx="18" cy="18" r="15" fill="none" stroke="#e2e8f0" stroke-width="3"></circle>
                <circle cx="18" cy="18" r="15" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" class="{{ $acento }}" stroke-dasharray="{{ $relleno }} {{ $circunferencia }}"></circle>
            </svg>
        </div>
    @elseif(!empty($icono))
        <span class="mx-auto mb-1 flex h-7 w-7 items-center justify-center rounded-lg bg-slate-100">
            @include('partials.icon', ['name' => $icono, 'clase' => 'h-4 w-4 ' . $acento])
        </span>
    @endif

    <p class="mb-1 text-[24px] font-black leading-none {{ $acento }}">{{ $valor }}</p>
    <p class="mt-1 text-[11px] font-semibold leading-4 text-slate-600">{{ $etiqueta }}</p>

    @if(!empty($nota))
        <p class="mt-1 text-[10px] font-bold {{ $notaColor ?? 'text-slate-400' }}">{{ $nota }}</p>
    @endif
</div>
