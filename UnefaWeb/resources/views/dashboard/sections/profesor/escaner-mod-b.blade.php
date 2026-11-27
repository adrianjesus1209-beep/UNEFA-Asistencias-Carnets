{{-- Seccion Escáner de Carnets Estudiantiles (Modalidad B) --}}
@php
    $escaneosModB = [
        ['nombre' => 'Luis Fernando Morales Peña', 'detalle' => 'V-27.890.341 · 08:50:12 AM', 'estado' => 'PRESENTE'],
        ['nombre' => 'Sofía Gabriela León Pérez', 'detalle' => 'V-29.552.109 · 08:48:33 AM', 'estado' => 'PRESENTE'],
        ['nombre' => 'Andrés José Briceño', 'detalle' => 'V-28.104.332 · 08:47:19 AM', 'estado' => 'PRESENTE'],
    ];
@endphp

<div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <h1 class="text-2xl sm:text-[1.75rem] font-black tracking-tight text-unefa-navy">Escáner de Carnets Estudiantiles (Modalidad B)</h1>
        <p class="text-sm text-text-muted mt-1">Escanee el código QR dinámico del carnet digital del estudiante sobre una sesión abierta (<span class="font-mono">POST /api/attendance/scan/modality-b</span>).</p>
    </div>
    <a href="{{ route('dashboard', ['rol' => $rol, 'seccion' => 'sesion-activa']) }}" class="inline-flex items-center justify-center min-h-[2.75rem] px-4 py-2 rounded-lg bg-white border-[1.5px] border-unefa-navy text-unefa-navy text-xs font-extrabold hover:bg-unefa-navy hover:text-white no-underline self-start md:self-auto">
        ← Volver a Sesión Activa (Mod. A)
    </a>
</div>

{{-- Selector de Sesion Abierta --}}
<section aria-label="Sesión destino de escaneo" class="bg-white border-[1.5px] border-border-primary rounded-xl p-4 shadow-panel flex flex-wrap items-center justify-between gap-4">
    <div class="flex flex-wrap items-center gap-3">
        <label for="activeSessionSelect" class="text-xs font-extrabold uppercase tracking-wider text-text-muted">Sesión Abierta Destino:</label>
        <select id="activeSessionSelect" class="h-10 px-3 rounded-lg bg-surface-input border border-border-primary text-xs font-extrabold text-unefa-navy">
            <option value="open-1">ING-SIS-601 · Ingeniería de Software (01S-2610-D1) — ABIERTA</option>
        </select>
    </div>
    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#d1fae5] text-[#065f46] text-xs font-extrabold">
        ● Tolerancia activa: 15 min · Aula B-204
    </span>
</section>

