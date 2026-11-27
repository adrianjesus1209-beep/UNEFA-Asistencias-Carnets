<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Panel Principal — SICEU UNEFA')</title>
    <meta name="description" content="@yield('descripcion', 'Portal institucional SICEU de la Universidad Nacional Experimental Politécnica de la Fuerza Armada Nacional Bolivariana.')" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logos/logo_unefa.png') }}" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    @stack('styles')
</head>
@php
    $rolMeta = $rolMeta ?? [];
    $usuario = $usuario ?? [];
    $notificaciones = $notificaciones ?? [];
    $logoFallback = "data:image/svg+xml;utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Ccircle cx='32' cy='32' r='30' fill='%23002855' stroke='%23f2b807' stroke-width='3'/%3E%3Cpath d='M32 10 L48 18 V34 C48 44 41 51 32 55 C23 51 16 44 16 34 V18 Z' fill='%2306152a' stroke='%23f2b807' stroke-width='2'/%3E%3Ctext x='32' y='37' text-anchor='middle' font-family='sans-serif' font-size='11' font-weight='900' fill='%23f2b807'%3EUNEFA%3C/text%3E%3C/svg%3E";
    $avatarSvg = "data:image/svg+xml;utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 180 240'%3E%3Crect width='180' height='240' fill='%23e9eef6'/%3E%3Ccircle cx='90' cy='86' r='36' fill='%230b2545'/%3E%3Cpath d='M28 240 C34 176 58 148 90 148 C122 148 146 176 152 240 Z' fill='%23002855'/%3E%3Cpath d='M74 149 L90 184 L106 149 Z' fill='%23ffffff'/%3E%3Cpath d='M86 160 L90 198 L94 160 Z' fill='%23f2b807'/%3E%3C/svg%3E";
