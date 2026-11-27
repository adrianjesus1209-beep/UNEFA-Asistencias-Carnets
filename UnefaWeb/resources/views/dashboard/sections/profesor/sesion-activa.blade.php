{{-- Seccion Control de Sesion en Vivo y QR de Aula (Modalidad A) --}}
<div class="flex flex-col xl:flex-row xl:items-end justify-between gap-4">
    <div>
        <div class="flex flex-wrap items-center gap-2 mb-1.5">
            <span id="sessionStateBadge" class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded bg-[#d1fae5] text-[#065f46] border border-unefa-green text-xs font-black uppercase tracking-wider">
                ● SESIÓN ABIERTA (OPEN)
            </span>
            <span class="px-2.5 py-0.5 rounded bg-bg-tertiary text-unefa-blue font-mono text-xs font-extrabold">ING-SIS-601 · Sec. 01S-2610-D1</span>
            <span class="text-xs font-semibold text-text-muted">Aula B-204 · Tolerancia: 15 min</span>
        </div>
        <h1 class="text-2xl sm:text-[1.75rem] font-black tracking-tight text-unefa-navy">Control de Sesión en Vivo y QR de Aula (Modalidad A)</h1>
    </div>

    <div class="flex flex-wrap items-center gap-2.5">
        <button
            type="button"
            id="btnOpenProjector"
            class="inline-flex items-center justify-center gap-2 min-h-[2.75rem] px-4 py-2 rounded-lg bg-unefa-gold text-unefa-navy border-[1.5px] border-unefa-gold-dark text-sm font-extrabold shadow-sm hover:bg-unefa-gold-light cursor-pointer"
        >
            @include('partials.icon', ['name' => 'maximize', 'clase' => 'w-4 h-4'])
            <span>Proyectar QR (Pantalla Completa)</span>
        </button>
        <a
            href="{{ route('dashboard', ['rol' => $rol, 'seccion' => 'escaner-mod-b']) }}"
            class="inline-flex items-center justify-center gap-2 min-h-[2.75rem] px-4 py-2 rounded-lg bg-white border-[1.5px] border-unefa-navy text-unefa-navy text-sm font-extrabold hover:bg-unefa-navy hover:text-white transition-colors no-underline"
        >
            <span>Escanear Carnets (Mod. B)</span>
        </a>
        <button
            type="button"
            id="btnCloseSessionTrigger"
            class="inline-flex items-center justify-center gap-2 min-h-[2.75rem] px-4 py-2 rounded-lg bg-unefa-red text-white text-sm font-extrabold hover:opacity-95 cursor-pointer"
        >
            <span>Cerrar Sesión</span>
        </button>
    </div>
</div>

{{-- Aviso de Auditoria cuando la sesion ya esta cerrada (RF-10) --}}
<div id="closedAuditBanner" class="hidden px-4 py-3.5 rounded-xl border-2 border-unefa-blue bg-surface-input text-sm text-unefa-navy flex flex-wrap items-center justify-between gap-3" role="status">
    <div>
        <strong>SESIÓN CERRADA (CLOSED):</strong> Los estudiantes sin registro fueron marcados automáticamente como <span class="font-mono font-bold text-unefa-red">ABSENT</span>. Toda modificación manual posterior quedará auditada en <span class="font-mono font-bold">audit_log</span> (RF-10).
    </div>
    <a href="{{ route('dashboard', ['rol' => $rol, 'seccion' => 'actas']) }}" class="px-3.5 py-1.5 rounded-lg bg-unefa-navy-soft text-white text-xs font-extrabold no-underline hover:bg-unefa-blue">
        Ir al Acta PDF →
    </a>
</div>

{{-- Workspace 2 Columnas: QR Dinamico (30s) + Nomina en Tiempo Real --}}
<div class="grid grid-cols-1 lg:grid-cols-[4.5fr_7.5fr] gap-6 items-start">
    {{-- Columna Izquierda: QR Dinamico de Aula (Rotacion 30s / TTL 45s) --}}
    <div class="flex flex-col gap-5">
        <section aria-labelledby="classQrTitle" class="bg-white border-[1.5px] border-border-primary rounded-xl p-5 shadow-panel">
            <div class="flex items-start justify-between gap-2 mb-4">
                <div>
                    <h2 id="classQrTitle" class="text-base font-extrabold text-unefa-navy">QR Dinámico de Aula</h2>
                    <p class="text-xs text-text-muted mt-0.5">Rotación criptográfica cada 30 s (TTL 45 s · HMAC-SHA256)</p>
                </div>
                <span id="qrLiveTag" class="px-2.5 py-1 rounded-full bg-[#d1fae5] text-[#065f46] text-[0.68rem] font-extrabold">● ACTIVO</span>
            </div>

            <div id="classQrBox" class="p-4 rounded-xl bg-bg-secondary border border-border-primary flex flex-col items-center">
                <div class="p-2.5 bg-white rounded-lg border-2 border-unefa-navy">
                    @include('partials.dashboard.qr-svg', ['id' => 'classQrSvg', 'tamano' => 210])
                </div>

                <div class="w-full mt-4">
                    <div class="flex items-center justify-between text-xs font-extrabold mb-1.5">
                        <span class="text-unefa-navy">Próxima rotación en <span id="classQrSec" class="font-mono text-unefa-blue">30s</span></span>
                        <span class="font-mono text-text-muted">TTL 45s</span>
                    </div>
                    <div class="w-full h-2.5 bg-bg-tertiary rounded-full overflow-hidden">
                        <div id="classQrBar" class="h-full bg-unefa-gold transition-all duration-1000" style="width: 100%;"></div>
                    </div>
                    <div class="mt-3 flex items-center justify-between text-[0.7rem] font-mono text-text-muted">
                        <span id="classQrToken">salt: 9f2a10c4 · rot #04</span>
                        <button type="button" id="btnForceRotateClassQr" class="font-sans font-bold text-unefa-blue hover:underline cursor-pointer bg-transparent border-0">
                            Rotar ahora
                        </button>
                    </div>
                </div>
            </div>

            {{-- Contadores en Vivo de la Sesion --}}
            <div class="mt-4 grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-2 gap-2.5">
                <div class="p-3 rounded-lg bg-[#d1fae5]/35 border border-unefa-green/50 text-center">
                    <span class="block text-xl font-black text-[#065f46]" id="cntPresent">4</span>
                    <span class="text-[0.7rem] font-extrabold uppercase text-[#065f46]">Presentes</span>
                </div>
                <div class="p-3 rounded-lg bg-unefa-gold/15 border border-unefa-gold-dark/40 text-center">
                    <span class="block text-xl font-black text-unefa-navy" id="cntLate">1</span>
                    <span class="text-[0.7rem] font-extrabold uppercase text-unefa-gold-dark">Tardanzas</span>
                </div>
                <div class="p-3 rounded-lg bg-surface-input border border-unefa-blue/25 text-center">
                    <span class="block text-xl font-black text-unefa-blue" id="cntJustified">1</span>
                    <span class="text-[0.7rem] font-extrabold uppercase text-unefa-blue">Justificados</span>
                </div>
                <div class="p-3 rounded-lg bg-bg-secondary border border-border-primary text-center">
                    <span class="block text-xl font-black text-unefa-red" id="cntPending">2</span>
                    <span class="text-[0.7rem] font-extrabold uppercase text-text-muted" id="lblPending">Sin Registro</span>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-border-subtle flex items-center justify-between gap-2">
                <span class="text-xs text-text-muted font-semibold">Prueba en tiempo real (Socket.IO):</span>
                <button
                    type="button"
                    id="btnSimulateStudentScan"
                    class="px-3 py-1.5 rounded-md bg-surface-input border border-border-primary text-xs font-extrabold text-unefa-blue hover:bg-bg-tertiary cursor-pointer"
                >
                    + Simular Escaneo
                </button>
            </div>
        </section>
    </div>

    {{-- Columna Derecha: Nomina de Estudiantes con Edicion Manual y Justificacion (RF-10) --}}
    <section aria-labelledby="rosterTitle" class="bg-white border-[1.5px] border-border-primary rounded-xl shadow-panel overflow-hidden">
        <div class="px-5 py-4 border-b border-border-primary flex flex-col gap-3">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h2 id="rosterTitle" class="text-base font-extrabold text-unefa-navy">Nómina de Estudiantes en Tiempo Real</h2>
                    <p class="text-xs text-text-muted mt-0.5">Actualización instantánea vía <span class="font-mono">asistencia.estudiante_registrado</span> · Edición manual habilitada.</p>
                </div>
                <label for="rosterSearch" class="sr-only">Buscar estudiante por nombre o cédula</label>
                <input
                    id="rosterSearch"
                    type="search"
                    placeholder="Buscar nombre o cédula..."
                    class="h-9 px-3 rounded-lg bg-surface-input border border-border-primary text-xs text-unefa-navy w-full sm:w-56 focus:bg-white focus:border-unefa-blue"
                >
            </div>

            <div class="flex flex-wrap gap-2" role="group" aria-label="Filtrar nómina por estado">
                <button type="button" data-roster-filter="ALL" aria-pressed="true" class="roster-pill px-3 py-1 rounded-full text-xs font-extrabold bg-unefa-navy text-white cursor-pointer">Todos</button>
                <button type="button" data-roster-filter="PRESENT" aria-pressed="false" class="roster-pill px-3 py-1 rounded-full text-xs font-bold bg-bg-secondary border border-border-primary text-text-secondary cursor-pointer">Presente</button>
                <button type="button" data-roster-filter="LATE" aria-pressed="false" class="roster-pill px-3 py-1 rounded-full text-xs font-bold bg-bg-secondary border border-border-primary text-text-secondary cursor-pointer">Tardanza</button>
                <button type="button" data-roster-filter="JUSTIFIED" aria-pressed="false" class="roster-pill px-3 py-1 rounded-full text-xs font-bold bg-bg-secondary border border-border-primary text-text-secondary cursor-pointer">Justificada</button>
                <button type="button" data-roster-filter="PENDING" aria-pressed="false" class="roster-pill px-3 py-1 rounded-full text-xs font-bold bg-bg-secondary border border-border-primary text-text-secondary cursor-pointer">Sin Registro / Ausente</button>
            </div>
        </div>

        <div class="overflow-x-auto" tabindex="0" role="region" aria-labelledby="rosterTitle">
            <table class="w-full text-left border-collapse text-sm">
                <caption class="sr-only">Nómina de estudiantes de la sesión activa con estado de asistencia y edición manual</caption>
                <thead>
                    <tr class="bg-bg-secondary border-b border-border-primary text-[0.72rem] font-extrabold uppercase tracking-wider text-text-muted">
                        <th scope="col" class="py-3 px-4">Estudiante</th>
                        <th scope="col" class="py-3 px-4">Hora / Modalidad</th>
                        <th scope="col" class="py-3 px-4">Estado</th>
                        <th scope="col" class="py-3 px-4 text-right">Acción Manual</th>
                    </tr>
                </thead>
                <tbody id="rosterTableBody" class="divide-y divide-border-subtle"></tbody>
            </table>
        </div>
    </section>
</div>

{{-- Modal Proyector Pantalla Completa --}}
<dialog
    id="projectorDialog"
    closedby="any"
    aria-labelledby="projectorTitle"
    class="m-auto w-[min(95vw,44rem)] rounded-2xl border-4 border-unefa-gold bg-unefa-navy text-white p-6 sm:p-8 shadow-2xl"
>
    <div class="flex items-start justify-between gap-4 border-b border-white/15 pb-4">
        <div>
            <span class="text-xs font-extrabold uppercase tracking-[0.12em] text-unefa-gold">Modo Proyector de Aula · Modalidad A</span>
            <h1 id="projectorTitle" class="text-xl sm:text-2xl font-black text-white mt-1">Ingeniería de Software (01S-2610-D1)</h1>
            <p class="text-xs text-[#d8e3fb] mt-0.5">Aula B-204 · Prof. Elena Rivas · Escanea con el portal UNEFA</p>
        </div>
        <form method="dialog">
            <button type="submit" id="closeProjectorBtn" class="px-3.5 py-2 rounded-lg bg-white/10 border border-white/20 text-white text-xs font-extrabold hover:bg-white/20 cursor-pointer">
                Cerrar ✕
            </button>
        </form>
    </div>
    <div class="my-6 flex flex-col items-center">
        <div class="p-4 bg-white rounded-xl border-4 border-unefa-gold">
            @include('partials.dashboard.qr-svg', ['id' => 'projectorQrSvg', 'tamano' => 300])
        </div>
        <p class="mt-4 font-mono text-lg font-extrabold text-unefa-gold">
            Rotación automática en <span id="projectorQrSec">30s</span> · TTL 45s
        </p>
    </div>
</dialog>

{{-- Modal Registro Manual / Justificacion (RF-10) --}}
<dialog
    id="manualEditDialog"
    closedby="any"
    aria-labelledby="manualEditTitle"
    class="m-auto w-[min(92vw,29rem)] rounded-xl border-2 border-border-primary bg-white p-6 text-text-primary shadow-2xl"
>
    <h1 id="manualEditTitle" class="text-lg font-extrabold text-unefa-navy">Registro Manual / Justificación (RF-10)</h1>
    <p id="manualStudentLabel" class="mt-1 text-xs font-mono font-bold text-unefa-blue"></p>

    <div id="manualEditAlert" class="hidden mt-3 px-3.5 py-2.5 rounded-md text-xs font-semibold border border-unefa-red bg-[#ffdad6] text-[#93000a]" role="alert"></div>

    <form id="manualEditForm" class="mt-4 flex flex-col gap-4" novalidate>
        <div class="flex flex-col gap-1.5">
            <label for="manualStatusSelect" class="text-xs font-extrabold uppercase text-unefa-navy">Nuevo Estado de Asistencia *</label>
            <select id="manualStatusSelect" class="h-11 px-3 rounded-lg bg-surface-input border border-border-primary text-sm font-bold text-unefa-navy">
                <option value="PRESENT">PRESENTE (PRESENT)</option>
                <option value="LATE">TARDANZA (LATE)</option>
                <option value="JUSTIFIED">JUSTIFICADA (JUSTIFIED — requiere motivo)</option>
                <option value="ABSENT">AUSENTE (ABSENT)</option>
            </select>
        </div>

        <div class="flex flex-col gap-1.5">
            <label for="manualJustificationInput" class="text-xs font-extrabold uppercase text-unefa-navy">
                Motivo / Justificación <span id="justReqMark" class="text-unefa-red hidden">(Obligatorio *)</span>
            </label>
            <textarea
                id="manualJustificationInput"
                rows="3"
                maxlength="255"
                placeholder="Ej. Constancia de reposo médico avalada por Coordinación..."
                class="w-full px-3 py-2.5 rounded-lg bg-surface-input border border-border-primary text-sm text-unefa-navy focus:bg-white focus:border-unefa-blue resize-y"
            ></textarea>
        </div>

        <div class="mt-2 flex justify-end gap-3">
            <button type="button" id="cancelManualEdit" class="min-h-[2.75rem] px-4 py-2 rounded-lg bg-white border-[1.5px] border-border-primary text-unefa-navy text-sm font-bold cursor-pointer">
                Cancelar
            </button>
            <button type="submit" class="min-h-[2.75rem] px-5 py-2 rounded-lg bg-unefa-navy-soft text-white text-sm font-extrabold hover:bg-unefa-blue cursor-pointer">
                Guardar Cambio
            </button>
        </div>
    </form>
</dialog>

{{-- Modal Confirmacion Cierre de Sesion (RF-10) --}}
<dialog
    id="closeSessionDialog"
    closedby="any"
    aria-labelledby="closeSessionTitle"
    class="m-auto w-[min(92vw,29rem)] rounded-xl border-2 border-unefa-red bg-white p-6 text-text-primary shadow-2xl"
>
    <h1 id="closeSessionTitle" class="text-lg font-extrabold text-unefa-navy">¿Cerrar esta sesión de clase?</h1>
    <p id="closeSessionSummary" class="mt-2 text-sm text-text-secondary leading-relaxed"></p>
    <div class="mt-6 flex justify-end gap-3">
        <button type="button" id="cancelCloseSession" class="min-h-[2.75rem] px-4 py-2 rounded-lg bg-white border-[1.5px] border-border-primary text-unefa-navy text-sm font-bold cursor-pointer">
            Cancelar
        </button>
        <button type="button" id="confirmCloseSession" class="min-h-[2.75rem] px-5 py-2 rounded-lg bg-unefa-red text-white text-sm font-extrabold cursor-pointer hover:opacity-95">
            Confirmar Cierre
        </button>
    </div>
</dialog>
