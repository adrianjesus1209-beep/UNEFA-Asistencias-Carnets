/**
 * Interactividad del registro CINU: wizard de 3 pasos con las validaciones
 * exactas de UnefaApp (src/app/registro.tsx).
 */
(function () {
    'use strict';

    var formulario = document.getElementById('formulario-registro');

    if (!formulario) return;

    var totalPasos = 3;
    var pasoActual = 1;

    var indicadorPasos = document.getElementById('indicador-pasos');
    var alertaError = document.getElementById('alerta-error');
    var textoError = document.getElementById('texto-error');
    var panelExito = document.getElementById('panel-exito');
    var acciones = document.getElementById('acciones-formulario');
    var botonAtras = document.getElementById('boton-atras');
    var botonPrincipal = document.getElementById('boton-principal');
    var pasoActualEtiqueta = document.getElementById('paso-actual');

    var camposNacionalidad = formulario.querySelectorAll('[data-nacionalidad]');
    var campoNacionalidad = formulario.querySelector('#campo-nacionalidad');
    var campoCedula = formulario.querySelector('#campo-cedula');

    /**
     * Selector de nacionalidad V-/E- (compartido con el login).
     */
    function fijarNacionalidad(valor) {
        if (campoNacionalidad) campoNacionalidad.value = valor;
        camposNacionalidad.forEach(function (boton) {
            var activo = boton.getAttribute('data-nacionalidad') === valor;
            boton.classList.toggle('bg-unefa-blue', activo);
            var texto = boton.querySelector('span');
            if (texto) {
                texto.classList.toggle('!text-white', activo);
                texto.classList.toggle('text-slate-500', !activo);
            }
        });
    }

    camposNacionalidad.forEach(function (boton) {
        boton.addEventListener('click', function () {
            fijarNacionalidad(boton.getAttribute('data-nacionalidad'));
        });
    });
    fijarNacionalidad('V');

    /**
     * Cedula: solo digitos (maximo 8, como la aplicacion movil).
     */
    if (campoCedula) {
        campoCedula.addEventListener('input', function () {
            campoCedula.value = campoCedula.value.replace(/\D/g, '').slice(0, 8);
        });
    }

    /**
     * Botones Ver / Ocultar de ambas contrasenas.
     */
    formulario.querySelectorAll('[data-ver-clave]').forEach(function (boton) {
        boton.addEventListener('click', function () {
            var campo = document.getElementById(boton.getAttribute('data-ver-clave'));
            if (!campo) return;
            var visible = campo.type === 'text';
            campo.type = visible ? 'password' : 'text';
            boton.textContent = visible ? 'Ver' : 'Ocultar';
        });
    });

    /**
     * Valores de un grupo de radio con nombre dado.
     */
    function valorRadio(nombre) {
        var seleccion = formulario.querySelector('input[name="' + nombre + '"]:checked');
        return seleccion ? seleccion.value : '';
    }

    /**
     * Validaciones por paso, replicadas del registro movil:
     * paso 1 datos de acceso; paso 2 datos academicos; paso 3 residencia.
     */
    function validarPaso(paso) {
        var mensajes = [];

        if (paso === 1) {
            var primerNombre = formulario.querySelector('#campo-primer-nombre');
            var primerApellido = formulario.querySelector('#campo-primer-apellido');
            var cedula = campoCedula ? campoCedula.value.trim() : '';
            var email = formulario.querySelector('#campo-email');
            var clave = formulario.querySelector('#campo-clave');
            var clave2 = formulario.querySelector('#campo-clave2');

            if (!primerNombre.value.trim()) mensajes.push('El primer nombre es obligatorio.');
            if (!primerApellido.value.trim()) mensajes.push('El primer apellido es obligatorio.');
            if (cedula.length < 6) mensajes.push('El documento de identidad debe tener al menos 6 digitos.');
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) {
                mensajes.push('Ingresa un correo electronico valido.');
            }
            if (clave.value.length < 8) mensajes.push('La contraseña debe tener al menos 8 caracteres.');
            if (clave.value !== clave2.value) mensajes.push('Las contraseñas no coinciden.');
        }

        if (paso === 2) {
            var nacimiento = formulario.querySelector('#campo-nacimiento');
            var telefono = formulario.querySelector('#campo-telefono');
            var egreso = formulario.querySelector('#campo-egreso');

            if (!nacimiento.value) mensajes.push('La fecha de nacimiento es obligatoria.');
            else {
                var anio = new Date(nacimiento.value).getFullYear();
                var actual = new Date().getFullYear();
                if (anio < 1930 || anio > actual) mensajes.push('La fecha de nacimiento no es coherente.');
            }
            if (!telefono.value.trim()) mensajes.push('El telefono de contacto es obligatorio.');
            else {
                var digitos = telefono.value.replace(/\D/g, '');
                if (digitos.length < 10 || digitos.length > 11) {
                    mensajes.push('El telefono debe tener entre 10 y 11 digitos.');
                }
            }
            var genero = valorRadio('genero');
            var nivel = valorRadio('nivel_instruccion');
            var carrera = valorRadio('carrera');
            if (!genero) mensajes.push('Selecciona tu genero.');
            if (!nivel) mensajes.push('Selecciona tu nivel de instruccion.');
            if (!carrera) mensajes.push('Selecciona tu carrera de preferencia.');
            var anioEgreso = parseInt(egreso.value, 10);
            if (!egreso.value || isNaN(anioEgreso)) {
                mensajes.push('El año de egreso es obligatorio.');
            } else if (anioEgreso < 1970 || anioEgreso > 2026) {
                mensajes.push('El año de egreso debe estar entre 1970 y 2026.');
            }
        }

        if (paso === 3) {
            var municipio = formulario.querySelector('#campo-municipio');
            var parroquia = formulario.querySelector('#campo-parroquia');
            var urbanizacion = formulario.querySelector('#campo-urbanizacion');
            var calle = formulario.querySelector('#campo-calle');
            var nroCasa = formulario.querySelector('#campo-nro-casa');
            var estado = valorRadio('estado');

            if (!estado) mensajes.push('Selecciona tu estado de residencia.');
            if (!municipio.value.trim()) mensajes.push('El municipio es obligatorio.');
            if (!parroquia.value.trim()) mensajes.push('La parroquia es obligatoria.');
            if (!urbanizacion.value.trim()) mensajes.push('La urbanizacion o sector es obligatoria.');
            if (!calle.value.trim()) mensajes.push('La calle o avenida es obligatoria.');
            if (!nroCasa.value.trim()) mensajes.push('El numero de casa o edificio es obligatorio.');
        }

        return mensajes;
    }

    /**
     * Pinta el estado del indicador de pasos (barras y etiquetas).
     */
    function pintarIndicador() {
        for (var paso = 1; paso <= totalPasos; paso++) {
            var barra = formulario.parentElement.querySelector('[data-paso-barra="' + paso + '"]');
            var etiqueta = formulario.parentElement.querySelector('[data-paso-etiqueta="' + paso + '"]');
            if (!barra || !etiqueta) continue;

            var completado = paso < pasoActual;
            var actual = paso === pasoActual;

            barra.classList.toggle('bg-unefa-gold', completado || actual);
            barra.classList.toggle('bg-slate-200', !completado && !actual);

            etiqueta.classList.toggle('text-unefa-blue', actual);
            etiqueta.classList.toggle('font-extrabold', actual);
            etiqueta.classList.toggle('text-slate-500', !actual);
            etiqueta.classList.toggle('font-semibold', !actual);
        }
        if (pasoActualEtiqueta) pasoActualEtiqueta.textContent = String(pasoActual);
    }

    /**
     * Muestra el paso solicitado y ajusta las acciones.
     */
    function mostrarPaso(paso) {
        pasoActual = paso;

        formulario.querySelectorAll('[data-paso]').forEach(function (bloque) {
            bloque.classList.toggle('hidden', parseInt(bloque.getAttribute('data-paso'), 10) !== paso);
        });

        if (botonAtras) {
            botonAtras.classList.toggle('hidden', paso === 1);
            botonAtras.classList.toggle('flex', paso !== 1);
        }
        if (botonPrincipal) {
            var esFinal = paso === totalPasos;
            botonPrincipal.textContent = esFinal ? 'Enviar preinscripción →' : 'Continuar →';
        }

        pintarIndicador();

        var campoEnfocado = formulario.querySelector('[data-paso="' + paso + '"] input:not([type=hidden]):not(.sr-only)');
        if (campoEnfocado) campoEnfocado.focus();
    }

    function mostrarError(mensaje) {
        if (!alertaError || !textoError) return;
        textoError.textContent = mensaje;
        alertaError.classList.remove('hidden');
        if (alertaError.scrollIntoView) {
            alertaError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    botonAtras.addEventListener('click', function () {
        if (pasoActual > 1) {
            if (alertaError) alertaError.classList.add('hidden');
            mostrarPaso(pasoActual - 1);
        }
    });

    botonPrincipal.addEventListener('click', function () {
        var errores = validarPaso(pasoActual);
        if (errores.length > 0) {
            mostrarError(errores[0]);
            return;
        }
        if (alertaError) alertaError.classList.add('hidden');

        if (pasoActual < totalPasos) {
            mostrarPaso(pasoActual + 1);
            return;
        }

        // Paso final: envio simulado. El backend debe reemplazarlo por el
        // guardado real del expediente (POST /registro).
        if (botonPrincipal) {
            botonPrincipal.disabled = true;
            botonPrincipal.textContent = 'Enviando...';
        }
        if (acciones) acciones.classList.add('hidden');
        if (indicadorPasos) indicadorPasos.classList.add('hidden');

        window.setTimeout(function () {
            formulario.classList.add('hidden');
            if (panelExito) panelExito.classList.remove('hidden');
            if (panelExito && panelExito.scrollIntoView) {
                panelExito.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }, 700);
    });

    // Estado inicial.
    mostrarPaso(1);
})();
