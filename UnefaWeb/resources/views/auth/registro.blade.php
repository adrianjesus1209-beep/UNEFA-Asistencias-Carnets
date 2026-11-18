@extends('layouts.public')

@section('title', 'Preinscripción CINU 2026-I | UNEFA')
@section('header-subtitle', 'Registro CINU')

@push('scripts')
    <script src="{{ asset('js/registro.js') }}" defer></script>
@endpush

@section('content')
    {{-- Contenido tomado de la pantalla de registro de UnefaApp (src/app/registro.tsx). --}}
    <div class="mx-auto w-full max-w-6xl px-4 pb-10 pt-4 lg:pt-8">
        <div class="mx-auto w-full max-w-2xl">

            {{-- Banner --}}
            <div class="mb-4 rounded-[14px] border border-slate-200 bg-slate-50 p-3.5">
                <p class="mb-0.5 text-[11px] font-semibold text-slate-600">Admisiones · Curso de nivelación</p>
                <p class="text-base font-black text-neutral-950">CINU 2026-I</p>
            </div>

            {{-- Tarjeta del formulario --}}
            <div class="mb-5 rounded-[22px] border border-slate-200 bg-white p-5 shadow-lg">
                <div class="mb-[18px]">
                    <div class="mb-3 flex flex-wrap gap-2">
                        <span class="rounded-lg bg-[rgba(242,184,7,0.16)] px-2.5 py-1 text-[11px] font-extrabold text-unefa-goldDark">Nuevo ingreso</span>
                        <span class="rounded-lg border border-slate-200 bg-slate-100 px-2.5 py-1 text-[11px] font-bold text-slate-600">Expediente digital</span>
                    </div>

                    <h1 class="mb-1.5 text-[26px] font-black text-neutral-950">Preinscripción CINU</h1>
                    <p class="text-[13px] leading-[18px] text-slate-600">
                        Completa las 3 secciones para formalizar tu solicitud de ingreso universitario.
                    </p>
                </div>

                {{-- Indicador de pasos (se oculta al enviar) --}}
                <div id="indicador-pasos" class="mb-5 flex gap-2 py-1">
                    <div class="flex-1">
                        <div data-paso-barra="1" class="mb-1.5 h-1 rounded-sm bg-unefa-gold"></div>
                        <p data-paso-etiqueta="1" class="text-[11px] font-extrabold text-unefa-blue">
                            <span class="font-black">01.</span> Acceso
                        </p>
                    </div>
                    <div class="flex-1">
                        <div data-paso-barra="2" class="mb-1.5 h-1 rounded-sm bg-slate-200"></div>
                        <p data-paso-etiqueta="2" class="text-[11px] font-semibold text-slate-500">
                            <span class="font-black">02.</span> Académico
                        </p>
                    </div>
                    <div class="flex-1">
                        <div data-paso-barra="3" class="mb-1.5 h-1 rounded-sm bg-slate-200"></div>
                        <p data-paso-etiqueta="3" class="text-[11px] font-semibold text-slate-500">
                            <span class="font-black">03.</span> Residencia
                        </p>
                    </div>
                </div>

                {{-- Alerta de validacion --}}
                <div id="alerta-error" class="mb-4 hidden rounded-xl border border-red-300 bg-red-100 p-3">
                    <p id="texto-error" class="text-[13px] font-bold text-unefa-red"></p>
                </div>

                {{-- Panel de exito (visible al finalizar) --}}
                <div id="panel-exito" class="mb-5 hidden rounded-[18px] border border-slate-200 bg-slate-50 p-6 text-center">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-green-100">
                        <span class="text-[32px] font-black text-unefa-green">✓</span>
                    </div>
                    <span class="mb-2 inline-block rounded-lg bg-[rgba(4,15,217,0.1)] px-2.5 py-1 text-[11px] font-extrabold text-unefa-blue">Expediente registrado</span>
                    <p class="mb-2.5 text-[22px] font-black text-neutral-950">¡Preinscripción exitosa!</p>
                    <p class="mb-5 text-sm leading-5 text-slate-600">
                        Tu solicitud para el <span class="font-extrabold">Curso Integral de Nivelación Universitaria (CINU 2026-I)</span> fue registrada. Recibirás por correo la fecha para consignar tus documentos en Control de Estudios.
                    </p>
                    <div class="flex flex-col gap-2.5">
                        <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 rounded-[14px] bg-unefa-gold py-3 text-sm font-black text-unefa-navy transition hover:brightness-105">
                            Ir al portal SICEU
                        </a>
                        <a href="{{ route('landing') }}" class="flex items-center justify-center gap-2 rounded-[14px] border border-slate-300 py-3 text-[13px] font-bold text-neutral-950 transition hover:bg-slate-50">
                            Volver a la página principal
                        </a>
                    </div>
                </div>

                {{-- TODO(backend): conectar el envio del formulario a POST /registro al integrar la preinscripcion. --}}
                <form id="formulario-registro" action="#" method="POST" novalidate>

                    {{-- PASO 1: Acceso --}}
                    <fieldset data-paso="1" class="grid gap-x-4 md:grid-cols-2">
                        <div class="mb-4">
                            <label for="campo-primer-nombre" class="mb-1.5 block text-[13px] font-bold text-neutral-950">Primer nombre *</label>
                            <input type="text" name="primer_nombre" id="campo-primer-nombre" autocomplete="given-name" placeholder="Ej. Carlos" class="h-12 w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 text-sm text-neutral-950 outline-none placeholder:text-slate-400 focus:border-unefa-blue" />
                        </div>

                        <div class="mb-4">
                            <label for="campo-segundo-nombre" class="mb-1.5 block text-[13px] font-bold text-neutral-950">Segundo nombre</label>
                            <input type="text" name="segundo_nombre" id="campo-segundo-nombre" autocomplete="additional-name" placeholder="Ej. Eduardo" class="h-12 w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 text-sm text-neutral-950 outline-none placeholder:text-slate-400 focus:border-unefa-blue" />
                        </div>

                        <div class="mb-4">
                            <label for="campo-primer-apellido" class="mb-1.5 block text-[13px] font-bold text-neutral-950">Primer apellido *</label>
                            <input type="text" name="primer_apellido" id="campo-primer-apellido" autocomplete="family-name" placeholder="Ej. Mendoza" class="h-12 w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 text-sm text-neutral-950 outline-none placeholder:text-slate-400 focus:border-unefa-blue" />
                        </div>

                        <div class="mb-4">
                            <label for="campo-segundo-apellido" class="mb-1.5 block text-[13px] font-bold text-neutral-950">Segundo apellido</label>
                            <input type="text" name="segundo_apellido" id="campo-segundo-apellido" autocomplete="additional-family-name" placeholder="Ej. Gómez" class="h-12 w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 text-sm text-neutral-950 outline-none placeholder:text-slate-400 focus:border-unefa-blue" />
                        </div>

                        <div class="mb-4 md:col-span-2">
                            <label for="campo-cedula" class="mb-1.5 block text-[13px] font-bold text-neutral-950">Documento de identidad *</label>
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
                                <input type="text" name="cedula" id="campo-cedula" inputmode="numeric" maxlength="12" autocomplete="off" placeholder="Ej. 29123456" class="h-12 min-w-0 flex-1 rounded-xl border border-slate-300 bg-slate-50 px-3.5 text-sm text-neutral-950 outline-none placeholder:text-slate-400 focus:border-unefa-blue" />
                            </div>
                        </div>

                        <div class="mb-4 md:col-span-2">
                            <label for="campo-email" class="mb-1.5 block text-[13px] font-bold text-neutral-950">Correo electrónico *</label>
                            <input type="email" name="email" id="campo-email" autocomplete="email" placeholder="nombre@correo.com" class="h-12 w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 text-sm text-neutral-950 outline-none placeholder:text-slate-400 focus:border-unefa-blue" />
                        </div>

                        <div class="mb-4">
                            <label for="campo-clave" class="mb-1.5 block text-[13px] font-bold text-neutral-950">Contraseña *</label>
                            <div class="relative flex items-center">
                                <input type="password" name="password" id="campo-clave" autocomplete="new-password" placeholder="Mínimo 8 caracteres" class="h-12 w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 text-sm text-neutral-950 outline-none placeholder:text-slate-400 focus:border-unefa-blue" />
                                <button type="button" data-ver-clave="campo-clave" class="absolute right-3 px-2 py-1 text-xs font-bold text-unefa-blue">Ver</button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="campo-clave2" class="mb-1.5 block text-[13px] font-bold text-neutral-950">Confirmar contraseña *</label>
                            <div class="relative flex items-center">
                                <input type="password" name="password_confirmation" id="campo-clave2" autocomplete="new-password" placeholder="Repite la contraseña" class="h-12 w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 text-sm text-neutral-950 outline-none placeholder:text-slate-400 focus:border-unefa-blue" />
                                <button type="button" data-ver-clave="campo-clave2" class="absolute right-3 px-2 py-1 text-xs font-bold text-unefa-blue">Ver</button>
                            </div>
                        </div>
                    </fieldset>

                    {{-- PASO 2: Academico --}}
                    <fieldset data-paso="2" class="hidden">
                        <div class="mb-4">
                            <label for="campo-nacimiento" class="mb-1.5 block text-[13px] font-bold text-neutral-950">Fecha de nacimiento *</label>
                            <input type="date" name="fecha_nacimiento" id="campo-nacimiento" class="h-12 w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 text-sm text-neutral-950 outline-none focus:border-unefa-blue" />
                        </div>

                        <div class="mb-4">
                            <label for="campo-telefono" class="mb-1.5 block text-[13px] font-bold text-neutral-950">Teléfono de contacto *</label>
                            <input type="tel" name="telefono" id="campo-telefono" autocomplete="tel" placeholder="Ej. 0414-1234567" class="h-12 w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 text-sm text-neutral-950 outline-none placeholder:text-slate-400 focus:border-unefa-blue" />
                        </div>

                        <div class="mb-4">
                            <p class="mb-1.5 text-[13px] font-bold text-neutral-950">Género *</p>
                            <div class="grid grid-cols-3 gap-2">
                                <label class="cursor-pointer rounded-[10px] border border-slate-200 bg-white px-2 py-2.5 text-center transition-colors has-[:checked]:border-unefa-blue has-[:checked]:bg-[rgba(4,15,217,0.08)]">
                                    <input type="radio" name="genero" value="Masculino" class="sr-only" checked />
                                    <span class="text-xs font-bold text-neutral-950">Masculino</span>
                                </label>
                                <label class="cursor-pointer rounded-[10px] border border-slate-200 bg-white px-2 py-2.5 text-center transition-colors has-[:checked]:border-unefa-blue has-[:checked]:bg-[rgba(4,15,217,0.08)]">
                                    <input type="radio" name="genero" value="Femenino" class="sr-only" />
                                    <span class="text-xs font-bold text-neutral-950">Femenino</span>
                                </label>
                                <label class="cursor-pointer rounded-[10px] border border-slate-200 bg-white px-2 py-2.5 text-center transition-colors has-[:checked]:border-unefa-blue has-[:checked]:bg-[rgba(4,15,217,0.08)]">
                                    <input type="radio" name="genero" value="Otro" class="sr-only" />
                                    <span class="text-xs font-bold text-neutral-950">Otro</span>
                                </label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <p class="mb-1.5 text-[13px] font-bold text-neutral-950">Nivel de instrucción *</p>
                            <div class="flex flex-col gap-1.5">
                                <label class="cursor-pointer rounded-[10px] border border-slate-200 bg-white px-3.5 py-2.5 transition-colors has-[:checked]:border-unefa-blue has-[:checked]:bg-[rgba(4,15,217,0.08)]">
                                    <input type="radio" name="nivel_instruccion" value="Bachiller en Ciencias" class="sr-only" checked />
                                    <span class="text-xs font-bold text-neutral-950">Bachiller en Ciencias</span>
                                </label>
                                <label class="cursor-pointer rounded-[10px] border border-slate-200 bg-white px-3.5 py-2.5 transition-colors has-[:checked]:border-unefa-blue has-[:checked]:bg-[rgba(4,15,217,0.08)]">
                                    <input type="radio" name="nivel_instruccion" value="Técnico Medio Industrial" class="sr-only" />
                                    <span class="text-xs font-bold text-neutral-950">Técnico Medio Industrial</span>
                                </label>
                                <label class="cursor-pointer rounded-[10px] border border-slate-200 bg-white px-3.5 py-2.5 transition-colors has-[:checked]:border-unefa-blue has-[:checked]:bg-[rgba(4,15,217,0.08)]">
                                    <input type="radio" name="nivel_instruccion" value="Bachiller en Humanidades" class="sr-only" />
                                    <span class="text-xs font-bold text-neutral-950">Bachiller en Humanidades</span>
                                </label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="campo-egreso" class="mb-1.5 block text-[13px] font-bold text-neutral-950">Año de egreso de bachillerato *</label>
                            <input type="number" name="anio_egreso" id="campo-egreso" min="1970" max="2026" inputmode="numeric" placeholder="Ej. 2025" class="h-12 w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 text-sm text-neutral-950 outline-none placeholder:text-slate-400 focus:border-unefa-blue" />
                        </div>

                        <div class="mb-4">
                            <p class="mb-1.5 text-[13px] font-bold text-neutral-950">Carrera de preferencia *</p>
                            <div class="grid gap-1.5 sm:grid-cols-2">
                                <label class="cursor-pointer rounded-[10px] border border-slate-200 bg-white px-3.5 py-2.5 transition-colors has-[:checked]:border-unefa-blue has-[:checked]:bg-[rgba(4,15,217,0.08)]">
                                    <input type="radio" name="carrera" value="Ingeniería de Sistemas" class="sr-only" checked />
                                    <span class="text-xs font-bold text-neutral-950">Ingeniería de Sistemas</span>
                                </label>
                                <label class="cursor-pointer rounded-[10px] border border-slate-200 bg-white px-3.5 py-2.5 transition-colors has-[:checked]:border-unefa-blue has-[:checked]:bg-[rgba(4,15,217,0.08)]">
                                    <input type="radio" name="carrera" value="Ingeniería de Telecomunicaciones" class="sr-only" />
                                    <span class="text-xs font-bold text-neutral-950">Ingeniería de Telecomunicaciones</span>
                                </label>
                                <label class="cursor-pointer rounded-[10px] border border-slate-200 bg-white px-3.5 py-2.5 transition-colors has-[:checked]:border-unefa-blue has-[:checked]:bg-[rgba(4,15,217,0.08)]">
                                    <input type="radio" name="carrera" value="Ingeniería Mecánica" class="sr-only" />
                                    <span class="text-xs font-bold text-neutral-950">Ingeniería Mecánica</span>
                                </label>
                                <label class="cursor-pointer rounded-[10px] border border-slate-200 bg-white px-3.5 py-2.5 transition-colors has-[:checked]:border-unefa-blue has-[:checked]:bg-[rgba(4,15,217,0.08)]">
                                    <input type="radio" name="carrera" value="Ingeniería Electrónica" class="sr-only" />
                                    <span class="text-xs font-bold text-neutral-950">Ingeniería Electrónica</span>
                                </label>
                                <label class="cursor-pointer rounded-[10px] border border-slate-200 bg-white px-3.5 py-2.5 transition-colors has-[:checked]:border-unefa-blue has-[:checked]:bg-[rgba(4,15,217,0.08)]">
                                    <input type="radio" name="carrera" value="Lic. Administración y Gestión Municipal" class="sr-only" />
                                    <span class="text-xs font-bold text-neutral-950">Lic. Administración y Gestión Municipal</span>
                                </label>
                                <label class="cursor-pointer rounded-[10px] border border-slate-200 bg-white px-3.5 py-2.5 transition-colors has-[:checked]:border-unefa-blue has-[:checked]:bg-[rgba(4,15,217,0.08)]">
                                    <input type="radio" name="carrera" value="Licenciatura en Enfermería" class="sr-only" />
                                    <span class="text-xs font-bold text-neutral-950">Licenciatura en Enfermería</span>
                                </label>
                                <label class="cursor-pointer rounded-[10px] border border-slate-200 bg-white px-3.5 py-2.5 transition-colors has-[:checked]:border-unefa-blue has-[:checked]:bg-[rgba(4,15,217,0.08)]">
                                    <input type="radio" name="carrera" value="TSU en Análisis de Sistemas" class="sr-only" />
                                    <span class="text-xs font-bold text-neutral-950">TSU en Análisis de Sistemas</span>
                                </label>
                                <label class="cursor-pointer rounded-[10px] border border-slate-200 bg-white px-3.5 py-2.5 transition-colors has-[:checked]:border-unefa-blue has-[:checked]:bg-[rgba(4,15,217,0.08)]">
                                    <input type="radio" name="carrera" value="TSU en Enfermería" class="sr-only" />
                                    <span class="text-xs font-bold text-neutral-950">TSU en Enfermería</span>
                                </label>
                            </div>
                        </div>
                    </fieldset>

                    {{-- PASO 3: Residencia --}}
                    <fieldset data-paso="3" class="hidden">
                        <div class="mb-4">
                            <p class="mb-1.5 text-[13px] font-bold text-neutral-950">Estado *</p>
                            <div class="grid gap-1.5 sm:grid-cols-2">
                                <label class="cursor-pointer rounded-[10px] border border-slate-200 bg-white px-3.5 py-2.5 transition-colors has-[:checked]:border-unefa-blue has-[:checked]:bg-[rgba(4,15,217,0.08)]">
                                    <input type="radio" name="estado" value="Distrito Capital" class="sr-only" checked />
                                    <span class="text-xs font-bold text-neutral-950">Distrito Capital</span>
                                </label>
                                <label class="cursor-pointer rounded-[10px] border border-slate-200 bg-white px-3.5 py-2.5 transition-colors has-[:checked]:border-unefa-blue has-[:checked]:bg-[rgba(4,15,217,0.08)]">
                                    <input type="radio" name="estado" value="Miranda" class="sr-only" />
                                    <span class="text-xs font-bold text-neutral-950">Miranda</span>
                                </label>
                                <label class="cursor-pointer rounded-[10px] border border-slate-200 bg-white px-3.5 py-2.5 transition-colors has-[:checked]:border-unefa-blue has-[:checked]:bg-[rgba(4,15,217,0.08)]">
                                    <input type="radio" name="estado" value="Aragua" class="sr-only" />
                                    <span class="text-xs font-bold text-neutral-950">Aragua</span>
                                </label>
                                <label class="cursor-pointer rounded-[10px] border border-slate-200 bg-white px-3.5 py-2.5 transition-colors has-[:checked]:border-unefa-blue has-[:checked]:bg-[rgba(4,15,217,0.08)]">
                                    <input type="radio" name="estado" value="Carabobo" class="sr-only" />
                                    <span class="text-xs font-bold text-neutral-950">Carabobo</span>
                                </label>
                                <label class="cursor-pointer rounded-[10px] border border-slate-200 bg-white px-3.5 py-2.5 transition-colors has-[:checked]:border-unefa-blue has-[:checked]:bg-[rgba(4,15,217,0.08)]">
                                    <input type="radio" name="estado" value="Zulia" class="sr-only" />
                                    <span class="text-xs font-bold text-neutral-950">Zulia</span>
                                </label>
                                <label class="cursor-pointer rounded-[10px] border border-slate-200 bg-white px-3.5 py-2.5 transition-colors has-[:checked]:border-unefa-blue has-[:checked]:bg-[rgba(4,15,217,0.08)]">
                                    <input type="radio" name="estado" value="Lara" class="sr-only" />
                                    <span class="text-xs font-bold text-neutral-950">Lara</span>
                                </label>
                                <label class="cursor-pointer rounded-[10px] border border-slate-200 bg-white px-3.5 py-2.5 transition-colors has-[:checked]:border-unefa-blue has-[:checked]:bg-[rgba(4,15,217,0.08)]">
                                    <input type="radio" name="estado" value="Anzoátegui" class="sr-only" />
                                    <span class="text-xs font-bold text-neutral-950">Anzoátegui</span>
                                </label>
                                <label class="cursor-pointer rounded-[10px] border border-slate-200 bg-white px-3.5 py-2.5 transition-colors has-[:checked]:border-unefa-blue has-[:checked]:bg-[rgba(4,15,217,0.08)]">
                                    <input type="radio" name="estado" value="Bolívar" class="sr-only" />
                                    <span class="text-xs font-bold text-neutral-950">Bolívar</span>
                                </label>
                                <label class="cursor-pointer rounded-[10px] border border-slate-200 bg-white px-3.5 py-2.5 transition-colors has-[:checked]:border-unefa-blue has-[:checked]:bg-[rgba(4,15,217,0.08)]">
                                    <input type="radio" name="estado" value="Táchira" class="sr-only" />
                                    <span class="text-xs font-bold text-neutral-950">Táchira</span>
                                </label>
                                <label class="cursor-pointer rounded-[10px] border border-slate-200 bg-white px-3.5 py-2.5 transition-colors has-[:checked]:border-unefa-blue has-[:checked]:bg-[rgba(4,15,217,0.08)]">
                                    <input type="radio" name="estado" value="Otro estado de Venezuela" class="sr-only" />
                                    <span class="text-xs font-bold text-neutral-950">Otro estado de Venezuela</span>
                                </label>
                            </div>
                        </div>

                        <div class="grid gap-x-4 md:grid-cols-2">
                            <div class="mb-4">
                                <label for="campo-municipio" class="mb-1.5 block text-[13px] font-bold text-neutral-950">Municipio *</label>
                                <input type="text" name="municipio" id="campo-municipio" placeholder="Ej. Libertador" class="h-12 w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 text-sm text-neutral-950 outline-none placeholder:text-slate-400 focus:border-unefa-blue" />
                            </div>
                            <div class="mb-4">
                                <label for="campo-parroquia" class="mb-1.5 block text-[13px] font-bold text-neutral-950">Parroquia *</label>
                                <input type="text" name="parroquia" id="campo-parroquia" placeholder="Ej. Sucre / El Valle" class="h-12 w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 text-sm text-neutral-950 outline-none placeholder:text-slate-400 focus:border-unefa-blue" />
                            </div>
                            <div class="mb-4">
                                <label for="campo-urbanizacion" class="mb-1.5 block text-[13px] font-bold text-neutral-950">Urbanización / sector *</label>
                                <input type="text" name="urbanizacion" id="campo-urbanizacion" placeholder="Ej. Casalta / Chuao" class="h-12 w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 text-sm text-neutral-950 outline-none placeholder:text-slate-400 focus:border-unefa-blue" />
                            </div>
                            <div class="mb-4">
                                <label for="campo-calle" class="mb-1.5 block text-[13px] font-bold text-neutral-950">Calle o avenida *</label>
                                <input type="text" name="calle_avenida" id="campo-calle" placeholder="Ej. Av. Principal con Calle 3" class="h-12 w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 text-sm text-neutral-950 outline-none placeholder:text-slate-400 focus:border-unefa-blue" />
                            </div>
                            <div class="mb-4 md:col-span-2">
                                <label for="campo-nro-casa" class="mb-1.5 block text-[13px] font-bold text-neutral-950">Nro. casa / edificio *</label>
                                <input type="text" name="nro_casa" id="campo-nro-casa" placeholder="Ej. 14-B" class="h-12 w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 text-sm text-neutral-950 outline-none placeholder:text-slate-400 focus:border-unefa-blue" />
                            </div>
                        </div>

                        <p class="mb-2.5 mt-1.5 text-[11px] italic leading-4 text-slate-500">
                            Al enviar este formulario certifico bajo fe de juramento que todos los datos
                            consignados son fidedignos y me comprometo a cumplir el reglamento disciplinario
                            del CINU y la doctrina cívico-militar unefista.
                        </p>
                    </fieldset>

                    {{-- Acciones del formulario --}}
                    <div id="acciones-formulario" class="mt-2.5 flex items-center justify-between border-t border-slate-300 pt-4">
                        <p class="text-xs font-bold text-slate-500">Paso <span id="paso-actual">1</span> / 3</p>
                        <div class="flex gap-2">
                            <button type="button" id="boton-atras" class="hidden items-center justify-center gap-2 rounded-[14px] border border-slate-300 px-4 py-2.5 text-[13px] font-bold text-neutral-950 transition hover:bg-slate-50">
                                ← Atrás
                            </button>
                            <button type="button" id="boton-principal" class="flex items-center justify-center gap-2 rounded-[14px] bg-unefa-gold px-4 py-2.5 text-sm font-black text-unefa-navy transition hover:brightness-105">
                                Continuar →
                            </button>
                        </div>
                    </div>
                </form>

                {{-- Acceso alternativo --}}
                <div class="mt-5 flex flex-col gap-2.5 border-t border-slate-300 pt-4">
                    <p class="text-center text-xs font-semibold text-slate-600">¿Ya posees matrícula o usuario activo?</p>
                    <a href="{{ route('login') }}" class="flex items-center justify-center rounded-[14px] border border-slate-300 py-3 text-[13px] font-bold text-neutral-950 transition hover:bg-slate-50">
                        Iniciar sesión en SICEU
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
