@extends('layouts.public')

@section('title', 'UNEFA — Universidad Nacional Experimental Politécnica de la FANB')
@section('descripcion', 'Portal oficial de la UNEFA. Formación politécnica y cívico-militar con excelencia académica, disciplina y gratuidad total de matrícula en toda Venezuela.')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endpush

@push('scripts')
    <script src="{{ asset('js/landing.js') }}" defer></script>
@endpush

@section('header')
    <!-- Barra institucional superior de alta visibilidad -->
    <div class="sys-status-bar">
        <div class="container">
            <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
                <span style="font-weight: 800; color: var(--unefa-gold);">República Bolivariana de Venezuela</span>
                <span style="opacity: 0.6;">|</span>
                <span>Universidad Nacional Experimental Politécnica de la FANB</span>
            </div>
            <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
                <span class="sys-status-badge">Periodo Académico 2026-I</span>
                <span style="opacity: 0.6;">|</span>
                <span style="font-weight: 700; color: #ffffff;">Portal Institucional</span>
            </div>
        </div>
    </div>

    <!-- Encabezado Principal -->
    <header class="main-header">
        <div class="container header-inner">
            <a href="{{ route('landing') }}" class="brand-group" aria-label="UNEFA Página de inicio">
                <div class="brand-logo-wrap">
                    <img src="{{ asset('img/unefa-logo.webp') }}" alt="Escudo de la UNEFA" width="40" height="40" style="border-radius: 50%;">
                </div>
                <div class="brand-title">
                    <span class="brand-title-main">UNEFA</span>
                    <span class="brand-title-sub">Excelencia Educativa</span>
                </div>
            </a>

            <!-- Navegación de escritorio -->
            <nav class="nav-desktop" aria-label="Menú principal de navegación">
                <a href="#inicio" class="nav-link active">Inicio</a>
                <a href="#nosotros" class="nav-link">La UNEFA</a>
                <a href="#carreras" class="nav-link">Carreras</a>
                <a href="#carnetizacion" class="nav-link">Carnetización</a>
                <a href="#servicios" class="nav-link">Servicios</a>
            </nav>

            <!-- Acciones de encabezado con botones notorios -->
            <div class="header-actions">
                <a href="{{ route('login') }}" class="btn btn-gold btn-sm" aria-label="Acceder al Portal">
                    <span>Portal Web</span>
                    <span aria-hidden="true">→</span>
                </a>
                <button class="mobile-toggle" aria-label="Abrir menú de navegación" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
            </div>
        </div>

        <!-- Menú desplegable para móviles -->
        <div class="mobile-menu" aria-label="Navegación móvil">
            <ul class="mobile-nav-list">
                <li><a href="#inicio" class="mobile-nav-link"><span>Inicio</span> <span>→</span></a></li>
                <li><a href="#nosotros" class="mobile-nav-link"><span>La UNEFA y Doctrina</span> <span>→</span></a></li>
                <li><a href="#carreras" class="mobile-nav-link"><span>Catálogo de Carreras</span> <span>→</span></a></li>
                <li><a href="#carnetizacion" class="mobile-nav-link"><span>Carnetización</span> <span>→</span></a></li>
                <li><a href="#servicios" class="mobile-nav-link"><span>Servicios Digitales</span> <span>→</span></a></li>
                <li style="padding-top: 0.5rem;">
                    <a href="{{ route('registro') }}" class="btn btn-outline btn-lg" style="width: 100%; justify-content: center; margin-bottom: 0.5rem;">
                        <span>Registro de Carnet</span>
                        <span>→</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('login') }}" class="btn btn-gold btn-lg" style="width: 100%; justify-content: center;">
                        <span>Acceder al Portal</span>
                        <span>→</span>
                    </a>
                </li>
            </ul>
        </div>
    </header>
@endsection

