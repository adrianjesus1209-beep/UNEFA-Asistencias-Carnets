import React, { useState } from 'react';
import {
  View,
  Text,
  ScrollView,
  TextInput,
  Pressable,
  ActivityIndicator,
  StyleSheet,
} from 'react-native';
import { Image } from 'expo-image';
import { useRouter } from 'expo-router';
import {
  GraduationCap,
  BookOpen,
  ClipboardCheck,
  ShieldCheck,
  Sparkles,
} from 'lucide-react-native';
import { UnefaColors, MaxContentWidth } from '@/constants/theme';
import { Header } from '@/components/Header';
import { BottomNav } from '@/components/BottomNav';
import { QrModal } from '@/components/QrModal';
import { SafeAreaView } from 'react-native-safe-area-context';

export default function LoginScreen() {
  const router = useRouter();

  // Form state
  const [nacionalidad, setNacionalidad] = useState<'V' | 'E'>('V');
  const [cedula, setCedula] = useState('');
  const [password, setPassword] = useState('');
  const [showPassword, setShowPassword] = useState(false);
  const [showForgotNote, setShowForgotNote] = useState(false);

  // Status feedback
  const [errorMsg, setErrorMsg] = useState('');
  const [successMsg, setSuccessMsg] = useState('');
  const [isLoading, setIsLoading] = useState(false);
  const [qrOpen, setQrOpen] = useState(false);

  const handleSubmit = () => {
    setErrorMsg('');
    setSuccessMsg('');

    if (!cedula.trim() || !password.trim()) {
      setErrorMsg('Ingresa tu número de cédula y tu contraseña institucional.');
      return;
    }

    if (!/^\d+$/.test(cedula.trim())) {
      setErrorMsg('El documento de identidad debe contener solo números.');
      return;
    }

    setIsLoading(true);

    setTimeout(() => {
      setIsLoading(false);
      setSuccessMsg(
        `Acceso verificado para ${nacionalidad}-${cedula.trim()}. Redirigiendo a SICEU...`
      );
      setTimeout(() => {
        router.push({ pathname: '/dashboard' as any, params: { role: 'estudiante' } });
      }, 500);
    }, 800);
  };

  const handleSimulatedLogin = (role: 'estudiante' | 'profesor' | 'coordinador' | 'director') => {
    router.push({ pathname: '/dashboard' as any, params: { role } });
  };

  return (
    <SafeAreaView className="flex-1 bg-white">
      <Header subtitle="SICEU en línea" showBack={true} />

      <ScrollView
        className="flex-1"
        contentContainerClassName="items-center pb-10"
        showsVerticalScrollIndicator={false}
        keyboardShouldPersistTaps="handled">
        <View className="w-full max-w-[480px] px-4 pt-4">
          {/* Institutional banner */}
          <View className="mb-4 rounded-[18px] border border-unefa-blue bg-unefa-blueDeep p-[18px]">
            <View className="flex-row items-center justify-between">
              <View className="flex-row items-center gap-3">
                <View className="h-[42px] w-[42px] items-center justify-center rounded-[13px] bg-white">
                  <Image
                    source={require('@/assets/images/unefa-logo.png')}
                    style={{ width: 34, height: 34 }}
                    contentFit="contain"
                    accessibilityLabel="Logo de la UNEFA"
                  />
                </View>
                <View>
                  <Text className="mb-[3px] text-[10px] font-semibold tracking-[1px] text-white/75">
                    PORTAL ACADÉMICO
                  </Text>
                  <Text className="text-[17px] font-black text-white">
                    SICEU en línea
                  </Text>
                </View>
              </View>
              <View className="rounded-full bg-unefa-gold px-2.5 py-1.5">
                <Text className="text-[11px] font-black text-unefa-navy">
                  2026-I
                </Text>
              </View>
            </View>
            <Text className="mt-3.5 text-xs leading-[18px] text-white/80">
              Acceso seguro para estudiantes y personal UNEFA.
            </Text>
          </View>

          {/* Auth Main Card */}
          <View className="mb-5 rounded-[22px] border border-slate-200 bg-white p-5 shadow-lg">
            <View className="mb-5">
              <View className="mb-3 flex-row gap-2">
                <View className="rounded-lg bg-[rgba(4,15,217,0.1)] px-2.5 py-1">
                  <Text className="text-[11px] font-extrabold text-unefa-blue">
                    SICEU / Acceso
                  </Text>
                </View>
                <View className="rounded-lg border border-slate-200 bg-slate-100 px-2.5 py-1">
                  <Text className="text-[11px] font-bold text-slate-600">
                    Periodo 2026-I
                  </Text>
                </View>
              </View>

              <Text className="mb-1.5 text-[26px] font-black text-neutral-950">
                Iniciar sesión
              </Text>
              <Text className="text-[13px] leading-[18px] text-slate-600">
                Ingresa con tu documento de identidad y clave institucional.
              </Text>
            </View>

            {/* Simulación Evaluativa de Entidades */}
            <View style={styles.simCard}>
              <View style={styles.simHeader}>
                <View style={styles.simBadge}>
                  <Sparkles size={11} color={UnefaColors.navy} />
                  <Text style={styles.simBadgeText}>EVALUACIÓN DE ENTIDADES</Text>
                </View>
                <Text style={styles.simTitle}>Simular acceso por rol</Text>
                <Text style={styles.simSub}>
                  Ingresa directamente al dashboard de cada entidad sin requerir backend:
                </Text>
              </View>

              <View style={styles.simGrid}>
                {/* 1. Estudiante */}
                <Pressable
                  style={[styles.simBtn, styles.simBtnEstudiante]}
                  onPress={() => handleSimulatedLogin('estudiante')}
                  accessibilityRole="button"
                  accessibilityLabel="Ingresar como Estudiante">
                  <View style={[styles.simIconBox, { backgroundColor: 'rgba(4, 15, 217, 0.1)' }]}>
                    <GraduationCap size={18} color={UnefaColors.blue} />
                  </View>
                  <View style={styles.simTextBox}>
                    <Text style={[styles.simRoleName, { color: UnefaColors.blue }]}>Estudiante</Text>
                    <Text style={styles.simRoleSub}>C.I. 28.123.456 · 7mo Semestre</Text>
                  </View>
                  
                </Pressable>

                {/* 2. Profesor */}
                <Pressable
                  style={[styles.simBtn, styles.simBtnProfesor]}
                  onPress={() => handleSimulatedLogin('profesor')}
                  accessibilityRole="button"
                  accessibilityLabel="Ingresar como Profesor">
                  <View style={[styles.simIconBox, { backgroundColor: 'rgba(13, 148, 136, 0.12)' }]}>
                    <BookOpen size={18} color="#0d9488" />
                  </View>
                  <View style={styles.simTextBox}>
                    <Text style={[styles.simRoleName, { color: '#0d9488' }]}>Profesor</Text>
                    <Text style={styles.simRoleSub}>C.I. 14.567.890 · Docente Ordinario</Text>
                  </View>
                  
                </Pressable>

                {/* 3. Coordinador */}
                <Pressable
                  style={[styles.simBtn, styles.simBtnCoordinador]}
                  onPress={() => handleSimulatedLogin('coordinador')}
                  accessibilityRole="button"
                  accessibilityLabel="Ingresar como Coordinador">
                  <View style={[styles.simIconBox, { backgroundColor: 'rgba(180, 83, 9, 0.12)' }]}>
                    <ClipboardCheck size={18} color="#b45309" />
                  </View>
                  <View style={styles.simTextBox}>
                    <Text style={[styles.simRoleName, { color: '#b45309' }]}>Coordinador</Text>
                    <Text style={styles.simRoleSub}>C.I. 11.234.567 · Coord. Carrera</Text>
                  </View>
                  
                </Pressable>

                {/* 4. Director */}
                <Pressable
                  style={[styles.simBtn, styles.simBtnDirector]}
                  onPress={() => handleSimulatedLogin('director')}
                  accessibilityRole="button"
                  accessibilityLabel="Ingresar como Director">
                  <View style={[styles.simIconBox, { backgroundColor: 'rgba(6, 21, 42, 0.12)' }]}>
                    <ShieldCheck size={18} color={UnefaColors.navy} />
                  </View>
                  <View style={styles.simTextBox}>
                    <Text style={[styles.simRoleName, { color: UnefaColors.navy }]}>Director</Text>
                    <Text style={styles.simRoleSub}>Cnel. Roberto Silva · Dir. Núcleo</Text>
                  </View>
                  
                </Pressable>
              </View>
            </View>

            {/* Separador */}
            <View style={styles.dividerRow}>
              <View style={styles.dividerLine} />
              <Text style={styles.dividerText}>O INGRESO CON CREDENCIALES</Text>
              <View style={styles.dividerLine} />
            </View>

            {/* Error alert */}
            {errorMsg ? (
              <View className="mb-4 rounded-xl border border-red-300 bg-red-100 p-3">
                <Text className="text-[13px] font-bold text-unefa-red">
                  ⚠️ {errorMsg}
                </Text>
              </View>
            ) : null}

            {/* Success alert */}
            {successMsg ? (
              <View className="mb-4 rounded-xl border border-green-300 bg-green-100 p-3">
                <Text className="text-[13px] font-bold leading-[18px] text-unefa-green">
                  ✓ {successMsg}
                </Text>
              </View>
            ) : null}

            {/* Field: Documento de identidad */}
            <View className="mb-[18px]">
              <Text className="mb-1.5 text-[13px] font-bold text-neutral-950">
                Documento de identidad
              </Text>
              <View className="flex-row gap-2">
                {/* V / E Selector */}
                <View className="flex-row rounded-xl bg-slate-100 p-[3px]">
                  <Pressable
                    className={`items-center justify-center rounded-[10px] px-3 py-2.5 ${
                      nacionalidad === 'V' ? 'bg-unefa-blue' : ''
                    }`}
                    onPress={() => setNacionalidad('V')}>
                    <Text
                      className={`text-[13px] font-extrabold ${
                        nacionalidad === 'V'
                          ? 'text-white'
                          : 'text-slate-500'
                      }`}>
                      V-
                    </Text>
                  </Pressable>
                  <Pressable
                    className={`items-center justify-center rounded-[10px] px-3 py-2.5 ${
                      nacionalidad === 'E' ? 'bg-unefa-blue' : ''
                    }`}
                    onPress={() => setNacionalidad('E')}>
                    <Text
                      className={`text-[13px] font-extrabold ${
                        nacionalidad === 'E'
                          ? 'text-white'
                          : 'text-slate-500'
                      }`}>
                      E-
                    </Text>
                  </Pressable>
                </View>

                {/* Cédula Input */}
                <TextInput
                  className="h-12 flex-1 rounded-xl border border-slate-300 bg-slate-50 px-3.5 text-sm text-neutral-950"
                  value={cedula}
                  onChangeText={(val) => {
                    setCedula(val.replace(/\D/g, ''));
                    setErrorMsg('');
                  }}
                  keyboardType="numeric"
                  maxLength={12}
                  returnKeyType="next"
                  accessibilityLabel="Número de cédula"
                  placeholder="Ej. 28123456"
                  placeholderTextColor="#94a3b8"
                />
              </View>
            </View>

            {/* Field: Contraseña */}
            <View className="mb-[18px]">
              <View className="mb-1.5 flex-row items-center justify-between">
                <Text className="text-[13px] font-bold text-neutral-950">
                  Contraseña institucional
                </Text>
                <Pressable onPress={() => setShowForgotNote((prev) => !prev)}>
                  <Text className="text-xs font-bold text-unefa-blue">
                    ¿La olvidaste?
                  </Text>
                </Pressable>
              </View>

              <View className="relative justify-center">
                <TextInput
                  className="h-12 rounded-xl border border-slate-300 bg-slate-50 px-3.5 text-sm text-neutral-950"
                  value={password}
                  onChangeText={(val) => {
                    setPassword(val);
                    setErrorMsg('');
                  }}
                  secureTextEntry={!showPassword}
                  returnKeyType="go"
                  accessibilityLabel="Contraseña institucional"
                  placeholder="••••••••••••"
                  placeholderTextColor="#94a3b8"
                />
                <Pressable
                  className="absolute right-3 px-2 py-1"
                  onPress={() => setShowPassword((prev) => !prev)}
                  accessibilityRole="button"
                  accessibilityLabel={
                    showPassword ? 'Ocultar contraseña' : 'Mostrar contraseña'
                  }>
                  <Text className="text-xs font-bold text-unefa-blue">
                    {showPassword ? 'Ocultar' : 'Mostrar'}
                  </Text>
                </Pressable>
              </View>

              {showForgotNote && (
                <Text className="mt-1.5 text-[11px] italic leading-4 text-unefa-goldDark">
                  Contacta al departamento de Control de Estudios de tu núcleo
                  para el restablecimiento de la clave institucional.
                </Text>
              )}
            </View>

            {/* Submit Button */}
            <Pressable
              className="mt-1.5 flex-row items-center justify-center gap-2 rounded-[14px] bg-unefa-gold py-4 shadow-md"
              onPress={handleSubmit}
              disabled={isLoading}
              accessibilityRole="button"
              accessibilityLabel="Acceder al SICEU">
              {isLoading ? (
                <ActivityIndicator color={UnefaColors.navy} size="small" />
              ) : (
                <>
                  <Text className="text-[15px] font-black text-unefa-navy">
                    Acceder al SICEU
                  </Text>
                  <Text className="text-base font-black text-unefa-navy">
                    →
                  </Text>
                </>
              )}
            </Pressable>

            {/* Auth Switch */}
            <View className="mt-6 gap-2.5 border-t border-slate-300 pt-4">
              <Text className="text-center text-xs font-semibold text-slate-600">
                ¿Eres aspirante de nuevo ingreso?
              </Text>
              <Pressable
                className="flex-row items-center justify-center rounded-[14px] border border-slate-300 py-3.5"
                onPress={() => router.push('/registro')}>
                <Text className="text-[13px] font-bold text-neutral-950">
                  Preinscripción al CINU 2026-I
                </Text>
              </Pressable>
            </View>

            <Text className="mt-5 text-center text-[11px] leading-4 text-slate-500">
              Conexión segura con el servidor de la UNEFA.{'\n'}
              Uso exclusivo para la comunidad universitaria autorizada.
            </Text>
          </View>

          {/* Aside Help */}
          <View className="rounded-[18px] border border-slate-200 bg-white p-[18px]">
            <Text className="mb-1.5 text-xs font-extrabold text-unefa-blue">
              ¿Necesitas ayuda?
            </Text>
            <Text className="mb-2.5 text-xs leading-[18px] text-slate-600">
              Si no recuerdas tu clave o tu usuario no está activo, acude a la
              Unidad de Control de Estudios de tu núcleo.
            </Text>
            <Pressable onPress={() => router.push('/landing')}>
              <Text className="text-[13px] font-extrabold text-unefa-blue">
                Volver a la landing →
              </Text>
            </Pressable>
          </View>
        </View>
      </ScrollView>
      {/* La barra y el modal QR se mantienen disponibles desde SICEU. */}
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
  rootDark: {
    backgroundColor: '#0a0e17',
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

  // Banner
  banner: {
    padding: 18,
    borderRadius: 18,
    marginBottom: 16,
    borderWidth: 1,
    backgroundColor: UnefaColors.blueDeep,
    borderColor: UnefaColors.blue,
  },
  bannerTopRow: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
  },
  bannerBrand: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 12,
  },
  bannerMark: {
    width: 42,
    height: 42,
    borderRadius: 13,
    alignItems: 'center',
    justifyContent: 'center',
    backgroundColor: '#ffffff',
  },
  bannerLogo: {
    width: 34,
    height: 34,
  },
  bannerSub: {
    color: 'rgba(255, 255, 255, 0.75)',
    fontSize: 10,
    fontWeight: '600',
    letterSpacing: 1,
    marginBottom: 3,
  },
  bannerTitle: {
    color: '#ffffff',
    fontSize: 17,
    fontWeight: '900',
  },
  periodBadge: {
    borderRadius: 20,
    backgroundColor: UnefaColors.gold,
    paddingHorizontal: 10,
    paddingVertical: 6,
  },
  periodBadgeText: {
    color: UnefaColors.navy,
    fontSize: 11,
    fontWeight: '900',
  },
  bannerCaption: {
    color: 'rgba(255, 255, 255, 0.82)',
    fontSize: 12,
    lineHeight: 18,
    marginTop: 14,
  },

  // Auth Card
  authCard: {
    borderRadius: 22,
    padding: 20,
    borderWidth: 1,
    shadowColor: '#06152a',
    shadowOffset: { width: 0, height: 10 },
    shadowOpacity: 0.1,
    shadowRadius: 20,
    elevation: 4,
    marginBottom: 20,
  },
  cardHead: {
    marginBottom: 20,
  },
  badgeRow: {
    flexDirection: 'row',
    gap: 8,
    marginBottom: 12,
  },
  badgeBlue: {
    backgroundColor: 'rgba(4, 15, 217, 0.1)',
    paddingHorizontal: 10,
    paddingVertical: 4,
    borderRadius: 8,
  },
  badgeBlueText: {
    color: UnefaColors.blue,
    fontSize: 11,
    fontWeight: '800',
  },
  badgeNeutral: {
    paddingHorizontal: 10,
    paddingVertical: 4,
    borderRadius: 8,
    borderWidth: 1,
  },
  badgeLight: {
    backgroundColor: '#f1f5f9',
    borderColor: '#e2e8f0',
  },
  badgeDark: {
    backgroundColor: '#13233c',
    borderColor: 'rgba(255, 255, 255, 0.1)',
  },
  badgeNeutralText: {
    fontSize: 11,
    fontWeight: '700',
  },
  authTitle: {
    fontSize: 26,
    fontWeight: '900',
    marginBottom: 6,
  },
  authSub: {
    fontSize: 13,
    lineHeight: 18,
  },

  // Alerts
  alertError: {
    backgroundColor: '#fee2e2',
    borderColor: '#fca5a5',
    borderWidth: 1,
    padding: 12,
    borderRadius: 12,
    marginBottom: 16,
  },
  alertErrorText: {
    color: UnefaColors.red,
    fontSize: 13,
    fontWeight: '700',
  },
  alertSuccess: {
    backgroundColor: '#dcfce7',
    borderColor: '#86efac',
    borderWidth: 1,
    padding: 12,
    borderRadius: 12,
    marginBottom: 16,
  },
  alertSuccessText: {
    color: UnefaColors.green,
    fontSize: 13,
    fontWeight: '700',
    lineHeight: 18,
  },

  // Fields
  field: {
    marginBottom: 18,
  },
  label: {
    fontSize: 13,
    fontWeight: '700',
    marginBottom: 6,
  },
  fieldLabelRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: 6,
  },
  inlineLink: {
    fontSize: 12,
    color: UnefaColors.blue,
    fontWeight: '700',
  },
  cedulaGroup: {
    flexDirection: 'row',
    gap: 8,
  },
  nationalityToggle: {
    flexDirection: 'row',
    borderRadius: 12,
    backgroundColor: '#f1f5f9',
    padding: 3,
  },
  natBtn: {
    paddingHorizontal: 12,
    paddingVertical: 10,
    borderRadius: 10,
    justifyContent: 'center',
    alignItems: 'center',
  },
  natBtnDark: {
    backgroundColor: '#13233c',
  },
  natBtnActive: {
    backgroundColor: UnefaColors.blue,
  },
  natBtnText: {
    fontSize: 13,
    fontWeight: '800',
    color: '#64748b',
  },
  natBtnTextActive: {
    color: '#ffffff',
  },
  input: {
    height: 48,
    borderRadius: 12,
    paddingHorizontal: 14,
    fontSize: 14,
    borderWidth: 1,
  },
  cedulaInput: {
    flex: 1,
  },
  inputLight: {
    backgroundColor: '#f8fafc',
    borderColor: '#cbd5e1',
    color: '#0a0a0a',
  },
  inputDark: {
    backgroundColor: '#06152a',
    borderColor: 'rgba(255, 255, 255, 0.2)',
    color: '#f8fafc',
  },
  passwordWrap: {
    position: 'relative',
    justifyContent: 'center',
  },
  togglePassBtn: {
    position: 'absolute',
    right: 12,
    paddingHorizontal: 8,
    paddingVertical: 4,
  },
  togglePassText: {
    fontSize: 12,
    color: UnefaColors.blue,
    fontWeight: '700',
  },
  formNote: {
    fontSize: 11,
    color: UnefaColors.goldDark,
    marginTop: 6,
    lineHeight: 16,
    fontStyle: 'italic',
  },

  // Buttons
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
    marginTop: 6,
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
    fontSize: 13,
  },

  // Auth Switch
  authSwitch: {
    marginTop: 24,
    paddingTop: 16,
    borderTopWidth: StyleSheet.hairlineWidth,
    borderTopColor: '#cbd5e1',
    gap: 10,
  },
  switchPrompt: {
    fontSize: 12,
    textAlign: 'center',
    fontWeight: '600',
  },
  secureNote: {
    fontSize: 11,
    color: '#64748b',
    textAlign: 'center',
    marginTop: 20,
    lineHeight: 16,
  },

  // Simulation Card (Efectos evaluativos)
  simCard: {
    backgroundColor: '#f8fafc',
    borderRadius: 16,
    padding: 14,
    marginBottom: 16,
    borderWidth: 1.5,
    borderColor: '#e2e8f0',
  },
  simHeader: {
    marginBottom: 12,
  },
  simBadge: {
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
  simBadgeText: {
    fontSize: 9,
    fontWeight: '900',
    color: UnefaColors.navy,
    letterSpacing: 0.5,
  },
  simTitle: {
    fontSize: 14,
    fontWeight: '900',
    color: '#0f172a',
    marginBottom: 2,
  },
  simSub: {
    fontSize: 11,
    color: '#64748b',
    lineHeight: 16,
  },
  simGrid: {
    gap: 8,
  },
  simBtn: {
    flexDirection: 'row',
    alignItems: 'center',
    paddingVertical: 10,
    paddingHorizontal: 12,
    borderRadius: 12,
    borderWidth: 1,
    backgroundColor: '#ffffff',
  },
  simBtnEstudiante: {
    borderColor: 'rgba(4, 15, 217, 0.25)',
  },
  simBtnProfesor: {
    borderColor: 'rgba(13, 148, 136, 0.25)',
  },
  simBtnCoordinador: {
    borderColor: 'rgba(180, 83, 9, 0.25)',
  },
  simBtnDirector: {
    borderColor: 'rgba(6, 21, 42, 0.25)',
  },
  simIconBox: {
    width: 36,
    height: 36,
    borderRadius: 10,
    alignItems: 'center',
    justifyContent: 'center',
    marginRight: 10,
  },
  simTextBox: {
    flex: 1,
  },
  simRoleName: {
    fontSize: 13,
    fontWeight: '800',
    marginBottom: 1,
  },
  simRoleSub: {
    fontSize: 10,
    color: '#64748b',
    fontWeight: '600',
  },
  simArrow: {
    fontSize: 16,
    fontWeight: '800',
    color: '#94a3b8',
    marginLeft: 6,
  },

  // Divider
  dividerRow: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 10,
    marginBottom: 16,
  },
  dividerLine: {
    flex: 1,
    height: 1,
    backgroundColor: '#e2e8f0',
  },
  dividerText: {
    fontSize: 10,
    fontWeight: '800',
    color: '#94a3b8',
    letterSpacing: 0.5,
  },

  // Help card
  authHelp: {
    padding: 18,
    borderRadius: 18,
    borderWidth: 1,
    borderColor: '#e2e8f0',
  },
  helpKicker: {
    fontSize: 12,
    fontWeight: '800',
    color: UnefaColors.blue,
    marginBottom: 6,
  },
  helpText: {
    fontSize: 12,
    lineHeight: 18,
    marginBottom: 10,
  },
  miniLink: {
    fontSize: 13,
    color: UnefaColors.blue,
    fontWeight: '800',
  },

  // Themes
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
