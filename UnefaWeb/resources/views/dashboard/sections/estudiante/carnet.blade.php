{{-- Seccion Mi Carnet Digital QR --}}
<div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <h1 class="text-2xl sm:text-[1.75rem] font-black tracking-tight text-unefa-navy">Mi Carnet Digital Institucional</h1>
        <p class="text-sm text-text-muted mt-1">Acreditación oficial con código QR dinámico firmado (<span class="font-mono">HMAC-SHA256</span>) y exportación PDF CR80.</p>
    </div>
    <div class="flex flex-wrap items-center gap-3">
        <a
            href="{{ route('dashboard', ['rol' => $rol, 'seccion' => 'carnet-foto']) }}"
            class="inline-flex items-center justify-center gap-2 min-h-[2.75rem] px-4 py-2 rounded-lg bg-white border-[1.5px] border-unefa-navy text-unefa-navy text-sm font-extrabold hover:bg-unefa-navy hover:text-white transition-colors no-underline"
        >
            @include('partials.icon', ['name' => 'camera', 'clase' => 'w-4 h-4'])
            <span>Actualizar Fotografía (3:4)</span>
        </a>
        <button
            type="button"
            id="btnDownloadCardPdf"
            command="show-modal"
            commandfor="pdfDownloadDialog"
            class="inline-flex items-center justify-center gap-2 min-h-[2.75rem] px-5 py-2 rounded-lg bg-unefa-gold text-unefa-navy border-[1.5px] border-unefa-gold-dark text-sm font-extrabold shadow-sm hover:bg-unefa-gold-light transition-colors cursor-pointer"
        >
            @include('partials.icon', ['name' => 'download', 'clase' => 'w-4 h-4'])
            <span>Descargar Carnet PDF (300 DPI)</span>
        </button>
    </div>
</div>

