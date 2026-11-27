{{-- Plantilla oficial del Carnet Digital UNEFA (modos: compacto, anverso, preview-foto). --}}
@php
    $modo = $modo ?? 'compacto';
    $avatarSvg = "data:image/svg+xml;utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 180 240'%3E%3Crect width='180' height='240' fill='%23e9eef6'/%3E%3Ccircle cx='90' cy='86' r='36' fill='%230b2545'/%3E%3Cpath d='M28 240 C34 176 58 148 90 148 C122 148 146 176 152 240 Z' fill='%23002855'/%3E%3Cpath d='M74 149 L90 184 L106 149 Z' fill='%23ffffff'/%3E%3Cpath d='M86 160 L90 198 L94 160 Z' fill='%23f2b807'/%3E%3C/svg%3E";
    $logoFallback = "data:image/svg+xml;utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Ccircle cx='32' cy='32' r='30' fill='%23002855' stroke='%23f2b807' stroke-width='3'/%3E%3Cpath d='M32 10 L48 18 V34 C48 44 41 51 32 55 C23 51 16 44 16 34 V18 Z' fill='%2306152a' stroke='%23f2b807' stroke-width='2'/%3E%3Ctext x='32' y='37' text-anchor='middle' font-family='sans-serif' font-size='11' font-weight='900' fill='%23f2b807'%3EUNEFA%3C/text%3E%3C/svg%3E";
    $nombre = $estudiante['nombreCompleto'] ?? 'Carlos Eduardo González Márquez';
    $nombreCorto = $estudiante['nombreCorto'] ?? 'Carlos E. González M.';
    $cedula = $estudiante['cedula'] ?? 'V-28.450.123';
    $carrera = $estudiante['carrera'] ?? 'Ingeniería de Sistemas';
    $carreraCodigo = $estudiante['carreraCodigo'] ?? 'ING-SIS-10';
    $nucleo = $estudiante['nucleo'] ?? 'Núcleo Carabobo';
    $serial = $estudiante['serial'] ?? 'UNEFA-2026-EST-008492';
    $vigencia = $estudiante['vigencia'] ?? '31/12/2026';
@endphp

