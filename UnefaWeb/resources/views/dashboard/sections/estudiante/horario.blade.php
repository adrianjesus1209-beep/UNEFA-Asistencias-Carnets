{{-- Seccion Horario y Materias --}}
@php
    $bloques = [
        [
            'hora' => '07:15 - 08:45',
            'compacto' => true,
            'dias' => [null, null, null, null, null],
        ],
        [
            'hora' => '08:45 - 10:15',
            'dias' => [
                ['codigo' => 'ING-SIS-601', 'nombre' => 'Ingeniería de Software', 'detalle' => '01S-2610-D1 · Aula B-204', 'fondo' => 'bg-surface-input border-l-unefa-blue hover:bg-bg-tertiary', 'codigoClase' => 'text-unefa-blue'],
                ['codigo' => 'ING-SIS-602', 'nombre' => 'Bases de Datos II', 'detalle' => '01S-2610-D1 · Lab. Comp. 2', 'fondo' => 'bg-bg-secondary border-l-unefa-navy hover:bg-bg-tertiary', 'codigoClase' => 'text-unefa-navy'],
                null,
                ['codigo' => 'ING-SIS-601', 'nombre' => 'Ingeniería de Software', 'detalle' => '01S-2610-D1 · Aula B-204', 'fondo' => 'bg-surface-input border-l-unefa-blue hover:bg-bg-tertiary', 'codigoClase' => 'text-unefa-blue'],
                ['codigo' => 'ING-SIS-602', 'nombre' => 'Bases de Datos II', 'detalle' => '01S-2610-D1 · Lab. Comp. 2', 'fondo' => 'bg-bg-secondary border-l-unefa-navy hover:bg-bg-tertiary', 'codigoClase' => 'text-unefa-navy'],
            ],
        ],
        [
            'hora' => '10:30 - 12:00',
            'dias' => [
                ['codigo' => 'ING-SIS-604', 'nombre' => 'Sistemas Operativos', 'detalle' => '01S-2610-D1 · Lab. Linux 1', 'fondo' => 'bg-[#d1fae5]/25 border-l-unefa-green hover:bg-[#d1fae5]/45', 'codigoClase' => 'text-[#065f46]'],
                null,
                ['codigo' => 'ING-SIS-603', 'nombre' => 'Redes y Teleproceso', 'detalle' => '01S-2610-D1 · Aula B-108', 'fondo' => 'bg-unefa-gold/12 border-l-unefa-gold-dark hover:bg-unefa-gold/25', 'codigoClase' => 'text-unefa-gold-dark'],
                ['codigo' => 'ING-SIS-603', 'nombre' => 'Redes y Teleproceso', 'detalle' => '01S-2610-D1 · Aula B-108', 'fondo' => 'bg-unefa-gold/12 border-l-unefa-gold-dark hover:bg-unefa-gold/25', 'codigoClase' => 'text-unefa-gold-dark'],
                null,
            ],
        ],
        [
            'hora' => '12:00 - 13:30',
            'dias' => [
                null,
                null,
                ['codigo' => 'ING-SIS-604', 'nombre' => 'Sistemas Operativos', 'detalle' => '01S-2610-D1 · Lab. Linux 1', 'fondo' => 'bg-[#d1fae5]/25 border-l-unefa-green hover:bg-[#d1fae5]/45', 'codigoClase' => 'text-[#065f46]'],
                null,
                null,
            ],
        ],
        [
            'hora' => '14:00 - 15:30',
            'dias' => [
                null,
                null,
                null,
                ['codigo' => 'DEF-605', 'nombre' => 'Defensa Integral VI', 'detalle' => '01S-2610-D1 · Patio de Honor', 'fondo' => 'bg-bg-secondary border-l-unefa-blue-deep hover:bg-bg-tertiary', 'codigoClase' => 'text-unefa-navy'],
                null,
            ],
        ],
    ];

    $materias = [
        ['codigo' => 'ING-SIS-601', 'nombre' => 'Ingeniería de Software', 'seccion' => '01S-2610-D1', 'uc' => 5, 'docente' => 'Prof. Elena Rivas'],
        ['codigo' => 'ING-SIS-602', 'nombre' => 'Bases de Datos II', 'seccion' => '01S-2610-D1', 'uc' => 5, 'docente' => 'Prof. Marcos Pérez'],
        ['codigo' => 'ING-SIS-603', 'nombre' => 'Redes y Teleproceso', 'seccion' => '01S-2610-D1', 'uc' => 4, 'docente' => 'Prof. Juan Blanco'],
        ['codigo' => 'ING-SIS-604', 'nombre' => 'Sistemas Operativos', 'seccion' => '01S-2610-D1', 'uc' => 4, 'docente' => 'Prof. Manuel Silva'],
        ['codigo' => 'DEF-605', 'nombre' => 'Defensa Integral VI', 'seccion' => '01S-2610-D1', 'uc' => 4, 'docente' => 'Prof. Luis Vásquez'],
    ];
