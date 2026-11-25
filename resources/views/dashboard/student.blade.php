@extends('layouts.dashboard')

@php
    $abrirModalJustificativo = $errors->hasAny(['session_id', 'file_type', 'document', 'observations']);
    $fotoUrl = null;
    if (!empty($estudiante['foto'])) {
        $fotoUrl = str_starts_with($estudiante['foto'], 'http')
            ? $estudiante['foto']
            : asset('storage/' . ltrim($estudiante['foto'], '/'));
    }
@endphp

@section('title', 'Panel Estudiante | Portal UNEFA')
@section('header-subtitle', 'Panel Estudiante')
@section('descripcion', 'Panel del estudiante del Sistema Integral de Asistencias y Carnetización Digital de la UNEFA. Período académico ' . $periodo['nombre'] . '.')

@section('content')
   

    @if(session('student_status'))
        <div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-xs font-bold text-emerald-800" role="status">
            {{ session('student_status') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mt-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-xs font-bold text-red-700" role="alert">
            <p class="mb-1 font-extrabold">Revise los datos ingresados:</p>
            <ul class="list-disc space-y-0.5 pl-4 font-semibold">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mt-4">
        <div class="grid items-stretch gap-5 lg:grid-cols-2">
            @include('partials.session-banner', [
                'insignia' => $estudiante['insignia'],
                'insigniaFondo' => 'bg-slate-100',
                'insigniaTexto' => 'text-slate-700',
                'icono' => 'graduation-cap',
                'acentoFondo' => 'bg-slate-300',
                'bordeClase' => 'border-slate-200',
                'nombre' => $estudiante['nombre'],
                'cedula' => $estudiante['cedula'],
                'departamento' => $estudiante['departamento'],
                'subtitulo' => $estudiante['subtitulo'],
                'matricula' => $estudiante['matricula'],
                'claseContenedor' => 'mb-0 h-full',
                'distribuir' => true,
            ])

            {{-- Carnet digital con datos reales de user_account, profile, career y user_role --}}
            <div class="relative flex h-full flex-col overflow-hidden rounded-[18px] border border-unefa-gold/60 bg-white p-5 shadow-sm ring-1 ring-slate-100">
                <div class="relative flex flex-1 flex-col justify-center">
                    <div class="flex flex-wrap items-start justify-between gap-3 border-b border-slate-200 pb-3">
                        <div>
                            <p class="text-[11px] font-extrabold tracking-[0.4px] text-slate-600">REPÚBLICA BOLIVARIANA DE VENEZUELA</p>
                            <p class="text-[11px] tracking-[0.3px] text-slate-500">MINISTERIO DEL PODER POPULAR PARA LA DEFENSA</p>
                            <p class="mt-1 text-sm font-black tracking-[0.5px] text-slate-900">UNEFA · CARNET DE ASISTENCIA DIGITAL</p>
                        </div>
                        <span class="rounded-md bg-amber-100 px-2.5 py-1 text-xs font-black text-amber-800">{{ $periodo['nombre'] }}</span>
                    </div>

                    <div class="my-4 border-t border-dashed border-slate-200" aria-hidden="true"></div>

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-center">
                        <div class="mx-auto flex h-28 w-24 shrink-0 flex-col items-center justify-center gap-1 overflow-hidden rounded-[10px] border-2 border-unefa-gold bg-white/95 p-1 sm:mx-0">
                            @if($fotoUrl)
                                <img
                                    src="{{ $fotoUrl }}"
                                    alt="Foto de {{ $estudiante['nombre'] }}"
                                    class="h-full w-full rounded-[6px] object-cover"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                />
                                <div class="hidden h-full w-full flex-col items-center justify-center gap-1">
                                    @include('partials.icon', ['name' => 'user', 'clase' => 'h-10 w-10 text-slate-400'])
                                    <span class="text-center text-[11px] font-extrabold text-slate-500">SIN FOTO</span>
                                </div>
                            @else
                                @include('partials.icon', ['name' => 'user', 'clase' => 'h-10 w-10 text-slate-400'])
                                <span class="text-center text-[11px] font-extrabold text-slate-500">FOTO</span>
                            @endif
                        </div>

                        <div class="min-w-0 flex-1">
                            <p class="mb-1 text-base font-black text-slate-900">{{ $estudiante['nombre'] }}</p>
                            <p class="mb-1 text-[13px] font-extrabold text-amber-700">{{ $estudiante['cedula'] }}</p>
                            <p class="mb-1 text-[11px] font-bold text-slate-500">{{ $estudiante['carrera_mayusculas'] }}</p>
                            <p class="mb-3 text-[11px] font-extrabold text-emerald-700">{{ $estudiante['condicion'] }}</p>

                            <div class="flex items-center gap-3 rounded-lg bg-slate-50 p-2">
                                <div
                                    id="student-qr-container"
                                    data-qr-token="{{ $estudiante['qr_token'] }}"
                                    class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-[4px] border border-slate-200 bg-white p-1"
                                    role="img"
                                    aria-label="Código QR del estudiante matrícula {{ $estudiante['matricula'] }}"
                                ></div>

                                <div class="min-w-0">
                                    <span class="block truncate font-mono text-[11px] font-bold tracking-[0.5px] text-slate-900" title="{{ $estudiante['qr_token'] }}">
                                        QR · {{ $estudiante['qr_token'] ?: 'SIN TOKEN' }}
                                    </span>
                                    <span class="mt-0.5 block truncate font-mono text-[11px] font-bold text-slate-500">
                                        MAT: {{ $estudiante['matricula'] }}
                                    </span>
                                    <span class="mt-1 block text-[10px] font-semibold text-emerald-700">
                                        Credencial digital verificada
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5 flex flex-col gap-5">
            {{-- Métricas reales del estudiante --}}
            <div class="grid grid-cols-2 gap-2.5 lg:grid-cols-4">
                @include('partials.metric-card', [
                    'valor' => $metricas['semestre'],
                    'etiqueta' => 'Semestre en curso',
                    'icono' => 'calendar',
                    'acento' => 'text-slate-900',
                    'acentoBarra' => 'bg-slate-300',
                ])
                @include('partials.metric-card', [
                    'valor' => $metricas['materias_inscritas'],
                    'etiqueta' => 'Materias inscritas',
                    'icono' => 'book-open',
                    'acento' => 'text-slate-900',
                    'acentoBarra' => 'bg-slate-300',
                ])
                @include('partials.metric-card', [
                    'valor' => $metricas['promedio_general'],
                    'etiqueta' => 'Promedio general',
                    'icono' => 'award',
                    'acento' => 'text-slate-900',
                    'acentoBarra' => 'bg-slate-500',
                ])
                @include('partials.metric-card', [
                    'valor' => $metricas['asistencia_global_texto'],
                    'etiqueta' => 'Asistencia global',
                    'tipo' => 'porcentaje',
                    'porcentaje' => $metricas['asistencia_global'],
                    'acento' => $metricas['asistencia_global'] >= 75 ? 'text-unefa-green' : 'text-amber-700',
                    'acentoBarra' => $metricas['asistencia_global'] >= 75 ? 'bg-unefa-green' : 'bg-unefa-goldDark',
                    'nota' => 'Meta ≥ 75%',
                    'notaColor' => $metricas['asistencia_global'] >= 75 ? 'text-emerald-700' : 'text-amber-700',
                ])
            </div>

            {{-- Módulo: Asignaturas y control de asistencias desde BD --}}
            <div class="rounded-[18px] border border-slate-200 bg-white p-5 shadow-sm">
                <div class="mb-4 flex flex-wrap items-start justify-between gap-3 border-b border-slate-200 pb-3">
                    <div>
                        <p class="mb-0.5 text-[10px] font-extrabold uppercase tracking-[0.6px] text-amber-700">CONTROL DE ASISTENCIAS</p>
                        <h2 class="text-base font-black text-slate-900">Mis asignaturas inscritas</h2>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        @if(count($periodos) > 0)
                            <form method="GET" action="{{ route('dashboard.estudiante') }}" class="flex flex-wrap items-center gap-2">
                                <label for="period_id" class="sr-only">Período académico</label>
                                <select id="period_id" name="period_id" class="rounded-lg border border-slate-300 bg-white px-2.5 py-1 text-xs font-bold text-slate-700 focus:border-slate-900 focus:outline-none">
                                    @foreach($periodos as $itemPeriodo)
                                        <option value="{{ $itemPeriodo['id'] }}" @selected((int) ($filtros['period_id'] ?? 0) === $itemPeriodo['id'])>
                                            {{ $itemPeriodo['nombre'] }}
                                        </option>
                                    @endforeach
                                </select>

                                <label for="subject_code" class="sr-only">Código de asignatura</label>
                                <input
                                    id="subject_code"
                                    name="subject_code"
                                    type="text"
                                    maxlength="20"
                                    value="{{ $filtros['subject_code'] ?? '' }}"
                                    placeholder="Código (ej. SIS-701)"
                                    class="w-36 rounded-lg border border-slate-300 bg-white px-2.5 py-1 text-xs font-semibold text-slate-700 placeholder:text-slate-400 focus:border-slate-900 focus:outline-none"
                                />

                                <button type="submit" class="rounded-lg bg-slate-900 px-3 py-1 text-xs font-bold text-white transition hover:bg-slate-800">
                                    Filtrar
                                </button>
                            </form>
                        @endif

                        @include('partials.status-badge', [
                            'texto' => $metricas['es_solvente'] ? 'Solvente' : 'En observación',
                            'tipo' => $metricas['es_solvente'] ? 'success' : 'warning',
                        ])
                    </div>
                </div>

                @if(count($asignaturas) === 0)
                    <div class="rounded-[14px] border border-dashed border-slate-300 bg-slate-50 p-6 text-center">
                        <p class="text-sm font-extrabold text-slate-700">No hay asignaturas inscritas para los criterios seleccionados.</p>
                        <p class="mt-1 text-xs font-semibold text-slate-500">Verifique el período académico o limpie el filtro de código.</p>
                    </div>
                @else
                    <div class="grid gap-3 xl:grid-cols-2">
                        @foreach($asignaturas as $asignatura)
                            <div class="group rounded-[14px] border border-slate-200 bg-slate-50 p-3.5 transition duration-150 hover:-translate-y-0.5 hover:border-slate-300 hover:shadow-md motion-reduce:transform-none motion-reduce:transition-none">
                                <div class="mb-2 flex flex-wrap items-center justify-between gap-2">
                                    <div class="flex items-center gap-1.5">
                                        <span class="rounded-md bg-slate-200 px-1.5 py-0.5 font-mono text-[11px] font-extrabold text-slate-700">{{ $asignatura['codigo'] }}</span>
                                        @if(!empty($asignatura['seccion']))
                                            <span class="rounded-md bg-amber-100 px-1.5 py-0.5 font-mono text-[11px] font-bold text-amber-800">Sec. {{ $asignatura['seccion'] }}</span>
                                        @endif
                                    </div>
                                    @include('partials.status-badge', ['texto' => $asignatura['porcentaje'] . '%', 'tipo' => $asignatura['estado']])
                                </div>
                                <h3 class="mb-0.5 text-sm font-extrabold text-slate-900">{{ $asignatura['nombre'] }}</h3>
                                <p class="mb-3 text-xs font-semibold text-slate-500">{{ $asignatura['profesor'] }}</p>

                                @include('partials.progress-bar', [
                                    'porcentaje' => $asignatura['porcentaje'],
                                    'etiqueta' => 'Asistencia',
                                    'color' => $asignatura['barra'],
                                    'textoColor' => $asignatura['texto'],
                                ])

                                <div class="mt-3 flex flex-wrap items-center justify-between gap-2 border-t border-slate-200 pt-2">
                                    <span class="flex min-w-0 items-center gap-1">
                                        @include('partials.icon', ['name' => 'map-pin', 'clase' => 'h-3.5 w-3.5 shrink-0 text-slate-500'])
                                        <span class="truncate text-[11px] font-semibold text-slate-600">{{ $asignatura['aula'] }}</span>
                                    </span>
                                    <span class="text-[11px] font-bold text-slate-700">{{ $asignatura['asistidas'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Trámites y constancias --}}
            <div class="rounded-[18px] border border-slate-200 bg-white p-5 shadow-sm">
                <div class="mb-4 border-b border-slate-200 pb-3">
                    <p class="mb-0.5 text-[10px] font-extrabold uppercase tracking-[0.6px] text-amber-700">TRÁMITES Y CONSTANCIAS</p>
                    <h2 class="text-base font-black text-slate-900">Servicios digitales disponibles</h2>
                </div>

                <div class="mt-1 grid gap-2.5 lg:grid-cols-2">
                    @php
                        $tramites = [
                            ['titulo' => 'Constancia de Estudio', 'detalle' => 'Descarga inmediata con firma digital y sello QR', 'accion' => null],
                            ['titulo' => 'Récord de Calificaciones', 'detalle' => 'Historial acumulado y promedio ponderado', 'accion' => null],
                            ['titulo' => 'Horario Semanal ' . $periodo['nombre'], 'detalle' => 'Distribución de bloques por aula y laboratorio', 'accion' => null],
                            ['titulo' => 'Justificar Inasistencia', 'detalle' => 'Consignación digital de justificativo médico/laboral', 'accion' => 'justificar'],
                        ];
                    @endphp

                    @foreach($tramites as $tramite)
                        @if($tramite['accion'] === 'justificar')
                            <button type="button" data-abrir-justificativo class="group flex items-start justify-between gap-2 rounded-xl border border-slate-200 bg-slate-50 p-3 text-left transition duration-150 hover:-translate-y-0.5 hover:border-slate-300 hover:bg-white hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-900 motion-reduce:transform-none motion-reduce:transition-none">
                                <span class="min-w-0">
                                    <span class="mb-0.5 block text-[13px] font-extrabold text-slate-900">{{ $tramite['titulo'] }}</span>
                                    <span class="block text-[11px] leading-4 text-slate-600">{{ $tramite['detalle'] }}</span>
                                </span>
                                @include('partials.icon', ['name' => 'chevron-right', 'clase' => 'h-4 w-4 shrink-0 text-slate-600 transition group-hover:translate-x-0.5 motion-reduce:transition-none'])
                            </button>
                        @else
                            <button type="button" aria-disabled="true" title="Disponible en próxima fase" class="group flex items-start justify-between gap-2 rounded-xl border border-slate-200 bg-slate-50 p-3 text-left transition duration-150 hover:-translate-y-0.5 hover:border-slate-300 hover:bg-white hover:shadow-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-slate-900 motion-reduce:transform-none motion-reduce:transition-none">
                                <span class="min-w-0">
                                    <span class="mb-0.5 block text-[13px] font-extrabold text-slate-900">{{ $tramite['titulo'] }}</span>
                                    <span class="block text-[11px] leading-4 text-slate-600">{{ $tramite['detalle'] }}</span>
                                </span>
                                @include('partials.icon', ['name' => 'chevron-right', 'clase' => 'h-4 w-4 shrink-0 text-slate-600 transition group-hover:translate-x-0.5 motion-reduce:transition-none'])
                            </button>
                        @endif
                    @endforeach
                </div>

                @if(count($justificativos) > 0)
                    <div class="mt-4 border-t border-slate-200 pt-4">
                        <p class="mb-2 text-[11px] font-extrabold uppercase tracking-[0.5px] text-slate-600">Mis justificativos consignados</p>
                        <div class="space-y-2">
                            @foreach($justificativos as $doc)
                                <div class="flex flex-wrap items-center justify-between gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-xs">
                                    <div class="min-w-0">
                                        <p class="truncate font-extrabold text-slate-900">{{ $doc['archivo'] }} <span class="font-semibold text-slate-500">({{ $doc['tipo'] }})</span></p>
                                        <p class="truncate text-[11px] text-slate-600">{{ $doc['observaciones'] }}</p>
                                    </div>
                                    @include('partials.status-badge', [
                                        'texto' => $doc['estado'],
                                        'tipo' => $doc['estado'] === 'Approved' ? 'success' : ($doc['estado'] === 'Rejected' ? 'warning' : 'info'),
                                    ])
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <p class="pb-2 text-center text-[11px] font-semibold text-slate-500">
                Sistema Integral de Asistencias y Carnetización Digital · UNEFA {{ $periodo['nombre'] }}
            </p>
        </div>
    </div>

    {{-- Modal para consignar justificativo de inasistencia --}}
    <div id="modal-justificativo" class="{{ $abrirModalJustificativo ? 'flex' : 'hidden' }} fixed inset-0 z-50 items-center justify-center bg-[rgba(6,21,42,0.65)] p-4" role="dialog" aria-modal="true" aria-label="Consignar justificativo de inasistencia">
        <div data-cerrar-justificativo class="absolute inset-0"></div>
        <div class="relative w-full max-w-md rounded-[22px] bg-white p-6 shadow-2xl">
            <div class="mb-4 flex items-start justify-between gap-2 border-b border-slate-200 pb-3">
                <div>
                    <p class="text-[10px] font-extrabold uppercase tracking-[0.6px] text-amber-700">TRÁMITE DIGITAL</p>
                    <h3 class="text-base font-black text-slate-900">Justificar Inasistencia</h3>
                </div>
                <button type="button" data-cerrar-justificativo class="rounded-lg border border-slate-200 px-2.5 py-1 text-xs font-bold text-slate-600 hover:bg-slate-50">
                    Cerrar
                </button>
            </div>

            <form method="POST" action="{{ route('dashboard.estudiante.justificativos.store') }}" enctype="multipart/form-data" class="space-y-3.5">
                @csrf

                @if(count($sesionesAusentes) > 0)
                    <div>
                        <label for="session_id" class="mb-1 block text-xs font-bold text-slate-700">Sesión con inasistencia (opcional)</label>
                        <select id="session_id" name="session_id" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-xs font-semibold text-slate-800 focus:border-slate-900 focus:outline-none">
                            <option value="">General / Sin sesión específica</option>
                            @foreach($sesionesAusentes as $sesion)
                                <option value="{{ $sesion['id'] }}" @selected((string) old('session_id') === (string) $sesion['id'])>
                                    {{ $sesion['etiqueta'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div>
                    <label for="file_type" class="mb-1 block text-xs font-bold text-slate-700">Tipo de documento</label>
                    <select id="file_type" name="file_type" required class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-xs font-semibold text-slate-800 focus:border-slate-900 focus:outline-none">
                        <option value="PDF" @selected(old('file_type', 'PDF') === 'PDF')>PDF</option>
                        <option value="Image" @selected(old('file_type') === 'Image')>Imagen (JPG / PNG)</option>
                        <option value="Word" @selected(old('file_type') === 'Word')>Word (DOC / DOCX)</option>
                        <option value="Excel" @selected(old('file_type') === 'Excel')>Excel (XLS / XLSX)</option>
                    </select>
                </div>

                <div>
                    <label for="document" class="mb-1 block text-xs font-bold text-slate-700">Archivo de soporte (máx. 5 MB)</label>
                    <input id="document" name="document" type="file" required accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-2 text-xs font-semibold text-slate-700" />
                </div>

                <div>
                    <label for="observations" class="mb-1 block text-xs font-bold text-slate-700">Motivo / Observaciones</label>
                    <textarea id="observations" name="observations" rows="3" required minlength="10" maxlength="500" placeholder="Explique brevemente el motivo médico o laboral de la inasistencia..." class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-xs font-semibold text-slate-800 focus:border-slate-900 focus:outline-none">{{ old('observations') }}</textarea>
                </div>

                <div class="flex gap-2.5 pt-1">
                    <button type="button" data-cerrar-justificativo class="flex-1 rounded-xl border border-slate-300 py-2.5 text-xs font-bold text-slate-800 transition hover:bg-slate-50">
                        Cancelar
                    </button>
                    <button type="submit" class="flex-1 rounded-xl bg-slate-900 py-2.5 text-xs font-extrabold text-white transition hover:bg-slate-800">
                        Enviar justificativo
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function () {
            var modal = document.getElementById('modal-justificativo');
            if (modal) {
                document.querySelectorAll('[data-abrir-justificativo]').forEach(function (btn) {
                    btn.addEventListener('click', function () {
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                    });
                });

                document.querySelectorAll('[data-cerrar-justificativo]').forEach(function (btn) {
                    btn.addEventListener('click', function () {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                    });
                });
            }

            // Genera una matriz SVG determinística basada en el qr_token real del estudiante
            var qrBox = document.getElementById('student-qr-container');
            if (qrBox) {
                var token = (qrBox.getAttribute('data-qr-token') || '').trim();
                var size = 21;
                var hash = 2166136261;
                for (var i = 0; i < token.length; i++) {
                    hash ^= token.charCodeAt(i);
                    hash = Math.imul(hash, 16777619);
                }

                var isFinder = function (r, c) {
                    return (r < 7 && c < 7) || (r < 7 && c >= size - 7) || (r >= size - 7 && c < 7);
                };

                var rects = ['<rect width="21" height="21" fill="#ffffff"/>'];
                var drawFinder = function (ox, oy) {
                    rects.push('<rect x="' + ox + '" y="' + oy + '" width="7" height="7" fill="#0f172a"/>');
                    rects.push('<rect x="' + (ox + 1) + '" y="' + (oy + 1) + '" width="5" height="5" fill="#ffffff"/>');
                    rects.push('<rect x="' + (ox + 2) + '" y="' + (oy + 2) + '" width="3" height="3" fill="#0f172a"/>');
                };
                drawFinder(0, 0);
                drawFinder(size - 7, 0);
                drawFinder(0, size - 7);

                var seed = (hash >>> 0) || 123456789;
                for (var r = 0; r < size; r++) {
                    for (var c = 0; c < size; c++) {
                        if (isFinder(r, c)) continue;
                        seed = (Math.imul(seed, 1664525) + 1013904223) >>> 0;
                        if (token.length > 0 && ((seed >>> 28) & 1) === 1) {
                            rects.push('<rect x="' + c + '" y="' + r + '" width="1" height="1" fill="#0f172a"/>');
                        }
                    }
                }

                qrBox.innerHTML = '<svg viewBox="0 0 21 21" class="h-full w-full">' + rects.join('') + '</svg>';
            }
        })();
    </script>
@endpush