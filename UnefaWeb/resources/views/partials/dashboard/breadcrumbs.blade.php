{{-- Ruta de navegacion reutilizable del dashboard. --}}
@php $items = $items ?? []; @endphp
@if(!empty($items))
    <nav aria-label="Ruta de navegación" class="text-xs font-semibold text-text-muted flex items-center gap-2 flex-wrap">
        @foreach($items as $indice => $item)
            @if($indice > 0)
                <span aria-hidden="true">/</span>
            @endif
            @if(!empty($item['url']))
                <a href="{{ $item['url'] }}" class="hover:text-unefa-blue">{{ $item['texto'] }}</a>
            @else
                <span class="text-unefa-navy font-bold">{{ $item['texto'] }}</span>
            @endif
        @endforeach
    </nav>
@endif
