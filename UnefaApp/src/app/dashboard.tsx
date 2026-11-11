import React, { useState } from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  Pressable,
} from 'react-native';
import { useRouter, useLocalSearchParams } from 'expo-router';
import { SafeAreaView } from 'react-native-safe-area-context';
import {
  GraduationCap,
  BookOpen,
  ClipboardCheck,
  ShieldCheck,
  User,
  QrCode,
  Calendar,
  Award,
  CheckCircle2,
  Clock,
  ArrowLeft,
  LogOut,
  Building2,
  Users,
  AlertTriangle,
  ChevronRight,
  Sparkles,
} from 'lucide-react-native';
import { UnefaColors, MaxContentWidth } from '@/constants/theme';
import { Header } from '@/components/Header';
import { BottomNav } from '@/components/BottomNav';
import { QrModal } from '@/components/QrModal';

export type EntityRole = 'estudiante' | 'profesor' | 'coordinador' | 'director';

interface RoleConfig {
  id: EntityRole;
  title: string;
  badge: string;
  badgeColor: string;
  badgeBg: string;
  name: string;
  cedula: string;
  department: string;
  subtitle: string;
  matricula: string;
  accentColor: string;
}

const ROLES_DATA: Record<EntityRole, RoleConfig> = {
  estudiante: {
    id: 'estudiante',
    title: 'Estudiante',
    badge: 'ESTUDIANTE REGULAR',
    badgeColor: UnefaColors.blue,
    badgeBg: 'rgba(4, 15, 217, 0.08)',
    name: 'Carlos Manuel Mendoza Rojas',
    cedula: 'V-28.123.456',
    department: 'Ingeniería de Sistemas · 7mo Semestre',
    subtitle: 'Matrícula Oficial 2026-I · Modalidad Diurna',
    matricula: 'UNEFA-2022-04921',
    accentColor: UnefaColors.blue,
  },
  profesor: {
    id: 'profesor',
    title: 'Profesor',
    badge: 'DOCENTE ORDINARIO',
    badgeColor: '#0d9488',
    badgeBg: 'rgba(13, 148, 136, 0.1)',
    name: 'Prof. Ing. Elena Rivas Méndez',
    cedula: 'V-14.567.890',
    department: 'Dpto. de Informática y Telecomunicaciones',
    subtitle: 'Dedicación Exclusiva · Escalafón Agregado',
    matricula: 'DOC-UNEFA-8812',
    accentColor: '#0d9488',
  },
  coordinador: {
    id: 'coordinador',
    title: 'Coordinador',
    badge: 'COORDINACIÓN DE CARRERA',
    badgeColor: '#b45309',
    badgeBg: 'rgba(180, 83, 9, 0.1)',
    name: 'Dr. Marcos Peña Colmenares',
    cedula: 'V-11.234.567',
    department: 'Coordinación de Ing. Sistemas y Telemática',
    subtitle: 'Decanato Académico · Núcleo Caracas',
    matricula: 'COORD-SIS-2026',
    accentColor: '#b45309',
  },
  director: {
    id: 'director',
    title: 'Director',
    badge: 'DIRECCIÓN GENERAL DE NÚCLEO',
    badgeColor: UnefaColors.navy,
    badgeBg: 'rgba(6, 21, 42, 0.12)',
    name: 'Cnel. Roberto Silva Pacheco',
    cedula: 'V-09.876.543',
    department: 'Dirección General de Núcleo · Decanato Militar',
    subtitle: 'Comando y Gestión Académica Institucional',
    matricula: 'DIR-UNEFA-001',
    accentColor: UnefaColors.navy,
  },
};

