{{-- Seccion Inicio del Panel Docente --}}
@php
    $seccionesAsignadas = [
        [
            'seccion' => '01S-2610-D1',
            'asignatura' => 'Ingeniería de Software',
            'codigo' => 'ING-SIS-601 · Diurno',
            'horario' => 'Lun/Jue 08:45 · Aula B-204',
            'inscritos' => 32,
            'enCurso' => true,
        ],
        [
            'seccion' => '01S-2610-N1',
            'asignatura' => 'Ingeniería de Software',
            'codigo' => 'ING-SIS-601 · Nocturno',
            'horario' => 'Mar/Vie 17:30 · Aula B-206',
            'inscritos' => 28,
            'enCurso' => false,
        ],
        [
            'seccion' => '02S-2612-D1',
            'asignatura' => 'Arquitectura de Software',
            'codigo' => 'ING-SIS-704 · Diurno',
            'horario' => 'Mié/Vie 10:30 · Lab. Comp. 1',
            'inscritos' => 26,
            'enCurso' => false,
        ],
    ];

    $escaneosRecientes = [
        ['nombre' => 'Carlos E. González Márquez', 'detalle' => 'V-28.450.123 · Modalidad A', 'estado' => 'PRESENTE', 'hora' => '08:52:14'],
        ['nombre' => 'María Alejandra Ruiz Díaz', 'detalle' => 'V-29.114.602 · Modalidad A', 'estado' => 'PRESENTE', 'hora' => '08:51:49'],
        ['nombre' => 'Luis Fernando Morales', 'detalle' => 'V-27.890.341 · Modalidad B', 'estado' => 'PRESENTE', 'hora' => '08:50:12'],
    ];
@endphp

<div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
    <div>
        <h1 class="text-2xl sm:text-[1.75rem] font-black tracking-tight text-unefa-navy">Panel Principal del Docente</h1>
        <p class="text-sm text-text-muted mt-1">Control de sesiones de clase activas, carga horaria del día y seguimiento de asistencia.</p>
    </div>
    <div class="flex flex-wrap items-center gap-3">
        <span class="text-xs font-bold text-unefa-blue bg-white border border-border-primary px-3 py-2 rounded-lg">
            Viernes, 27 de Noviembre de 2026
        </span>
        <button
            type="button"
            id="btnOpenNewSessionModal"
            command="show-modal"
            commandfor="openSessionDialog"
            class="inline-flex items-center justify-center gap-2 min-h-[2.75rem] px-4 py-2 rounded-lg bg-unefa-gold text-unefa-navy border-[1.5px] border-unefa-gold-dark text-sm font-extrabold shadow-sm hover:bg-unefa-gold-light cursor-pointer transition-colors"
        >
            <span>+ Abrir Nueva Sesión</span>
        </button>
    </div>
</div>

{{-- Banda de Identidad Docente + KPIs --}}
<section aria-label="Resumen operativo del docente" class="bg-white border-[1.5px] border-border-primary rounded-xl p-5 sm:p-6 shadow-panel grid grid-cols-1 xl:grid-cols-[minmax(0,5fr)_minmax(0,7fr)] gap-6 items-center">
    <div>
        <span class="inline-flex items-center px-2.5 py-0.5 rounded bg-bg-tertiary text-unefa-blue font-extrabold text-[0.72rem] uppercase tracking-wider mb-2">
            Personal Docente · Dedicación Exclusiva
        </span>
        <h2 class="text-xl font-extrabold text-unefa-navy">{{ $titular['nombreConTitulo'] ?? 'Prof. Elena Carolina Rivas Mendoza' }}</h2>
        <p class="text-sm font-semibold text-text-muted mt-1">
            Departamento de Ingeniería de Sistemas · {{ $titular['nucleo'] ?? 'Núcleo Carabobo' }}
        </p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        @include('partials.dashboard.kpi-card', [
            'compacta' => true,
            'titulo' => 'Secciones Asignadas',
            'valor' => '3',
            'subtitulo' => 'Periodo Activo 2026-II',
            'borde' => 'border-t-unefa-blue',
            'tamanoValor' => 'text-2xl',
        ])
        @include('partials.dashboard.kpi-card', [
            'compacta' => true,
            'titulo' => 'Estudiantes Inscritos',
            'valor' => '86',
            'subtitulo' => '88,6% asistencia promedio',
            'borde' => 'border-t-unefa-green',
            'tamanoValor' => 'text-2xl',
            'subtituloClase' => 'font-bold text-[#047857]',
        ])
        @include('partials.dashboard.kpi-card', [
            'compacta' => true,
            'titulo' => 'Sesión en Curso',
            'insignia' => '1 Abierta (OPEN)',
            'subtitulo' => 'Aula B-204 · 24/32 presentes',
            'borde' => 'border-t-unefa-gold',
        ])
    </div>
