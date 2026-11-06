import React, { useState, useRef } from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  Pressable,
  LayoutChangeEvent,
  type ScrollViewProps,
} from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';

// ScrollView imperative handle type
type ScrollViewHandle = React.ElementRef<typeof ScrollView>;
import { Image } from 'expo-image';
import { useRouter } from 'expo-router';
import { UnefaColors, MaxContentWidth } from '@/constants/theme';
import { Header } from '@/components/Header';
import { BottomNav } from '@/components/BottomNav';
import { MenuDrawer } from '@/components/MenuDrawer';
import { QrModal } from '@/components/QrModal';
import {
  PILLARS_DATA,
  CAREERS_DATA,
  CHECKLIST_ITEMS,
  Career,
  Pillar,
} from '@/constants/data';

export default function LandingScreen() {
  const router = useRouter();
  const scrollRef = useRef<ScrollViewHandle>(null);

  // Modals
  const [menuOpen, setMenuOpen] = useState(false);
  const [qrOpen, setQrOpen] = useState(false);

  // Section Y positions for smooth scrolling
  const sectionPositions = useRef<{ [key: string]: number }>({});

  const handleLayoutSection = (key: string) => (event: LayoutChangeEvent) => {
    sectionPositions.current[key] = event.nativeEvent.layout.y;
  };

  const scrollToSection = (key: string) => {
    const y = sectionPositions.current[key];
    if (y !== undefined && scrollRef.current) {
      scrollRef.current.scrollTo({ y: Math.max(0, y - 20), animated: true });
    }
  };

  // Section 02 - Doctrina
  const [selectedPillarKey, setSelectedPillarKey] = useState<string>('ingenieria');
  const activePillar: Pillar = PILLARS_DATA[selectedPillarKey] || PILLARS_DATA.ingenieria;

  // Section 03 - Carreras
  const [selectedFaculty, setSelectedFaculty] = useState<string>('ingenieria');
  const careersInFaculty: Career[] = CAREERS_DATA[selectedFaculty] || [];
  const [selectedCareerId, setSelectedCareerId] = useState<string>(
    careersInFaculty[0]?.id || 'sistemas'
  );
  const activeCareer: Career =
    careersInFaculty.find((c) => c.id === selectedCareerId) ||
    careersInFaculty[0] ||
    CAREERS_DATA.ingenieria[0];

  // Section 04 - Verificador de recaudos
  const [checkedItems, setCheckedItems] = useState<{ [id: number]: boolean }>({
    1: true,
    2: true,
  });

  const toggleCheckItem = (id: number) => {
    setCheckedItems((prev) => ({
      ...prev,
      [id]: !prev[id],
    }));
  };

  const completedCount = CHECKLIST_ITEMS.filter((item) => checkedItems[item.id]).length;
  const percentage = Math.round((completedCount / CHECKLIST_ITEMS.length) * 100);

  return (
    <SafeAreaView style={[styles.root, styles.rootLight]}>
      <Header
        subtitle="Excelencia Educativa"
        onMenuPress={() => setMenuOpen(true)}
      />

      <ScrollView
        ref={scrollRef}
        style={styles.scroll}
        contentContainerStyle={styles.scrollContent}
        showsVerticalScrollIndicator={false}>
        <View style={styles.centerContainer}>
          {/* ── 01. HERO SECTION ─────────────────────────────────────────── */}
          <View
            style={[styles.hero, styles.sectionLight]}
            onLayout={handleLayoutSection('inicio')}>
            <Text style={styles.heroKicker}>[01] — Institución politécnica cívico-militar</Text>
            <Text style={[styles.heroTitle, styles.textDark]}>
              Vanguardia{'\n'}Técnica &{'\n'}
              <Text style={styles.heroTitleBlue}>Soberanía</Text>
            </Text>

            <Text style={[styles.heroDesc, styles.subLight]}>
              Formación politécnica rigurosa, investigación científica aplicada y valores
              cívico-militares con 100% de gratuidad de matrícula.
            </Text>

            <View style={styles.metricsRow}>
              <View style={[styles.metricCard, styles.cardLight]}>
                <Text style={[styles.metricVal, styles.textDark]}>
                  100%
                </Text>
                <Text style={styles.metricLbl}>Gratuidad</Text>
              </View>
              <View style={[styles.metricCard, styles.cardLight]}>
                <Text style={[styles.metricVal, styles.textDark]}>
                  24
                </Text>
                <Text style={styles.metricLbl}>Estados</Text>
              </View>
              <View style={[styles.metricCard, styles.cardLight]}>
                <Text style={[styles.metricVal, styles.blueVal]}>CINU</Text>
                <Text style={styles.metricLbl}>Convocatoria</Text>
              </View>
            </View>

            <View style={styles.heroCta}>
              <Pressable
                style={[styles.btn, styles.btnGold, styles.btnLg]}
                onPress={() => router.push('/registro')}>
                <Text style={styles.btnGoldText}>Preinscripción CINU</Text>
                <Text style={styles.btnGoldArrow}>→</Text>
              </Pressable>

              <Pressable
                style={[styles.btn, styles.btnOutline]}
                onPress={() => router.push('/login')}>
                <Text style={[styles.btnOutlineText, styles.textDark]}>
                  Portal SICEU
                </Text>
              </Pressable>

              <Pressable
                style={styles.heroLink}
                onPress={() => scrollToSection('carreras')}>
                <Text style={[styles.heroLinkText, styles.subLight]}>
                  Explorar carreras ↓
                </Text>
              </Pressable>
            </View>

            <View style={styles.photoContainer}>
              <Image
                source={{
                  uri: 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1200&q=80',
                }}
                style={styles.heroImg}
                contentFit="cover"
              />
              <View style={[styles.photoCaption, styles.captionLight]}>
                <View>
                  <Text style={[styles.captionTitle, styles.textDark]}>
                    FIG. 01 — LABORATORIO POLITÉCNICO
                  </Text>
                  <Text style={styles.captionSub}>
                    ROBÓTICA, AUTOMATIZACIÓN Y SISTEMAS APLICADOS
                  </Text>
                </View>
                <View style={styles.swatch} />
              </View>
            </View>

            <View style={styles.heroBadges}>
              <View style={[styles.heroBadge, styles.cardLight]}>
                <Text style={styles.badgeIcon}>⚙</Text>
                <View>
                  <Text style={[styles.badgeMain, styles.textDark]}>
                    Ingenierías
                  </Text>
                  <Text style={styles.badgeSub}>10 Semestres</Text>
                </View>
              </View>

              <View style={[styles.heroBadge, styles.cardLight]}>
                <Text style={[styles.badgeIcon, styles.goldIcon]}>★</Text>
                <View>
                  <Text style={[styles.badgeMain, styles.textDark]}>
                    Cívico-Militar
                  </Text>
                  <Text style={styles.badgeSub}>Doctrina Integral</Text>
                </View>
              </View>
            </View>
          </View>

          {/* ── 02. DOCTRINA SECTION ─────────────────────────────────────── */}
          <View
            style={[styles.section, styles.sectionLightAlt]}
            onLayout={handleLayoutSection('nosotros')}>
            <View style={styles.sectionHead}>
              <Text style={styles.kicker}>[02] — Doctrina &amp; fundamentos</Text>
              <Text style={[styles.sectionTitle, styles.textDark]}>
                Pilares del modelo unefista
              </Text>
              <Text style={[styles.sectionDesc, styles.subLight]}>
                Una propuesta pedagógica única que une la disciplina del método científico
                con la mística y responsabilidad cívico-militar.
              </Text>
            </View>

            <ScrollView
              horizontal
              showsHorizontalScrollIndicator={false}
              contentContainerStyle={styles.scrollerRow}>
              {Object.keys(PILLARS_DATA).map((key) => {
                const item = PILLARS_DATA[key];
                const isActive = selectedPillarKey === key;
                return (
                  <Pressable
                    key={key}
                    style={[
                      styles.pillarTab,
                      styles.pillarTabLight,
                      isActive && styles.pillarTabActive,
                    ]}
                    onPress={() => setSelectedPillarKey(key)}>
                    <View style={styles.pIndexRow}>
                      <Text style={[styles.pNum, isActive && styles.pNumActive]}>[{item.number}]</Text>
                      <Text style={styles.pSubtitle}>{item.subtitle}</Text>
                    </View>
                    <Text
                      style={[
                        styles.pName,
                        styles.textDark,
                        isActive && styles.pNameActive,
                      ]}>
                      {item.tabTitle}
                    </Text>
                  </Pressable>
                );
              })}
            </ScrollView>

            {/* Dossier Card */}
            <View style={[styles.dossier, styles.cardLight]}>
              <View style={styles.dossierMedia}>
                <Image
                  source={{ uri: activePillar.image }}
                  style={styles.dossierImg}
                  contentFit="cover"
                />
                <View style={[styles.dossierCaptionBox, styles.captionLight]}>
                  <Text style={[styles.dossierCaptionText, styles.textDark]}>
                    {activePillar.caption}
                  </Text>
                </View>
              </View>

              <View style={styles.dossierBody}>
                <View style={styles.bluePill}>
                  <Text style={styles.bluePillText}>Área {activePillar.number}</Text>
                </View>
                <Text style={[styles.dossierTitle, styles.textDark]}>
                  {activePillar.title}
                </Text>
                <Text style={[styles.dossierDesc, styles.subLight]}>
                  {activePillar.description}
                </Text>

                <View style={styles.highlightSection}>
                  <Text style={styles.listLabel}>Hitos de formación</Text>
                  {activePillar.highlights.map((h, i) => (
                    <View key={i} style={styles.highlightItem}>
                      <Text style={styles.highlightArrow}>→</Text>
                      <Text style={[styles.highlightText, styles.textDark]}>
                        {h}
                      </Text>
                    </View>
                  ))}
                </View>
              </View>
            </View>

            <View style={[styles.lemaBox, styles.lemaBoxLight]}>
              <Text style={styles.lemaLabel}>Lema institucional</Text>
              <Text style={[styles.lemaText, styles.textDark]}>
                "Excelencia Educativa Abierta al Pueblo"
              </Text>
            </View>
          </View>

          {/* ── 03. CARRERAS SECTION ─────────────────────────────────────── */}
          <View
            style={[styles.section, styles.sectionLight]}
            onLayout={handleLayoutSection('carreras')}>
            <View style={styles.sectionHeadRow}>
              <View>
                <Text style={styles.kicker}>[03] — Oferta académica</Text>
                <Text style={[styles.sectionTitle, styles.textDark]}>
                  Explorador de carreras
                </Text>
              </View>
              <Pressable onPress={() => router.push('/registro')}>
                <Text style={styles.miniLink}>Inscripción →</Text>
              </Pressable>
            </View>

            {/* Segmented control */}
            <View style={[styles.segmented, styles.segmentedLight]}>
              <Pressable
                style={[styles.segBtn, selectedFaculty === 'ingenieria' && styles.segBtnActive]}
                onPress={() => {
                  setSelectedFaculty('ingenieria');
                  setSelectedCareerId(CAREERS_DATA.ingenieria[0].id);
                }}>
                <Text
                  style={[
                    styles.segLabel,
                    selectedFaculty === 'ingenieria' && styles.segLabelActive,
                  ]}>
                  Ingenierías
                </Text>
                <Text style={styles.segMeta}>10 sem.</Text>
              </Pressable>

              <Pressable
                style={[styles.segBtn, selectedFaculty === 'licenciaturas' && styles.segBtnActive]}
                onPress={() => {
                  setSelectedFaculty('licenciaturas');
                  setSelectedCareerId(CAREERS_DATA.licenciaturas[0].id);
                }}>
                <Text
                  style={[
                    styles.segLabel,
                    selectedFaculty === 'licenciaturas' && styles.segLabelActive,
                  ]}>
                  Licenciaturas
                </Text>
                <Text style={styles.segMeta}>8 sem.</Text>
              </Pressable>

              <Pressable
                style={[styles.segBtn, selectedFaculty === 'tsu' && styles.segBtnActive]}
                onPress={() => {
                  setSelectedFaculty('tsu');
                  setSelectedCareerId(CAREERS_DATA.tsu[0].id);
                }}>
                <Text
                  style={[
                    styles.segLabel,
                    selectedFaculty === 'tsu' && styles.segLabelActive,
                  ]}>
                  Técnico Superior
                </Text>
                <Text style={styles.segMeta}>6 sem.</Text>
              </Pressable>
            </View>

            {/* Career buttons list */}
            <View style={styles.careerList}>
              {careersInFaculty.map((item) => {
                const isSelected = activeCareer.id === item.id;
                return (
                  <Pressable
                    key={item.id}
                    style={[
                      styles.careerBtn,
                      styles.cardLight,
                      isSelected && styles.careerBtnActive,
                    ]}
                    onPress={() => setSelectedCareerId(item.id)}>
                    <View style={styles.careerBtnTop}>
                      <Text style={[styles.careerCode, isSelected && styles.careerCodeActive]}>
                        {item.code}
                      </Text>
                      <Text style={styles.careerDuration}>{item.duration}</Text>
                    </View>
                    <Text
                      style={[
                        styles.careerBtnTitle,
                        styles.textDark,
                        isSelected && styles.careerBtnTitleActive,
                      ]}>
                      {item.title}
                    </Text>
                  </Pressable>
                );
              })}
            </View>

            {/* Career Detailed Dossier */}
            <View style={[styles.dossier, styles.cardLight]}>
              <View style={styles.dossierMedia}>
                <Image
                  source={{ uri: activeCareer.image }}
                  style={styles.dossierImg}
                  contentFit="cover"
                />
                <View style={styles.careerMediaTag}>
                  <Text style={styles.careerMediaTagText}>{activeCareer.code}</Text>
                </View>
                <View style={styles.careerMediaFooter}>
                  <Text style={styles.careerDegreeText}>{activeCareer.degree}</Text>
                  <Text style={styles.careerDurationGold}>{activeCareer.duration}</Text>
                </View>
              </View>

              <View style={styles.dossierBody}>
                <Text style={[styles.dossierTitle, styles.textDark]}>
                  {activeCareer.title}
                </Text>
                <Text style={[styles.dossierDesc, styles.subLight]}>
                  {activeCareer.description}
                </Text>

                <View style={styles.highlightSection}>
                  <Text style={styles.listLabel}>Competencias principales</Text>
                  {activeCareer.competencies.map((c, i) => (
                    <View key={i} style={styles.highlightItem}>
                      <Text style={styles.competencySquare}>■</Text>
                      <Text style={[styles.highlightText, styles.textDark]}>
                        {c}
                      </Text>
                    </View>
                  ))}
                </View>

                <View style={styles.subjectsSection}>
                  <Text style={styles.listLabel}>Materias troncales</Text>
                  <View style={styles.chipsRow}>
                    {activeCareer.subjects.map((sub, i) => (
                      <View
                        key={i}
                        style={[styles.chip, styles.chipLight]}>
                        <Text style={[styles.chipText, styles.textDark]}>
                          {sub}
                        </Text>
                      </View>
                    ))}
                  </View>
                </View>

                <View style={styles.careerCta}>
                  <Text style={styles.monoNote}>
                    Modalidad presencial · Núcleo Central y sedes regionales
                  </Text>
                  <Pressable
                    style={[styles.btn, styles.btnGold]}
                    onPress={() => router.push('/registro')}>
                    <Text style={styles.btnGoldText}>Postularme en esta carrera</Text>
                    <Text style={styles.btnGoldArrow}>→</Text>
                  </Pressable>
                </View>
              </View>
            </View>
          </View>

          {/* ── 04. ADMISIONES & VERIFICADOR CINU ─────────────────────────── */}
          <View
            style={[styles.section, styles.sectionLightAlt]}
            onLayout={handleLayoutSection('admisiones')}>
            <View style={styles.sectionHead}>
              <Text style={styles.kicker}>[04] — Admisiones &amp; nivelación</Text>
              <Text style={[styles.sectionTitle, styles.textDark]}>
                Ruta de ingreso y verificador CINU
              </Text>
              <Text style={[styles.sectionDesc, styles.subLight]}>
                Todos los aspirantes formalizan su acceso a través del Curso Integral de
                Nivelación Universitaria. Verifica tus recaudos antes de iniciar el registro.
              </Text>
            </View>

            {/* Timeline */}
            <View style={styles.timeline}>
              {[
                {
                  num: '01',
                  title: 'Registro digital',
                  desc: 'Creación de expediente en el portal, selección de carrera politécnica y sede regional asignada.',
                },
                {
                  num: '02',
                  title: 'Consignación de recaudos',
                  desc: 'Revisión física de documentos en la Unidad de Control de Estudios de tu núcleo UNEFA.',
                },
                {
                  num: '03',
                  title: 'Cursado del CINU',
                  desc: '14 semanas intensivas en Matemática, Habilidades de Comunicación y Doctrina Cívico-Militar.',
                },
                {
                  num: '04',
                  title: 'Activación en SICEU',
                  desc: 'Asignación definitiva de matrícula e inicio del primer semestre académico regular.',
                },
              ].map((step, idx) => (
                <View key={idx} style={styles.timelineItem}>
                  <View style={styles.timelineNumBox}>
                    <Text style={styles.timelineNum}>{step.num}</Text>
                  </View>
                  <View style={styles.timelineContent}>
                    <Text style={[styles.timelineTitle, styles.textDark]}>
                      {step.title}
                    </Text>
                    <Text style={[styles.timelineDesc, styles.subLight]}>
                      {step.desc}
                    </Text>
                  </View>
                </View>
              ))}
            </View>

            {/* Sede central photo */}
            <View style={styles.photoContainer}>
              <Image
                source={{
                  uri: 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=1200&q=80',
                }}
                style={styles.sedeImg}
                contentFit="cover"
              />
              <View style={[styles.photoCaption, styles.captionLight]}>
                <Text style={[styles.captionTitle, styles.textDark]}>
                  INSTALACIONES DE PREGRADO Y POSTGRADO
                </Text>
                <Text style={styles.goldText}>SEDES EN 24 ESTADOS</Text>
              </View>
            </View>

            {/* Interactive Verificador */}
            <View style={[styles.verifier, styles.cardLight]}>
              <View style={styles.verifierHead}>
                <View>
                  <Text style={styles.verifierKicker}>Herramienta del aspirante</Text>
                  <Text style={[styles.verifierTitle, styles.textDark]}>
                    Verificador de recaudos
                  </Text>
                </View>
                <View style={styles.percentWrap}>
                  <Text style={styles.percentText}>{percentage}%</Text>
                  <Text style={styles.percentLabel}>Listo para consignar</Text>
                </View>
              </View>

              {/* Progress bar */}
              <View style={styles.progressBarTrack}>
                <View style={[styles.progressBarFill, { width: `${percentage}%` }]} />
              </View>

              <Text style={[styles.hintText, styles.subLight]}>
                Marca los recaudos que ya posees en físico para calcular tu preparación:
              </Text>

              {/* Checklist items */}
              <View style={styles.checklist}>
                {CHECKLIST_ITEMS.map((item) => {
                  const isChecked = !!checkedItems[item.id];
                  return (
                    <Pressable
                      key={item.id}
                      style={[
                        styles.checkItem,
                        styles.checkItemLight,
                        isChecked && styles.checkItemActive,
                      ]}
                      onPress={() => toggleCheckItem(item.id)}>
                      <View style={[styles.checkBox, isChecked && styles.checkBoxChecked]}>
                        {isChecked && <Text style={styles.checkMark}>✓</Text>}
                      </View>
                      <Text
                        style={[
                          styles.checkText,
                          styles.textDark,
                          isChecked && styles.checkTextActive,
                        ]}>
                        {item.text}
                      </Text>
                      <View style={styles.phasePill}>
                        <Text style={styles.phaseText}>{item.phase}</Text>
                      </View>
                    </Pressable>
                  );
                })}
              </View>

              <View
                style={[
                  styles.feedbackBox,
                  percentage === 100 ? styles.feedbackSuccess : styles.feedbackNormal,
                ]}>
                <Text
                  style={[
                    styles.feedbackText,
                    percentage === 100 ? styles.feedbackSuccessText : styles.feedbackNormalText,
                  ]}>
                  {percentage === 100
                    ? '¡100% de recaudos listos! Puedes formalizar tu expediente en Control de Estudios sin demoras.'
                    : `Tienes ${completedCount} de ${CHECKLIST_ITEMS.length} recaudos completados.`}
                </Text>
              </View>

              <Pressable
                style={[styles.btn, styles.btnGold]}
                onPress={() => router.push('/registro')}>
                <Text style={styles.btnGoldText}>Iniciar preinscripción digital</Text>
                <Text style={styles.btnGoldArrow}>→</Text>
              </Pressable>

              <Text style={styles.secureNote}>
                🛡 Trámite 100% público y gratuito, sin intermediarios
              </Text>
            </View>
          </View>

          {/* ── 05. SERVICIOS DIGITALES ──────────────────────────────────── */}
          <View
            style={[styles.section, styles.sectionLight]}
            onLayout={handleLayoutSection('servicios')}>
            <View style={styles.sectionHeadRow}>
              <View>
                <Text style={styles.kicker}>[05] — Plataformas &amp; servicios</Text>
                <Text style={[styles.sectionTitle, styles.textDark]}>
                  Servicios digitales
                </Text>
              </View>
              <Pressable onPress={() => router.push('/login')}>
                <Text style={styles.miniLink}>Ingreso →</Text>
              </Pressable>
            </View>

            <View style={styles.serviceStack}>
              {/* Service 01 */}
              <View
                style={[
                  styles.serviceCard,
                  styles.serviceCardFeatured,
                  styles.cardLight,
                ]}>
                <View style={styles.serviceMeta}>
                  <View style={styles.goldPill}>
                    <Text style={styles.goldPillText}>SVC-01</Text>
                  </View>
                  <View style={styles.neutralPill}>
                    <Text style={styles.neutralPillText}>Sistema central</Text>
                  </View>
                </View>
                <Text style={[styles.serviceTitle, styles.textDark]}>
                  Portal SICEU
                </Text>
                <Text style={[styles.serviceDesc, styles.subLight]}>
                  Consulta de calificaciones, récord académico, inscripción de asignaturas,
                  control de asistencia y aulas asignadas.
                </Text>
                <Pressable
                  style={[styles.btn, styles.btnGold]}
                  onPress={() => router.push('/login')}>
                  <Text style={styles.btnGoldText}>Acceder a SICEU</Text>
                </Pressable>
              </View>

              {/* Service 02 */}
              <View style={[styles.serviceCard, styles.cardLight]}>
                <View style={styles.serviceMeta}>
                  <View style={styles.neutralPill}>
                    <Text style={styles.neutralPillText}>SVC-02</Text>
                  </View>
                  <View style={styles.neutralPill}>
                    <Text style={styles.neutralPillText}>Semestre 2026-I</Text>
                  </View>
                </View>
                <Text style={[styles.serviceTitle, styles.textDark]}>
                  Calendario oficial
                </Text>
                <Text style={[styles.serviceDesc, styles.subLight]}>
                  Fechas de inicio de clases, cortes de notas parciales, solicitudes de retiro o
                  adición y actos solemnes de grado.
                </Text>
                <Pressable
                  style={[styles.btn, styles.btnOutline]}
                  onPress={() => scrollToSection('inicio')}>
                  <Text
                    style={[styles.btnOutlineText, styles.textDark]}>
                    Consultar fechas
                  </Text>
                </Pressable>
              </View>

              {/* Service 03 */}
              <View style={[styles.serviceCard, styles.cardLight]}>
                <View style={styles.serviceMeta}>
                  <View style={styles.neutralPill}>
                    <Text style={styles.neutralPillText}>SVC-03</Text>
                  </View>
                  <View style={styles.neutralPill}>
                    <Text style={styles.neutralPillText}>Trámites</Text>
                  </View>
                </View>
                <Text style={[styles.serviceTitle, styles.textDark]}>
                  Constancias en línea
                </Text>
                <Text style={[styles.serviceDesc, styles.subLight]}>
                  Generación automatizada de constancias de estudio, notas certificadas y cartas de
                  culminación con firma digital.
                </Text>
                <Pressable
                  style={[styles.btn, styles.btnOutline]}
                  onPress={() => router.push('/login')}>
                  <Text
                    style={[styles.btnOutlineText, styles.textDark]}>
                    Gestión digital
                  </Text>
                </Pressable>
              </View>

              {/* Service 04 */}
              <View style={[styles.serviceCard, styles.cardLight]}>
                <View style={styles.serviceMeta}>
                  <View style={styles.neutralPill}>
                    <Text style={styles.neutralPillText}>SVC-04</Text>
                  </View>
                  <View style={styles.neutralPill}>
                    <Text style={styles.neutralPillText}>Ciencia</Text>
                  </View>
                </View>
                <Text style={[styles.serviceTitle, styles.textDark]}>
                  Repositorio y tesis
                </Text>
                <Text style={[styles.serviceDesc, styles.subLight]}>
                  Acceso público y digital a trabajos especiales de grado, guías metodológicas de
                  ingeniería y revistas de investigación.
                </Text>
                <Pressable
                  style={[styles.btn, styles.btnOutline]}
                  onPress={() => scrollToSection('carreras')}>
                  <Text
                    style={[styles.btnOutlineText, styles.textDark]}>
                    Abrir repositorio
                  </Text>
                </Pressable>
              </View>
            </View>
          </View>

          {/* ── FOOTER ─────────────────────────────────────────────────── */}
          <View style={[styles.footer, styles.footerLight]}>
            <View style={styles.footerBrand}>
              <View style={styles.footerLogoWrap}>
                <Image
                  source={require('@/assets/images/unefa-logo.png')}
                  style={styles.footerLogo}
                  contentFit="contain"
                />
              </View>
              <Text style={[styles.footerBrandText, styles.textDark]}>
                UNEFA
              </Text>
            </View>

            <Text style={[styles.footerAbout, styles.subLight]}>
              Universidad Nacional Experimental Politécnica de la Fuerza Armada Nacional
              Bolivariana. Institución pública formadora de profesionales con excelencia técnica,
              disciplina y compromiso patriótico.
            </Text>

            <View style={styles.footerNavGrid}>
              <View style={styles.footerNavCol}>
                <Text style={[styles.footerColHead, styles.textDark]}>
                  Navegación
                </Text>
                <Pressable onPress={() => scrollToSection('inicio')}>
                  <Text style={styles.footerLink}>Página principal</Text>
                </Pressable>
                <Pressable onPress={() => scrollToSection('nosotros')}>
                  <Text style={styles.footerLink}>Doctrina</Text>
                </Pressable>
                <Pressable onPress={() => scrollToSection('carreras')}>
                  <Text style={styles.footerLink}>Catálogo carreras</Text>
                </Pressable>
                <Pressable onPress={() => scrollToSection('admisiones')}>
                  <Text style={styles.footerLink}>Admisión CINU</Text>
                </Pressable>
              </View>

              <View style={styles.footerNavCol}>
                <Text style={[styles.footerColHead, styles.textDark]}>
                  Plataformas
                </Text>
                <Pressable onPress={() => router.push('/login')}>
                  <Text style={styles.footerLink}>SICEU estudiantes</Text>
                </Pressable>
                <Pressable onPress={() => router.push('/login')}>
                  <Text style={styles.footerLink}>SICEU docentes</Text>
                </Pressable>
                <Pressable onPress={() => router.push('/registro')}>
                  <Text style={styles.footerLink}>Preinscripción CINU</Text>
                </Pressable>
                <Pressable onPress={() => scrollToSection('servicios')}>
                  <Text style={styles.footerLink}>Biblioteca digital</Text>
                </Pressable>
              </View>
            </View>

            <View style={styles.footerAddress}>
              <Text style={[styles.footerAddrBold, styles.textDark]}>
                Sede Central
              </Text>
              <Text style={[styles.footerAddrText, styles.subLight]}>
                Edificio Sede UNEFA, Chuao.{'\n'}
                Caracas, República Bolivariana de Venezuela.{'\n'}
                Teléfono: +58 (0212) 908-2000
              </Text>
            </View>

            <View style={styles.footerBottom}>
              <Text style={styles.copyright}>© 2026 UNEFA — Todos los derechos reservados.</Text>
              <Text style={styles.proposalBadge}>Propuesta de interfaz móvil · 2026</Text>
            </View>
          </View>
        </View>
      </ScrollView>

      {/* ── NAVEGACIÓN INFERIOR ─────────────────────────────────────────── */}
      <BottomNav
        activeTab="inicio"
        onPressInicio={() => scrollToSection('inicio')}
        onPressCarreras={() => scrollToSection('carreras')}
        onOpenQr={() => setQrOpen(true)}
      />

      {/* ── MODALES ────────────────────────────────────────────────────── */}
      <MenuDrawer
        visible={menuOpen}
        onClose={() => setMenuOpen(false)}
        onNavigateSection={(sec) => scrollToSection(sec)}
      />
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
  rootDark: {
    backgroundColor: '#0a0e17',
  },
  scroll: {
    flex: 1,
  },
  scrollContent: {
    paddingBottom: 20,
    alignItems: 'center',
  },
  centerContainer: {
    width: '100%',
    maxWidth: MaxContentWidth,
  },

  // Sections
  hero: {
    paddingHorizontal: 16,
    paddingTop: 20,
    paddingBottom: 32,
  },
  section: {
    paddingHorizontal: 16,
    paddingVertical: 32,
  },
  sectionLight: {
    backgroundColor: '#ffffff',
  },
  sectionDark: {
    backgroundColor: '#0a0e17',
  },
  sectionLightAlt: {
    backgroundColor: '#f8fafc',
    borderTopWidth: 1,
    borderBottomWidth: 1,
    borderColor: '#e2e8f0',
  },
  sectionDarkAlt: {
    backgroundColor: '#06152a',
    borderTopWidth: 1,
    borderBottomWidth: 1,
    borderColor: 'rgba(255, 255, 255, 0.08)',
  },

  // Hero texts
  heroKicker: {
    fontSize: 11,
    fontWeight: '800',
    color: UnefaColors.blue,
    textTransform: 'uppercase',
    letterSpacing: 0.5,
    marginBottom: 8,
  },
  heroTitle: {
    fontSize: 36,
    lineHeight: 40,
    fontWeight: '900',
    letterSpacing: -0.5,
    marginBottom: 12,
  },
  heroTitleBlue: {
    color: UnefaColors.blue,
  },
  heroDesc: {
    fontSize: 15,
    lineHeight: 22,
    marginBottom: 20,
  },

  // Metrics
  metricsRow: {
    flexDirection: 'row',
    gap: 10,
    marginBottom: 24,
  },
  metricCard: {
    flex: 1,
    padding: 12,
    borderRadius: 14,
    alignItems: 'center',
    shadowColor: '#06152a',
    shadowOffset: { width: 0, height: 4 },
    shadowOpacity: 0.06,
    shadowRadius: 8,
    elevation: 2,
  },
  metricVal: {
    fontSize: 22,
    fontWeight: '900',
  },
  blueVal: {
    color: UnefaColors.blue,
  },
  metricLbl: {
    fontSize: 11,
    fontWeight: '600',
    color: '#64748b',
    marginTop: 2,
  },

  // CTAs
  heroCta: {
    gap: 10,
    marginBottom: 24,
  },
  btn: {
    paddingVertical: 14,
    borderRadius: 14,
    alignItems: 'center',
    justifyContent: 'center',
    flexDirection: 'row',
    gap: 8,
  },
  btnLg: {
    paddingVertical: 16,
  },
  btnGold: {
    backgroundColor: UnefaColors.gold,
    shadowColor: UnefaColors.goldDark,
    shadowOffset: { width: 0, height: 6 },
    shadowOpacity: 0.25,
    shadowRadius: 10,
    elevation: 3,
  },
  btnGoldText: {
    color: UnefaColors.navy,
    fontWeight: '900',
    fontSize: 15,
  },
  btnGoldArrow: {
    color: UnefaColors.navy,
    fontWeight: '900',
    fontSize: 16,
  },
  btnOutline: {
    borderWidth: 1,
    borderColor: '#cbd5e1',
    backgroundColor: 'transparent',
  },
  btnOutlineDark: {
    borderColor: 'rgba(255, 255, 255, 0.2)',
  },
  btnOutlineText: {
    fontWeight: '700',
    fontSize: 14,
  },
  heroLink: {
    alignSelf: 'center',
    paddingVertical: 6,
  },
  heroLinkText: {
    fontSize: 13,
    fontWeight: '700',
  },

  // Hero photo
  photoContainer: {
    borderRadius: 18,
    overflow: 'hidden',
    marginBottom: 20,
    borderWidth: 1,
    borderColor: '#e2e8f0',
  },
  heroImg: {
    width: '100%',
    height: 200,
  },
  photoCaption: {
    padding: 12,
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
  },
  captionLight: {
    backgroundColor: '#ffffff',
  },
  captionDark: {
    backgroundColor: '#0d1829',
  },
  captionTitle: {
    fontSize: 10,
    fontWeight: '800',
    letterSpacing: 0.4,
  },
  captionSub: {
    fontSize: 9,
    color: '#64748b',
    fontWeight: '600',
  },
  swatch: {
    width: 14,
    height: 14,
    borderRadius: 7,
    backgroundColor: UnefaColors.blue,
  },

  // Hero badges
  heroBadges: {
    flexDirection: 'row',
    gap: 10,
  },
  heroBadge: {
    flex: 1,
    flexDirection: 'row',
    alignItems: 'center',
    gap: 10,
    padding: 12,
    borderRadius: 14,
  },
  badgeIcon: {
    fontSize: 20,
    color: UnefaColors.blue,
  },
  goldIcon: {
    color: UnefaColors.gold,
  },
  badgeMain: {
    fontSize: 13,
    fontWeight: '800',
  },
  badgeSub: {
    fontSize: 10,
    color: '#64748b',
    fontWeight: '600',
  },

  // Headings
  sectionHead: {
    marginBottom: 20,
  },
  sectionHeadRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'flex-start',
    marginBottom: 20,
  },
  kicker: {
    fontSize: 11,
    fontWeight: '800',
    color: UnefaColors.blue,
    textTransform: 'uppercase',
    letterSpacing: 0.5,
    marginBottom: 4,
  },
  sectionTitle: {
    fontSize: 24,
    fontWeight: '900',
    marginBottom: 6,
  },
  sectionDesc: {
    fontSize: 14,
    lineHeight: 20,
  },
  miniLink: {
    fontSize: 13,
    color: UnefaColors.blue,
    fontWeight: '800',
  },

  // Scroller
  scrollerRow: {
    gap: 8,
    paddingBottom: 16,
  },
  pillarTab: {
    paddingHorizontal: 14,
    paddingVertical: 10,
    borderRadius: 12,
    borderWidth: 1,
    minWidth: 150,
  },
  pillarTabLight: {
    backgroundColor: '#ffffff',
    borderColor: '#e2e8f0',
  },
  pillarTabDark: {
    backgroundColor: '#0d1829',
    borderColor: 'rgba(255, 255, 255, 0.12)',
  },
  pillarTabActive: {
    borderColor: UnefaColors.blue,
    backgroundColor: 'rgba(4, 15, 217, 0.06)',
  },
  pIndexRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginBottom: 4,
  },
  pNum: {
    fontSize: 11,
    fontFamily: 'monospace',
    fontWeight: '800',
    color: '#64748b',
  },
  pNumActive: {
    color: UnefaColors.blue,
  },
  pSubtitle: {
    fontSize: 10,
    color: '#64748b',
    fontWeight: '600',
  },
  pName: {
    fontSize: 13,
    fontWeight: '700',
  },
  pNameActive: {
    color: UnefaColors.blue,
  },

  // Dossier Card
  dossier: {
    borderRadius: 20,
    overflow: 'hidden',
    borderWidth: 1,
    borderColor: '#e2e8f0',
    marginBottom: 20,
    shadowColor: '#06152a',
    shadowOffset: { width: 0, height: 6 },
    shadowOpacity: 0.08,
    shadowRadius: 12,
    elevation: 3,
  },
  dossierMedia: {
    position: 'relative',
    height: 180,
  },
  dossierImg: {
    width: '100%',
    height: '100%',
  },
  dossierCaptionBox: {
    position: 'absolute',
    bottom: 0,
    left: 0,
    right: 0,
    paddingHorizontal: 12,
    paddingVertical: 6,
  },
  dossierCaptionText: {
    fontSize: 9,
    fontWeight: '700',
    letterSpacing: 0.3,
  },
  dossierBody: {
    padding: 16,
  },
  bluePill: {
    alignSelf: 'flex-start',
    backgroundColor: 'rgba(4, 15, 217, 0.1)',
    paddingHorizontal: 10,
    paddingVertical: 4,
    borderRadius: 8,
    marginBottom: 10,
  },
  bluePillText: {
    color: UnefaColors.blue,
    fontSize: 11,
    fontWeight: '800',
  },
  dossierTitle: {
    fontSize: 20,
    fontWeight: '900',
    marginBottom: 8,
  },
  dossierDesc: {
    fontSize: 13,
    lineHeight: 19,
    marginBottom: 16,
  },
  highlightSection: {
    marginBottom: 16,
  },
  listLabel: {
    fontSize: 11,
    fontWeight: '800',
    textTransform: 'uppercase',
    color: '#64748b',
    letterSpacing: 0.4,
    marginBottom: 8,
  },
  highlightItem: {
    flexDirection: 'row',
    alignItems: 'flex-start',
    gap: 8,
    marginBottom: 6,
  },
  highlightArrow: {
    color: UnefaColors.blue,
    fontSize: 14,
    fontWeight: '800',
  },
  highlightText: {
    flex: 1,
    fontSize: 12,
    lineHeight: 18,
    fontWeight: '500',
  },

  // Lema
  lemaBox: {
    padding: 16,
    borderRadius: 14,
    alignItems: 'center',
    borderWidth: 1,
  },
  lemaBoxLight: {
    backgroundColor: '#ffffff',
    borderColor: '#e2e8f0',
  },
  lemaBoxDark: {
    backgroundColor: '#0d1829',
    borderColor: 'rgba(255, 255, 255, 0.1)',
  },
  lemaLabel: {
    fontSize: 10,
    color: '#64748b',
    fontWeight: '800',
    textTransform: 'uppercase',
    letterSpacing: 0.4,
    marginBottom: 4,
  },
  lemaText: {
    fontSize: 14,
    fontWeight: '800',
    fontStyle: 'italic',
    textAlign: 'center',
  },

  // Segmented
  segmented: {
    flexDirection: 'row',
    borderRadius: 14,
    padding: 4,
    marginBottom: 16,
    borderWidth: 1,
  },
  segmentedLight: {
    backgroundColor: '#f1f5f9',
    borderColor: '#e2e8f0',
  },
  segmentedDark: {
    backgroundColor: '#0f1d33',
    borderColor: 'rgba(255, 255, 255, 0.1)',
  },
  segBtn: {
    flex: 1,
    paddingVertical: 8,
    borderRadius: 10,
    alignItems: 'center',
  },
  segBtnActive: {
    backgroundColor: UnefaColors.blue,
  },
  segLabel: {
    fontSize: 12,
    fontWeight: '800',
  },
  segLabelActive: {
    color: '#ffffff',
  },
  segMeta: {
    fontSize: 9,
    color: '#64748b',
  },

  // Career list
  careerList: {
    gap: 8,
    marginBottom: 20,
  },
  careerBtn: {
    padding: 12,
    borderRadius: 14,
    borderWidth: 1,
    borderColor: '#e2e8f0',
  },
  careerBtnActive: {
    borderColor: UnefaColors.blue,
    backgroundColor: 'rgba(4, 15, 217, 0.05)',
  },
  careerBtnTop: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginBottom: 2,
  },
  careerCode: {
    fontSize: 11,
    fontFamily: 'monospace',
    fontWeight: '800',
    color: '#64748b',
  },
  careerCodeActive: {
    color: UnefaColors.blue,
  },
  careerDuration: {
    fontSize: 11,
    color: '#64748b',
    fontWeight: '600',
  },
  careerBtnTitle: {
    fontSize: 14,
    fontWeight: '800',
  },
  careerBtnTitleActive: {
    color: UnefaColors.blue,
  },

  // Career Media Overlay
  careerMediaTag: {
    position: 'absolute',
    top: 10,
    left: 10,
    backgroundColor: UnefaColors.navy,
    paddingHorizontal: 8,
    paddingVertical: 3,
    borderRadius: 6,
  },
  careerMediaTagText: {
    color: '#ffffff',
    fontSize: 10,
    fontFamily: 'monospace',
    fontWeight: '800',
  },
  careerMediaFooter: {
    position: 'absolute',
    bottom: 0,
    left: 0,
    right: 0,
    backgroundColor: 'rgba(6, 21, 42, 0.85)',
    paddingHorizontal: 12,
    paddingVertical: 6,
    flexDirection: 'row',
    justifyContent: 'space-between',
  },
  careerDegreeText: {
    color: '#ffffff',
    fontSize: 11,
    fontWeight: '700',
  },
  careerDurationGold: {
    color: UnefaColors.gold,
    fontSize: 11,
    fontWeight: '800',
  },
  competencySquare: {
    color: UnefaColors.gold,
    fontSize: 11,
  },
  subjectsSection: {
    marginBottom: 16,
  },
  chipsRow: {
    flexDirection: 'row',
    flexWrap: 'wrap',
    gap: 6,
  },
  chip: {
    paddingHorizontal: 10,
    paddingVertical: 5,
    borderRadius: 20,
    borderWidth: 1,
  },
  chipLight: {
    backgroundColor: '#f1f5f9',
    borderColor: '#e2e8f0',
  },
  chipDark: {
    backgroundColor: '#13233c',
    borderColor: 'rgba(255, 255, 255, 0.1)',
  },
  chipText: {
    fontSize: 11,
    fontWeight: '600',
  },
  careerCta: {
    gap: 8,
    marginTop: 8,
  },
  monoNote: {
    fontSize: 10,
    fontFamily: 'monospace',
    color: '#64748b',
    textAlign: 'center',
  },

  // Timeline
  timeline: {
    gap: 12,
    marginBottom: 20,
  },
  timelineItem: {
    flexDirection: 'row',
    gap: 12,
  },
  timelineNumBox: {
    width: 32,
    height: 32,
    borderRadius: 16,
    backgroundColor: UnefaColors.goldSoft,
    alignItems: 'center',
    justifyContent: 'center',
  },
  timelineNum: {
    color: UnefaColors.goldDark,
    fontSize: 13,
    fontWeight: '900',
    fontFamily: 'monospace',
  },
  timelineContent: {
    flex: 1,
  },
  timelineTitle: {
    fontSize: 14,
    fontWeight: '800',
    marginBottom: 2,
  },
  timelineDesc: {
    fontSize: 12,
    lineHeight: 17,
  },
  sedeImg: {
    width: '100%',
    height: 180,
  },
  goldText: {
    color: UnefaColors.goldDark,
    fontSize: 10,
    fontWeight: '800',
  },

  // Verificador
  verifier: {
    padding: 18,
    borderRadius: 20,
    borderWidth: 1,
    borderColor: '#e2e8f0',
  },
  verifierHead: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: 14,
  },
  verifierKicker: {
    fontSize: 10,
    fontWeight: '800',
    color: UnefaColors.blue,
    textTransform: 'uppercase',
  },
  verifierTitle: {
    fontSize: 18,
    fontWeight: '900',
  },
  percentWrap: {
    alignItems: 'flex-end',
  },
  percentText: {
    fontSize: 22,
    fontWeight: '900',
    color: UnefaColors.goldDark,
  },
  percentLabel: {
    fontSize: 10,
    color: '#64748b',
    fontWeight: '600',
  },
  progressBarTrack: {
    height: 8,
    backgroundColor: '#e2e8f0',
    borderRadius: 4,
    overflow: 'hidden',
    marginBottom: 14,
  },
  progressBarFill: {
    height: '100%',
    backgroundColor: UnefaColors.gold,
  },
  hintText: {
    fontSize: 12,
    lineHeight: 17,
    marginBottom: 12,
  },
  checklist: {
    gap: 8,
    marginBottom: 16,
  },
  checkItem: {
    flexDirection: 'row',
    alignItems: 'center',
    padding: 10,
    borderRadius: 12,
    borderWidth: 1,
    gap: 10,
  },
  checkItemLight: {
    backgroundColor: '#ffffff',
    borderColor: '#e2e8f0',
  },
  checkItemDark: {
    backgroundColor: '#0d1829',
    borderColor: 'rgba(255, 255, 255, 0.1)',
  },
  checkItemActive: {
    borderColor: UnefaColors.blue,
    backgroundColor: 'rgba(4, 15, 217, 0.04)',
  },
  checkBox: {
    width: 22,
    height: 22,
    borderRadius: 6,
    borderWidth: 2,
    borderColor: '#cbd5e1',
    alignItems: 'center',
    justifyContent: 'center',
  },
  checkBoxChecked: {
    backgroundColor: UnefaColors.blue,
    borderColor: UnefaColors.blue,
  },
  checkMark: {
    color: '#ffffff',
    fontSize: 13,
    fontWeight: '900',
  },
  checkText: {
    flex: 1,
    fontSize: 12,
    lineHeight: 16,
    fontWeight: '500',
  },
  checkTextActive: {
    fontWeight: '700',
  },
  phasePill: {
    backgroundColor: '#f1f5f9',
    paddingHorizontal: 6,
    paddingVertical: 2,
    borderRadius: 6,
  },
  phaseText: {
    fontSize: 9,
    color: '#64748b',
    fontWeight: '700',
  },
  feedbackBox: {
    padding: 12,
    borderRadius: 12,
    marginBottom: 14,
  },
  feedbackNormal: {
    backgroundColor: 'rgba(4, 15, 217, 0.06)',
  },
  feedbackSuccess: {
    backgroundColor: UnefaColors.greenSoft,
  },
  feedbackText: {
    fontSize: 12,
    fontWeight: '600',
    textAlign: 'center',
  },
  feedbackNormalText: {
    color: UnefaColors.blue,
  },
  feedbackSuccessText: {
    color: UnefaColors.green,
    fontWeight: '800',
  },
  secureNote: {
    fontSize: 11,
    color: '#64748b',
    textAlign: 'center',
    marginTop: 10,
  },

  // Services
  serviceStack: {
    gap: 14,
  },
  serviceCard: {
    padding: 18,
    borderRadius: 18,
    borderWidth: 1,
    borderColor: '#e2e8f0',
  },
  serviceCardFeatured: {
    borderColor: UnefaColors.gold,
    borderWidth: 1.5,
  },
  serviceMeta: {
    flexDirection: 'row',
    gap: 8,
    marginBottom: 10,
  },
  goldPill: {
    backgroundColor: UnefaColors.goldSoft,
    paddingHorizontal: 8,
    paddingVertical: 3,
    borderRadius: 6,
  },
  goldPillText: {
    color: UnefaColors.goldDark,
    fontSize: 10,
    fontWeight: '800',
  },
  neutralPill: {
    backgroundColor: '#f1f5f9',
    paddingHorizontal: 8,
    paddingVertical: 3,
    borderRadius: 6,
  },
  neutralPillText: {
    color: '#64748b',
    fontSize: 10,
    fontWeight: '700',
  },
  serviceTitle: {
    fontSize: 18,
    fontWeight: '900',
    marginBottom: 6,
  },
  serviceDesc: {
    fontSize: 13,
    lineHeight: 18,
    marginBottom: 14,
  },

  // Footer
  footer: {
    paddingHorizontal: 16,
    paddingVertical: 32,
    borderTopWidth: 1,
  },
  footerLight: {
    backgroundColor: '#f8fafc',
    borderTopColor: '#e2e8f0',
  },
  footerDark: {
    backgroundColor: '#06152a',
    borderTopColor: 'rgba(255, 255, 255, 0.08)',
  },
  footerBrand: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 10,
    marginBottom: 12,
  },
  footerLogoWrap: {
    width: 32,
    height: 32,
    borderRadius: 6,
    backgroundColor: '#fff',
    borderWidth: 1,
    borderColor: '#e2e8f0',
    alignItems: 'center',
    justifyContent: 'center',
  },
  footerLogo: {
    width: 26,
    height: 26,
  },
  footerBrandText: {
    fontSize: 18,
    fontWeight: '900',
  },
  footerAbout: {
    fontSize: 12,
    lineHeight: 18,
    marginBottom: 20,
  },
  footerNavGrid: {
    flexDirection: 'row',
    gap: 24,
    marginBottom: 20,
  },
  footerNavCol: {
    flex: 1,
    gap: 6,
  },
  footerColHead: {
    fontSize: 13,
    fontWeight: '800',
    marginBottom: 4,
  },
  footerLink: {
    fontSize: 12,
    color: UnefaColors.blue,
    fontWeight: '600',
    paddingVertical: 2,
  },
  footerAddress: {
    paddingTop: 16,
    borderTopWidth: StyleSheet.hairlineWidth,
    borderTopColor: '#cbd5e1',
    marginBottom: 16,
  },
  footerAddrBold: {
    fontSize: 13,
    fontWeight: '800',
    marginBottom: 4,
  },
  footerAddrText: {
    fontSize: 11,
    lineHeight: 16,
  },
  footerBottom: {
    gap: 4,
  },
  copyright: {
    fontSize: 10,
    color: '#64748b',
  },
  proposalBadge: {
    fontSize: 10,
    color: UnefaColors.goldDark,
    fontWeight: '700',
  },

  // Common card themes
  cardLight: {
    backgroundColor: '#ffffff',
    borderColor: '#e2e8f0',
  },
  cardDark: {
    backgroundColor: '#0d1829',
    borderColor: 'rgba(255, 255, 255, 0.1)',
  },
  textLight: {
    color: '#f8fafc',
  },
  textDark: {
    color: '#0a0a0a',
  },
  subLight: {
    color: '#475569',
  },
  subDark: {
    color: '#cbd5e1',
  },
});

