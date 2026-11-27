{{-- Seccion Actualizar Fotografia 3:4 --}}
@php
    $avatarSvg = "data:image/svg+xml;utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 180 240'%3E%3Crect width='180' height='240' fill='%23e9eef6'/%3E%3Ccircle cx='90' cy='86' r='36' fill='%230b2545'/%3E%3Cpath d='M28 240 C34 176 58 148 90 148 C122 148 146 176 152 240 Z' fill='%23002855'/%3E%3Cpath d='M74 149 L90 184 L106 149 Z' fill='%23ffffff'/%3E%3Cpath d='M86 160 L90 198 L94 160 Z' fill='%23f2b807'/%3E%3C/svg%3E";
@endphp

@include('partials.dashboard.page-header', [
    'titulo' => 'Carga y Recorte de Fotografía Institucional',
    'descripcionHtml' => 'Ajuste su fotografía en proporción obligatoria <strong>3:4</strong> (mín. 600×800 px, formato JPEG o PNG hasta 5 MB).',
])

{{-- Alerta de Validacion Dinamica --}}
<div id="photoAlertBox" class="hidden px-4 py-3 rounded-lg text-sm font-semibold border border-unefa-red bg-[#ffdad6] text-[#93000a]" role="alert"></div>

{{-- Estudio de Recorte 2 Columnas --}}
<div class="grid grid-cols-1 lg:grid-cols-[7fr_5fr] gap-6 items-start">
    {{-- Columna Izquierda: Editor Interactivo 3:4 --}}
    <section aria-labelledby="editorTitle" class="bg-white border-[1.5px] border-border-primary rounded-xl shadow-panel overflow-hidden">
        <div class="px-5 py-4 border-b border-border-primary flex items-center justify-between gap-3">
            <h2 id="editorTitle" class="text-base font-extrabold text-unefa-navy">Editor de Recorte (3:4)</h2>
            <label
                for="photoFileInput"
                class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg bg-surface-input border border-border-primary text-xs font-extrabold text-unefa-navy hover:bg-bg-tertiary cursor-pointer transition-colors"
            >
                @include('partials.icon', ['name' => 'upload', 'clase' => 'w-[15px] h-[15px]'])
                <span>Seleccionar Imagen</span>
                <input id="photoFileInput" type="file" accept="image/jpeg,image/png" class="sr-only" />
            </label>
        </div>

        <div class="p-5 sm:p-6">
            {{-- Lienzo Oscurecido con Marco Dorado 3:4 --}}
            <div class="relative w-full h-[24rem] bg-[#1e293b] rounded-lg overflow-hidden flex items-center justify-center select-none border border-border-grid">
                <div class="relative w-[225px] h-[300px] border-[3px] border-unefa-gold overflow-hidden bg-bg-tertiary shadow-[0_0_0_9999px_rgba(6,21,42,0.58)]">
                    <img
                        id="cropImageEl"
                        src="{{ $avatarSvg }}"
                        alt="Fotografía en edición para el carnet"
                        class="w-full h-full object-cover transition-transform duration-150"
                        style="transform: scale(1.15) rotate(0deg);"
                    />
                    <div class="pointer-events-none absolute inset-0 grid grid-cols-3 grid-rows-3" aria-hidden="true">
                        <div class="border-r border-b border-white/30"></div>
                        <div class="border-r border-b border-white/30"></div>
                        <div class="border-b border-white/30"></div>
                        <div class="border-r border-b border-white/30"></div>
                        <div class="border-r border-b border-white/30"></div>
                        <div class="border-b border-white/30"></div>
                        <div class="border-r border-white/30"></div>
                        <div class="border-r border-white/30"></div>
                        <div></div>
                    </div>
                </div>
            </div>

            {{-- Controles de Zoom y Rotacion --}}
            <div class="mt-5 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-3 flex-1 min-w-[14rem]">
                    <label for="zoomRange" class="text-xs font-extrabold uppercase tracking-wider text-text-muted whitespace-nowrap">
                        Zoom: <span id="zoomValue" class="font-mono text-unefa-navy">115%</span>
                    </label>
                    <input id="zoomRange" type="range" min="100" max="200" value="115" class="flex-1 accent-unefa-blue cursor-pointer" />
                </div>

                <div class="flex items-center gap-2">
                    <button
                        type="button"
                        id="btnRotatePhoto"
                        class="min-h-[2.5rem] px-3.5 py-1.5 rounded-lg bg-white border border-border-primary text-xs font-extrabold text-unefa-navy hover:bg-bg-secondary cursor-pointer"
                    >
                        ↻ Rotar 90°
                    </button>
                    <button
                        type="button"
                        id="btnResetCrop"
                        class="min-h-[2.5rem] px-3.5 py-1.5 rounded-lg bg-white border border-border-primary text-xs font-extrabold text-text-muted hover:text-unefa-navy cursor-pointer"
                    >
                        Restablecer
                    </button>
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-border-subtle flex flex-wrap items-center justify-between gap-2">
                <span id="photoMetaPill" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-[#d1fae5] text-[#065f46] text-xs font-mono font-bold">
                    ✓ 840 × 1120 px · JPEG · 1,8 MB · Formato válido
                </span>
                <span class="text-xs text-text-muted font-mono">Relación bloqueada 3:4</span>
            </div>
        </div>
    </section>

    {{-- Columna Derecha: Preview en Plantilla + Checklist + Aviso --}}
    <div class="flex flex-col gap-5">
        <section aria-labelledby="miniPreviewTitle" class="bg-white border-[1.5px] border-border-primary rounded-xl p-5 shadow-panel">
            <h2 id="miniPreviewTitle" class="text-sm font-extrabold text-unefa-navy mb-3">Vista Previa en Plantilla Oficial</h2>
            @include('partials.dashboard.carnet-card', [
                'modo' => 'preview-foto',
                'estudiante' => $estudiante,
                'fotoImgId' => 'previewCardPhoto',
            ])
        </section>

        <section aria-labelledby="reqsTitle" class="bg-white border-[1.5px] border-border-primary rounded-xl p-5 shadow-panel">
            <h2 id="reqsTitle" class="text-sm font-extrabold text-unefa-navy mb-3">Requisitos Obligatorios de Fotografía</h2>
            <ul class="list-none p-0 m-0 flex flex-col gap-2.5 text-sm text-text-secondary">
                <li class="flex items-center gap-2.5"><span class="text-unefa-green font-black">✓</span> Proporción exacta 3:4 (mínimo 600 × 800 px)</li>
                <li class="flex items-center gap-2.5"><span class="text-unefa-green font-black">✓</span> Fondo claro, liso y con iluminación uniforme</li>
                <li class="flex items-center gap-2.5"><span class="text-unefa-green font-black">✓</span> Rostro de frente sin gorra ni lentes oscuros</li>
                <li class="flex items-center gap-2.5"><span class="text-unefa-green font-black">✓</span> Archivo JPEG o PNG de hasta 5 MB</li>
            </ul>
        </section>

        <div class="p-4 rounded-xl bg-unefa-gold/12 border-[1.5px] border-unefa-gold-dark text-xs text-unefa-navy leading-relaxed">
            <p class="font-extrabold uppercase tracking-wider mb-1">⚠ Estado al enviar: PENDIENTE DE REVISIÓN</p>
            <p>
                Mientras Coordinación valida la nueva fotografía (<span class="font-mono font-bold">PENDING</span>), la descarga del PDF oficial y el escaneo en Modalidad B permanecerán pausados hasta su aprobación.
            </p>
        </div>

        <div class="flex items-center justify-end gap-3 pt-1">
            <a
                href="{{ route('dashboard', ['rol' => $rol, 'seccion' => 'carnet']) }}"
                class="inline-flex items-center justify-center min-h-[2.85rem] px-5 py-2.5 rounded-lg bg-white border-[1.5px] border-border-primary text-unefa-navy text-sm font-extrabold hover:bg-bg-secondary no-underline"
            >
                Cancelar
            </a>
            <button
                type="button"
                id="btnSubmitPhoto"
                command="show-modal"
                commandfor="photoSubmittedDialog"
                class="inline-flex items-center justify-center gap-2 min-h-[2.85rem] px-5 py-2.5 rounded-lg bg-unefa-gold text-unefa-navy border-[1.5px] border-unefa-gold-dark text-sm font-extrabold shadow-sm hover:bg-unefa-gold-light cursor-pointer"
            >
                <span>Enviar Fotografía a Revisión</span>
            </button>
        </div>
    </div>
</div>

{{-- Dialogo Confirmacion Envio --}}
<dialog id="photoSubmittedDialog" closedby="any" aria-labelledby="photoSubTitle" class="m-auto w-[min(92vw,28rem)] rounded-xl border-2 border-unefa-green bg-white p-6 text-text-primary shadow-2xl">
    <span class="inline-block px-2.5 py-0.5 rounded bg-unefa-gold/25 text-unefa-navy text-xs font-extrabold uppercase mb-2">Estado: PENDING</span>
    <h1 id="photoSubTitle" class="text-lg font-extrabold text-unefa-navy">Fotografía enviada a Coordinación</h1>
    <p class="mt-2 text-sm text-text-muted leading-relaxed">
        Recibirás una notificación en tiempo real (<span class="font-mono text-xs">carnet.foto_revisada</span>) en cuanto tu nueva fotografía sea aprobada o requiera correcciones.
    </p>
    <div class="mt-6 flex justify-end">
        <a href="{{ route('dashboard', ['rol' => $rol, 'seccion' => 'carnet']) }}" autofocus class="inline-flex items-center justify-center min-h-[2.75rem] px-5 py-2 rounded-lg bg-unefa-navy-soft text-white text-sm font-bold hover:bg-unefa-blue no-underline">
            Volver a Mi Carnet
        </a>
    </div>
</dialog>
