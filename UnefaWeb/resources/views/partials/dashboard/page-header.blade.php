{{-- Encabezado de seccion reutilizable (titulo, descripcion, etiquetas o fecha). --}}
@php
    $etiquetas = $etiquetas ?? [];
    $fecha = $fecha ?? null;
    $descripcionHtml = $descripcionHtml ?? null;
@endphp
<div class="flex flex-col lg:flex-row lg:items-end justify-between gap-4">
    <div>
        <h1 class="text-2xl sm:text-[1.75rem] font-black tracking-tight text-unefa-navy">{{ $titulo }}</h1>
        @if(!empty($descripcionHtml))
            <p class="text-sm text-text-muted mt-1">{!! $descripcionHtml !!}</p>
        @elseif(!empty($descripcion))
            <p class="text-sm text-text-muted mt-1">{{ $descripcion }}</p>
        @endif

        @if(!empty($etiquetas))
            <div class="flex flex-wrap items-center gap-2 mt-2">
                @foreach($etiquetas as $tag)
                    <span class="px-2.5 py-0.5 rounded text-xs {{ $tag['clase'] ?? 'bg-bg-tertiary text-unefa-navy border border-border-primary font-bold' }}">
                        {{ $tag['texto'] }}
                    </span>
                @endforeach
            </div>
        @endif
    </div>

    @if(!empty($fecha))
        <div class="flex items-center gap-2 text-xs font-bold text-unefa-blue bg-white border border-border-primary px-3 py-1.5 rounded-lg self-start lg:self-auto">
            <span>{{ $fecha }}</span>
        </div>
    @endif
</div>
