{{-- Seccion Seguridad de Cuenta --}}
@include('partials.dashboard.page-header', [
    'titulo' => 'Seguridad de Cuenta y Recuperación',
    'descripcion' => 'Configuración de preguntas de seguridad reglamentarias (RF-04) y control de sesión e inactividad (RF-05).',
])

<div class="grid grid-cols-1 lg:grid-cols-[7fr_5fr] gap-6 items-start">
    {{-- Columna Izquierda: Preguntas de Seguridad (RF-04) --}}
    <section aria-labelledby="secQuestionsTitle" class="bg-white border-[1.5px] border-border-primary rounded-xl p-5 sm:p-6 shadow-panel">
        <div class="pb-4 mb-5 border-b border-border-subtle">
            <h2 id="secQuestionsTitle" class="text-base font-extrabold text-unefa-navy">Preguntas de Seguridad para Recuperación de Cuenta</h2>
            <p class="text-xs text-text-muted mt-1">
                Debe configurar al menos <strong>2 preguntas distintas</strong>. Cada respuesta debe tener estrictamente entre <strong>4 y 16 caracteres</strong> (sin espacios vacíos).
            </p>
        </div>

        <div id="secAlertBox" class="hidden mb-5 px-4 py-3 rounded-lg text-xs font-semibold border border-unefa-red bg-[#ffdad6] text-[#93000a]" role="alert"></div>
        <div id="secSuccessBox" class="hidden mb-5 px-4 py-3 rounded-lg text-xs font-bold border border-unefa-green bg-[#d1fae5] text-[#065f46]" role="status"></div>

        <form id="securityQuestionsForm" class="flex flex-col gap-5" novalidate>
            <div class="flex flex-col gap-2">
                <label for="secQ1" class="text-xs font-extrabold uppercase tracking-wider text-unefa-navy">Pregunta de Seguridad 1 *</label>
                <select id="secQ1" required class="w-full h-11 px-3 rounded-lg bg-surface-input border border-border-primary text-sm text-text-primary focus:bg-white focus:border-unefa-blue">
                    <option value="1" selected>¿Cuál es el nombre de tu primera escuela primaria?</option>
                    <option value="2">¿En qué ciudad nació tu madre?</option>
                    <option value="3">¿Cuál fue el nombre de tu primera mascota?</option>
                    <option value="4">¿Cuál es el segundo nombre de tu padre?</option>
                </select>

                <label for="secA1" class="text-xs font-bold text-text-secondary mt-1">Respuesta 1 (4 a 16 caracteres) *</label>
                <div class="relative flex items-center rounded-lg overflow-hidden border border-border-primary bg-surface-input focus-within:bg-white focus-within:border-unefa-blue">
                    <input
                        id="secA1"
                        type="password"
                        minlength="4"
                        maxlength="16"
                        value="bolivar8"
                        required
                        aria-describedby="secA1Counter"
                        placeholder="Entre 4 y 16 caracteres"
                        class="w-full h-11 pl-3.5 pr-11 border-0 bg-transparent text-sm text-text-primary outline-none"
                    />
                    <button type="button" data-toggle-input="secA1" aria-label="Mostrar respuesta 1" aria-pressed="false" class="absolute right-0 inset-y-0 w-11 flex items-center justify-center text-text-muted hover:text-unefa-navy cursor-pointer bg-transparent border-0">
                        <span data-eye-open>@include('partials.icon', ['name' => 'eye', 'clase' => 'w-4 h-4'])</span>
                        <span data-eye-off class="hidden">@include('partials.icon', ['name' => 'eye-off', 'clase' => 'w-4 h-4'])</span>
                    </button>
                </div>
                <span id="secA1Counter" class="inline-flex self-start px-2.5 py-0.5 rounded bg-[#d1fae5] text-[#065f46] text-xs font-mono font-bold">
                    ✓ 8 / 16 caracteres · Longitud válida (4–16)
                </span>
            </div>

            <div class="flex flex-col gap-2 pt-3 border-t border-border-subtle">
                <label for="secQ2" class="text-xs font-extrabold uppercase tracking-wider text-unefa-navy">Pregunta de Seguridad 2 *</label>
                <select id="secQ2" required class="w-full h-11 px-3 rounded-lg bg-surface-input border border-border-primary text-sm text-text-primary focus:bg-white focus:border-unefa-blue">
                    <option value="1">¿Cuál es el nombre de tu primera escuela primaria?</option>
                    <option value="2" selected>¿En qué ciudad nació tu madre?</option>
                    <option value="3">¿Cuál fue el nombre de tu primera mascota?</option>
                    <option value="4">¿Cuál es el segundo nombre de tu padre?</option>
                </select>

                <label for="secA2" class="text-xs font-bold text-text-secondary mt-1">Respuesta 2 (4 a 16 caracteres) *</label>
                <div class="relative flex items-center rounded-lg overflow-hidden border border-border-primary bg-surface-input focus-within:bg-white focus-within:border-unefa-blue">
                    <input
                        id="secA2"
                        type="password"
                        minlength="4"
                        maxlength="16"
                        value="guacara"
                        required
                        aria-describedby="secA2Counter"
                        placeholder="Entre 4 y 16 caracteres"
                        class="w-full h-11 pl-3.5 pr-11 border-0 bg-transparent text-sm text-text-primary outline-none"
                    />
                    <button type="button" data-toggle-input="secA2" aria-label="Mostrar respuesta 2" aria-pressed="false" class="absolute right-0 inset-y-0 w-11 flex items-center justify-center text-text-muted hover:text-unefa-navy cursor-pointer bg-transparent border-0">
                        <span data-eye-open>@include('partials.icon', ['name' => 'eye', 'clase' => 'w-4 h-4'])</span>
                        <span data-eye-off class="hidden">@include('partials.icon', ['name' => 'eye-off', 'clase' => 'w-4 h-4'])</span>
                    </button>
                </div>
                <span id="secA2Counter" class="inline-flex self-start px-2.5 py-0.5 rounded bg-[#d1fae5] text-[#065f46] text-xs font-mono font-bold">
                    ✓ 7 / 16 caracteres · Longitud válida (4–16)
                </span>
            </div>

            <div class="pt-4 border-t border-border-subtle flex flex-wrap items-center justify-between gap-3">
                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 min-h-[2.85rem] px-5 py-2.5 rounded-lg bg-unefa-navy-soft text-white text-sm font-extrabold hover:bg-unefa-blue cursor-pointer transition-colors"
                >
                    <span>Guardar Preguntas de Seguridad</span>
                </button>
                <span class="text-xs text-text-muted font-medium">
                    Última actualización: 12 Nov 2026 · Hash Bcrypt (costo 12)
                </span>
            </div>
        </form>
    </section>

    {{-- Columna Derecha: Control de Sesion + Proteccion Fuerza Bruta --}}
    <div class="flex flex-col gap-6">
        <section aria-labelledby="sessionCtrlTitle" class="bg-white border-[1.5px] border-border-primary rounded-xl p-5 sm:p-6 shadow-panel">
            <h2 id="sessionCtrlTitle" class="text-base font-extrabold text-unefa-navy">Control de Sesión Activa e Inactividad (RF-05)</h2>
            <p class="text-xs font-mono text-text-muted mt-1">Navegador Web · IP 190.72.14.88 · Canal: STUDENT</p>

            <div class="mt-4">
                <div class="flex items-center justify-between text-xs font-extrabold text-unefa-navy mb-1.5">
                    <span>Cierre automático por inactividad:</span>
                    <span class="font-mono"><span data-inactivity-timer>10:00</span> / 10:00 min</span>
                </div>
                <div class="w-full h-2.5 bg-bg-tertiary rounded-full overflow-hidden">
                    <div data-inactivity-bar class="h-full bg-unefa-gold transition-all duration-1000" style="width: 100%;"></div>
                </div>
                <p class="text-[0.72rem] text-text-muted mt-1.5">El temporizador se reinicia automáticamente con cada interacción.</p>
            </div>

            <div class="mt-4 p-3.5 rounded-lg bg-bg-secondary border border-border-primary text-xs text-text-secondary leading-relaxed">
                <strong>Control dual en servidor:</strong> Redis valida la sesión activa bajo <span class="font-mono">session:{sid}</span> con TTL deslizante exacto de 600 segundos.
            </div>

            <div class="mt-4">
                <button
                    type="button"
                    data-open-logout
                    class="inline-flex items-center justify-center gap-2 min-h-[2.75rem] px-4 py-2 rounded-lg bg-white border-[1.5px] border-unefa-red text-unefa-red text-xs font-extrabold uppercase tracking-wider hover:bg-unefa-red hover:text-white cursor-pointer transition-colors"
                >
                    <span>Cerrar Sesión Actual</span>
                </button>
            </div>
        </section>

        <section aria-labelledby="bruteForceTitle" class="bg-white border-[1.5px] border-border-primary rounded-xl p-5 sm:p-6 shadow-panel">
            <h2 id="bruteForceTitle" class="text-base font-extrabold text-unefa-navy mb-3">Protección contra Fuerza Bruta y Acceso</h2>
            <ul class="list-none p-0 m-0 flex flex-col gap-2.5 text-xs text-text-secondary">
                <li class="flex items-center gap-2">
                    <span class="w-5 h-5 rounded-full bg-[#d1fae5] text-[#047857] font-black flex items-center justify-center shrink-0">✓</span>
                    <span>Bloqueo automático de IP tras 10 intentos fallidos por 15 min · <strong>Activo</strong></span>
                </li>
                <li class="flex items-center gap-2">
                    <span class="w-5 h-5 rounded-full bg-[#d1fae5] text-[#047857] font-black flex items-center justify-center shrink-0">✓</span>
                    <span>Canal exclusivo Estudiantes (<span class="font-mono">STUDENT</span>) validado</span>
                </li>
            </ul>

            <div class="mt-4 pt-4 border-t border-border-subtle flex items-center justify-between">
                <button type="button" id="btnOpenChangePwd" command="show-modal" commandfor="changePwdDialog" class="text-xs font-extrabold text-unefa-blue hover:underline cursor-pointer bg-transparent border-0 p-0">
                    Cambiar Contraseña Institucional →
                </button>
                <span class="font-mono text-[0.68rem] text-text-muted">SIA-UNEFA V2.4.0</span>
            </div>
        </section>
    </div>
</div>

{{-- Dialogo Cambio de Contrasena --}}
<dialog id="changePwdDialog" closedby="any" aria-labelledby="changePwdTitle" class="m-auto w-[min(92vw,28rem)] rounded-xl border-2 border-border-primary bg-white p-6 text-text-primary shadow-2xl">
    <h1 id="changePwdTitle" class="text-lg font-extrabold text-unefa-navy">Cambiar Contraseña Institucional</h1>
    <p class="mt-2 text-sm text-text-muted leading-relaxed">
        Para modificar su contraseña institucional, utilice el flujo de recuperación verificada con sus preguntas de seguridad configuradas (RF-04).
    </p>
    <form method="dialog" class="mt-6 flex justify-end">
        <button type="submit" id="closeChangePwdDialog" autofocus class="min-h-[2.75rem] px-5 py-2 rounded-lg bg-unefa-navy-soft text-white text-sm font-bold cursor-pointer hover:bg-unefa-blue">
            Entendido
        </button>
    </form>
</dialog>
