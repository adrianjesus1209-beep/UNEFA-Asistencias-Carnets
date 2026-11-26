import React, { useState } from 'react';
import {
  View,
  Text,
  ScrollView,
  TextInput,
  Pressable,
  ActivityIndicator,
} from 'react-native';
import { Image } from 'expo-image';
import { useRouter } from 'expo-router';
import {
  GraduationCap,
  Users,
  BookOpen,
  ClipboardCheck,
  ShieldCheck,
  Sparkles,
  ChevronRight,
} from 'lucide-react-native';
import { UnefaColors } from '@/constants/theme';
import { Header } from '@/components/Header';
import { BottomNav } from '@/components/BottomNav';
import { QrModal } from '@/components/QrModal';
import { SafeAreaView } from 'react-native-safe-area-context';

export default function LoginScreen() {
  const router = useRouter();

  // Estado del formulario y del tipo de usuario que inicia sesión.
  const [activeTab, setActiveTab] = useState<'estudiante' | 'personal'>('estudiante');
  const [staffRole, setStaffRole] = useState<'profesor' | 'coordinador' | 'director'>('profesor');
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
    const role = activeTab === 'estudiante' ? 'estudiante' : staffRole;

    setTimeout(() => {
      setIsLoading(false);
      setSuccessMsg(
        `Acceso verificado para ${nacionalidad}-${cedula.trim()}. Redirigiendo al portal...`,
      );
      setTimeout(() => {
        router.push({ pathname: '/dashboard' as any, params: { role } });
      }, 500);
    }, 800);
  };

  const selectTab = (tab: 'estudiante' | 'personal') => {
    setActiveTab(tab);
    setErrorMsg('');
    setSuccessMsg('');
  };

  // Mantiene accesos directos de prueba para revisar cada panel por separado.
  const handleTestLogin = (role: 'estudiante' | 'profesor' | 'coordinador' | 'director') => {
    router.push({ pathname: '/dashboard' as any, params: { role } });
  };

  return (
    <SafeAreaView className="flex-1 bg-white">
      <Header subtitle="Portal en línea" showBack={true} />

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
                    className="h-[34px] w-[34px]"
                    contentFit="contain"
                    accessibilityLabel="Logo de la UNEFA"
                  />
                </View>
                <View>
                  <Text className="mb-[3px] text-[10px] font-semibold tracking-[1px] text-white/75">
                    PORTAL ACADÉMICO
                  </Text>
                  <Text className="text-[17px] font-black text-white">
                    Portal en línea
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
                    Portal / Acceso
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
                Selecciona tu tipo de usuario para continuar con el acceso.
              </Text>
            </View>

            {/* Selector de ingreso por tipo de usuario. */}
            <View className="mb-5 flex-row rounded-xl bg-slate-100 p-1">
              <Pressable
                className={`flex-1 flex-row items-center justify-center gap-1.5 rounded-[10px] py-3 ${
                  activeTab === 'estudiante' ? 'bg-unefa-blue' : ''
                }`}
                onPress={() => selectTab('estudiante')}
                accessibilityRole="tab"
                accessibilityState={{ selected: activeTab === 'estudiante' }}>
                <GraduationCap
                  size={17}
                  color={activeTab === 'estudiante' ? '#ffffff' : '#475569'}
                />
                <Text
                  className={`text-xs font-extrabold ${
                    activeTab === 'estudiante' ? 'text-white' : 'text-slate-600'
                  }`}>
                  Estudiantes
                </Text>
              </Pressable>
              <Pressable
                className={`flex-1 flex-row items-center justify-center gap-1.5 rounded-[10px] py-3 ${
                  activeTab === 'personal' ? 'bg-unefa-blue' : ''
                }`}
                onPress={() => selectTab('personal')}
                accessibilityRole="tab"
                accessibilityState={{ selected: activeTab === 'personal' }}>
                <Users
                  size={17}
                  color={activeTab === 'personal' ? '#ffffff' : '#475569'}
                />
                <Text
                  className={`text-xs font-extrabold ${
                    activeTab === 'personal' ? 'text-white' : 'text-slate-600'
                  }`}>
                  Personal
                </Text>
              </Pressable>
            </View>

            {activeTab === 'estudiante' ? (
              <View className="mb-5 rounded-2xl border border-slate-200 bg-slate-50 p-3.5">
                <View className="mb-3">
                  <Text className="text-sm font-black text-slate-900">
                    Probar como estudiante
                  </Text>
                </View>
                <Pressable
                  className="flex-row items-center rounded-xl border border-blue-200 bg-white p-2.5"
                  onPress={() => handleTestLogin('estudiante')}
                  accessibilityRole="button"
                  accessibilityLabel="Iniciar sesión de prueba como estudiante">
                  <View className="mr-2.5 h-9 w-9 items-center justify-center rounded-lg bg-[rgba(4,15,217,0.1)]">
                    <GraduationCap size={18} color={UnefaColors.blue} />
                  </View>
                  <View className="flex-1">
                    <Text className="text-[13px] font-extrabold text-unefa-blue">
                      Estudiante
                    </Text>
                    <Text className="text-[10px] font-semibold text-slate-500">
                      C.I. 28.123.456 · 7mo Semestre
                    </Text>
                  </View>
                  <ChevronRight size={16} color={UnefaColors.blue} />
                </Pressable>
              </View>
            ) : (
              <View className="mb-5 rounded-2xl border border-slate-200 bg-slate-50 p-3.5">
                <View className="mb-3">
                  <Text className="text-sm font-black text-slate-900">
                    Probar panel de personal
                  </Text>
                </View>
                <View className="gap-2">
                  <Pressable
                    className="flex-row items-center rounded-xl border border-teal-200 bg-white p-2.5"
                    onPress={() => handleTestLogin('profesor')}
                    accessibilityRole="button"
                    accessibilityLabel="Iniciar sesión de prueba como docente">
                    <View className="mr-2.5 h-9 w-9 items-center justify-center rounded-lg bg-[rgba(13,148,136,0.12)]">
                      <BookOpen size={18} color="#0d9488" />
                    </View>
                    <View className="flex-1">
                      <Text className="text-[13px] font-extrabold text-teal-700">
                        Profesor / Docente
                      </Text>
                      <Text className="text-[10px] font-semibold text-slate-500">
                        C.I. 14.567.890 · Docente Ordinario
                      </Text>
                    </View>
                    <ChevronRight size={16} color="#0d9488" />
                  </Pressable>

                  <Pressable
                    className="flex-row items-center rounded-xl border border-amber-200 bg-white p-2.5"
                    onPress={() => handleTestLogin('coordinador')}
                    accessibilityRole="button"
                    accessibilityLabel="Iniciar sesión de prueba como coordinador">
                    <View className="mr-2.5 h-9 w-9 items-center justify-center rounded-lg bg-[rgba(180,83,9,0.12)]">
                      <ClipboardCheck size={18} color="#b45309" />
                    </View>
                    <View className="flex-1">
                      <Text className="text-[13px] font-extrabold text-amber-700">
                        Coordinador de Carrera
                      </Text>
                      <Text className="text-[10px] font-semibold text-slate-500">
                        C.I. 11.234.567 · Coord. Carrera
                      </Text>
                    </View>
                    <ChevronRight size={16} color="#b45309" />
                  </Pressable>

                  <Pressable
                    className="flex-row items-center rounded-xl border border-slate-300 bg-white p-2.5"
                    onPress={() => handleTestLogin('director')}
                    accessibilityRole="button"
                    accessibilityLabel="Iniciar sesión de prueba como director">
                    <View className="mr-2.5 h-9 w-9 items-center justify-center rounded-lg bg-[rgba(6,21,42,0.12)]">
                      <ShieldCheck size={18} color={UnefaColors.navy} />
                    </View>
                    <View className="flex-1">
                      <Text className="text-[13px] font-extrabold text-unefa-navy">
                        Director de Núcleo
                      </Text>
                      <Text className="text-[10px] font-semibold text-slate-500">
                        Cnel. Roberto Silva · Dir. General
                      </Text>
                    </View>
                    <ChevronRight size={16} color={UnefaColors.navy} />
                  </Pressable>
                </View>
              </View>
            )}

            {activeTab === 'personal' && (
              <View className="mb-5">
                <Text className="mb-2 text-[13px] font-bold text-neutral-950">
                  Tipo de personal
                </Text>
                <View className="flex-row flex-wrap gap-2">
                  {([
                    ['profesor', 'Docente'],
                    ['coordinador', 'Coordinación'],
                    ['director', 'Dirección'],
                  ] as const).map(([role, label]) => (
                    <Pressable
                      key={role}
                      className={`rounded-xl border px-3 py-2 ${
                        staffRole === role
                          ? 'border-unefa-blue bg-unefa-blue'
                          : 'border-slate-300 bg-white'
                      }`}
                      onPress={() => {
                        setStaffRole(role);
                        setErrorMsg('');
                        setSuccessMsg('');
                      }}
                      accessibilityRole="radio"
                      accessibilityState={{ selected: staffRole === role }}>
                      <Text
                        className={`text-xs font-bold ${
                          staffRole === role ? 'text-white' : 'text-slate-600'
                        }`}>
                        {label}
                      </Text>
                    </Pressable>
                  ))}
                </View>
              </View>
            )}

            <Text className="mb-4 text-[13px] leading-[18px] text-slate-600">
              {activeTab === 'estudiante'
                ? 'Ingresa con tu documento de identidad y clave institucional de estudiante.'
                : 'Ingresa con tu documento de identidad y clave institucional del personal.'}
            </Text>

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
              accessibilityLabel="Acceder al portal">
              {isLoading ? (
                <ActivityIndicator color={UnefaColors.navy} size="small" />
              ) : (
                <>
                  <Text className="text-[15px] font-black text-unefa-navy">
                    Acceder al portal
                  </Text>
                </>
              )}
            </Pressable>

            {/* Auth Switch */}
            <View className="mt-6 gap-2.5 border-t border-slate-300 pt-4">
              <Text className="text-center text-xs font-semibold text-slate-600">
                ¿Todavía no tienes cuenta?
              </Text>
              <Pressable
                className="flex-row items-center justify-center rounded-[14px] border border-slate-300 py-3.5"
                onPress={() => router.push('/registro')}>
                <Text className="text-[13px] font-bold text-neutral-950">
                  Crear cuenta UNEFA
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
                Volver a la landing
              </Text>
            </Pressable>
          </View>
        </View>
      </ScrollView>
      {/* La barra y el modal QR se mantienen disponibles desde el portal. */}
      <BottomNav activeTab="portal" onOpenQr={() => setQrOpen(true)} />
      <QrModal visible={qrOpen} onClose={() => setQrOpen(false)} />
    </SafeAreaView>
  );
}
