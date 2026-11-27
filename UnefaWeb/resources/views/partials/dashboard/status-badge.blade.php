{{-- Insignia de estado semantico reutilizable. --}}
@php
    $variante = $variante ?? 'neutral';
    $estilos = [
        'success' => 'bg-[#d1fae5] text-[#065f46]',
        'info' => 'bg-unefa-blue/10 text-unefa-blue',
        'warning' => 'bg-unefa-gold/25 text-unefa-navy border border-unefa-gold-dark',
        'danger' => 'bg-unefa-red text-white',
        'neutral' => 'bg-bg-tertiary text-text-muted',
    ];
    $clase = $estilos[$variante] ?? $estilos['neutral'];
@endphp
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-extrabold {{ $clase }}">
    {{ $texto }}
</span>
