{{-- Seccion Registrar Asistencia QR (Modalidad A) --}}
@include('partials.dashboard.page-header', [
    'titulo' => 'Registro de Asistencia por Código QR (Modalidad A)',
    'descripcionHtml' => 'Apunte la cámara web hacia el código QR dinámico proyectado por el docente en el aula (<span class="font-mono">POST /api/attendance/scan/modality-a</span>).',
])

<div class="grid grid-cols-1 lg:grid-cols-[7.5fr_4.5fr] gap-6 items-start">
    {{-- Columna Principal: Visor de Camara y Resultado --}}
    <section aria-labelledby="scannerPanelTitle" class="bg-white border-[1.5px] border-border-primary rounded-xl shadow-panel overflow-hidden">
        <div class="px-5 py-3.5 border-b border-border-primary flex flex-wrap items-center justify-between gap-3 bg-bg-secondary">
            <div class="flex items-center gap-2.5">
                <h2 id="scannerPanelTitle" class="sr-only">Visor de cámara web para código QR</h2>
                <label for="cameraSelect" class="sr-only">Seleccionar cámara web</label>
                <select id="cameraSelect" class="h-10 px-3 rounded-lg bg-white border border-border-primary text-xs font-bold text-unefa-navy">
                    <option value="default">Cámara: Webcam HD Integrada</option>
                    <option value="external">Cámara: Dispositivo USB Externo</option>
                </select>
                <button
                    type="button"
                    id="btnToggleWebcam"
                    class="h-10 px-3.5 rounded-lg bg-unefa-navy-soft text-white text-xs font-bold hover:bg-unefa-blue cursor-pointer transition-colors"
                >
                    Activar Cámara Real
                </button>
            </div>
            <span id="cameraLiveBadge" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#d1fae5] text-[#065f46] text-xs font-extrabold">
                ● Cámara Activa · Conexión Segura
            </span>
        </div>

        <div class="p-5">
            <div class="relative w-full aspect-[16/10] bg-[#0b1322] rounded-xl overflow-hidden flex items-center justify-center border-2 border-unefa-navy">
                <video id="realWebcamVideo" class="hidden absolute inset-0 w-full h-full object-cover" autoplay playsinline muted></video>

                <div id="simulatedViewfinder" class="absolute inset-0 bg-[#142033] flex items-center justify-center">
                    <div class="p-4 bg-white rounded-lg shadow-lg opacity-95">
                        @include('partials.dashboard.qr-svg', ['tamano' => 150])
                    </div>
                </div>

                <div class="absolute top-4 left-4 right-4 flex items-center justify-between pointer-events-none">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-unefa-red text-white text-[0.7rem] font-black tracking-wider uppercase">
                        ● LIVE · 1080p
                    </span>
                    <span class="px-3 py-1 rounded bg-unefa-navy/90 text-white text-xs font-bold border border-white/15">
                        Enfoque el QR docente (rotación cada 30s)
                    </span>
                </div>

                <div class="relative z-10 w-56 h-56 pointer-events-none" aria-hidden="true">
                    <span class="absolute top-0 left-0 w-9 h-9 border-t-4 border-l-4 border-unefa-gold"></span>
                    <span class="absolute top-0 right-0 w-9 h-9 border-t-4 border-r-4 border-unefa-gold"></span>
                    <span class="absolute bottom-0 left-0 w-9 h-9 border-b-4 border-l-4 border-unefa-gold"></span>
                    <span class="absolute bottom-0 right-0 w-9 h-9 border-b-4 border-r-4 border-unefa-gold"></span>
                </div>
            </div>

            <div id="scanResultCard" class="mt-4 p-4 rounded-xl border-2 border-unefa-green bg-[#d1fae5]/35 flex items-start gap-3.5" role="status" aria-live="polite">
                <div id="scanResultIcon" class="w-10 h-10 rounded-full bg-unefa-green text-white flex items-center justify-center shrink-0 font-black">
                    ✓
                </div>
                <div class="min-w-0 flex-1">
                    <p id="scanResultHeading" class="text-sm font-black uppercase tracking-wide text-[#065f46]">
                        ASISTENCIA REGISTRADA · PRESENTE
                    </p>
                    <p id="scanResultDetail" class="text-sm font-bold text-unefa-navy mt-0.5">
                        Ingeniería de Software (01S-2610-D1) · Prof. Elena Rivas · Aula B-204
                    </p>
                    <p id="scanResultMeta" class="text-xs font-semibold text-text-muted mt-1">
                        08:52:14 AM · Registrado dentro del margen de tolerancia (15 min)
                    </p>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-border-subtle flex flex-wrap items-center gap-2 text-xs">
                <span class="font-bold text-text-muted mr-1">Simular respuesta API:</span>
                <button type="button" data-sim-scan="present" class="px-2.5 py-1 rounded bg-bg-secondary border border-border-primary font-bold text-[#065f46] hover:bg-[#d1fae5] cursor-pointer">200 Presente</button>
                <button type="button" data-sim-scan="late" class="px-2.5 py-1 rounded bg-bg-secondary border border-border-primary font-bold text-unefa-gold-dark hover:bg-unefa-gold/20 cursor-pointer">200 Tardanza</button>
                <button type="button" data-sim-scan="duplicate" class="px-2.5 py-1 rounded bg-bg-secondary border border-border-primary font-bold text-[#93000a] hover:bg-[#ffdad6] cursor-pointer">409 Duplicado</button>
                <button type="button" data-sim-scan="expired" class="px-2.5 py-1 rounded bg-bg-secondary border border-border-primary font-bold text-[#93000a] hover:bg-[#ffdad6] cursor-pointer">401 QR Expirado</button>
            </div>
        </div>
    </section>

    {{-- Columna Derecha: Sesiones de Hoy + Reglas de Validacion --}}
    <div class="flex flex-col gap-6">
        <section aria-labelledby="todaySessionsTitle" class="bg-white border-[1.5px] border-border-primary rounded-xl shadow-panel overflow-hidden">
            <div class="px-5 py-4 border-b border-border-primary">
                <h2 id="todaySessionsTitle" class="text-base font-extrabold text-unefa-navy">Sesiones de Hoy — Jueves 26 Nov</h2>
            </div>
            <ul class="divide-y divide-border-subtle list-none p-0 m-0">
                <li class="p-4 flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-extrabold text-unefa-navy">Ingeniería de Software</p>
                        <p class="text-xs font-mono text-text-muted mt-0.5">08:45 - 10:15 · Aula B-204 · Prof. Elena Rivas</p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded bg-[#d1fae5] text-[#065f46] text-[0.7rem] font-extrabold shrink-0">✓ PRESENTE</span>
                </li>
                <li class="p-4 flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-extrabold text-unefa-navy">Redes y Teleproceso</p>
                        <p class="text-xs font-mono text-text-muted mt-0.5">10:30 - 12:00 · Aula B-108 · Prof. Juan Blanco</p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded bg-unefa-blue/10 text-unefa-blue text-[0.7rem] font-extrabold shrink-0">Próxima</span>
                </li>
                <li class="p-4 flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-extrabold text-unefa-navy">Defensa Integral VI</p>
                        <p class="text-xs font-mono text-text-muted mt-0.5">14:00 - 15:30 · Patio de Honor · Prof. Luis Vásquez</p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded bg-bg-tertiary text-text-muted text-[0.7rem] font-extrabold shrink-0">Programada</span>
                </li>
            </ul>
        </section>

        <section aria-labelledby="rulesTitle" class="bg-white border-[1.5px] border-border-primary rounded-xl p-5 shadow-panel">
            <h2 id="rulesTitle" class="text-base font-extrabold text-unefa-navy mb-3">Reglas de Validación en Tiempo Real</h2>
            <ul class="list-none p-0 m-0 flex flex-col gap-2.5 text-xs text-text-secondary leading-relaxed">
                <li class="flex items-start gap-2.5">
                    <span class="w-2 h-2 rounded-full bg-unefa-green mt-1.5 shrink-0" aria-hidden="true"></span>
                    <span><strong class="text-unefa-navy">Presente:</strong> escaneo validado dentro de los minutos de tolerancia definidos por el docente.</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <span class="w-2 h-2 rounded-full bg-unefa-gold-dark mt-1.5 shrink-0" aria-hidden="true"></span>
                    <span><strong class="text-unefa-navy">Tardanza (LATE):</strong> escaneo posterior a la tolerancia mientras la sesión permanezca abierta.</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <span class="w-2 h-2 rounded-full bg-unefa-blue mt-1.5 shrink-0" aria-hidden="true"></span>
                    <span><strong class="text-unefa-navy">Anti-duplicidad:</strong> un único registro válido por estudiante en cada sesión (<span class="font-mono">409 ASISTENCIA_YA_REGISTRADA</span>).</span>
                </li>
                <li class="flex items-start gap-2.5">
                    <span class="w-2 h-2 rounded-full bg-unefa-red mt-1.5 shrink-0" aria-hidden="true"></span>
                    <span><strong class="text-unefa-navy">Vigencia QR:</strong> token firmado con TTL de 45 segundos y conectividad requerida (Supuesto S-05).</span>
                </li>
            </ul>
        </section>
    </div>
</div>