</section>

{{-- Layout Principal 65% / 35% --}}
<div class="grid grid-cols-1 xl:grid-cols-[minmax(0,8fr)_minmax(0,4fr)] gap-6 items-start">
    {{-- Columna Izquierda --}}
    <div class="flex min-w-0 flex-col gap-6">
        {{-- Banner de Sesion Activa en Aula --}}
        <section aria-label="Sesión abierta actualmente" class="bg-white border-2 border-unefa-gold-dark rounded-xl overflow-hidden shadow-panel">
            <div class="h-1.5 w-full bg-unefa-gold" aria-hidden="true"></div>
            <div class="p-5 sm:p-6 flex flex-col gap-4">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-1.5">
                            <span class="w-2.5 h-2.5 rounded-full bg-unefa-green animate-pulse" aria-hidden="true"></span>
                            <span class="text-xs font-black uppercase tracking-[0.1em] text-[#065f46]">Sesión Abierta en Tiempo Real · Sala Activa</span>
                        </div>
                        <h2 class="text-lg sm:text-xl font-extrabold text-unefa-navy">
                            Ingeniería de Software (<span class="font-mono text-unefa-blue">01S-2610-D1</span>)
                        </h2>
                        <p class="text-sm text-text-secondary font-medium mt-1">
                            Aula B-204 · Apertura: 08:45 AM · Tolerancia: <strong class="font-mono text-unefa-navy" id="teacherTolClock">09:18</strong> restantes ·
                            <strong class="text-[#047857]">24 / 32</strong> registrados
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-2.5 shrink-0">
                        <a
                            href="{{ route('dashboard', ['rol' => $rol, 'seccion' => 'sesion-activa']) }}"
                            class="inline-flex items-center justify-center gap-2 min-h-[2.85rem] px-4 py-2 rounded-lg bg-unefa-gold text-unefa-navy border-[1.5px] border-unefa-gold-dark text-sm font-extrabold hover:bg-unefa-gold-light no-underline"
                        >
                            <span>Proyectar QR / Control →</span>
                        </a>
                        <a
                            href="{{ route('dashboard', ['rol' => $rol, 'seccion' => 'escaner-mod-b']) }}"
                            class="inline-flex items-center justify-center gap-2 min-h-[2.85rem] px-4 py-2 rounded-lg bg-unefa-navy-soft text-white text-sm font-bold hover:bg-unefa-blue no-underline"
                        >
                            <span>Escanear Carnets</span>
                        </a>
                    </div>
                </div>

                <div class="w-full h-2 bg-bg-tertiary rounded-full overflow-hidden">
                    <div class="h-full bg-unefa-green" style="width: 75%;"></div>
                </div>
            </div>
        </section>

        {{-- Tabla de Secciones Asignadas --}}
        <section aria-labelledby="docenteClasesTitle" class="bg-white border-[1.5px] border-border-primary rounded-xl shadow-panel overflow-hidden">
            <div class="px-5 py-4 border-b border-border-primary flex items-center justify-between gap-4">
                <div>
                    <h2 id="docenteClasesTitle" class="text-base font-extrabold text-unefa-navy">Secciones Asignadas — Periodo 2026-II</h2>
                    <p class="text-xs text-text-muted mt-0.5">Acceso directo a apertura de sesión, asistencia y actas oficiales PDF.</p>
                </div>
                <a href="{{ route('dashboard', ['rol' => $rol, 'seccion' => 'carga']) }}" class="text-xs font-bold text-unefa-blue hover:underline">Ver horario semanal →</a>
            </div>

            <div class="overflow-x-auto" tabindex="0" role="region" aria-labelledby="docenteClasesTitle">
                <table class="w-full text-left border-collapse text-sm">
                    <caption class="sr-only">Secciones académicas asignadas al docente en el Periodo 2026-II</caption>
                    <thead>
                        <tr class="bg-bg-secondary border-b border-border-primary text-[0.72rem] font-extrabold uppercase tracking-wider text-text-muted">
                            <th scope="col" class="py-3 px-4">Sección</th>
                            <th scope="col" class="py-3 px-4">Asignatura</th>
                            <th scope="col" class="py-3 px-4">Horario / Aula</th>
                            <th scope="col" class="py-3 px-4 text-center">Inscritos</th>
                            <th scope="col" class="py-3 px-4 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-subtle">
                        @foreach($seccionesAsignadas as $fila)
                            <tr class="{{ $fila['enCurso'] ? 'bg-unefa-gold/8' : 'hover:bg-bg-secondary' }}">
                                <th scope="row" class="py-3.5 px-4 font-mono text-xs font-extrabold text-unefa-blue whitespace-nowrap">{{ $fila['seccion'] }}</th>
                                <td class="py-3.5 px-4">
                                    <span class="block font-bold text-unefa-navy">{{ $fila['asignatura'] }}</span>
                                    <span class="text-xs font-mono text-text-muted">{{ $fila['codigo'] }}</span>
                                </td>
                                <td class="py-3.5 px-4 text-xs text-text-secondary whitespace-nowrap">{{ $fila['horario'] }}</td>
                                <td class="py-3.5 px-4 text-center font-bold text-unefa-navy">{{ $fila['inscritos'] }}</td>
                                <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                    @if($fila['enCurso'])
                                        <a href="{{ route('dashboard', ['rol' => $rol, 'seccion' => 'sesion-activa']) }}" class="inline-flex items-center px-3 py-1.5 rounded bg-[#d1fae5] text-[#065f46] text-xs font-extrabold mr-1.5 no-underline">En curso →</a>
                                    @else
                                        <button type="button" data-quick-open="{{ $fila['seccion'] }}" class="inline-flex items-center px-3 py-1.5 rounded bg-unefa-navy-soft text-white text-xs font-bold hover:bg-unefa-blue cursor-pointer mr-1.5">Abrir Sesión</button>
                                    @endif
                                    <a href="{{ route('dashboard', ['rol' => $rol, 'seccion' => 'actas']) }}" class="inline-flex items-center px-2.5 py-1.5 rounded bg-white border border-border-primary text-unefa-navy text-xs font-bold hover:bg-bg-secondary no-underline">Acta PDF</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    {{-- Columna Derecha --}}
    <div class="flex min-w-0 flex-col gap-6">
        {{-- Widget Carnet Docente --}}
        <section aria-labelledby="docCarnetWidgetTitle" class="bg-white border-[1.5px] border-border-primary rounded-xl shadow-panel overflow-hidden">
            <div class="px-5 py-3.5 border-b border-border-primary flex flex-wrap items-center justify-between gap-2">
                <h2 id="docCarnetWidgetTitle" class="min-w-0 text-sm font-extrabold text-unefa-navy">Mi Carnet Docente</h2>
                <a href="{{ route('dashboard', ['rol' => $rol, 'seccion' => 'carnet']) }}" class="text-xs font-bold text-unefa-blue hover:underline">Ver Carnet / PDF →</a>
            </div>
            <div class="p-4">
                @include('partials.dashboard.carnet-card', [
                    'modo' => 'compacto',
                    'titular' => $titular,
                    'bordeCompacto' => 'border-unefa-navy',
                    'tituloCompacto' => 'UNEFA · Personal Docente',
                    'estadoCompacto' => 'VIGENTE',
                    'subtituloCompacto' => 'Ing. de Sistemas',
                    'qrId' => 'docDashMiniQr',
                    'qrTamanoCompacto' => 66,
                ])
            </div>
        </section>

        {{-- Feed Tiempo Real de Escaneos --}}
        <section aria-labelledby="liveFeedTitle" class="bg-white border-[1.5px] border-border-primary rounded-xl shadow-panel overflow-hidden">
            <div class="px-5 py-3.5 border-b border-border-primary flex flex-wrap items-center justify-between gap-2">
                <h2 id="liveFeedTitle" class="text-sm font-extrabold text-unefa-navy">Últimos Escaneos en Vivo</h2>
                <span class="inline-flex items-center gap-1 text-[0.7rem] font-bold text-[#047857]">
                    <span class="w-2 h-2 rounded-full bg-unefa-green" aria-hidden="true"></span>
                    session:01S
                </span>
            </div>
            <ul class="divide-y divide-border-subtle list-none p-0 m-0">
                @foreach($escaneosRecientes as $escaneo)
                    <li class="p-3.5 flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-xs font-extrabold text-unefa-navy truncate">{{ $escaneo['nombre'] }}</p>
                            <p class="text-[0.7rem] font-mono text-text-muted">{{ $escaneo['detalle'] }}</p>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="inline-block px-2 py-0.5 rounded bg-[#d1fae5] text-[#065f46] text-[0.68rem] font-extrabold">{{ $escaneo['estado'] }}</span>
                            <span class="block text-[0.68rem] font-mono text-text-muted mt-0.5">{{ $escaneo['hora'] }}</span>
                        </div>
                    </li>
                @endforeach
            </ul>
        </section>
    </div>
