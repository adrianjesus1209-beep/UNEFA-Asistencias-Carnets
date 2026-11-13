/**
 * UNIVERSIDAD NACIONAL EXPERIMENTAL POLITÉCNICA DE LA FANB (UNEFA)
 * Controlador de Preinscripción CINU (Multi-pasos)
 */

(function () {
  "use strict";

  /* ── 1. Alternador de Visibilidad de Contraseñas ──────────────────────── */
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

  /* ── 2. Lógica del Formulario Multi-pasos ──────────────────────────────── */
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
        if (step === currentStep) {
          pill.classList.add("active");
          pill.setAttribute("aria-current", "step");
        } else if (step < currentStep) {
          pill.classList.add("completed");
          pill.removeAttribute("aria-current");
        } else {
          pill.removeAttribute("aria-current");
        }
      });

      stepContainers.forEach((container) => {
        const step = parseInt(container.dataset.step, 10);
        container.style.display = step === currentStep ? "block" : "none";
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

      if (formError) {
        formError.style.display = "none";
      }

      // Scroll suave hacia el inicio del formulario
      const card = document.querySelector(".auth-card");
      if (card) {
        card.scrollIntoView({ behavior: "smooth", block: "start" });
      }
    }

    function validateStep(stepNum) {
      const container = document.querySelector(`.signup-step-container[data-step="${stepNum}"]`);
      if (!container) return true;

      const requiredInputs = container.querySelectorAll("[required]");
      for (const input of requiredInputs) {
        if (!input.value.trim()) {
          const labelText = input.closest(".form-group")?.querySelector(".form-label")?.textContent.replace("*", "").trim() || "el campo requerido";
          showError(`Por favor completa el campo obligatorio: "${labelText}".`);
          input.focus();
          return false;
        }
      }

      // Validación Paso 1: Validación de contraseñas
      if (stepNum === 1) {
        const p1 = document.getElementById("reg_password")?.value;
        const p2 = document.getElementById("reg_confirmPassword")?.value;
        if (p1 && p1.length < 8) {
          showError("La contraseña institucional debe contener al menos 8 caracteres.");
          document.getElementById("reg_password")?.focus();
          return false;
        }
        if (p1 && p2 && p1 !== p2) {
          showError("Las contraseñas no coinciden. Por favor verifícalas con exactitud.");
          document.getElementById("reg_confirmPassword")?.focus();
          return false;
        }
      }

      return true;
    }

    function showError(msg) {
      if (!formError) return;
      formError.innerHTML = `<strong>⚠️ Error en el formulario:</strong> ${msg}`;
      formError.style.display = "flex";
      formError.scrollIntoView({ behavior: "smooth", block: "center" });
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
      const indicatorBar = document.querySelector(".step-indicator-bar");
      const authHeader = document.querySelector(".auth-header");

      if (successBox) {
        form.style.display = "none";
        if (indicatorBar) indicatorBar.style.display = "none";
        if (authHeader) authHeader.style.display = "none";
        successBox.style.display = "block";
        successBox.scrollIntoView({ behavior: "smooth", block: "start" });
      }
    });

    showStep(1);
  }

  /* ── Inicialización ───────────────────────────────────────────────────── */
  document.addEventListener("DOMContentLoaded", () => {
    initPasswordToggles();
    initRegistrationForm();
  });
})();
