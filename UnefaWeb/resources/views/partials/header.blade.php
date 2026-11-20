{{-- Barra superior publica: marca, navegacion de secciones, acciones y cajon de menu movil. --}}
<header class="sticky top-0 z-40 border-b border-slate-200 bg-white shadow-sm">
    <div class="mx-auto flex h-20 w-full max-w-6xl items-center justify-between px-4">
        <a href="{{ route('landing') }}" class="flex items-center gap-3" aria-label="Ir al inicio">
            <span class="flex h-12 w-12 items-center justify-center rounded-xl border border-slate-200 bg-white p-1 shadow-xs">
                <img src="{{ asset('assets/img/logos/logo_unefa.png') }}" alt="Logo de la UNEFA" class="h-10 w-10 object-contain" />
            </span>
            <span class="flex flex-col justify-center">
                <span class="text-lg font-black tracking-wider text-slate-900">UNEFA</span>
                <span class="text-xs font-semibold uppercase tracking-wide text-slate-600">@yield('header-subtitle', 'Excelencia Educativa')</span>
            </span>
        </a>

        <nav class="hidden items-center gap-1.5 lg:flex" aria-label="Secciones de la pagina">
            <a data-nav-link="inicio" href="{{ route('landing') }}#inicio" class="rounded-lg px-3.5 py-2.5 text-sm font-bold text-slate-800 transition-colors hover:bg-slate-100 hover:text-unefa-navy">Inicio</a>
            <a data-nav-link="nosotros" href="{{ route('landing') }}#nosotros" class="rounded-lg px-3.5 py-2.5 text-sm font-bold text-slate-800 transition-colors hover:bg-slate-100 hover:text-unefa-navy">Doctrina</a>
            <a data-nav-link="carreras" href="{{ route('landing') }}#carreras" class="rounded-lg px-3.5 py-2.5 text-sm font-bold text-slate-800 transition-colors hover:bg-slate-100 hover:text-unefa-navy">Carreras</a>
            <a data-nav-link="admisiones" href="{{ route('landing') }}#admisiones" class="rounded-lg px-3.5 py-2.5 text-sm font-bold text-slate-800 transition-colors hover:bg-slate-100 hover:text-unefa-navy">Admisión CINU</a>
            <a data-nav-link="servicios" href="{{ route('landing') }}#servicios" class="rounded-lg px-3.5 py-2.5 text-sm font-bold text-slate-800 transition-colors hover:bg-slate-100 hover:text-unefa-navy">Servicios</a>
        </nav>

        <div class="flex items-center gap-2.5">
            <a href="{{ route('registro') }}" class="hidden items-center justify-center gap-2 rounded-[14px] bg-unefa-gold px-4 py-2.5 text-sm font-black text-unefa-navy shadow-md transition hover:brightness-105 md:flex">
                Preinscripción CINU
            </a>
            <a href="{{ route('login') }}" class="hidden items-center justify-center gap-2 rounded-[14px] border-2 border-slate-300 bg-white px-4 py-2.5 text-sm font-bold text-slate-900 transition hover:border-unefa-navy hover:bg-slate-50 md:flex">
                Portal SICEU
            </a>
            <button type="button" data-abrir-qr class="flex h-10 items-center justify-center gap-1.5 rounded-full border border-slate-300 bg-slate-50 px-3.5 transition hover:bg-slate-100" aria-label="Abrir escáner QR">
                @include('partials.icon', ['name' => 'qr-code', 'clase' => 'h-5 w-5 text-unefa-navy'])
                <span class="hidden text-xs font-bold text-unefa-goldDark sm:inline">ScanerQR</span>
            </button>
            <button type="button" id="boton-menu" class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-300 bg-slate-50 transition hover:bg-slate-100 lg:hidden" aria-label="Abrir menú" aria-expanded="false" aria-controls="cajon-menu">
                @include('partials.icon', ['name' => 'menu', 'clase' => 'h-5 w-5 text-slate-900'])
            </button>
        </div>
    </div>
</header>

