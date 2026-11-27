{{-- Seccion Seguridad de Cuenta y Control de Sesion Docente --}}
@php
    $actividadAuditada = [
        ['evento' => 'Apertura sesión 01S-2610-D1', 'hora' => 'Hoy 08:45'],
        ['evento' => 'Justificación manual (V-29.408.511)', 'hora' => 'Hoy 08:46'],
        ['evento' => 'Inicio de sesión canal STAFF', 'hora' => 'Hoy 08:41'],
    ];
@endphp

@include('partials.dashboard.page-header', [
    'titulo' => 'Seguridad de Cuenta y Control de Sesión',
    'descripcion' => 'Preguntas de seguridad reglamentarias (RF-04), vigilancia de inactividad (RF-05) y trazabilidad de accesos del canal Personal.',
])

<div class="grid grid-cols-1 lg:grid-cols-[7fr_5fr] gap-6 items-start">
    {{-- Preguntas de Seguridad (RF-04) --}}
    <section aria-labelledby="docSecQTitle" class="bg-white border-[1.5px] border-border-primary rounded-xl p-5 sm:p-6 shadow-panel">
        <div class="pb-4 mb-5 border-b border-border-subtle">
            <h2 id="docSecQTitle" class="text-base font-extrabold text-unefa-navy">Preguntas de Seguridad (RF-04)</h2>
            <p class="text-xs text-text-muted mt-1">Configure al menos 2 preguntas distintas con respuestas entre <strong>4 y 16 caracteres</strong> (normalizadas y encriptadas con Bcrypt).</p>
        </div>

        <div id="docSecAlert" class="hidden mb-4 px-4 py-3 rounded-lg text-xs font-semibold border border-unefa-red bg-[#ffdad6] text-[#93000a]" role="alert"></div>
        <div id="docSecOk" class="hidden mb-4 px-4 py-3 rounded-lg text-xs font-bold border border-unefa-green bg-[#d1fae5] text-[#065f46]" role="status"></div>

        <form id="docSecForm" class="flex flex-col gap-5" novalidate>
            <div class="flex flex-col gap-2">
                <label for="dq1" class="text-xs font-extrabold uppercase text-unefa-navy">Pregunta de Seguridad 1 *</label>
                <select id="dq1" class="h-11 px-3 rounded-lg bg-surface-input border border-border-primary text-sm">
                    <option value="1" selected>¿En qué ciudad obtuviste tu título universitario?</option>
                    <option value="2">¿Cuál es el nombre de tu primera escuela primaria?</option>
                    <option value="3">¿Cuál es el segundo nombre de tu madre?</option>
                </select>
                <label for="da1" class="sr-only">Respuesta a la pregunta de seguridad 1 (4 a 16 caracteres)</label>
                <input id="da1" type="password" minlength="4" maxlength="16" value="valencia" aria-describedby="dc1" class="h-11 px-3.5 rounded-lg bg-surface-input border border-border-primary text-sm" placeholder="4 a 16 caracteres">
                <span id="dc1" class="inline-flex self-start px-2.5 py-0.5 rounded bg-[#d1fae5] text-[#065f46] text-xs font-mono font-bold">✓ 8 / 16 caracteres · Longitud válida</span>
            </div>

            <div class="flex flex-col gap-2 pt-3 border-t border-border-subtle">
                <label for="dq2" class="text-xs font-extrabold uppercase text-unefa-navy">Pregunta de Seguridad 2 *</label>
                <select id="dq2" class="h-11 px-3 rounded-lg bg-surface-input border border-border-primary text-sm">
                    <option value="1">¿En qué ciudad obtuviste tu título universitario?</option>
                    <option value="2" selected>¿Cuál es el nombre de tu primera escuela primaria?</option>
                    <option value="3">¿Cuál es el segundo nombre de tu madre?</option>
                </select>
                <label for="da2" class="sr-only">Respuesta a la pregunta de seguridad 2 (4 a 16 caracteres)</label>
                <input id="da2" type="password" minlength="4" maxlength="16" value="carabobo" aria-describedby="dc2" class="h-11 px-3.5 rounded-lg bg-surface-input border border-border-primary text-sm" placeholder="4 a 16 caracteres">
                <span id="dc2" class="inline-flex self-start px-2.5 py-0.5 rounded bg-[#d1fae5] text-[#065f46] text-xs font-mono font-bold">✓ 8 / 16 caracteres · Longitud válida</span>
            </div>

            <div class="pt-4 border-t border-border-subtle flex flex-wrap items-center justify-between gap-3">
                <button type="submit" class="min-h-[2.85rem] px-5 py-2.5 rounded-lg bg-unefa-navy-soft text-white text-sm font-extrabold hover:bg-unefa-blue cursor-pointer">
                    Guardar Preguntas de Seguridad
                </button>
                <span class="text-xs text-text-muted font-mono">PUT /api/auth/security-questions</span>
            </div>
        </form>
    </section>

    {{-- Control de Sesion STAFF + Auditoria --}}
    <div class="flex flex-col gap-6">
        <section aria-labelledby="docSessCtrl" class="bg-white border-[1.5px] border-border-primary rounded-xl p-5 sm:p-6 shadow-panel">
            <h2 id="docSessCtrl" class="text-base font-extrabold text-unefa-navy">Control de Sesión Activa (RF-05)</h2>
            <p class="text-xs font-mono text-text-muted mt-1">Canal: STAFF · Rol: TEACHER · IP 190.72.14.88</p>
            <div class="mt-4">
                <div class="flex justify-between text-xs font-extrabold mb-1.5">
                    <span>Inactividad restante:</span>
                    <span class="font-mono"><span data-inactivity-timer>10:00</span> / 10:00 min</span>
                </div>
                <div class="w-full h-2.5 bg-bg-tertiary rounded-full overflow-hidden">
                    <div data-inactivity-bar class="h-full bg-unefa-gold transition-all duration-1000" style="width: 100%;"></div>
                </div>
            </div>
            <div class="mt-4">
                <button type="button" data-open-logout class="min-h-[2.75rem] px-4 py-2 rounded-lg bg-white border-[1.5px] border-unefa-red text-unefa-red text-xs font-extrabold uppercase hover:bg-unefa-red hover:text-white cursor-pointer">
                    Cerrar Sesión Actual
                </button>
            </div>
        </section>

        <section aria-labelledby="docAuditPreview" class="bg-white border-[1.5px] border-border-primary rounded-xl p-5 sm:p-6 shadow-panel">
            <h2 id="docAuditPreview" class="text-base font-extrabold text-unefa-navy mb-3">Actividad Reciente Auditada</h2>
            <ul class="list-none p-0 m-0 space-y-2.5 text-xs text-text-secondary">
                @foreach($actividadAuditada as $registro)
                    <li class="flex justify-between gap-2">
                        <span class="font-bold text-unefa-navy">{{ $registro['evento'] }}</span>
                        <span class="font-mono text-text-muted">{{ $registro['hora'] }}</span>
                    </li>
                @endforeach
            </ul>
        </section>
    </div>
</div>
