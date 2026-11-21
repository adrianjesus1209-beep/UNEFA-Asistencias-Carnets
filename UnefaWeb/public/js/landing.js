/**
 * UNIVERSIDAD NACIONAL EXPERIMENTAL POLITÉCNICA DE LA FANB (UNEFA)
 * Controlador de la Página Principal / Landing (Blade UNEFA)
 */

(function () {
  "use strict";

  /* ── 1. Menú Móvil ─────────────────────────────────────────────────────── */
  function initMobileMenu() {
    const toggle = document.querySelector(".mobile-toggle");
    const menu = document.querySelector(".mobile-menu");
    if (!toggle || !menu) return;

    toggle.addEventListener("click", () => {
      const isOpen = menu.classList.toggle("open");
      toggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
    });

    const links = menu.querySelectorAll("a");
    links.forEach((l) => {
      l.addEventListener("click", () => {
        menu.classList.remove("open");
        toggle.setAttribute("aria-expanded", "false");
      });
    });
  }

  /* ── 2. Datos y Lógica del Explorador de Carreras ──────────────────────── */
  const CAREERS_DATA = {
    ingenieria: [
      {
        id: "sistemas",
        code: "ING-SIS-10",
        title: "Ingeniería de Sistemas",
        duration: "10 Semestres (5 Años)",
        degree: "Ingeniero de Sistemas",
        image: "/img/carrera-sistemas.webp",
        description: "Formación en ingeniería de software crítico, arquitectura de sistemas distribuidos, bases de datos masivas, ciberseguridad y computación para la defensa y el desarrollo soberano de la nación.",
        competencies: [
          "Desarrollo de software de misión crítica",
          "Ciberseguridad y soberanía tecnológica",
          "Modelado matemático e inteligencia artificial",
          "Gestión de infraestructuras del Estado"
        ],
        subjects: ["Algoritmos y Estructuras", "Bases de Datos Masivas", "Redes y Teleproceso", "Ingeniería de Software", "Sistemas Operativos"]
      },
      {
        id: "telecom",
        code: "ING-TEL-10",
        title: "Ingeniería de Telecomunicaciones",
        duration: "10 Semestres (5 Años)",
        degree: "Ingeniero de Telecomunicaciones",
        image: "/img/carrera-telecomunicaciones.webp",
        description: "Especialistas en transmisión por fibra óptica, microondas, enlaces satelitales civiles y militares, antenas y procesamiento digital de señales para redes estratégicas.",
        competencies: [
          "Diseño de redes de comunicación nacional",
          "Operación de estaciones terrenas y satélites",
          "Propagación electromagnética y microondas",
          "Protocolos seguros de enrutamiento"
        ],
        subjects: ["Líneas de Transmisión", "Comunicaciones Digitales", "Sistemas Satelitales", "Fibra Óptica", "Telefonía IP"]
      },
      {
        id: "mecanica",
        code: "ING-MEC-10",
        title: "Ingeniería Mecánica",
        duration: "10 Semestres (5 Años)",
        degree: "Ingeniero Mecánico",
        image: "/img/laboratorio-mecatronica.webp",
        description: "Diseño, manufactura y mantenimiento de maquinaria pesada, sistemas térmicos, turbinas y estructuras mecánicas para la industria petrolera, naval e industrial venezolana.",
        competencies: [
          "Diseño asistido por computadora (CAD/CAM)",
          "Termodinámica aplicada y fluidodinámica",
          "Mantenimiento de plantas industriales",
          "Metalurgia y resistencia de materiales"
        ],
        subjects: ["Termodinámica", "Mecánica de Fluidos", "Diseño de Elementos", "Plantas de Potencia", "Vibraciones Mecánicas"]
      },
      {
        id: "electronica",
        code: "ING-ELE-10",
        title: "Ingeniería Electrónica",
        duration: "10 Semestres (5 Años)",
        degree: "Ingeniero Electrónico",
        image: "/img/laboratorio-electronica.webp",
        description: "Automatización industrial, instrumentación electrónica, sistemas embebidos, procesamiento de señales y desarrollo de hardware para la soberanía tecnológica e industrial.",
        competencies: [
          "Diseño de sistemas electrónicos y microcontroladores",
          "Automatización y control de procesos industriales",
          "Mantenimiento de sistemas de radar y comunicaciones",
          "Robótica e instrumentación biomédica e industrial"
        ],
        subjects: ["Circuitos Electrónicos", "Sistemas de Control", "Microprocesadores", "Instrumentación Industrial", "Electrónica de Potencia"]
      }
    ],
    licenciaturas: [
      {
        id: "administracion",
        code: "LIC-AGM-08",
        title: "Administración y Gestión Municipal",
        duration: "8 Semestres (4 Años)",
        degree: "Licenciado en Administración y Gestión Municipal",
        image: "/img/carrera-administracion.webp",
        description: "Planificación pública, presupuestos estatales, auditoría gubernamental y gobernanza de corporaciones municipales con probidad y transparencia bolivariana.",
        competencies: [
          "Formulación presupuestaria del sector público",
          "Control de gestión y auditoría fiscal",
          "Desarrollo socioeconómico comunal",
          "Administración de personal y talento"
        ],
        subjects: ["Contabilidad Pública", "Presupuesto Nacional", "Derecho Administrativo", "Planificación Estratégica", "Políticas Públicas"]
      },
      {
        id: "desastres",
        code: "LIC-ADD-08",
        title: "Administración de Desastres",
        duration: "8 Semestres (4 Años)",
        degree: "Licenciado en Administración de Desastres",
        image: "/img/sede-central.webp",
        description: "Gestión integral del riesgo socio-natural y tecnológico, formulación de planes de contingencia, defensa civil, respuesta humanitaria y resiliencia territorial ante eventos adversos.",
        competencies: [
          "Evaluación y cartografía de riesgos y amenazas",
          "Coordinación táctica de protección civil y rescate",
          "Logística humanitaria y refugios temporales",
          "Manejo de crisis y continuidad operativa institucional"
        ],
        subjects: ["Gestión Integral de Riesgo", "Protección Civil y Rescate", "Meteorología y Sismología", "Logística Humanitaria", "Primeros Auxilios Avanzados"]
      },
      {
        id: "economia",
        code: "LIC-ECO-08",
        title: "Economía Social",
        duration: "8 Semestres (4 Años)",
        degree: "Licenciado en Economía Social",
        image: "/img/carrera-administracion.webp",
        description: "Análisis macroeconómico, proyectos socioproductivos, soberanía agroalimentaria y modelos alternativos de distribución de riqueza comunitaria.",
        competencies: [
          "Evaluación de proyectos de inversión socioproductiva",
          "Modelos económicos comunales y cooperativos",
          "Econometría y estadística social aplicada",
          "Comercio exterior e integración regional soberana"
        ],
        subjects: ["Microeconomía", "Macroeconomía", "Econometría Social", "Desarrollo Endógeno", "Finanzas Públicas"]
      },
      {
        id: "educacion",
        code: "LIC-EDU-08",
        title: "Educación Integral",
        duration: "8 Semestres (4 Años)",
        degree: "Licenciado en Educación Integral",
        image: "/img/sede-central.webp",
        description: "Formación docente con sentido cívico, didáctica contemporánea, diseño curricular contextualizado e investigación pedagógica para la enseñanza en los niveles de educación básica.",
        competencies: [
          "Didáctica aplicada y procesos cognitivos del aprendizaje",
          "Planificación y evaluación curricular por competencias",
          "Orientación educativa, vocacional y comunitaria",
          "Promoción de valores éticos, cívicos y patrióticos"
        ],
        subjects: ["Pedagogía y Didáctica", "Psicología del Aprendizaje", "Enseñanza de la Lengua y Matemática", "Planificación Educativa", "Práctica Docente"]
      }
    ],
    tsu: [
      {
        id: "tsu-sistemas",
        code: "TSU-ADS-06",
        title: "TSU en Análisis y Diseño de Sistemas / Datos",
        duration: "6 Semestres (3 Años)",
        degree: "Técnico Superior Universitario en Sistemas y Datos",
        image: "/img/carrera-tsu-sistemas.webp",
        description: "Desarrollo ágil de software, modelado y análisis de datos relacionales y no estructurados, soporte de servidores Linux y administración de redes informáticas institucionales.",
        competencies: [
          "Desarrollo web fullstack y consumo de APIs",
          "Modelado, limpieza y análisis de bases de datos",
          "Administración de redes locales y soporte técnico",
          "Implementación de políticas de respaldo y seguridad"
        ],
        subjects: ["Algoritmos y Programación", "Bases de Datos y SQL", "Análisis y Modelado de Datos", "Redes de Computadoras", "Sistemas Operativos"]
      }
    ]
  };

  function initCareerExplorer() {
    let currentFaculty = "ingenieria";
    let currentCareerId = "sistemas";

    const facultyBtns = document.querySelectorAll(".faculty-tab-btn");
    const careersList = document.getElementById("careersList");
    const dossierImg = document.getElementById("dossierImg");
    const dossierCode = document.getElementById("dossierCode");
    const dossierDegree = document.getElementById("dossierDegree");
    const dossierDuration = document.getElementById("dossierDuration");
    const dossierTitle = document.getElementById("dossierTitle");
    const dossierDesc = document.getElementById("dossierDesc");
    const dossierCompetencies = document.getElementById("dossierCompetencies");
    const dossierSubjects = document.getElementById("dossierSubjects");

    if (!careersList) return;

    function renderCareersList() {
      const careers = CAREERS_DATA[currentFaculty] || [];
      careersList.innerHTML = "";

      careers.forEach((career) => {
        const btn = document.createElement("button");
        btn.type = "button";
        btn.setAttribute("role", "tab");
        btn.setAttribute("aria-selected", career.id === currentCareerId ? "true" : "false");
        btn.className = `career-item-btn ${career.id === currentCareerId ? "active" : ""}`;
        btn.dataset.id = career.id;

        btn.innerHTML = `
          <div class="career-item-code">
            <span>${career.code}</span>
            <span>${career.duration.split(" ")[0]} Sem.</span>
          </div>
          <div class="career-item-name">${career.title}</div>
        `;

        btn.addEventListener("click", () => {
          currentCareerId = career.id;
          renderCareersList();
          renderDossier();
        });

        careersList.appendChild(btn);
      });
    }

    function renderDossier() {
      const careers = CAREERS_DATA[currentFaculty] || [];
      const career = careers.find((c) => c.id === currentCareerId) || careers[0];
      if (!career) return;

      currentCareerId = career.id;

      if (dossierImg) dossierImg.src = career.image;
      if (dossierCode) dossierCode.textContent = career.code;
      if (dossierDegree) dossierDegree.textContent = career.degree;
      if (dossierDuration) dossierDuration.textContent = career.duration;
      if (dossierTitle) dossierTitle.textContent = career.title;
      if (dossierDesc) dossierDesc.textContent = career.description;

      if (dossierCompetencies) {
        dossierCompetencies.innerHTML = career.competencies
          .map(
            (comp) => `
          <div class="competency-item">
            <span class="competency-bullet"></span>
            <span>${comp}</span>
          </div>
        `
          )
          .join("");
      }

      if (dossierSubjects) {
        dossierSubjects.innerHTML = career.subjects
          .map((sub) => `<span class="subject-chip">${sub}</span>`)
          .join("");
      }
    }

    facultyBtns.forEach((btn) => {
      btn.addEventListener("click", () => {
        currentFaculty = btn.dataset.faculty;
        facultyBtns.forEach((b) => {
          const isActive = b.dataset.faculty === currentFaculty;
          b.classList.toggle("active", isActive);
          b.setAttribute("aria-selected", isActive ? "true" : "false");
        });
        const first = (CAREERS_DATA[currentFaculty] || [])[0];
        if (first) currentCareerId = first.id;
        renderCareersList();
        renderDossier();
      });
    });

    renderCareersList();
    renderDossier();
  }

  /* ── 3. Datos y Lógica de Doctrina y Pilares ──────────────────────────── */
  const PILLARS_DATA = [
    {
      id: "doctrina",
      tag: "Pilar 01",
      title: "Excelencia Educativa y Disciplina Cívico-Militar",
      desc: "Una propuesta pedagógica única que une la disciplina del método científico con el sentido patrio y la responsabilidad ciudadana, formando ingenieros y profesionales de carácter inquebrantable.",
      image: "/img/sede-central.webp",
      caption: "Patio de Honor · Aula Magna de la UNEFA",
      highlights: [
        "Formación integral cívico-militar y ética patriótica",
        "Rigurosidad metodológica en ciencias aplicadas",
        "Cátedra Bolivariana de liderazgo social y comunitario",
        "Acatamiento del código de disciplina y orden cerrado"
      ]
    },
    {
      id: "gratuidad",
      tag: "Pilar 02",
      title: "Educación Universitaria Pública y 100% Gratuita",
      desc: "Garantizamos el acceso democrático y universal a la educación técnica y superior sin aranceles de matrícula. El talento y la vocación son los únicos requisitos para ingresar y graduarse.",
      image: "/img/laboratorio-electronica.webp",
      caption: "Comunidad Universitaria · Acceso Universal",
      highlights: [
        "Cero aranceles de inscripción o mensualidades",
        "Comedor universitario subsidiado en todos los núcleos",
        "Laboratorios tecnológicos abiertos e internet institucional",
        "Expedición de títulos y actas sin aranceles abusivos"
      ]
    },
    {
      id: "presencia",
      tag: "Pilar 03",
      title: "Presencia Estratégica en los 24 Estados del País",
      desc: "Nuestra red de núcleos y extensiones abraza toda la geografía nacional, llevando carreras politécnicas de punta a comunidades urbanas, rurales, costeras y fronterizas.",
      image: "/img/laboratorio-mecatronica.webp",
      caption: "Red Nacional de Núcleos · Presencia Soberana",
      highlights: [
        "Más de 60 sedes entre núcleos, extensiones y aulas anexas",
        "Planes de estudio adaptados al aparato productivo regional",
        "Alianzas directas con empresas e industrias del Estado",
        "Movilidad académica entre sedes de todo el país"
      ]
    }
  ];

  function initPillars() {
    const tabBtns = document.querySelectorAll(".pillar-tab-btn");
    const pillarImg = document.getElementById("pillarImg");
    const pillarCaption = document.getElementById("pillarCaption");
    const pillarArea = document.getElementById("pillarArea");
    const pillarTitle = document.getElementById("pillarTitle");
    const pillarDesc = document.getElementById("pillarDesc");
    const pillarHighlights = document.getElementById("pillarHighlights");

    if (!tabBtns.length) return;

    function renderPillar(id) {
      const data = PILLARS_DATA.find((p) => p.id === id) || PILLARS_DATA[0];
      if (!data) return;

      if (pillarImg) pillarImg.src = data.image;
      if (pillarCaption) pillarCaption.textContent = data.caption;
      if (pillarArea) pillarArea.textContent = data.tag;
      if (pillarTitle) pillarTitle.textContent = data.title;
      if (pillarDesc) pillarDesc.textContent = data.desc;

      if (pillarHighlights) {
        pillarHighlights.innerHTML = data.highlights
          .map(
            (h) => `
          <div class="competency-item">
            <span class="competency-bullet"></span>
            <span>${h}</span>
          </div>
        `
          )
          .join("");
      }
    }

    tabBtns.forEach((btn) => {
      btn.addEventListener("click", () => {
        const pillarId = btn.dataset.pillar;
        tabBtns.forEach((b) => {
          const isActive = b.dataset.pillar === pillarId;
          b.classList.toggle("active", isActive);
          b.setAttribute("aria-selected", isActive ? "true" : "false");
        });
        renderPillar(pillarId);
      });
    });

    renderPillar("doctrina");
  }

  /* ── 4. Verificador de Recaudos (Admisiones) ───────────────────────────── */
  function initAdmissionsChecklist() {
    const checkLabels = document.querySelectorAll(".check-item-label");
    const bar = document.getElementById("barra-recaudos");
    const percentage = document.getElementById("porcentaje-recaudos");
    const message = document.getElementById("texto-mensaje-recaudos");

    if (!checkLabels.length) return;

    function updateProgress() {
      let completed = 0;
      checkLabels.forEach((label) => {
        const input = label.querySelector('input[type="checkbox"]');
        const customCheck = label.querySelector(".custom-checkbox");
        if (input && input.checked) {
          completed++;
          label.classList.add("checked");
          if (customCheck) customCheck.textContent = "✓";
        } else {
          label.classList.remove("checked");
          if (customCheck) customCheck.textContent = "";
        }
      });

      const total = checkLabels.length;
      const pct = total > 0 ? Math.round((completed / total) * 100) : 0;
      if (bar) bar.style.width = pct + "%";
      if (percentage) percentage.textContent = pct + "%";
      if (message) {
        message.textContent =
          pct === 100
            ? "Excelente. Ya tienes todos los recaudos completos para consignar."
            : `Tienes ${completed} de ${total} recaudos completados.`;
      }
    }

    checkLabels.forEach((label) => {
      const input = label.querySelector('input[type="checkbox"]');
      if (input) {
        input.addEventListener("change", updateProgress);
      }
    });

    updateProgress();
  }

  /* ── Inicialización ───────────────────────────────────────────────────── */
  document.addEventListener("DOMContentLoaded", () => {
    initMobileMenu();
    initCareerExplorer();
    initPillars();
    initAdmissionsChecklist();
  });
})();