{{-- Contenido Principal 2 Columnas --}}
<div class="grid grid-cols-1 lg:grid-cols-[7fr_5fr] gap-6 items-start">
    {{-- Columna Izquierda: Visualizador de Credencial CR80 (Anverso / Reverso) --}}
    <section aria-label="Plantilla oficial del carnet digital" class="bg-white border-[1.5px] border-border-primary rounded-xl shadow-panel overflow-hidden">
        <div role="tablist" aria-label="Lado del carnet" id="cardSideTablist" class="grid grid-cols-2 bg-bg-tertiary border-b border-border-primary">
            <button
                type="button"
                id="tabAnverso"
                role="tab"
                aria-selected="true"
                tabindex="0"
                class="tab-btn py-3.5 px-4 text-sm font-extrabold text-text-muted cursor-pointer border-r border-border-primary"
            >
                Anverso (Frente)
            </button>
            <button
                type="button"
                id="tabReverso"
                role="tab"
                aria-selected="false"
                tabindex="-1"
                class="tab-btn py-3.5 px-4 text-sm font-extrabold text-text-muted cursor-pointer"
            >
                Reverso (Validez Institucional)
            </button>
        </div>

        <div class="p-6 sm:p-8 bg-bg-secondary/60 flex items-center justify-center">
            {{-- ANVERSO --}}
            <div id="panelAnverso" role="tabpanel" aria-labelledby="tabAnverso" class="w-full flex justify-center">
                @include('partials.dashboard.carnet-card', [
                    'modo' => 'anverso',
                    'estudiante' => $estudiante,
                ])
            </div>

            {{-- REVERSO --}}
            <div id="panelReverso" role="tabpanel" aria-labelledby="tabReverso" hidden class="w-full flex justify-center">
                <div class="w-full max-w-[34rem] bg-white border-2 border-unefa-navy rounded-xl overflow-hidden shadow-md">
                    <div class="bg-unefa-navy text-white px-5 py-3 border-b-4 border-unefa-gold flex items-center justify-between">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-unefa-gold">Condiciones de Uso y Verificación</span>
                        <span class="font-mono text-xs text-[#d8e3fb]">{{ $estudiante['serial'] ?? 'UNEFA-2026-EST-008492' }}</span>
                    </div>
                    <div class="p-6 flex flex-col gap-4 text-xs text-text-secondary leading-relaxed">
                        <p class="font-semibold text-unefa-navy">
                            Este carnet es personal e intransferible y acredita al titular como estudiante activo de la Universidad Nacional Experimental Politécnica de la Fuerza Armada Nacional Bolivariana (UNEFA).
                        </p>
                        <ul class="list-disc pl-5 space-y-1.5">
                            <li>El código QR impreso en la versión PDF porta un identificador firmado vigente hasta el <strong>{{ $estudiante['vigencia'] ?? '31/12/2026' }}</strong> (Supuesto S-03).</li>
                            <li>En caso de pérdida o revocación, notifique de inmediato a la Coordinación Académica del {{ $estudiante['nucleo'] ?? 'Núcleo Carabobo' }}.</li>
                            <li>El uso indebido de esta credencial será sancionado conforme al reglamento disciplinario institucional.</li>
                        </ul>
                        <div class="pt-4 mt-2 border-t border-border-primary flex items-end justify-between gap-4">
                            <div>
                                <div class="w-40 border-b border-unefa-navy mb-1"></div>
                                <span class="text-[0.68rem] font-bold uppercase text-text-muted">Vicerrectorado Académico</span>
                            </div>
                            <div class="text-right font-mono text-[0.68rem] text-text-muted">
                                Emitido: 14/11/2026<br>SIA-UNEFA V2.0
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-white border-t border-border-primary flex flex-wrap items-center justify-between gap-2 text-xs text-text-muted">
            <span>Formato físico estándar ISO/IEC 7810 ID-1 (CR80 · 85,6 × 53,98 mm).</span>
            <span class="font-mono font-bold text-unefa-blue">GET /api/id-cards/:cardId/pdf</span>
        </div>
    </section>

    {{-- Columna Derecha: QR Dinamico Modalidad B + Estado Fotografico --}}
    <div class="flex flex-col gap-6">
        <section aria-labelledby="qrDynamicTitle" class="bg-white border-[1.5px] border-border-primary rounded-xl p-5 sm:p-6 shadow-panel">
            <div class="flex items-start justify-between gap-3 mb-4">
                <div>
                    <h2 id="qrDynamicTitle" class="text-base font-extrabold text-unefa-navy">Código QR Dinámico (Modalidad B)</h2>
                    <p class="text-xs text-text-muted mt-0.5">Muestre este código al docente para pase de lista en aula.</p>
                </div>
                <span id="qrStatusPill" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-[#d1fae5] text-[#065f46] text-[0.7rem] font-extrabold shrink-0">
                    ● HMAC-SHA256
                </span>
            </div>

            <div class="flex flex-col items-center py-4 px-4 rounded-lg bg-bg-secondary border border-border-primary">
                <div id="dynamicQrContainer" class="p-2 bg-white rounded-lg border-2 border-unefa-navy">
                    @include('partials.dashboard.qr-svg', ['id' => 'cardDynamicQrSvg', 'tamano' => 192])
                </div>

                <div class="w-full mt-4">
                    <div class="flex items-center justify-between text-xs font-bold mb-1.5">
                        <span class="text-unefa-navy">Rotación automática en <span id="cardQrSeconds" class="font-mono">60s</span></span>
                        <span class="text-text-muted font-mono">TTL: 90s</span>
                    </div>
                    <div class="w-full h-2 bg-bg-tertiary rounded-full overflow-hidden">
                        <div id="cardQrProgress" class="h-full bg-unefa-gold transition-all duration-1000" style="width: 100%;"></div>
                    </div>
                    <div class="mt-3 flex items-center justify-between gap-2 text-[0.72rem] text-text-muted font-mono">
                        <span id="qrTokenId">Token: hmac-2026-0928-008492</span>
                        <button type="button" id="btnRotateQrNow" class="font-sans font-bold text-unefa-blue hover:underline cursor-pointer bg-transparent border-0">
                            Renovar ahora
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <section aria-labelledby="photoValidationTitle" class="bg-white border-[1.5px] border-border-primary rounded-xl p-5 sm:p-6 shadow-panel">
            <h2 id="photoValidationTitle" class="text-base font-extrabold text-unefa-navy mb-4">Estado de Validación Fotográfica</h2>

            <ol class="grid grid-cols-3 gap-2 list-none p-0 m-0 text-center">
                <li class="p-3 rounded-lg bg-[#d1fae5]/40 border border-unefa-green">
                    <span class="w-7 h-7 rounded-full bg-unefa-green text-white font-extrabold text-xs flex items-center justify-center mx-auto mb-1.5">✓</span>
                    <span class="block text-xs font-extrabold text-unefa-navy">Foto Cargada</span>
                    <span class="block text-[0.68rem] text-text-muted mt-0.5">3:4 · 840×1120</span>
                </li>
                <li class="p-3 rounded-lg bg-[#d1fae5]/40 border border-unefa-green">
                    <span class="w-7 h-7 rounded-full bg-unefa-green text-white font-extrabold text-xs flex items-center justify-center mx-auto mb-1.5">✓</span>
                    <span class="block text-xs font-extrabold text-unefa-navy">Revisión Coord.</span>
                    <span class="block text-[0.68rem] text-text-muted mt-0.5">Validada</span>
                </li>
                <li class="p-3 rounded-lg bg-[#d1fae5]/40 border border-unefa-green">
                    <span class="w-7 h-7 rounded-full bg-unefa-green text-white font-extrabold text-xs flex items-center justify-center mx-auto mb-1.5">✓</span>
                    <span class="block text-xs font-extrabold text-unefa-navy">Carnet Aprobado</span>
                    <span class="block text-[0.68rem] text-text-muted mt-0.5">14 Nov 2026</span>
                </li>
            </ol>

            <div class="mt-4 p-3.5 rounded-lg bg-surface-input border border-unefa-blue/25 text-xs text-text-secondary leading-relaxed">
                <strong class="text-unefa-blue">Política institucional (S-02):</strong> La descarga del carnet en PDF de 300 DPI y el escaneo por docente en Modalidad B solo están habilitados con fotografía en estado <span class="font-mono font-bold">APPROVED</span>.
            </div>
        </section>
    </div>
</div>

{{-- Modal Descarga PDF --}}
<dialog id="pdfDownloadDialog" closedby="any" aria-labelledby="pdfDialogTitle" class="m-auto w-[min(92vw,28rem)] rounded-xl border-2 border-border-primary bg-white p-6 text-text-primary shadow-2xl">
    <h1 id="pdfDialogTitle" class="text-lg font-extrabold text-unefa-navy">Carnet Digital PDF (300 DPI)</h1>
    <p class="mt-2 text-sm text-text-muted leading-relaxed">
        Archivo generado en formato <strong>CR80 (anverso y reverso)</strong> listo para impresión institucional con código QR firmado vigente hasta el <strong>31/12/2026</strong>.
    </p>
    <div class="mt-4 p-3 rounded-md bg-bg-secondary border border-border-primary font-mono text-xs text-unefa-navy">
        carnet_unefa_V28450123_300dpi.pdf · 412 KB
    </div>
    <form method="dialog" class="mt-6 flex justify-end gap-3">
        <button type="submit" id="closePdfDialog" autofocus class="min-h-[2.75rem] px-4 py-2 rounded-lg bg-unefa-navy-soft text-white text-sm font-bold cursor-pointer hover:bg-unefa-blue">
            Aceptar
        </button>
    </form>
</dialog>