export default function DashboardScreen() {
  const router = useRouter();
  const params = useLocalSearchParams<{ role?: string }>();

  // Determine active role from params or default to estudiante
  const initialRole: EntityRole =
    params.role === 'profesor' ||
    params.role === 'coordinador' ||
    params.role === 'director'
      ? (params.role as EntityRole)
      : 'estudiante';

  const [activeRole, setActiveRole] = useState<EntityRole>(initialRole);
  const [qrOpen, setQrOpen] = useState(false);

  const currentRole = ROLES_DATA[activeRole];

  return (
    <SafeAreaView style={[styles.root, styles.rootLight]}>
      <Header subtitle={`Panel ${currentRole.title}`} showBack={true} />

      <ScrollView
        style={styles.scroll}
        contentContainerStyle={styles.scrollContent}
        showsVerticalScrollIndicator={false}>
        <View style={styles.centerContainer}>

          {/* Selector de Entidad (Efectos evaluativos) */}
          <View style={styles.selectorCard}>
            <View style={styles.selectorHead}>
              <View style={styles.evalTag}>
                <Sparkles size={13} color={UnefaColors.navy} />
                <Text style={styles.evalTagText}>MÓDULOS DE EVALUACIÓN</Text>
              </View>
              <Text style={styles.selectorTitle}>Cambiar vista de entidad:</Text>
            </View>

            <View style={styles.rolesRow}>
              {(['estudiante', 'profesor', 'coordinador', 'director'] as EntityRole[]).map((r) => {
                const isSelected = activeRole === r;
                return (
                  <Pressable
                    key={r}
                    style={[
                      styles.roleChip,
                      isSelected && styles.roleChipActive,
                    ]}
                    onPress={() => setActiveRole(r)}>
                    <Text
                      style={[
                        styles.roleChipText,
                        isSelected && styles.roleChipTextActive,
                      ]}>
                      {r === 'estudiante' && '🎓 '}
                      {r === 'profesor' && '👨‍🏫 '}
                      {r === 'coordinador' && '📋 '}
                      {r === 'director' && '🏛️ '}
                      {ROLES_DATA[r].title}
                    </Text>
                  </Pressable>
                );
              })}
            </View>
          </View>

          {/* Banner de Sesión Activa */}
          <View style={[styles.sessionBanner, { borderColor: currentRole.accentColor }]}>
            <View style={styles.sessionBannerTop}>
              <View style={styles.sessionStatusPill}>
                <View style={styles.liveDot} />
                <Text style={styles.sessionStatusText}>SESIÓN ACTIVA</Text>
              </View>
              <View style={[styles.roleBadge, { backgroundColor: currentRole.badgeBg }]}>
                <Text style={[styles.roleBadgeText, { color: currentRole.badgeColor }]}>
                  {currentRole.badge}
                </Text>
              </View>
            </View>

            <View style={styles.profileRow}>
              <View style={[styles.avatarBox, { backgroundColor: currentRole.accentColor }]}>
                {activeRole === 'estudiante' && <GraduationCap size={28} color="#ffffff" />}
                {activeRole === 'profesor' && <BookOpen size={28} color="#ffffff" />}
                {activeRole === 'coordinador' && <ClipboardCheck size={28} color="#ffffff" />}
                {activeRole === 'director' && <ShieldCheck size={28} color="#ffffff" />}
              </View>
              <View style={styles.profileInfo}>
                <Text style={styles.profileName}>{currentRole.name}</Text>
                <Text style={styles.profileCedula}>{currentRole.cedula}</Text>
                <Text style={styles.profileDept}>{currentRole.department}</Text>
                <Text style={styles.profileSub}>{currentRole.subtitle}</Text>
              </View>
            </View>

            <View style={styles.sessionFooter}>
              <View style={styles.matriculaWrap}>
                <Text style={styles.matriculaLabel}>ID Institucional:</Text>
                <Text style={styles.matriculaVal}>{currentRole.matricula}</Text>
              </View>
              <Pressable
                style={styles.logoutBtn}
                onPress={() => router.replace('/login' as any)}>
                <LogOut size={14} color="#ef4444" />
                <Text style={styles.logoutBtnText}>Cerrar sesión</Text>
              </Pressable>
            </View>
          </View>

          {/* ────────────────────────────────────────────────────────── */}
          {/* VISTA 1: DASHBOARD ESTUDIANTE                             */}
          {/* ────────────────────────────────────────────────────────── */}
          {activeRole === 'estudiante' && (
            <View style={styles.dashboardSection}>
              {/* Carnet Digital UNEFA (Simulado) */}
              <View style={styles.carnetCard}>
                <View style={styles.carnetHeader}>
                  <View style={styles.carnetHeaderLeft}>
                    <Text style={styles.carnetHeaderTitle}>REPÚBLICA BOLIVARIANA DE VENEZUELA</Text>
                    <Text style={styles.carnetHeaderSub}>MINISTERIO DEL PODER POPULAR PARA LA DEFENSA</Text>
                    <Text style={styles.carnetHeaderUnefa}>UNEFA · CARNET DE ASISTENCIA DIGITAL</Text>
                  </View>
                  <View style={styles.carnetBadgeGold}>
                    <Text style={styles.carnetBadgeGoldText}>2026-I</Text>
                  </View>
                </View>

                <View style={styles.carnetBody}>
                  <View style={styles.carnetPhotoBox}>
                    <User size={38} color="#64748b" />
                    <Text style={styles.carnetPhotoText}>FOTO ESTUDIANTE</Text>
                  </View>
                  <View style={styles.carnetDetails}>
                    <Text style={styles.carnetName}>{currentRole.name}</Text>
                    <Text style={styles.carnetCedula}>{currentRole.cedula}</Text>
                    <Text style={styles.carnetCareer}>INGENIERÍA DE SISTEMAS</Text>
                    <Text style={styles.carnetMeta}>CONDICIÓN: REGULAR ACTIVO</Text>
                    <View style={styles.carnetQrRow}>
                      <View style={styles.qrIconWrap}>
                        <QrCode size={40} color={UnefaColors.navy} />
                      </View>
                      <View style={styles.barcodeWrap}>
                        <Text style={styles.barcodeText}>||| | |||| || ||| |||| | |||</Text>
                        <Text style={styles.barcodeCode}>MAT: 2022-04921-SICEU</Text>
                      </View>
                    </View>
                  </View>
                </View>
              </View>

              {/* Métricas del Estudiante */}
              <View style={styles.metricsGrid}>
                <View style={styles.metricCard}>
                  <Text style={styles.metricNumber}>7mo</Text>
                  <Text style={styles.metricLabel}>Semestre en curso</Text>
                </View>
                <View style={styles.metricCard}>
                  <Text style={styles.metricNumber}>6</Text>
                  <Text style={styles.metricLabel}>Materias inscritas</Text>
                </View>
                <View style={styles.metricCard}>
                  <Text style={[styles.metricNumber, { color: UnefaColors.blue }]}>17.42</Text>
                  <Text style={styles.metricLabel}>Promedio general</Text>
                </View>
                <View style={styles.metricCard}>
                  <Text style={[styles.metricNumber, { color: UnefaColors.green }]}>94.5%</Text>
                  <Text style={styles.metricLabel}>Asistencia global</Text>
                </View>
              </View>

              {/* Módulo: Asignaturas y Control de Asistencias */}
              <View style={styles.contentBlock}>
                <View style={styles.blockHead}>
                  <View>
                    <Text style={styles.blockKicker}>CONTROL DE ASISTENCIAS</Text>
                    <Text style={styles.blockTitle}>Mis asignaturas inscritas</Text>
                  </View>
                  <View style={styles.pillGreen}>
                    <CheckCircle2 size={12} color={UnefaColors.green} />
                    <Text style={styles.pillGreenText}>Solvente</Text>
                  </View>
                </View>

                {/* Lista de materias */}
                {[
                  {
                    code: 'SIS-701',
                    name: 'Sistemas Distribuidos',
                    prof: 'Prof. Elena Rivas Méndez',
                    room: 'Lab Telemática 2',
                    attendance: '96%',
                    hours: '24/25 asistidas',
                    status: 'Óptima',
                  },
                  {
                    code: 'CIB-702',
                    name: 'Ciberseguridad y Soberanía Nacional',
                    prof: 'Prof. Carlos Morales',
                    room: 'Aula A-04',
                    attendance: '100%',
                    hours: '20/20 asistidas',
                    status: 'Perfecta',
                  },
                  {
                    code: 'TEL-703',
                    name: 'Redes de Computadoras II',
                    prof: 'Prof. Luis Sánchez',
                    room: 'Aula C-10',
                    attendance: '88%',
                    hours: '22/25 asistidas',
                    status: 'Regular',
                  },
                  {
                    code: 'PRY-704',
                    name: 'Metodología y Proyecto Especial',
                    prof: 'Prof. Carmen Gómez',
                    room: 'Aula A-02',
                    attendance: '95%',
                    hours: '19/20 asistidas',
                    status: 'Óptima',
                  },
                  {
                    code: 'SOF-705',
                    name: 'Ingeniería de Software Crítico',
                    prof: 'Dr. Marcos Peña',
                    room: 'Lab 3',
                    attendance: '92%',
                    hours: '23/25 asistidas',
                    status: 'Óptima',
                  },
                ].map((item, idx) => (
                  <View key={idx} style={styles.subjectCard}>
                    <View style={styles.subjectTop}>
                      <View style={styles.codeTag}>
                        <Text style={styles.codeTagText}>{item.code}</Text>
                      </View>
                      <View style={styles.percentBadge}>
                        <Text style={styles.percentBadgeText}>{item.attendance}</Text>
                      </View>
                    </View>
                    <Text style={styles.subjectName}>{item.name}</Text>
                    <Text style={styles.subjectProf}>{item.prof}</Text>
                    <View style={styles.subjectFooter}>
                      <View style={styles.roomInfo}>
                        <Clock size={12} color="#64748b" />
                        <Text style={styles.roomText}>{item.room}</Text>
                      </View>
                      <Text style={styles.hoursText}>{item.hours}</Text>
                    </View>
                  </View>
                ))}
              </View>

              {/* Accesos Rápidos de Estudiante */}
              <View style={styles.contentBlock}>
                <Text style={styles.blockKicker}>TRÁMITES Y CONSTANCIAS</Text>
                <Text style={styles.blockTitle}>Servicios digitales disponibles</Text>

                <View style={styles.servicesGrid}>
                  {[
                    { title: 'Constancia de Estudio', desc: 'Descarga inmediata con firma digital y sello QR' },
                    { title: 'Récord de Calificaciones', desc: 'Historial acumulado y promedio ponderado' },
                    { title: 'Horario Semanal 2026-I', desc: 'Distribución de bloques por aula y laboratorio' },
                    { title: 'Justificar Inasistencia', desc: 'Consignación digital de justificativo médico/laboral' },
                  ].map((s, i) => (
                    <View key={i} style={styles.serviceItem}>
                      <View style={styles.serviceItemTop}>
                        <Text style={styles.serviceItemTitle}>{s.title}</Text>
                        <ChevronRight size={16} color={UnefaColors.blue} />
                      </View>
                      <Text style={styles.serviceItemDesc}>{s.desc}</Text>
                    </View>
                  ))}
                </View>
              </View>
            </View>
          )}

          {/* ────────────────────────────────────────────────────────── */}
          {/* VISTA 2: DASHBOARD PROFESOR                               */}
          {/* ────────────────────────────────────────────────────────── */}
          {activeRole === 'profesor' && (
            <View style={styles.dashboardSection}>
              {/* Resumen Docente */}
              <View style={styles.metricsGrid}>
                <View style={styles.metricCard}>
                  <Text style={styles.metricNumber}>3</Text>
                  <Text style={styles.metricLabel}>Secciones asignadas</Text>
                </View>
                <View style={styles.metricCard}>
                  <Text style={styles.metricNumber}>89</Text>
                  <Text style={styles.metricLabel}>Alumnos matriculados</Text>
                </View>
                <View style={styles.metricCard}>
                  <Text style={[styles.metricNumber, { color: '#0d9488' }]}>32</Text>
                  <Text style={styles.metricLabel}>Clases impartidas</Text>
                </View>
                <View style={styles.metricCard}>
                  <Text style={[styles.metricNumber, { color: UnefaColors.green }]}>92.8%</Text>
                  <Text style={styles.metricLabel}>Asistencia promedio</Text>
                </View>
              </View>

              {/* Módulo: Secciones a Cargo y Control de Asistencia */}
              <View style={styles.contentBlock}>
                <View style={styles.blockHead}>
                  <View>
                    <Text style={styles.blockKicker}>CÁTEDRA ACTIVA</Text>
                    <Text style={styles.blockTitle}>Secciones</Text>
                  </View>
                  <View style={[styles.pillGreen, { backgroundColor: 'rgba(13, 148, 136, 0.1)' }]}>
                    <Text style={[styles.pillGreenText, { color: '#0d9488' }]}>Activas 2026-I</Text>
                  </View>
                </View>

                {[
                  {
                    name: 'Sistemas Distribuidos',
                    sec: 'Sección SIS-701',
                    students: '32 estudiantes',
                    schedule: 'Lun y Mié 08:00 - 10:15',
                    room: 'Lab Telemática 2',
                    avgAttendance: '93.4%',
                    status: 'Pase de lista al día',
                  },
                  {
                    name: 'Arquitectura de Software',
                    sec: 'Sección SIS-702',
                    students: '28 estudiantes',
                    schedule: 'Mar y Jue 10:30 - 12:45',
                    room: 'Aula B-12',
                    avgAttendance: '89.1%',
                    status: 'Pase de lista al día',
                  },
                  {
                    name: 'Proyecto Sociotecnológico I',
                    sec: 'Sección PRY-501',
                    students: '29 estudiantes',
                    schedule: 'Viernes 08:00 - 11:30',
                    room: 'Aula A-05',
                    avgAttendance: '95.8%',
                    status: 'Pase de lista al día',
                  },
                ].map((course, idx) => (
                  <View key={idx} style={styles.courseCard}>
                    <View style={styles.courseTop}>
                      <View>
                        <Text style={styles.courseSec}>{course.sec}</Text>
                        <Text style={styles.courseName}>{course.name}</Text>
                      </View>
                      <View style={styles.courseAttendanceBadge}>
                        <Text style={styles.courseAttendanceText}>{course.avgAttendance}</Text>
                        <Text style={styles.courseAttendanceLabel}>Asistencia</Text>
                      </View>
                    </View>

                    <View style={styles.courseMetaRow}>
                      <Text style={styles.courseMetaText}>👥 {course.students}</Text>
                      <Text style={styles.courseMetaText}>🕒 {course.schedule}</Text>
                      <Text style={styles.courseMetaText}>📍 {course.room}</Text>
                    </View>

                    <View style={styles.courseActionRow}>
                      <View style={styles.actionPill}>
                        <QrCode size={13} color={UnefaColors.blue} />
                        <Text style={styles.actionPillText}>Escanear Asistencia QR</Text>
                      </View>
                      <View style={styles.actionPillSecondary}>
                        <Text style={styles.actionPillSecondaryText}>Ver Planilla</Text>
                      </View>
                    </View>
                  </View>
                ))}
              </View>

              {/* Herramientas del Docente */}
              <View style={styles.contentBlock}>
                <Text style={styles.blockKicker}>GESTIÓN ACADÉMICA DOCENTE</Text>
                <Text style={styles.blockTitle}>Operaciones de cátedra</Text>

                <View style={styles.docenteActionsList}>
                  <View style={styles.docenteActionItem}>
                    <Award size={20} color="#0d9488" />
                    <View style={styles.docenteActionText}>
                      <Text style={styles.docenteActionTitle}>Cargar Calificaciones 1er Corte</Text>
                      <Text style={styles.docenteActionSub}>Plazo de consignación abierto hasta la semana 6</Text>
                    </View>
                  </View>
                  <View style={styles.docenteActionItem}>
                    <Users size={20} color={UnefaColors.blue} />
                    <View style={styles.docenteActionText}>
                      <Text style={styles.docenteActionTitle}>Reportar Inasistencias Críticas</Text>
                      <Text style={styles.docenteActionSub}>Notificación preventiva a la Coordinación de Carrera</Text>
                    </View>
                  </View>
                  <View style={styles.docenteActionItem}>
                    <Calendar size={20} color={UnefaColors.goldDark} />
                    <View style={styles.docenteActionText}>
                      <Text style={styles.docenteActionTitle}>Planificación Semestral Consolidada</Text>
                      <Text style={styles.docenteActionSub}>Cronograma de evaluaciones, talleres y defensas</Text>
                    </View>
                  </View>
                </View>
              </View>
            </View>
          )}

          {/* ────────────────────────────────────────────────────────── */}
          {/* VISTA 3: DASHBOARD COORDINADOR                            */}
          {/* ────────────────────────────────────────────────────────── */}
          {activeRole === 'coordinador' && (
            <View style={styles.dashboardSection}>
              {/* Métricas de Coordinación */}
              <View style={styles.metricsGrid}>
                <View style={styles.metricCard}>
                  <Text style={styles.metricNumber}>645</Text>
                  <Text style={styles.metricLabel}>Matrícula carrera</Text>
                </View>
                <View style={styles.metricCard}>
                  <Text style={styles.metricNumber}>22</Text>
                  <Text style={styles.metricLabel}>Docentes adscritos</Text>
                </View>
                <View style={styles.metricCard}>
                  <Text style={[styles.metricNumber, { color: '#b45309' }]}>24</Text>
                  <Text style={styles.metricLabel}>Secciones activas</Text>
                </View>
                <View style={styles.metricCard}>
                  <Text style={[styles.metricNumber, { color: UnefaColors.green }]}>93.8%</Text>
                  <Text style={styles.metricLabel}>Asistencia global</Text>
                </View>
              </View>

              {/* Módulo de Supervisión en Tiempo Real */}
              <View style={styles.contentBlock}>
                <View style={styles.blockHead}>
                  <View>
                    <Text style={styles.blockKicker}>SUPERVISIÓN DE CARRERA</Text>
                    <Text style={styles.blockTitle}>cátedras y docentes</Text>
                  </View>
                  <View style={[styles.pillGreen, { backgroundColor: 'rgba(180, 83, 9, 0.1)' }]}>
                    <Text style={[styles.pillGreenText, { color: '#b45309' }]}>Guacara · Activo</Text>
                  </View>
                </View>

                {[
                  {
                    title: 'Asistencia de docentes',
                    val: '20 de 22 docentes en aula',
                    badge: '91% Cumplimiento',
                    desc: 'Registro validado en sistemas y laboratorios de computación.',
                  },
                  {
                    title: 'Inasistencia Estudiantil',
                    val: '12 casos en seguimiento',
                    badge: 'Atención requerida',
                    desc: 'Aspirantes y estudiantes con más de 3 ausencias consecutivas.',
                  },
                  {
                    title: 'Disponibilidad de Laboratorios',
                    val: '5 salas y laboratorios operativos',
                    badge: '100% Funcional',
                    desc: 'Lab Telemática, Sistemas, Redes, Física y Electrónica en uso.',
                  },
                  {
                    title: 'Consignación de Actas y Cortes',
                    val: '18 de 24 actas registradas',
                    badge: 'En progreso',
                    desc: 'Cierre de actas parciales de evaluación continua 2026-I.',
                  },
                ].map((item, idx) => (
                  <View key={idx} style={styles.coordinacionItem}>
                    <View style={styles.coordTop}>
                      <Text style={styles.coordTitle}>{item.title}</Text>
                      <View style={styles.coordBadge}>
                        <Text style={styles.coordBadgeText}>{item.badge}</Text>
                      </View>
                    </View>
                    <Text style={styles.coordVal}>{item.val}</Text>
                    <Text style={styles.coordDesc}>{item.desc}</Text>
                  </View>
                ))}
              </View>

              {/* Acciones de Coordinación */}
              <View style={styles.contentBlock}>
                <Text style={styles.blockKicker}>GESTIÓN DEPARTAMENTAL</Text>
                <Text style={styles.blockTitle}>Acciones de carrera</Text>

                <View style={styles.servicesGrid}>
                  <View style={styles.serviceItem}>
                    <Text style={styles.serviceItemTitle}>Asignación de Carga Académica</Text>
                    <Text style={styles.serviceItemDesc}>Distribución de horas docentes y aprobación de horarios</Text>
                  </View>
                  <View style={styles.serviceItem}>
                    <Text style={styles.serviceItemTitle}>Validación de Jurados de Grado</Text>
                    <Text style={styles.serviceItemDesc}>Aprobación de Trabajos Especiales de Grado (TEG)</Text>
                  </View>
                  <View style={styles.serviceItem}>
                    <Text style={styles.serviceItemTitle}>Solicitudes de Cambio de Sección</Text>
                    <Text style={styles.serviceItemDesc}>5 solicitudes pendientes por cupo y compatibilidad</Text>
                  </View>
                  <View style={styles.serviceItem}>
                    <Text style={styles.serviceItemTitle}>Reporte al Decanato Académico</Text>
                    <Text style={styles.serviceItemDesc}>Informe mensual de rendimiento y retención estudiantil</Text>
                  </View>
                </View>
              </View>
            </View>
          )}

          {/* ────────────────────────────────────────────────────────── */}
          {/* VISTA 4: DASHBOARD DIRECTOR                               */}
          {/* ────────────────────────────────────────────────────────── */}
          {activeRole === 'director' && (
            <View style={styles.dashboardSection}>
              {/* Métricas Institucionales */}
              <View style={styles.metricsGrid}>
                <View style={styles.metricCard}>
                  <Text style={[styles.metricNumber, { color: UnefaColors.navy }]}>3.450</Text>
                  <Text style={styles.metricLabel}>Matrícula total núcleo</Text>
                </View>
                <View style={styles.metricCard}>
                  <Text style={styles.metricNumber}>210</Text>
                  <Text style={styles.metricLabel}>Personal activo</Text>
                </View>
                <View style={styles.metricCard}>
                  <Text style={[styles.metricNumber, { color: UnefaColors.green }]}>95.1%</Text>
                  <Text style={styles.metricLabel}>Asistencia general</Text>
                </View>
                <View style={styles.metricCard}>
                  <Text style={[styles.metricNumber, { color: UnefaColors.goldDark }]}>100%</Text>
                  <Text style={styles.metricLabel}>Gratuidad garantizada</Text>
                </View>
              </View>

              {/* Módulo: Supervisión General de Núcleo */}
              <View style={styles.contentBlock}>
                <View style={styles.blockHead}>
                  <View>
                    <Text style={styles.blockKicker}>DIRECCIÓN GENERAL Y MANDO</Text>
                    <Text style={styles.blockTitle}>Supervisión consolidada de sedes</Text>
                  </View>
                  <View style={[styles.pillGreen, { backgroundColor: 'rgba(6, 21, 42, 0.1)' }]}>
                    <Text style={[styles.pillGreenText, { color: UnefaColors.navy }]}>Mando Soberano</Text>
                  </View>
                </View>

                {/* Reporte por carreras */}
                <View style={styles.directorCareerCard}>
                  <Text style={styles.directorCareerTitle}>Asistencia consolidada por facultad</Text>

                  {[
                    { fac: 'Facultad de Ingeniería', rate: '96.2%', pct: 96 },
                    { fac: 'Facultad de Ciencias Sociales', rate: '93.5%', pct: 93 },
                    { fac: 'Técnico Superior Universitario', rate: '95.0%', pct: 95 },
                    { fac: 'Curso Integral de Nivelación Universitaria', rate: '97.4%', pct: 97 },
                  ].map((f, i) => (
                    <View key={i} style={styles.progressRow}>
                      <View style={styles.progressTextRow}>
                        <Text style={styles.progressLabel}>{f.fac}</Text>
                        <Text style={styles.progressValue}>{f.rate}</Text>
                      </View>
                      <View style={styles.progressBarTrack}>
                        <View style={[styles.progressBarFill, { width: `${f.pct}%` }]} />
                      </View>
                    </View>
                  ))}
                </View>

                {/* Indicadores Clave de Operatividad */}
                <View style={styles.directorGrid}>
                  <View style={styles.directorStatBox}>
                    <Building2 size={22} color={UnefaColors.navy} />
                    <Text style={styles.directorStatNum}>4 Sedes</Text>
                    <Text style={styles.directorStatLbl}>Extensiones del núcleo operando</Text>
                  </View>
                  <View style={styles.directorStatBox}>
                    <QrCode size={22} color={UnefaColors.blue} />
                    <Text style={styles.directorStatNum}>3.120 lecturas</Text>
                    <Text style={styles.directorStatLbl}>Accesos por carnet QR hoy</Text>
                  </View>
                  <View style={styles.directorStatBox}>
                    <Users size={22} color={UnefaColors.green} />
                    <Text style={styles.directorStatNum}>1.450 raciones</Text>
                    <Text style={styles.directorStatLbl}>Comedor estudiantil solvente</Text>
                  </View>
                  <View style={styles.directorStatBox}>
                    <ShieldCheck size={22} color={UnefaColors.goldDark} />
                    <Text style={styles.directorStatNum}>0 Novedades</Text>
                    <Text style={styles.directorStatLbl}>Doctrina y disciplina militar</Text>
                  </View>
                </View>
              </View>

              {/* Acciones de Dirección */}
              <View style={styles.contentBlock}>
                <Text style={styles.blockKicker}>COMANDO INSTITUCIONAL</Text>
                <Text style={styles.blockTitle}>Acciones directivas estratégicas</Text>

                <View style={styles.servicesGrid}>
                  <View style={styles.serviceItem}>
                    <Text style={styles.serviceItemTitle}>Reporte al Vicerrectorado Académico</Text>
                    <Text style={styles.serviceItemDesc}>Consolidado de auditoría semestral y rendimiento de núcleos</Text>
                  </View>
                  <View style={styles.serviceItem}>
                    <Text style={styles.serviceItemTitle}>Auditoría Integral SICEU</Text>
                    <Text style={styles.serviceItemDesc}>Supervisión de actas de grado y récord académico nacional</Text>
                  </View>
                  <View style={styles.serviceItem}>
                    <Text style={styles.serviceItemTitle}>Plan Soberanía y Defensa 2026</Text>
                    <Text style={styles.serviceItemDesc}>Seguimiento de convenios tecnológicos con la FANB</Text>
                  </View>
                  <View style={styles.serviceItem}>
                    <Text style={styles.serviceItemTitle}>Aprobación de Convocatoria CINU 2026-II</Text>
                    <Text style={styles.serviceItemDesc}>Planificación de cupos para bachilleres de nuevo ingreso</Text>
                  </View>
                </View>
              </View>
            </View>
          )}

          {/* Botón Inferior de Retorno al Login */}
          <View style={styles.bottomActions}>
            <Pressable
              style={styles.backToLoginBtn}
              onPress={() => router.replace('/login' as any)}>
              <ArrowLeft size={16} color={UnefaColors.navy} />
              <Text style={styles.backToLoginText}>Volver al inicio de sesión</Text>
            </Pressable>
          </View>

        </View>
      </ScrollView>

      {/* Barra Inferior */}
      <BottomNav activeTab="siceu" onOpenQr={() => setQrOpen(true)} />
      <QrModal visible={qrOpen} onClose={() => setQrOpen(false)} />
    </SafeAreaView>
  );
}

