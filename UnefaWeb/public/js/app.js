/**
 * Interactividad compartida del portal UNEFA.
 * Incluye el cajon de menu lateral, respaldo progresivo de <dialog>
 * y el resaltado de la seccion activa en la navegacion.
 */
(function () {
    'use strict';

    /**
     * Cajon de menu lateral (partials/header.blade.php).
     * Reproduce el MenuDrawer de la aplicacion movil con clases de transicion
     * definidas en resources/css/app.css.
     */
    var cajon = document.getElementById('cajon-menu');
    var botonMenu = document.getElementById('boton-menu');

    function abrirCajon() {
        if (!cajon) return;
        cajon.classList.remove('hidden');
        // Un frame despues aplica la clase de apertura para animar la entrada.
        requestAnimationFrame(function () {
            cajon.classList.add('menu-drawer-open');
        });
        if (botonMenu) botonMenu.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';
    }

    function cerrarCajon() {
        if (!cajon) return;
        cajon.classList.remove('menu-drawer-open');
        if (botonMenu) botonMenu.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
        // Espera la transicion antes de ocultar el contenedor.
        window.setTimeout(function () {
            cajon.classList.add('hidden');
        }, 220);
    }

    if (botonMenu) {
        botonMenu.addEventListener('click', abrirCajon);
    }
    if (cajon) {
        cajon.querySelectorAll('[data-cerrar-menu]').forEach(function (nodo) {
            nodo.addEventListener('click', cerrarCajon);
        });
    }

    /**
     * Respaldo progresivo para <dialog> con Invoker Commands y closedby="any"
     * en navegadores sin soporte nativo (Safari / versiones anteriores).
     */
    if (!('commandForElement' in HTMLButtonElement.prototype)) {
        document.querySelectorAll('button[command="show-modal"][commandfor]').forEach(function (boton) {
            boton.addEventListener('click', function () {
                var objetivo = document.getElementById(boton.getAttribute('commandfor'));
                if (objetivo && typeof objetivo.showModal === 'function' && !objetivo.open) {
                    objetivo.showModal();
                }
            });
        });
    }

    if (!('closedBy' in HTMLDialogElement.prototype)) {
        var fueraDelDialogo = function (evento, dialogo) {
            var rect = dialogo.getBoundingClientRect();
            return (
                evento.clientX < rect.left ||
                evento.clientX > rect.right ||
                evento.clientY < rect.top ||
                evento.clientY > rect.bottom
            );
        };

        document.querySelectorAll('dialog[closedby="any"]').forEach(function (dialogo) {
            var presionadoFuera = false;
            dialogo.addEventListener('pointerdown', function (evento) {
                presionadoFuera = fueraDelDialogo(evento, dialogo);
            });
            dialogo.addEventListener('pointerup', function (evento) {
                if (presionadoFuera && fueraDelDialogo(evento, dialogo)) {
                    dialogo.close();
                }
                presionadoFuera = false;
            });
        });
    }

    // Teclado: Escape cierra el cajon de menu lateral.
    document.addEventListener('keydown', function (evento) {
        if (evento.key !== 'Escape') return;
        if (cajon && !cajon.classList.contains('hidden')) cerrarCajon();
    });

    /**
     * Resaltado de la seccion visible en la barra superior (solo landing).
     * Replica el scroll-spy del Header movil: observa cada seccion y marca
     * el enlace correspondiente.
     */
    var enlacesNav = document.querySelectorAll('[data-nav-link]');
    var secciones = document.querySelectorAll('[data-seccion-nav]');

    if (enlacesNav.length > 0 && secciones.length > 0 && 'IntersectionObserver' in window) {
        var observador = new IntersectionObserver(
            function (entradas) {
                entradas.forEach(function (entrada) {
                    if (!entrada.isIntersecting) return;
                    var id = entrada.target.getAttribute('data-seccion-nav');
                    enlacesNav.forEach(function (enlace) {
                        var activo = enlace.getAttribute('data-nav-link') === id;
                        enlace.classList.toggle('text-unefa-blue', activo);
                        enlace.classList.toggle('bg-slate-100', activo);
                    });
                });
            },
            { rootMargin: '-45% 0px -50% 0px' }
        );
        secciones.forEach(function (seccion) {
            observador.observe(seccion);
        });
    }
})();
