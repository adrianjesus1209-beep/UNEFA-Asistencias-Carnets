/**
 * UNIVERSIDAD NACIONAL EXPERIMENTAL POLITÉCNICA DE LA FANB (UNEFA)
 * Controlador de Autenticación Institucional (Portal Web)
 * 100% JavaScript Local — Sin Dependencias Externas
 */

(function () {
  "use strict";

  window.switchRole = function (role) {
    const tabStudent = document.getElementById("tabStudent");
    const tabAdmin = document.getElementById("tabAdmin");
    const identifierLabelText = document.getElementById("identifierLabelText");
    const identifierHint = document.getElementById("identifierHint");
    const cedulaInput = document.getElementById("cedulaInput");
    const submitBtnText = document.getElementById("submitBtnText");
    const alertBox = document.getElementById("loginAlertBox");
    const registerPromptRow = document.getElementById("registerPromptRow");

    if (alertBox) alertBox.classList.add("hidden");

    if (role === "student") {
      if (tabStudent) tabStudent.classList.add("active");
      if (tabAdmin) tabAdmin.classList.remove("active");
      if (identifierLabelText) identifierLabelText.textContent = "Cédula de Identidad";
      if (identifierHint) identifierHint.textContent = "Estudiantes";
      if (cedulaInput) cedulaInput.placeholder = "27450892";
      if (submitBtnText) submitBtnText.textContent = "Ingresar como Estudiante";
      if (registerPromptRow) registerPromptRow.style.display = "flex";
    } else {
      if (tabAdmin) tabAdmin.classList.add("active");
      if (tabStudent) tabStudent.classList.remove("active");
      if (identifierLabelText) identifierLabelText.textContent = "Cédula de Identidad";
      if (identifierHint) identifierHint.textContent = "Personal Docente / Administrativo";
      if (cedulaInput) cedulaInput.placeholder = "14230890";
      if (submitBtnText) submitBtnText.textContent = "Ingresar como Personal";
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

  document.addEventListener("DOMContentLoaded", function () {
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