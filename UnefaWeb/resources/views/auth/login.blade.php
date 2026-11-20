@extends('layouts.public')

@section('title', 'Portal Académico — Iniciar sesión | UNEFA')
@section('header-subtitle', 'Portal en línea')

@push('scripts')
    <script src="{{ asset('js/login.js') }}" defer></script>
@endpush

@section('content')
    {{-- Contenido tomado de la pantalla de login de UnefaApp (src/app/login.tsx). --}}
    <div class="mx-auto w-full max-w-6xl px-4 pb-10 pt-4 lg:pt-8">
        <div class="grid gap-6 lg:grid-cols-[minmax(0,7fr)_minmax(0,5fr)] lg:items-start">
            <div class="mx-auto w-full max-w-xl lg:mx-0 lg:max-w-none">

                {{-- Banner institucional --}}
                <div class="mb-4 rounded-[18px] border border-unefa-blue bg-unefa-blueDeep p-[18px]">
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <span class="flex h-[42px] w-[42px] items-center justify-center rounded-[13px] bg-white">
                                <img src="{{ asset('assets/img/logos/logo_unefa.png') }}" alt="Logo de la UNEFA" class="h-[34px] w-[34px] object-contain" />
                            </span>
                            <div>
                                <p class="mb-[3px] text-[10px] font-semibold tracking-[1px] text-white/75">PORTAL ACADÉMICO</p>
                                <p class="text-[17px] font-black text-white">Portal en línea</p>
                            </div>
                        </div>
                        <span class="rounded-full bg-unefa-gold px-2.5 py-1.5 text-[11px] font-black text-unefa-navy">2026-I</span>
                    </div>
                    <p class="mt-3.5 text-xs leading-[18px] text-white/80">
                        Acceso seguro para estudiantes y personal UNEFA.
                    </p>
                </div>

                {{-- Tarjeta principal de acceso --}}
                <div class="mb-5 rounded-[22px] border border-slate-200 bg-white p-5 shadow-lg">
                    <div class="mb-5">
                        <div class="mb-3 flex flex-wrap gap-2">
                            <span class="rounded-lg bg-[rgba(4,15,217,0.1)] px-2.5 py-1 text-[11px] font-extrabold text-unefa-blue">Portal / Acceso</span>
                            <span class="rounded-lg border border-slate-200 bg-slate-100 px-2.5 py-1 text-[11px] font-bold text-slate-600">Periodo 2026-I</span>
                        </div>

                        <h1 class="mb-1.5 text-[26px] font-black text-neutral-950">Iniciar sesión</h1>
                        <p class="text-[13px] leading-[18px] text-slate-600">
                            Ingresa con tu documento de identidad y clave institucional.
                        </p>
                    </div>

                    {{-- Simulacion de acceso por rol (maqueta de evaluacion; el backend la reemplazara por la sesion real) --}}
                    <div class="mb-4 rounded-2xl border-[1.5px] border-slate-200 bg-slate-50 p-3.5">
                        <div class="mb-3">
                            <span class="mb-1.5 inline-flex items-center gap-1 rounded-md bg-[rgba(242,184,7,0.16)] px-2 py-[3px] text-[9px] font-black tracking-[0.5px] text-unefa-navy">
                                @include('partials.icon', ['name' => 'sparkles', 'clase' => 'h-3 w-3 text-unefa-navy'])
                                EVALUACIÓN DE ENTIDADES
                            </span>
                            <p class="text-sm font-black text-slate-900">Simular acceso por rol</p>
                            <p class="text-[11px] leading-4 text-slate-500">
                                Ingresa directamente al dashboard de cada entidad sin requerir backend:
                            </p>
                        </div>

                        <div class="grid gap-2 sm:grid-cols-2">
                            <a href="{{ route('dashboard.estudiante') }}" class="flex items-center gap-2.5 rounded-xl border-[1.5px] border-[rgba(4,15,217,0.25)] bg-white px-3 py-2.5 transition hover:bg-slate-50" aria-label="Ingresar como Estudiante">
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-[10px] bg-[rgba(4,15,217,0.1)]">
                                    @include('partials.icon', ['name' => 'graduation-cap', 'clase' => 'h-[18px] w-[18px] text-unefa-blue'])
                                </span>
                                <span>
                                    <span class="block text-[13px] font-extrabold text-unefa-blue">Estudiante</span>
                                    <span class="block text-[10px] font-semibold text-slate-500">C.I. 28.123.456 · 7mo Semestre</span>
                                </span>
                            </a>

                            <a href="{{ route('dashboard.profesor') }}" class="flex items-center gap-2.5 rounded-xl border-[1.5px] border-[rgba(13,148,136,0.25)] bg-white px-3 py-2.5 transition hover:bg-slate-50" aria-label="Ingresar como Profesor">
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-[10px] bg-[rgba(13,148,136,0.12)]">
                                    @include('partials.icon', ['name' => 'book-open', 'clase' => 'h-[18px] w-[18px] text-[#0d9488]'])
                                </span>
                                <span>
                                    <span class="block text-[13px] font-extrabold text-[#0d9488]">Profesor</span>
                                    <span class="block text-[10px] font-semibold text-slate-500">C.I. 14.567.890 · Docente Ordinario</span>
                                </span>
                            </a>

                            <a href="{{ route('dashboard.coordinador') }}" class="flex items-center gap-2.5 rounded-xl border-[1.5px] border-[rgba(180,83,9,0.25)] bg-white px-3 py-2.5 transition hover:bg-slate-50" aria-label="Ingresar como Coordinador">
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-[10px] bg-[rgba(180,83,9,0.12)]">
                                    @include('partials.icon', ['name' => 'clipboard-check', 'clase' => 'h-[18px] w-[18px] text-[#b45309]'])
                                </span>
                                <span>
                                    <span class="block text-[13px] font-extrabold text-[#b45309]">Coordinador</span>
                                    <span class="block text-[10px] font-semibold text-slate-500">C.I. 11.234.567 · Coord. Carrera</span>
                                </span>
                            </a>

                            <a href="{{ route('dashboard.director') }}" class="flex items-center gap-2.5 rounded-xl border-[1.5px] border-[rgba(6,21,42,0.25)] bg-white px-3 py-2.5 transition hover:bg-slate-50" aria-label="Ingresar como Director">
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-[10px] bg-[rgba(6,21,42,0.12)]">
                                    @include('partials.icon', ['name' => 'shield-check', 'clase' => 'h-[18px] w-[18px] text-unefa-navy'])
                                </span>
                                <span>
                                    <span class="block text-[13px] font-extrabold text-unefa-navy">Director</span>
                                    <span class="block text-[10px] font-semibold text-slate-500">Cnel. Roberto Silva · Dir. Núcleo</span>
                                </span>
                            </a>
                        </div>
                    </div>

                    {{-- Separador --}}
                    <div class="mb-4 flex items-center gap-2.5">
                        <span class="h-px flex-1 bg-slate-200"></span>
                        <span class="text-[10px] font-extrabold tracking-[0.5px] text-slate-400">O INGRESO CON CREDENCIALES</span>
                        <span class="h-px flex-1 bg-slate-200"></span>
                    </div>

                    {{-- TODO(backend): conectar el envio del formulario a POST /login al integrar la autenticacion. --}}
                    <form id="formulario-login" action="#" method="POST" novalidate data-destino-estudiante="{{ route('dashboard.estudiante') }}">

                        {{-- Alertas de estado --}}
                        <div id="alerta-error" class="mb-4 hidden rounded-xl border border-red-300 bg-red-100 p-3">
                            <p id="texto-error" class="text-[13px] font-bold text-unefa-red"></p>
                        </div>
                        <div id="alerta-exito" class="mb-4 hidden rounded-xl border border-green-300 bg-green-100 p-3">
                            <p id="texto-exito" class="text-[13px] font-bold leading-[18px] text-unefa-green"></p>
                        </div>

                        {{-- Campo: Documento de identidad --}}
                        <div class="mb-[18px]">
                            <label for="campo-cedula" class="mb-1.5 block text-[13px] font-bold text-neutral-950">Documento de identidad</label>
                            <div class="flex gap-2">
                                <input type="hidden" name="nacionalidad" id="campo-nacionalidad" value="V" />
                                <div class="flex gap-1 rounded-xl bg-slate-100 p-[3px]" role="group" aria-label="Nacionalidad">
                                    <button type="button" data-nacionalidad="V" class="flex items-center justify-center rounded-[10px] bg-unefa-blue px-3 py-2.5">
                                        <span class="text-[13px] font-extrabold !text-white text-slate-500">V-</span>
                                    </button>
                                    <button type="button" data-nacionalidad="E" class="flex items-center justify-center rounded-[10px] px-3 py-2.5">
                                        <span class="text-[13px] font-extrabold text-slate-500">E-</span>
                                    </button>
                                </div>
                                <input type="text" name="cedula" id="campo-cedula" inputmode="numeric" maxlength="12" autocomplete="off" placeholder="Ej. 28123456" aria-label="Número de cédula" class="h-12 min-w-0 flex-1 rounded-xl border border-slate-300 bg-slate-50 px-3.5 text-sm text-neutral-950 outline-none placeholder:text-slate-400 focus:border-unefa-blue" />
                            </div>
                        </div>

                        {{-- Campo: Contrasena --}}
                        <div class="mb-[18px]">
                            <div class="mb-1.5 flex items-center justify-between">
                                <label for="campo-clave" class="text-[13px] font-bold text-neutral-950">Contraseña institucional</label>
                                <button type="button" id="boton-olvidada" class="text-xs font-bold text-unefa-blue hover:underline">¿La olvidaste?</button>
                            </div>

                            <div class="relative flex items-center">
                                <input type="password" name="password" id="campo-clave" autocomplete="current-password" placeholder="••••••••••••" aria-label="Contraseña institucional" class="h-12 w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 text-sm text-neutral-950 outline-none placeholder:text-slate-400 focus:border-unefa-blue" />
                                <button type="button" id="boton-ver-clave" class="absolute right-3 px-2 py-1 text-xs font-bold text-unefa-blue" aria-label="Mostrar contraseña">Mostrar</button>
                            </div>

                            <p id="nota-olvidada" class="mt-1.5 hidden text-[11px] italic leading-4 text-unefa-goldDark">
                                Contacta al departamento de Control de Estudios de tu núcleo
                                para el restablecimiento de la clave institucional.
                            </p>
                        </div>

                        {{-- Boton de envio --}}
                        <button type="submit" id="boton-acceder" class="mt-1.5 flex w-full items-center justify-center gap-2 rounded-[14px] bg-unefa-gold py-4 text-[15px] font-black text-unefa-navy shadow-md transition hover:brightness-105 disabled:opacity-70" aria-label="Acceder al Portal">
                            <span data-texto-boton>Acceder al Portal</span>
                            <span class="text-base font-black text-unefa-navy">→</span>
                        </button>

                        {{-- Acceso alternativo --}}
                        <div class="mt-6 flex flex-col gap-2.5 border-t border-slate-300 pt-4">
                            <p class="text-center text-xs font-semibold text-slate-600">¿Eres aspirante de nuevo ingreso?</p>
                            <a href="{{ route('registro') }}" class="flex items-center justify-center rounded-[14px] border border-slate-300 py-3.5 text-[13px] font-bold text-neutral-950 transition hover:bg-slate-50">
                                Preinscripción en Línea 2026-I
                            </a>
                        </div>

                        <p class="mt-5 text-center text-[11px] leading-4 text-slate-500">
                            Conexión segura con el servidor de la UNEFA.<br />
                            Uso exclusivo para la comunidad universitaria autorizada.
                        </p>
                    </form>
                </div>
            </div>

            {{-- Tarjeta de ayuda lateral --}}
            <aside class="mx-auto w-full max-w-xl rounded-[18px] border border-slate-200 bg-white p-[18px] lg:mx-0 lg:max-w-none">
                <p class="mb-1.5 text-xs font-extrabold text-unefa-blue">¿Necesitas ayuda?</p>
                <p class="mb-2.5 text-xs leading-[18px] text-slate-600">
                    Si no recuerdas tu clave o tu usuario no está activo, acude a la
                    Unidad de Control de Estudios de tu núcleo.
                </p>
                <a href="{{ route('landing') }}" class="text-[13px] font-extrabold text-unefa-blue hover:underline">
                    Volver a la landing →
                </a>
            </aside>
        </div>
    </div>
@endsection
