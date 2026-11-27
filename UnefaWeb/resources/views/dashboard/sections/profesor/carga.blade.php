{{-- Seccion Carga Horaria y Secciones Asignadas --}}
@php
    $bloquesDocente = [
        [
            'hora' => '08:45 - 10:15',
            'dias' => [
                ['sec' => '01S-2610-D1', 'cod' => 'ING-SIS-601', 'materia' => 'Ingeniería de Software', 'aula' => '01S-2610-D1 · Aula B-204', 'bg' => 'bg-surface-input border-l-unefa-blue hover:bg-bg-tertiary', 'codCls' => 'text-unefa-blue'],
                null,
                null,
                ['sec' => '01S-2610-D1', 'cod' => 'ING-SIS-601', 'materia' => 'Ingeniería de Software', 'aula' => '01S-2610-D1 · Aula B-204', 'bg' => 'bg-surface-input border-l-unefa-blue hover:bg-bg-tertiary', 'codCls' => 'text-unefa-blue'],
                null,
            ],
        ],
        [
            'hora' => '10:30 - 12:00',
            'dias' => [
                null,
                null,
                ['sec' => '02S-2612-D1', 'cod' => 'ING-SIS-704', 'materia' => 'Arquitectura de Software', 'aula' => '02S-2612-D1 · Lab. Comp. 1', 'bg' => 'bg-[#d1fae5]/25 border-l-unefa-green hover:bg-[#d1fae5]/45', 'codCls' => 'text-[#065f46]'],
                null,
                ['sec' => '02S-2612-D1', 'cod' => 'ING-SIS-704', 'materia' => 'Arquitectura de Software', 'aula' => '02S-2612-D1 · Lab. Comp. 1', 'bg' => 'bg-[#d1fae5]/25 border-l-unefa-green hover:bg-[#d1fae5]/45', 'codCls' => 'text-[#065f46]'],
            ],
        ],
        [
            'hora' => '17:30 - 19:00',
            'dias' => [
                null,
                ['sec' => '01S-2610-N1', 'cod' => 'ING-SIS-601', 'materia' => 'Ingeniería de Software', 'aula' => '01S-2610-N1 · Aula B-206', 'bg' => 'bg-unefa-gold/12 border-l-unefa-gold-dark hover:bg-unefa-gold/25', 'codCls' => 'text-unefa-gold-dark'],
                null,
                null,
                ['sec' => '01S-2610-N1', 'cod' => 'ING-SIS-601', 'materia' => 'Ingeniería de Software', 'aula' => '01S-2610-N1 · Aula B-206', 'bg' => 'bg-unefa-gold/12 border-l-unefa-gold-dark hover:bg-unefa-gold/25', 'codCls' => 'text-unefa-gold-dark'],
            ],
        ],
    ];

    $resumenSecciones = [
        ['seccion' => '01S-2610-D1', 'materia' => 'Ingeniería de Software', 'turnoAula' => 'Diurno · Aula B-204', 'inscritos' => 32, 'cerradas' => 12, 'pct' => '90,2%', 'pctCls' => 'font-black text-[#047857]', 'btnCls' => 'bg-unefa-gold text-unefa-navy font-extrabold'],
        ['seccion' => '01S-2610-N1', 'materia' => 'Ingeniería de Software', 'turnoAula' => 'Nocturno · Aula B-206', 'inscritos' => 28, 'cerradas' => 10, 'pct' => '86,8%', 'pctCls' => 'font-black text-[#047857]', 'btnCls' => 'bg-unefa-navy-soft text-white font-bold'],
        ['seccion' => '02S-2612-D1', 'materia' => 'Arquitectura de Software', 'turnoAula' => 'Diurno · Lab. Comp. 1', 'inscritos' => 26, 'cerradas' => 0, 'pct' => '0%', 'pctCls' => 'font-mono font-bold text-text-muted', 'btnCls' => 'bg-unefa-navy-soft text-white font-bold'],
    ];
@endphp

