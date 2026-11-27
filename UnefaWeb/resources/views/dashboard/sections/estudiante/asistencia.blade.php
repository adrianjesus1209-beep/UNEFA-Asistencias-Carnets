{{-- Seccion Historial de Asistencia --}}
<div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <h1 class="text-2xl sm:text-[1.75rem] font-black tracking-tight text-unefa-navy">Historial de Asistencia por Asignatura</h1>
        <p class="text-sm text-text-muted mt-1">Seguimiento de porcentajes acumulados, tardanzas, justificaciones y registro por modalidad.</p>
    </div>
    <div class="flex flex-wrap items-center gap-3">
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-[#d1fae5] text-[#065f46] text-xs font-extrabold">
            ● Sincronizado en tiempo real (Socket.IO)
        </span>
        <label for="periodFilter" class="sr-only">Periodo académico</label>
        <select id="periodFilter" class="h-10 px-3 rounded-lg bg-white border border-border-primary text-xs font-extrabold text-unefa-navy">
            <option value="2026-II">Periodo Activo: 2026-II</option>
            <option value="2026-I">Periodo Anterior: 2026-I</option>
        </select>
    </div>
</div>

{{-- Banda de 4 KPIs --}}
<section aria-label="Indicadores de asistencia del periodo" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    @include('partials.dashboard.kpi-card', [
        'titulo' => 'Asistencia Global',
        'valor' => '91,4%',
        'subtitulo' => '✓ Meta cumplida (mín. 75%)',
        'subtituloClase' => 'font-bold text-[#047857]',
        'borde' => 'border-t-unefa-green',
    ])
    @include('partials.dashboard.kpi-card', [
        'titulo' => 'Sesiones Presentes',
        'valor' => '32',
        'subtitulo' => 'De 37 clases cerradas',
        'borde' => 'border-t-unefa-navy',
    ])
    @include('partials.dashboard.kpi-card', [
        'titulo' => 'Tardanzas (LATE)',
        'valor' => '3',
        'subtitulo' => 'Registro fuera de tolerancia',
        'borde' => 'border-t-unefa-gold',
    ])
    @include('partials.dashboard.kpi-card', [
        'titulo' => 'Inasistencias',
        'valor' => '2',
        'subtitulo' => '1 Justificada · 1 Injustificada',
        'borde' => 'border-t-unefa-red',
    ])
</section>

{{-- Vista Maestro-Detalle --}}
<div class="grid grid-cols-1 lg:grid-cols-[4.5fr_7.5fr] gap-6 items-start">
    <section aria-labelledby="subjectListTitle" class="bg-white border-[1.5px] border-border-primary rounded-xl shadow-panel overflow-hidden">
        <div class="px-5 py-4 border-b border-border-primary">
            <h2 id="subjectListTitle" class="text-base font-extrabold text-unefa-navy">Resumen por Asignatura</h2>
            <p class="text-xs text-text-muted mt-0.5">Seleccione una materia para auditar sus sesiones.</p>
        </div>
        <div id="subjectProgressList" role="tablist" aria-orientation="vertical" aria-label="Asignaturas inscritas" class="divide-y divide-border-subtle">
            {{-- Renderizado dinamicamente por public/js/dashboard.js --}}
        </div>
    </section>

    <section aria-labelledby="detailHeading" class="bg-white border-[1.5px] border-border-primary rounded-xl shadow-panel overflow-hidden">
        <div class="px-5 py-4 border-b border-border-primary flex flex-col gap-3">
            <div>
                <h2 id="detailHeading" class="text-base font-extrabold text-unefa-navy">Detalle de Sesiones — Sistemas Operativos</h2>
                <p id="detailSubheading" class="text-xs font-mono text-text-muted mt-0.5">ING-SIS-604 · Sec. 01S-2610-D1 · Prof. Manuel Silva</p>
            </div>
            <div id="statusFilterGroup" class="flex flex-wrap gap-2" role="group" aria-label="Filtrar sesiones por estado">
                <button type="button" data-filter="ALL" aria-pressed="true" class="filter-pill px-3 py-1.5 rounded-full text-xs font-extrabold bg-unefa-navy text-white cursor-pointer">Todas</button>
                <button type="button" data-filter="PRESENT" aria-pressed="false" class="filter-pill px-3 py-1.5 rounded-full text-xs font-bold bg-bg-secondary border border-border-primary text-text-secondary hover:bg-bg-tertiary cursor-pointer">Presente</button>
                <button type="button" data-filter="LATE" aria-pressed="false" class="filter-pill px-3 py-1.5 rounded-full text-xs font-bold bg-bg-secondary border border-border-primary text-text-secondary hover:bg-bg-tertiary cursor-pointer">Tardanza</button>
                <button type="button" data-filter="JUSTIFIED" aria-pressed="false" class="filter-pill px-3 py-1.5 rounded-full text-xs font-bold bg-bg-secondary border border-border-primary text-text-secondary hover:bg-bg-tertiary cursor-pointer">Justificada</button>
                <button type="button" data-filter="ABSENT" aria-pressed="false" class="filter-pill px-3 py-1.5 rounded-full text-xs font-bold bg-bg-secondary border border-border-primary text-text-secondary hover:bg-bg-tertiary cursor-pointer">Ausente</button>
            </div>
        </div>

        <div tabindex="0" role="region" aria-labelledby="detailHeading" class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-sm">
                <caption class="sr-only">Registro de sesiones de clase de la asignatura seleccionada</caption>
                <thead>
                    <tr class="bg-bg-secondary border-b border-border-primary text-[0.72rem] font-extrabold uppercase tracking-wider text-text-muted">
                        <th scope="col" class="py-3 px-4">Fecha y Hora</th>
                        <th scope="col" class="py-3 px-4">Modalidad</th>
                        <th scope="col" class="py-3 px-4">Estado</th>
                        <th scope="col" class="py-3 px-4">Observación / Justificación</th>
                    </tr>
                </thead>
                <tbody id="attendanceTableBody" class="divide-y divide-border-subtle">
                    {{-- Renderizado dinamicamente por public/js/dashboard.js --}}
                </tbody>
            </table>
        </div>
        <div id="attendanceTableFooter" class="px-5 py-3 bg-bg-secondary border-t border-border-primary text-xs font-semibold text-text-muted"></div>
    </section>
</div>