@section('content')
    <!-- ── Sección 1: Hero Poster Modular ─────────────────────────────────── -->
    <section id="inicio" class="hero-section">
        <div class="container hero-grid">
            
            <div class="hero-statement">
                <div class="hero-kicker">
                    <span>Universidad de la Fuerza Armada Nacional Bolivariana</span>
                </div>

                <h1 class="text-title-monumental">
                    Excelencia educativa.<br>
                    Disciplina patriótica.<br>
                    <span style="color: var(--unefa-blue);">Matrícula 100% gratuita.</span>
                </h1>

                <p class="hero-desc">
                    Formamos a los ingenieros, técnicos y licenciados que impulsan el desarrollo productivo, científico y soberano de Venezuela, bajo el rigor del método científico y la doctrina cívico-militar.
                </p>

                <!-- Métricas de alto impacto -->
                <div class="hero-metrics-strip">
                    <div class="metric-unit">
                        <span class="metric-value">24</span>
                        <span class="metric-label">Estados con presencia</span>
                    </div>
                    <div class="metric-unit">
                        <span class="metric-value">60+</span>
                        <span class="metric-label">Núcleos y extensiones</span>
                    </div>
                    <div class="metric-unit">
                        <span class="metric-value">0 Bs</span>
                        <span class="metric-label">Costo de matrícula</span>
                    </div>
                </div>

                <!-- Botones de Acción con Alta Visibilidad -->
                <div class="hero-cta-group">
                    <a href="{{ route('login') }}" class="btn btn-gold btn-lg">
                        <span>Acceso al Portal</span>
                        <span aria-hidden="true">→</span>
                    </a>
                    <a href="{{ route('registro') }}" class="btn btn-blue btn-lg">
                        <span>Preinscripción</span>
                        <span aria-hidden="true">→</span>
                    </a>
                    <a href="#carreras" class="btn btn-outline btn-lg">
                        <span>Explorar Carreras</span>
                    </a>
                </div>
            </div>

            <!-- Columna derecha del Hero: Fotografía Técnica -->
            <div class="hero-photo-card">
                <div class="photo-wrapper">
                    <img
                        src="{{ asset('img/laboratorio-electronica.webp') }}"
                        alt="Laboratorio de Electrónica e Ingeniería UNEFA"
                        width="600"
                        height="450"
                    >
                </div>
                <div class="photo-caption-bar">
                    <div>
                        <div class="photo-caption-title">Laboratorios de Alta Tecnología</div>
                        <div class="photo-caption-meta">Investigación aplicada y software crítico</div>
                    </div>
                    <span class="badge-tag accent-blue">Sede Principal</span>
                </div>

                <div class="hero-photo-subgrid">
                    <div class="subgrid-badge">
                        <div class="subgrid-badge-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        </div>
                        <div class="subgrid-badge-text">
                            <strong>Defensa y Soberanía</strong>
                            <span>Doctrina bolivariana</span>
                        </div>
                    </div>
                    <div class="subgrid-badge">
                        <div class="subgrid-badge-icon gold">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>
                        </div>
                        <div class="subgrid-badge-text">
                            <strong>Título Universitario</strong>
                            <span>Reconocimiento oficial</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- ── Sección 2: La UNEFA y sus Pilares ──────────────────────────────── -->
    <section id="nosotros" class="section" style="background-color: var(--bg-secondary);">
        <div class="container">
            
            <div class="section-header">
                <div class="section-header-flex">
                    <div>
                        <div class="section-number">Identidad Institucional</div>
                        <h2 class="text-title-section">
                            Los pilares que forjan a nuestros profesionales
                        </h2>
                    </div>
                    <p style="font-size: 1.1rem; color: var(--text-secondary); max-width: 28rem; line-height: 1.7;">
                        Conoce la doctrina, valores y cobertura territorial que hacen de la UNEFA la mayor universidad técnica del país.
                    </p>
                </div>
            </div>

            <!-- Navegación de Pilares -->
            <div class="pillar-nav-strip" role="tablist" aria-label="Pilares institucionales">
                <button type="button" role="tab" aria-selected="true" class="pillar-tab-btn active" data-pillar="doctrina">
                    Pilar 01 · Disciplina y Excelencia
                </button>
                <button type="button" role="tab" aria-selected="false" class="pillar-tab-btn" data-pillar="gratuidad">
                    Pilar 02 · Gratuidad y Democracia
                </button>
                <button type="button" role="tab" aria-selected="false" class="pillar-tab-btn" data-pillar="presencia">
                    Pilar 03 · Presencia en 24 Estados
                </button>
            </div>

            <!-- Caja de visualización del pilar activo -->
            <div class="explorer-grid" role="tabpanel" tabindex="0" aria-label="Detalle del pilar seleccionado">
                <div class="dossier-photo-bar" style="aspect-ratio: 4 / 3;">
                    <img id="pillarImg" src="{{ asset('img/sede-central.webp') }}" alt="Doctrina UNEFA">
                    <div id="pillarCaption" class="dossier-photo-footer">
                        Patio de Honor · Aula Magna de la UNEFA
                    </div>
                </div>

                <div class="dossier-content">
                    <span id="pillarArea" class="badge-tag accent-blue" style="align-self: flex-start;">Pilar 01</span>
                    <h3 id="pillarTitle" class="text-title-card" style="font-size: 1.7rem;">
                        Excelencia Educativa y Disciplina Cívico-Militar
                    </h3>
                    <p id="pillarDesc" style="font-size: 1.1rem; color: var(--text-secondary); line-height: 1.75;">
                        Una propuesta pedagógica única que une la disciplina del método científico con el sentido patrio y la responsabilidad ciudadana, formando ingenieros y profesionales de carácter inquebrantable.
                    </p>

                    <div>
                        <strong style="display: block; font-size: 1.05rem; margin-bottom: 1rem; color: var(--unefa-navy);">
                            Fundamentos y Principios:
                        </strong>
                        <div id="pillarHighlights" class="competencies-list">
                            <!-- Inyectado por JS -->
                        </div>
                    </div>

                    <div style="margin-top: 1rem;">
                        <a href="#carnetizacion" class="btn btn-outline" style="font-size: 1rem;">
                            <span>Conocer requisitos de carnetización</span>
                            <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- ── Sección 3: Explorador de Carreras (Horizontal) ──────────────────── -->
    <section id="carreras" class="section">
        <div class="container">
            
            <div class="section-header">
                <div class="section-header-flex">
                    <div>
                        <div class="section-number">Oferta Académica</div>
                        <h2 class="text-title-section">
                            Explora nuestras carreras politécnicas
                        </h2>
                    </div>
                    <p style="font-size: 1.1rem; color: var(--text-secondary); max-width: 30rem; line-height: 1.7;">
                        Planes de estudio modernos, avalados por el Ministerio del Poder Popular para la Educación Universitaria y la FANB.
                    </p>
                </div>
            </div>

            <!-- Selector de Facultades (Horizontal) -->
            <div class="faculty-nav-strip" role="tablist" aria-label="Facultades">
                <button type="button" role="tab" aria-selected="true" class="faculty-tab-btn active" data-faculty="ingenieria">
                    Ingenierías
                </button>
                <button type="button" role="tab" aria-selected="false" class="faculty-tab-btn" data-faculty="licenciaturas">
                    Licenciaturas
                </button>
                <button type="button" role="tab" aria-selected="false" class="faculty-tab-btn" data-faculty="tsu">
                    Técnico Superior Universitario (TSU)
                </button>
            </div>

            <!-- Selector Horizontal de Carreras (Sin scroll vertical excesivo) -->
            <div id="careersList" class="career-nav-strip" role="tablist" aria-orientation="horizontal" aria-label="Lista de carreras">
                <!-- Rellenado por JS: Fichas horizontales compactas -->
            </div>

            <!-- Ficha / Dossier Horizontal de la Carrera -->
            <div class="explorer-grid" role="tabpanel" tabindex="0" aria-label="Detalle de la carrera seleccionada">
                
                <div class="dossier-photo-bar" style="aspect-ratio: 4 / 3;">
                    <img id="dossierImg" src="{{ asset('img/carrera-sistemas.webp') }}" alt="Área académica de la carrera">
                    <div id="dossierCode" class="dossier-photo-tag">ING-SIS-10</div>
                    <div class="dossier-photo-footer">
                        <span id="dossierDegree">Ingeniero de Sistemas</span>
                        <span id="dossierDuration" style="color: var(--unefa-gold); font-weight: 800;">10 Semestres</span>
                    </div>
                </div>

                <div class="dossier-content">
                    <div>
                        <span class="badge-tag accent-blue" style="margin-bottom: 0.6rem;">Pensum Oficial 2026</span>
                        <h3 id="dossierTitle" class="text-title-card" style="font-size: 1.7rem; margin-bottom: 0.75rem;">
                            Ingeniería de Sistemas
                        </h3>
                        <p id="dossierDesc" style="font-size: 1.05rem; color: var(--text-secondary); line-height: 1.7;">
                            Formación en ingeniería de software crítico, arquitectura de sistemas distribuidos, bases de datos masivas, ciberseguridad y computación para la defensa y el desarrollo soberano de la nación.
                        </p>
                    </div>

                    <div>
                        <strong style="display: block; font-size: 1.05rem; margin-bottom: 0.85rem; color: var(--unefa-navy);">
                            Competencias Principales del Egresado:
                        </strong>
                        <div id="dossierCompetencies" class="competencies-list">
                            <!-- Inyectado por JS -->
                        </div>
                    </div>

                    <div>
                        <strong style="display: block; font-size: 1.05rem; margin-bottom: 0.75rem; color: var(--unefa-navy);">
                            Asignaturas Clave de la Malla:
                        </strong>
                        <div id="dossierSubjects" class="subjects-wrap">
                            <!-- Inyectado por JS -->
                        </div>
                    </div>

                    <div style="padding-top: 1.25rem; border-top: 2px solid var(--border-subtle); display: flex; gap: 1rem; flex-wrap: wrap;">
                        <a href="{{ route('registro') }}" class="btn btn-gold btn-lg">
                            <span>Registrarme con esta carrera</span>
                            <span aria-hidden="true">→</span>
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline btn-lg">
                            <span>Acceso al Portal</span>
                            <span aria-hidden="true">→</span>
                        </a>
                        <a href="#servicios" class="btn btn-outline btn-lg">
                            <span>Servicios estudiantiles</span>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- ── Sección 4: Carnetización y Control de Asistencias ───────────────── -->
    <section id="carnetizacion" class="section" style="background-color: var(--bg-secondary);">
        <div class="container">
            
            <div class="section-header">
                <div class="section-header-flex">
                    <div>
                        <div class="section-number">Carnetización &amp; Asistencias</div>
                        <h2 class="text-title-section">
                            Activación de carnet digital y registro estudiantil
                        </h2>
                    </div>
                    <p style="font-size: 1.1rem; color: var(--text-secondary); max-width: 32rem; line-height: 1.7;">
                        Plataforma dirigida a estudiantes regulares y cursantes que ya aprobaron el Curso Introductorio. Verifica tus recaudos para emitir tu carnet digital con QR y habilitar el pase de asistencia.
                    </p>
                </div>
            </div>

            <div class="calc-grid">
                
                <!-- Columna Izquierda: Fases de Activación e Instalaciones -->
                <div>
                    <div class="timeline-dossier">
                        <div class="timeline-step">
                            <span class="timeline-num">01</span>
                            <div class="timeline-body">
                                <strong>Curso Introductorio Aprobado / Estatus Regular</strong>
                                <p>Haber aprobado satisfactoriamente el Curso Introductorio de Nivelación o mantener condición de estudiante regular activo.</p>
                            </div>
                        </div>
                        <div class="timeline-step">
                            <span class="timeline-num">02</span>
                            <div class="timeline-body">
                                <strong>Registro en la Plataforma</strong>
                                <p>Carga de información personal, cédula de identidad, sede de estudio y carrera politécnica asignada.</p>
                            </div>
                        </div>
                        <div class="timeline-step">
                            <span class="timeline-num">03</span>
                            <div class="timeline-body">
                                <strong>Validación de Recaudos</strong>
                                <p>Verificación de la constancia de aprobación del Curso Introductorio y matrícula activa en la coordinación académica.</p>
                            </div>
                        </div>
                        <div class="timeline-step">
                            <span class="timeline-num">04</span>
                            <div class="timeline-body">
                                <strong>Emisión de Carnet QR</strong>
                                <p>Activación de tu credencial digital segura para el registro de asistencia en tiempo real en cada clase.</p>
                            </div>
                        </div>
                    </div>

                    <div class="dossier-photo-bar" style="margin-top: 1.5rem; border-radius: var(--radius-md); aspect-ratio: 16 / 9;">
                        <img src="{{ asset('img/sede-central.webp') }}" alt="Instalaciones de la UNEFA">
                        <div class="dossier-photo-footer">
                            <span>Control de Asistencia Digital</span>
                            <span style="color: var(--unefa-gold); font-weight: 800;">Código QR Seguro</span>
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha: Verificador Interactivo de Recaudos -->
                <div class="interactive-box">
                    <div class="calc-progress-header">
                        <div>
                            <span class="badge-tag accent-blue" style="margin-bottom: 0.5rem;">Herramienta del Cursante</span>
                            <h3 class="text-title-card" style="font-size: 1.5rem;">Verificador de Recaudos para Carnetización</h3>
                        </div>
                        <div class="text-right">
                            <div id="porcentaje-recaudos" class="calc-percentage">50%</div>
                            <span style="font-size: 0.8rem; color: var(--text-muted); font-weight: 700;">Listo para consignar</span>
                        </div>
                    </div>

                    <div class="calc-progress-bar-bg">
                        <div id="barra-recaudos" class="calc-progress-bar-fill" style="width: 50%;"></div>
                    </div>

                    <p style="font-size: 0.95rem; color: var(--text-secondary); margin-bottom: 1.25rem;">
                        Marca los recaudos que posees para tramitar tu carnet digital y habilitar tu control de asistencias:
                    </p>

                    <div class="checklist-group">
                        <label class="check-item-label checked">
                            <div style="display: flex; align-items: center;">
                                <input type="checkbox" style="display: none;" checked>
                                <span class="custom-checkbox">✓</span>
                                <span>Cédula de identidad laminada y 2 fotocopias legibles</span>
                            </div>
                            <span class="badge-tag" style="font-size: 0.75rem;">Fase 1</span>
                        </label>
                        <label class="check-item-label checked">
                            <div style="display: flex; align-items: center;">
                                <input type="checkbox" style="display: none;" checked>
                                <span class="custom-checkbox">✓</span>
                                <span>Constancia o certificación de aprobación del Curso Introductorio</span>
                            </div>
                            <span class="badge-tag" style="font-size: 0.75rem;">Fase 1</span>
                        </label>
                        <label class="check-item-label checked">
                            <div style="display: flex; align-items: center;">
                                <input type="checkbox" style="display: none;" checked>
                                <span class="custom-checkbox">✓</span>
                                <span>Planilla de asignación de carrera o comprobante de matrícula</span>
                            </div>
                            <span class="badge-tag" style="font-size: 0.75rem;">Fase 2</span>
                        </label>
                        <label class="check-item-label">
                            <div style="display: flex; align-items: center;">
                                <input type="checkbox" style="display: none;">
                                <span class="custom-checkbox"></span>
                                <span>Fotografía digital fondo blanco para el carnet QR</span>
                            </div>
                            <span class="badge-tag" style="font-size: 0.75rem;">Fase 2</span>
                        </label>
                        <label class="check-item-label">
                            <div style="display: flex; align-items: center;">
                                <input type="checkbox" style="display: none;">
                                <span class="custom-checkbox"></span>
                                <span>Copia simple de partida de nacimiento y título de bachiller</span>
                            </div>
                            <span class="badge-tag" style="font-size: 0.75rem;">Fase 3</span>
                        </label>
                        <label class="check-item-label">
                            <div style="display: flex; align-items: center;">
                                <input type="checkbox" style="display: none;">
                                <span class="custom-checkbox"></span>
                                <span>Horario o constancia de materias inscritas del período</span>
                            </div>
                            <span class="badge-tag" style="font-size: 0.75rem;">Fase 3</span>
                        </label>
                    </div>

                    <p id="texto-mensaje-recaudos" style="text-align: center; font-size: 0.95rem; font-weight: 700; color: var(--unefa-blue); margin-bottom: 1.25rem;">
                        Tienes 3 de 6 recaudos completados.
                    </p>

                    <a href="{{ route('registro') }}" class="btn btn-gold btn-lg" style="width: 100%; justify-content: center;">
                        <span>Iniciar registro de carnetización</span>
                        <span aria-hidden="true">→</span>
                    </a>

                    <p style="text-align: center; font-size: 0.82rem; color: var(--text-muted); margin-top: 1rem; display: flex; align-items: center; justify-content: center; gap: 0.4rem;">
                        @include('partials.icon', ['name' => 'shield-check', 'clase' => 'h-4 w-4 text-slate-500'])
                        Sistema de Carnetización y Asistencias Digitales · UNEFA
                    </p>
                </div>

            </div>

        </div>
    </section>

    <!-- ── Sección 5: Servicios Digitales ─────────────────────────────────── -->
    <section id="servicios" class="section">
        <div class="container">
            
            <div class="section-header">
                <div class="section-header-flex">
                    <div>
                        <div class="section-number">Ecosistema Digital</div>
                        <h2 class="text-title-section">
                            Plataformas de gestión académica y estudiantil
                        </h2>
                    </div>
                    <p style="font-size: 1.1rem; color: var(--text-secondary); max-width: 28rem; line-height: 1.7;">
                        Herramientas tecnológicas disponibles 24/7 para toda la comunidad universitaria unefista.
                    </p>
                </div>
            </div>

            <div class="services-quad-grid">
                
                <div class="service-quad-cell">
                    <div>
                        <span class="badge-tag accent-gold" style="margin-bottom: 1.2rem;">Portal Académico</span>
                        <h3 class="text-title-card" style="font-size: 1.4rem; margin-bottom: 0.75rem;">
                            Control de Estudios en Línea
                        </h3>
                        <p style="font-size: 1rem; color: var(--text-secondary); line-height: 1.65; margin-bottom: 1.75rem;">
                            Consulta de calificaciones parciales, constancias de estudio con firma digital, horarios semanales y récord acumulado.
                        </p>
                    </div>
                    <a href="{{ route('login') }}" class="btn btn-gold btn-sm" style="width: 100%; justify-content: center;">
                        <span>Acceder al Portal</span>
                        <span aria-hidden="true">→</span>
                    </a>
                </div>

                <div class="service-quad-cell">
                    <div>
                        <span class="badge-tag accent-blue" style="margin-bottom: 1.2rem;">Carnet Digital</span>
                        <h3 class="text-title-card" style="font-size: 1.4rem; margin-bottom: 0.75rem;">
                            Asistencia por Código QR
                        </h3>
                        <p style="font-size: 1rem; color: var(--text-secondary); line-height: 1.65; margin-bottom: 1.75rem;">
                            Identificación digital institucional con pase de lista en tiempo real mediante aplicación móvil y código QR seguro.
                        </p>
                    </div>
                    <a href="{{ route('login') }}" class="btn btn-blue btn-sm" style="width: 100%; justify-content: center;">
                        <span>Consultar Carnet</span>
                        <span aria-hidden="true">→</span>
                    </a>
                </div>

                <div class="service-quad-cell">
                    <div>
                        <span class="badge-tag" style="margin-bottom: 1.2rem;">Trámites</span>
                        <h3 class="text-title-card" style="font-size: 1.4rem; margin-bottom: 0.75rem;">
                            Constancias de Estudio
                        </h3>
                        <p style="font-size: 1rem; color: var(--text-secondary); line-height: 1.65; margin-bottom: 1.75rem;">
                            Generación de constancias de estudio, notas certificadas y cartas de culminación con firma digital institucional.
                        </p>
                    </div>
                    <a href="{{ route('login') }}" class="btn btn-outline btn-sm" style="width: 100%; justify-content: center;">
                        <span>Gestionar trámites</span>
                        <span aria-hidden="true">→</span>
                    </a>
                </div>

                <div class="service-quad-cell">
                    <div>
                        <span class="badge-tag" style="margin-bottom: 1.2rem;">Biblioteca Virtual</span>
                        <h3 class="text-title-card" style="font-size: 1.4rem; margin-bottom: 0.75rem;">
                            Repositorio Académico
                        </h3>
                        <p style="font-size: 1rem; color: var(--text-secondary); line-height: 1.65; margin-bottom: 1.75rem;">
                            Acceso a libros de texto de ingeniería, proyectos de grado, guías de laboratorio y documentos de soberanía nacional.
                        </p>
                    </div>
                    <a href="{{ route('login') }}" class="btn btn-outline btn-sm" style="width: 100%; justify-content: center;">
                        <span>Explorar Repositorio</span>
                        <span aria-hidden="true">→</span>
                    </a>
                </div>

            </div>

        </div>
    </section>
