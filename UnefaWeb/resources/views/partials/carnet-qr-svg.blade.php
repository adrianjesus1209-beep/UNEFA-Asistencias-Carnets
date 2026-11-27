{{-- Codigo QR ilustrativo del carnet estudiantil (componente compartido entre tarjeta y vista ampliada). --}}
@php
    $clase = $clase ?? 'h-24 w-24';
    $decorativo = !empty($decorativo);
    $etiqueta = $ariaLabel ?? 'Código QR de demostración de la matrícula 2022-04921';
@endphp
<svg
    viewBox="0 0 25 25"
    shape-rendering="crispEdges"
    class="{{ $clase }} shrink-0 rounded bg-white"
    @if($decorativo)
        aria-hidden="true"
    @else
        role="img"
        aria-label="{{ $etiqueta }}"
    @endif
>
    <rect width="25" height="25" fill="#ffffff"></rect>
    <g fill="#06152a">
        <rect x="1" y="1" width="7" height="7"></rect>
        <rect x="17" y="1" width="7" height="7"></rect>
        <rect x="1" y="17" width="7" height="7"></rect>
    </g>
    <g fill="#ffffff">
        <rect x="2" y="2" width="5" height="5"></rect>
        <rect x="18" y="2" width="5" height="5"></rect>
        <rect x="2" y="18" width="5" height="5"></rect>
    </g>
    <g fill="#06152a">
        <rect x="3" y="3" width="3" height="3"></rect>
        <rect x="19" y="3" width="3" height="3"></rect>
        <rect x="3" y="19" width="3" height="3"></rect>
    </g>
    <g fill="#06152a">
        <rect x="9" y="1" width="1" height="1"></rect><rect x="11" y="1" width="2" height="1"></rect><rect x="14" y="1" width="1" height="1"></rect>
        <rect x="9" y="3" width="2" height="1"></rect><rect x="13" y="3" width="1" height="1"></rect><rect x="15" y="3" width="2" height="1"></rect>
        <rect x="10" y="5" width="1" height="1"></rect><rect x="12" y="5" width="3" height="1"></rect>
        <rect x="9" y="6" width="1" height="1"></rect><rect x="11" y="6" width="1" height="1"></rect><rect x="13" y="6" width="2" height="1"></rect><rect x="16" y="6" width="1" height="1"></rect>
        <rect x="1" y="9" width="1" height="2"></rect><rect x="3" y="9" width="2" height="1"></rect><rect x="6" y="9" width="1" height="1"></rect>
        <rect x="9" y="8" width="2" height="1"></rect><rect x="12" y="8" width="1" height="2"></rect><rect x="15" y="8" width="2" height="1"></rect><rect x="18" y="8" width="1" height="1"></rect><rect x="21" y="8" width="2" height="1"></rect>
        <rect x="9" y="10" width="1" height="2"></rect><rect x="11" y="11" width="2" height="1"></rect><rect x="14" y="10" width="1" height="2"></rect><rect x="17" y="10" width="2" height="1"></rect><rect x="21" y="10" width="1" height="2"></rect>
        <rect x="9" y="12" width="3" height="1"></rect><rect x="14" y="13" width="2" height="1"></rect><rect x="18" y="12" width="1" height="2"></rect><rect x="22" y="13" width="1" height="1"></rect>
        <rect x="1" y="14" width="2" height="1"></rect><rect x="4" y="14" width="1" height="2"></rect><rect x="6" y="15" width="1" height="1"></rect>
        <rect x="9" y="15" width="1" height="2"></rect><rect x="12" y="14" width="2" height="2"></rect><rect x="16" y="15" width="3" height="1"></rect><rect x="21" y="15" width="1" height="1"></rect>
        <rect x="9" y="18" width="2" height="1"></rect><rect x="12" y="17" width="1" height="2"></rect><rect x="15" y="18" width="1" height="2"></rect><rect x="18" y="17" width="2" height="1"></rect><rect x="22" y="18" width="1" height="2"></rect>
        <rect x="10" y="20" width="3" height="1"></rect><rect x="15" y="21" width="2" height="1"></rect><rect x="19" y="20" width="1" height="2"></rect><rect x="22" y="21" width="2" height="1"></rect>
        <rect x="9" y="22" width="1" height="2"></rect><rect x="12" y="23" width="2" height="1"></rect><rect x="16" y="22" width="1" height="2"></rect><rect x="19" y="23" width="3" height="1"></rect>
    </g>
</svg>
