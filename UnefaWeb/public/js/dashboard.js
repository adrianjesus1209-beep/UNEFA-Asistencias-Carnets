/**
 * Interactividad unificada del Portal SICEU (UNEFA).
 * Agrupa el shell comun (inactividad RF-05, sidebar, notificaciones, dialogos)
 * y los controladores por seccion del dashboard.
 */
(function () {
    'use strict';

    var loginUrl = document.body.getAttribute('data-login-url') || '/login';

    // Respaldo progresivo para Invoker Commands y closedby="any" en navegadores sin soporte nativo.
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

    // -------------------------------------------------------------------------
    // Modulo comun del shell: Inactividad RF-05, Sidebar, Notificaciones, Sesion
    // -------------------------------------------------------------------------
    var INACTIVITY_LIMIT = 600;
    var remainingSeconds = INACTIVITY_LIMIT;
    var timerInterval = null;

    var timerDisplays = document.querySelectorAll('[data-inactivity-timer]');
    var timerBars = document.querySelectorAll('[data-inactivity-bar]');
    var sessionExpiredDialog = document.getElementById('sessionExpiredDialog');
    var logoutDialog = document.getElementById('logoutDialog');
    var sidebar = document.getElementById('dashboardSidebar');
    var sidebarBackdrop = document.getElementById('sidebarBackdrop');
    var mobileToggle = document.getElementById('mobileSidebarToggle');
    var notifToggle = document.getElementById('notifPopoverToggle');
    var notifPopover = document.getElementById('notifPopover');
    var notifBadge = document.getElementById('notifBadgeCount');
    var markAllReadBtn = document.getElementById('markAllNotifRead');

    function formatTime(sec) {
        var m = String(Math.floor(sec / 60)).padStart(2, '0');
        var s = String(sec % 60).padStart(2, '0');
        return m + ':' + s;
    }

    function renderTimer() {
        var formatted = formatTime(remainingSeconds);
        timerDisplays.forEach(function (el) {
            el.textContent = formatted;
            el.classList.toggle('text-unefa-gold', remainingSeconds <= 60);
        });
        var pct = Math.max(0, (remainingSeconds / INACTIVITY_LIMIT) * 100);
        timerBars.forEach(function (bar) {
            bar.style.width = pct + '%';
        });
    }

    function resetInactivity() {
        if (remainingSeconds <= 0) return;
        remainingSeconds = INACTIVITY_LIMIT;
        renderTimer();
    }

    function startInactivityWatch() {
        renderTimer();
        timerInterval = window.setInterval(function () {
            remainingSeconds -= 1;
            renderTimer();
            if (remainingSeconds <= 0) {
                window.clearInterval(timerInterval);
                if (sessionExpiredDialog && typeof sessionExpiredDialog.showModal === 'function' && !sessionExpiredDialog.open) {
                    sessionExpiredDialog.showModal();
                }
            }
        }, 1000);

        ['click', 'keydown', 'pointerdown', 'scroll'].forEach(function (evt) {
            window.addEventListener(evt, resetInactivity, { passive: true });
        });
    }

    function setSidebarOpen(open) {
        if (!sidebar || !sidebarBackdrop || !mobileToggle) return;
        sidebar.classList.toggle('-translate-x-full', !open);
        sidebarBackdrop.classList.toggle('hidden', !open);
        mobileToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    }

    if (mobileToggle) {
        mobileToggle.addEventListener('click', function () {
            var isOpen = mobileToggle.getAttribute('aria-expanded') === 'true';
            setSidebarOpen(!isOpen);
        });
    }
    if (sidebarBackdrop) {
        sidebarBackdrop.addEventListener('click', function () {
            setSidebarOpen(false);
        });
    }

    function setNotifOpen(open) {
        if (!notifPopover || !notifToggle) return;
        notifPopover.classList.toggle('hidden', !open);
        notifToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    }

    if (notifToggle && notifPopover) {
        notifToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            setNotifOpen(notifPopover.classList.contains('hidden'));
        });

        document.addEventListener('click', function (e) {
            if (!notifPopover.contains(e.target) && !notifToggle.contains(e.target)) {
                setNotifOpen(false);
            }
        });
    }

    if (markAllReadBtn) {
        markAllReadBtn.addEventListener('click', function () {
            if (notifBadge) notifBadge.classList.add('hidden');
            document.querySelectorAll('[data-notif-unread]').forEach(function (dot) {
                dot.classList.add('hidden');
            });
        });
    }

    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;
        if (notifPopover && !notifPopover.classList.contains('hidden')) {
            setNotifOpen(false);
            if (notifToggle) notifToggle.focus();
        }
        if (mobileToggle && mobileToggle.getAttribute('aria-expanded') === 'true') {
            setSidebarOpen(false);
            mobileToggle.focus();
        }
    });

    document.querySelectorAll('[data-open-logout]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            if (logoutDialog && typeof logoutDialog.showModal === 'function') {
                logoutDialog.showModal();
            } else {
                window.location.href = loginUrl;
            }
        });
    });

    var cancelLogoutBtn = document.getElementById('cancelLogoutBtn');
    if (cancelLogoutBtn) {
        cancelLogoutBtn.addEventListener('click', function () {
            if (logoutDialog) logoutDialog.close();
        });
    }

    var confirmLogoutBtn = document.getElementById('confirmLogoutBtn');
    if (confirmLogoutBtn) {
        confirmLogoutBtn.addEventListener('click', function () {
            window.location.href = loginUrl;
        });
    }

    var confirmExpiredBtn = document.getElementById('confirmExpiredBtn');
    if (confirmExpiredBtn) {
        confirmExpiredBtn.addEventListener('click', function () {
            window.location.href = loginUrl;
        });
    }

    startInactivityWatch();

    // -------------------------------------------------------------------------
    // Seccion Inicio: Temporizador de tolerancia y barra de rotacion QR
    // -------------------------------------------------------------------------
    var tolEl = document.getElementById('dashToleranceClock');
    var qrEl = document.getElementById('dashQrCountdown');
    var qrBar = document.getElementById('dashQrBar');

    if (tolEl || qrEl || qrBar) {
        var tolSec = 11 * 60;
        var qrSec = 46;

        window.setInterval(function () {
            if (tolSec > 0) {
                tolSec -= 1;
                if (tolEl) tolEl.textContent = formatTime(tolSec);
            }
            qrSec = qrSec <= 1 ? 60 : qrSec - 1;
            if (qrEl) qrEl.textContent = qrSec + 's';
            if (qrBar) qrBar.style.width = ((qrSec / 60) * 100) + '%';
        }, 1000);
    }

    // -------------------------------------------------------------------------
    // Seccion Carnet: Tabs Anverso/Reverso + Rotacion QR Dinamico
    // -------------------------------------------------------------------------
    var tablist = document.getElementById('cardSideTablist');
    var tabAnverso = document.getElementById('tabAnverso');
    var tabReverso = document.getElementById('tabReverso');
    var panelAnverso = document.getElementById('panelAnverso');
    var panelReverso = document.getElementById('panelReverso');

    if (tablist && tabAnverso && tabReverso && panelAnverso && panelReverso) {
        var selectSide = function (side) {
            var isFront = side === 'anverso';
            tabAnverso.setAttribute('aria-selected', isFront ? 'true' : 'false');
            tabAnverso.tabIndex = isFront ? 0 : -1;
            tabReverso.setAttribute('aria-selected', isFront ? 'false' : 'true');
            tabReverso.tabIndex = isFront ? -1 : 0;
            panelAnverso.hidden = !isFront;
            panelReverso.hidden = isFront;
        };

        tabAnverso.addEventListener('click', function () { selectSide('anverso'); });
        tabReverso.addEventListener('click', function () { selectSide('reverso'); });
        tablist.addEventListener('keydown', function (e) {
            if (e.key === 'ArrowLeft' || e.key === 'ArrowRight' || e.key === 'Home' || e.key === 'End') {
                e.preventDefault();
                var next = e.key === 'Home'
                    ? 'anverso'
                    : e.key === 'End'
                        ? 'reverso'
                        : (tabAnverso.getAttribute('aria-selected') === 'true' ? 'reverso' : 'anverso');
                selectSide(next);
                (next === 'anverso' ? tabAnverso : tabReverso).focus();
            }
        });
    }

    var cardQrSecEl = document.getElementById('cardQrSeconds');
    var cardQrBarEl = document.getElementById('cardQrProgress');
    var cardQrTokenEl = document.getElementById('qrTokenId');
    var cardQrSvg = document.getElementById('cardDynamicQrSvg');

    if (cardQrSecEl || cardQrBarEl || cardQrSvg) {
        var qrCountdown = 60;

        var updateCardQrUI = function () {
            if (cardQrSecEl) cardQrSecEl.textContent = qrCountdown + 's';
            if (cardQrBarEl) cardQrBarEl.style.width = ((qrCountdown / 60) * 100) + '%';
        };

        var rotateToken = function () {
            qrCountdown = 60;
            var hex = Math.floor(100000 + Math.random() * 900000);
            if (cardQrTokenEl) cardQrTokenEl.textContent = 'Token: hmac-2026-' + hex + '-008492';
            if (cardQrSvg) {
                cardQrSvg.querySelectorAll('rect').forEach(function (r, idx) {
                    if (idx > 40 && idx % 5 === 0) {
                        r.setAttribute('fill', Math.random() > 0.5 ? '#06152a' : '#ffffff');
                    }
                });
            }
            updateCardQrUI();
        };

        window.setInterval(function () {
            qrCountdown -= 1;
            if (qrCountdown <= 0) {
                rotateToken();
            } else {
                updateCardQrUI();
            }
        }, 1000);

        var btnRotateQrNow = document.getElementById('btnRotateQrNow');
        if (btnRotateQrNow) btnRotateQrNow.addEventListener('click', rotateToken);
    }

    // -------------------------------------------------------------------------
    // Seccion Actualizar Fotografia: Zoom, Rotacion y Validacion 3:4
    // -------------------------------------------------------------------------
    var cropImg = document.getElementById('cropImageEl');
    if (cropImg) {
        var zoom = 115;
        var rotation = 0;
        var fileInput = document.getElementById('photoFileInput');
        var previewImg = document.getElementById('previewCardPhoto');
        var zoomRange = document.getElementById('zoomRange');
        var zoomValue = document.getElementById('zoomValue');
        var metaPill = document.getElementById('photoMetaPill');
        var photoAlertBox = document.getElementById('photoAlertBox');

        var applyTransform = function () {
            var t = 'scale(' + (zoom / 100) + ') rotate(' + rotation + 'deg)';
            cropImg.style.transform = t;
            if (previewImg) previewImg.style.transform = t;
            if (zoomValue) zoomValue.textContent = zoom + '%';
        };

        if (zoomRange) {
            zoomRange.addEventListener('input', function () {
                zoom = parseInt(zoomRange.value, 10);
                applyTransform();
            });
        }

        var btnRotatePhoto = document.getElementById('btnRotatePhoto');
        if (btnRotatePhoto) {
            btnRotatePhoto.addEventListener('click', function () {
                rotation = (rotation + 90) % 360;
                applyTransform();
            });
        }

        var btnResetCrop = document.getElementById('btnResetCrop');
        if (btnResetCrop) {
            btnResetCrop.addEventListener('click', function () {
                zoom = 115;
                rotation = 0;
                if (zoomRange) zoomRange.value = '115';
                applyTransform();
            });
        }

        if (fileInput) {
            fileInput.addEventListener('change', function () {
                var file = fileInput.files && fileInput.files[0];
                if (!file) return;
                if (photoAlertBox) photoAlertBox.classList.add('hidden');

                if (file.type !== 'image/jpeg' && file.type !== 'image/png') {
                    if (photoAlertBox) {
                        photoAlertBox.textContent = 'ERROR_VALIDACION: Solo se admiten imágenes en formato JPEG o PNG.';
                        photoAlertBox.classList.remove('hidden');
                    }
                    return;
                }

                if (file.size > 5 * 1024 * 1024) {
                    if (photoAlertBox) {
                        photoAlertBox.textContent = 'ERROR_VALIDACION: El archivo supera el límite máximo permitido de 5 MB.';
                        photoAlertBox.classList.remove('hidden');
                    }
                    return;
                }

                var reader = new FileReader();
                reader.onload = function (ev) {
                    var src = ev.target.result;
                    var probe = new Image();
                    probe.onload = function () {
                        cropImg.src = src;
                        if (previewImg) previewImg.src = src;
                        var sizeMb = (file.size / (1024 * 1024)).toFixed(2).replace('.', ',');
                        var ext = file.type === 'image/png' ? 'PNG' : 'JPEG';
                        var validDims = probe.width >= 600 && probe.height >= 800;
                        if (metaPill) {
                            metaPill.textContent = (validDims ? '✓ ' : '⚠ ') + probe.width + ' × ' + probe.height + ' px · ' + ext + ' · ' + sizeMb + ' MB · ' + (validDims ? 'Formato válido' : 'Resolución inferior a 600×800');
                            metaPill.className = validDims
                                ? 'inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-[#d1fae5] text-[#065f46] text-xs font-mono font-bold'
                                : 'inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-[#ffdad6] text-[#93000a] text-xs font-mono font-bold';
                        }
                    };
                    probe.src = src;
                };
                reader.readAsDataURL(file);
            });
        }
    }

    // -------------------------------------------------------------------------
    // Seccion Escaner: Camara web y simulacion de respuestas API
    // -------------------------------------------------------------------------
    var btnWebcam = document.getElementById('btnToggleWebcam');
    if (btnWebcam || document.querySelector('[data-sim-scan]')) {
        var mediaStream = null;
        var videoEl = document.getElementById('realWebcamVideo');
        var simEl = document.getElementById('simulatedViewfinder');
        var scanCard = document.getElementById('scanResultCard');
        var scanIcon = document.getElementById('scanResultIcon');
        var scanHeading = document.getElementById('scanResultHeading');
        var scanDetail = document.getElementById('scanResultDetail');
        var scanMeta = document.getElementById('scanResultMeta');

        var SCAN_STYLES = {
            present: {
                card: 'mt-4 p-4 rounded-xl border-2 border-unefa-green bg-[#d1fae5]/35 flex items-start gap-3.5',
                icon: 'w-10 h-10 rounded-full bg-unefa-green text-white flex items-center justify-center shrink-0 font-black',
                sym: '✓',
                h: 'text-sm font-black uppercase tracking-wide text-[#065f46]'
            },
            late: {
                card: 'mt-4 p-4 rounded-xl border-2 border-unefa-gold-dark bg-unefa-gold/15 flex items-start gap-3.5',
                icon: 'w-10 h-10 rounded-full bg-unefa-gold text-unefa-navy flex items-center justify-center shrink-0 font-black',
                sym: '!',
                h: 'text-sm font-black uppercase tracking-wide text-unefa-navy'
            },
            error: {
                card: 'mt-4 p-4 rounded-xl border-2 border-unefa-red bg-[#ffdad6] flex items-start gap-3.5',
                icon: 'w-10 h-10 rounded-full bg-unefa-red text-white flex items-center justify-center shrink-0 font-black',
                sym: '✕',
                h: 'text-sm font-black uppercase tracking-wide text-[#93000a]'
            }
        };

        var updateResultCard = function (type, title, desc, sub) {
            if (!scanCard || !SCAN_STYLES[type]) return;
            var st = SCAN_STYLES[type];
            scanCard.className = st.card;
            if (scanIcon) { scanIcon.className = st.icon; scanIcon.textContent = st.sym; }
            if (scanHeading) { scanHeading.className = st.h; scanHeading.textContent = title; }
            if (scanDetail) scanDetail.textContent = desc;
            if (scanMeta) scanMeta.textContent = sub;
        };

        if (btnWebcam) {
            btnWebcam.addEventListener('click', function () {
                if (mediaStream) {
                    mediaStream.getTracks().forEach(function (t) { t.stop(); });
                    mediaStream = null;
                    if (videoEl) videoEl.classList.add('hidden');
                    if (simEl) simEl.classList.remove('hidden');
                    btnWebcam.textContent = 'Activar Cámara Real';
                    return;
                }
                if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                    updateResultCard('error', 'SIN_PERMISOS_CAMARA', 'El navegador no soporta captura de cámara web.', 'Verifique los permisos o use HTTPS.');
                    return;
                }
                navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
                    .then(function (stream) {
                        mediaStream = stream;
                        if (videoEl) {
                            videoEl.srcObject = mediaStream;
                            videoEl.classList.remove('hidden');
                        }
                        if (simEl) simEl.classList.add('hidden');
                        btnWebcam.textContent = 'Detener Cámara';
                    })
                    .catch(function () {
                        updateResultCard('error', 'SIN_PERMISOS_CAMARA', 'No se pudo acceder a la cámara web del dispositivo.', 'Verifique los permisos del navegador para usar el escáner QR.');
                    });
            });
        }

        var SCENARIOS = {
            present: ['present', 'ASISTENCIA REGISTRADA · PRESENTE', 'Ingeniería de Software (01S-2610-D1) · Prof. Elena Rivas · Aula B-204', '08:52:14 AM · Registrado dentro del margen de tolerancia (15 min)'],
            late: ['late', 'ASISTENCIA REGISTRADA · TARDANZA (LATE)', 'Ingeniería de Software (01S-2610-D1) · Prof. Elena Rivas · Aula B-204', '09:04:19 AM · Escaneo posterior a la tolerancia con sesión abierta'],
            duplicate: ['error', '409 · ASISTENCIA_YA_REGISTRADA', 'Tu asistencia ya fue registrada en esta sesión de clase.', 'El sistema impide registros duplicados mediante restricción única en PostgreSQL.'],
            expired: ['error', '401 · TOKEN_QR_EXPIRADO', 'El código QR ha vencido. Solicita que se actualice e intenta de nuevo.', 'Los códigos de aula rotan cada 30 s con vigencia máxima de 45 s.']
        };

        document.querySelectorAll('[data-sim-scan]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var s = SCENARIOS[btn.getAttribute('data-sim-scan')];
                if (s) updateResultCard(s[0], s[1], s[2], s[3]);
            });
        });
    }

    // -------------------------------------------------------------------------
    // Seccion Horario: Modal de detalle de asignatura y planilla PDF
    // -------------------------------------------------------------------------
    var scheduleDlg = document.getElementById('scheduleDialog');
    if (scheduleDlg) {
        var COURSES = {
            'ING-SIS-601': { name: 'Ingeniería de Software', teacher: 'Prof. Elena Rivas', room: 'Aula B-204 (Edif. Académico)', uc: 5, slots: 'Lunes y Jueves · 08:45 - 10:15' },
            'ING-SIS-602': { name: 'Bases de Datos II', teacher: 'Prof. Marcos Pérez', room: 'Lab. Comp. 2 (Piso 1)', uc: 5, slots: 'Martes y Viernes · 08:45 - 10:15' },
            'ING-SIS-603': { name: 'Redes y Teleproceso', teacher: 'Prof. Juan Blanco', room: 'Aula B-108 (Edif. Académico)', uc: 4, slots: 'Miércoles y Jueves · 10:30 - 12:00' },
            'ING-SIS-604': { name: 'Sistemas Operativos', teacher: 'Prof. Manuel Silva', room: 'Lab. Linux 1 (Piso 2)', uc: 4, slots: 'Lunes 10:30 - 12:00 · Miércoles 12:00 - 13:30' },
            'DEF-605': { name: 'Defensa Integral VI', teacher: 'Prof. Luis Vásquez', room: 'Patio de Honor', uc: 4, slots: 'Jueves · 14:00 - 15:30' }
        };

        var dlgTitle = document.getElementById('scheduleDialogTitle');
        var dlgBody = document.getElementById('scheduleDialogBody');

        var appendTerm = function (dl, label, value, valueClass) {
            var wrap = document.createElement('div');
            var dt = document.createElement('dt');
            dt.className = 'text-xs font-bold uppercase text-text-muted';
            dt.textContent = label;
            var dd = document.createElement('dd');
            dd.className = valueClass || 'font-semibold';
            dd.textContent = value;
            wrap.appendChild(dt);
            wrap.appendChild(dd);
            dl.appendChild(wrap);
        };

        document.querySelectorAll('[data-course-modal]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var code = btn.getAttribute('data-course-modal');
                var c = COURSES[code];
                if (!c || !dlgTitle || !dlgBody) return;

                dlgTitle.textContent = code + ' · ' + c.name;
                dlgBody.textContent = '';

                var dl = document.createElement('dl');
                dl.className = 'space-y-2';
                appendTerm(dl, 'Docente Titular', c.teacher, 'font-bold text-unefa-navy');
                appendTerm(dl, 'Ubicación / Aula', c.room, 'font-semibold');
                appendTerm(dl, 'Bloques Horarios', c.slots, 'font-mono text-xs font-bold text-unefa-blue');
                appendTerm(dl, 'Unidades de Crédito', c.uc + ' U.C. · Sección 01S-2610-D1', 'font-bold');
                dlgBody.appendChild(dl);

                scheduleDlg.showModal();
            });
        });

        var btnPlanilla = document.getElementById('btnDownloadPlanilla');
        if (btnPlanilla) {
            btnPlanilla.addEventListener('click', function () {
                if (!dlgTitle || !dlgBody) return;
                dlgTitle.textContent = 'Planilla de Inscripción 2026-II (PDF)';
                dlgBody.textContent = '';

                var p = document.createElement('p');
                p.textContent = 'Se ha preparado su Planilla de Inscripción Oficial desde el servidor (GET /api/reports/enrollment-form/me/pdf).';
                var box = document.createElement('div');
                box.className = 'mt-3 p-3 rounded-md bg-bg-secondary border border-border-primary font-mono text-xs text-unefa-navy';
                box.textContent = 'planilla_inscripcion_2026-II_V28450123.pdf · 5 materias · 22 U.C.';
                dlgBody.appendChild(p);
                dlgBody.appendChild(box);

                scheduleDlg.showModal();
            });
        }
    }

    // -------------------------------------------------------------------------
    // Seccion Asistencia: Maestro-Detalle por asignatura y filtros de estado
    // -------------------------------------------------------------------------
    var subjectListEl = document.getElementById('subjectProgressList');
    var attTbodyEl = document.getElementById('attendanceTableBody');
    if (subjectListEl && attTbodyEl) {
        var SUBJECTS = [
            {
                code: 'ING-SIS-601',
                name: 'Ingeniería de Software',
                teacher: 'Prof. Elena Rivas',
                pct: 95,
                alert: false,
                records: [
                    { date: '26 Nov · 08:52 AM', mod: 'Modalidad A (QR Aula)', status: 'PRESENT', note: 'Dentro de tolerancia (15 min)' },
                    { date: '23 Nov · 08:49 AM', mod: 'Modalidad A (QR Aula)', status: 'PRESENT', note: 'Dentro de tolerancia' },
                    { date: '19 Nov · 09:03 AM', mod: 'Modalidad A (QR Aula)', status: 'LATE', note: 'Registro 3 min tras tolerancia' },
                    { date: '16 Nov · 08:47 AM', mod: 'Modalidad B (Carnet)', status: 'PRESENT', note: 'Carnet escaneado por docente' }
                ]
            },
            {
                code: 'ING-SIS-602',
                name: 'Bases de Datos II',
                teacher: 'Prof. Marcos Pérez',
                pct: 88,
                alert: false,
                records: [
                    { date: '24 Nov · 08:51 AM', mod: 'Modalidad A (QR Aula)', status: 'PRESENT', note: 'Dentro de tolerancia' },
                    { date: '20 Nov · 09:05 AM', mod: 'Modalidad A (QR Aula)', status: 'LATE', note: 'Registro fuera de tolerancia' },
                    { date: '17 Nov · 08:48 AM', mod: 'Modalidad B (Carnet)', status: 'PRESENT', note: 'Carnet escaneado en laboratorio' }
                ]
            },
            {
                code: 'ING-SIS-603',
                name: 'Redes y Teleproceso',
                teacher: 'Prof. Juan Blanco',
                pct: 100,
                alert: false,
                records: [
                    { date: '25 Nov · 10:33 AM', mod: 'Modalidad A (QR Aula)', status: 'PRESENT', note: 'Dentro de tolerancia' },
                    { date: '19 Nov · 10:31 AM', mod: 'Modalidad A (QR Aula)', status: 'PRESENT', note: 'Dentro de tolerancia' },
                    { date: '18 Nov · 10:35 AM', mod: 'Modalidad B (Carnet)', status: 'PRESENT', note: 'Verificación presencial' }
                ]
            },
            {
                code: 'ING-SIS-604',
                name: 'Sistemas Operativos',
                teacher: 'Prof. Manuel Silva',
                pct: 76,
                alert: true,
                records: [
                    { date: '25 Nov · 12:04 PM', mod: 'Modalidad A (QR Aula)', status: 'PRESENT', note: 'Dentro de tolerancia' },
                    { date: '23 Nov · 10:51 AM', mod: 'Modalidad A (QR Aula)', status: 'LATE', note: 'Registro 6 min tras tolerancia' },
                    { date: '18 Nov · 12:00 PM', mod: 'Manual (Docente)', status: 'JUSTIFIED', note: 'Reposo médico avalado por Coordinación' },
                    { date: '16 Nov · 10:30 AM', mod: 'Cierre Automático', status: 'ABSENT', note: 'Sin registro al cierre de sesión' },
                    { date: '11 Nov · 12:02 PM', mod: 'Modalidad B (Carnet)', status: 'PRESENT', note: 'Carnet escaneado en aula' }
                ]
            },
            {
                code: 'DEF-605',
                name: 'Defensa Integral VI',
                teacher: 'Prof. Luis Vásquez',
                pct: 100,
                alert: false,
                records: [
                    { date: '19 Nov · 02:02 PM', mod: 'Modalidad B (Carnet)', status: 'PRESENT', note: 'Formación en Patio de Honor' },
                    { date: '12 Nov · 02:00 PM', mod: 'Modalidad B (Carnet)', status: 'PRESENT', note: 'Formación en Patio de Honor' }
                ]
            }
        ];

        var BADGE_INFO = {
            PRESENT: { text: 'PRESENTE', cls: 'inline-flex px-2.5 py-0.5 rounded bg-[#d1fae5] text-[#065f46] text-xs font-extrabold' },
            LATE: { text: 'TARDANZA', cls: 'inline-flex px-2.5 py-0.5 rounded bg-unefa-gold/25 text-unefa-navy border border-unefa-gold-dark text-xs font-extrabold' },
            JUSTIFIED: { text: 'JUSTIFICADA', cls: 'inline-flex px-2.5 py-0.5 rounded bg-unefa-blue text-white text-xs font-extrabold' },
            ABSENT: { text: 'AUSENTE', cls: 'inline-flex px-2.5 py-0.5 rounded bg-unefa-red text-white text-xs font-extrabold' }
        };

        var activeCode = 'ING-SIS-604';
        var activeFilter = 'ALL';
        var detailHeading = document.getElementById('detailHeading');
        var detailSub = document.getElementById('detailSubheading');
        var tableFooter = document.getElementById('attendanceTableFooter');

        var renderTable = function () {
            var sub = SUBJECTS.find(function (s) { return s.code === activeCode; }) || SUBJECTS[0];
            if (detailHeading) detailHeading.textContent = 'Detalle de Sesiones — ' + sub.name;
            if (detailSub) detailSub.textContent = sub.code + ' · Sec. 01S-2610-D1 · ' + sub.teacher;

            var rows = activeFilter === 'ALL'
                ? sub.records
                : sub.records.filter(function (r) { return r.status === activeFilter; });

            attTbodyEl.textContent = '';

            if (rows.length === 0) {
                var emptyTr = document.createElement('tr');
                var emptyTd = document.createElement('td');
                emptyTd.colSpan = 4;
                emptyTd.className = 'py-8 px-4 text-center text-sm text-text-muted';
                emptyTd.textContent = 'No hay sesiones con este estado para la asignatura seleccionada.';
                emptyTr.appendChild(emptyTd);
                attTbodyEl.appendChild(emptyTr);
            } else {
                rows.forEach(function (r) {
                    var tr = document.createElement('tr');
                    tr.className = 'hover:bg-bg-secondary';

                    var tdDate = document.createElement('td');
                    tdDate.className = 'py-3.5 px-4 font-mono text-xs font-bold text-unefa-navy whitespace-nowrap';
                    tdDate.textContent = r.date;

                    var tdMod = document.createElement('td');
                    tdMod.className = 'py-3.5 px-4 text-xs font-semibold text-text-secondary whitespace-nowrap';
                    tdMod.textContent = r.mod;

                    var tdStatus = document.createElement('td');
                    tdStatus.className = 'py-3.5 px-4 whitespace-nowrap';
                    var badgeInfo = BADGE_INFO[r.status] || BADGE_INFO.PRESENT;
                    var badge = document.createElement('span');
                    badge.className = badgeInfo.cls;
                    badge.textContent = badgeInfo.text;
                    tdStatus.appendChild(badge);

                    var tdNote = document.createElement('td');
                    tdNote.className = 'py-3.5 px-4 text-xs text-text-secondary';
                    tdNote.textContent = r.note;

                    tr.appendChild(tdDate);
                    tr.appendChild(tdMod);
                    tr.appendChild(tdStatus);
                    tr.appendChild(tdNote);
                    attTbodyEl.appendChild(tr);
                });
            }

            if (tableFooter) {
                tableFooter.textContent = 'Mostrando ' + rows.length + ' de ' + sub.records.length + ' sesiones registradas en el periodo actual.';
            }
        };

        var renderSubjects = function (focusSelected) {
            subjectListEl.textContent = '';

            SUBJECTS.forEach(function (s, index) {
                var selected = s.code === activeCode;
                var btn = document.createElement('button');
                btn.type = 'button';
                btn.setAttribute('role', 'tab');
                btn.setAttribute('aria-selected', selected ? 'true' : 'false');
                btn.tabIndex = selected ? 0 : -1;
                btn.setAttribute('data-subject', s.code);
                btn.className = selected
                    ? 'relative w-full text-left p-4 bg-unefa-gold/10 border-l-4 border-l-unefa-gold cursor-pointer block'
                    : 'w-full text-left p-4 bg-white hover:bg-bg-secondary border-l-4 border-l-transparent cursor-pointer block';

                var topRow = document.createElement('div');
                topRow.className = 'flex items-start justify-between gap-2';

                var left = document.createElement('div');
                var title = document.createElement('span');
                title.className = 'block text-sm font-extrabold text-unefa-navy';
                title.textContent = s.name;
                var meta = document.createElement('span');
                meta.className = 'block text-xs font-mono text-text-muted mt-0.5';
                meta.textContent = s.code + ' · Semestre 6';
                left.appendChild(title);
                left.appendChild(meta);

                var right = document.createElement('div');
                right.className = 'text-right';
                var pct = document.createElement('span');
                pct.className = 'block text-sm font-black ' + (s.alert ? 'text-unefa-red' : 'text-[#047857]');
                pct.textContent = s.pct + '%';
                right.appendChild(pct);

                if (s.alert) {
                    var warn = document.createElement('span');
                    warn.className = 'inline-block px-1.5 py-0.5 rounded bg-[#ffdad6] text-[#93000a] text-[0.65rem] font-extrabold uppercase mt-0.5';
                    warn.textContent = 'Atención';
                    right.appendChild(warn);
                }

                topRow.appendChild(left);
                topRow.appendChild(right);

                var barTrack = document.createElement('div');
                barTrack.className = 'w-full h-2 bg-bg-tertiary rounded-full overflow-hidden mt-2.5';
                var barFill = document.createElement('div');
                barFill.className = 'h-full ' + (s.alert ? 'bg-unefa-red' : 'bg-unefa-green');
                barFill.style.width = s.pct + '%';
                barTrack.appendChild(barFill);

                btn.appendChild(topRow);
                btn.appendChild(barTrack);

                btn.addEventListener('click', function () {
                    activeCode = s.code;
                    renderSubjects(false);
                    renderTable();
                });

                btn.addEventListener('keydown', function (e) {
                    var nextIndex = null;
                    if (e.key === 'ArrowDown') nextIndex = (index + 1) % SUBJECTS.length;
                    else if (e.key === 'ArrowUp') nextIndex = (index - 1 + SUBJECTS.length) % SUBJECTS.length;
                    else if (e.key === 'Home') nextIndex = 0;
                    else if (e.key === 'End') nextIndex = SUBJECTS.length - 1;
                    if (nextIndex === null) return;
                    e.preventDefault();
                    activeCode = SUBJECTS[nextIndex].code;
                    renderSubjects(true);
                    renderTable();
                });

                subjectListEl.appendChild(btn);
                if (focusSelected && selected) btn.focus();
            });
        };

        document.querySelectorAll('.filter-pill').forEach(function (btn) {
            btn.addEventListener('click', function () {
                activeFilter = btn.getAttribute('data-filter') || 'ALL';
                document.querySelectorAll('.filter-pill').forEach(function (p) {
                    var on = p === btn;
                    p.setAttribute('aria-pressed', on ? 'true' : 'false');
                    p.className = on
                        ? 'filter-pill px-3 py-1.5 rounded-full text-xs font-extrabold bg-unefa-navy text-white cursor-pointer'
                        : 'filter-pill px-3 py-1.5 rounded-full text-xs font-bold bg-bg-secondary border border-border-primary text-text-secondary hover:bg-bg-tertiary cursor-pointer';
                });
                renderTable();
            });
        });

        renderSubjects(false);
        renderTable();
    }

    // -------------------------------------------------------------------------
    // Seccion Seguridad: Validacion RF-04 y visibilidad de respuestas
    // -------------------------------------------------------------------------
    var secForm = document.getElementById('securityQuestionsForm');
    if (secForm) {
        var q1 = document.getElementById('secQ1');
        var q2 = document.getElementById('secQ2');
        var a1 = document.getElementById('secA1');
        var a2 = document.getElementById('secA2');
        var c1 = document.getElementById('secA1Counter');
        var c2 = document.getElementById('secA2Counter');
        var secAlert = document.getElementById('secAlertBox');
        var secSuccess = document.getElementById('secSuccessBox');

        var updateCounter = function (input, badge) {
            if (!input || !badge) return false;
            var len = input.value.trim().length;
            var ok = len >= 4 && len <= 16;
            badge.textContent = ok
                ? '✓ ' + len + ' / 16 caracteres · Longitud válida (4–16)'
                : '✕ ' + len + ' / 16 caracteres · Debe tener entre 4 y 16 caracteres';
            badge.className = ok
                ? 'inline-flex self-start px-2.5 py-0.5 rounded bg-[#d1fae5] text-[#065f46] text-xs font-mono font-bold'
                : 'inline-flex self-start px-2.5 py-0.5 rounded bg-[#ffdad6] text-[#93000a] text-xs font-mono font-bold';
            return ok;
        };

        if (a1) a1.addEventListener('input', function () { updateCounter(a1, c1); });
        if (a2) a2.addEventListener('input', function () { updateCounter(a2, c2); });

        document.querySelectorAll('[data-toggle-input]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var targetId = btn.getAttribute('data-toggle-input');
                var target = document.getElementById(targetId);
                if (!target) return;
                var showing = target.type === 'password';
                target.type = showing ? 'text' : 'password';
                btn.setAttribute('aria-pressed', showing ? 'true' : 'false');
                var num = targetId === 'secA1' ? '1' : '2';
                btn.setAttribute('aria-label', (showing ? 'Ocultar' : 'Mostrar') + ' respuesta ' + num);
                var eyeOpen = btn.querySelector('[data-eye-open]');
                var eyeOff = btn.querySelector('[data-eye-off]');
                if (eyeOpen) eyeOpen.classList.toggle('hidden', showing);
                if (eyeOff) eyeOff.classList.toggle('hidden', !showing);
            });
        });

        secForm.addEventListener('submit', function (e) {
            e.preventDefault();
            if (secAlert) secAlert.classList.add('hidden');
            if (secSuccess) secSuccess.classList.add('hidden');

            if (q1 && q2 && q1.value === q2.value) {
                if (secAlert) {
                    secAlert.textContent = 'ERROR_VALIDACION: Debe seleccionar dos preguntas de seguridad diferentes.';
                    secAlert.classList.remove('hidden');
                }
                return;
            }

            var ok1 = updateCounter(a1, c1);
            var ok2 = updateCounter(a2, c2);
            if (!ok1 || !ok2) {
                if (secAlert) {
                    secAlert.textContent = 'ERROR_VALIDACION: Cada respuesta debe tener estrictamente entre 4 y 16 caracteres (RF-04).';
                    secAlert.classList.remove('hidden');
                }
                return;
            }

            if (secSuccess) {
                secSuccess.textContent = 'Preguntas de seguridad guardadas y encriptadas correctamente (PUT /api/auth/security-questions).';
                secSuccess.classList.remove('hidden');
            }
        });
    }
})();
