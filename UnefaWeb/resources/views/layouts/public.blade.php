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
<body class="@yield('body-class', 'bg-white font-sans text-neutral-950')">
    @hasSection('header')
        @yield('header')
    @else
        @include('partials.header')
    @endif

    <main>
        @yield('content')
    </main>

    @hasSection('footer')
        @yield('footer')
    @endif

    @include('partials.qr-modal')

    <script src="{{ asset('js/app.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