@endphp

<div class="flex flex-col lg:flex-row lg:items-end justify-between gap-4">
    <div>
        <h1 class="text-2xl sm:text-[1.75rem] font-black tracking-tight text-unefa-navy">Horario Semanal y Materias Inscritas</h1>
        <div class="flex flex-wrap items-center gap-2 mt-2">
            <span class="px-2.5 py-0.5 rounded bg-unefa-blue text-white text-xs font-extrabold">Periodo 2026-II</span>
            <span class="px-2.5 py-0.5 rounded bg-bg-tertiary text-unefa-navy border border-border-primary text-xs font-bold">Semestre 6 · Diurno</span>
            <span class="px-2.5 py-0.5 rounded bg-unefa-gold/25 text-unefa-navy border border-unefa-gold-dark text-xs font-extrabold">5 Asignaturas · 22 U.C.</span>
        </div>
    </div>

    <button
        type="button"
        id="btnDownloadPlanilla"
        class="inline-flex items-center justify-center gap-2 min-h-[2.85rem] px-5 py-2.5 rounded-lg bg-unefa-gold text-unefa-navy border-[1.5px] border-unefa-gold-dark text-sm font-extrabold shadow-sm hover:bg-unefa-gold-light transition-colors cursor-pointer self-start lg:self-auto"
    >
        @include('partials.icon', ['name' => 'file-text', 'clase' => 'w-[17px] h-[17px]'])
        <span>Descargar Planilla de Inscripción (PDF)</span>
    </button>
</div>

{{-- Matriz Semanal de Clases --}}
<section aria-labelledby="weeklyGridTitle" class="bg-white border-[1.5px] border-border-primary rounded-xl shadow-panel overflow-hidden">
    <div class="px-5 py-4 border-b border-border-primary flex flex-wrap items-center justify-between gap-2">
        <div>
            <h2 id="weeklyGridTitle" class="text-base font-extrabold text-unefa-navy">Horario de Clases Semanal</h2>
            <p class="text-xs text-text-muted mt-0.5">Sección: <span class="font-mono font-bold text-unefa-blue">01S-2610-D1</span> · Seleccione un bloque para ver detalles del aula y docente.</p>
        </div>
        <span class="text-xs font-mono text-text-muted">GET /api/academic/students/me/schedule</span>
    </div>

    <div tabindex="0" role="region" aria-labelledby="weeklyGridTitle" class="overflow-x-auto">
        <table class="w-full min-w-[820px] border-collapse table-fixed">
            <caption class="sr-only">Horario semanal de clases de lunes a viernes</caption>
            <thead>
                <tr class="bg-bg-secondary border-b border-border-primary text-xs font-extrabold uppercase tracking-wider text-unefa-navy">
                    <th scope="col" class="w-28 py-3 px-3 text-left border-r border-border-primary">Hora</th>
                    <th scope="col" class="py-3 px-3 text-left border-r border-border-primary">Lunes</th>
                    <th scope="col" class="py-3 px-3 text-left border-r border-border-primary">Martes</th>
                    <th scope="col" class="py-3 px-3 text-left border-r border-border-primary">Miércoles</th>
                    <th scope="col" class="py-3 px-3 text-left border-r border-border-primary">Jueves</th>
                    <th scope="col" class="py-3 px-3 text-left">Viernes</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-primary text-xs">
                @foreach($bloques as $bloque)
                    @php $esCompacto = !empty($bloque['compacto']); @endphp
                    <tr class="{{ $esCompacto ? 'h-14' : 'h-24 align-top' }}">
                        <th scope="row" class="px-3 {{ $esCompacto ? 'py-2 text-text-muted' : 'py-3 text-unefa-navy' }} font-mono font-bold text-left bg-bg-secondary/50 border-r border-border-primary">
                            {{ $bloque['hora'] }}
                        </th>
                        @foreach($bloque['dias'] as $idx => $celda)
                            <td class="{{ $esCompacto ? 'p-1.5' : 'p-2' }} {{ $idx < 4 ? 'border-r border-border-primary' : '' }}">
                                @if($celda)
                                    <button type="button" data-course-modal="{{ $celda['codigo'] }}" class="w-full text-left p-2.5 rounded-md border border-border-primary border-l-4 {{ $celda['fondo'] }} cursor-pointer transition-colors">
                                        <span class="block font-mono text-[0.7rem] font-extrabold {{ $celda['codigoClase'] }}">{{ $celda['codigo'] }}</span>
                                        <span class="block font-extrabold text-unefa-navy mt-0.5">{{ $celda['nombre'] }}</span>
                                        <span class="block text-[0.7rem] text-text-muted mt-1">{{ $celda['detalle'] }}</span>
                                    </button>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