@endsection

@section('footer')
    <!-- ── Pie de Página Principal ─────────────────────────────────────────── -->
    <footer class="main-footer">
        <div class="container">
            
            <div class="footer-grid">
                
                <div class="footer-col">
                    <div style="display: flex; align-items: center; gap: 0.85rem; margin-bottom: 1.25rem;">
                        <img src="{{ asset('img/unefa-logo.webp') }}" alt="Logo UNEFA" width="40" height="40" style="border-radius: 50%;">
                        <div>
                            <span style="font-size: 1.35rem; font-weight: 900; letter-spacing: 0.12em; color: #ffffff;">UNEFA</span>
                            <span style="display: block; font-size: 0.72rem; color: var(--unefa-gold); font-weight: 800; letter-spacing: 0.08em; text-transform: uppercase;">
                                Universidad de la FANB
                            </span>
                        </div>
                    </div>
                    <p style="font-size: 1rem; color: #cbd5e1; line-height: 1.7; margin-bottom: 1.75rem;">
                        Universidad Nacional Experimental Politécnica de la Fuerza Armada Nacional Bolivariana. Excelencia educativa abierta al pueblo con presencia soberana en toda Venezuela.
                    </p>
                    <a href="{{ route('login') }}" class="btn btn-gold btn-sm">
                        <span>Acceso al Portal</span>
                        <span aria-hidden="true">→</span>
                    </a>
                </div>

                <div class="footer-col">
                    <h4>Navegación</h4>
                    <ul class="footer-links">
                        <li><a href="#inicio">Inicio</a></li>
                        <li><a href="#nosotros">La UNEFA</a></li>
                        <li><a href="#carreras">Carreras</a></li>
                        <li><a href="#carnetizacion">Carnetización</a></li>
                        <li><a href="#servicios">Servicios</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Plataformas Académicas</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('login') }}">Portal Estudiantes</a></li>
                        <li><a href="{{ route('login') }}">Portal Docentes y Cátedras</a></li>
                        <li><a href="{{ route('registro') }}">Registro de Carnet Digital</a></li>
                        <li><a href="#servicios">Carnetización y Asistencia QR</a></li>
                        <li><a href="#servicios">Biblioteca virtual</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Sede Central</h4>
                    <p style="font-size: 0.98rem; color: #cbd5e1; line-height: 1.75;">
                        Edificio Sede UNEFA, Chuao.<br>
                        Caracas, República Bolivariana de Venezuela.<br><br>
                        <strong>Atención Central:</strong><br>
                        +58 (0212) 908-2000<br>
                        soporte@unefa.edu.ve
                    </p>
                </div>

            </div>

            <div class="footer-sub">
                <span>© 2026 UNEFA — Universidad Nacional Experimental Politécnica de la FANB. Todos los derechos reservados.</span>
                <span>Caracas, Venezuela · República Bolivariana de Venezuela</span>
            </div>

        </div>
    </footer>
@endsection
