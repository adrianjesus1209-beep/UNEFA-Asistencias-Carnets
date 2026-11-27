{{-- Tarjeta KPI reutilizable (sirve para Inicio, Asistencia y futuros roles). --}}
@php
    $borde = $borde ?? 'border-t-unefa-blue';
    $superficie = $superficie ?? 'bg-white';
    $tamanoValor = $tamanoValor ?? 'text-3xl';
    $subtituloClase = $subtituloClase ?? 'font-semibold text-text-muted';
    $compacta = !empty($compacta);
@endphp
<div class="{{ $compacta ? 'p-4 rounded-lg bg-bg-secondary' : 'p-5 rounded-xl shadow-panel ' . $superficie }} border-[1.5px] border-border-primary border-t-4 {{ $borde }}">
    <span class="block text-xs font-bold uppercase tracking-wider text-text-muted">{{ $titulo }}</span>
    @if(!empty($insignia))
        <span class="inline-flex items-center gap-1.5 mt-1.5 px-2.5 py-0.5 rounded-full text-xs font-extrabold uppercase {{ $insigniaClase ?? 'bg-[#d1fae5] text-[#065f46]' }}">
            {{ $insignia }}
        </span>
    @else
        <span class="block {{ $tamanoValor }} font-black text-unefa-navy mt-1">{{ $valor }}</span>
    @endif
    @if(!empty($subtitulo))
        <span class="block text-xs {{ $subtituloClase }} {{ !empty($insignia) ? 'mt-1.5' : 'mt-1' }}">{{ $subtitulo }}</span>
    @endif
</div>
