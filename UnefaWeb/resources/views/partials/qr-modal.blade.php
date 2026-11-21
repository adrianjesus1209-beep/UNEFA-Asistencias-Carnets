{{-- Modal de prueba del escaner QR (placeholder hasta integrar el lector real con el backend). --}}
<div id="modal-qr" class="qr-modal fixed inset-0 z-50 flex items-center justify-center bg-[rgba(6,21,42,0.65)] p-6" role="dialog" aria-modal="true" aria-hidden="true" aria-label="Acceso a la cámara">
    <div data-cerrar-qr class="absolute inset-0"></div>
    <div class="relative flex w-full max-w-[360px] flex-col items-center rounded-[22px] bg-white p-6 shadow-2xl">
        <div class="mb-4 flex h-[60px] w-[60px] items-center justify-center rounded-full bg-[rgba(242,184,7,0.16)]">
            @include('partials.icon', ['name' => 'camera', 'clase' => 'h-7 w-7 text-unefa-goldDark'])
        </div>
        <p class="mb-2.5 text-center text-lg font-extrabold text-neutral-950">Acceso a la cámara</p>
        <p class="mb-3 text-center text-sm leading-5 text-slate-600">
            ¿Desea permitir que el portal UNEFA acceda a la cámara del dispositivo para escanear un código QR?
        </p>
        <p class="mb-5 text-center text-xs italic text-unefa-goldDark">
            Esta es una interfaz de prueba: la cámara no se activará.
        </p>
        <div class="flex w-full gap-3">
            <button type="button" data-cerrar-qr class="flex flex-1 items-center justify-center rounded-[14px] border border-slate-300 py-3 text-sm font-bold text-neutral-950 transition hover:bg-slate-50">
                Ahora no
            </button>
            <button type="button" data-cerrar-qr class="flex flex-1 items-center justify-center rounded-[14px] bg-unefa-gold py-3 text-sm font-extrabold text-unefa-navy transition hover:brightness-105">
                Permitir
            </button>
        </div>
    </div>
</div>
