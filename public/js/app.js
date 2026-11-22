/**
 * Interactividad compartida del portal UNEFA.
 * Equivalente web de los componentes MenuDrawer y QrModal de UnefaApp,
 * mas el resaltado de la seccion activa en la navegacion.
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
     * Modal del escaner QR (partials/qr-modal.blade.php).
     * Placeholder de la maqueta: no activa la camara, solo muestra el dialogo.
     */
    var modalQr = document.getElementById('modal-qr');

    function abrirQr() {
        if (!modalQr) return;
        modalQr.classList.remove('hidden');
        modalQr.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        requestAnimationFrame(function () {
            modalQr.classList.add('qr-modal-open');
        });
    }

    function cerrarQr() {
        if (!modalQr) return;
        modalQr.classList.remove('qr-modal-open');
        modalQr.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        window.setTimeout(function () {
            modalQr.classList.add('hidden');
        }, 220);
    }

    document.querySelectorAll('[data-abrir-qr]').forEach(function (nodo) {
        nodo.addEventListener('click', abrirQr);
    });
    if (modalQr) {
        modalQr.querySelectorAll('[data-cerrar-qr]').forEach(function (nodo) {
            nodo.addEventListener('click', cerrarQr);
        });
    }

    // Escape cierra menu y modal.
    document.addEventListener('keydown', function (evento) {
        if (evento.key !== 'Escape') return;
        if (modalQr && !modalQr.classList.contains('hidden')) cerrarQr();
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
