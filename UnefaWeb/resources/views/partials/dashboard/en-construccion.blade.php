{{-- Marcador temporal para roles administrativos pendientes de maquetación --}}
<div class="bg-white border-[1.5px] border-border-primary rounded-xl shadow-panel overflow-hidden">
    <div class="h-1 w-full bg-unefa-gold" aria-hidden="true"></div>
    <div class="p-6 flex flex-col gap-3">
        <span class="inline-flex self-start items-center px-2.5 py-0.5 rounded bg-bg-tertiary text-unefa-blue text-xs font-extrabold uppercase tracking-wider">
            {{ $rolMeta['insigniaRol'] ?? 'ROL INSTITUCIONAL' }}
        </span>
        <h1 class="text-2xl font-black text-unefa-navy">
            Módulo {{ $rolMeta['tituloRol'] ?? 'Institucional' }} en preparación
        </h1>
        <p class="text-sm text-text-muted leading-relaxed">
            El panel principal y las secciones operativas de este rol se integrarán progresivamente sobre este portal unificado, manteniendo los controles de sesión e inactividad (RF-05).
        </p>
    </div>
</div>
