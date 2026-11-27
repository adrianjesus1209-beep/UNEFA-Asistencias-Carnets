<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'UNEFA')</title>
    <meta name="description" content="@yield('descripcion', 'Portal web de la Universidad Nacional Experimental Politécnica de la Fuerza Armada Nacional Bolivariana.')" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logos/logo_unefa.png') }}" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    @stack('styles')
</head>
<body class="bg-white font-sans text-neutral-950">
    <header class="sticky top-0 z-40 border-b border-slate-200 bg-white">
        <div class="mx-auto flex h-16 w-full max-w-5xl items-center justify-between px-4">
            <a href="{{ route('landing') }}" class="flex items-center gap-2.5" aria-label="Ir al inicio">
                <span class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-white p-0.5">
                    <img src="{{ asset('assets/img/logos/logo_unefa.png') }}" alt="Logo de la UNEFA" class="h-7 w-7 object-contain" />
                </span>
                <span class="flex flex-col justify-center">
                    <span class="text-base font-black tracking-wider text-slate-900">UNEFA</span>
                    <span class="text-[10px] font-semibold uppercase tracking-wide text-slate-500">@yield('header-subtitle', 'Portal Académico')</span>
                </span>
            </a>

            <div class="flex items-center gap-2">
                <a href="{{ route('landing') }}" class="flex h-9 items-center gap-1.5 rounded-full border border-slate-200 bg-slate-50 px-3 text-xs font-bold text-slate-900 transition hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-900">
                    @include('partials.icon', ['name' => 'arrow-left', 'clase' => 'h-3.5 w-3.5 text-slate-900'])
                    Inicio
                </a>
                <a href="{{ route('login') }}" class="flex h-9 items-center gap-1.5 rounded-full border border-red-200 bg-red-50 px-3 text-xs font-bold text-unefa-red transition hover:bg-red-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-900">
                    @include('partials.icon', ['name' => 'log-out', 'clase' => 'h-3.5 w-3.5 text-unefa-red'])
                    Cerrar sesión
                </a>
            </div>
        </div>
    </header>

    <main class="mx-auto w-full max-w-5xl px-4 pb-16 pt-5">
        @yield('content')
    </main>

    <script src="{{ asset('js/app.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
