/**
 * UNIVERSIDAD NACIONAL EXPERIMENTAL POLITÉCNICA DE LA FANB (UNEFA)
 * Controlador de la Página Principal / Landing
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
        image: "../public/img/carrera-sistemas.webp",
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
        image: "../public/img/carrera-telecomunicaciones.webp",
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
        image: "../public/img/laboratorio-mecatronica.webp",
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
        id: "aeronautica",
        code: "ING-AER-10",
        title: "Ingeniería Aeronáutica",
        duration: "10 Semestres (5 Años)",
        degree: "Ingeniero Aeronáutico",
        image: "../public/img/laboratorio-electronica.webp",
        description: "Mantenimiento mayor de aeronaves, propulsión a reacción, aviónica y certificación aeroespacial con enfoque en soberanía de la aviación militar y comercial.",
        competencies: [
          "Mantenimiento de aeronaves y turbinas",
          "Sistemas de navegación y aviónica",
          "Aerodinámica teórica y experimental",
          "Regulaciones aeronáuticas INAC/OACI"
        ],
        subjects: ["Aerodinámica", "Estructuras Aeronáuticas", "Turborreactores", "Aviónica", "Instrumentación de Vuelo"]
      }
    ],
    sociales: [
      {
        id: "administracion",
        code: "LIC-AGM-08",
        title: "Licenciatura en Administración y Gestión Municipal",
        duration: "8 Semestres (4 Años)",
        degree: "Licenciado en Administración y Gestión Municipal",
        image: "../public/img/carrera-administracion.webp",
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
        id: "economia",
        code: "LIC-ECO-08",
        title: "Licenciatura en Economía Social",
        duration: "8 Semestres (4 Años)",
        degree: "Licenciado en Economía Social",
        image: "../public/img/carrera-administracion.webp",
        description: "Análisis macroeconómico, proyectos socioproductivos, soberanía agroalimentaria y modelos alternativos de distribución de riqueza comunitaria.",
        competencies: [
          "Evaluación de proyectos de inversión",
          "Modelos económicos comunitarios",
          "Econometría y estadística social",
          "Comercio exterior soberano"
        ],
        subjects: ["Microeconomía", "Macroeconomía", "Econometría", "Desarrollo Endógeno", "Finanzas Públicas"]
      },
      {
        id: "turismo",
        code: "LIC-TUR-08",
        title: "Licenciatura en Turismo",
        duration: "8 Semestres (4 Años)",
        degree: "Licenciado en Turismo",
        image: "../public/img/sede-central.webp",
        description: "Gestión sustentable de patrimonios naturales, hotelería ecosocialista, guiatura especializada y mercadotecnia turística internacional.",
        competencies: [
          "Diseño de rutas ecoturísticas patrimoniales",
          "Administración hotelera y recreativa",
          "Planificación de destinos sustentables",
          "Idiomas y relaciones públicas"
        ],
        subjects: ["Geografía Turística", "Patrimonio Cultural", "Gestión Hotelera", "Ecoturismo", "Comercialización Turística"]
      }
    ],
    tsu: [
      {
        id: "tsu-sistemas",
        code: "TSU-SIS-06",
        title: "TSU en Análisis y Diseño de Sistemas",
        duration: "6 Semestres (3 Años)",
        degree: "Técnico Superior Universitario en Sistemas",
        image: "../public/img/carrera-tsu-sistemas.webp",
        description: "Desarrollo rápido de aplicaciones, administración de redes locales, soporte de servidores Linux y mantenimiento de parques informáticos institucionales.",
        competencies: [
          "Programación web y bases de datos SQL",
          "Soporte técnico y cableado estructurado",
          "Configuración de servidores de red",
          "Seguridad en puestos de trabajo"
        ],
        subjects: ["Algorítmica", "Base de Datos", "Redes de Datos", "Sistemas Operativos", "Desarrollo de Software"]
      },
      {
        id: "tsu-enfermeria",
        code: "TSU-ENF-06",
        title: "TSU en Enfermería",
        duration: "6 Semestres (3 Años)",
        degree: "Técnico Superior Universitario en Enfermería",
        image: "../public/img/carrera-enfermeria.webp",
        description: "Atención primaria en salud, enfermería comunitaria, soporte de urgencias en hospitales militares y red de salud pública nacional.",
        competencies: [
          "Atención directa al paciente en sala",
          "Primeros auxilios y soporte de trauma",
          "Salud comunitaria y programas de inmunización",
          "Ética profesional y bioética médica"
        ],
        subjects: ["Anatomía Humana", "Farmacología Básica", "Enfermería Comunitaria", "Atención de Emergencias", "Materno Infantil"]
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
        facultyBtns.forEach((b) => b.classList.remove("active"));
        btn.classList.add("active");
        currentFaculty = btn.dataset.faculty;
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
      image: "../public/img/sede-central.webp",
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
      image: "../public/img/laboratorio-electronica.webp",
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
      image: "../public/img/laboratorio-mecatronica.webp",
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
        tabBtns.forEach((b) => b.classList.remove("active"));
        btn.classList.add("active");
        renderPillar(btn.dataset.pillar);
      });
    });

    renderPillar("doctrina");
  }

  /* ── Inicialización ───────────────────────────────────────────────────── */
  document.addEventListener("DOMContentLoaded", () => {
    initMobileMenu();
    initCareerExplorer();
    initPillars();
  });
})();
