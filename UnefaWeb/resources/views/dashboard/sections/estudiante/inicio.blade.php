{{-- Seccion Inicio: Panel Principal del Estudiante --}}
@include('partials.dashboard.page-header', [
    'titulo' => 'Panel Principal del Estudiante',
    'descripcion' => 'Resumen académico diario, sesiones activas y estado de acreditación digital.',
    'fecha' => 'Jueves, 26 de Noviembre de 2026',
])

{{-- Banda de Identidad Academica + KPIs --}}
<section aria-label="Resumen académico del estudiante" class="bg-white border-[1.5px] border-border-primary rounded-xl p-5 sm:p-6 shadow-panel grid grid-cols-1 xl:grid-cols-[minmax(0,5fr)_minmax(0,7fr)] gap-6 items-center">
    <div>
        <span class="inline-flex items-center px-2.5 py-0.5 rounded bg-bg-tertiary text-unefa-blue font-extrabold text-[0.72rem] uppercase tracking-wider mb-2">
            Estudiante Regular · {{ $estudiante['semestre'] ?? 'Semestre 6' }} · {{ $estudiante['turno'] ?? 'Diurno' }}
        </span>
        <h2 class="text-xl font-extrabold text-unefa-navy">{{ $estudiante['nombreCompleto'] ?? 'Carlos Eduardo González Márquez' }}</h2>
        <p class="text-sm font-semibold text-text-muted mt-1">
            {{ $estudiante['carrera'] ?? 'Ingeniería de Sistemas' }} (<span class="font-mono text-unefa-blue">{{ $estudiante['carreraCodigo'] ?? 'ING-SIS-10' }}</span>) · {{ $estudiante['nucleo'] ?? 'Núcleo Carabobo' }}
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        @include('partials.dashboard.kpi-card', [
            'titulo' => 'Asistencia Global',
            'valor' => '91,4%',
            'subtitulo' => 'Meta cumplida (mín. 75%)',
            'subtituloClase' => 'font-bold text-[#047857]',
            'borde' => 'border-t-unefa-green',
            'tamanoValor' => 'text-2xl',
            'compacta' => true,
        ])
        @include('partials.dashboard.kpi-card', [
            'titulo' => 'Materias Inscritas',
            'valor' => '5',
            'subtitulo' => '22 U.C. · Periodo 2026-II',
            'borde' => 'border-t-unefa-blue',
            'tamanoValor' => 'text-2xl',
            'compacta' => true,
        ])
        @include('partials.dashboard.kpi-card', [
            'titulo' => 'Carnet Digital',
            'insignia' => 'Aprobado',
            'subtitulo' => 'Vigente hasta 31/12/2026',
            'borde' => 'border-t-unefa-gold',
            'compacta' => true,
        ])
    </div>
</section>