{{-- Cajon de menu lateral (equivalente al MenuDrawer de la aplicacion movil). --}}
<div id="cajon-menu" class="menu-drawer fixed inset-0 z-50 hidden" role="dialog" aria-modal="true" aria-label="Menú institucional">
    <div data-cerrar-menu class="menu-drawer-backdrop absolute inset-0 bg-[rgba(6,21,42,0.65)]"></div>
    <aside class="menu-drawer-panel absolute right-0 top-0 flex h-full w-[85%] max-w-sm flex-col bg-white px-5 pb-6 pt-4">
        <div class="flex items-center justify-between border-b border-slate-300 pb-4">
            <div class="flex items-center gap-3">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl border border-slate-200 bg-white p-1">
                    <img src="{{ asset('assets/img/logos/logo_unefa.png') }}" alt="Logo de la UNEFA" class="h-9 w-9 object-contain" />
                </span>
                <div>
                    <p class="text-lg font-black text-neutral-950">UNEFA</p>
                    <p class="text-xs font-semibold text-slate-600">Menú institucional</p>
                </div>
            </div>
            <button type="button" data-cerrar-menu class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-100 transition hover:bg-slate-200" aria-label="Cerrar menú">
                @include('partials.icon', ['name' => 'x', 'clase' => 'h-5 w-5 text-slate-900'])
            </button>
        </div>

        <div class="mt-4 flex-1 overflow-y-auto">
            <div class="mb-5 flex flex-col gap-1.5">
                <a href="{{ route('landing') }}#inicio" data-cerrar-menu class="flex items-center border-b border-[rgba(148,163,184,0.2)] py-3.5">
                    <span class="w-[38px] font-mono text-xs font-bold text-unefa-blue">[01]</span>
                    <span class="flex-1 text-base font-bold text-neutral-950">Inicio</span>
                    @include('partials.icon', ['name' => 'arrow-right', 'clase' => 'h-4 w-4 text-unefa-gold'])
                </a>
                <a href="{{ route('landing') }}#nosotros" data-cerrar-menu class="flex items-center border-b border-[rgba(148,163,184,0.2)] py-3.5">
                    <span class="w-[38px] font-mono text-xs font-bold text-unefa-blue">[02]</span>
                    <span class="flex-1 text-base font-bold text-neutral-950">Doctrina</span>
                    @include('partials.icon', ['name' => 'arrow-right', 'clase' => 'h-4 w-4 text-unefa-gold'])
                </a>
                <a href="{{ route('landing') }}#carreras" data-cerrar-menu class="flex items-center border-b border-[rgba(148,163,184,0.2)] py-3.5">
                    <span class="w-[38px] font-mono text-xs font-bold text-unefa-blue">[03]</span>
                    <span class="flex-1 text-base font-bold text-neutral-950">Carreras</span>
                    @include('partials.icon', ['name' => 'arrow-right', 'clase' => 'h-4 w-4 text-unefa-gold'])
                </a>
                <a href="{{ route('landing') }}#admisiones" data-cerrar-menu class="flex items-center border-b border-[rgba(148,163,184,0.2)] py-3.5">
                    <span class="w-[38px] font-mono text-xs font-bold text-unefa-blue">[04]</span>
                    <span class="flex-1 text-base font-bold text-neutral-950">Admisiones CINU</span>
                    @include('partials.icon', ['name' => 'arrow-right', 'clase' => 'h-4 w-4 text-unefa-gold'])
                </a>
                <a href="{{ route('landing') }}#servicios" data-cerrar-menu class="flex items-center border-b border-[rgba(148,163,184,0.2)] py-3.5">
                    <span class="w-[38px] font-mono text-xs font-bold text-unefa-blue">[05]</span>
                    <span class="flex-1 text-base font-bold text-neutral-950">Servicios</span>
                    @include('partials.icon', ['name' => 'arrow-right', 'clase' => 'h-4 w-4 text-unefa-gold'])
                </a>
            </div>

            <div class="mb-5 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                <p class="mb-1.5 text-[11px] font-extrabold uppercase text-unefa-blue">[+] Institución</p>
                <p class="mb-3 text-xs leading-[18px] text-slate-600">
                    Formación politécnica, investigación aplicada y doctrina cívico-militar al servicio de la República.
                </p>
                <div class="flex gap-4">
                    <div class="flex-1 rounded-[10px] bg-white p-2 text-center">
                        <p class="text-base font-black text-neutral-950">100%</p>
                        <p class="text-[10px] font-semibold text-slate-500">Gratuidad</p>
                    </div>
                    <div class="flex-1 rounded-[10px] bg-white p-2 text-center">
                        <p class="text-base font-black text-neutral-950">24</p>
                        <p class="text-[10px] font-semibold text-slate-500">Estados</p>
                    </div>
                </div>
            </div>

            <div class="mb-5 flex flex-col gap-2.5">
                <a href="{{ route('registro') }}" data-cerrar-menu class="flex items-center justify-center rounded-[14px] bg-unefa-gold py-3.5 text-sm font-extrabold text-unefa-navy transition hover:brightness-105">
                    Preinscripción CINU
                </a>
                <a href="{{ route('login') }}" data-cerrar-menu class="flex items-center justify-center rounded-[14px] border-2 border-slate-300 py-3.5 text-sm font-bold text-neutral-950 transition hover:bg-slate-50">
                    Portal SICEU
                </a>
            </div>

            <p class="mb-6 text-center text-[10px] leading-[15px] text-slate-500">
                Periodo académico 2026-I · Presencia en los 24 estados<br />
                República Bolivariana de Venezuela
            </p>
        </div>
    </aside>
</div>