const styles = StyleSheet.create({
  root: {
    flex: 1,
  },
  rootLight: {
    backgroundColor: '#ffffff',
  },
  scroll: {
    flex: 1,
  },
  scrollContent: {
    paddingBottom: 40,
    alignItems: 'center',
  },
  centerContainer: {
    width: '100%',
    maxWidth: MaxContentWidth,
    paddingHorizontal: 16,
    paddingTop: 16,
  },

  // Selector de Roles (Efectos Evaluativos)
  selectorCard: {
    backgroundColor: '#f8fafc',
    borderRadius: 16,
    padding: 14,
    marginBottom: 16,
    borderWidth: 1,
    borderColor: '#e2e8f0',
  },
  selectorHead: {
    marginBottom: 10,
  },
  evalTag: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 5,
    backgroundColor: UnefaColors.goldSoft,
    alignSelf: 'flex-start',
    paddingHorizontal: 8,
    paddingVertical: 3,
    borderRadius: 6,
    marginBottom: 6,
  },
  evalTagText: {
    fontSize: 10,
    fontWeight: '800',
    color: UnefaColors.navy,
    letterSpacing: 0.5,
  },
  selectorTitle: {
    fontSize: 12,
    fontWeight: '700',
    color: '#475569',
  },
  rolesRow: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    gap: 6,
  },
  roleChip: {
    paddingVertical: 8,
    paddingHorizontal: 12,
    borderRadius: 10,
    borderWidth: 1,
    borderColor: '#cbd5e1',
    backgroundColor: '#ffffff',
  },
  roleChipActive: {
    backgroundColor: UnefaColors.navy,
    borderColor: UnefaColors.navy,
  },
  roleChipText: {
    fontSize: 12,
    fontWeight: '700',
    color: '#334155',
  },
  roleChipTextActive: {
    color: '#ffffff',
  },

  // Active Session Banner
  sessionBanner: {
    backgroundColor: '#ffffff',
    borderRadius: 18,
    padding: 18,
    marginBottom: 20,
    borderWidth: 1.5,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.05,
    shadowRadius: 8,
    elevation: 3,
  },
  sessionBannerTop: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    marginBottom: 14,
  },
  sessionStatusPill: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 6,
    backgroundColor: '#dcfce7',
    paddingHorizontal: 10,
    paddingVertical: 4,
    borderRadius: 20,
  },
  liveDot: {
    width: 7,
    height: 7,
    borderRadius: 4,
    backgroundColor: '#16a34a',
  },
  sessionStatusText: {
    fontSize: 10,
    fontWeight: '900',
    color: '#16a34a',
    letterSpacing: 0.5,
  },
  roleBadge: {
    paddingHorizontal: 10,
    paddingVertical: 4,
    borderRadius: 8,
  },
  roleBadgeText: {
    fontSize: 11,
    fontWeight: '800',
    letterSpacing: 0.3,
  },
  profileRow: {
    flexDirection: 'row',
    gap: 14,
    alignItems: 'center',
    marginBottom: 14,
  },
  avatarBox: {
    width: 54,
    height: 54,
    borderRadius: 16,
    alignItems: 'center',
    justifyContent: 'center',
  },
  profileInfo: {
    flex: 1,
  },
  profileName: {
    fontSize: 16,
    fontWeight: '900',
    color: '#0f172a',
    marginBottom: 2,
  },
  profileCedula: {
    fontSize: 13,
    fontWeight: '700',
    color: UnefaColors.blue,
    marginBottom: 2,
  },
  profileDept: {
    fontSize: 12,
    fontWeight: '600',
    color: '#475569',
  },
  profileSub: {
    fontSize: 11,
    color: '#64748b',
    marginTop: 2,
  },
  sessionFooter: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingTop: 12,
    borderTopWidth: StyleSheet.hairlineWidth,
    borderTopColor: '#e2e8f0',
  },
  matriculaWrap: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 6,
  },
  matriculaLabel: {
    fontSize: 11,
    color: '#64748b',
    fontWeight: '600',
  },
  matriculaVal: {
    fontSize: 11,
    fontWeight: '800',
    color: '#0f172a',
    fontFamily: 'monospace',
  },
  logoutBtn: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 5,
    paddingVertical: 4,
    paddingHorizontal: 8,
    borderRadius: 6,
  },
  logoutBtnText: {
    fontSize: 12,
    fontWeight: '700',
    color: '#ef4444',
  },

  // Sections
  dashboardSection: {
    gap: 20,
  },

  // Carnet Digital Card
  carnetCard: {
    backgroundColor: UnefaColors.navy,
    borderRadius: 18,
    padding: 16,
    borderWidth: 1,
    borderColor: 'rgba(242, 184, 7, 0.4)',
  },
  carnetHeader: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    borderBottomWidth: 1,
    borderBottomColor: 'rgba(255, 255, 255, 0.15)',
    paddingBottom: 10,
    marginBottom: 14,
  },
  carnetHeaderLeft: {
    flex: 1,
  },
  carnetHeaderTitle: {
    fontSize: 8,
    fontWeight: '800',
    color: '#cbd5e1',
    letterSpacing: 0.4,
  },
  carnetHeaderSub: {
    fontSize: 7,
    color: '#94a3b8',
    letterSpacing: 0.3,
  },
  carnetHeaderUnefa: {
    fontSize: 11,
    fontWeight: '900',
    color: UnefaColors.gold,
    marginTop: 2,
    letterSpacing: 0.5,
  },
  carnetBadgeGold: {
    backgroundColor: UnefaColors.gold,
    paddingHorizontal: 8,
    paddingVertical: 3,
    borderRadius: 6,
    alignSelf: 'flex-start',
  },
  carnetBadgeGoldText: {
    fontSize: 11,
    fontWeight: '900',
    color: UnefaColors.navy,
  },
  carnetBody: {
    flexDirection: 'row',
    gap: 14,
  },
  carnetPhotoBox: {
    width: 78,
    height: 96,
    borderRadius: 10,
    backgroundColor: '#ffffff',
    alignItems: 'center',
    justifyContent: 'center',
    borderWidth: 2,
    borderColor: UnefaColors.gold,
    padding: 4,
  },
  carnetPhotoText: {
    fontSize: 8,
    fontWeight: '800',
    color: '#64748b',
    textAlign: 'center',
    marginTop: 4,
  },
  carnetDetails: {
    flex: 1,
  },
  carnetName: {
    fontSize: 13,
    fontWeight: '900',
    color: '#ffffff',
    marginBottom: 2,
  },
  carnetCedula: {
    fontSize: 12,
    fontWeight: '800',
    color: UnefaColors.gold,
    marginBottom: 2,
  },
  carnetCareer: {
    fontSize: 10,
    fontWeight: '700',
    color: '#cbd5e1',
    marginBottom: 2,
  },
  carnetMeta: {
    fontSize: 9,
    fontWeight: '800',
    color: '#10b981',
    marginBottom: 8,
  },
  carnetQrRow: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 8,
    backgroundColor: '#ffffff',
    borderRadius: 8,
    padding: 4,
  },
  qrIconWrap: {
    width: 44,
    height: 44,
    alignItems: 'center',
    justifyContent: 'center',
  },
  barcodeWrap: {
    flex: 1,
  },
  barcodeText: {
    fontSize: 10,
    letterSpacing: 2,
    color: '#0f172a',
    fontFamily: 'monospace',
    fontWeight: '700',
  },
  barcodeCode: {
    fontSize: 8,
    color: '#64748b',
    fontWeight: '700',
    fontFamily: 'monospace',
  },

  // Metrics Grid
  metricsGrid: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    gap: 10,
  },
  metricCard: {
    flex: 1,
    minWidth: '45%',
    backgroundColor: '#f8fafc',
    borderRadius: 14,
    padding: 14,
    borderWidth: 1,
    borderColor: '#e2e8f0',
    alignItems: 'center',
  },
  metricNumber: {
    fontSize: 22,
    fontWeight: '900',
    color: '#0f172a',
    marginBottom: 4,
  },
  metricLabel: {
    fontSize: 11,
    color: '#64748b',
    fontWeight: '600',
    textAlign: 'center',
  },

  // Content Blocks
  contentBlock: {
    backgroundColor: '#ffffff',
    borderRadius: 18,
    padding: 16,
    borderWidth: 1,
    borderColor: '#e2e8f0',
  },
  blockHead: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'flex-start',
    marginBottom: 14,
  },
  blockKicker: {
    fontSize: 10,
    fontWeight: '800',
    color: UnefaColors.blue,
    letterSpacing: 0.6,
    textTransform: 'uppercase',
    marginBottom: 2,
  },
  blockTitle: {
    fontSize: 16,
    fontWeight: '900',
    color: '#0f172a',
  },
  pillGreen: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 4,
    backgroundColor: '#dcfce7',
    paddingHorizontal: 8,
    paddingVertical: 4,
    borderRadius: 8,
  },
  pillGreenText: {
    fontSize: 11,
    fontWeight: '800',
    color: UnefaColors.green,
  },

  // Subject Cards (Estudiante)
  subjectCard: {
    backgroundColor: '#f8fafc',
    borderRadius: 14,
    padding: 14,
    marginBottom: 10,
    borderWidth: 1,
    borderColor: '#e2e8f0',
  },
  subjectTop: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: 6,
  },
  codeTag: {
    backgroundColor: '#e2e8f0',
    paddingHorizontal: 6,
    paddingVertical: 2,
    borderRadius: 6,
  },
  codeTagText: {
    fontSize: 10,
    fontWeight: '800',
    color: '#334155',
    fontFamily: 'monospace',
  },
  percentBadge: {
    backgroundColor: 'rgba(4, 15, 217, 0.1)',
    paddingHorizontal: 8,
    paddingVertical: 2,
    borderRadius: 12,
  },
  percentBadgeText: {
    fontSize: 11,
    fontWeight: '900',
    color: UnefaColors.blue,
  },
  subjectName: {
    fontSize: 14,
    fontWeight: '800',
    color: '#0f172a',
    marginBottom: 2,
  },
  subjectProf: {
    fontSize: 12,
    color: '#475569',
    marginBottom: 8,
  },
  subjectFooter: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    paddingTop: 8,
    borderTopWidth: StyleSheet.hairlineWidth,
    borderTopColor: '#e2e8f0',
  },
  roomInfo: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 4,
  },
  roomText: {
    fontSize: 11,
    color: '#64748b',
    fontWeight: '600',
  },
  hoursText: {
    fontSize: 11,
    fontWeight: '700',
    color: UnefaColors.blue,
  },

  // Services Grid
  servicesGrid: {
    gap: 8,
    marginTop: 10,
  },
  serviceItem: {
    backgroundColor: '#f8fafc',
    borderRadius: 12,
    padding: 12,
    borderWidth: 1,
    borderColor: '#e2e8f0',
  },
  serviceItemTop: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: 4,
  },
  serviceItemTitle: {
    fontSize: 13,
    fontWeight: '800',
    color: '#0f172a',
  },
  serviceItemDesc: {
    fontSize: 11,
    color: '#64748b',
    lineHeight: 16,
  },

  // Course Cards (Profesor)
  courseCard: {
    backgroundColor: '#f8fafc',
    borderRadius: 14,
    padding: 14,
    marginBottom: 12,
    borderWidth: 1,
    borderColor: '#e2e8f0',
  },
  courseTop: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'flex-start',
    marginBottom: 8,
  },
  courseSec: {
    fontSize: 11,
    fontWeight: '800',
    color: '#0d9488',
    textTransform: 'uppercase',
  },
  courseName: {
    fontSize: 15,
    fontWeight: '900',
    color: '#0f172a',
  },
  courseAttendanceBadge: {
    backgroundColor: 'rgba(13, 148, 136, 0.1)',
    borderRadius: 10,
    paddingHorizontal: 8,
    paddingVertical: 4,
    alignItems: 'center',
  },
  courseAttendanceText: {
    fontSize: 13,
    fontWeight: '900',
    color: '#0d9488',
  },
  courseAttendanceLabel: {
    fontSize: 9,
    fontWeight: '700',
    color: '#0d9488',
  },
  courseMetaRow: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    gap: 10,
    marginBottom: 12,
  },
  courseMetaText: {
    fontSize: 11,
    color: '#475569',
    fontWeight: '600',
  },
  courseActionRow: {
    flexDirection: 'row',
    gap: 8,
    paddingTop: 10,
    borderTopWidth: StyleSheet.hairlineWidth,
    borderTopColor: '#e2e8f0',
  },
  actionPill: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 6,
    backgroundColor: UnefaColors.blue,
    paddingHorizontal: 12,
    paddingVertical: 8,
    borderRadius: 10,
    flex: 1,
    justifyContent: 'center',
  },
  actionPillText: {
    fontSize: 12,
    fontWeight: '800',
    color: '#ffffff',
  },
  actionPillSecondary: {
    backgroundColor: '#ffffff',
    borderWidth: 1,
    borderColor: '#cbd5e1',
    paddingHorizontal: 12,
    paddingVertical: 8,
    borderRadius: 10,
    justifyContent: 'center',
  },
  actionPillSecondaryText: {
    fontSize: 12,
    fontWeight: '700',
    color: '#334155',
  },

  // Docente Actions List
  docenteActionsList: {
    gap: 10,
    marginTop: 10,
  },
  docenteActionItem: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 12,
    backgroundColor: '#f8fafc',
    borderRadius: 12,
    padding: 12,
    borderWidth: 1,
    borderColor: '#e2e8f0',
  },
  docenteActionText: {
    flex: 1,
  },
  docenteActionTitle: {
    fontSize: 13,
    fontWeight: '800',
    color: '#0f172a',
  },
  docenteActionSub: {
    fontSize: 11,
    color: '#64748b',
  },

  // Coordinacion Items
  coordinacionItem: {
    backgroundColor: '#f8fafc',
    borderRadius: 14,
    padding: 14,
    marginBottom: 10,
    borderWidth: 1,
    borderColor: '#e2e8f0',
  },
  coordTop: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: 6,
  },
  coordTitle: {
    fontSize: 13,
    fontWeight: '800',
    color: '#0f172a',
  },
  coordBadge: {
    backgroundColor: 'rgba(180, 83, 9, 0.1)',
    paddingHorizontal: 8,
    paddingVertical: 2,
    borderRadius: 8,
  },
  coordBadgeText: {
    fontSize: 10,
    fontWeight: '800',
    color: '#b45309',
  },
  coordVal: {
    fontSize: 15,
    fontWeight: '900',
    color: '#b45309',
    marginBottom: 4,
  },
  coordDesc: {
    fontSize: 11,
    color: '#475569',
    lineHeight: 16,
  },

  // Director View
  directorCareerCard: {
    backgroundColor: '#f8fafc',
    borderRadius: 14,
    padding: 14,
    marginBottom: 14,
    borderWidth: 1,
    borderColor: '#e2e8f0',
  },
  directorCareerTitle: {
    fontSize: 13,
    fontWeight: '800',
    color: '#0f172a',
    marginBottom: 12,
  },
  progressRow: {
    marginBottom: 10,
  },
  progressTextRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginBottom: 4,
  },
  progressLabel: {
    fontSize: 11,
    color: '#334155',
    fontWeight: '600',
  },
  progressValue: {
    fontSize: 11,
    fontWeight: '800',
    color: UnefaColors.navy,
  },
  progressBarTrack: {
    height: 8,
    backgroundColor: '#e2e8f0',
    borderRadius: 4,
    overflow: 'hidden',
  },
  progressBarFill: {
    height: '100%',
    backgroundColor: UnefaColors.navy,
    borderRadius: 4,
  },
  directorGrid: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    gap: 10,
  },
  directorStatBox: {
    flex: 1,
    minWidth: '45%',
    backgroundColor: '#f8fafc',
    borderRadius: 14,
    padding: 12,
    borderWidth: 1,
    borderColor: '#e2e8f0',
    alignItems: 'center',
  },
  directorStatNum: {
    fontSize: 16,
    fontWeight: '900',
    color: '#0f172a',
    marginTop: 6,
    marginBottom: 2,
  },
  directorStatLbl: {
    fontSize: 10,
    color: '#64748b',
    fontWeight: '600',
    textAlign: 'center',
  },

  // Bottom Actions
  bottomActions: {
    marginTop: 10,
    marginBottom: 20,
    alignItems: 'center',
  },
  backToLoginBtn: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 8,
    paddingVertical: 12,
    paddingHorizontal: 20,
    borderRadius: 12,
    backgroundColor: '#f1f5f9',
    borderWidth: 1,
    borderColor: '#cbd5e1',
  },
  backToLoginText: {
    fontSize: 13,
    fontWeight: '800',
    color: UnefaColors.navy,
  },
});