{{-- Layout 2 Columnas --}}
<div class="grid grid-cols-1 lg:grid-cols-[7.5fr_4.5fr] gap-6 items-start">
    {{-- Columna Principal: Visor de Camara y Diagnostico --}}
    <section aria-labelledby="scannerModBTitle" class="bg-white border-[1.5px] border-border-primary rounded-xl shadow-panel overflow-hidden">
        <div class="px-5 py-3.5 border-b border-border-primary bg-bg-secondary flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2.5">
                <h2 id="scannerModBTitle" class="sr-only">Visor de cámara para escanear carnet estudiantil</h2>
                <select aria-label="Seleccionar cámara" class="h-10 px-3 rounded-lg bg-white border border-border-primary text-xs font-bold text-unefa-navy">
                    <option>Cámara: Webcam HD Integrada</option>
                    <option>Cámara: Lector USB Escritorio</option>
                </select>
                <button type="button" id="btnToggleDocCam" class="h-10 px-3.5 rounded-lg bg-unefa-navy-soft text-white text-xs font-bold hover:bg-unefa-blue cursor-pointer">
                    Activar Cámara Real
                </button>
            </div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#d1fae5] text-[#065f46] text-xs font-extrabold">
                ● Lectura Modalidad B Lista
            </span>
        </div>

        <div class="p-5">
            <div class="relative w-full aspect-[16/10] bg-[#0b1322] rounded-xl overflow-hidden flex items-center justify-center border-2 border-unefa-navy">
                <video id="docWebcamVideo" class="hidden absolute inset-0 w-full h-full object-cover" autoplay playsinline muted></video>
                <div id="docSimViewfinder" class="absolute inset-0 bg-[#142033] flex items-center justify-center">
                    <div class="bg-white rounded-lg p-3.5 shadow-xl border-2 border-unefa-navy flex items-center gap-3">
                        <div class="text-left">
                            <span class="block text-[0.6rem] font-black uppercase text-unefa-blue">Carnet Digital UNEFA</span>
                            <span class="block text-xs font-extrabold text-unefa-navy mt-0.5">Luis F. Morales</span>
                            <span class="block text-[0.65rem] font-mono text-text-muted">V-27.890.341</span>
                        </div>
                        @include('partials.dashboard.qr-svg', ['tamano' => 92])
                    </div>
                </div>

                <div class="absolute top-4 left-4 right-4 flex items-center justify-between pointer-events-none">
                    <span class="px-2.5 py-1 rounded bg-unefa-red text-white text-[0.7rem] font-black uppercase">● LIVE · MOD B</span>
                    <span class="px-3 py-1 rounded bg-unefa-navy/90 text-white text-xs font-bold border border-white/15">
                        Enfoque el QR dinámico del carnet (TTL 90s)
                    </span>
                </div>

                <div class="relative z-10 w-56 h-56 pointer-events-none" aria-hidden="true">
                    <span class="absolute top-0 left-0 w-9 h-9 border-t-4 border-l-4 border-unefa-gold"></span>
                    <span class="absolute top-0 right-0 w-9 h-9 border-t-4 border-r-4 border-unefa-gold"></span>
                    <span class="absolute bottom-0 left-0 w-9 h-9 border-b-4 border-l-4 border-unefa-gold"></span>
                    <span class="absolute bottom-0 right-0 w-9 h-9 border-b-4 border-r-4 border-unefa-gold"></span>
                </div>
            </div>

            {{-- Tarjeta de Resultado --}}
            <div id="modBResultCard" class="mt-4 p-4 rounded-xl border-2 border-unefa-green bg-[#d1fae5]/35 flex items-start gap-3.5" role="status" aria-live="polite">
                <div id="modBResultIcon" class="w-10 h-10 rounded-full bg-unefa-green text-white flex items-center justify-center shrink-0 font-black">✓</div>
                <div class="min-w-0 flex-1">
                    <p id="modBResultHeading" class="text-sm font-black uppercase text-[#065f46]">CARNET VALIDADO · ASISTENCIA PRESENTE</p>
                    <p id="modBResultDetail" class="text-sm font-bold text-unefa-navy mt-0.5">Luis Fernando Morales Peña (V-27.890.341) · Inscrito en 01S-2610-D1</p>
                    <p id="modBResultMeta" class="text-xs font-semibold text-text-muted mt-1">Firma HMAC-SHA256 verificada · Foto APPROVED · 08:50:12 AM</p>
                </div>
            </div>

            {{-- Simulador de Casos de Borde RF-09 --}}
            <div class="mt-4 pt-3 border-t border-border-subtle flex flex-wrap items-center gap-2 text-xs">
                <span class="font-bold text-text-muted">Simular validación RF-09:</span>
                <button type="button" data-sim-b="present" class="px-2.5 py-1 rounded bg-bg-secondary border border-border-primary font-bold text-[#065f46] cursor-pointer">200 Presente</button>
                <button type="button" data-sim-b="late" class="px-2.5 py-1 rounded bg-bg-secondary border border-border-primary font-bold text-unefa-gold-dark cursor-pointer">200 Tardanza</button>
                <button type="button" data-sim-b="invalid_card" class="px-2.5 py-1 rounded bg-bg-secondary border border-border-primary font-bold text-[#93000a] cursor-pointer">422 Carnet Inválido</button>
                <button type="button" data-sim-b="not_enrolled" class="px-2.5 py-1 rounded bg-bg-secondary border border-border-primary font-bold text-[#93000a] cursor-pointer">403 No Inscrito</button>
                <button type="button" data-sim-b="duplicate" class="px-2.5 py-1 rounded bg-bg-secondary border border-border-primary font-bold text-[#93000a] cursor-pointer">409 Duplicado</button>
            </div>
        </div>
    </section>

    {{-- Columna Derecha: Historial Inmediato + Reglas RF-09 --}}
    <div class="flex flex-col gap-6">
        <section aria-labelledby="recentModBTitle" class="bg-white border-[1.5px] border-border-primary rounded-xl shadow-panel overflow-hidden">
            <div class="px-5 py-4 border-b border-border-primary flex items-center justify-between">
                <h2 id="recentModBTitle" class="text-base font-extrabold text-unefa-navy">Escaneos Recientes (Mod. B)</h2>
                <span class="font-mono text-xs font-bold text-unefa-blue" id="modBCount">3 validados</span>
            </div>
            <ul id="modBHistoryList" class="divide-y divide-border-subtle list-none p-0 m-0">
                @foreach($escaneosModB as $item)
                    <li class="p-4 flex items-center justify-between gap-2">
                        <div>
                            <p class="text-xs font-extrabold text-unefa-navy">{{ $item['nombre'] }}</p>
                            <p class="text-[0.7rem] font-mono text-text-muted">{{ $item['detalle'] }}</p>
                        </div>
                        <span class="px-2 py-0.5 rounded bg-[#d1fae5] text-[#065f46] text-[0.68rem] font-extrabold">{{ $item['estado'] }}</span>
                    </li>
                @endforeach
            </ul>
        </section>

        <section aria-labelledby="rulesModBTitle" class="bg-white border-[1.5px] border-border-primary rounded-xl p-5 shadow-panel">
            <h2 id="rulesModBTitle" class="text-base font-extrabold text-unefa-navy mb-3">Controles de Integridad (RF-09)</h2>
            <ul class="list-none p-0 m-0 flex flex-col gap-2.5 text-xs text-text-secondary leading-relaxed">
                <li class="flex items-start gap-2.5"><span class="w-2 h-2 rounded-full bg-unefa-green mt-1.5 shrink-0" aria-hidden="true"></span><span>Verifica firma criptográfica <span class="font-mono">HMAC-SHA256</span> y vigencia del carnet (TTL 90 s en pantalla o vigencia anual en PDF impreso).</span></li>
                <li class="flex items-start gap-2.5"><span class="w-2 h-2 rounded-full bg-unefa-red mt-1.5 shrink-0" aria-hidden="true"></span><span>Rechaza con <span class="font-mono font-bold">422 CARNET_ESTUDIANTIL_INVALIDO</span> si el carnet está revocado, sin foto <span class="font-mono">APPROVED</span> o pertenece a otro rol.</span></li>
                <li class="flex items-start gap-2.5"><span class="w-2 h-2 rounded-full bg-unefa-blue mt-1.5 shrink-0" aria-hidden="true"></span><span>Valida inscripción activa en la sección seleccionada (<span class="font-mono">403 ESTUDIANTE_NO_INSCRITO</span>).</span></li>
            </ul>
        </section>
    </div>
</div>
