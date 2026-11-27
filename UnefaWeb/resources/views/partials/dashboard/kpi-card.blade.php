{{-- Tarjeta KPI reutilizable (sirve para Inicio, Asistencia y futuros roles). --}}
@php
    $borde = $borde ?? 'border-t-unefa-blue';
    $barrasColor = [
        'border-t-unefa-blue' => 'bg-unefa-blue',
        'border-t-unefa-green' => 'bg-unefa-green',
        'border-t-unefa-gold' => 'bg-unefa-gold',
        'border-t-unefa-red' => 'bg-unefa-red',
    ];
    $barraClase = $barraColor ?? ($barrasColor[$borde] ?? 'bg-unefa-blue');
    $superficie = $superficie ?? 'bg-white';
    $tamanoValor = $tamanoValor ?? 'text-3xl';
    $subtituloClase = $subtituloClase ?? 'font-semibold text-text-muted';
    $valorClase = $valorClase ?? 'text-unefa-navy';
    $compacta = !empty($compacta);
@endphp
<div class="{{ $compacta ? 'rounded-lg bg-bg-secondary' : 'rounded-xl shadow-panel ' . $superficie }} border-[1.5px] border-border-primary overflow-hidden">
    <div class="h-1 w-full {{ $barraClase }}" aria-hidden="true"></div>
    <div class="{{ $compacta ? 'p-4' : 'p-5' }}">
        <span class="block text-xs font-bold uppercase tracking-wider text-text-muted">{{ $titulo }}</span>
        @if(!empty($insignia))
            <span class="inline-flex items-center gap-1.5 mt-1.5 px-2.5 py-0.5 rounded-full text-xs font-extrabold uppercase {{ $insigniaClase ?? 'bg-[#d1fae5] text-[#065f46]' }}">
                {{ $insignia }}
            </span>
        @else
            <span @if(!empty($valorId)) id="{{ $valorId }}" @endif class="block {{ $tamanoValor }} font-black {{ $valorClase }} mt-1">{{ $valor }}</span>
        @endif
        @if(!empty($subtitulo))
            <span class="block text-xs {{ $subtituloClase }} {{ !empty($insignia) ? 'mt-1.5' : 'mt-1' }}">{{ $subtitulo }}</span>
        @endif
    </div>
</div>
