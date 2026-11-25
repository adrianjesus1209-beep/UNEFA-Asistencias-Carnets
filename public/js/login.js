/**
 * UNIVERSIDAD NACIONAL EXPERIMENTAL POLITÉCNICA DE LA FANB (UNEFA)
 * Controlador de Autenticación Institucional (Portal Web)
 * 100% JavaScript Local — Sin Dependencias Externas
 */

(function () {
  "use strict";

  const ARROW_SVG =
    '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>';

  function restoreSubmitButton() {
    const submitBtn = document.getElementById("submitBtn");
    const tabAdmin = document.getElementById("tabAdmin");
    if (!submitBtn) return;

    const isAdmin = tabAdmin ? tabAdmin.classList.contains("active") : false;
    const label = isAdmin ? "Ingresar como Personal" : "Ingresar como Estudiante";

    submitBtn.disabled = false;
    submitBtn.innerHTML = `<span id="submitBtnText">${label}</span>${ARROW_SVG}`;
  }

  window.switchRole = function (role) {
    const tabStudent = document.getElementById("tabStudent");
    const tabAdmin = document.getElementById("tabAdmin");
    const identifierLabelText = document.getElementById("identifierLabelText");
    const identifierHint = document.getElementById("identifierHint");
    const cedulaInput = document.getElementById("cedulaInput");
    const submitBtn = document.getElementById("submitBtn");
    const alertBox = document.getElementById("loginAlertBox");
    const registerPromptRow = document.getElementById("registerPromptRow");

    if (alertBox) alertBox.classList.add("hidden");

    if (role === "student") {
      if (tabStudent) tabStudent.classList.add("active");
      if (tabAdmin) tabAdmin.classList.remove("active");
      if (identifierLabelText) identifierLabelText.textContent = "Cédula de Identidad";
      if (identifierHint) identifierHint.textContent = "Estudiantes";
      if (cedulaInput) cedulaInput.placeholder = "27450892";
      if (submitBtn && !submitBtn.disabled) {
        submitBtn.innerHTML = `<span id="submitBtnText">Ingresar como Estudiante</span>${ARROW_SVG}`;
      }
      if (registerPromptRow) registerPromptRow.style.display = "flex";
    } else {
      if (tabAdmin) tabAdmin.classList.add("active");
      if (tabStudent) tabStudent.classList.remove("active");
      if (identifierLabelText) identifierLabelText.textContent = "Cédula de Identidad";
      if (identifierHint) identifierHint.textContent = "Personal Docente / Administrativo";
      if (cedulaInput) cedulaInput.placeholder = "14230890";
      if (submitBtn && !submitBtn.disabled) {
        submitBtn.innerHTML = `<span id="submitBtnText">Ingresar como Personal</span>${ARROW_SVG}`;
      }
      if (registerPromptRow) registerPromptRow.style.display = "none";
    }
  };

  window.togglePasswordVisibility = function () {
    const passwordInput = document.getElementById("passwordInput");
    if (!passwordInput) return;

    const btn = document.querySelector(".btn-toggle-pwd");
    const eyeOpen = btn ? btn.querySelector(".icon-eye") : null;
    const eyeOff = btn ? btn.querySelector(".icon-eye-off") : null;

    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      if (eyeOpen && eyeOff) {
        eyeOpen.style.display = "none";
        eyeOff.style.display = "block";
      }
    } else {
      passwordInput.type = "password";
      if (eyeOpen && eyeOff) {
        eyeOpen.style.display = "block";
        eyeOff.style.display = "none";
      }
    }
  };

  function showAlert(htmlMessage) {
    const alertBox = document.getElementById("loginAlertBox");
    if (!alertBox) return;
    alertBox.innerHTML = htmlMessage;
    alertBox.classList.remove("hidden");
  }

  window.addEventListener("pageshow", function () {
    restoreSubmitButton();
  });

  document.addEventListener("DOMContentLoaded", function () {
    restoreSubmitButton();

    const form = document.getElementById("loginForm");
    if (!form) return;

    form.addEventListener("submit", function (event) {
      const cedulaInput = document.getElementById("cedulaInput");
      const passwordInput = document.getElementById("passwordInput");
      const submitBtn = document.getElementById("submitBtn");

      const cedula = cedulaInput ? cedulaInput.value.trim() : "";
      const pass = passwordInput ? passwordInput.value.trim() : "";

      if (!cedula || !pass) {
        event.preventDefault();
        showAlert(
          "<strong>Error de autenticación:</strong> Ingrese su número de cédula y contraseña institucional."
        );
        return;
      }

      if (cedula.length < 6) {
        event.preventDefault();
        showAlert(
          "<strong>Error de documento:</strong> El número de cédula debe tener al menos 6 dígitos."
        );
        return;
      }

      if (pass.length < 6) {
        event.preventDefault();
        showAlert(
          "<strong>Error de seguridad:</strong> La contraseña debe tener al menos 6 caracteres."
        );
        return;
      }

      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = "<span>Validando credenciales...</span>";
      }
    });
  });
})();