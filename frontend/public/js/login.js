/**
 * UNIVERSIDAD NACIONAL EXPERIMENTAL POLITÉCNICA DE LA FANB (UNEFA)
 * Controlador de Autenticación Institucional SICEU
 * 100% JavaScript Local — Sin Dependencias Externas
 */

(function () {
  "use strict";

  let currentRole = "student";

  window.switchRole = function (role) {
    currentRole = role;
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
      // El enlace de registro es exclusivo para Estudiantes
      if (registerPromptRow) registerPromptRow.style.display = "flex";
    } else {
      if (tabAdmin) tabAdmin.classList.add("active");
      if (tabStudent) tabStudent.classList.remove("active");
      if (identifierLabelText) identifierLabelText.textContent = "Cédula de Identidad";
      if (identifierHint) identifierHint.textContent = "Personal Docente / Administrativo";
      if (cedulaInput) cedulaInput.placeholder = "14230890";
      if (submitBtnText) submitBtnText.textContent = "Ingresar como Personal";
      // El personal institucional es registrado internamente por RRHH y Telemática
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

  window.handleLogin = function () {
    const docType = document.getElementById("docType");
    const cedulaInput = document.getElementById("cedulaInput");
    const passwordInput = document.getElementById("passwordInput");
    const alertBox = document.getElementById("loginAlertBox");
    const submitBtn = document.getElementById("submitBtn");

    const cedula = cedulaInput ? cedulaInput.value.trim() : "";
    const pass = passwordInput ? passwordInput.value.trim() : "";
    const nationality = docType ? docType.value : "V";

    if (!cedula || !pass) {
      if (alertBox) {
        alertBox.innerHTML =
          "<strong>Error de autenticación:</strong> Ingrese su número de cédula y contraseña institucional.";
        alertBox.classList.remove("hidden");
      }
      return;
    }

    if (alertBox) alertBox.classList.add("hidden");

    const originalContent = submitBtn ? submitBtn.innerHTML : "";
    if (submitBtn) {
      submitBtn.disabled = true;
      submitBtn.innerHTML = "<span>Validando credenciales...</span>";
    }

    setTimeout(() => {
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalContent;
      }

      const fullId = `${nationality}-${cedula}`;
      if (currentRole === "student") {
        alert(
          `[Acceso SICEU concedido]\n\nUsuario: ${fullId}\nRol: Estudiantes\nConexión autorizada en los servidores centrales de la UNEFA.`
        );
      } else {
        alert(
          `[Consola Institucional SICEU]\n\nUsuario: ${fullId}\nRol: Personal\nSesión iniciada con privilegios institucionales.`
        );
      }
    }, 700);
  };
})();
