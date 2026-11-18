/**
 * UNIVERSIDAD NACIONAL EXPERIMENTAL POLITÉCNICA DE LA FANB (UNEFA)
 * Controlador de Registro de Nuevo Estudiante (Pregrado y Postgrado)
 * 100% JavaScript Local — Sin Dependencias Externas
 */

(function () {
  "use strict";

  let currentStep = 1;
  const totalSteps = 3;

  window.toggleFieldPassword = function (fieldId, btn) {
    const input = document.getElementById(fieldId);
    if (!input) return;

    const eyeOpen = btn ? btn.querySelector(".icon-eye") : null;
    const eyeOff = btn ? btn.querySelector(".icon-eye-off") : null;
    if (input.type === "password") {
      input.type = "text";
      if (eyeOpen && eyeOff) {
        eyeOpen.style.display = "none";
        eyeOff.style.display = "block";
      }
    } else {
      input.type = "password";
      if (eyeOpen && eyeOff) {
        eyeOpen.style.display = "block";
        eyeOff.style.display = "none";
      }
    }
  };

  window.updateCareerOptions = function () {
    const nivelSelect = document.getElementById("reg_nivel");
    const carreraSelect = document.getElementById("reg_carrera");
    if (!nivelSelect || !carreraSelect) return;

    const nivel = nivelSelect.value;
    if (nivel === "postgrado") {
      carreraSelect.innerHTML = `
        <optgroup label="Especializaciones Técnicas">
          <option value="ESP-TEL">Especialización en Redes y Telecomunicaciones</option>
          <option value="ESP-GER">Especialización en Gerencia Pública</option>
          <option value="ESP-SEG">Especialización en Seguridad Informática</option>
        </optgroup>
        <optgroup label="Maestrías">
          <option value="MAE-CIE">Maestría en Ciencias de la Computación</option>
          <option value="MAE-GER">Maestría en Gerencia y Liderazgo Institucional</option>
          <option value="MAE-EDU">Maestría en Educación Superior Politécnica</option>
        </optgroup>
        <optgroup label="Doctorados">
          <option value="DOC-ING">Doctorado en Ciencias de la Ingeniería</option>
          <option value="DOC-SEG">Doctorado en Seguridad de la Nación</option>
        </optgroup>
      `;
    } else {
      carreraSelect.innerHTML = `
        <optgroup label="Ingenierías (10 Semestres)">
          <option value="ING-SIS">Ingeniería de Sistemas</option>
          <option value="ING-TEL">Ingeniería de Telecomunicaciones</option>
          <option value="ING-MEC">Ingeniería Mecánica</option>
          <option value="ING-AER">Ingeniería Aeronáutica</option>
          <option value="ING-CIV">Ingeniería Civil</option>
        </optgroup>
        <optgroup label="Licenciaturas (8 Semestres)">
          <option value="LIC-ADM">Licenciatura en Administración y Gestión Municipal</option>
          <option value="LIC-ECO">Licenciatura en Economía Social</option>
          <option value="LIC-TUR">Licenciatura en Turismo</option>
          <option value="LIC-ENF">Licenciatura en Enfermería</option>
        </optgroup>
        <optgroup label="Técnico Superior Universitario (6 Semestres)">
          <option value="TSU-SIS">TSU en Análisis y Diseño de Sistemas</option>
          <option value="TSU-ENF">TSU en Enfermería</option>
          <option value="TSU-HOT">TSU en Hotelería</option>
        </optgroup>
      `;
    }
  };

  function validateCurrentStep(step) {
    const alertBox = document.getElementById("signupAlertBox");
    if (alertBox) alertBox.classList.add("hidden");

    const container = document.getElementById(`stepContainer${step}`);
    if (!container) return true;

    const inputs = container.querySelectorAll("input[required], select[required], textarea[required]");
    for (const input of inputs) {
      if (!input.value.trim()) {
        const formGroup = input.closest(".form-group") || input.closest(".space-y-1");
        const label = formGroup?.querySelector("label")?.textContent.replace("*", "").trim() || "campo requerido";
        showStepError(`Por favor complete el campo obligatorio: "${label}".`);
        input.focus();
        return false;
      }
    }

    if (step === 1) {
      const email = document.getElementById("reg_email")?.value.trim() || "";
      if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        showStepError("Ingrese una dirección de correo electrónico válida.");
        document.getElementById("reg_email")?.focus();
        return false;
      }

      const p1 = document.getElementById("reg_password")?.value || "";
      const p2 = document.getElementById("reg_confirmPassword")?.value || "";
      if (p1.length < 8) {
        showStepError("La contraseña institucional debe contener al menos 8 caracteres.");
        document.getElementById("reg_password")?.focus();
        return false;
      }
      if (p1 !== p2) {
        showStepError("Las contraseñas no coinciden. Verifíquelas con exactitud.");
        document.getElementById("reg_confirmPassword")?.focus();
        return false;
      }
    }

    if (step === 2) {
      const promedio = parseFloat(document.getElementById("reg_promedio")?.value || "0");
      if (isNaN(promedio) || promedio < 1 || promedio > 20) {
        showStepError("El promedio de notas debe estar en la escala de 1 a 20 puntos.");
        document.getElementById("reg_promedio")?.focus();
        return false;
      }
    }

    return true;
  }

  function showStepError(msg) {
    const alertBox = document.getElementById("signupAlertBox");
    if (!alertBox) return;
    alertBox.innerHTML = `<strong>Validación requerida:</strong> ${msg}`;
    alertBox.classList.remove("hidden");
    alertBox.scrollIntoView({ behavior: "smooth", block: "center" });
  }

  window.navigateStep = function (direction) {
    if (direction > 0 && !validateCurrentStep(currentStep)) {
      return;
    }

    const nextStep = currentStep + direction;
    if (nextStep < 1 || nextStep > totalSteps) return;

    currentStep = nextStep;
    updateStepView();
  };

  function updateStepView() {
    const alertBox = document.getElementById("signupAlertBox");
    if (alertBox) alertBox.classList.add("hidden");

    for (let i = 1; i <= totalSteps; i++) {
      const container = document.getElementById(`stepContainer${i}`);
      const pill = document.getElementById(`stepPill${i}`);
      const leftIndicator = document.getElementById(`leftStepIndicator${i}`);

      if (container) {
        if (i === currentStep) {
          container.classList.remove("hidden");
        } else {
          container.classList.add("hidden");
        }
      }

      if (pill) {
        pill.classList.remove("active", "completed", "pending");
        if (i === currentStep) {
          pill.classList.add("active");
        } else if (i < currentStep) {
          pill.classList.add("completed");
        } else {
          pill.classList.add("pending");
        }
      }

      if (leftIndicator) {
        leftIndicator.classList.remove("active", "completed", "pending");
        if (i === currentStep) {
          leftIndicator.classList.add("active");
        } else if (i < currentStep) {
          leftIndicator.classList.add("completed");
        } else {
          leftIndicator.classList.add("pending");
        }
      }
    }

    const btnPrev = document.getElementById("btnPrevStep");
    const btnNext = document.getElementById("btnNextStep");
    const btnSubmit = document.getElementById("btnSubmitRegistration");

    if (btnPrev) {
      if (currentStep > 1) {
        btnPrev.classList.remove("hidden");
      } else {
        btnPrev.classList.add("hidden");
      }
    }

    if (btnNext && btnSubmit) {
      if (currentStep === totalSteps) {
        btnNext.classList.add("hidden");
        btnSubmit.classList.remove("hidden");
      } else {
        btnNext.classList.remove("hidden");
        btnSubmit.classList.add("hidden");
      }
    }
  }

  document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("signupMultiForm");
    if (!form) return;

    form.addEventListener("submit", (e) => {
      e.preventDefault();
      if (!validateCurrentStep(currentStep)) return;

      const submitBtn = document.getElementById("btnSubmitRegistration");
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = "<span>Procesando inscripción...</span>";
      }

      setTimeout(() => {
        const successCard = document.getElementById("signupSuccessCard");
        const stepPillsContainer = document.getElementById("stepPillsContainer");
        const registrationCodeBadge = document.getElementById("registrationCodeBadge");

        const randomNum = Math.floor(100000 + Math.random() * 900000);
        const nivel = document.getElementById("reg_nivel")?.value === "postgrado" ? "POS" : "PRE";
        if (registrationCodeBadge) {
          registrationCodeBadge.textContent = `UNEFA-2026-I-${nivel}-${randomNum}`;
        }

        form.classList.add("hidden");
        if (stepPillsContainer) stepPillsContainer.classList.add("hidden");
        if (successCard) {
          successCard.classList.remove("hidden");
          successCard.scrollIntoView({ behavior: "smooth", block: "start" });
        }
      }, 700);
    });

    updateStepView();
  });
})();