@if($modo === 'anverso')
    <div class="w-full max-w-[34rem] bg-white border-2 border-unefa-navy rounded-xl overflow-hidden shadow-md">
        <div class="bg-unefa-navy text-white px-5 py-4 border-b-4 border-unefa-gold flex items-center gap-3.5">
            <div class="w-11 h-11 rounded-full bg-white p-0.5 border-2 border-unefa-gold shrink-0">
                <img
                    src="{{ asset('img/unefa-logo.webp') }}"
                    onerror="this.onerror=null;this.src='{{ $logoFallback }}'"
                    alt="Escudo UNEFA"
                    class="w-full h-full object-contain rounded-full"
                >
            </div>
            <div class="leading-tight">
                <p class="text-[0.7rem] font-extrabold tracking-[0.08em] uppercase text-unefa-gold">República Bolivariana de Venezuela · UNEFA</p>
                <p class="text-xs font-bold text-[#d8e3fb] mt-0.5">Universidad Nacional Experimental Politécnica de la FANB</p>
            </div>
        </div>

        <div class="px-5 py-2 bg-bg-tertiary border-b border-border-primary text-center">
            <span class="text-xs font-black tracking-[0.14em] uppercase text-unefa-blue">Carnet Estudiantil · Pregrado</span>
        </div>

        <div class="p-5 sm:p-6 grid grid-cols-1 sm:grid-cols-[132px_1fr] gap-5 items-center">
            <div class="mx-auto sm:mx-0">
                <img
                    src="{{ $avatarSvg }}"
                    alt="Fotografía aprobada de {{ $nombre }}"
                    width="132"
                    height="176"
                    class="w-[132px] h-[176px] object-cover rounded-lg border-2 border-border-primary bg-bg-secondary"
                >
            </div>

            <div class="flex flex-col gap-2">
                <h2 class="text-lg font-black text-unefa-navy leading-snug uppercase">{{ $nombre }}</h2>
                <dl class="grid grid-cols-1 gap-1.5 text-sm">
                    <div class="flex gap-2">
                        <dt class="font-bold text-text-muted">C.I.:</dt>
                        <dd class="font-mono font-extrabold text-unefa-navy">{{ $cedula }}</dd>
                    </div>
                    <div class="flex gap-2">
                        <dt class="font-bold text-text-muted">Carrera:</dt>
                        <dd class="font-bold text-unefa-blue">{{ $carrera }} ({{ $carreraCodigo }})</dd>
                    </div>
                    <div class="flex gap-2">
                        <dt class="font-bold text-text-muted">Núcleo:</dt>
                        <dd class="font-semibold text-text-secondary">{{ $nucleo }}</dd>
                    </div>
                    <div class="flex gap-2">
                        <dt class="font-bold text-text-muted">Serial:</dt>
                        <dd class="font-mono text-xs font-bold text-unefa-navy">{{ $serial }}</dd>
                    </div>
                    <div class="flex gap-2">
                        <dt class="font-bold text-text-muted">Vigencia:</dt>
                        <dd class="font-mono text-xs font-bold text-text-secondary">{{ $vigencia }}</dd>
                    </div>
                </dl>

                <div class="pt-2 flex items-center justify-between gap-2">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-[#d1fae5] text-[#065f46] border border-unefa-green text-[0.72rem] font-extrabold uppercase tracking-wider">
                        ✓ Vigente · Aprobado
                    </span>
                    <span class="text-[0.68rem] font-mono text-text-muted">CR80 · 300 DPI</span>
                </div>
            </div>
        </div>
    </div>
@elseif($modo === 'preview-foto')
    <div class="border border-unefa-navy rounded-lg overflow-hidden bg-white">
        <div class="bg-unefa-navy text-white px-3.5 py-2 border-b-2 border-unefa-gold text-[0.65rem] font-extrabold uppercase tracking-wider">
            República Bolivariana de Venezuela · UNEFA
        </div>
        <div class="p-3.5 flex items-center gap-3.5">
            <div class="w-16 h-[85px] rounded border border-border-primary overflow-hidden bg-bg-tertiary shrink-0">
                <img
                    id="{{ $fotoImgId ?? 'previewCardPhoto' }}"
                    src="{{ $avatarSvg }}"
                    alt="Vista previa en carnet"
                    class="w-full h-full object-cover"
                    style="transform: scale(1.15) rotate(0deg);"
                >
            </div>
            <div class="min-w-0 text-xs">
                <p class="font-black text-unefa-navy uppercase truncate">{{ $nombreCorto }}</p>
                <p class="font-mono font-bold text-text-secondary mt-0.5">C.I.: {{ $cedula }}</p>
                <p class="text-unefa-blue font-bold truncate mt-0.5">Ing. de Sistemas ({{ $carreraCodigo }})</p>
                <span class="inline-block mt-1.5 px-2 py-0.5 rounded bg-bg-tertiary text-unefa-navy font-mono text-[0.65rem] font-bold">VISTA PREVIA DE CARNET</span>
            </div>
        </div>
    </div>
@else
    <div class="border-[1.5px] border-border-primary rounded-lg overflow-hidden bg-white">
        <div class="bg-unefa-navy text-white px-3.5 py-2 border-b-2 border-unefa-gold flex items-center justify-between">
            <span class="text-[0.65rem] font-extrabold tracking-wider uppercase">República Bolivariana de Venezuela · UNEFA</span>
        </div>
        <div class="p-3.5 flex items-center justify-between gap-3">
            <div class="flex items-center gap-3 min-w-0">
                <img src="{{ $avatarSvg }}" alt="Foto carnet" width="54" height="72" class="w-13 h-17 rounded object-cover border border-border-primary shrink-0">
                <div class="min-w-0">
                    <p class="text-sm font-extrabold text-unefa-navy truncate">{{ $nombreCorto }}</p>
                    <p class="text-xs font-mono font-bold text-text-secondary mt-0.5">C.I. {{ $cedula }}</p>
                    <p class="text-xs text-text-muted truncate">Ing. de Sistemas</p>
                    <p class="text-[0.68rem] font-mono text-unefa-blue mt-1">{{ $serial }}</p>
                </div>
            </div>
            <div class="shrink-0">
                @include('partials.dashboard.qr-svg', ['id' => $qrId ?? 'dashMiniQr', 'tamano' => 68])
            </div>
        </div>
    </div>
@endif
