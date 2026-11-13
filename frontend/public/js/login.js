/**
 * UNIVERSIDAD NACIONAL EXPERIMENTAL POLITÉCNICA DE LA FANB (UNEFA)
 * Controlador de Inicio de Sesión Diferenciado por Canales (Estudiante / Profesional)
 */

(function () {
  "use strict";

  let currentChannel = "estudiante"; // 'estudiante' | 'profesional'

  /* ── 1. Alternador de Visibilidad de Contraseña ───────────────────────── */
  function initPasswordToggles() {
    const buttons = document.querySelectorAll(".toggle-password-btn");
    buttons.forEach((btn) => {
      btn.addEventListener("click", () => {
        const targetId = btn.getAttribute("data-target");
        const input = document.getElementById(targetId);
        if (!input) return;

        if (input.type === "password") {
          input.type = "text";
          btn.textContent = "Ocultar";
          btn.setAttribute("aria-label", "Ocultar contraseña");
        } else {
          input.type = "password";
          btn.textContent = "Mostrar";
          btn.setAttribute("aria-label", "Mostrar contraseña");
        }
      });
    });
  }

  /* ── 2. Conmutador de Canales (Estudiante vs Profesional) ─────────────── */
  function initChannelSwitch() {
    const tabButtons = document.querySelectorAll(".channel-tab-btn");
    const channelTag = document.getElementById("channelBadgeTag");
    const channelTitle = document.getElementById("loginTitle");
    const channelSub = document.getElementById("loginSubtitle");
    const cedulaLabel = document.getElementById("identifierLabel");
    const cedulaInput = document.getElementById("login_cedula");
    const natSelectWrap = document.getElementById("nacionalidadSelectWrap");
    const submitBtn = document.getElementById("loginSubmitBtn");
    const registerPrompt = document.getElementById("studentRegisterPrompt");
    const professionalSupportNote = document.getElementById("professionalSupportNote");
    const errorBox = document.getElementById("loginErrorMsg");

    function setChannel(channel) {
      currentChannel = channel;

      // Actualizar botones de pestaña
      tabButtons.forEach((btn) => {
        const target = btn.getAttribute("data-target-channel");
        if (target === channel) {
          btn.classList.add("active");
          btn.setAttribute("aria-selected", "true");
        } else {
          btn.classList.remove("active");
          btn.setAttribute("aria-selected", "false");
        }
      });

      // Limpiar errores previos
      if (errorBox) {
        errorBox.style.display = "none";
        errorBox.textContent = "";
      }

      if (channel === "estudiante") {
        if (channelTag) {
          channelTag.textContent = "Acceso Estudiantes";
          channelTag.className = "badge-tag accent-gold";
        }
        if (channelTitle) channelTitle.textContent = "Portal Estudiantil SICEU";
        if (channelSub) {
          channelSub.textContent =
            "Ingresa con tu cédula de identidad y contraseña para consultar tus asignaturas, notas, horarios y carnet digital.";
        }
        if (cedulaLabel) cedulaLabel.textContent = "Cédula de identidad estudiantil";
        if (cedulaInput) {
          cedulaInput.placeholder = "Ej. 28123456";
          cedulaInput.type = "text";
          cedulaInput.inputMode = "numeric";
        }
        if (natSelectWrap) natSelectWrap.style.display = "block";

        if (submitBtn) {
          submitBtn.className = "btn btn-gold btn-lg auth-submit-btn";
          submitBtn.innerHTML = "<span>Acceder como Estudiante</span> <span>→</span>";
        }

        if (registerPrompt) registerPrompt.style.display = "flex";
        if (professionalSupportNote) professionalSupportNote.style.display = "none";

      } else {
        // Canal Profesional (Docente / Administrativo / Directivo)
        if (channelTag) {
          channelTag.textContent = "Acceso Personal / Docente";
          channelTag.className = "badge-tag accent-blue";
        }
        if (channelTitle) channelTitle.textContent = "Portal Docente y Personal";
        if (channelSub) {
          channelSub.textContent =
            "Acceso para Profesores, Coordinadores, Directores de Núcleo y Personal Administrativo autorizado.";
        }
        if (cedulaLabel) cedulaLabel.textContent = "Cédula o Correo institucional (@unefa.edu.ve)";
        if (cedulaInput) {
          cedulaInput.placeholder = "Ej. 14567890 o docente@unefa.edu.ve";
          cedulaInput.type = "text";
          cedulaInput.inputMode = "text";
        }
        // En acceso profesional el correo o cédula puede ir directo
        if (natSelectWrap) natSelectWrap.style.display = "block";

        if (submitBtn) {
          submitBtn.className = "btn btn-blue btn-lg auth-submit-btn";
          submitBtn.innerHTML = "<span>Acceder como Profesional</span> <span>→</span>";
        }

        if (registerPrompt) registerPrompt.style.display = "none";
        if (professionalSupportNote) professionalSupportNote.style.display = "block";
      }
    }

    tabButtons.forEach((btn) => {
      btn.addEventListener("click", () => {
        const target = btn.getAttribute("data-target-channel");
        if (target) setChannel(target);
      });
    });

    // Iniciar por defecto en canal Estudiante
    setChannel("estudiante");
  }

  /* ── 3. Manejo del Formulario de Acceso ───────────────────────────────── */
  function initLoginForm() {
    const loginForm = document.getElementById("loginForm");
    if (!loginForm) return;

    loginForm.addEventListener("submit", (e) => {
      e.preventDefault();

      const identifierInput = document.getElementById("login_cedula");
      const passwordInput = document.getElementById("login_password");
      const errorMsg = document.getElementById("loginErrorMsg");
      const submitBtn = document.getElementById("loginSubmitBtn");

      const identifier = identifierInput ? identifierInput.value.trim() : "";
      const password = passwordInput ? passwordInput.value.trim() : "";

      if (!identifier || !password) {
        if (errorMsg) {
          errorMsg.className = "auth-alert-box auth-alert-error";
          errorMsg.innerHTML = "<strong>⚠️ Error de validación:</strong> Por favor complete su identificación y contraseña institucional.";
          errorMsg.style.display = "flex";
          errorMsg.scrollIntoView({ behavior: "smooth", block: "center" });
        }
        return;
      }

      if (errorMsg) {
        errorMsg.style.display = "none";
      }

      const originalBtnHTML = submitBtn ? submitBtn.innerHTML : "";
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = "<span>Verificando credenciales...</span>";
      }

      setTimeout(() => {
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.innerHTML = originalBtnHTML;
        }

        if (currentChannel === "estudiante") {
          alert(`✅ [Canal Estudiantes] Credenciales verificadas exitosamente para: ${identifier}.\n\nAcceso al panel estudiantil SICEU concedido.`);
        } else {
          alert(`✅ [Canal Profesional] Credenciales verificadas exitosamente para: ${identifier}.\n\nAcceso a la consola de cátedra y gestión académica concedido.`);
        }
      }, 750);
    });
  }

  /* ── Inicialización ───────────────────────────────────────────────────── */
  document.addEventListener("DOMContentLoaded", () => {
    initPasswordToggles();
    initChannelSwitch();
    initLoginForm();
  });
})();