@endphp
<body class="siceu-portal min-h-screen flex flex-col bg-bg-page text-text-primary font-sans" data-login-url="{{ route('login') }}">
    {{-- Enlace de salto accesible --}}
    <a
        href="#contenido-principal"
        class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-[200] focus:bg-unefa-gold focus:text-unefa-navy focus:font-extrabold focus:px-4 focus:py-2 focus:rounded-md focus:shadow-lg"
    >
        Ir al contenido principal
    </a>

    {{-- Barra Institucional Superior Fija --}}
    <header class="sticky top-0 z-50 w-full bg-unefa-navy text-white border-b-2 border-unefa-gold">
        <div class="h-16 px-4 lg:px-6 flex items-center justify-between gap-4">
            {{-- Izquierda: Boton movil + Identidad UNEFA --}}
            <div class="flex items-center gap-3 min-w-0">
                <button
                    type="button"
                    id="mobileSidebarToggle"
                    class="inline-flex lg:hidden items-center justify-center w-11 h-11 rounded-md bg-unefa-navy-soft border border-white/15 text-white cursor-pointer"
                    aria-label="Abrir menú lateral"
                    aria-expanded="false"
                    aria-controls="dashboardSidebar"
                >
                    @include('partials.icon', ['name' => 'menu', 'clase' => 'w-[22px] h-[22px]'])
                </button>

                <a href="{{ route('dashboard', ['rol' => $rol ?? 'estudiante', 'seccion' => 'inicio']) }}" class="flex items-center gap-3 no-underline shrink-0">
                    <div class="w-9.5 h-9.5 rounded-full border-2 border-unefa-gold bg-white p-0.5 flex items-center justify-center shrink-0">
                        <img
                            src="{{ asset('img/unefa-logo.webp') }}"
                            onerror="this.onerror=null;this.src='{{ $logoFallback }}'"
                            alt="Escudo UNEFA"
                            width="38"
                            height="38"
                            class="w-full h-full object-contain rounded-full"
                        />
                    </div>
                    <div class="flex flex-col leading-tight">
                        <span class="text-[0.95rem] sm:text-[1.02rem] font-black tracking-[0.06em] text-white uppercase">
                            {{ $rolMeta['marcaHeader'] ?? 'UNEFA · SICEU' }}
                        </span>
                        <span class="hidden sm:block text-[0.68rem] font-semibold tracking-[0.04em] text-[#b0c6ff]">
                            {{ $rolMeta['subtituloHeader'] ?? 'Vicerrectorado Académico · Control de Estudios' }}
                        </span>
                    </div>
                </a>

                <span class="hidden md:inline-flex items-center px-2.5 py-1 rounded bg-unefa-gold text-unefa-navy font-extrabold text-[0.72rem] tracking-[0.04em] uppercase shrink-0">
                    Periodo 2026-II
                </span>
            </div>

            {{-- Derecha: Inactividad (RF-05), Notificaciones, Badge de Rol, Usuario --}}
            <div class="flex items-center gap-2.5 sm:gap-3.5 shrink-0">
                <div
                    class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-unefa-navy-soft border border-white/15 text-[0.78rem] font-mono font-bold text-[#d8e3fb]"
                    title="Cierre automático tras 10 minutos de inactividad (RF-05)"
                >
                    @include('partials.icon', ['name' => 'clock', 'clase' => 'w-3.5 h-3.5'])
                    <span>Sesión: <span data-inactivity-timer>10:00</span></span>
                </div>

                {{-- Campana de Notificaciones Socket.IO --}}
                <div class="relative">
                    <button
                        type="button"
                        id="notifPopoverToggle"
                        class="relative inline-flex items-center justify-center w-10 h-10 rounded-md bg-unefa-navy-soft border border-white/15 text-white hover:bg-unefa-blue cursor-pointer transition-colors"
                        aria-label="Notificaciones en tiempo real"
                        aria-expanded="false"
                        aria-controls="notifPopover"
                    >
                        @include('partials.icon', ['name' => 'bell', 'clase' => 'w-[18px] h-[18px]'])
                        <span id="notifBadgeCount" class="absolute -top-1 -right-1 w-4.5 h-4.5 rounded-full bg-unefa-green text-unefa-navy text-[0.65rem] font-black flex items-center justify-center border border-unefa-navy">
                            {{ count(array_filter($notificaciones, fn ($n) => !empty($n['noLeida']))) }}
                        </span>
                    </button>

                    <div
                        id="notifPopover"
                        class="hidden absolute right-0 mt-2 w-80 sm:w-96 bg-white text-text-primary border-2 border-border-primary rounded-xl shadow-xl z-50 overflow-hidden"
                        role="region"
                        aria-label="Centro de notificaciones en tiempo real"
                    >
                        <div class="px-4 py-3 bg-bg-secondary border-b border-border-primary flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-unefa-green" aria-hidden="true"></span>
                                <span class="text-xs font-extrabold uppercase tracking-wider text-unefa-navy">Tiempo Real (Socket.IO)</span>
                            </div>
                            <button type="button" id="markAllNotifRead" class="text-xs font-bold text-unefa-blue hover:underline cursor-pointer bg-transparent border-0">
                                Marcar leídas
                            </button>
                        </div>
                        <ul class="divide-y divide-border-subtle list-none p-0 m-0 text-sm">
                            @foreach($notificaciones as $notif)
                                <li class="px-4 py-3 flex items-start gap-3 hover:bg-bg-secondary">
                                    <span
                                        @if(!empty($notif['noLeida'])) data-notif-unread @endif
                                        class="w-2 h-2 rounded-full {{ !empty($notif['noLeida']) ? 'bg-unefa-green' : 'bg-transparent' }} mt-1.5 shrink-0"
                                        aria-hidden="true"
                                    ></span>
                                    <div>
                                        <p class="font-bold text-unefa-navy text-[0.82rem]">{{ $notif['titulo'] }}</p>
                                        <p class="text-xs text-text-muted mt-0.5">{{ $notif['detalle'] }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                {{-- RoleHeaderBadge de Alto Contraste --}}
                <span class="inline-flex items-center px-2.5 py-1 rounded border-[1.5px] border-unefa-gold bg-unefa-navy-soft text-unefa-gold font-extrabold text-[0.72rem] tracking-[0.06em] uppercase">
                    {{ $rolMeta['insigniaRol'] ?? 'ROL: ESTUDIANTE' }}
                </span>

                {{-- Identidad Usuario --}}
                <div class="hidden xl:flex items-center gap-2.5 pl-2 border-l border-white/15">
                    <img
                        src="{{ $avatarSvg }}"
                        alt="Avatar {{ $usuario['nombreHeader'] ?? 'Usuario' }}"
                        width="32"
                        height="32"
                        class="w-8 h-8 rounded-full object-cover border border-unefa-gold bg-white"
                    />
                    <div class="flex flex-col leading-tight">
                        <span class="text-[0.82rem] font-bold text-white">{{ $usuario['nombreHeader'] ?? 'Usuario' }}</span>
                        <span class="text-[0.7rem] font-mono text-[#b0c6ff]">{{ $usuario['cedula'] ?? '' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- Cuerpo Principal: Sidebar Fija + Espacio de Trabajo --}}
    <div class="flex-1 flex relative">
        <div id="sidebarBackdrop" class="hidden fixed inset-0 z-30 bg-unefa-navy/60 lg:hidden" aria-hidden="true"></div>

        @yield('sidebar')

        <main id="contenido-principal" tabindex="-1" class="flex-1 min-w-0 p-5 sm:p-6 lg:p-8">
            <div class="max-w-[1280px] mx-auto flex flex-col gap-6">
                @yield('breadcrumbs')
                @yield('content')
            </div>
        </main>
    </div>

    {{-- Dialogo de Confirmacion de Cierre de Sesion --}}
    <dialog
        id="logoutDialog"
        closedby="any"
        aria-labelledby="logoutDialogTitle"
        class="m-auto w-[min(92vw,26rem)] rounded-xl border-2 border-border-primary bg-white p-6 text-text-primary shadow-2xl"
    >
        <h1 id="logoutDialogTitle" class="text-lg font-extrabold text-unefa-navy">¿Cerrar sesión institucional?</h1>
        <p class="mt-2 text-sm text-text-muted leading-relaxed">
            Se revocará su token activo en Redis y se desconectará la sesión en tiempo real de SICEU.
        </p>
        <div class="mt-6 flex justify-end gap-3">
            <button
                type="button"
                id="cancelLogoutBtn"
                autofocus
                class="min-h-[2.75rem] px-4 py-2 rounded-lg bg-white border-[1.5px] border-border-primary text-unefa-navy text-sm font-bold cursor-pointer hover:bg-bg-secondary"
            >
                Cancelar
            </button>
            <button
                type="button"
                id="confirmLogoutBtn"
                class="min-h-[2.75rem] px-4 py-2 rounded-lg bg-unefa-red text-white text-sm font-bold cursor-pointer hover:opacity-95"
            >
                Cerrar Sesión
            </button>
        </div>
    </dialog>

    {{-- Dialogo de Sesion Expirada por Inactividad (RF-05) --}}
    <dialog
        id="sessionExpiredDialog"
        aria-labelledby="sessionExpiredTitle"
        class="m-auto w-[min(92vw,28rem)] rounded-xl border-2 border-unefa-red bg-white p-6 text-text-primary shadow-2xl"
    >
        <span class="inline-block px-2.5 py-0.5 rounded bg-[#ffdad6] text-[#93000a] text-xs font-extrabold uppercase tracking-wider mb-2">
            SESION_EXPIRADA_INACTIVIDAD
        </span>
        <h1 id="sessionExpiredTitle" class="text-lg font-extrabold text-unefa-navy">Sesión cerrada por seguridad</h1>
        <p class="mt-2 text-sm text-text-muted leading-relaxed">
            Tu sesión se cerró automáticamente tras 10 minutos de inactividad (RF-05). Inicia sesión nuevamente para continuar.
        </p>
        <div class="mt-6 flex justify-end">
            <button
                type="button"
                id="confirmExpiredBtn"
                class="min-h-[2.75rem] px-5 py-2 rounded-lg bg-unefa-navy-soft text-white text-sm font-bold cursor-pointer hover:bg-unefa-blue"
            >
                Ir al Inicio de Sesión
            </button>
        </div>
    </dialog>

    <script src="{{ asset('js/dashboard.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