<div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <h1 class="text-2xl sm:text-[1.75rem] font-black tracking-tight text-unefa-navy">Carga Horaria y Secciones Asignadas</h1>
        <div class="flex flex-wrap items-center gap-2 mt-2">
            <span class="px-2.5 py-0.5 rounded bg-unefa-blue text-white text-xs font-extrabold">Periodo 2026-II</span>
            <span class="px-2.5 py-0.5 rounded bg-bg-tertiary text-unefa-navy border border-border-primary text-xs font-bold">3 Secciones · 12 Horas Académicas / Sem</span>
            <span class="px-2.5 py-0.5 rounded bg-unefa-gold/25 text-unefa-navy border border-unefa-gold-dark text-xs font-extrabold">86 Estudiantes Totales</span>
        </div>
    </div>
    <a href="{{ route('dashboard', ['rol' => $rol, 'seccion' => 'actas']) }}" class="inline-flex items-center justify-center gap-2 min-h-[2.75rem] px-4 py-2 rounded-lg bg-unefa-gold text-unefa-navy border-[1.5px] border-unefa-gold-dark text-sm font-extrabold hover:bg-unefa-gold-light no-underline self-start md:self-auto">
        <span>Emitir Actas de Asistencia PDF →</span>
    </a>
</div>

{{-- Rejilla Semanal Docente --}}
<section aria-labelledby="docGridTitle" class="bg-white border-[1.5px] border-border-primary rounded-xl shadow-panel overflow-hidden">
    <div class="px-5 py-4 border-b border-border-primary flex flex-wrap items-center justify-between gap-2">
        <div>
            <h2 id="docGridTitle" class="text-base font-extrabold text-unefa-navy">Matriz Horaria Semanal</h2>
            <p class="text-xs text-text-muted mt-0.5">Haga clic sobre cualquier bloque de cátedra para ver aula, capacidad y abrir sesión.</p>
        </div>
        <span class="text-xs font-mono text-text-muted">GET /api/academic/teachers/me/load</span>
    </div>

    <div class="overflow-x-auto" tabindex="0" role="region" aria-labelledby="docGridTitle">
        <table class="w-full min-w-[820px] border-collapse table-fixed">
            <caption class="sr-only">Matriz horaria semanal de clases asignadas al docente</caption>
            <thead>
                <tr class="bg-bg-secondary border-b border-border-primary text-xs font-extrabold uppercase tracking-wider text-unefa-navy">
                    <th scope="col" class="w-28 py-3 px-3 text-left border-r border-border-primary">Bloque</th>
                    <th scope="col" class="py-3 px-3 text-left border-r border-border-primary">Lunes</th>
                    <th scope="col" class="py-3 px-3 text-left border-r border-border-primary">Martes</th>
                    <th scope="col" class="py-3 px-3 text-left border-r border-border-primary">Miércoles</th>
                    <th scope="col" class="py-3 px-3 text-left border-r border-border-primary">Jueves</th>
                    <th scope="col" class="py-3 px-3 text-left">Viernes</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-primary text-xs">
                @foreach($bloquesDocente as $fila)
                    <tr class="h-24 align-top">
                        <th scope="row" class="px-3 py-3 font-mono font-bold text-unefa-navy bg-bg-secondary/50 border-r border-border-primary text-left">{{ $fila['hora'] }}</th>
                        @foreach($fila['dias'] as $idx => $celda)
                            <td class="p-2 {{ $idx < 4 ? 'border-r border-border-primary' : '' }}">
                                @if($celda)
                                    <button type="button" data-sec-modal="{{ $celda['sec'] }}" class="w-full text-left p-2.5 rounded-md border border-border-primary border-l-4 {{ $celda['bg'] }} cursor-pointer">
                                        <span class="block font-mono text-[0.7rem] font-extrabold {{ $celda['codCls'] }}">{{ $celda['cod'] }}</span>
                                        <span class="block font-extrabold text-unefa-navy mt-0.5">{{ $celda['materia'] }}</span>
                                        <span class="block text-[0.7rem] text-text-muted mt-1">{{ $celda['aula'] }}</span>
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

