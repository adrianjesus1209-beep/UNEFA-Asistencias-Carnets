import React, { useState, useRef } from 'react';
import {
  View,
  Text,
  ScrollView,
  Pressable,
  LayoutChangeEvent,
  type NativeScrollEvent,
  type NativeSyntheticEvent,
} from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';

import { Image } from 'expo-image';
import { cssInterop } from 'nativewind';
import { useRouter } from 'expo-router';

import { Header } from '@/components/Header';
import { BottomNav } from '@/components/BottomNav';
import { MenuDrawer } from '@/components/MenuDrawer';
import { QrModal } from '@/components/QrModal';
import {
  PILLARS_DATA,
  CAREERS_DATA,
  Career,
  Pillar,
} from '@/constants/data';

cssInterop(Image, { className: 'style' });

// Tipo para la referencia imperativa del componente ScrollView
type ScrollViewHandle = React.ElementRef<typeof ScrollView>;

/**
 * Pantalla principal y portal informativo de la aplicacion UNEFA.
 */
export default function LandingScreen() {
  const router = useRouter();
  const scrollRef = useRef<ScrollViewHandle>(null);

  // Control de visibilidad de modales y pestana activa
  const [menuOpen, setMenuOpen] = useState(false);
  const [qrOpen, setQrOpen] = useState(false);
  const [activeTab, setActiveTab] = useState<'inicio' | 'carreras' | 'registro' | 'siceu'>('inicio');

  // Posiciones verticales de cada seccion para desplazamiento suave
  const sectionPositions = useRef<{ [key: string]: number }>({});
  const sectionTabs: Record<string, 'inicio' | 'carreras' | 'registro' | 'siceu'> = {
    inicio: 'inicio',
    nosotros: 'inicio',
    carreras: 'carreras',
    registro: 'registro',
    servicios: 'siceu',
  };

  // Almacena la posicion vertical de una seccion al renderizarse
  const handleLayoutSection = (key: string, event: LayoutChangeEvent) => {
    sectionPositions.current[key] = event.nativeEvent.layout.y;
  };

  // Desplaza la pantalla hacia la seccion indicada
  const scrollToSection = (key: string) => {
    const nextTab = sectionTabs[key] ?? 'inicio';
    setActiveTab((currentTab) => (currentTab === nextTab ? currentTab : nextTab));
    const y = sectionPositions.current[key];
    if (y !== undefined && scrollRef.current) {
      scrollRef.current.scrollTo({ y: Math.max(0, y - 20), animated: true });
    }
  };

  // Sincroniza la pestana inferior con la seccion visible durante el desplazamiento
  const handleScroll = (event: NativeSyntheticEvent<NativeScrollEvent>) => {
    const scrollY = event.nativeEvent.contentOffset.y + 100;
    const visibleSections = Object.entries(sectionPositions.current)
      .filter(([, y]) => y <= scrollY)
      .sort(([, firstY], [, secondY]) => firstY - secondY);
    const activeSection = visibleSections[visibleSections.length - 1]?.[0];

    if (activeSection) {
      const nextTab = sectionTabs[activeSection] ?? 'inicio';
      setActiveTab((currentTab) => (currentTab === nextTab ? currentTab : nextTab));
    }
  };

  // Gestion del pilar doctrinal seleccionado
  const [selectedPillarKey, setSelectedPillarKey] = useState<string>('ingenieria');
  const activePillar: Pillar = PILLARS_DATA[selectedPillarKey] || PILLARS_DATA.ingenieria;

  // Gestion de facultad y carrera seleccionada
  const [selectedFaculty, setSelectedFaculty] = useState<string>('ingenieria');
  const careersInFaculty: Career[] = CAREERS_DATA[selectedFaculty] || [];
  const [selectedCareerId, setSelectedCareerId] = useState<string>(
    careersInFaculty[0]?.id || 'sistemas'
  );
  const activeCareer: Career =
    careersInFaculty.find((c) => c.id === selectedCareerId) ||
    careersInFaculty[0] ||
    CAREERS_DATA.ingenieria[0];

  return (
    <SafeAreaView className="flex-1 bg-white">
      <Header
        subtitle="Excelencia Educativa"
        onMenuPress={() => setMenuOpen(true)}
      />

      <ScrollView
        ref={scrollRef}
        className="flex-1"
        contentContainerClassName="items-center pb-5"
        onScroll={handleScroll}
        scrollEventThrottle={16}
        showsVerticalScrollIndicator={false}>
        <View className="w-full max-w-[480px]">
          {/* Seccion 01: Presentacion principal */}
          <View
            className="px-4 pt-5 pb-8 bg-white"
            onLayout={(event) => handleLayoutSection('inicio', event)}>
            <Text className="mb-2 text-[11px] font-extrabold uppercase tracking-[0.5px] text-unefa-blue">[01] — Institución politécnica cívico-militar</Text>
            <Text className="mb-3 text-[36px] leading-[40px] font-black tracking-[-0.5px] text-neutral-950">
              Vanguardia{'\n'}Técnica &{'\n'}
              <Text className="text-unefa-blue">Soberanía</Text>
            </Text>

            <Text className="mb-5 text-[15px] leading-[22px] text-slate-600">
              Formación politécnica rigurosa, investigación científica aplicada y valores
              cívico-militares con 100% de gratuidad de matrícula.
            </Text>

            <View className="mb-6 flex-row gap-2.5">
              <View className="flex-1 items-center rounded-[14px] bg-white p-3 shadow-sm bg-white border-slate-200">
                <Text className="text-[22px] font-black text-neutral-950">
                  100%
                </Text>
                <Text className="mt-0.5 text-[11px] font-semibold text-slate-500">Gratuidad</Text>
              </View>
              <View className="flex-1 items-center rounded-[14px] bg-white p-3 shadow-sm bg-white border-slate-200">
                <Text className="text-[22px] font-black text-neutral-950">
                  24
                </Text>
                <Text className="mt-0.5 text-[11px] font-semibold text-slate-500">Estados</Text>
              </View>
              <View className="flex-1 items-center rounded-[14px] bg-white p-3 shadow-sm bg-white border-slate-200">
                <Text className="text-[22px] font-black text-unefa-blue">Registro</Text>
                <Text className="mt-0.5 text-[11px] font-semibold text-slate-500">Cuenta</Text>
              </View>
            </View>

            <View className="mb-6 gap-2.5">
              <Pressable
                className="flex-row items-center justify-center gap-2 rounded-[14px] py-3.5 bg-unefa-gold shadow-md py-4"
                onPress={() => router.push('/registro')}>
                <Text className="text-[15px] font-black text-unefa-navy">Crear cuenta UNEFA</Text>
                <Text className="text-base font-black text-unefa-navy">→</Text>
              </Pressable>

              <Pressable
                className="flex-row items-center justify-center gap-2 rounded-[14px] py-3.5 border border-slate-300 bg-transparent"
                onPress={() => router.push('/login')}>
                <Text className="text-sm font-bold text-neutral-950">
                  Portal SICEU
                </Text>
              </Pressable>

              <Pressable
                className="items-center self-center py-1.5"
                onPress={() => scrollToSection('carreras')}>
                <Text className="text-[13px] font-bold text-slate-600">
                  Explorar carreras ↓
                </Text>
              </Pressable>
            </View>

            <View className="mb-5 overflow-hidden rounded-[18px] border border-slate-200">
              <Image
                source={{
                  uri: 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1200&q=80',
                }}
                className="h-[200px] w-full"
                contentFit="cover"
              />
              <View className="flex-row items-center justify-between p-3 bg-white">
                <View>
                  <Text className="text-[10px] font-extrabold tracking-[0.4px] text-neutral-950">
                    FIG. 01 — LABORATORIO POLITÉCNICO
                  </Text>
                  <Text className="text-[9px] font-semibold text-slate-500">
                    ROBÓTICA, AUTOMATIZACIÓN Y SISTEMAS APLICADOS
                  </Text>
                </View>
                <View className="h-[14px] w-[14px] rounded-full bg-unefa-blue" />
              </View>
            </View>

            <View className="flex-row gap-2.5">
              <View className="flex-1 flex-row items-center gap-2.5 rounded-[14px] p-3 bg-white border-slate-200">
                <Text className="text-xl text-unefa-blue">⚙</Text>
                <View>
                  <Text className="text-[13px] font-extrabold text-neutral-950">
                    Ingenierías
                  </Text>
                  <Text className="text-[10px] font-semibold text-slate-500">10 Semestres</Text>
                </View>
              </View>

              <View className="flex-1 flex-row items-center gap-2.5 rounded-[14px] p-3 bg-white border-slate-200">
                <Text className="text-xl text-unefa-blue text-unefa-gold">★</Text>
                <View>
                  <Text className="text-[13px] font-extrabold text-neutral-950">
                    Cívico-Militar
                  </Text>
                  <Text className="text-[10px] font-semibold text-slate-500">Doctrina Integral</Text>
                </View>
              </View>
            </View>
          </View>

          {/* Seccion 02: Doctrina y fundamentos unefistas */}
          <View
            className="px-4 py-8 border-y border-slate-200 bg-slate-50"
            onLayout={(event) => handleLayoutSection('nosotros', event)}>
            <View className="mb-5">
              <Text className="mb-1 text-[11px] font-extrabold uppercase tracking-[0.5px] text-unefa-blue">[02] — Doctrina &amp; fundamentos</Text>
              <Text className="mb-1.5 text-2xl font-black text-neutral-950">
                Pilares del modelo unefista
              </Text>
              <Text className="text-sm leading-5 text-slate-600">
                Una propuesta pedagógica única que une la disciplina del método científico
                con la mística y responsabilidad cívico-militar.
              </Text>
            </View>

            <ScrollView
              horizontal
              showsHorizontalScrollIndicator={false}
              contentContainerClassName="gap-2 pb-4">
              {Object.keys(PILLARS_DATA).map((key) => {
                const item = PILLARS_DATA[key];
                const isActive = selectedPillarKey === key;
                return (
                  <Pressable
                    key={key}
                    className={[
                      'min-w-[150px] rounded-xl border p-2.5 px-3.5',
                      'bg-white border-slate-200',
                      isActive && '!border-unefa-blue !bg-unefa-blue/[0.06]',
                    ].filter(Boolean).join(' ')}
                    onPress={() => setSelectedPillarKey(key)}>
                    <View className="mb-1 flex-row justify-between">
                      <Text className={['font-mono text-[11px] font-extrabold text-slate-500', isActive && '!text-unefa-blue'].filter(Boolean).join(' ')}>[{item.number}]</Text>
                      <Text className="text-[10px] font-semibold text-slate-500">{item.subtitle}</Text>
                    </View>
                    <Text
                      className={[
                        'text-[13px] font-bold',
                        'text-neutral-950',
                        isActive && '!text-unefa-blue',
                      ].filter(Boolean).join(' ')}>
                      {item.tabTitle}
                    </Text>
                  </Pressable>
                );
              })}
            </ScrollView>

            {/* Ficha informativa del pilar doctrinal */}
            <View className="mb-5 overflow-hidden rounded-[20px] border border-slate-200 shadow-md bg-white border-slate-200">
              <View className="relative h-[180px]">
                <Image
                  source={{ uri: activePillar.image }}
                  className="h-full w-full"
                  contentFit="cover"
                />
                <View className="absolute inset-x-0 bottom-0 px-3 py-1.5 bg-white">
                  <Text className="text-[9px] font-bold tracking-[0.3px] text-neutral-950">
                    {activePillar.caption}
                  </Text>
                </View>
              </View>

              <View className="p-4">
                <View className="mb-2.5 self-start rounded-lg bg-unefa-blue/10 px-2.5 py-1">
                  <Text className="text-[11px] font-extrabold text-unefa-blue">Área {activePillar.number}</Text>
                </View>
                <Text className="mb-2 text-xl font-black text-neutral-950">
                  {activePillar.title}
                </Text>
                <Text className="mb-4 text-[13px] leading-[19px] text-slate-600">
                  {activePillar.description}
                </Text>

                <View className="mb-4">
                  <Text className="mb-2 text-[11px] font-extrabold uppercase tracking-[0.4px] text-slate-500">Hitos de formación</Text>
                  {activePillar.highlights.map((h, i) => (
                    <View key={i} className="mb-1.5 flex-row items-start gap-2">
                      <Text className="text-sm font-extrabold text-unefa-blue">→</Text>
                      <Text className="flex-1 text-xs leading-[18px] font-medium text-neutral-950">
                        {h}
                      </Text>
                    </View>
                  ))}
                </View>
              </View>
            </View>

            <View className="items-center rounded-[14px] border p-4 bg-white border-slate-200">
              <Text className="mb-1 text-[10px] font-extrabold uppercase tracking-[0.4px] text-slate-500">Lema institucional</Text>
              <Text className="text-sm font-extrabold italic text-center text-neutral-950">
                {'“Excelencia Educativa Abierta al Pueblo”'}
              </Text>
            </View>
          </View>

          {/* Seccion 03: Oferta academica y carreras */}
          <View
            className="px-4 py-8 bg-white"
            onLayout={(event) => handleLayoutSection('carreras', event)}>
            <View className="mb-5 flex-row items-start justify-between">
              <View>
                <Text className="mb-1 text-[11px] font-extrabold uppercase tracking-[0.5px] text-unefa-blue">[03] — Oferta académica</Text>
                <Text className="mb-1.5 text-2xl font-black text-neutral-950">
                  Explorador de carreras
                </Text>
              </View>
              <Pressable onPress={() => router.push('/registro')}>
                <Text className="text-[13px] font-extrabold text-unefa-blue">Inscripción →</Text>
              </Pressable>
            </View>

            {/* Control segmentado por tipo de facultad */}
            <View className="mb-4 flex-row rounded-[14px] border p-1 bg-slate-100 border-slate-200">
              <Pressable
                className={['flex-1 items-center rounded-[10px] py-2', selectedFaculty === 'ingenieria' && '!bg-unefa-blue'].filter(Boolean).join(' ')}
                onPress={() => {
                  setSelectedFaculty('ingenieria');
                  setSelectedCareerId(CAREERS_DATA.ingenieria[0].id);
                }}>
                <Text
                  className={[
                    'text-xs font-extrabold',
                    selectedFaculty === 'ingenieria' && '!text-white',
                  ].filter(Boolean).join(' ')}>
                  Ingenierías
                </Text>
                <Text className="text-[9px] text-slate-500">10 sem.</Text>
              </Pressable>

              <Pressable
                className={['flex-1 items-center rounded-[10px] py-2', selectedFaculty === 'licenciaturas' && '!bg-unefa-blue'].filter(Boolean).join(' ')}
                onPress={() => {
                  setSelectedFaculty('licenciaturas');
                  setSelectedCareerId(CAREERS_DATA.licenciaturas[0].id);
                }}>
                <Text
                  className={[
                    'text-xs font-extrabold',
                    selectedFaculty === 'licenciaturas' && '!text-white',
                  ].filter(Boolean).join(' ')}>
                  Licenciaturas
                </Text>
                <Text className="text-[9px] text-slate-500">8 sem.</Text>
              </Pressable>

              <Pressable
                className={['flex-1 items-center rounded-[10px] py-2', selectedFaculty === 'tsu' && '!bg-unefa-blue'].filter(Boolean).join(' ')}
                onPress={() => {
                  setSelectedFaculty('tsu');
                  setSelectedCareerId(CAREERS_DATA.tsu[0].id);
                }}>
                <Text
                  className={[
                    'text-xs font-extrabold',
                    selectedFaculty === 'tsu' && '!text-white',
                  ].filter(Boolean).join(' ')}>
                  Técnico Superior
                </Text>
                <Text className="text-[9px] text-slate-500">6 sem.</Text>
              </Pressable>
            </View>

            {/* Listado de carreras disponibles */}
            <View className="mb-5 gap-2">
              {careersInFaculty.map((item) => {
                const isSelected = activeCareer.id === item.id;
                return (
                  <Pressable
                    key={item.id}
                    className={[
                      'rounded-[14px] border border-slate-200 p-3',
                      'bg-white border-slate-200',
                      isSelected && '!border-unefa-blue !bg-unefa-blue/[0.05]',
                    ].filter(Boolean).join(' ')}
                    onPress={() => setSelectedCareerId(item.id)}>
                    <View className="mb-0.5 flex-row justify-between">
                      <Text className={['font-mono text-[11px] font-extrabold text-slate-500', isSelected && '!text-unefa-blue'].filter(Boolean).join(' ')}>
                        {item.code}
                      </Text>
                      <Text className="text-[11px] font-semibold text-slate-500">{item.duration}</Text>
                    </View>
                    <Text
                      className={[
                        'text-sm font-extrabold',
                        'text-neutral-950',
                        isSelected && '!text-unefa-blue',
                      ].filter(Boolean).join(' ')}>
                      {item.title}
                    </Text>
                  </Pressable>
                );
              })}
            </View>

            {/* Ficha detallada de la carrera seleccionada */}
            <View className="mb-5 overflow-hidden rounded-[20px] border border-slate-200 shadow-md bg-white border-slate-200">
              <View className="relative h-[180px]">
                <Image
                  source={{ uri: activeCareer.image }}
                  className="h-full w-full"
                  contentFit="cover"
                />
                <View className="absolute left-2.5 top-2.5 rounded-md bg-unefa-navy px-2 py-1">
                  <Text className="font-mono text-[10px] font-extrabold text-white">{activeCareer.code}</Text>
                </View>
                <View className="absolute inset-x-0 bottom-0 flex-row justify-between bg-unefa-navy/[0.85] px-3 py-1.5">
                  <Text className="text-[11px] font-bold text-white">{activeCareer.degree}</Text>
                  <Text className="text-[11px] font-extrabold text-unefa-gold">{activeCareer.duration}</Text>
                </View>
              </View>

              <View className="p-4">
                <Text className="mb-2 text-xl font-black text-neutral-950">
                  {activeCareer.title}
                </Text>
                <Text className="mb-4 text-[13px] leading-[19px] text-slate-600">
                  {activeCareer.description}
                </Text>

                <View className="mb-4">
                  <Text className="mb-2 text-[11px] font-extrabold uppercase tracking-[0.4px] text-slate-500">Competencias principales</Text>
                  {activeCareer.competencies.map((c, i) => (
                    <View key={i} className="mb-1.5 flex-row items-start gap-2">
                      <Text className="text-[11px] text-unefa-gold">■</Text>
                      <Text className="flex-1 text-xs leading-[18px] font-medium text-neutral-950">
                        {c}
                      </Text>
                    </View>
                  ))}
                </View>

                <View className="mb-4">
                  <Text className="mb-2 text-[11px] font-extrabold uppercase tracking-[0.4px] text-slate-500">Materias troncales</Text>
                  <View className="flex-row flex-wrap gap-1.5">
                    {activeCareer.subjects.map((sub, i) => (
                      <View
                        key={i}
                        className="rounded-[20px] border px-2.5 py-[5px] bg-slate-100 border-slate-200">
                        <Text className="text-[11px] font-semibold text-neutral-950">
                          {sub}
                        </Text>
                      </View>
                    ))}
                  </View>
                </View>

                <View className="mt-2 gap-2">
                  <Text className="font-mono text-[10px] text-center text-slate-500">
                    Modalidad presencial · Núcleo Central y sedes regionales
                  </Text>
                  <Pressable
                    className="flex-row items-center justify-center gap-2 rounded-[14px] py-3.5 bg-unefa-gold shadow-md"
                    onPress={() => router.push('/registro')}>
                    <Text className="text-[15px] font-black text-unefa-navy">Postularme en esta carrera</Text>
                    <Text className="text-base font-black text-unefa-navy">→</Text>
                  </Pressable>
                </View>
              </View>
            </View>
          </View>

          {/* Seccion 04: registro convencional de cuenta */}
          <View
            className="px-4 py-8 border-y border-slate-200 bg-slate-50"
            onLayout={(event) => handleLayoutSection('registro', event)}>
            <View className="mb-5">
              <Text className="mb-1 text-[11px] font-extrabold uppercase tracking-[0.5px] text-unefa-blue">
                [04] — Cuenta universitaria
              </Text>
              <Text className="mb-1.5 text-2xl font-black text-neutral-950">
                Regístrate para comenzar
              </Text>
              <Text className="text-sm leading-5 text-slate-600">
                Crea una cuenta con tus datos personales y un correo electrónico activo para acceder a los servicios digitales UNEFA.
              </Text>
            </View>

            <View className="mb-5 gap-3">
              {[
                {
                  num: '01',
                  title: 'Completa tus datos',
                  desc: 'Indica tu nombre, documento de identidad y correo electrónico.',
                },
                {
                  num: '02',
                  title: 'Protege tu cuenta',
                  desc: 'Elige una contraseña segura y confírmala antes de enviar el formulario.',
                },
                {
                  num: '03',
                  title: 'Accede a los servicios',
                  desc: 'Usa el portal institucional para continuar con los trámites disponibles.',
                },
              ].map((step) => (
                <View key={step.num} className="flex-row gap-3">
                  <View className="h-8 w-8 items-center justify-center rounded-full bg-[rgba(242,184,7,0.16)]">
                    <Text className="font-mono text-[13px] font-black text-[#c99106]">
                      {step.num}
                    </Text>
                  </View>
                  <View className="flex-1">
                    <Text className="mb-0.5 text-sm font-extrabold text-neutral-950">
                      {step.title}
                    </Text>
                    <Text className="text-xs leading-[17px] text-slate-600">
                      {step.desc}
                    </Text>
                  </View>
                </View>
              ))}
            </View>

            <View className="rounded-[20px] border border-slate-200 bg-white p-5">
              <Text className="mb-1 text-lg font-black text-neutral-950">
                ¿Listo para crear tu cuenta?
              </Text>
              <Text className="mb-4 text-[13px] leading-5 text-slate-600">
                Ten a mano tu documento de identidad y verifica que puedas acceder a tu correo.
              </Text>
              <Pressable
                className="flex-row items-center justify-center gap-2 rounded-[14px] bg-unefa-gold py-3.5 shadow-md"
                onPress={() => router.push('/registro')}>
                <Text className="text-[15px] font-black text-unefa-navy">Crear cuenta UNEFA</Text>
                <Text className="text-base font-black text-unefa-navy">→</Text>
              </Pressable>
            </View>
          </View>

          {/* Seccion 05: Plataformas y servicios digitales */}
          <View
            className="px-4 py-8 bg-white"
            onLayout={(event) => handleLayoutSection('servicios', event)}>
            <View className="mb-5 flex-row items-start justify-between">
              <View>
                <Text className="mb-1 text-[11px] font-extrabold uppercase tracking-[0.5px] text-unefa-blue">[05] — Plataformas &amp; servicios</Text>
                <Text className="mb-1.5 text-2xl font-black text-neutral-950">
                  Servicios digitales
                </Text>
              </View>
              <Pressable onPress={() => router.push('/login')}>
                <Text className="text-[13px] font-extrabold text-unefa-blue">Ingreso →</Text>
              </Pressable>
            </View>

            <View className="gap-3.5">
              {/* Servicio 01: Portal SICEU */}
              <View
                className="rounded-[18px] border border-slate-200 p-[18px] border-[1.5px] border-unefa-gold bg-white border-slate-200">
                <View className="mb-2.5 flex-row gap-2">
                  <View className="rounded-md bg-[rgba(242,184,7,0.16)] px-2 py--[3px]">
                    <Text className="text-[10px] font-extrabold text-[#c99106]">SVC-01</Text>
                  </View>
                  <View className="rounded-md bg-slate-100 px-2 py-[3px]">
                    <Text className="text-[10px] font-bold text-slate-500">Sistema central</Text>
                  </View>
                </View>
                <Text className="mb-1.5 text-lg font-black text-neutral-950">
                  Portal SICEU
                </Text>
                <Text className="mb-3.5 text-[13px] leading-[18px] text-slate-600">
                  Consulta de calificaciones, récord académico, inscripción de asignaturas,
                  control de asistencia y aulas asignadas.
                </Text>
                <Pressable
                  className="flex-row items-center justify-center gap-2 rounded-[14px] py-3.5 bg-unefa-gold shadow-md"
                  onPress={() => router.push('/login')}>
                  <Text className="text-[15px] font-black text-unefa-navy">Acceder a SICEU</Text>
                </Pressable>
              </View>

              {/* Servicio 02: Calendario academico */}
              <View className="rounded-[18px] border border-slate-200 p-[18px] bg-white border-slate-200">
                <View className="mb-2.5 flex-row gap-2">
                  <View className="rounded-md bg-slate-100 px-2 py-[3px]">
                    <Text className="text-[10px] font-bold text-slate-500">SVC-02</Text>
                  </View>
                  <View className="rounded-md bg-slate-100 px-2 py-[3px]">
                    <Text className="text-[10px] font-bold text-slate-500">Semestre 2026-I</Text>
                  </View>
                </View>
                <Text className="mb-1.5 text-lg font-black text-neutral-950">
                  Calendario oficial
                </Text>
                <Text className="mb-3.5 text-[13px] leading-[18px] text-slate-600">
                  Fechas de inicio de clases, cortes de notas parciales, solicitudes de retiro o
                  adición y actos solemnes de grado.
                </Text>
                <Pressable
                  className="flex-row items-center justify-center gap-2 rounded-[14px] py-3.5 border border-slate-300 bg-transparent"
                  onPress={() => scrollToSection('inicio')}>
                  <Text
                    className="text-sm font-bold text-neutral-950">
                    Consultar fechas
                  </Text>
                </Pressable>
              </View>

              {/* Servicio 03: Tramites y constancias */}
              <View className="rounded-[18px] border border-slate-200 p-[18px] bg-white border-slate-200">
                <View className="mb-2.5 flex-row gap-2">
                  <View className="rounded-md bg-slate-100 px-2 py-[3px]">
                    <Text className="text-[10px] font-bold text-slate-500">SVC-03</Text>
                  </View>
                  <View className="rounded-md bg-slate-100 px-2 py-[3px]">
                    <Text className="text-[10px] font-bold text-slate-500">Trámites</Text>
                  </View>
                </View>
                <Text className="mb-1.5 text-lg font-black text-neutral-950">
                  Constancias en línea
                </Text>
                <Text className="mb-3.5 text-[13px] leading-[18px] text-slate-600">
                  Generación automatizada de constancias de estudio, notas certificadas y cartas de
                  culminación con firma digital.
                </Text>
                <Pressable
                  className="flex-row items-center justify-center gap-2 rounded-[14px] py-3.5 border border-slate-300 bg-transparent"
                  onPress={() => router.push('/login')}>
                  <Text
                    className="text-sm font-bold text-neutral-950">
                    Gestión digital
                  </Text>
                </Pressable>
              </View>

              {/* Servicio 04: Repositorio institucional */}
              <View className="rounded-[18px] border border-slate-200 p-[18px] bg-white border-slate-200">
                <View className="mb-2.5 flex-row gap-2">
                  <View className="rounded-md bg-slate-100 px-2 py-[3px]">
                    <Text className="text-[10px] font-bold text-slate-500">SVC-04</Text>
                  </View>
                  <View className="rounded-md bg-slate-100 px-2 py-[3px]">
                    <Text className="text-[10px] font-bold text-slate-500">Ciencia</Text>
                  </View>
                </View>
                <Text className="mb-1.5 text-lg font-black text-neutral-950">
                  Repositorio y tesis
                </Text>
                <Text className="mb-3.5 text-[13px] leading-[18px] text-slate-600">
                  Acceso público y digital a trabajos especiales de grado, guías metodológicas de
                  ingeniería y revistas de investigación.
                </Text>
                <Pressable
                  className="flex-row items-center justify-center gap-2 rounded-[14px] py-3.5 border border-slate-300 bg-transparent"
                  onPress={() => scrollToSection('carreras')}>
                  <Text
                    className="text-sm font-bold text-neutral-950">
                    Abrir repositorio
                  </Text>
                </Pressable>
              </View>
            </View>
          </View>

          {/* Pie de pagina con enlaces e informacion institucional */}
          <View className="border-t px-4 py-8 border-t-slate-200 bg-slate-50">
            <View className="mb-3 flex-row items-center gap-2.5">
              <View className="h-8 w-8 items-center justify-center rounded-md border border-slate-200 bg-white">
                <Image
                  source={require('@/assets/images/unefa-logo.png')}
                  className="h-[26px] w-[26px]"
                  contentFit="contain"
                />
              </View>
              <Text className="text-lg font-black text-neutral-950">
                UNEFA
              </Text>
            </View>

            <Text className="mb-5 text-xs leading-[18px] text-slate-600">
              Universidad Nacional Experimental Politécnica de la Fuerza Armada Nacional
              Bolivariana. Institución pública formadora de profesionales con excelencia técnica,
              disciplina y compromiso patriótico.
            </Text>

            <View className="mb-5 flex-row gap-6">
              <View className="flex-1 gap-1.5">
                <Text className="mb-1 text-[13px] font-extrabold text-neutral-950">
                  Navegación
                </Text>
                <Pressable onPress={() => scrollToSection('inicio')}>
                  <Text className="py-0.5 text-xs font-semibold text-unefa-blue">Página principal</Text>
                </Pressable>
                <Pressable onPress={() => scrollToSection('nosotros')}>
                  <Text className="py-0.5 text-xs font-semibold text-unefa-blue">Doctrina</Text>
                </Pressable>
                <Pressable onPress={() => scrollToSection('carreras')}>
                  <Text className="py-0.5 text-xs font-semibold text-unefa-blue">Catálogo carreras</Text>
                </Pressable>
                <Pressable onPress={() => scrollToSection('registro')}>
                  <Text className="py-0.5 text-xs font-semibold text-unefa-blue">Registro de cuenta</Text>
                </Pressable>
              </View>

              <View className="flex-1 gap-1.5">
                <Text className="mb-1 text-[13px] font-extrabold text-neutral-950">
                  Plataformas
                </Text>
                <Pressable onPress={() => router.push('/login')}>
                  <Text className="py-0.5 text-xs font-semibold text-unefa-blue">SICEU estudiantes</Text>
                </Pressable>
                <Pressable onPress={() => router.push('/login')}>
                  <Text className="py-0.5 text-xs font-semibold text-unefa-blue">SICEU docentes</Text>
                </Pressable>
                <Pressable onPress={() => router.push('/registro')}>
                  <Text className="py-0.5 text-xs font-semibold text-unefa-blue">Crear cuenta UNEFA</Text>
                </Pressable>
                <Pressable onPress={() => scrollToSection('servicios')}>
                  <Text className="py-0.5 text-xs font-semibold text-unefa-blue">Biblioteca digital</Text>
                </Pressable>
              </View>
            </View>

            <View className="mb-4 border-t border-slate-300 pt-4">
              <Text className="mb-1 text-[13px] font-extrabold text-neutral-950">
                Sede Central
              </Text>
              <Text className="text-[11px] leading-4 text-slate-600">
                Edificio Sede UNEFA, Chuao.{'\n'}
                Caracas, República Bolivariana de Venezuela.{'\n'}
                Teléfono: +58 (0212) 908-2000
              </Text>
            </View>

            <View className="gap-1">
              <Text className="text-[10px] text-slate-500">© 2026 UNEFA — Todos los derechos reservados.</Text>
              <Text className="text-[10px] font-bold text-[#c99106]">Propuesta de interfaz móvil · 2026</Text>
            </View>
          </View>
        </View>
      </ScrollView>

      {/* Barra de navegacion inferior */}
      <BottomNav
        activeTab={activeTab}
        onPressInicio={() => scrollToSection('inicio')}
        onPressCarreras={() => scrollToSection('carreras')}
        onOpenQr={() => setQrOpen(true)}
      />

      {/* Modales de navegacion y codigo QR */}
      <MenuDrawer
        visible={menuOpen}
        onClose={() => setMenuOpen(false)}
        onNavigateSection={(sec) => scrollToSection(sec)}
      />
      <QrModal visible={qrOpen} onClose={() => setQrOpen(false)} />
    </SafeAreaView>
  );
}