</div>

{{-- Modal Abrir Nueva Sesion (RF-08) --}}
<dialog
    id="openSessionDialog"
    closedby="any"
    aria-labelledby="openSessionTitle"
    class="m-auto w-[min(92vw,28rem)] rounded-xl border-2 border-border-primary bg-white p-6 text-text-primary shadow-2xl"
>
    <h1 id="openSessionTitle" class="text-lg font-extrabold text-unefa-navy">Abrir Nueva Sesión de Clase (RF-08)</h1>
    <p class="mt-1 text-xs text-text-muted">Configure la sección y el margen de tolerancia antes de proyectar el QR dinámico de aula.</p>
    <form id="newSessionForm" data-sesion-activa-url="{{ route('dashboard', ['rol' => $rol, 'seccion' => 'sesion-activa']) }}" class="mt-4 flex flex-col gap-4">
        <div class="flex flex-col gap-1.5">
            <label for="newSessionSection" class="text-xs font-extrabold uppercase text-unefa-navy">Sección Asignada *</label>
            <select id="newSessionSection" class="h-11 px-3 rounded-lg bg-surface-input border border-border-primary text-sm font-semibold text-unefa-navy">
                <option value="01S-2610-D1">ING-SIS-601 · Ingeniería de Software (01S-2610-D1)</option>
                <option value="01S-2610-N1">ING-SIS-601 · Ingeniería de Software (01S-2610-N1)</option>
                <option value="02S-2612-D1">ING-SIS-704 · Arquitectura de Software (02S-2612-D1)</option>
            </select>
        </div>
        <div class="flex flex-col gap-1.5">
            <label for="newSessionTolerance" class="text-xs font-extrabold uppercase text-unefa-navy">Minutos de Tolerancia (PRESENTE vs. LATE) *</label>
            <input id="newSessionTolerance" type="number" min="5" max="45" value="15" required class="h-11 px-3 rounded-lg bg-surface-input border border-border-primary text-sm font-mono font-bold text-unefa-navy">
            <span class="text-[0.72rem] text-text-muted">Por defecto: 15 minutos. Escaneos posteriores marcarán TARDANZA (LATE).</span>
        </div>
        <div class="mt-2 flex justify-end gap-3">
            <button type="button" id="cancelNewSession" class="min-h-[2.75rem] px-4 py-2 rounded-lg bg-white border-[1.5px] border-border-primary text-unefa-navy text-sm font-bold cursor-pointer">
                Cancelar
            </button>
            <button type="submit" class="min-h-[2.75rem] px-5 py-2 rounded-lg bg-unefa-gold text-unefa-navy border-[1.5px] border-unefa-gold-dark text-sm font-extrabold cursor-pointer hover:bg-unefa-gold-light">
                Iniciar Sesión y Proyectar QR
            </button>
        </div>
    </form>
</dialog>
