/**
 * UNIVERSIDAD NACIONAL EXPERIMENTAL POLITÉCNICA DE LA FANB (UNEFA)
 * Controlador de la landing institucional
 */

(function () {
  "use strict";

  /* ── 1. Mobile Menu ───────────────────────────────────────────────────── */
  function initMobileMenu() {
    const toggle = document.querySelector(".mobile-toggle");
    const menu = document.querySelector(".mobile-menu");
    if (!toggle || !menu) return;

    toggle.addEventListener("click", () => {
      menu.classList.toggle("open");
    });
  }

  /* ── 2. Career Explorer Data & Logic ──────────────────────────────────── */
  const CAREERS_DATA = {
    ingenieria: [
      {
        id: "sistemas",
        code: "ING-SIS-10",
        title: "Ingeniería de Sistemas",
        duration: "10 Semestres (5 Años)",
        degree: "Ingeniero de Sistemas",
        image: "https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&w=1200&q=80",
        description: "Formación en ingeniería de software crítico, arquitectura de sistemas distribuidos, bases de datos masivas, ciberseguridad y computación para la defensa y el desarrollo soberano.",
        competencies: [
          "Desarrollo de software de misión crítica",
          "Ciberseguridad y soberanía de datos",
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
        image: "https://images.unsplash.com/photo-1544197150-b99a580bb7a8?auto=format&fit=crop&w=1200&q=80",
        description: "Especialistas en transmisión por fibra óptica, microondas, enlaces satelitales civiles y militares, antenas y procesamiento digital de señales para redes estratégicas.",
        competencies: [
          "Diseño de redes de comunicación nacional",
          "Operación de estaciones terrenas y satélites",
          "Propagación electromagnética y microondas",
          "Protocolos tácticos y seguros de comunicación"
        ],
        subjects: ["Teoría Electromagnética", "Sistemas de Transmisión", "Microondas y Radar", "Comunicaciones Ópticas", "Redes de Conmutación"]
      },
      {
        id: "mecanica",
        code: "ING-MEC-10",
        title: "Ingeniería Mecánica",
        duration: "10 Semestres (5 Años)",
        degree: "Ingeniero Mecánico",
        image: "https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=1200&q=80",
        description: "Diseño asistido por computadora (CAD/CAM), plantas térmicas, turbomáquinas, manufactura avanzada y mantenimiento de plantas industriales y de defensa.",
        competencies: [
          "Diseño y simulación de mecanismos",
          "Plantas térmicas y conversión de potencia",
          "Automatización de procesos industriales",
          "Metalurgia y resistencia de materiales"
        ],
        subjects: ["Mecánica de Fluidos", "Termodinámica Aplicada", "Diseño de Máquinas", "Resistencia de Materiales", "Transferencia de Calor"]
      },
      {
        id: "electronica",
        code: "ING-ELE-10",
        title: "Ingeniería Electrónica",
        duration: "10 Semestres (5 Años)",
        degree: "Ingeniero Electrónico",
        image: "https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1200&q=80",
        description: "Control automático, diseño de sistemas embebidos, instrumentación industrial y biomédica, robótica aplicada y electrónica de potencia.",
        competencies: [
          "Sistemas embebidos y microcontroladores",
          "Control y automatismos de plantas",
          "Electrónica de potencia industrial",
          "Robótica y sensórica aplicada"
        ],
        subjects: ["Circuitos Eléctricos", "Electrónica Analógica y Digital", "Sistemas de Control", "Microprocesadores", "Robótica Industrial"]
      }
    ],
    licenciaturas: [
      {
        id: "administracion",
        code: "LIC-AGM-08",
        title: "Administración y Gestión Municipal",
        duration: "8 Semestres (4 Años)",
        degree: "Licenciado en Administración y Gestión Municipal",
        image: "https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1200&q=80",
        description: "Formación en gerencia pública estratégica, presupuesto y contabilidad del Estado, contrataciones públicas y gestión de proyectos socio-productivos comunales.",
        competencies: [
          "Planificación presupuestaria pública",
          "Gobernanza territorial y comunal",
          "Auditoría y control de gestión",
          "Diseño de políticas socio-productivas"
        ],
        subjects: ["Derecho Administrativo", "Finanzas Públicas", "Planificación Estratégica", "Gestión Tributaria", "Proyectos Comunales"]
      },
      {
        id: "enfermeria",
        code: "LIC-ENF-08",
        title: "Licenciatura en Enfermería",
        duration: "8 Semestres (4 Años)",
        degree: "Licenciado en Enfermería",
        image: "https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=1200&q=80",
        description: "Atención hospitalaria, salud integral preventiva, gestión de emergencias clínicas y medicina táctica en apoyo a las comunidades y la fuerza armada.",
        competencies: [
          "Cuidados intensivos y prehospitalarios",
          "Epidemiología y salud pública",
          "Administración de servicios clínicos",
          "Atención en situaciones de contingencia"
        ],
        subjects: ["Anatomía y Fisiología", "Farmacología Clínica", "Enfermería Médico-Quirúrgica", "Salud Pública", "Medicina de Emergencia"]
      }
    ],
    tsu: [
      {
        id: "tsu-sistemas",
        code: "TSU-SIS-06",
        title: "TSU en Análisis de Sistemas",
        duration: "6 Semestres (3 Años)",
        degree: "Técnico Superior Universitario en Análisis de Sistemas",
        image: "https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=1200&q=80",
        description: "Inserción técnica directa: programación web, administración de bases de datos relacionales, soporte de redes locales y mantenimiento de infraestructura informática.",
        competencies: [
          "Desarrollo web y aplicaciones",
          "Configuración de redes LAN",
          "Mantenimiento preventivo y correctivo de software"
        ],
        subjects: ["Lenguajes de Programación", "Bases de Datos Relacionales", "Redes de Computadoras", "Sistemas de Información"]
      },
      {
        id: "tsu-enfermeria",
        code: "TSU-ENF-06",
        title: "TSU en Enfermería",
        duration: "6 Semestres (3 Años)",
        degree: "Técnico Superior Universitario en Enfermería",
        image: "https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=1200&q=80",
        description: "Asistencia clínica directa en hospitales y ambulatorios, curas y primeros auxilios, vacunación y apoyo inmediato a brigadas de salud preventiva.",
        competencies: [
          "Procedimientos de enfermería básicos y avanzados",
          "Atención inmediata en triaje y primeros auxilios",
          "Protocolos de esterilización e bioseguridad"
        ],
        subjects: ["Fundamentos de Enfermería", "Bioquímica Básica", "Enfermería Comunitaria", "Atención Materno-Infantil"]
      }
    ]
  };

  function initCareerExplorer() {
    const tabBtns = document.querySelectorAll(".faculty-tab-btn");
    const listContainer = document.getElementById("careersList");
    if (!tabBtns.length || !listContainer) return;

    let currentFaculty = "ingenieria";

    function renderFacultyList(facultyKey) {
      currentFaculty = facultyKey;
      const programs = CAREERS_DATA[facultyKey] || [];
      listContainer.innerHTML = "";

      programs.forEach((prog, index) => {
        const btn = document.createElement("button");
        btn.className = `career-item-btn ${index === 0 ? "active" : ""}`;
        btn.dataset.careerId = prog.id;
        btn.innerHTML = `
          <div class="career-item-code">
            <span>${prog.code}</span>
            <span>${prog.duration}</span>
          </div>
          <div class="career-item-name">${prog.title}</div>
        `;
        btn.addEventListener("click", () => {
          document.querySelectorAll(".career-item-btn").forEach((b) => b.classList.remove("active"));
          btn.classList.add("active");
          renderDossier(prog);
        });
        listContainer.appendChild(btn);
      });

      if (programs.length > 0) {
        renderDossier(programs[0]);
      }
    }

    function renderDossier(prog) {
      const imgEl = document.getElementById("dossierImg");
      const codeEl = document.getElementById("dossierCode");
      const degreeEl = document.getElementById("dossierDegree");
      const durationEl = document.getElementById("dossierDuration");
      const titleEl = document.getElementById("dossierTitle");
      const descEl = document.getElementById("dossierDesc");
      const compContainer = document.getElementById("dossierCompetencies");
      const subjContainer = document.getElementById("dossierSubjects");

      if (imgEl) imgEl.src = prog.image;
      if (codeEl) codeEl.textContent = prog.code;
      if (degreeEl) degreeEl.textContent = prog.degree;
      if (durationEl) durationEl.textContent = prog.duration;
      if (titleEl) titleEl.textContent = prog.title;
      if (descEl) descEl.textContent = prog.description;

      if (compContainer) {
        compContainer.innerHTML = prog.competencies
          .map((c) => `<div class="competency-item"><span class="competency-bullet"></span><span>${c}</span></div>`)
          .join("");
      }

      if (subjContainer) {
        subjContainer.innerHTML = prog.subjects
          .map((s) => `<span class="subject-chip">${s}</span>`)
          .join("");
      }
    }

    tabBtns.forEach((btn) => {
      btn.addEventListener("click", () => {
        tabBtns.forEach((b) => b.classList.remove("active"));
        btn.classList.add("active");
        renderFacultyList(btn.dataset.faculty);
      });
    });

    // Initial render
    renderFacultyList("ingenieria");
  }

  /* ── 3. Pillars / Doctrina Data & Logic ───────────────────────────────── */
  const PILLARS_DATA = {
    ingenieria: {
      number: "01",
      title: "Investigación e innovación",
      caption: "Laboratorio de electrónica y mecatrónica",
      image: "https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=1200&q=80",
      description: "Programas orientados a la soberanía científica: desarrollo de software crítico, automatización, diseño mecánico y telecomunicaciones satelitales que atienden las necesidades estratégicas del país.",
      highlights: [
        "Laboratorios equipados para prácticas de hardware y redes",
        "Proyectos de grado orientados a problemas industriales reales",
        "Docencia a cargo de especialistas con experiencia comprobada"
      ]
    },
    doctrina: {
      number: "02",
      title: "Doctrina cívico-militar y liderazgo",
      caption: "Formación integral y patrimonio institucional",
      image: "https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=1200&q=80",
      description: "Formación en valores de honor, disciplina, lealtad y corresponsabilidad ciudadana, orientada a la defensa y al desarrollo integral de la patria.",
      highlights: [
        "Instrucción en orden cerrado, liderazgo y trabajo bajo presión",
        "Cátedra de Defensa Integral de la Nación y soberanía popular",
        "Ética cívica aplicada a la ingeniería y a la administración pública"
      ]
    },
    extension: {
      number: "03",
      title: "Extensión y compromiso comunitario",
      caption: "Vinculación comunitaria y servicio social",
      image: "https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1200&q=80",
      description: "La ciencia y la técnica salen del aula: los estudiantes unefistas llevan sus proyectos a las comunidades, consejos comunales y empresas públicas a través del servicio comunitario.",
      highlights: [
        "Más de 100 proyectos comunitarios activos por semestre",
        "Capacitación tecnológica a sectores vulnerables y escuelas técnicas",
        "Soluciones de ingeniería de bajo costo con alto impacto social"
      ]
    },
    gratuidad: {
      number: "04",
      title: "Inclusión y cobertura nacional",
      caption: "Aulas y acceso en todo el país",
      image: "https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&w=1200&q=80",
      description: "Educación universitaria pública y gratuita, para que el talento de cualquier rincón del país acceda a las carreras más demandadas por el sector productivo.",
      highlights: [
        "Sin aranceles de matrícula durante toda la carrera",
        "Presencia en los 24 estados con sedes y extensiones",
        "Igualdad de oportunidades mediante el Curso Integral CINU"
      ]
    }
  };

  function initPillars() {
    const pillarBtns = document.querySelectorAll(".pillar-selector-btn");
    const imgEl = document.getElementById("pillarImg");
    const captionEl = document.getElementById("pillarCaption");
    const areaEl = document.getElementById("pillarArea");
    const titleEl = document.getElementById("pillarTitle");
    const descEl = document.getElementById("pillarDesc");
    const highlightsEl = document.getElementById("pillarHighlights");

    if (!pillarBtns.length) return;

    pillarBtns.forEach((btn) => {
      btn.addEventListener("click", () => {
        pillarBtns.forEach((b) => b.classList.remove("active"));
        btn.classList.add("active");

        const data = PILLARS_DATA[btn.dataset.pillar];
        if (!data) return;

        if (imgEl) imgEl.src = data.image;
        if (captionEl) captionEl.textContent = data.caption;
        if (areaEl) areaEl.textContent = `Pilar ${data.number}`;
        if (titleEl) titleEl.textContent = data.title;
        if (descEl) descEl.textContent = data.description;

        if (highlightsEl) {
          highlightsEl.innerHTML = data.highlights
            .map((h) => `<div class="competency-item"><span class="competency-bullet"></span><span>${h}</span></div>`)
            .join("");
        }
      });
    });
  }

  /* ── 4. Admissions Interactive Checklist Calculator ──────────────────── */
  function initAdmissionsChecklist() {
    const items = document.querySelectorAll(".check-item-label");
    const percentageEl = document.getElementById("calcPercentage");
    const fillEl = document.getElementById("calcProgressBar");
    const messageEl = document.getElementById("calcFeedbackMessage");

    if (!items.length) return;

    function update() {
      const checked = document.querySelectorAll(".check-item-label.checked").length;
      const total = items.length;
      const pct = Math.round((checked / total) * 100);

      if (percentageEl) percentageEl.textContent = `${pct}%`;
      if (fillEl) fillEl.style.width = `${pct}%`;

      if (messageEl) {
        if (pct === 100) {
          messageEl.innerHTML = `<strong>Documentos completos.</strong> Ya puedes formalizar tu expediente en Control de Estudios.`;
          messageEl.style.borderColor = "#16a34a";
          messageEl.style.color = "#16a34a";
        } else {
          messageEl.innerHTML = `Tienes <strong>${checked} de ${total}</strong> recaudos completados.`;
          messageEl.style.borderColor = "var(--border-subtle)";
          messageEl.style.color = "var(--text-secondary)";
        }
      }
    }

    items.forEach((item) => {
      item.addEventListener("click", () => {
        item.classList.toggle("checked");
        update();
      });
    });

    update();
  }

  /* ── 5. Password Visibility Toggle ────────────────────────────────────── */
  function initPasswordToggles() {
    const toggleBtns = document.querySelectorAll(".toggle-password-btn");
    toggleBtns.forEach((btn) => {
      btn.addEventListener("click", () => {
        const targetId = btn.dataset.target;
        const input = document.getElementById(targetId);
        if (!input) return;
        const isPassword = input.type === "password";
        input.type = isPassword ? "text" : "password";
        btn.textContent = isPassword ? "Ocultar" : "Mostrar";
      });
    });
  }

  /* ── 6. Multi-step Registration Form Logic ────────────────────────────── */
  function initRegistrationForm() {
    const form = document.getElementById("signupMultiForm");
    if (!form) return;

    let currentStep = 1;
    const totalSteps = 3;

    const stepPills = document.querySelectorAll(".step-pill");
    const stepContainers = document.querySelectorAll(".signup-step-container");
    const btnNext = document.getElementById("btnStepNext");
    const btnPrev = document.getElementById("btnStepPrev");
    const btnSubmit = document.getElementById("btnStepSubmit");
    const formError = document.getElementById("signupFormError");

    function showStep(stepNum) {
      currentStep = stepNum;

      stepPills.forEach((pill) => {
        const step = parseInt(pill.dataset.step, 10);
        pill.classList.remove("active", "completed");
        if (step === currentStep) pill.classList.add("active");
        else if (step < currentStep) pill.classList.add("completed");
      });

      stepContainers.forEach((c) => {
        c.style.display = parseInt(c.dataset.step, 10) === currentStep ? "block" : "none";
      });

      if (btnPrev) {
        btnPrev.style.display = currentStep > 1 ? "inline-flex" : "none";
      }

      if (btnNext && btnSubmit) {
        if (currentStep === totalSteps) {
          btnNext.style.display = "none";
          btnSubmit.style.display = "inline-flex";
        } else {
          btnNext.style.display = "inline-flex";
          btnSubmit.style.display = "none";
        }
      }

      if (formError) formError.style.display = "none";
    }

    function validateStep(stepNum) {
      const container = document.querySelector(`.signup-step-container[data-step="${stepNum}"]`);
      if (!container) return true;

      const requiredInputs = container.querySelectorAll("[required]");
      for (const input of requiredInputs) {
        if (!input.value.trim()) {
          showError(`Por favor completa el campo obligatorio: ${input.previousElementSibling?.textContent || "todos los campos requeridos"}`);
          input.focus();
          return false;
        }
      }

      // Step 1: Password match check
      if (stepNum === 1) {
        const p1 = document.getElementById("reg_password")?.value;
        const p2 = document.getElementById("reg_confirmPassword")?.value;
        if (p1 && p2 && p1 !== p2) {
          showError("Las contraseñas no coinciden. Por favor verifícalas.");
          return false;
        }
      }

      return true;
    }

    function showError(msg) {
      if (!formError) return;
      formError.textContent = msg;
      formError.style.display = "block";
    }

    if (btnNext) {
      btnNext.addEventListener("click", () => {
        if (validateStep(currentStep)) {
          if (currentStep < totalSteps) showStep(currentStep + 1);
        }
      });
    }

    if (btnPrev) {
      btnPrev.addEventListener("click", () => {
        if (currentStep > 1) showStep(currentStep - 1);
      });
    }

    form.addEventListener("submit", (e) => {
      e.preventDefault();
      if (!validateStep(currentStep)) return;

      const successBox = document.getElementById("signupSuccessMessage");
      if (successBox) {
        form.style.display = "none";
        successBox.style.display = "block";
      }
    });

    showStep(1);
  }

  /* ── 7. Login Form Handling ───────────────────────────────────────────── */
  function initLoginForm() {
    const loginForm = document.getElementById("loginForm");
    if (!loginForm) return;

    loginForm.addEventListener("submit", (e) => {
      e.preventDefault();
      const cedula = document.getElementById("login_cedula")?.value.trim();
      const password = document.getElementById("login_password")?.value.trim();
      const errorMsg = document.getElementById("loginErrorMsg");

      if (!cedula || !password) {
        if (errorMsg) {
          errorMsg.textContent = "Por favor ingrese su número de cédula y contraseña.";
          errorMsg.style.display = "block";
        }
        return;
      }

      const btn = loginForm.querySelector("button[type='submit']");
      if (btn) btn.textContent = "Verificando credenciales...";

      setTimeout(() => {
        alert(`Acceso concedido al portal SICEU. Cédula: ${cedula}.`);
        if (btn) btn.textContent = "Acceder al SICEU";
      }, 700);
    });
  }

  /* ── DOM Ready Initializer ────────────────────────────────────────────── */
  document.addEventListener("DOMContentLoaded", () => {
    initMobileMenu();
    initCareerExplorer();
    initPillars();
    initAdmissionsChecklist();
    initPasswordToggles();
    initRegistrationForm();
    initLoginForm();
  });
})();
