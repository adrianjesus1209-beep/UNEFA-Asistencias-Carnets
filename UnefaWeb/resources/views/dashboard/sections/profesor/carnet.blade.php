{{-- Seccion Mi Carnet Digital Docente --}}
<div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <h1 class="text-2xl sm:text-[1.75rem] font-black tracking-tight text-unefa-navy">Mi Carnet Digital Docente</h1>
        <p class="text-sm text-text-muted mt-1">Credencial oficial de personal académico con QR dinámico firmado (<span class="font-mono">HMAC-SHA256</span>) y exportación CR80 a 300 DPI.</p>
    </div>
    <div class="flex flex-wrap gap-3">
        <button
            type="button"
            id="btnOpenDocPhotoModal"
            command="show-modal"
            commandfor="docPhotoDialog"
            class="min-h-[2.75rem] px-4 py-2 rounded-lg bg-white border-[1.5px] border-unefa-navy text-unefa-navy text-sm font-extrabold hover:bg-unefa-navy hover:text-white cursor-pointer"
        >
            Actualizar Fotografía (3:4)
        </button>
        <button
            type="button"
            id="btnDownloadDocCardPdf"
            command="show-modal"
            commandfor="docPdfDialog"
            class="min-h-[2.75rem] px-5 py-2 rounded-lg bg-unefa-gold text-unefa-navy border-[1.5px] border-unefa-gold-dark text-sm font-extrabold hover:bg-unefa-gold-light cursor-pointer"
        >
            Descargar Carnet PDF (300 DPI)
        </button>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-[7fr_5fr] gap-6 items-start">
    {{-- Plantilla Oficial Carnet Docente --}}
    <section aria-label="Credencial oficial docente" class="bg-white border-[1.5px] border-border-primary rounded-xl shadow-panel overflow-hidden">
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
                Reverso (Validez)
            </button>
        </div>

        <div class="p-6 sm:p-8 bg-bg-secondary/60 flex items-center justify-center">
            <div id="panelAnverso" role="tabpanel" aria-labelledby="tabAnverso" class="w-full flex justify-center">
                @include('partials.dashboard.carnet-card', [
                    'modo' => 'anverso',
                    'titular' => $titular,
                    'franjaContenedorClase' => 'bg-unefa-blue',
                    'franjaTextoClase' => 'text-white',
                    'franjaTexto' => 'Personal Docente · Cátedra Universitaria',
                    'campoPrincipalEtiqueta' => 'Cargo:',
                    'campoPrincipalValor' => $titular['cargo'] ?? 'Docente Titular · Ing. de Sistemas',
                ])
            </div>

            <div id="panelReverso" role="tabpanel" aria-labelledby="tabReverso" hidden class="w-full max-w-[34rem] bg-white border-2 border-unefa-navy rounded-xl overflow-hidden shadow-md">
                <div class="bg-unefa-navy text-white px-5 py-3 border-b-4 border-unefa-gold flex justify-between text-xs font-extrabold">
                    <span class="text-unefa-gold uppercase">Acreditación de Personal Docente</span>
                    <span class="font-mono">{{ $titular['serial'] ?? 'UNEFA-2026-DOC-001248' }}</span>
                </div>
                <div class="p-6 text-xs text-text-secondary leading-relaxed space-y-3">
                    <p class="font-semibold text-unefa-navy">Esta credencial acredita al portador como miembro activo del cuerpo docente de la UNEFA, autorizado para el acceso a recintos académicos, laboratorios y control de asistencia digital.</p>
                    <p>El QR de la edición impresa a 300 DPI mantiene firma institucional vigente hasta el <strong>{{ $titular['vigencia'] ?? '31/12/2026' }}</strong>.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Columna Derecha: QR Dinamico 60s --}}
    <section aria-labelledby="docQrTitle" class="bg-white border-[1.5px] border-border-primary rounded-xl p-5 sm:p-6 shadow-panel">
        <div class="flex items-start justify-between gap-2 mb-4">
            <div>
                <h2 id="docQrTitle" class="text-base font-extrabold text-unefa-navy">Código QR Dinámico de Identificación</h2>
                <p class="text-xs text-text-muted mt-0.5">Rotación automática cada 60 segundos (TTL 90 s)</p>
            </div>
            <span class="px-2.5 py-1 rounded-full bg-[#d1fae5] text-[#065f46] text-[0.7rem] font-extrabold">● HMAC-SHA256</span>
        </div>
        <div class="flex flex-col items-center p-4 rounded-lg bg-bg-secondary border border-border-primary">
            <div class="p-2 bg-white rounded-lg border-2 border-unefa-navy">
                @include('partials.dashboard.qr-svg', ['id' => 'cardDynamicQrSvg', 'tamano' => 186])
            </div>
            <div class="w-full mt-4">
                <div class="flex justify-between text-xs font-bold mb-1.5">
                    <span>Rotación en <span id="cardQrSeconds" class="font-mono">60s</span></span>
                    <span class="font-mono text-text-muted">TTL 90s</span>
                </div>
                <div class="w-full h-2 bg-bg-tertiary rounded-full overflow-hidden">
                    <div id="cardQrProgress" class="h-full bg-unefa-gold transition-all duration-1000" style="width: 100%;"></div>
                </div>
            </div>
        </div>
    </section>
