/**
 * Interactividad del login SICEU: selector V-/E-, campo numerico, mostrar
 * clave y flujo de acceso simulado. Equivalente web de src/app/login.tsx.
 */
(function () {
    'use strict';

    var formulario = document.getElementById('formulario-login');

    if (!formulario) return;

    var nacionalidad = document.getElementById('campo-nacionalidad');
    var botonesNacionalidad = formulario.querySelectorAll('[data-nacionalidad]');
    var campoCedula = document.getElementById('campo-cedula');
    var campoClave = document.getElementById('campo-clave');
    var botonVerClave = document.getElementById('boton-ver-clave');
    var botonOlvidada = document.getElementById('boton-olvidada');
    var notaOlvidada = document.getElementById('nota-olvidada');
    var alertaError = document.getElementById('alerta-error');
    var textoError = document.getElementById('texto-error');
    var alertaExito = document.getElementById('alerta-exito');
    var textoExito = document.getElementById('texto-exito');
    var botonAcceder = document.getElementById('boton-acceder');
    var textoBoton = formulario.querySelector('[data-texto-boton]');
    var destinoEstudiante = formulario.getAttribute('data-destino-estudiante');

    /**
     * Selector de nacionalidad: marca el boton activo y guarda el valor.
     */
    function fijarNacionalidad(valor) {
        if (nacionalidad) nacionalidad.value = valor;
        botonesNacionalidad.forEach(function (boton) {
            var activo = boton.getAttribute('data-nacionalidad') === valor;
            boton.classList.toggle('bg-unefa-blue', activo);
            var texto = boton.querySelector('span');
            if (texto) {
                texto.classList.toggle('!text-white', activo);
                texto.classList.toggle('text-slate-500', !activo);
            }
        });
    }

    botonesNacionalidad.forEach(function (boton) {
        boton.addEventListener('click', function () {
            fijarNacionalidad(boton.getAttribute('data-nacionalidad'));
        });
    });
    fijarNacionalidad('V');

    /**
     * Cedula: solo digitos.
     */
    if (campoCedula) {
        campoCedula.addEventListener('input', function () {
            campoCedula.value = campoCedula.value.replace(/\D/g, '').slice(0, 8);
        });
    }

    /**
     * Mostrar / ocultar la clave institucional.
     */
    if (botonVerClave && campoClave) {
        botonVerClave.addEventListener('click', function () {
            var visible = campoClave.type === 'text';
            campoClave.type = visible ? 'password' : 'text';
            botonVerClave.textContent = visible ? 'Mostrar' : 'Ocultar';
        });
    }

    /**
     * Nota de recuperacion de clave (solo informativa en la maqueta).
     */
    if (botonOlvidada && notaOlvidada) {
        botonOlvidada.addEventListener('click', function () {
            notaOlvidada.classList.toggle('hidden');
        });
    }

    function mostrarError(mensaje) {
        if (!alertaError || !textoError) return;
        textoError.textContent = mensaje;
        alertaError.classList.remove('hidden');
        if (alertaExito) alertaExito.classList.add('hidden');
    }

    function ocultarAlertas() {
        if (alertaError) alertaError.classList.add('hidden');
        if (alertaExito) alertaExito.classList.add('hidden');
    }

    /**
     * Flujo simulado de la maqueta: validar, 800 ms de carga, mensaje de
     * exito, 500 ms y redireccion al dashboard del estudiante. El backend
     * debe reemplazar esta secuencia por la autenticacion real.
     */
    formulario.addEventListener('submit', function (evento) {
        evento.preventDefault();
        ocultarAlertas();

        var cedula = campoCedula ? campoCedula.value.trim() : '';
        var clave = campoClave ? campoClave.value : '';

        if (cedula.length < 6) {
            mostrarError('Ingresa tu número de documento de identidad completo (al menos 6 dígitos).');
            if (campoCedula) campoCedula.focus();
            return;
        }
        if (clave.length < 6) {
            mostrarError('La contraseña institucional debe tener al menos 6 caracteres.');
            if (campoClave) campoClave.focus();
            return;
        }

        // Estado de carga replica el spinner del boton movil.
        if (botonAcceder) botonAcceder.disabled = true;
        if (textoBoton) textoBoton.textContent = 'Verificando credenciales';

        window.setTimeout(function () {
            ocultarAlertas();
            if (alertaExito && textoExito) {
                textoExito.textContent =
                    'Credenciales verificadas. Abriendo tu panel SICEU, ' +
                    (nacionalidad ? nacionalidad.value : 'V') + '-' + cedula + '.';
                alertaExito.classList.remove('hidden');
            }
            if (textoBoton) textoBoton.textContent = 'Acceso concedido';

            window.setTimeout(function () {
                window.location.href = destinoEstudiante || '/dashboard/estudiante';
            }, 500);
        }, 800);
    });
})();
