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
    // Escáner QR reutilizable (Estudiante Mod. A y Docente Mod. B)
    // -------------------------------------------------------------------------
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

    function bindScannerController(cfg) {
        var btnWebcam = document.getElementById(cfg.btnCamId);
        var simButtons = document.querySelectorAll('[' + cfg.simAttr + ']');
        if (!btnWebcam && !simButtons.length) return;

        var mediaStream = null;
        var videoEl = document.getElementById(cfg.videoId);
        var simEl = document.getElementById(cfg.simViewId);
        var scanCard = document.getElementById(cfg.cardId);
        var scanIcon = document.getElementById(cfg.iconId);
        var scanHeading = document.getElementById(cfg.headingId);
        var scanDetail = document.getElementById(cfg.detailId);
        var scanMeta = document.getElementById(cfg.metaId);

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
                        updateResultCard('error', 'SIN_PERMISOS_CAMARA', cfg.camErrDetail, cfg.camErrMeta);
                    });
            });
        }

        simButtons.forEach(function (btn) {
            btn.addEventListener('click', function () {
                var s = cfg.scenarios[btn.getAttribute(cfg.simAttr)];
                if (s) updateResultCard(s[0], s[1], s[2], s[3]);
            });
        });
    }

    bindScannerController({
        btnCamId: 'btnToggleWebcam',
        simAttr: 'data-sim-scan',
        videoId: 'realWebcamVideo',
        simViewId: 'simulatedViewfinder',
        cardId: 'scanResultCard',
        iconId: 'scanResultIcon',
        headingId: 'scanResultHeading',
        detailId: 'scanResultDetail',
        metaId: 'scanResultMeta',
        camErrDetail: 'No se pudo acceder a la cámara web del dispositivo.',
        camErrMeta: 'Verifique los permisos del navegador para usar el escáner QR.',
        scenarios: {
            present: ['present', 'ASISTENCIA REGISTRADA · PRESENTE', 'Ingeniería de Software (01S-2610-D1) · Prof. Elena Rivas · Aula B-204', '08:52:14 AM · Registrado dentro del margen de tolerancia (15 min)'],
            late: ['late', 'ASISTENCIA REGISTRADA · TARDANZA (LATE)', 'Ingeniería de Software (01S-2610-D1) · Prof. Elena Rivas · Aula B-204', '09:04:19 AM · Escaneo posterior a la tolerancia con sesión abierta'],
            duplicate: ['error', '409 · ASISTENCIA_YA_REGISTRADA', 'Tu asistencia ya fue registrada en esta sesión de clase.', 'El sistema impide registros duplicados mediante restricción única en PostgreSQL.'],
            expired: ['error', '401 · TOKEN_QR_EXPIRADO', 'El código QR ha vencido. Solicita que se actualice e intenta de nuevo.', 'Los códigos de aula rotan cada 30 s con vigencia máxima de 45 s.']
        }
    });

    bindScannerController({
        btnCamId: 'btnToggleDocCam',
        simAttr: 'data-sim-b',
        videoId: 'docWebcamVideo',
        simViewId: 'docSimViewfinder',
        cardId: 'modBResultCard',
        iconId: 'modBResultIcon',
        headingId: 'modBResultHeading',
        detailId: 'modBResultDetail',
        metaId: 'modBResultMeta',
        camErrDetail: 'No se pudo acceder a la cámara web del equipo.',
        camErrMeta: 'Autorice el uso de la cámara en la barra del navegador.',
        scenarios: {
            present: ['present', 'CARNET VALIDADO · ASISTENCIA PRESENTE', 'Luis Fernando Morales Peña (V-27.890.341) · Inscrito en 01S-2610-D1', 'Firma HMAC-SHA256 verificada · Foto APPROVED · Dentro de tolerancia'],
            late: ['late', 'CARNET VALIDADO · TARDANZA (LATE)', 'Diego Andrés Castillo Lugo (V-28.732.190) · Inscrito en 01S-2610-D1', 'Registrado fuera del margen de tolerancia con sesión abierta'],
            invalid_card: ['error', '422 · CARNET_ESTUDIANTIL_INVALIDO', 'El carnet escaneado está revocado, sin foto aprobada o no pertenece a un estudiante.', 'El estudiante debe completar la aprobación fotográfica en Coordinación (Supuesto S-02).'],
            not_enrolled: ['error', '403 · ESTUDIANTE_NO_INSCRITO', 'El estudiante escaneado no figura inscrito en la sección 01S-2610-D1.', 'Verifique la sección seleccionada o solicite revisión en Control de Estudios.'],
            duplicate: ['error', '409 · ASISTENCIA_YA_REGISTRADA', 'La asistencia de este estudiante ya fue asentada en la sesión actual.', 'Restricción única (session_id, student_id) activa en PostgreSQL 16.']
        }
    });

    // Helper compartido para filas <dl> dentro de dialogos de detalle académico.
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
    // Seccion Seguridad: Validacion RF-04 reutilizable (Estudiante y Docente)
    // -------------------------------------------------------------------------
    function bindSecurityQuestionsForm(cfg) {
        var secForm = document.getElementById(cfg.formId);
        if (!secForm) return;

        var q1 = document.getElementById(cfg.q1Id);
        var q2 = document.getElementById(cfg.q2Id);
        var a1 = document.getElementById(cfg.a1Id);
        var a2 = document.getElementById(cfg.a2Id);
        var c1 = document.getElementById(cfg.c1Id);
        var c2 = document.getElementById(cfg.c2Id);
        var secAlert = document.getElementById(cfg.alertId);
        var secSuccess = document.getElementById(cfg.successId);

        var updateCounter = function (input, badge) {
            if (!input || !badge) return false;
            var len = input.value.trim().length;
            var ok = len >= 4 && len <= 16;
            badge.textContent = ok
                ? '✓ ' + len + ' / 16 caracteres · ' + cfg.validSuffix
                : '✕ ' + len + ' / 16 caracteres · ' + cfg.invalidSuffix;
            badge.className = ok
                ? 'inline-flex self-start px-2.5 py-0.5 rounded bg-[#d1fae5] text-[#065f46] text-xs font-mono font-bold'
                : 'inline-flex self-start px-2.5 py-0.5 rounded bg-[#ffdad6] text-[#93000a] text-xs font-mono font-bold';
            return ok;
        };

        if (a1) a1.addEventListener('input', function () { updateCounter(a1, c1); });
        if (a2) a2.addEventListener('input', function () { updateCounter(a2, c2); });

        secForm.addEventListener('submit', function (e) {
            e.preventDefault();
            if (secAlert) secAlert.classList.add('hidden');
            if (secSuccess) secSuccess.classList.add('hidden');

            if (q1 && q2 && q1.value === q2.value) {
                if (secAlert) {
                    secAlert.textContent = cfg.dupMsg;
                    secAlert.classList.remove('hidden');
                }
                return;
            }

            var ok1 = updateCounter(a1, c1);
            var ok2 = updateCounter(a2, c2);
            if (!ok1 || !ok2) {
                if (secAlert) {
                    secAlert.textContent = cfg.lenMsg;
                    secAlert.classList.remove('hidden');
                }
                return;
            }

            if (secSuccess) {
                secSuccess.textContent = cfg.okMsg;
                secSuccess.classList.remove('hidden');
            }
        });
    }

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

    bindSecurityQuestionsForm({
        formId: 'securityQuestionsForm',
        q1Id: 'secQ1',
        q2Id: 'secQ2',
        a1Id: 'secA1',
        a2Id: 'secA2',
        c1Id: 'secA1Counter',
        c2Id: 'secA2Counter',
        alertId: 'secAlertBox',
        successId: 'secSuccessBox',
        validSuffix: 'Longitud válida (4–16)',
        invalidSuffix: 'Debe tener entre 4 y 16 caracteres',
        dupMsg: 'ERROR_VALIDACION: Debe seleccionar dos preguntas de seguridad diferentes.',
        lenMsg: 'ERROR_VALIDACION: Cada respuesta debe tener estrictamente entre 4 y 16 caracteres (RF-04).',
        okMsg: 'Preguntas de seguridad guardadas y encriptadas correctamente (PUT /api/auth/security-questions).'
    });

    bindSecurityQuestionsForm({
        formId: 'docSecForm',
        q1Id: 'dq1',
        q2Id: 'dq2',
        a1Id: 'da1',
        a2Id: 'da2',
        c1Id: 'dc1',
        c2Id: 'dc2',
        alertId: 'docSecAlert',
        successId: 'docSecOk',
        validSuffix: 'Longitud válida',
        invalidSuffix: 'Requerido 4–16',
        dupMsg: 'ERROR_VALIDACION: Las dos preguntas de seguridad deben ser diferentes.',
        lenMsg: 'ERROR_VALIDACION: Cada respuesta debe tener entre 4 y 16 caracteres (RF-04).',
        okMsg: 'Preguntas de seguridad actualizadas correctamente en el servidor.'
    });

    // -------------------------------------------------------------------------
    // Modulo Docente - Inicio: Temporizador de tolerancia y apertura de sesion
    // -------------------------------------------------------------------------
    var teacherTolClock = document.getElementById('teacherTolClock');
    var openSessionDlg = document.getElementById('openSessionDialog');
    if (teacherTolClock || openSessionDlg) {
        if (teacherTolClock) {
            var teacherTolSec = 9 * 60 + 18;
            window.setInterval(function () {
                if (teacherTolSec > 0) {
                    teacherTolSec -= 1;
                    teacherTolClock.textContent = formatTime(teacherTolSec);
                }
            }, 1000);
        }

        if (openSessionDlg) {
            var newSessionSection = document.getElementById('newSessionSection');
            document.querySelectorAll('[data-quick-open]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    if (newSessionSection) {
                        newSessionSection.value = btn.getAttribute('data-quick-open') || '01S-2610-D1';
                    }
                    openSessionDlg.showModal();
                });
            });

            var cancelNewSessionBtn = document.getElementById('cancelNewSession');
            if (cancelNewSessionBtn) {
                cancelNewSessionBtn.addEventListener('click', function () {
                    openSessionDlg.close();
                });
            }

            var newSessionForm = document.getElementById('newSessionForm');
            if (newSessionForm) {
                newSessionForm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    var nextUrl = newSessionForm.getAttribute('data-sesion-activa-url');
                    if (nextUrl) window.location.href = nextUrl;
                });
            }
        }
    }

    // -------------------------------------------------------------------------
    // Modulo Docente - Sesion Activa: QR 30s, Nomina Socket.IO, RF-10 y Cierre
    // -------------------------------------------------------------------------
    var rosterTbody = document.getElementById('rosterTableBody');
    if (rosterTbody) {
        var sessionClosed = false;
        var qrSecDoc = 30;
        var rotCount = 4;
        var rosterFilter = 'ALL';
        var editingStudentId = null;

        var DOC_STUDENTS = [
            { id: '1', name: 'Carlos Eduardo González Márquez', ci: 'V-28.450.123', status: 'PRESENT', time: '08:52:14', mod: 'Modalidad A (QR)', note: 'Dentro de tolerancia' },
            { id: '2', name: 'María Alejandra Ruiz Díaz', ci: 'V-29.114.602', status: 'PRESENT', time: '08:51:49', mod: 'Modalidad A (QR)', note: 'Dentro de tolerancia' },
            { id: '3', name: 'Luis Fernando Morales Peña', ci: 'V-27.890.341', status: 'PRESENT', time: '08:50:12', mod: 'Modalidad B (Carnet)', note: 'Carnet escaneado en aula' },
            { id: '4', name: 'Valentina Sofía Herrera Castro', ci: 'V-30.012.744', status: 'PRESENT', time: '08:49:05', mod: 'Modalidad A (QR)', note: 'Dentro de tolerancia' },
            { id: '5', name: 'Diego Andrés Castillo Lugo', ci: 'V-28.732.190', status: 'LATE', time: '09:03:22', mod: 'Modalidad A (QR)', note: '3 min tras tolerancia' },
            { id: '6', name: 'Oriana Patricia Mendoza Silva', ci: 'V-29.408.511', status: 'JUSTIFIED', time: '08:46:00', mod: 'Manual (Docente)', note: 'Reposo médico avalado por Coordinación' },
            { id: '7', name: 'Jesús Gabriel Paredes Rojas', ci: 'V-28.991.204', status: 'PENDING', time: '—', mod: 'Sin registro', note: '' },
            { id: '8', name: 'Camila Andrea Torres Blanco', ci: 'V-30.245.887', status: 'PENDING', time: '—', mod: 'Sin registro', note: '' }
        ];

        var DOC_BADGES = {
            PRESENT: { text: 'PRESENTE', cls: 'inline-flex px-2.5 py-0.5 rounded bg-[#d1fae5] text-[#065f46] text-xs font-extrabold' },
            LATE: { text: 'TARDANZA', cls: 'inline-flex px-2.5 py-0.5 rounded bg-unefa-gold/25 text-unefa-navy border border-unefa-gold-dark text-xs font-extrabold' },
            JUSTIFIED: { text: 'JUSTIFICADA', cls: 'inline-flex px-2.5 py-0.5 rounded bg-unefa-blue text-white text-xs font-extrabold' },
            ABSENT: { text: 'AUSENTE', cls: 'inline-flex px-2.5 py-0.5 rounded bg-unefa-red text-white text-xs font-extrabold' },
            PENDING: { text: 'SIN REGISTRO', cls: 'inline-flex px-2.5 py-0.5 rounded bg-bg-tertiary text-text-muted text-xs font-bold' }
        };

        var rosterSearch = document.getElementById('rosterSearch');
        var editDlg = document.getElementById('manualEditDialog');
        var statusSel = document.getElementById('manualStatusSelect');
        var justInput = document.getElementById('manualJustificationInput');
        var justReqMark = document.getElementById('justReqMark');
        var editAlert = document.getElementById('manualEditAlert');

        var openEditModal = function (id) {
            var st = DOC_STUDENTS.find(function (s) { return s.id === id; });
            if (!st || !editDlg) return;
            editingStudentId = id;
            var lbl = document.getElementById('manualStudentLabel');
            if (lbl) lbl.textContent = st.name + ' · ' + st.ci;
            if (statusSel) statusSel.value = st.status === 'PENDING' ? 'PRESENT' : st.status;
            if (justInput) justInput.value = st.note || '';
            if (justReqMark && statusSel) justReqMark.classList.toggle('hidden', statusSel.value !== 'JUSTIFIED');
            if (editAlert) editAlert.classList.add('hidden');
            editDlg.showModal();
        };

        var updateCounters = function () {
            var cntPresent = document.getElementById('cntPresent');
            var cntLate = document.getElementById('cntLate');
            var cntJust = document.getElementById('cntJustified');
            var cntPending = document.getElementById('cntPending');
            var lblPending = document.getElementById('lblPending');
            if (cntPresent) cntPresent.textContent = String(DOC_STUDENTS.filter(function (s) { return s.status === 'PRESENT'; }).length);
            if (cntLate) cntLate.textContent = String(DOC_STUDENTS.filter(function (s) { return s.status === 'LATE'; }).length);
            if (cntJust) cntJust.textContent = String(DOC_STUDENTS.filter(function (s) { return s.status === 'JUSTIFIED'; }).length);
            if (cntPending) cntPending.textContent = String(DOC_STUDENTS.filter(function (s) { return s.status === 'PENDING' || s.status === 'ABSENT'; }).length);
            if (lblPending) lblPending.textContent = sessionClosed ? 'Ausentes' : 'Sin Registro';
        };

        var renderRoster = function () {
            var q = (rosterSearch && rosterSearch.value ? rosterSearch.value : '').trim().toLowerCase();
            var rows = DOC_STUDENTS.filter(function (s) {
                var matchQ = !q || s.name.toLowerCase().indexOf(q) !== -1 || s.ci.toLowerCase().indexOf(q) !== -1;
                var matchF = rosterFilter === 'ALL'
                    || (rosterFilter === 'PENDING' ? (s.status === 'PENDING' || s.status === 'ABSENT') : s.status === rosterFilter);
                return matchQ && matchF;
            });

            rosterTbody.textContent = '';

            if (!rows.length) {
                var emptyTr = document.createElement('tr');
                var emptyTd = document.createElement('td');
                emptyTd.colSpan = 4;
                emptyTd.className = 'py-8 text-center text-sm text-text-muted';
                emptyTd.textContent = 'No se encontraron estudiantes con ese criterio.';
                emptyTr.appendChild(emptyTd);
                rosterTbody.appendChild(emptyTr);
            } else {
                rows.forEach(function (s) {
                    var tr = document.createElement('tr');
                    tr.className = 'hover:bg-bg-secondary';

                    var thStudent = document.createElement('th');
                    thStudent.scope = 'row';
                    thStudent.className = 'py-3.5 px-4 text-left font-normal';
                    var nameSpan = document.createElement('span');
                    nameSpan.className = 'block font-bold text-unefa-navy';
                    nameSpan.textContent = s.name;
                    var ciSpan = document.createElement('span');
                    ciSpan.className = 'block text-xs font-mono text-text-muted';
                    ciSpan.textContent = s.ci;
                    thStudent.appendChild(nameSpan);
                    thStudent.appendChild(ciSpan);
                    if (s.note) {
                        var noteSpan = document.createElement('span');
                        noteSpan.className = 'block text-[0.72rem] text-unefa-blue mt-0.5';
                        noteSpan.textContent = s.note;
                        thStudent.appendChild(noteSpan);
                    }

                    var tdMeta = document.createElement('td');
                    tdMeta.className = 'py-3.5 px-4 whitespace-nowrap';
                    var timeSpan = document.createElement('span');
                    timeSpan.className = 'block font-mono text-xs font-bold text-unefa-navy';
                    timeSpan.textContent = s.time;
                    var modSpan = document.createElement('span');
                    modSpan.className = 'block text-xs text-text-muted';
                    modSpan.textContent = s.mod;
                    tdMeta.appendChild(timeSpan);
                    tdMeta.appendChild(modSpan);

                    var tdBadge = document.createElement('td');
                    tdBadge.className = 'py-3.5 px-4 whitespace-nowrap';
                    var badgeInfo = DOC_BADGES[s.status] || DOC_BADGES.PENDING;
                    var badgeEl = document.createElement('span');
                    badgeEl.className = badgeInfo.cls;
                    badgeEl.textContent = badgeInfo.text;
                    tdBadge.appendChild(badgeEl);

                    var tdAction = document.createElement('td');
                    tdAction.className = 'py-3.5 px-4 text-right whitespace-nowrap';
                    var editBtn = document.createElement('button');
                    editBtn.type = 'button';
                    editBtn.className = 'px-3 py-1.5 rounded-md bg-white border border-border-primary text-xs font-extrabold text-unefa-navy hover:bg-unefa-navy hover:text-white cursor-pointer transition-colors';
                    editBtn.textContent = 'Editar / Justificar';
                    editBtn.addEventListener('click', function () {
                        openEditModal(s.id);
                    });
                    tdAction.appendChild(editBtn);

                    tr.appendChild(thStudent);
                    tr.appendChild(tdMeta);
                    tr.appendChild(tdBadge);
                    tr.appendChild(tdAction);
                    rosterTbody.appendChild(tr);
                });
            }

            updateCounters();
        };

        var syncQrClock = function () {
            var s1 = document.getElementById('classQrSec');
            var s2 = document.getElementById('projectorQrSec');
            var bar = document.getElementById('classQrBar');
            if (s1) s1.textContent = qrSecDoc + 's';
            if (s2) s2.textContent = qrSecDoc + 's';
            if (bar) bar.style.width = ((qrSecDoc / 30) * 100) + '%';
        };

        var rotateClassQr = function () {
            if (sessionClosed) return;
            qrSecDoc = 30;
            rotCount += 1;
            var salt = Math.random().toString(16).slice(2, 10);
            var tokEl = document.getElementById('classQrToken');
            if (tokEl) tokEl.textContent = 'salt: ' + salt + ' · rot #' + String(rotCount).padStart(2, '0');
            ['classQrSvg', 'projectorQrSvg'].forEach(function (id) {
                var svg = document.getElementById(id);
                if (!svg) return;
                svg.querySelectorAll('rect').forEach(function (r, idx) {
                    if (idx > 45 && idx % 6 === 0) {
                        r.setAttribute('fill', Math.random() > 0.5 ? '#06152a' : '#ffffff');
                    }
                });
            });
            syncQrClock();
        };

        window.setInterval(function () {
            if (sessionClosed) return;
            qrSecDoc -= 1;
            if (qrSecDoc <= 0) rotateClassQr();
            else syncQrClock();
        }, 1000);

        var forceRotateBtn = document.getElementById('btnForceRotateClassQr');
        if (forceRotateBtn) forceRotateBtn.addEventListener('click', rotateClassQr);

        var simScanBtn = document.getElementById('btnSimulateStudentScan');
        if (simScanBtn) {
            simScanBtn.addEventListener('click', function () {
                if (sessionClosed) return;
                var pending = DOC_STUDENTS.find(function (s) { return s.status === 'PENDING'; });
                if (!pending) return;
                pending.status = 'PRESENT';
                pending.time = new Date().toTimeString().slice(0, 8);
                pending.mod = 'Modalidad A (Socket.IO)';
                pending.note = 'Escaneo recibido en tiempo real';
                renderRoster();
            });
        }

        if (statusSel) {
            statusSel.addEventListener('change', function () {
                if (justReqMark) justReqMark.classList.toggle('hidden', statusSel.value !== 'JUSTIFIED');
            });
        }

        var cancelEditBtn = document.getElementById('cancelManualEdit');
        if (cancelEditBtn && editDlg) {
            cancelEditBtn.addEventListener('click', function () { editDlg.close(); });
        }

        var manualEditForm = document.getElementById('manualEditForm');
        if (manualEditForm && editDlg) {
            manualEditForm.addEventListener('submit', function (e) {
                e.preventDefault();
                if (editAlert) editAlert.classList.add('hidden');
                var newStatus = statusSel ? statusSel.value : 'PRESENT';
                var note = justInput ? justInput.value.trim() : '';

                if (newStatus === 'JUSTIFIED' && note.length < 4) {
                    if (editAlert) {
                        editAlert.textContent = 'ERROR_VALIDACION: El motivo es obligatorio al marcar una inasistencia como JUSTIFICADA (RF-10).';
                        editAlert.classList.remove('hidden');
                    }
                    if (justInput) justInput.focus();
                    return;
                }

                var st = DOC_STUDENTS.find(function (s) { return s.id === editingStudentId; });
                if (st) {
                    st.status = newStatus;
                    st.mod = sessionClosed ? 'Manual Post-Cierre (Auditado)' : 'Manual (Docente)';
                    st.time = new Date().toTimeString().slice(0, 8);
                    st.note = note || (newStatus === 'ABSENT' ? 'Marcado manualmente por el docente' : 'Actualizado manualmente');
                }
                editDlg.close();
                renderRoster();
            });
        }

        var projDlg = document.getElementById('projectorDialog');
        var btnProj = document.getElementById('btnOpenProjector');
        if (btnProj && projDlg) {
            btnProj.addEventListener('click', function () {
                if (!sessionClosed) projDlg.showModal();
            });
        }

        var closeDlg = document.getElementById('closeSessionDialog');
        var btnCloseTrigger = document.getElementById('btnCloseSessionTrigger');
        var closeSummaryEl = document.getElementById('closeSessionSummary');
        if (btnCloseTrigger && closeDlg) {
            btnCloseTrigger.addEventListener('click', function () {
                if (sessionClosed) return;
                var pendingCount = DOC_STUDENTS.filter(function (s) { return s.status === 'PENDING'; }).length;
                if (closeSummaryEl) {
                    closeSummaryEl.textContent = '';
                    closeSummaryEl.appendChild(document.createTextNode('Al cerrar la sesión '));
                    var strongCourse = document.createElement('strong');
                    strongCourse.textContent = 'ING-SIS-601 (01S-2610-D1)';
                    closeSummaryEl.appendChild(strongCourse);
                    closeSummaryEl.appendChild(document.createTextNode(', el QR dinámico de aula se inhabilitará y los '));
                    var strongPending = document.createElement('strong');
                    strongPending.textContent = pendingCount + ' estudiantes sin registro';
                    closeSummaryEl.appendChild(strongPending);
                    closeSummaryEl.appendChild(document.createTextNode(' serán marcados automáticamente como '));
                    var strongAbs = document.createElement('strong');
                    strongAbs.textContent = 'AUSENTE (ABSENT)';
                    closeSummaryEl.appendChild(strongAbs);
                    closeSummaryEl.appendChild(document.createTextNode('.'));
                }
                closeDlg.showModal();
            });
        }

        var cancelCloseBtn = document.getElementById('cancelCloseSession');
        if (cancelCloseBtn && closeDlg) {
            cancelCloseBtn.addEventListener('click', function () { closeDlg.close(); });
        }

        var confirmCloseBtn = document.getElementById('confirmCloseSession');
        if (confirmCloseBtn && closeDlg) {
            confirmCloseBtn.addEventListener('click', function () {
                sessionClosed = true;
                DOC_STUDENTS.forEach(function (s) {
                    if (s.status === 'PENDING') {
                        s.status = 'ABSENT';
                        s.mod = 'Cierre Automático';
                        s.note = 'Sin registro al cierre de sesión';
                    }
                });
                var stateBadge = document.getElementById('sessionStateBadge');
                if (stateBadge) {
                    stateBadge.textContent = '■ SESIÓN CERRADA (CLOSED)';
                    stateBadge.className = 'inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded bg-bg-tertiary text-unefa-navy border border-border-grid text-xs font-black uppercase tracking-wider';
                }
                var qrLiveTag = document.getElementById('qrLiveTag');
                if (qrLiveTag) {
                    qrLiveTag.textContent = 'INACTIVO';
                    qrLiveTag.className = 'px-2.5 py-1 rounded-full bg-[#ffdad6] text-[#93000a] text-[0.68rem] font-extrabold';
                }
                var qrBox = document.getElementById('classQrBox');
                if (qrBox) qrBox.classList.add('opacity-50');
                var auditBanner = document.getElementById('closedAuditBanner');
                if (auditBanner) auditBanner.classList.remove('hidden');
                if (btnCloseTrigger) {
                    btnCloseTrigger.disabled = true;
                    btnCloseTrigger.classList.add('opacity-50', 'cursor-not-allowed');
                }
                if (btnProj) {
                    btnProj.disabled = true;
                    btnProj.classList.add('opacity-50', 'cursor-not-allowed');
                }
                closeDlg.close();
                renderRoster();
            });
        }

        if (rosterSearch) rosterSearch.addEventListener('input', renderRoster);
        document.querySelectorAll('.roster-pill').forEach(function (pill) {
            pill.addEventListener('click', function () {
                rosterFilter = pill.getAttribute('data-roster-filter') || 'ALL';
                document.querySelectorAll('.roster-pill').forEach(function (p) {
                    var on = p === pill;
                    p.setAttribute('aria-pressed', on ? 'true' : 'false');
                    p.className = on
                        ? 'roster-pill px-3 py-1 rounded-full text-xs font-extrabold bg-unefa-navy text-white cursor-pointer'
                        : 'roster-pill px-3 py-1 rounded-full text-xs font-bold bg-bg-secondary border border-border-primary text-text-secondary cursor-pointer';
                });
                renderRoster();
            });
        });

        renderRoster();
    }

    // -------------------------------------------------------------------------
    // Modulo Docente - Carga Horaria: Modal detalle de bloque de catedra
    // -------------------------------------------------------------------------
    var secDetailDlg = document.getElementById('sectionDetailDialog');
    if (secDetailDlg) {
        var DOC_LOAD_DATA = {
            '01S-2610-D1': { name: 'ING-SIS-601 · Ingeniería de Software', room: 'Aula B-204 (Capacidad 40)', slots: 'Lunes y Jueves · 08:45 - 10:15', enrolled: '32 estudiantes inscritos' },
            '01S-2610-N1': { name: 'ING-SIS-601 · Ingeniería de Software', room: 'Aula B-206 (Capacidad 35)', slots: 'Martes y Viernes · 17:30 - 19:00', enrolled: '28 estudiantes inscritos' },
            '02S-2612-D1': { name: 'ING-SIS-704 · Arquitectura de Software', room: 'Lab. Comp. 1 (Capacidad 30)', slots: 'Miércoles y Viernes · 10:30 - 12:00', enrolled: '26 estudiantes inscritos' }
        };
        var secDlgTitle = document.getElementById('secDlgTitle');
        var secDlgBody = document.getElementById('secDlgBody');

        document.querySelectorAll('[data-sec-modal]').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var code = btn.getAttribute('data-sec-modal');
                var d = DOC_LOAD_DATA[code];
                if (!d || !secDlgTitle || !secDlgBody) return;
                secDlgTitle.textContent = code + ' · ' + d.name;
                secDlgBody.textContent = '';

                var dl = document.createElement('dl');
                dl.className = 'space-y-2';
                appendTerm(dl, 'Aula', d.room, 'font-semibold');
                appendTerm(dl, 'Bloques', d.slots, 'font-mono text-xs font-bold text-unefa-blue');
                appendTerm(dl, 'Matrícula', d.enrolled, 'font-bold text-unefa-navy');
                secDlgBody.appendChild(dl);

                secDetailDlg.showModal();
            });
        });
    }

    // -------------------------------------------------------------------------
    // Modulo Docente - Actas PDF (RF-13 con caso de borde 0 sesiones = 0%)
    // -------------------------------------------------------------------------
    var actCardsEl = document.getElementById('actSectionCards');
    var actRosterEl = document.getElementById('actRosterBody');
    if (actCardsEl && actRosterEl) {
        var ACT_SECTIONS = {
            '01S-2610-D1': {
                code: '01S-2610-D1',
                subject: 'Ingeniería de Software (ING-SIS-601)',
                shift: 'Diurno · Aula B-204',
                closedSessions: 12,
                enrolled: 32,
                avg: '90,2%',
                risk: 1,
                rows: [
                    { ci: 'V-28.450.123', name: 'Carlos Eduardo González Márquez', p: 11, l: 1, j: 0, a: 0, pct: 95 },
                    { ci: 'V-29.114.602', name: 'María Alejandra Ruiz Díaz', p: 12, l: 0, j: 0, a: 0, pct: 100 },
                    { ci: 'V-27.890.341', name: 'Luis Fernando Morales Peña', p: 10, l: 1, j: 1, a: 0, pct: 92 },
                    { ci: 'V-28.732.190', name: 'Diego Andrés Castillo Lugo', p: 7, l: 1, j: 0, a: 4, pct: 67 },
                    { ci: 'V-29.408.511', name: 'Oriana Patricia Mendoza Silva', p: 10, l: 0, j: 2, a: 0, pct: 100 }
                ]
            },
            '01S-2610-N1': {
                code: '01S-2610-N1',
                subject: 'Ingeniería de Software (ING-SIS-601)',
                shift: 'Nocturno · Aula B-206',
                closedSessions: 10,
                enrolled: 28,
                avg: '86,8%',
                risk: 2,
                rows: [
                    { ci: 'V-26.812.400', name: 'Roberto José Salazar M.', p: 9, l: 1, j: 0, a: 0, pct: 95 },
                    { ci: 'V-27.304.119', name: 'Gabriela Victoria Núñez', p: 8, l: 0, j: 1, a: 1, pct: 90 },
                    { ci: 'V-25.998.712', name: 'Daniel Alejandro Quintero', p: 6, l: 1, j: 0, a: 3, pct: 70 }
                ]
            },
            '02S-2612-D1': {
                code: '02S-2612-D1',
                subject: 'Arquitectura de Software (ING-SIS-704)',
                shift: 'Diurno · Lab. Comp. 1',
                closedSessions: 0,
                enrolled: 26,
                avg: '0%',
                risk: 0,
                rows: [
                    { ci: 'V-28.110.503', name: 'Andrea Carolina Pérez', p: 0, l: 0, j: 0, a: 0, pct: 0 },
                    { ci: 'V-28.540.918', name: 'Miguel Ángel Ramírez', p: 0, l: 0, j: 0, a: 0, pct: 0 },
                    { ci: 'V-29.002.441', name: 'Paola Estefanía León', p: 0, l: 0, j: 0, a: 0, pct: 0 }
                ]
            }
        };

        var activeActSec = '01S-2610-D1';

        var renderActs = function () {
            actCardsEl.textContent = '';

            Object.keys(ACT_SECTIONS).forEach(function (key) {
                var s = ACT_SECTIONS[key];
                var on = s.code === activeActSec;
                var cardBtn = document.createElement('button');
                cardBtn.type = 'button';
                cardBtn.setAttribute('aria-pressed', on ? 'true' : 'false');
                cardBtn.className = on
                    ? 'text-left rounded-xl bg-white border-2 border-unefa-navy shadow-panel overflow-hidden cursor-pointer'
                    : 'text-left rounded-xl bg-white border-[1.5px] border-border-primary hover:bg-bg-secondary overflow-hidden cursor-pointer';

                var cardStrip = document.createElement('span');
                cardStrip.className = 'block h-1 w-full ' + (on ? 'bg-unefa-gold' : 'bg-transparent');
                cardStrip.setAttribute('aria-hidden', 'true');

                var cardInner = document.createElement('div');
                cardInner.className = 'p-4';

                var topRow = document.createElement('div');
                topRow.className = 'flex items-center justify-between';
                var codeSpan = document.createElement('span');
                codeSpan.className = 'font-mono text-xs font-extrabold text-unefa-blue';
                codeSpan.textContent = s.code;
                var avgSpan = document.createElement('span');
                avgSpan.className = 'text-xs font-black ' + (s.closedSessions === 0 ? 'text-text-muted' : 'text-[#047857]');
                avgSpan.textContent = s.avg;
                topRow.appendChild(codeSpan);
                topRow.appendChild(avgSpan);

                var subjP = document.createElement('p');
                subjP.className = 'font-extrabold text-sm text-unefa-navy mt-1';
                subjP.textContent = s.subject;

                var metaP = document.createElement('p');
                metaP.className = 'text-xs text-text-muted mt-0.5';
                metaP.textContent = s.shift + ' · ' + s.closedSessions + ' sesiones cerradas';

                cardInner.appendChild(topRow);
                cardInner.appendChild(subjP);
                cardInner.appendChild(metaP);
                cardBtn.appendChild(cardStrip);
                cardBtn.appendChild(cardInner);
                cardBtn.addEventListener('click', function () {
                    activeActSec = s.code;
                    renderActs();
                });
                actCardsEl.appendChild(cardBtn);
            });

            var cur = ACT_SECTIONS[activeActSec];
            var elAvg = document.getElementById('actKpiAvg');
            var elSes = document.getElementById('actKpiSessions');
            var elEnr = document.getElementById('actKpiEnrolled');
            var elRsk = document.getElementById('actKpiRisk');
            var zeroEl = document.getElementById('zeroSessionsNotice');
            var tblTitle = document.getElementById('actTableTitle');
            var tblSub = document.getElementById('actTableSubtitle');

            if (elAvg) elAvg.textContent = cur.avg;
            if (elSes) elSes.textContent = String(cur.closedSessions);
            if (elEnr) elEnr.textContent = String(cur.enrolled);
            if (elRsk) elRsk.textContent = String(cur.risk);
            if (zeroEl) zeroEl.classList.toggle('hidden', cur.closedSessions > 0);
            if (tblTitle) tblTitle.textContent = 'Consolidado de Asistencia — ' + cur.code;
            if (tblSub) tblSub.textContent = cur.subject + ' · Periodo 2026-II';

            actRosterEl.textContent = '';
            cur.rows.forEach(function (r) {
                var risk = cur.closedSessions > 0 && r.pct < 75;
                var pctCls = cur.closedSessions === 0
                    ? 'px-2.5 py-0.5 rounded bg-bg-tertiary text-text-muted font-mono font-bold text-xs'
                    : risk
                        ? 'px-2.5 py-0.5 rounded bg-[#ffdad6] text-[#93000a] font-mono font-extrabold text-xs'
                        : 'px-2.5 py-0.5 rounded bg-[#d1fae5] text-[#065f46] font-mono font-extrabold text-xs';

                var tr = document.createElement('tr');
                tr.className = 'hover:bg-bg-secondary';

                var thCi = document.createElement('th');
                thCi.scope = 'row';
                thCi.className = 'py-3.5 px-4 font-mono text-xs font-bold text-unefa-navy whitespace-nowrap text-left';
                thCi.textContent = r.ci;

                var tdName = document.createElement('td');
                tdName.className = 'py-3.5 px-4 font-bold text-unefa-navy';
                tdName.textContent = r.name;

                tr.appendChild(thCi);
                tr.appendChild(tdName);

                [r.p, r.l, r.j, r.a].forEach(function (val) {
                    var tdNum = document.createElement('td');
                    tdNum.className = 'py-3.5 px-4 text-center font-mono';
                    tdNum.textContent = String(val);
                    tr.appendChild(tdNum);
                });

                var tdPct = document.createElement('td');
                tdPct.className = 'py-3.5 px-4 text-right whitespace-nowrap';
                var pctBadge = document.createElement('span');
                pctBadge.className = pctCls;
                pctBadge.textContent = r.pct + '%' + (risk ? ' · Riesgo' : '');
                tdPct.appendChild(pctBadge);
                tr.appendChild(tdPct);

                actRosterEl.appendChild(tr);
            });
        };

        var actPdfDlg = document.getElementById('actPdfDialog');
        var btnEmitActPdf = document.getElementById('btnEmitActPdf');
        var actPdfBody = document.getElementById('actPdfBody');
        if (btnEmitActPdf && actPdfDlg && actPdfBody) {
            btnEmitActPdf.addEventListener('click', function () {
                var s = ACT_SECTIONS[activeActSec];
                actPdfBody.textContent = '';

                var dl = document.createElement('dl');
                dl.className = 'space-y-2';
                appendTerm(dl, 'Sección', s.code + ' — ' + s.subject, 'font-bold text-unefa-navy');
                appendTerm(dl, 'Resumen', s.closedSessions + ' sesiones cerradas incluidas · Promedio acumulado: ' + s.avg, 'font-semibold');
                actPdfBody.appendChild(dl);

                var fileBox = document.createElement('div');
                fileBox.className = 'p-3 rounded-md bg-bg-secondary border border-border-primary font-mono text-xs text-unefa-navy';
                fileBox.textContent = 'acta_asistencia_' + s.code + '_2026-II.pdf · Generado server-side';
                actPdfBody.appendChild(fileBox);

                actPdfDlg.showModal();
            });
        }

        renderActs();
    }

    // -------------------------------------------------------------------------
    // Modulo Docente - Validacion rapida de fotografia en modal Carnet
    // -------------------------------------------------------------------------
    var docPhotoInput = document.getElementById('docPhotoFileInput');
    var docPhotoAlert = document.getElementById('docPhotoAlert');
    if (docPhotoInput && docPhotoAlert) {
        docPhotoInput.addEventListener('change', function () {
            var f = docPhotoInput.files && docPhotoInput.files[0];
            docPhotoAlert.classList.add('hidden');
            if (!f) return;
            if (f.type !== 'image/jpeg' && f.type !== 'image/png') {
                docPhotoAlert.textContent = 'ERROR_VALIDACION: Solo se admiten imágenes JPEG o PNG.';
                docPhotoAlert.classList.remove('hidden');
                docPhotoInput.value = '';
                return;
            }
            if (f.size > 5 * 1024 * 1024) {
                docPhotoAlert.textContent = 'ERROR_VALIDACION: El archivo supera el límite máximo permitido de 5 MB.';
                docPhotoAlert.classList.remove('hidden');
                docPhotoInput.value = '';
            }
        });
    }
})();
