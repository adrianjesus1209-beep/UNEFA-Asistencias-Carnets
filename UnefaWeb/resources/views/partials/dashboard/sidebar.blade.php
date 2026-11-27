{{-- Barra lateral institucional reutilizable para cualquier rol del portal SICEU. --}}
@php
    $menu = $menu ?? [];
    $seccionActiva = $seccionActiva ?? 'inicio';
    $rol = $rol ?? 'estudiante';
    $usuario = $usuario ?? [];
    $canalBadge = $canalBadge ?? 'v2.0';
    $subtituloMovil = $usuario['subtituloMovil'] ?? (($usuario['cedula'] ?? '') . ' · Periodo 2026-II');
@endphp
<aside
    id="dashboardSidebar"
    aria-label="Menú principal del portal"
    class="fixed lg:sticky top-16 left-0 z-40 w-64 h-[calc(100vh-4rem)] bg-unefa-navy text-white border-r border-white/12 flex flex-col justify-between transform -translate-x-full lg:translate-x-0 transition-transform duration-200 shrink-0"
>
    <div class="py-5 overflow-y-auto">
        <div class="px-4 pb-3 mb-2 border-b border-white/10 lg:hidden">
            <p class="text-sm font-extrabold text-white">{{ $usuario['nombreMovil'] ?? ($usuario['nombreCompleto'] ?? 'Usuario UNEFA') }}</p>
            <p class="text-xs font-mono text-unefa-gold">{{ $subtituloMovil }}</p>
        </div>

        <p class="px-4 mb-2 text-[0.68rem] font-extrabold uppercase tracking-[0.12em] text-[#b0c6ff]/70">
            {{ $tituloMenu ?? 'Navegación Académica' }}
        </p>

        <ul class="list-none p-0 m-0 flex flex-col gap-0.5">
            @foreach($menu as $item)
                @php
                    $clavesActivas = $item['activos'] ?? [$item['clave']];
                    $esActual = in_array($seccionActiva, $clavesActivas, true);
                @endphp
                <li>
                    <a
                        href="{{ route('dashboard', ['rol' => $rol, 'seccion' => $item['clave']]) }}"
                        @if($esActual) aria-current="page" @endif
                        class="nav-item flex items-center gap-3 px-4 py-3 text-[0.9rem] no-underline {{ $esActual ? 'text-white font-bold' : 'text-[#d8e3fb] hover:bg-unefa-navy-soft/70 hover:text-white font-semibold' }}"
                    >
                        <span class="{{ $esActual ? 'text-unefa-gold' : 'text-[#b0c6ff]' }} shrink-0">
                            @include('partials.icon', ['name' => $item['icono'], 'clase' => 'w-[18px] h-[18px]'])
                        </span>
                        <span>{{ $item['etiqueta'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Pie de Sidebar: Estado de Conexion + Cerrar Sesion --}}
    <div class="p-4 border-t border-white/12 flex flex-col gap-3">
        <div class="px-3 py-2 rounded-md bg-unefa-navy-soft/80 border border-white/10 text-[0.72rem] text-[#d8e3fb] flex items-center justify-between">
            <span class="inline-flex items-center gap-1.5 font-semibold">
                <span class="w-2 h-2 rounded-full bg-unefa-green" aria-hidden="true"></span>
                Socket.IO Activo
            </span>
            <span class="font-mono text-[0.68rem] text-[#b0c6ff]">{{ $canalBadge }}</span>
        </div>

        <button
            type="button"
            data-open-logout
            class="w-full min-h-[2.75rem] px-4 py-2.5 rounded-md bg-transparent border border-white/20 text-[#d8e3fb] hover:bg-unefa-red/20 hover:border-unefa-red hover:text-white text-[0.86rem] font-bold flex items-center gap-2.5 cursor-pointer transition-colors"
        >
            @include('partials.icon', ['name' => 'log-out', 'clase' => 'w-[17px] h-[17px]'])
            <span>Cerrar Sesión</span>
        </button>
    </div>
</aside>
