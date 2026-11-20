{{-- Pie de pagina institucional de la landing (equivalente al footer de la aplicacion movil). --}}
<footer class="border-t border-slate-200 bg-slate-50 px-4 py-10">
    <div class="mx-auto w-full max-w-6xl">
        <div class="mb-8 grid gap-8 md:grid-cols-3">
            <div>
                <div class="mb-3 flex items-center gap-2.5">
                    <span class="flex h-8 w-8 items-center justify-center rounded-md border border-slate-200 bg-white">
                        <img src="{{ asset('assets/img/logos/logo_unefa.png') }}" alt="Logo de la UNEFA" class="h-6 w-6 object-contain" />
                    </span>
                    <span class="text-lg font-black text-neutral-950">UNEFA</span>
                </div>
                <p class="text-xs leading-[18px] text-slate-600">
                    Universidad Nacional Experimental Politécnica de la Fuerza Armada Nacional
                    Bolivariana. Institución pública formadora de profesionales con excelencia técnica,
                    disciplina y compromiso patriótico.
                </p>
            </div>

            <div>
                <p class="mb-1 text-[13px] font-extrabold text-neutral-950">Navegación</p>
                <ul class="flex flex-col gap-1.5">
                    <li><a href="{{ route('landing') }}#inicio" class="py-0.5 text-xs font-semibold text-unefa-blue hover:underline">Inicio</a></li>
                    <li><a href="{{ route('landing') }}#nosotros" class="py-0.5 text-xs font-semibold text-unefa-blue hover:underline">La UNEFA</a></li>
                    <li><a href="{{ route('landing') }}#carreras" class="py-0.5 text-xs font-semibold text-unefa-blue hover:underline">Carreras</a></li>
                    <li><a href="{{ route('landing') }}#carnetizacion" class="py-0.5 text-xs font-semibold text-unefa-blue hover:underline">Carnetización</a></li>
                    <li><a href="{{ route('landing') }}#servicios" class="py-0.5 text-xs font-semibold text-unefa-blue hover:underline">Servicios</a></li>
                </ul>
            </div>

            <div>
                <p class="mb-1 text-[13px] font-extrabold text-neutral-950">Plataformas</p>
                <ul class="flex flex-col gap-1.5">
                    <li><a href="{{ route('login') }}" class="py-0.5 text-xs font-semibold text-unefa-blue hover:underline">Portal Estudiantes</a></li>
                    <li><a href="{{ route('login') }}" class="py-0.5 text-xs font-semibold text-unefa-blue hover:underline">Portal Docentes</a></li>
                    <li><a href="{{ route('registro') }}" class="py-0.5 text-xs font-semibold text-unefa-blue hover:underline">Registro de Carnet Digital</a></li>
                    <li><a href="{{ route('landing') }}#servicios" class="py-0.5 text-xs font-semibold text-unefa-blue hover:underline">Biblioteca digital</a></li>
                </ul>
            </div>
        </div>

        <div class="mb-4 border-t border-slate-300 pt-4">
            <p class="mb-1 text-[13px] font-extrabold text-neutral-950">INFORMACION</p>
            <p class="text-[11px] leading-4 text-slate-600">
                Edificio Sede UNEFA, Guacara.<br />
                Guacara, República Bolivariana de Venezuela.<br />
                Teléfono: +58 (0212) 908-2000
            </p>
        </div>

        <div class="flex flex-col gap-1">
            <p class="text-[10px] text-slate-500">© 2026 UNEFA — Todos los derechos reservados.</p>
            <p class="text-[10px] font-bold text-unefa-goldDark">Portal web del Sistema Integral de Asistencias y Carnetización Digital · 2026</p>
        </div>
    </div>
</footer>
