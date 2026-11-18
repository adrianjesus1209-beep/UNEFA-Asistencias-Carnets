/**
 * Interactividad de la landing: pestanas de pilares, explorador de carreras
 * y verificador de recaudos CINU. Equivalente web de src/app/landing.tsx.
 */
(function () {
    'use strict';

    /**
     * Pestanas de pilares (seccion 02): muestra la ficha del pilar activo y
     * resalta el boton correspondiente. Replica los tabs de data.ts.
     */
    var pestañasPilar = document.querySelectorAll('[data-pilar-tab]');
    var fichasPilar = document.querySelectorAll('[data-pilar-ficha]');

    function activarPilar(clave) {
        pestañasPilar.forEach(function (boton) {
            var activo = boton.getAttribute('data-pilar-tab') === clave;
            boton.setAttribute('aria-selected', activo ? 'true' : 'false');
            // Bordes y colores del boton activo.
            boton.classList.toggle('!border-unefa-blue', activo);
            boton.classList.toggle('!bg-unefa-blue/[0.06]', activo);
            boton.querySelectorAll('[data-pilar-num], [data-pilar-titulo]').forEach(function (texto) {
                texto.classList.toggle('!text-unefa-blue', activo);
                texto.classList.toggle('text-slate-500', !activo);
                texto.classList.toggle('text-neutral-950', !activo);
            });
        });
        fichasPilar.forEach(function (ficha) {
            ficha.classList.toggle('hidden', ficha.getAttribute('data-pilar-ficha') !== clave);
        });
    }

    pestañasPilar.forEach(function (boton) {
        boton.addEventListener('click', function () {
            activarPilar(boton.getAttribute('data-pilar-tab'));
        });
    });

    /**
     * Explorador de carreras (seccion 03): segmento por facultad y ficha por
     * carrera. Replica los controles segmentados de landing.tsx.
     */
    var pestañasFacultad = document.querySelectorAll('[data-facultad-tab]');
    var listasFacultad = document.querySelectorAll('[data-facultad-lista]');
    var fichasCarrera = document.querySelectorAll('[data-carrera-ficha]');

    function activarFacultad(clave) {
        pestañasFacultad.forEach(function (boton) {
            var activo = boton.getAttribute('data-facultad-tab') === clave;
            boton.setAttribute('aria-selected', activo ? 'true' : 'false');
            boton.classList.toggle('!bg-unefa-blue', activo);
            var titulo = boton.querySelector('[data-facultad-titulo]');
            if (titulo) {
                titulo.classList.toggle('!text-white', activo);
                titulo.classList.toggle('text-neutral-950', !activo);
            }
            var nota = boton.querySelector('span:last-child');
            if (nota) {
                nota.classList.toggle('text-slate-400', activo);
                nota.classList.toggle('text-slate-500', !activo);
            }
        });
        // Las listas alternan hidden y grid (todas usan grid en escritorio).
        listasFacultad.forEach(function (lista) {
            var activa = lista.getAttribute('data-facultad-lista') === clave;
            lista.classList.toggle('hidden', !activa);
            lista.classList.toggle('grid', activa);
        });
    }

    pestañasFacultad.forEach(function (boton) {
        boton.addEventListener('click', function () {
            activarFacultad(boton.getAttribute('data-facultad-tab'));
        });
    });

    function activarCarrera(clave) {
        var esNuevaFacultad = false;
        document.querySelectorAll('[data-carrera-item]').forEach(function (boton) {
            var activo = boton.getAttribute('data-carrera-item') === clave;
            boton.classList.toggle('!border-unefa-blue', activo);
            boton.classList.toggle('!bg-unefa-blue/[0.05]', activo);
            boton.querySelectorAll('[data-carrera-codigo], [data-carrera-titulo]').forEach(function (texto) {
                texto.classList.toggle('!text-unefa-blue', activo);
                texto.classList.toggle('text-slate-500', !activo && texto.hasAttribute('data-carrera-codigo'));
                texto.classList.toggle('text-neutral-950', !activo && !texto.hasAttribute('data-carrera-codigo'));
            });
        });
        fichasCarrera.forEach(function (ficha) {
            var visible = ficha.getAttribute('data-carrera-ficha') === clave;
            ficha.classList.toggle('hidden', !visible);
            if (visible) {
                // Muestra la facultad correspondiente a la carrera elegida.
                var mapa = {
                    sistemas: 'ingenieria',
                    telecom: 'ingenieria',
                    mecanica: 'ingenieria',
                    electronica: 'ingenieria',
                    administracion: 'licenciaturas',
                    enfermeria: 'licenciaturas',
                    'tsu-sistemas': 'tsu',
                    'tsu-enfermeria': 'tsu'
                };
                var facultad = mapa[clave];
                if (facultad) {
                    var listaVisible = document.querySelector(
                        '[data-facultad-lista="' + facultad + '"]:not(.hidden)'
                    );
                    if (!listaVisible) esNuevaFacultad = true;
                }
            }
        });
        if (esNuevaFacultad) {
            var mapaInverso = {
                sistemas: 'ingenieria',
                telecom: 'ingenieria',
                mecanica: 'ingenieria',
                electronica: 'ingenieria',
                administracion: 'licenciaturas',
                enfermeria: 'licenciaturas',
                'tsu-sistemas': 'tsu',
                'tsu-enfermeria': 'tsu'
            };
            var facultadClave = mapaInverso[clave];
            if (facultadClave) activarFacultad(facultadClave);
        }
    }

    document.querySelectorAll('[data-carrera-item]').forEach(function (boton) {
        boton.addEventListener('click', function () {
            activarCarrera(boton.getAttribute('data-carrera-item'));
        });
    });

    /**
     * Verificador de recaudos (seccion 04): recalcula el porcentaje y el
     * mensaje al marcar o desmarcar cada casilla. Replica la logica de
     * CHECKLIST_ITEMS de data.ts (items 1 y 2 marcados por defecto = 33%).
     */
    var casillas = document.querySelectorAll('[data-recaudo]');
    var barra = document.getElementById('barra-recaudos');
    var porcentaje = document.getElementById('porcentaje-recaudos');
    var mensaje = document.getElementById('texto-mensaje-recaudos');
    var total = casillas.length;

    function actualizarRecaudos() {
        var marcadas = 0;
        casillas.forEach(function (casilla) {
            var caja = casilla.closest('label').querySelector('[data-caja-recaudo]');
            var marca = casilla.closest('label').querySelector('[data-marca-recaudo]');
            var texto = casilla.closest('label').querySelector('[data-texto-recaudo]');
            var marcada = casilla.checked;
            if (marcada) marcadas++;

            caja.classList.toggle('!border-unefa-blue', marcada);
            caja.classList.toggle('!bg-unefa-blue', marcada);
            caja.classList.toggle('bg-white', !marcada);
            marca.classList.toggle('hidden', !marcada);
            texto.classList.toggle('!font-bold', marcada);
            texto.classList.toggle('font-medium', !marcada);

            var etiqueta = casilla.closest('label');
            etiqueta.classList.toggle('!border-unefa-blue', marcada);
            etiqueta.classList.toggle('!bg-unefa-blue/[0.04]', marcada);
        });

        var avance = total > 0 ? Math.round((marcadas / total) * 100) : 0;
        if (barra) barra.style.width = avance + '%';
        if (porcentaje) porcentaje.textContent = avance + '%';
        if (mensaje) {
            mensaje.textContent =
                avance === 100
                    ? 'Excelente. Ya puedes iniciar tu preinscripción digital.'
                    : 'Tienes ' + marcadas + ' de ' + total + ' recaudos completados.';
        }
    }

    casillas.forEach(function (casilla) {
        casilla.addEventListener('change', actualizarRecaudos);
    });

    // Estado inicial coherente con los checkboxes marcados en el HTML.
    actualizarRecaudos();
})();