{{-- Espacio de Trabajo Asimetrico 65% / 35% --}}
<div class="grid grid-cols-1 xl:grid-cols-[minmax(0,8fr)_minmax(0,4fr)] gap-6 items-start">
    {{-- Columna Principal Izquierda --}}
    <div class="flex min-w-0 flex-col gap-6">
        {{-- Banner Urgente de Sesion Abierta en Curso (RF-08) --}}
        <section aria-label="Sesión de clase activa" class="bg-white border-2 border-unefa-gold-dark rounded-xl overflow-hidden shadow-panel">
            <div class="h-1.5 w-full bg-unefa-gold" aria-hidden="true"></div>
            <div class="p-5 sm:p-6 flex flex-col md:flex-row md:items-center justify-between gap-5">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-unefa-green animate-pulse" aria-hidden="true"></span>
                        <span class="text-xs font-black uppercase tracking-[0.1em] text-unefa-red">Sesión Abierta en Curso</span>
                    </div>
                    <h2 class="text-lg sm:text-xl font-extrabold text-unefa-navy">
                        Ingeniería de Software (<span class="font-mono text-unefa-blue">01S-2610-D1</span>)
                    </h2>
                    <p class="text-sm text-text-secondary font-medium mt-1">
                        Aula B-204 · Prof. Elena Rivas · Margen de tolerancia:
                        <strong class="text-unefa-navy font-mono" id="dashToleranceClock">11:00</strong> restantes
                    </p>
                </div>

                <a
                    href="{{ route('dashboard', ['rol' => $rol, 'seccion' => 'escaner']) }}"
                    class="inline-flex items-center justify-center gap-2 min-h-[3rem] px-5 py-3 rounded-lg bg-unefa-gold text-unefa-navy border-[1.5px] border-unefa-gold-dark font-extrabold text-sm shadow-sm hover:bg-unefa-gold-light transition-colors no-underline shrink-0"
                >
                    @include('partials.icon', ['name' => 'scan-qr', 'clase' => 'w-[18px] h-[18px]'])
                    <span>Escanear QR de Clase →</span>
                </a>
            </div>
        </section>

        {{-- Tabla de Clases de Hoy --}}
        <section aria-labelledby="clasesHoyTitle" class="bg-white border-[1.5px] border-border-primary rounded-xl shadow-panel overflow-hidden">
            <div class="px-5 py-4 border-b border-border-primary flex items-center justify-between gap-4">
                <div>
                    <h2 id="clasesHoyTitle" class="text-base font-extrabold text-unefa-navy">Clases de Hoy — Jueves 26 Nov</h2>
                    <p class="text-xs text-text-muted mt-0.5">Sección asignada 01S-2610-D1 · Turno Diurno</p>
                </div>
                <a href="{{ route('dashboard', ['rol' => $rol, 'seccion' => 'horario']) }}" class="text-xs font-bold text-unefa-blue hover:underline">Ver horario completo →</a>
            </div>

            <div tabindex="0" role="region" aria-labelledby="clasesHoyTitle" class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <caption class="sr-only">Clases programadas para hoy jueves 26 de noviembre</caption>
                    <thead>
                        <tr class="bg-bg-secondary border-b border-border-primary text-[0.72rem] font-extrabold uppercase tracking-wider text-text-muted">
                            <th scope="col" class="py-3 px-4">Hora</th>
                            <th scope="col" class="py-3 px-4">Código</th>
                            <th scope="col" class="py-3 px-4">Asignatura</th>
                            <th scope="col" class="py-3 px-4">Aula</th>
                            <th scope="col" class="py-3 px-4">Docente</th>
                            <th scope="col" class="py-3 px-4 text-right">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-subtle">
                        <tr class="bg-unefa-gold/8">
                            <td class="py-3.5 px-4 font-mono text-xs font-bold text-unefa-navy whitespace-nowrap">08:45 - 10:15</td>
                            <td class="py-3.5 px-4 font-mono text-xs font-bold text-unefa-blue whitespace-nowrap">ING-SIS-601</td>
                            <th scope="row" class="py-3.5 px-4 font-bold text-unefa-navy">Ingeniería de Software</th>
                            <td class="py-3.5 px-4 text-text-secondary whitespace-nowrap">Aula B-204</td>
                            <td class="py-3.5 px-4 text-text-secondary whitespace-nowrap">Prof. Elena Rivas</td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                @include('partials.dashboard.status-badge', ['texto' => 'En curso', 'variante' => 'success'])
                                <a href="{{ route('dashboard', ['rol' => $rol, 'seccion' => 'escaner']) }}" class="ml-1.5 inline-flex items-center px-2.5 py-1 rounded bg-unefa-gold text-unefa-navy border border-unefa-gold-dark text-xs font-extrabold hover:bg-unefa-gold-light no-underline">Escanear</a>
                            </td>
                        </tr>
                        <tr class="hover:bg-bg-secondary">
                            <td class="py-3.5 px-4 font-mono text-xs font-semibold text-text-secondary whitespace-nowrap">10:30 - 12:00</td>
                            <td class="py-3.5 px-4 font-mono text-xs font-bold text-unefa-blue whitespace-nowrap">ING-SIS-603</td>
                            <th scope="row" class="py-3.5 px-4 font-bold text-unefa-navy">Redes y Teleproceso</th>
                            <td class="py-3.5 px-4 text-text-secondary whitespace-nowrap">Aula B-108</td>
                            <td class="py-3.5 px-4 text-text-secondary whitespace-nowrap">Prof. Juan Blanco</td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                @include('partials.dashboard.status-badge', ['texto' => 'Programada 10:30', 'variante' => 'info'])
                            </td>
                        </tr>
                        <tr class="hover:bg-bg-secondary">
                            <td class="py-3.5 px-4 font-mono text-xs font-semibold text-text-secondary whitespace-nowrap">14:00 - 15:30</td>
                            <td class="py-3.5 px-4 font-mono text-xs font-bold text-unefa-blue whitespace-nowrap">DEF-605</td>
                            <th scope="row" class="py-3.5 px-4 font-bold text-unefa-navy">Defensa Integral VI</th>
                            <td class="py-3.5 px-4 text-text-secondary whitespace-nowrap">Patio de Honor</td>
                            <td class="py-3.5 px-4 text-text-secondary whitespace-nowrap">Prof. Luis Vásquez</td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                @include('partials.dashboard.status-badge', ['texto' => 'Programada 14:00', 'variante' => 'neutral'])
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    {{-- Columna Derecha: Preview Carnet + Notificaciones Tiempo Real --}}
    <div class="flex min-w-0 flex-col gap-6">
        {{-- Widget Compacto Mi Carnet Digital --}}
        <section aria-labelledby="widgetCarnetTitle" class="bg-white border-[1.5px] border-border-primary rounded-xl shadow-panel overflow-hidden">
            <div class="px-5 py-3.5 border-b border-border-primary flex flex-wrap items-center justify-between gap-2">
                <h2 id="widgetCarnetTitle" class="min-w-0 text-sm font-extrabold text-unefa-navy">Mi Carnet Digital</h2>
                <a href="{{ route('dashboard', ['rol' => $rol, 'seccion' => 'carnet']) }}" class="text-xs font-bold text-unefa-blue hover:underline">Ver Carnet / PDF →</a>
            </div>

            <div class="p-4">
                @include('partials.dashboard.carnet-card', [
                    'modo' => 'compacto',
                    'estudiante' => $estudiante,
                    'qrId' => 'dashMiniQr',
                ])

                <div class="mt-3 flex items-center justify-between text-xs">
                    <span class="font-semibold text-text-muted">QR Dinámico · Rotación en <strong class="font-mono text-unefa-navy" id="dashQrCountdown">46s</strong></span>
                    <span class="text-[0.7rem] font-bold text-[#047857]">HMAC-SHA256</span>
                </div>
                <div class="w-full h-1.5 bg-bg-tertiary rounded-full overflow-hidden mt-1.5">
                    <div id="dashQrBar" class="h-full bg-unefa-gold transition-all duration-1000" style="width: 76%;"></div>
                </div>
            </div>
        </section>

        {{-- Feed Notificaciones en Tiempo Real --}}
        <section aria-labelledby="widgetNotifTitle" class="bg-white border-[1.5px] border-border-primary rounded-xl shadow-panel overflow-hidden">
            <div class="px-5 py-3.5 border-b border-border-primary flex flex-wrap items-center justify-between gap-2">
                <h2 id="widgetNotifTitle" class="text-sm font-extrabold text-unefa-navy">Notificaciones en Tiempo Real</h2>
                <span class="inline-flex items-center gap-1 text-[0.7rem] font-bold text-[#047857]">
                    <span class="w-2 h-2 rounded-full bg-unefa-green" aria-hidden="true"></span>
                    En vivo
                </span>
            </div>

            <ul class="divide-y divide-border-subtle list-none p-0 m-0">
                <li class="p-4 flex items-start gap-3">
                    <span class="w-7 h-7 rounded-md bg-[#d1fae5] text-[#047857] flex items-center justify-center shrink-0 mt-0.5">
                        @include('partials.icon', ['name' => 'check', 'clase' => 'w-[15px] h-[15px]'])
                    </span>
                    <div class="min-w-0 flex-1">
                        <div class="flex justify-between gap-2">
                            <p class="text-xs font-extrabold text-unefa-navy">Asistencia registrada: Bases de Datos II</p>
                            <span class="text-[0.68rem] font-mono text-text-muted shrink-0">08:52</span>
                        </div>
                        <p class="text-xs text-text-muted mt-0.5">Estado confirmado: PRESENTE (Modalidad A).</p>
                    </div>
                </li>
                <li class="p-4 flex items-start gap-3">
                    <span class="w-7 h-7 rounded-md bg-unefa-blue/10 text-unefa-blue flex items-center justify-center shrink-0 mt-0.5">
                        @include('partials.icon', ['name' => 'id-card', 'clase' => 'w-[15px] h-[15px]'])
                    </span>
                    <div class="min-w-0 flex-1">
                        <div class="flex justify-between gap-2">
                            <p class="text-xs font-extrabold text-unefa-navy">Fotografía de carnet aprobada</p>
                            <span class="text-[0.68rem] font-mono text-text-muted shrink-0">Ayer</span>
                        </div>
                        <p class="text-xs text-text-muted mt-0.5">Aprobada por Coordinación Académica.</p>
                    </div>
                </li>
                <li class="p-4 flex items-start gap-3">
                    <span class="w-7 h-7 rounded-md bg-unefa-gold/20 text-unefa-gold-dark flex items-center justify-center shrink-0 mt-0.5">
                        @include('partials.icon', ['name' => 'doc', 'clase' => 'w-[15px] h-[15px]'])
                    </span>
                    <div class="min-w-0 flex-1">
                        <div class="flex justify-between gap-2">
                            <p class="text-xs font-extrabold text-unefa-navy">Planilla de Inscripción 2026-II validada</p>
                            <span class="text-[0.68rem] font-mono text-text-muted shrink-0">24 Nov</span>
                        </div>
                        <p class="text-xs text-text-muted mt-0.5">Disponible para exportación en PDF oficial.</p>
                    </div>
                </li>
            </ul>
        </section>
    </div>
</div>
