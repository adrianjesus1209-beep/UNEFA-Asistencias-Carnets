{{-- Seccion Actas de Asistencia Institucionales (PDF) --}}
<div class="flex flex-col lg:flex-row lg:items-end justify-between gap-4">
    <div>
        <h1 class="text-2xl sm:text-[1.75rem] font-black tracking-tight text-unefa-navy">Actas de Asistencia Institucionales (PDF)</h1>
        <p class="text-sm text-text-muted mt-1">Consulta de acumulados por sección y emisión oficial en PDF con bloques de firmas (<span class="font-mono">GET /api/reports/attendance-act/:sectionId/pdf</span>).</p>
    </div>

    <button
        type="button"
        id="btnEmitActPdf"
        class="inline-flex items-center justify-center gap-2 min-h-[2.85rem] px-5 py-2.5 rounded-lg bg-unefa-gold text-unefa-navy border-[1.5px] border-unefa-gold-dark text-sm font-extrabold shadow-sm hover:bg-unefa-gold-light cursor-pointer self-start lg:self-auto"
    >
        @include('partials.icon', ['name' => 'file-text', 'clase' => 'w-[17px] h-[17px]'])
        <span>Descargar Acta de Asistencia (PDF)</span>
    </button>
</div>

{{-- Selector de Seccion (Incluye caso de borde RF-13: 0 sesiones cerradas = 0%) --}}
<section aria-label="Seleccionar sección para acta" class="grid grid-cols-1 md:grid-cols-3 gap-4" id="actSectionCards"></section>

{{-- Indicadores de la Seccion Seleccionada --}}
<section aria-label="Métricas de la sección seleccionada" class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    @include('partials.dashboard.kpi-card', [
        'titulo' => 'Promedio Asistencia',
        'valor' => '90,2%',
        'valorId' => 'actKpiAvg',
        'tamanoValor' => 'text-2xl',
        'borde' => 'border-t-unefa-green',
    ])
    @include('partials.dashboard.kpi-card', [
        'titulo' => 'Sesiones Cerradas',
        'valor' => '12',
        'valorId' => 'actKpiSessions',
        'tamanoValor' => 'text-2xl',
        'borde' => 'border-t-unefa-blue',
    ])
    @include('partials.dashboard.kpi-card', [
        'titulo' => 'Total Inscritos',
        'valor' => '32',
        'valorId' => 'actKpiEnrolled',
        'tamanoValor' => 'text-2xl',
        'borde' => 'border-t-unefa-gold',
    ])
    @include('partials.dashboard.kpi-card', [
        'titulo' => 'En Riesgo (<75%)',
        'valor' => '1',
        'valorId' => 'actKpiRisk',
        'tamanoValor' => 'text-2xl',
        'valorClase' => 'text-unefa-red',
        'borde' => 'border-t-unefa-red',
    ])
</section>

{{-- Aviso Caso de Borde RF-13 (0 sesiones cerradas) --}}
<div id="zeroSessionsNotice" class="hidden px-4 py-3.5 rounded-xl border-[1.5px] border-unefa-blue bg-surface-input text-xs text-unefa-navy font-semibold" role="status">
    <strong>Nota de cálculo (RF-13):</strong> Esta sección aún no posee sesiones cerradas. Todos los porcentajes acumulados se reportan de forma segura en <span class="font-mono font-bold">0%</span> sin errores de división y el acta PDF puede emitirse como constancia de matrícula inicial.
</div>

{{-- Tabla Consolidada del Acta --}}
<section aria-labelledby="actTableTitle" class="bg-white border-[1.5px] border-border-primary rounded-xl shadow-panel overflow-hidden">
    <div class="px-5 py-4 border-b border-border-primary flex flex-wrap items-center justify-between gap-2">
        <div>
            <h2 id="actTableTitle" class="text-base font-extrabold text-unefa-navy">Consolidado de Asistencia — 01S-2610-D1</h2>
            <p id="actTableSubtitle" class="text-xs text-text-muted mt-0.5">Ingeniería de Software (ING-SIS-601) · Periodo 2026-II</p>
        </div>
        <span class="text-xs font-mono text-text-muted">Base: sesiones cerradas (CLOSED)</span>
    </div>
    <div class="overflow-x-auto" tabindex="0" role="region" aria-labelledby="actTableTitle">
        <table class="w-full text-left border-collapse text-sm">
            <caption class="sr-only">Consolidado de asistencias acumuladas por estudiante para emisión de acta</caption>
            <thead>
                <tr class="bg-bg-secondary border-b border-border-primary text-[0.72rem] font-extrabold uppercase tracking-wider text-text-muted">
                    <th scope="col" class="py-3 px-4">Cédula</th>
                    <th scope="col" class="py-3 px-4">Estudiante</th>
                    <th scope="col" class="py-3 px-4 text-center">Presentes</th>
                    <th scope="col" class="py-3 px-4 text-center">Tardanzas</th>
                    <th scope="col" class="py-3 px-4 text-center">Justif.</th>
                    <th scope="col" class="py-3 px-4 text-center">Ausentes</th>
                    <th scope="col" class="py-3 px-4 text-right">% Acumulado</th>
                </tr>
            </thead>
            <tbody id="actRosterBody" class="divide-y divide-border-subtle"></tbody>
        </table>
    </div>
</section>

{{-- Modal Vista Previa Oficial Acta PDF --}}
<dialog
    id="actPdfDialog"
    closedby="any"
    aria-labelledby="actPdfTitle"
    class="m-auto w-[min(94vw,36rem)] rounded-xl border-2 border-unefa-navy bg-white p-6 text-text-primary shadow-2xl"
>
    <div class="flex items-start justify-between gap-4 pb-3 border-b-2 border-unefa-gold">
        <div>
            <span class="text-[0.68rem] font-extrabold uppercase tracking-wider text-unefa-blue">República Bolivariana de Venezuela · UNEFA</span>
            <h1 id="actPdfTitle" class="text-lg font-black text-unefa-navy mt-0.5">Acta Oficial de Asistencia (PDF)</h1>
        </div>
        <span class="font-mono text-xs font-bold px-2 py-1 rounded bg-bg-secondary border border-border-primary">RF-13</span>
    </div>
    <div id="actPdfBody" class="mt-4 text-sm text-text-secondary space-y-3"></div>
    <div class="mt-6 pt-4 border-t border-border-subtle grid grid-cols-2 gap-6 text-center text-xs text-text-muted">
        <div>
            <div class="border-b border-unefa-navy mb-1 h-8"></div>
            <strong class="text-unefa-navy">{{ $titular['nombreCorto'] ?? 'Prof. Elena C. Rivas M.' }}</strong><br>Docente Titular
        </div>
        <div>
            <div class="border-b border-unefa-navy mb-1 h-8"></div>
            <strong class="text-unefa-navy">Coordinación de Carrera</strong><br>Sello y Validación
        </div>
    </div>
    <div class="mt-6 flex justify-end gap-3">
        <form method="dialog">
            <button type="submit" id="closeActPdfDialog" class="min-h-[2.75rem] px-5 py-2 rounded-lg bg-unefa-navy-soft text-white text-sm font-bold cursor-pointer hover:bg-unefa-blue">
                Aceptar y Descargar
            </button>
        </form>
    </div>
</dialog>