{{-- Detalle de Secciones Asignadas --}}
<section aria-labelledby="secTableTitle" class="bg-white border-[1.5px] border-border-primary rounded-xl shadow-panel overflow-hidden">
    <div class="px-5 py-4 border-b border-border-primary">
        <h2 id="secTableTitle" class="text-base font-extrabold text-unefa-navy">Resumen de Secciones y Avance de Clases</h2>
    </div>
    <div class="overflow-x-auto" tabindex="0" role="region" aria-labelledby="secTableTitle">
        <table class="w-full text-left border-collapse text-sm">
            <caption class="sr-only">Resumen de secciones, avance de sesiones cerradas y promedio de asistencia</caption>
            <thead>
                <tr class="bg-bg-secondary border-b border-border-primary text-[0.72rem] font-extrabold uppercase tracking-wider text-text-muted">
                    <th scope="col" class="py-3 px-4">Sección</th>
                    <th scope="col" class="py-3 px-4">Asignatura</th>
                    <th scope="col" class="py-3 px-4">Turno / Aula</th>
                    <th scope="col" class="py-3 px-4 text-center">Inscritos</th>
                    <th scope="col" class="py-3 px-4 text-center">Sesiones Cerradas</th>
                    <th scope="col" class="py-3 px-4 text-center">% Asistencia</th>
                    <th scope="col" class="py-3 px-4 text-right">Gestión</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-border-subtle">
                @foreach($resumenSecciones as $sec)
                    <tr class="hover:bg-bg-secondary">
                        <th scope="row" class="py-3.5 px-4 font-mono text-xs font-extrabold text-unefa-blue">{{ $sec['seccion'] }}</th>
                        <td class="py-3.5 px-4 font-bold text-unefa-navy">{{ $sec['materia'] }}</td>
                        <td class="py-3.5 px-4 text-xs text-text-secondary">{{ $sec['turnoAula'] }}</td>
                        <td class="py-3.5 px-4 text-center font-bold">{{ $sec['inscritos'] }}</td>
                        <td class="py-3.5 px-4 text-center font-mono">{{ $sec['cerradas'] }}</td>
                        <td class="py-3.5 px-4 text-center {{ $sec['pctCls'] }}">{{ $sec['pct'] }}</td>
                        <td class="py-3.5 px-4 text-right whitespace-nowrap">
                            <a href="{{ route('dashboard', ['rol' => $rol, 'seccion' => 'sesion-activa']) }}" class="px-3 py-1.5 rounded {{ $sec['btnCls'] }} text-xs mr-1.5 no-underline">Sesión</a>
                            <a href="{{ route('dashboard', ['rol' => $rol, 'seccion' => 'actas']) }}" class="px-3 py-1.5 rounded bg-bg-secondary border border-border-primary text-unefa-navy text-xs font-bold no-underline">Acta</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

{{-- Modal Detalle Seccion --}}
<dialog
    id="sectionDetailDialog"
    closedby="any"
    aria-labelledby="secDlgTitle"
    class="m-auto w-[min(92vw,28rem)] rounded-xl border-2 border-border-primary bg-white p-6 text-text-primary shadow-2xl"
>
    <h1 id="secDlgTitle" class="text-lg font-extrabold text-unefa-navy">Detalle de Sección</h1>
    <div id="secDlgBody" class="mt-3 text-sm text-text-secondary space-y-2"></div>
    <div class="mt-6 flex justify-end gap-2.5">
        <form method="dialog">
            <button type="submit" id="closeSecDlg" class="min-h-[2.75rem] px-4 py-2 rounded-lg bg-white border border-border-primary text-sm font-bold text-unefa-navy cursor-pointer">Cerrar</button>
        </form>
        <a href="{{ route('dashboard', ['rol' => $rol, 'seccion' => 'sesion-activa']) }}" class="inline-flex items-center min-h-[2.75rem] px-4 py-2 rounded-lg bg-unefa-gold text-unefa-navy border border-unefa-gold-dark text-sm font-extrabold no-underline">Ir a Sesión →</a>
    </div>
</dialog>