{{-- Tabla Resumen de Carga Academica --}}
<section aria-labelledby="loadSummaryTitle" class="bg-white border-[1.5px] border-border-primary rounded-xl shadow-panel overflow-hidden">
    <div class="px-5 py-4 border-b border-border-primary">
        <h2 id="loadSummaryTitle" class="text-base font-extrabold text-unefa-navy">Resumen de Carga Académica Inscrita</h2>
        <p class="text-xs text-text-muted mt-0.5">Asignaturas validadas para el Periodo Académico 2026-II</p>
    </div>
    <div tabindex="0" role="region" aria-labelledby="loadSummaryTitle" class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <caption class="sr-only">Asignaturas inscritas y unidades de crédito</caption>
            <thead>
                <tr class="bg-bg-secondary border-b border-border-primary text-[0.72rem] font-extrabold uppercase tracking-wider text-text-muted">
                    <th scope="col" class="py-3 px-4">Código</th>
                    <th scope="col" class="py-3 px-4">Asignatura</th>
                    <th scope="col" class="py-3 px-4">Sección</th>
                    <th scope="col" class="py-3 px-4 text-center">U.C.</th>
                    <th scope="col" class="py-3 px-4">Docente Titular</th>
                    <th scope="col" class="py-3 px-4 text-right">Estado</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-subtle">
                @foreach($materias as $m)
                    <tr class="hover:bg-bg-secondary">
                        <td class="py-3 px-4 font-mono text-xs font-bold text-unefa-blue">{{ $m['codigo'] }}</td>
                        <th scope="row" class="py-3 px-4 font-bold text-unefa-navy">{{ $m['nombre'] }}</th>
                        <td class="py-3 px-4 font-mono text-xs">{{ $m['seccion'] }}</td>
                        <td class="py-3 px-4 text-center font-bold">{{ $m['uc'] }}</td>
                        <td class="py-3 px-4 text-text-secondary">{{ $m['docente'] }}</td>
                        <td class="py-3 px-4 text-right">
                            <span class="px-2.5 py-0.5 rounded bg-[#d1fae5] text-[#065f46] text-xs font-extrabold">Inscrita</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-bg-secondary border-t-2 border-border-primary font-extrabold text-unefa-navy">
                    <td colspan="3" class="py-3 px-4">Total: 5 Asignaturas Inscritas</td>
                    <td class="py-3 px-4 text-center font-mono">22 U.C.</td>
                    <td colspan="2" class="py-3 px-4 text-right text-xs text-text-muted">Expediente digital validado</td>
                </tr>
            </tfoot>
        </table>
    </div>
</section>

{{-- Modal Detalle de Bloque / Planilla PDF --}}
<dialog id="scheduleDialog" closedby="any" aria-labelledby="scheduleDialogTitle" class="m-auto w-[min(92vw,29rem)] rounded-xl border-2 border-border-primary bg-white p-6 text-text-primary shadow-2xl">
    <h1 id="scheduleDialogTitle" class="text-lg font-extrabold text-unefa-navy">Detalle de Asignatura</h1>
    <div id="scheduleDialogBody" class="mt-3 text-sm text-text-secondary leading-relaxed"></div>
    <form method="dialog" class="mt-6 flex justify-end gap-3">
        <button type="submit" id="closeScheduleDialog" autofocus class="min-h-[2.75rem] px-5 py-2 rounded-lg bg-unefa-navy-soft text-white text-sm font-bold cursor-pointer hover:bg-unefa-blue">
            Cerrar
        </button>
    </form>
</dialog>