</div>

{{-- Modal Recorte 3:4 --}}
<dialog
    id="docPhotoDialog"
    closedby="any"
    aria-labelledby="docPhotoTitle"
    class="m-auto w-[min(92vw,28rem)] rounded-xl border-2 border-border-primary bg-white p-6 text-text-primary shadow-2xl"
>
    <h1 id="docPhotoTitle" class="text-lg font-extrabold text-unefa-navy">Actualizar Fotografía Docente (3:4)</h1>
    <p class="mt-1 text-xs text-text-muted">Proporción obligatoria 3:4 (mín. 600×800 px, JPEG/PNG hasta 5 MB). Pasará a estado <span class="font-mono font-bold">PENDING</span> para revisión de Coordinación.</p>
    <input
        id="docPhotoFileInput"
        type="file"
        accept="image/jpeg,image/png"
        aria-label="Seleccionar fotografía institucional 3:4"
        class="mt-4 block w-full text-xs file:mr-3 file:py-2 file:px-3 file:rounded-md file:border file:border-border-primary file:bg-surface-input file:font-bold file:text-unefa-navy"
    >
    <div id="docPhotoAlert" class="hidden mt-3 px-3 py-2 rounded-md border border-unefa-red bg-[#ffdad6] text-[#93000a] text-xs font-semibold" role="alert"></div>
    <form method="dialog" class="mt-6 flex justify-end gap-2.5">
        <button type="submit" id="closeDocPhotoDlg" class="min-h-[2.75rem] px-4 py-2 rounded-lg bg-white border border-border-primary text-sm font-bold text-unefa-navy cursor-pointer">Cancelar</button>
        <button type="submit" id="saveDocPhotoDlg" class="min-h-[2.75rem] px-4 py-2 rounded-lg bg-unefa-gold text-unefa-navy border border-unefa-gold-dark text-sm font-extrabold cursor-pointer">Enviar a Revisión</button>
    </form>
</dialog>

{{-- Modal PDF 300 DPI --}}
<dialog
    id="docPdfDialog"
    closedby="any"
    aria-labelledby="docPdfTitle"
    class="m-auto w-[min(92vw,27rem)] rounded-xl border-2 border-border-primary bg-white p-6 text-text-primary shadow-2xl"
>
    <h1 id="docPdfTitle" class="text-lg font-extrabold text-unefa-navy">Carnet Docente PDF (300 DPI)</h1>
    <p class="mt-2 text-sm text-text-muted">Formato CR80 (anverso y reverso) listo para impresión institucional.</p>
    <div class="mt-3 p-3 rounded bg-bg-secondary border border-border-primary font-mono text-xs">carnet_docente_V14230890_300dpi.pdf · 398 KB</div>
    <form method="dialog" class="mt-6 flex justify-end">
        <button type="submit" id="closeDocPdfDlg" autofocus class="min-h-[2.75rem] px-5 py-2 rounded-lg bg-unefa-navy-soft text-white text-sm font-bold cursor-pointer">Aceptar</button>
    </form>
</dialog>
