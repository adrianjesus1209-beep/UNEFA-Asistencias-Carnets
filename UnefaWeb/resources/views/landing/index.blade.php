@extends('layouts.public')

@section('title', 'UNEFA — Vanguardia Técnica & Soberanía')
@section('header-subtitle', 'Excelencia Educativa')

@push('scripts')
    <script src="{{ asset('js/landing.js') }}" defer></script>
@endpush

@section('content')
    {{-- Contenido tomado de la landing de UnefaApp (src/app/landing.tsx y src/constants/data.ts). --}}
    <div class="mx-auto w-full max-w-6xl">

        {{-- Seccion 01: Presentacion principal --}}
        <section id="inicio" data-seccion-nav="inicio" class="bg-white px-4 pb-10 pt-6 lg:pt-10">
            <div class="grid items-center gap-10 lg:grid-cols-2">
                <div>
                    <p class="mb-2 text-[11px] font-extrabold uppercase tracking-[0.5px] text-unefa-blue">[01] — Institución politécnica cívico-militar</p>
                    <h1 class="mb-3 text-4xl font-black leading-[42px] tracking-[-0.5px] text-neutral-950 sm:text-5xl sm:leading-[54px]">
                        Vanguardia Técnica &amp;
                        <span class="text-unefa-blue">Soberanía</span>
                    </h1>

                    <p class="mb-5 text-[15px] leading-[22px] text-slate-600">
                        Formación politécnica rigurosa, investigación científica aplicada y valores
                        cívico-militares con 100% de gratuidad de matrícula.
                    </p>

                    <div class="mb-6 flex gap-2.5 sm:max-w-md">
                        <div class="flex-1 rounded-[14px] border border-slate-200 bg-white p-3 text-center shadow-sm">
                            <p class="text-[22px] font-black text-neutral-950">100%</p>
                            <p class="mt-0.5 text-[11px] font-semibold text-slate-500">Gratuidad</p>
                        </div>
                        <div class="flex-1 rounded-[14px] border border-slate-200 bg-white p-3 text-center shadow-sm">
                            <p class="text-[22px] font-black text-neutral-950">24</p>
                            <p class="mt-0.5 text-[11px] font-semibold text-slate-500">Estados</p>
                        </div>
                        <div class="flex-1 rounded-[14px] border border-slate-200 bg-white p-3 text-center shadow-sm">
                            <p class="text-[22px] font-black text-unefa-blue">CINU</p>
                            <p class="mt-0.5 text-[11px] font-semibold text-slate-500">Convocatoria</p>
                        </div>
                    </div>

                    <div class="mb-6 flex flex-col gap-2.5 sm:max-w-md">
                        <a href="{{ route('registro') }}" class="flex items-center justify-center gap-2 rounded-[14px] bg-unefa-gold py-3.5 text-[15px] font-black text-unefa-navy shadow-md transition hover:brightness-105">
                            Preinscripción CINU
                            <span class="text-base font-black text-unefa-navy">→</span>
                        </a>
                        <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 rounded-[14px] border border-slate-300 py-3.5 text-sm font-bold text-neutral-950 transition hover:bg-slate-50">
                            Portal SICEU
                        </a>
                        <a href="#carreras" class="self-center rounded px-1.5 py-1.5 text-[13px] font-bold text-slate-600 transition hover:text-neutral-950">
                            Explorar carreras ↓
                        </a>
                    </div>
                </div>

                <div>
                    <div class="mb-5 overflow-hidden rounded-[18px] border border-slate-200">
                        <img src="{{ asset('assets/img/unefaapp/hero-laboratorio.jpg') }}" alt="Laboratorio politécnico de la UNEFA" class="h-[200px] w-full object-cover sm:h-[280px] lg:h-[320px]" />
                        <div class="flex items-center justify-between p-3">
                            <div>
                                <p class="text-[10px] font-extrabold tracking-[0.4px] text-neutral-950">FIG. 01 — LABORATORIO POLITÉCNICO</p>
                                <p class="text-[9px] font-semibold text-slate-500">ROBÓTICA, AUTOMATIZACIÓN Y SISTEMAS APLICADOS</p>
                            </div>
                            <span class="h-[14px] w-[14px] rounded-full bg-unefa-blue"></span>
                        </div>
                    </div>

                    <div class="grid gap-2.5 sm:grid-cols-2">
                        <div class="flex items-center gap-2.5 rounded-[14px] border border-slate-200 bg-white p-3">
                            <span class="text-xl text-unefa-blue">⚙</span>
                            <div>
                                <p class="text-[13px] font-extrabold text-neutral-950">Ingenierías</p>
                                <p class="text-[10px] font-semibold text-slate-500">10 Semestres</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2.5 rounded-[14px] border border-slate-200 bg-white p-3">
                            <span class="text-xl text-unefa-gold">★</span>
                            <div>
                                <p class="text-[13px] font-extrabold text-neutral-950">Cívico-Militar</p>
                                <p class="text-[10px] font-semibold text-slate-500">Doctrina Integral</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Seccion 02: Doctrina y fundamentos unefistas --}}
        <section id="nosotros" data-seccion-nav="nosotros" class="border-y border-slate-200 bg-slate-50 px-4 py-10">
            <div class="mb-5">
                <p class="mb-1 text-[11px] font-extrabold uppercase tracking-[0.5px] text-unefa-blue">[02] — Doctrina &amp; fundamentos</p>
                <h2 class="mb-1.5 text-2xl font-black text-neutral-950 sm:text-3xl">Pilares del modelo unefista</h2>
                <p class="max-w-3xl text-sm leading-5 text-slate-600">
                    Una propuesta pedagógica única que une la disciplina del método científico
                    con la mística y responsabilidad cívico-militar.
                </p>
            </div>

            {{-- Pestanas de pilares (una ficha visible por vez) --}}
            <div class="mb-4 flex gap-2 overflow-x-auto pb-4" role="tablist" aria-label="Pilares institucionales">
                <button type="button" role="tab" aria-selected="true" data-pilar-tab="ingenieria" class="min-w-[150px] shrink-0 rounded-xl border !border-unefa-blue !bg-unefa-blue/[0.06] bg-white px-3.5 py-2.5 text-left">
                    <span class="mb-1 flex justify-between">
                        <span data-pilar-num class="font-mono text-[11px] font-extrabold !text-unefa-blue text-slate-500">[01]</span>
                        <span class="text-[10px] font-semibold text-slate-500">Área técnica</span>
                    </span>
                    <span data-pilar-titulo class="block text-[13px] font-bold !text-unefa-blue text-neutral-950">Innovación Politécnica</span>
                </button>
                <button type="button" role="tab" aria-selected="false" data-pilar-tab="doctrina" class="min-w-[150px] shrink-0 rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-left">
                    <span class="mb-1 flex justify-between">
                        <span data-pilar-num class="font-mono text-[11px] font-extrabold text-slate-500">[02]</span>
                        <span class="text-[10px] font-semibold text-slate-500">Defensa integral</span>
                    </span>
                    <span data-pilar-titulo class="block text-[13px] font-bold text-neutral-950">Doctrina Cívico-Militar</span>
                </button>
                <button type="button" role="tab" aria-selected="false" data-pilar-tab="extension" class="min-w-[150px] shrink-0 rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-left">
                    <span class="mb-1 flex justify-between">
                        <span data-pilar-num class="font-mono text-[11px] font-extrabold text-slate-500">[03]</span>
                        <span class="text-[10px] font-semibold text-slate-500">Vinculación</span>
                    </span>
                    <span data-pilar-titulo class="block text-[13px] font-bold text-neutral-950">Extensión Comunitaria</span>
                </button>
                <button type="button" role="tab" aria-selected="false" data-pilar-tab="gratuidad" class="min-w-[150px] shrink-0 rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-left">
                    <span class="mb-1 flex justify-between">
                        <span data-pilar-num class="font-mono text-[11px] font-extrabold text-slate-500">[04]</span>
                        <span class="text-[10px] font-semibold text-slate-500">Igualdad social</span>
                    </span>
                    <span data-pilar-titulo class="block text-[13px] font-bold text-neutral-950">Inclusión y Cobertura</span>
                </button>
            </div>

            {{-- Ficha 01: Innovacion Politencia --}}
            <article data-pilar-ficha="ingenieria" class="mb-5 overflow-hidden rounded-[20px] border border-slate-200 bg-white shadow-md">
                <div class="grid lg:grid-cols-2">
                    <figure class="relative min-h-[180px] lg:min-h-[300px]">
                        <img src="{{ asset('assets/img/unefaapp/pilar-ingenieria.jpg') }}" alt="Banco de pruebas electrónicas y mecatrónica" class="absolute inset-0 h-full w-full object-cover" />
                        <figcaption class="absolute inset-x-0 bottom-0 bg-white px-3 py-1.5 text-[9px] font-bold tracking-[0.3px] text-neutral-950">FIG. 02 — BANCO DE PRUEBAS ELECTRÓNICAS Y MECATRÓNICA</figcaption>
                    </figure>
                    <div class="p-5 lg:p-6">
                        <span class="mb-2.5 inline-block rounded-lg bg-unefa-blue/10 px-2.5 py-1 text-[11px] font-extrabold text-unefa-blue">Área 01</span>
                        <h3 class="mb-2 text-xl font-black text-neutral-950">Innovación Politécnica e Investigación</h3>
                        <p class="mb-4 text-[13px] leading-[19px] text-slate-600">
                            Programas orientados a la soberanía científica: desarrollo de software crítico, automatización, diseño mecánico y telecomunicaciones satelitales que atienden las necesidades estratégicas de la nación.
                        </p>
                        <p class="mb-2 text-[11px] font-extrabold uppercase tracking-[0.4px] text-slate-500">Hitos de formación</p>
                        <ul class="flex flex-col gap-1.5">
                            <li class="flex items-start gap-2">
                                <span class="text-sm font-extrabold text-unefa-blue">→</span>
                                <span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Laboratorios equipados para prácticas de hardware y redes</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-sm font-extrabold text-unefa-blue">→</span>
                                <span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Proyectos de tesis orientados a resolver problemas industriales reales</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-sm font-extrabold text-unefa-blue">→</span>
                                <span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Docencia a cargo de especialistas con trayectoria técnica probada</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </article>

            {{-- Ficha 02: Doctrina Civico-Militar --}}
            <article data-pilar-ficha="doctrina" class="mb-5 hidden overflow-hidden rounded-[20px] border border-slate-200 bg-white shadow-md">
                <div class="grid lg:grid-cols-2">
                    <figure class="relative min-h-[180px] lg:min-h-[300px]">
                        <img src="{{ asset('assets/img/unefaapp/pilar-doctrina.jpg') }}" alt="Formación integral y patrimonio institucional" class="absolute inset-0 h-full w-full object-cover" />
                        <figcaption class="absolute inset-x-0 bottom-0 bg-white px-3 py-1.5 text-[9px] font-bold tracking-[0.3px] text-neutral-950">FIG. 03 — FORMACIÓN INTEGRAL Y PATRIMONIO INSTITUCIONAL</figcaption>
                    </figure>
                    <div class="p-5 lg:p-6">
                        <span class="mb-2.5 inline-block rounded-lg bg-unefa-blue/10 px-2.5 py-1 text-[11px] font-extrabold text-unefa-blue">Área 02</span>
                        <h3 class="mb-2 text-xl font-black text-neutral-950">Doctrina Cívico-Militar y Liderazgo</h3>
                        <p class="mb-4 text-[13px] leading-[19px] text-slate-600">
                            Formación en valores de honor, disciplina, lealtad y corresponsabilidad ciudadana en la defensa y desarrollo integral de la patria, forjando un carácter ético inquebrantable en cada profesional.
                        </p>
                        <p class="mb-2 text-[11px] font-extrabold uppercase tracking-[0.4px] text-slate-500">Hitos de formación</p>
                        <ul class="flex flex-col gap-1.5">
                            <li class="flex items-start gap-2">
                                <span class="text-sm font-extrabold text-unefa-blue">→</span>
                                <span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Instrucción en orden cerrado, liderazgo y trabajo bajo presión</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-sm font-extrabold text-unefa-blue">→</span>
                                <span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Cátedra de Defensa Integral de la Nación y soberanía popular</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-sm font-extrabold text-unefa-blue">→</span>
                                <span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Ética cívica aplicada a la ingeniería y la administración pública</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </article>

            {{-- Ficha 03: Extension Comunitaria --}}
            <article data-pilar-ficha="extension" class="mb-5 hidden overflow-hidden rounded-[20px] border border-slate-200 bg-white shadow-md">
                <div class="grid lg:grid-cols-2">
                    <figure class="relative min-h-[180px] lg:min-h-[300px]">
                        <img src="{{ asset('assets/img/unefaapp/pilar-extension.jpg') }}" alt="Vinculación comunitaria y servicio social" class="absolute inset-0 h-full w-full object-cover" />
                        <figcaption class="absolute inset-x-0 bottom-0 bg-white px-3 py-1.5 text-[9px] font-bold tracking-[0.3px] text-neutral-950">FIG. 04 — VINCULACIÓN COMUNITARIA Y SERVICIO SOCIAL</figcaption>
                    </figure>
                    <div class="p-5 lg:p-6">
                        <span class="mb-2.5 inline-block rounded-lg bg-unefa-blue/10 px-2.5 py-1 text-[11px] font-extrabold text-unefa-blue">Área 03</span>
                        <h3 class="mb-2 text-xl font-black text-neutral-950">Extensión y Compromiso Comunitario</h3>
                        <p class="mb-4 text-[13px] leading-[19px] text-slate-600">
                            La ciencia y la técnica no se quedan en el aula: los estudiantes unefistas transfieren sus proyectos directamente a las comunidades, consejos comunales y empresas públicas a través del Servicio Comunitario obligatorio.
                        </p>
                        <p class="mb-2 text-[11px] font-extrabold uppercase tracking-[0.4px] text-slate-500">Hitos de formación</p>
                        <ul class="flex flex-col gap-1.5">
                            <li class="flex items-start gap-2">
                                <span class="text-sm font-extrabold text-unefa-blue">→</span>
                                <span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Más de 100 proyectos comunitarios activos por semestre</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-sm font-extrabold text-unefa-blue">→</span>
                                <span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Capacitación tecnológica a sectores vulnerables y escuelas técnicas</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-sm font-extrabold text-unefa-blue">→</span>
                                <span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Soluciones de ingeniería de bajo costo con alto impacto social</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </article>

            {{-- Ficha 04: Inclusion y Cobertura --}}
            <article data-pilar-ficha="gratuidad" class="mb-5 hidden overflow-hidden rounded-[20px] border border-slate-200 bg-white shadow-md">
                <div class="grid lg:grid-cols-2">
                    <figure class="relative min-h-[180px] lg:min-h-[300px]">
                        <img src="{{ asset('assets/img/unefaapp/pilar-gratuidad.jpg') }}" alt="Aulas digitales y acceso irrestricto" class="absolute inset-0 h-full w-full object-cover" />
                        <figcaption class="absolute inset-x-0 bottom-0 bg-white px-3 py-1.5 text-[9px] font-bold tracking-[0.3px] text-neutral-950">FIG. 05 — AULAS DIGITALES Y ACCESO IRRESTRICTO</figcaption>
                    </figure>
                    <div class="p-5 lg:p-6">
                        <span class="mb-2.5 inline-block rounded-lg bg-unefa-blue/10 px-2.5 py-1 text-[11px] font-extrabold text-unefa-blue">Área 04</span>
                        <h3 class="mb-2 text-xl font-black text-neutral-950">Inclusión Radical y Cobertura Nacional</h3>
                        <p class="mb-4 text-[13px] leading-[19px] text-slate-600">
                            Educación universitaria de primer nivel completamente pública y gratuita, garantizando que el talento de cualquier rincón del país tenga acceso a las carreras más demandadas del mercado tecnológico.
                        </p>
                        <p class="mb-2 text-[11px] font-extrabold uppercase tracking-[0.4px] text-slate-500">Hitos de formación</p>
                        <ul class="flex flex-col gap-1.5">
                            <li class="flex items-start gap-2">
                                <span class="text-sm font-extrabold text-unefa-blue">→</span>
                                <span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">0 aranceles de matrícula durante toda la carrera</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-sm font-extrabold text-unefa-blue">→</span>
                                <span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Presencia en los 24 estados con sedes y extensiones</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-sm font-extrabold text-unefa-blue">→</span>
                                <span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Igualdad de oportunidades mediante el Curso Introductorio CINU</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </article>

            <div class="rounded-[14px] border border-slate-200 bg-white p-4 text-center lg:mx-auto lg:max-w-2xl">
                <p class="mb-1 text-[10px] font-extrabold uppercase tracking-[0.4px] text-slate-500">Lema institucional</p>
                <p class="text-sm font-extrabold italic text-neutral-950">"Excelencia Educativa Abierta al Pueblo"</p>
            </div>
        </section>

        {{-- Seccion 03: Oferta academica y carreras --}}
        <section id="carreras" data-seccion-nav="carreras" class="bg-white px-4 py-10">
            <div class="mb-5 flex flex-wrap items-start justify-between gap-3">
                <div>
                    <p class="mb-1 text-[11px] font-extrabold uppercase tracking-[0.5px] text-unefa-blue">[03] — Oferta académica</p>
                    <h2 class="text-2xl font-black text-neutral-950 sm:text-3xl">Explorador de carreras</h2>
                </div>
                <a href="{{ route('registro') }}" class="text-[13px] font-extrabold text-unefa-blue hover:underline">Inscripción →</a>
            </div>

            {{-- Control segmentado por tipo de facultad --}}
            <div class="mb-4 flex gap-1 rounded-[14px] border border-slate-200 bg-slate-100 p-1 sm:max-w-xl" role="tablist" aria-label="Tipos de carrera">
                <button type="button" role="tab" aria-selected="true" data-facultad-tab="ingenieria" class="flex-1 rounded-[10px] !bg-unefa-blue py-2">
                    <span data-facultad-titulo class="block text-xs font-extrabold !text-white">Ingenierías</span>
                    <span class="block text-[9px] text-slate-500">10 sem.</span>
                </button>
                <button type="button" role="tab" aria-selected="false" data-facultad-tab="licenciaturas" class="flex-1 rounded-[10px] py-2">
                    <span data-facultad-titulo class="block text-xs font-extrabold">Licenciaturas</span>
                    <span class="block text-[9px] text-slate-500">8 sem.</span>
                </button>
                <button type="button" role="tab" aria-selected="false" data-facultad-tab="tsu" class="flex-1 rounded-[10px] py-2">
                    <span data-facultad-titulo class="block text-xs font-extrabold">Técnico Superior</span>
                    <span class="block text-[9px] text-slate-500">6 sem.</span>
                </button>
            </div>

            {{-- Listado: Ingenierias --}}
            <div data-facultad-lista="ingenieria" class="mb-5 grid gap-2 sm:grid-cols-2">
                <button type="button" data-carrera-item="sistemas" class="rounded-[14px] border !border-unefa-blue !bg-unefa-blue/[0.05] border-slate-200 bg-white p-3 text-left">
                    <span class="mb-0.5 flex justify-between">
                        <span data-carrera-codigo class="font-mono text-[11px] font-extrabold !text-unefa-blue text-slate-500">ING-SIS-10</span>
                        <span class="text-[11px] font-semibold text-slate-500">10 Semestres (5 Años)</span>
                    </span>
                    <span data-carrera-titulo class="block text-sm font-extrabold !text-unefa-blue text-neutral-950">Ingeniería de Sistemas</span>
                </button>
                <button type="button" data-carrera-item="telecom" class="rounded-[14px] border border-slate-200 bg-white p-3 text-left">
                    <span class="mb-0.5 flex justify-between">
                        <span data-carrera-codigo class="font-mono text-[11px] font-extrabold text-slate-500">ING-TEL-10</span>
                        <span class="text-[11px] font-semibold text-slate-500">10 Semestres (5 Años)</span>
                    </span>
                    <span data-carrera-titulo class="block text-sm font-extrabold text-neutral-950">Ingeniería de Telecomunicaciones</span>
                </button>
                <button type="button" data-carrera-item="mecanica" class="rounded-[14px] border border-slate-200 bg-white p-3 text-left">
                    <span class="mb-0.5 flex justify-between">
                        <span data-carrera-codigo class="font-mono text-[11px] font-extrabold text-slate-500">ING-MEC-10</span>
                        <span class="text-[11px] font-semibold text-slate-500">10 Semestres (5 Años)</span>
                    </span>
                    <span data-carrera-titulo class="block text-sm font-extrabold text-neutral-950">Ingeniería Mecánica</span>
                </button>
                <button type="button" data-carrera-item="electronica" class="rounded-[14px] border border-slate-200 bg-white p-3 text-left">
                    <span class="mb-0.5 flex justify-between">
                        <span data-carrera-codigo class="font-mono text-[11px] font-extrabold text-slate-500">ING-ELE-10</span>
                        <span class="text-[11px] font-semibold text-slate-500">10 Semestres (5 Años)</span>
                    </span>
                    <span data-carrera-titulo class="block text-sm font-extrabold text-neutral-950">Ingeniería Electrónica</span>
                </button>
            </div>

            {{-- Listado: Licenciaturas --}}
            <div data-facultad-lista="licenciaturas" class="mb-5 hidden gap-2 sm:grid-cols-2">
                <button type="button" data-carrera-item="administracion" class="rounded-[14px] border border-slate-200 bg-white p-3 text-left">
                    <span class="mb-0.5 flex justify-between">
                        <span data-carrera-codigo class="font-mono text-[11px] font-extrabold text-slate-500">LIC-AGM-08</span>
                        <span class="text-[11px] font-semibold text-slate-500">8 Semestres (4 Años)</span>
                    </span>
                    <span data-carrera-titulo class="block text-sm font-extrabold text-neutral-950">Administración y Gestión Municipal</span>
                </button>
                <button type="button" data-carrera-item="enfermeria" class="rounded-[14px] border border-slate-200 bg-white p-3 text-left">
                    <span class="mb-0.5 flex justify-between">
                        <span data-carrera-codigo class="font-mono text-[11px] font-extrabold text-slate-500">LIC-ENF-08</span>
                        <span class="text-[11px] font-semibold text-slate-500">8 Semestres (4 Años)</span>
                    </span>
                    <span data-carrera-titulo class="block text-sm font-extrabold text-neutral-950">Licenciatura en Enfermería</span>
                </button>
            </div>

            {{-- Listado: TSU --}}
            <div data-facultad-lista="tsu" class="mb-5 hidden gap-2 sm:grid-cols-2">
                <button type="button" data-carrera-item="tsu-sistemas" class="rounded-[14px] border border-slate-200 bg-white p-3 text-left">
                    <span class="mb-0.5 flex justify-between">
                        <span data-carrera-codigo class="font-mono text-[11px] font-extrabold text-slate-500">TSU-SIS-06</span>
                        <span class="text-[11px] font-semibold text-slate-500">6 Semestres (3 Años)</span>
                    </span>
                    <span data-carrera-titulo class="block text-sm font-extrabold text-neutral-950">TSU en Análisis de Sistemas</span>
                </button>
                <button type="button" data-carrera-item="tsu-enfermeria" class="rounded-[14px] border border-slate-200 bg-white p-3 text-left">
                    <span class="mb-0.5 flex justify-between">
                        <span data-carrera-codigo class="font-mono text-[11px] font-extrabold text-slate-500">TSU-ENF-06</span>
                        <span class="text-[11px] font-semibold text-slate-500">6 Semestres (3 Años)</span>
                    </span>
                    <span data-carrera-titulo class="block text-sm font-extrabold text-neutral-950">TSU en Enfermería</span>
                </button>
            </div>

            {{-- Ficha: Ingenieria de Sistemas --}}
            <article data-carrera-ficha="sistemas" class="mb-5 overflow-hidden rounded-[20px] border border-slate-200 bg-white shadow-md">
                <div class="grid lg:grid-cols-2">
                    <figure class="relative min-h-[180px] lg:min-h-[300px]">
                        <img src="{{ asset('assets/img/unefaapp/pilar-gratuidad.jpg') }}" alt="Ingeniería de Sistemas" class="absolute inset-0 h-full w-full object-cover" />
                        <span class="absolute left-2.5 top-2.5 rounded-md bg-unefa-navy px-2 py-1 font-mono text-[10px] font-extrabold text-white">ING-SIS-10</span>
                        <figcaption class="absolute inset-x-0 bottom-0 flex justify-between bg-unefa-navy/[0.85] px-3 py-1.5">
                            <span class="text-[11px] font-bold text-white">Ingeniero de Sistemas</span>
                            <span class="text-[11px] font-extrabold text-unefa-gold">10 Semestres (5 Años)</span>
                        </figcaption>
                    </figure>
                    <div class="p-5 lg:p-6">
                        <h3 class="mb-2 text-xl font-black text-neutral-950">Ingeniería de Sistemas</h3>
                        <p class="mb-4 text-[13px] leading-[19px] text-slate-600">
                            Formación de avanzada en ingeniería de software crítico, arquitectura de sistemas distribuidos, bases de datos masivas, ciberseguridad y computación para la defensa y desarrollo soberano.
                        </p>
                        <p class="mb-2 text-[11px] font-extrabold uppercase tracking-[0.4px] text-slate-500">Competencias principales</p>
                        <ul class="mb-4 flex flex-col gap-1.5">
                            <li class="flex items-start gap-2"><span class="text-[11px] text-unefa-gold">■</span><span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Desarrollo de software de misión crítica</span></li>
                            <li class="flex items-start gap-2"><span class="text-[11px] text-unefa-gold">■</span><span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Ciberseguridad y soberanía de datos</span></li>
                            <li class="flex items-start gap-2"><span class="text-[11px] text-unefa-gold">■</span><span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Modelado matemático e inteligencia artificial</span></li>
                            <li class="flex items-start gap-2"><span class="text-[11px] text-unefa-gold">■</span><span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Gestión de infraestructuras del Estado</span></li>
                        </ul>
                        <p class="mb-2 text-[11px] font-extrabold uppercase tracking-[0.4px] text-slate-500">Materias troncales</p>
                        <div class="mb-4 flex flex-wrap gap-1.5">
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Algoritmos y Estructuras</span>
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Bases de Datos Masivas</span>
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Redes y Teleproceso</span>
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Ingeniería de Software</span>
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Sistemas Operativos</span>
                        </div>
                        <p class="mb-2 text-center font-mono text-[10px] text-slate-500">Modalidad presencial · Núcleo Central y sedes regionales</p>
                        <a href="{{ route('registro') }}" class="flex items-center justify-center gap-2 rounded-[14px] bg-unefa-gold py-3.5 text-[15px] font-black text-unefa-navy shadow-md transition hover:brightness-105">
                            Postularme en esta carrera
                            <span class="text-base font-black text-unefa-navy">→</span>
                        </a>
                    </div>
                </div>
            </article>

            {{-- Ficha: Ingenieria de Telecomunicaciones --}}
            <article data-carrera-ficha="telecom" class="mb-5 hidden overflow-hidden rounded-[20px] border border-slate-200 bg-white shadow-md">
                <div class="grid lg:grid-cols-2">
                    <figure class="relative min-h-[180px] lg:min-h-[300px]">
                        <img src="{{ asset('assets/img/unefaapp/carrera-telecom.jpg') }}" alt="Ingeniería de Telecomunicaciones" class="absolute inset-0 h-full w-full object-cover" />
                        <span class="absolute left-2.5 top-2.5 rounded-md bg-unefa-navy px-2 py-1 font-mono text-[10px] font-extrabold text-white">ING-TEL-10</span>
                        <figcaption class="absolute inset-x-0 bottom-0 flex justify-between bg-unefa-navy/[0.85] px-3 py-1.5">
                            <span class="text-[11px] font-bold text-white">Ingeniero de Telecomunicaciones</span>
                            <span class="text-[11px] font-extrabold text-unefa-gold">10 Semestres (5 Años)</span>
                        </figcaption>
                    </figure>
                    <div class="p-5 lg:p-6">
                        <h3 class="mb-2 text-xl font-black text-neutral-950">Ingeniería de Telecomunicaciones</h3>
                        <p class="mb-4 text-[13px] leading-[19px] text-slate-600">
                            Especialistas en transmisión por fibra óptica, microondas, enlaces satelitales civiles y militares, antenas y procesamiento digital de señales para redes estratégicas.
                        </p>
                        <p class="mb-2 text-[11px] font-extrabold uppercase tracking-[0.4px] text-slate-500">Competencias principales</p>
                        <ul class="mb-4 flex flex-col gap-1.5">
                            <li class="flex items-start gap-2"><span class="text-[11px] text-unefa-gold">■</span><span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Diseño de redes de comunicación nacional</span></li>
                            <li class="flex items-start gap-2"><span class="text-[11px] text-unefa-gold">■</span><span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Operación de estaciones terrenas y satélites</span></li>
                            <li class="flex items-start gap-2"><span class="text-[11px] text-unefa-gold">■</span><span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Propagación electromagnética y microondas</span></li>
                            <li class="flex items-start gap-2"><span class="text-[11px] text-unefa-gold">■</span><span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Protocolos tácticos y seguros de comunicación</span></li>
                        </ul>
                        <p class="mb-2 text-[11px] font-extrabold uppercase tracking-[0.4px] text-slate-500">Materias troncales</p>
                        <div class="mb-4 flex flex-wrap gap-1.5">
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Teoría Electromagnética</span>
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Sistemas de Transmisión</span>
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Microondas y Radar</span>
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Comunicaciones Ópticas</span>
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Redes de Conmutación</span>
                        </div>
                        <p class="mb-2 text-center font-mono text-[10px] text-slate-500">Modalidad presencial · Núcleo Central y sedes regionales</p>
                        <a href="{{ route('registro') }}" class="flex items-center justify-center gap-2 rounded-[14px] bg-unefa-gold py-3.5 text-[15px] font-black text-unefa-navy shadow-md transition hover:brightness-105">
                            Postularme en esta carrera
                            <span class="text-base font-black text-unefa-navy">→</span>
                        </a>
                    </div>
                </div>
            </article>

            {{-- Ficha: Ingenieria Mecanica --}}
            <article data-carrera-ficha="mecanica" class="mb-5 hidden overflow-hidden rounded-[20px] border border-slate-200 bg-white shadow-md">
                <div class="grid lg:grid-cols-2">
                    <figure class="relative min-h-[180px] lg:min-h-[300px]">
                        <img src="{{ asset('assets/img/unefaapp/pilar-ingenieria.jpg') }}" alt="Ingeniería Mecánica" class="absolute inset-0 h-full w-full object-cover" />
                        <span class="absolute left-2.5 top-2.5 rounded-md bg-unefa-navy px-2 py-1 font-mono text-[10px] font-extrabold text-white">ING-MEC-10</span>
                        <figcaption class="absolute inset-x-0 bottom-0 flex justify-between bg-unefa-navy/[0.85] px-3 py-1.5">
                            <span class="text-[11px] font-bold text-white">Ingeniero Mecánico</span>
                            <span class="text-[11px] font-extrabold text-unefa-gold">10 Semestres (5 Años)</span>
                        </figcaption>
                    </figure>
                    <div class="p-5 lg:p-6">
                        <h3 class="mb-2 text-xl font-black text-neutral-950">Ingeniería Mecánica</h3>
                        <p class="mb-4 text-[13px] leading-[19px] text-slate-600">
                            Diseño asistido por computadora (CAD/CAM), plantas térmicas, turbomáquinas, manufactura avanzada y mantenimiento de plantas industriales y de defensa.
                        </p>
                        <p class="mb-2 text-[11px] font-extrabold uppercase tracking-[0.4px] text-slate-500">Competencias principales</p>
                        <ul class="mb-4 flex flex-col gap-1.5">
                            <li class="flex items-start gap-2"><span class="text-[11px] text-unefa-gold">■</span><span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Diseño y simulación de mecanismos</span></li>
                            <li class="flex items-start gap-2"><span class="text-[11px] text-unefa-gold">■</span><span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Plantas térmicas y conversión de potencia</span></li>
                            <li class="flex items-start gap-2"><span class="text-[11px] text-unefa-gold">■</span><span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Automatización de procesos industriales</span></li>
                            <li class="flex items-start gap-2"><span class="text-[11px] text-unefa-gold">■</span><span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Metalurgia y resistencia de materiales</span></li>
                        </ul>
                        <p class="mb-2 text-[11px] font-extrabold uppercase tracking-[0.4px] text-slate-500">Materias troncales</p>
                        <div class="mb-4 flex flex-wrap gap-1.5">
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Mecánica de Fluidos</span>
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Termodinámica Aplicada</span>
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Diseño de Máquinas</span>
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Resistencia de Materiales</span>
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Transferencia de Calor</span>
                        </div>
                        <p class="mb-2 text-center font-mono text-[10px] text-slate-500">Modalidad presencial · Núcleo Central y sedes regionales</p>
                        <a href="{{ route('registro') }}" class="flex items-center justify-center gap-2 rounded-[14px] bg-unefa-gold py-3.5 text-[15px] font-black text-unefa-navy shadow-md transition hover:brightness-105">
                            Postularme en esta carrera
                            <span class="text-base font-black text-unefa-navy">→</span>
                        </a>
                    </div>
                </div>
            </article>

            {{-- Ficha: Ingenieria Electronica --}}
            <article data-carrera-ficha="electronica" class="mb-5 hidden overflow-hidden rounded-[20px] border border-slate-200 bg-white shadow-md">
                <div class="grid lg:grid-cols-2">
                    <figure class="relative min-h-[180px] lg:min-h-[300px]">
                        <img src="{{ asset('assets/img/unefaapp/hero-laboratorio.jpg') }}" alt="Ingeniería Electrónica" class="absolute inset-0 h-full w-full object-cover" />
                        <span class="absolute left-2.5 top-2.5 rounded-md bg-unefa-navy px-2 py-1 font-mono text-[10px] font-extrabold text-white">ING-ELE-10</span>
                        <figcaption class="absolute inset-x-0 bottom-0 flex justify-between bg-unefa-navy/[0.85] px-3 py-1.5">
                            <span class="text-[11px] font-bold text-white">Ingeniero Electrónico</span>
                            <span class="text-[11px] font-extrabold text-unefa-gold">10 Semestres (5 Años)</span>
                        </figcaption>
                    </figure>
                    <div class="p-5 lg:p-6">
                        <h3 class="mb-2 text-xl font-black text-neutral-950">Ingeniería Electrónica</h3>
                        <p class="mb-4 text-[13px] leading-[19px] text-slate-600">
                            Control automático, diseño de sistemas embebidos, instrumentación industrial y biomédica, robótica aplicada y electrónica de potencia.
                        </p>
                        <p class="mb-2 text-[11px] font-extrabold uppercase tracking-[0.4px] text-slate-500">Competencias principales</p>
                        <ul class="mb-4 flex flex-col gap-1.5">
                            <li class="flex items-start gap-2"><span class="text-[11px] text-unefa-gold">■</span><span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Sistemas embebidos y microcontroladores</span></li>
                            <li class="flex items-start gap-2"><span class="text-[11px] text-unefa-gold">■</span><span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Control y automatismos de plantas</span></li>
                            <li class="flex items-start gap-2"><span class="text-[11px] text-unefa-gold">■</span><span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Electrónica de potencia industrial</span></li>
                            <li class="flex items-start gap-2"><span class="text-[11px] text-unefa-gold">■</span><span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Robótica y sensórica aplicada</span></li>
                        </ul>
                        <p class="mb-2 text-[11px] font-extrabold uppercase tracking-[0.4px] text-slate-500">Materias troncales</p>
                        <div class="mb-4 flex flex-wrap gap-1.5">
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Circuitos Eléctricos</span>
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Electrónica Analógica y Digital</span>
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Sistemas de Control</span>
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Microprocesadores</span>
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Robótica Industrial</span>
                        </div>
                        <p class="mb-2 text-center font-mono text-[10px] text-slate-500">Modalidad presencial · Núcleo Central y sedes regionales</p>
                        <a href="{{ route('registro') }}" class="flex items-center justify-center gap-2 rounded-[14px] bg-unefa-gold py-3.5 text-[15px] font-black text-unefa-navy shadow-md transition hover:brightness-105">
                            Postularme en esta carrera
                            <span class="text-base font-black text-unefa-navy">→</span>
                        </a>
                    </div>
                </div>
            </article>

            {{-- Ficha: Administracion y Gestion Municipal --}}
            <article data-carrera-ficha="administracion" class="mb-5 hidden overflow-hidden rounded-[20px] border border-slate-200 bg-white shadow-md">
                <div class="grid lg:grid-cols-2">
                    <figure class="relative min-h-[180px] lg:min-h-[300px]">
                        <img src="{{ asset('assets/img/unefaapp/pilar-extension.jpg') }}" alt="Administración y Gestión Municipal" class="absolute inset-0 h-full w-full object-cover" />
                        <span class="absolute left-2.5 top-2.5 rounded-md bg-unefa-navy px-2 py-1 font-mono text-[10px] font-extrabold text-white">LIC-AGM-08</span>
                        <figcaption class="absolute inset-x-0 bottom-0 flex justify-between bg-unefa-navy/[0.85] px-3 py-1.5">
                            <span class="text-[11px] font-bold text-white">Licenciado en Administración y Gestión Municipal</span>
                            <span class="text-[11px] font-extrabold text-unefa-gold">8 Semestres (4 Años)</span>
                        </figcaption>
                    </figure>
                    <div class="p-5 lg:p-6">
                        <h3 class="mb-2 text-xl font-black text-neutral-950">Administración y Gestión Municipal</h3>
                        <p class="mb-4 text-[13px] leading-[19px] text-slate-600">
                            Formación en gerencia pública estratégica, presupuesto y contabilidad del Estado, contrataciones públicas y gestión de proyectos socio-productivos comunales.
                        </p>
                        <p class="mb-2 text-[11px] font-extrabold uppercase tracking-[0.4px] text-slate-500">Competencias principales</p>
                        <ul class="mb-4 flex flex-col gap-1.5">
                            <li class="flex items-start gap-2"><span class="text-[11px] text-unefa-gold">■</span><span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Planificación presupuestaria pública</span></li>
                            <li class="flex items-start gap-2"><span class="text-[11px] text-unefa-gold">■</span><span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Gobernanza territorial y comunal</span></li>
                            <li class="flex items-start gap-2"><span class="text-[11px] text-unefa-gold">■</span><span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Auditoría y control de gestión</span></li>
                            <li class="flex items-start gap-2"><span class="text-[11px] text-unefa-gold">■</span><span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Diseño de políticas socio-productivas</span></li>
                        </ul>
                        <p class="mb-2 text-[11px] font-extrabold uppercase tracking-[0.4px] text-slate-500">Materias troncales</p>
                        <div class="mb-4 flex flex-wrap gap-1.5">
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Derecho Administrativo</span>
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Finanzas Públicas</span>
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Planificación Estratégica</span>
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Gestión Tributaria</span>
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Proyectos Comunales</span>
                        </div>
                        <p class="mb-2 text-center font-mono text-[10px] text-slate-500">Modalidad presencial · Núcleo Central y sedes regionales</p>
                        <a href="{{ route('registro') }}" class="flex items-center justify-center gap-2 rounded-[14px] bg-unefa-gold py-3.5 text-[15px] font-black text-unefa-navy shadow-md transition hover:brightness-105">
                            Postularme en esta carrera
                            <span class="text-base font-black text-unefa-navy">→</span>
                        </a>
                    </div>
                </div>
            </article>

            {{-- Ficha: Licenciatura en Enfermeria --}}
            <article data-carrera-ficha="enfermeria" class="mb-5 hidden overflow-hidden rounded-[20px] border border-slate-200 bg-white shadow-md">
                <div class="grid lg:grid-cols-2">
                    <figure class="relative min-h-[180px] lg:min-h-[300px]">
                        <img src="{{ asset('assets/img/unefaapp/carrera-enfermeria.jpg') }}" alt="Licenciatura en Enfermería" class="absolute inset-0 h-full w-full object-cover" />
                        <span class="absolute left-2.5 top-2.5 rounded-md bg-unefa-navy px-2 py-1 font-mono text-[10px] font-extrabold text-white">LIC-ENF-08</span>
                        <figcaption class="absolute inset-x-0 bottom-0 flex justify-between bg-unefa-navy/[0.85] px-3 py-1.5">
                            <span class="text-[11px] font-bold text-white">Licenciado en Enfermería</span>
                            <span class="text-[11px] font-extrabold text-unefa-gold">8 Semestres (4 Años)</span>
                        </figcaption>
                    </figure>
                    <div class="p-5 lg:p-6">
                        <h3 class="mb-2 text-xl font-black text-neutral-950">Licenciatura en Enfermería</h3>
                        <p class="mb-4 text-[13px] leading-[19px] text-slate-600">
                            Atención hospitalaria, salud integral preventiva, gestión de emergencias clínicas y medicina táctica en apoyo a las comunidades y la fuerza armada.
                        </p>
                        <p class="mb-2 text-[11px] font-extrabold uppercase tracking-[0.4px] text-slate-500">Competencias principales</p>
                        <ul class="mb-4 flex flex-col gap-1.5">
                            <li class="flex items-start gap-2"><span class="text-[11px] text-unefa-gold">■</span><span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Cuidados intensivos y prehospitalarios</span></li>
                            <li class="flex items-start gap-2"><span class="text-[11px] text-unefa-gold">■</span><span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Epidemiología y salud pública</span></li>
                            <li class="flex items-start gap-2"><span class="text-[11px] text-unefa-gold">■</span><span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Administración de servicios clínicos</span></li>
                            <li class="flex items-start gap-2"><span class="text-[11px] text-unefa-gold">■</span><span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Atención en situaciones de contingencia</span></li>
                        </ul>
                        <p class="mb-2 text-[11px] font-extrabold uppercase tracking-[0.4px] text-slate-500">Materias troncales</p>
                        <div class="mb-4 flex flex-wrap gap-1.5">
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Anatomía y Fisiología</span>
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Farmacología Clínica</span>
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Enfermería Médico-Quirúrgica</span>
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Salud Pública</span>
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Medicina de Emergencia</span>
                        </div>
                        <p class="mb-2 text-center font-mono text-[10px] text-slate-500">Modalidad presencial · Núcleo Central y sedes regionales</p>
                        <a href="{{ route('registro') }}" class="flex items-center justify-center gap-2 rounded-[14px] bg-unefa-gold py-3.5 text-[15px] font-black text-unefa-navy shadow-md transition hover:brightness-105">
                            Postularme en esta carrera
                            <span class="text-base font-black text-unefa-navy">→</span>
                        </a>
                    </div>
                </div>
            </article>

            {{-- Ficha: TSU en Analisis de Sistemas --}}
            <article data-carrera-ficha="tsu-sistemas" class="mb-5 hidden overflow-hidden rounded-[20px] border border-slate-200 bg-white shadow-md">
                <div class="grid lg:grid-cols-2">
                    <figure class="relative min-h-[180px] lg:min-h-[300px]">
                        <img src="{{ asset('assets/img/unefaapp/carrera-tsu-sistemas.jpg') }}" alt="TSU en Análisis de Sistemas" class="absolute inset-0 h-full w-full object-cover" />
                        <span class="absolute left-2.5 top-2.5 rounded-md bg-unefa-navy px-2 py-1 font-mono text-[10px] font-extrabold text-white">TSU-SIS-06</span>
                        <figcaption class="absolute inset-x-0 bottom-0 flex justify-between bg-unefa-navy/[0.85] px-3 py-1.5">
                            <span class="text-[11px] font-bold text-white">Técnico Superior Universitario en Análisis de Sistemas</span>
                            <span class="text-[11px] font-extrabold text-unefa-gold">6 Semestres (3 Años)</span>
                        </figcaption>
                    </figure>
                    <div class="p-5 lg:p-6">
                        <h3 class="mb-2 text-xl font-black text-neutral-950">TSU en Análisis de Sistemas</h3>
                        <p class="mb-4 text-[13px] leading-[19px] text-slate-600">
                            Inserción técnica directa: programación web, administración de bases de datos relacionales, soporte de redes locales y mantenimiento de infraestructura informática.
                        </p>
                        <p class="mb-2 text-[11px] font-extrabold uppercase tracking-[0.4px] text-slate-500">Competencias principales</p>
                        <ul class="mb-4 flex flex-col gap-1.5">
                            <li class="flex items-start gap-2"><span class="text-[11px] text-unefa-gold">■</span><span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Desarrollo web y aplicaciones</span></li>
                            <li class="flex items-start gap-2"><span class="text-[11px] text-unefa-gold">■</span><span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Configuración de redes LAN</span></li>
                            <li class="flex items-start gap-2"><span class="text-[11px] text-unefa-gold">■</span><span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Mantenimiento preventivo y correctivo de software</span></li>
                        </ul>
                        <p class="mb-2 text-[11px] font-extrabold uppercase tracking-[0.4px] text-slate-500">Materias troncales</p>
                        <div class="mb-4 flex flex-wrap gap-1.5">
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Lenguajes de Programación</span>
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Bases de Datos Relacionales</span>
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Redes de Computadoras</span>
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Sistemas de Información</span>
                        </div>
                        <p class="mb-2 text-center font-mono text-[10px] text-slate-500">Modalidad presencial · Núcleo Central y sedes regionales</p>
                        <a href="{{ route('registro') }}" class="flex items-center justify-center gap-2 rounded-[14px] bg-unefa-gold py-3.5 text-[15px] font-black text-unefa-navy shadow-md transition hover:brightness-105">
                            Postularme en esta carrera
                            <span class="text-base font-black text-unefa-navy">→</span>
                        </a>
                    </div>
                </div>
            </article>

            {{-- Ficha: TSU en Enfermeria --}}
            <article data-carrera-ficha="tsu-enfermeria" class="mb-5 hidden overflow-hidden rounded-[20px] border border-slate-200 bg-white shadow-md">
                <div class="grid lg:grid-cols-2">
                    <figure class="relative min-h-[180px] lg:min-h-[300px]">
                        <img src="{{ asset('assets/img/unefaapp/carrera-enfermeria.jpg') }}" alt="TSU en Enfermería" class="absolute inset-0 h-full w-full object-cover" />
                        <span class="absolute left-2.5 top-2.5 rounded-md bg-unefa-navy px-2 py-1 font-mono text-[10px] font-extrabold text-white">TSU-ENF-06</span>
                        <figcaption class="absolute inset-x-0 bottom-0 flex justify-between bg-unefa-navy/[0.85] px-3 py-1.5">
                            <span class="text-[11px] font-bold text-white">Técnico Superior Universitario en Enfermería</span>
                            <span class="text-[11px] font-extrabold text-unefa-gold">6 Semestres (3 Años)</span>
                        </figcaption>
                    </figure>
                    <div class="p-5 lg:p-6">
                        <h3 class="mb-2 text-xl font-black text-neutral-950">TSU en Enfermería</h3>
                        <p class="mb-4 text-[13px] leading-[19px] text-slate-600">
                            Asistencia clínica directa en hospitales y ambulatorios, curas y primeros auxilios, vacunación y apoyo inmediato a brigadas de salud preventiva.
                        </p>
                        <p class="mb-2 text-[11px] font-extrabold uppercase tracking-[0.4px] text-slate-500">Competencias principales</p>
                        <ul class="mb-4 flex flex-col gap-1.5">
                            <li class="flex items-start gap-2"><span class="text-[11px] text-unefa-gold">■</span><span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Procedimientos de enfermería básicos y avanzados</span></li>
                            <li class="flex items-start gap-2"><span class="text-[11px] text-unefa-gold">■</span><span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Atención inmediata en triaje y primeros auxilios</span></li>
                            <li class="flex items-start gap-2"><span class="text-[11px] text-unefa-gold">■</span><span class="flex-1 text-xs font-medium leading-[18px] text-neutral-950">Protocolos de esterilización y bioseguridad</span></li>
                        </ul>
                        <p class="mb-2 text-[11px] font-extrabold uppercase tracking-[0.4px] text-slate-500">Materias troncales</p>
                        <div class="mb-4 flex flex-wrap gap-1.5">
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Fundamentos de Enfermería</span>
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Bioquímica Básica</span>
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Enfermería Comunitaria</span>
                            <span class="rounded-[20px] border border-slate-200 bg-slate-100 px-2.5 py-[5px] text-[11px] font-semibold text-neutral-950">Atención Materno-Infantil</span>
                        </div>
                        <p class="mb-2 text-center font-mono text-[10px] text-slate-500">Modalidad presencial · Núcleo Central y sedes regionales</p>
                        <a href="{{ route('registro') }}" class="flex items-center justify-center gap-2 rounded-[14px] bg-unefa-gold py-3.5 text-[15px] font-black text-unefa-navy shadow-md transition hover:brightness-105">
                            Postularme en esta carrera
                            <span class="text-base font-black text-unefa-navy">→</span>
                        </a>
                    </div>
                </div>
            </article>
        </section>

        {{-- Seccion 04: Admisiones y verificador CINU --}}
        <section id="admisiones" data-seccion-nav="admisiones" class="border-y border-slate-200 bg-slate-50 px-4 py-10">
            <div class="mb-5">
                <p class="mb-1 text-[11px] font-extrabold uppercase tracking-[0.5px] text-unefa-blue">[04] — Admisiones &amp; nivelación</p>
                <h2 class="mb-1.5 text-2xl font-black text-neutral-950 sm:text-3xl">Ruta de ingreso y verificador CINU</h2>
                <p class="max-w-3xl text-sm leading-5 text-slate-600">
                    Todos los aspirantes formalizan su acceso a través del Curso Integral de
                    Nivelación Universitaria. Verifica tus recaudos antes de iniciar el registro.
                </p>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
                <div>
                    {{-- Cronologia de fases del proceso --}}
                    <div class="mb-5 flex flex-col gap-3">
                        <div class="flex gap-3">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[rgba(242,184,7,0.16)]">
                                <span class="font-mono text-[13px] font-black text-[#c99106]">01</span>
                            </span>
                            <div>
                                <p class="mb-0.5 text-sm font-extrabold text-neutral-950">Registro digital</p>
                                <p class="text-xs leading-[17px] text-slate-600">Creación de expediente en el portal, selección de carrera politécnica y sede regional asignada.</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[rgba(242,184,7,0.16)]">
                                <span class="font-mono text-[13px] font-black text-[#c99106]">02</span>
                            </span>
                            <div>
                                <p class="mb-0.5 text-sm font-extrabold text-neutral-950">Consignación de recaudos</p>
                                <p class="text-xs leading-[17px] text-slate-600">Revisión física de documentos en la Unidad de Control de Estudios de tu núcleo UNEFA.</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[rgba(242,184,7,0.16)]">
                                <span class="font-mono text-[13px] font-black text-[#c99106]">03</span>
                            </span>
                            <div>
                                <p class="mb-0.5 text-sm font-extrabold text-neutral-950">Cursado del CINU</p>
                                <p class="text-xs leading-[17px] text-slate-600">14 semanas intensivas en Matemática, Habilidades de Comunicación y Doctrina Cívico-Militar.</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[rgba(242,184,7,0.16)]">
                                <span class="font-mono text-[13px] font-black text-[#c99106]">04</span>
                            </span>
                            <div>
                                <p class="mb-0.5 text-sm font-extrabold text-neutral-950">Activación en SICEU</p>
                                <p class="text-xs leading-[17px] text-slate-600">Asignación definitiva de matrícula e inicio del primer semestre académico regular.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Fotografia de la sede institucional --}}
                    <div class="overflow-hidden rounded-[18px] border border-slate-200">
                        <img src="{{ asset('assets/img/unefaapp/pilar-doctrina.jpg') }}" alt="Instalaciones de pregrado y postgrado" class="h-[180px] w-full object-cover sm:h-[220px]" />
                        <div class="flex items-center justify-between p-3">
                            <p class="text-[10px] font-extrabold tracking-[0.4px] text-neutral-950">INSTALACIONES DE PREGRADO Y POSTGRADO</p>
                            <p class="text-[10px] font-extrabold text-[#c99106]">SEDES EN 24 ESTADOS</p>
                        </div>
                    </div>
                </div>

                {{-- Herramienta de verificacion de recaudos --}}
                <div class="rounded-[20px] border border-slate-200 bg-white p-[18px]">
                    <div class="mb-3.5 flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-extrabold uppercase text-unefa-blue">Herramienta del aspirante</p>
                            <p class="text-lg font-black text-neutral-950">Verificador de recaudos</p>
                        </div>
                        <div class="text-right">
                            <p id="porcentaje-recaudos" class="text-[22px] font-black text-[#c99106]">33%</p>
                            <p class="text-[10px] font-semibold text-slate-500">Listo para consignar</p>
                        </div>
                    </div>

                    <div class="mb-3.5 h-2 overflow-hidden rounded bg-slate-200">
                        <div id="barra-recaudos" class="h-full bg-unefa-gold" style="width: 33%;"></div>
                    </div>

                    <p class="mb-3 text-xs leading-[17px] text-slate-600">
                        Marca los recaudos que ya posees en físico para calcular tu preparación:
                    </p>

                    <div class="mb-4 flex flex-col gap-2">
                        <label class="flex cursor-pointer items-center gap-2.5 rounded-xl border !border-unefa-blue !bg-unefa-blue/[0.04] border-slate-200 bg-white p-2.5 transition-colors">
                            <input type="checkbox" data-recaudo="1" class="sr-only" checked />
                            <span data-caja-recaudo class="flex h-[22px] w-[22px] shrink-0 items-center justify-center rounded-md border-2 !border-unefa-blue !bg-unefa-blue border-slate-300 bg-white">
                                <span data-marca-recaudo class="text-[13px] font-black leading-none text-white">✓</span>
                            </span>
                            <span data-texto-recaudo class="flex-1 text-xs !font-bold font-medium leading-4 text-neutral-950">Cédula de identidad laminada y 2 fotocopias legibles</span>
                            <span class="rounded-md bg-slate-100 px-1.5 py-0.5 text-[9px] font-bold text-slate-500">Fase 1</span>
                        </label>
                        <label class="flex cursor-pointer items-center gap-2.5 rounded-xl border !border-unefa-blue !bg-unefa-blue/[0.04] border-slate-200 bg-white p-2.5 transition-colors">
                            <input type="checkbox" data-recaudo="2" class="sr-only" checked />
                            <span data-caja-recaudo class="flex h-[22px] w-[22px] shrink-0 items-center justify-center rounded-md border-2 !border-unefa-blue !bg-unefa-blue border-slate-300 bg-white">
                                <span data-marca-recaudo class="text-[13px] font-black leading-none text-white">✓</span>
                            </span>
                            <span data-texto-recaudo class="flex-1 text-xs !font-bold font-medium leading-4 text-neutral-950">Título de bachiller autenticado por Zona Educativa</span>
                            <span class="rounded-md bg-slate-100 px-1.5 py-0.5 text-[9px] font-bold text-slate-500">Fase 2</span>
                        </label>
                        <label class="flex cursor-pointer items-center gap-2.5 rounded-xl border border-slate-200 bg-white p-2.5 transition-colors">
                            <input type="checkbox" data-recaudo="3" class="sr-only" />
                            <span data-caja-recaudo class="flex h-[22px] w-[22px] shrink-0 items-center justify-center rounded-md border-2 border-slate-300 bg-white">
                                <span data-marca-recaudo class="hidden text-[13px] font-black leading-none text-white">✓</span>
                            </span>
                            <span data-texto-recaudo class="flex-1 text-xs font-medium leading-4 text-neutral-950">Notas certificadas de 1º a 5º año de educación media</span>
                            <span class="rounded-md bg-slate-100 px-1.5 py-0.5 text-[9px] font-bold text-slate-500">Fase 2</span>
                        </label>
                        <label class="flex cursor-pointer items-center gap-2.5 rounded-xl border border-slate-200 bg-white p-2.5 transition-colors">
                            <input type="checkbox" data-recaudo="4" class="sr-only" />
                            <span data-caja-recaudo class="flex h-[22px] w-[22px] shrink-0 items-center justify-center rounded-md border-2 border-slate-300 bg-white">
                                <span data-marca-recaudo class="hidden text-[13px] font-black leading-none text-white">✓</span>
                            </span>
                            <span data-texto-recaudo class="flex-1 text-xs font-medium leading-4 text-neutral-950">Certificado de participación en el SNI / OPSU</span>
                            <span class="rounded-md bg-slate-100 px-1.5 py-0.5 text-[9px] font-bold text-slate-500">Fase 1</span>
                        </label>
                        <label class="flex cursor-pointer items-center gap-2.5 rounded-xl border border-slate-200 bg-white p-2.5 transition-colors">
                            <input type="checkbox" data-recaudo="5" class="sr-only" />
                            <span data-caja-recaudo class="flex h-[22px] w-[22px] shrink-0 items-center justify-center rounded-md border-2 border-slate-300 bg-white">
                                <span data-marca-recaudo class="hidden text-[13px] font-black leading-none text-white">✓</span>
                            </span>
                            <span data-texto-recaudo class="flex-1 text-xs font-medium leading-4 text-neutral-950">Partida de nacimiento en formato reciente legible</span>
                            <span class="rounded-md bg-slate-100 px-1.5 py-0.5 text-[9px] font-bold text-slate-500">Fase 2</span>
                        </label>
                        <label class="flex cursor-pointer items-center gap-2.5 rounded-xl border border-slate-200 bg-white p-2.5 transition-colors">
                            <input type="checkbox" data-recaudo="6" class="sr-only" />
                            <span data-caja-recaudo class="flex h-[22px] w-[22px] shrink-0 items-center justify-center rounded-md border-2 border-slate-300 bg-white">
                                <span data-marca-recaudo class="hidden text-[13px] font-black leading-none text-white">✓</span>
                            </span>
                            <span data-texto-recaudo class="flex-1 text-xs font-medium leading-4 text-neutral-950">2 fotografías recientes fondo blanco tipo carnet</span>
                            <span class="rounded-md bg-slate-100 px-1.5 py-0.5 text-[9px] font-bold text-slate-500">Fase 3</span>
                        </label>
                    </div>

                    <div id="mensaje-recaudos" class="mb-3.5 rounded-xl bg-unefa-blue/[0.06] p-3">
                        <p id="texto-mensaje-recaudos" class="text-center text-xs font-semibold text-unefa-blue">
                            Tienes 2 de 6 recaudos completados.
                        </p>
                    </div>

                    <a href="{{ route('registro') }}" class="flex items-center justify-center gap-2 rounded-[14px] bg-unefa-gold py-3.5 text-[15px] font-black text-unefa-navy shadow-md transition hover:brightness-105">
                        Iniciar preinscripción digital
                        <span class="text-base font-black text-unefa-navy">→</span>
                    </a>

                    <p class="mt-2.5 flex items-center justify-center gap-1.5 text-center text-[11px] text-slate-500">
                        @include('partials.icon', ['name' => 'shield-check', 'clase' => 'h-3.5 w-3.5 text-slate-500'])
                        Trámite 100% público y gratuito, sin intermediarios
                    </p>
                </div>
            </div>
        </section>

        {{-- Seccion 05: Plataformas y servicios digitales --}}
        <section id="servicios" data-seccion-nav="servicios" class="bg-white px-4 py-10">
            <div class="mb-5 flex flex-wrap items-start justify-between gap-3">
                <div>
                    <p class="mb-1 text-[11px] font-extrabold uppercase tracking-[0.5px] text-unefa-blue">[05] — Plataformas &amp; servicios</p>
                    <h2 class="text-2xl font-black text-neutral-950 sm:text-3xl">Servicios digitales</h2>
                </div>
                <a href="{{ route('login') }}" class="text-[13px] font-extrabold text-unefa-blue hover:underline">Ingreso →</a>
            </div>

            <div class="grid gap-3.5 sm:grid-cols-2 xl:grid-cols-4">
                {{-- Servicio 01: Portal SICEU --}}
                <div class="rounded-[18px] border-[1.5px] border-unefa-gold border-slate-200 border-solid bg-white p-[18px]">
                    <div class="mb-2.5 flex gap-2">
                        <span class="rounded-md bg-[rgba(242,184,7,0.16)] px-2 py-[3px] text-[10px] font-extrabold text-[#c99106]">SVC-01</span>
                        <span class="rounded-md bg-slate-100 px-2 py-[3px] text-[10px] font-bold text-slate-500">Sistema central</span>
                    </div>
                    <p class="mb-1.5 text-lg font-black text-neutral-950">Portal SICEU</p>
                    <p class="mb-3.5 text-[13px] leading-[18px] text-slate-600">
                        Consulta de calificaciones, récord académico, inscripción de asignaturas, control de asistencia y aulas asignadas.
                    </p>
                    <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 rounded-[14px] bg-unefa-gold py-3.5 text-[15px] font-black text-unefa-navy shadow-md transition hover:brightness-105">
                        Acceder a SICEU
                    </a>
                </div>

                {{-- Servicio 02: Calendario academico --}}
                <div class="rounded-[18px] border border-slate-200 bg-white p-[18px]">
                    <div class="mb-2.5 flex gap-2">
                        <span class="rounded-md bg-slate-100 px-2 py-[3px] text-[10px] font-bold text-slate-500">SVC-02</span>
                        <span class="rounded-md bg-slate-100 px-2 py-[3px] text-[10px] font-bold text-slate-500">Semestre 2026-I</span>
                    </div>
                    <p class="mb-1.5 text-lg font-black text-neutral-950">Calendario oficial</p>
                    <p class="mb-3.5 text-[13px] leading-[18px] text-slate-600">
                        Fechas de inicio de clases, cortes de notas parciales, solicitudes de retiro o adición y actos solemnes de grado.
                    </p>
                    <a href="#inicio" class="flex items-center justify-center gap-2 rounded-[14px] border border-slate-300 py-3.5 text-sm font-bold text-neutral-950 transition hover:bg-slate-50">
                        Consultar fechas
                    </a>
                </div>

                {{-- Servicio 03: Tramites y constancias --}}
                <div class="rounded-[18px] border border-slate-200 bg-white p-[18px]">
                    <div class="mb-2.5 flex gap-2">
                        <span class="rounded-md bg-slate-100 px-2 py-[3px] text-[10px] font-bold text-slate-500">SVC-03</span>
                        <span class="rounded-md bg-slate-100 px-2 py-[3px] text-[10px] font-bold text-slate-500">Trámites</span>
                    </div>
                    <p class="mb-1.5 text-lg font-black text-neutral-950">Constancias en línea</p>
                    <p class="mb-3.5 text-[13px] leading-[18px] text-slate-600">
                        Generación automatizada de constancias de estudio, notas certificadas y cartas de culminación con firma digital.
                    </p>
                    <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 rounded-[14px] border border-slate-300 py-3.5 text-sm font-bold text-neutral-950 transition hover:bg-slate-50">
                        Gestión digital
                    </a>
                </div>

                {{-- Servicio 04: Repositorio institucional --}}
                <div class="rounded-[18px] border border-slate-200 bg-white p-[18px]">
                    <div class="mb-2.5 flex gap-2">
                        <span class="rounded-md bg-slate-100 px-2 py-[3px] text-[10px] font-bold text-slate-500">SVC-04</span>
                        <span class="rounded-md bg-slate-100 px-2 py-[3px] text-[10px] font-bold text-slate-500">Ciencia</span>
                    </div>
                    <p class="mb-1.5 text-lg font-black text-neutral-950">Repositorio y tesis</p>
                    <p class="mb-3.5 text-[13px] leading-[18px] text-slate-600">
                        Acceso público y digital a trabajos especiales de grado, guías metodológicas de ingeniería y revistas de investigación.
                    </p>
                    <a href="#carreras" class="flex items-center justify-center gap-2 rounded-[14px] border border-slate-300 py-3.5 text-sm font-bold text-neutral-950 transition hover:bg-slate-50">
                        Abrir repositorio
                    </a>
                </div>
            </div>
        </section>
    </div>

    @include('partials.footer')
@endsection
