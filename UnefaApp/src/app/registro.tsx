import React, { useState } from 'react';
import {
  View,
  Text,
  ScrollView,
  TextInput,
  Pressable,
} from 'react-native';
import { useRouter } from 'expo-router';
import { Header } from '@/components/Header';
import { BottomNav } from '@/components/BottomNav';
import { QrModal } from '@/components/QrModal';
import { SafeAreaView } from 'react-native-safe-area-context';

export default function RegistroScreen() {
  const router = useRouter();

  // Current Step (1, 2, 3)
  const [currentStep, setCurrentStep] = useState<number>(1);
  const [isSubmitted, setIsSubmitted] = useState<boolean>(false);
  const [errorMsg, setErrorMsg] = useState<string>('');
  const [qrOpen, setQrOpen] = useState(false);

  // Password visibility
  const [showPass, setShowPass] = useState<boolean>(false);
  const [showConfirmPass, setShowConfirmPass] = useState<boolean>(false);

  // Step 1: Acceso
  const [firstName, setFirstName] = useState('');
  const [middleName, setMiddleName] = useState('');
  const [lastName, setLastName] = useState('');
  const [secondLastName, setSecondLastName] = useState('');
  const [nacionalidad, setNacionalidad] = useState<'V' | 'E'>('V');
  const [cedula, setCedula] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');

  // Step 2: Académico
  const [birthDate, setBirthDate] = useState('');
  const [phone, setPhone] = useState('');
  const [gender, setGender] = useState<'Male' | 'Female' | 'Other'>('Male');
  const [level, setLevel] = useState<'Bachiller' | 'TecnicoMedio' | 'BachillerHumanidades'>('Bachiller');
  const [gradYear, setGradYear] = useState('');
  const [carrera, setCarrera] = useState('ING-SIS');

  // Step 3: Residencia
  const [state, setState] = useState('Distrito Capital');
  const [municipality, setMunicipality] = useState('');
  const [parish, setParish] = useState('');
  const [urbanizacion, setUrbanizacion] = useState('');
  const [calleAv, setCalleAv] = useState('');
  const [nroCasa, setNroCasa] = useState('');

  const validateStep = (step: number): boolean => {
    setErrorMsg('');

    if (step === 1) {
      if (!firstName.trim() || !lastName.trim() || !cedula.trim() || !email.trim() || !password || !confirmPassword) {
        setErrorMsg('Completa todos los campos obligatorios del paso 1.');
        return false;
      }
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email.trim())) {
        setErrorMsg('Ingresa un correo electrónico válido.');
        return false;
      }
      if (password.length < 8) {
        setErrorMsg('La contraseña debe tener al menos 8 caracteres.');
        return false;
      }
      if (password !== confirmPassword) {
        setErrorMsg('Las contraseñas no coinciden. Verifícalas.');
        return false;
      }
    }

    if (step === 2) {
      if (!birthDate.trim() || !phone.trim() || !gradYear.trim()) {
        setErrorMsg('Completa todos los campos obligatorios del paso 2.');
        return false;
      }
      const yr = parseInt(gradYear.trim(), 10);
      if (isNaN(yr) || yr < 1970 || yr > 2026) {
        setErrorMsg('El año de egreso debe estar entre 1970 y 2026.');
        return false;
      }
    }

    if (step === 3) {
      if (!municipality.trim() || !parish.trim() || !urbanizacion.trim() || !calleAv.trim() || !nroCasa.trim()) {
        setErrorMsg('Completa todos los campos de dirección obligatorios.');
        return false;
      }
    }

    return true;
  };

  const handleNext = () => {
    if (validateStep(currentStep)) {
      setCurrentStep((prev) => Math.min(3, prev + 1));
    }
  };

  const handlePrev = () => {
    setErrorMsg('');
    setCurrentStep((prev) => Math.max(1, prev - 1));
  };

  const handleSubmit = () => {
    if (validateStep(3)) {
      setIsSubmitted(true);
    }
  };

  return (
    <SafeAreaView className="flex-1 bg-white">
      <Header subtitle="Registro CINU" showBack={true} />

      <ScrollView
        className="flex-1"
        contentContainerClassName="items-center pb-10"
        showsVerticalScrollIndicator={false}
        keyboardShouldPersistTaps="handled">
        <View className="w-full max-w-[480px] px-4 pt-4">
          {/* Banner */}
          <View className="p-3.5 rounded-[14px] mb-4 border bg-slate-50 border-slate-200">
            <Text className="text-[11px] font-semibold mb-0.5 text-slate-600">
              Admisiones · Curso de nivelación
            </Text>
            <Text className="text-base font-black text-neutral-950">
              CINU 2026-I
            </Text>
          </View>

          {/* Auth Card */}
          <View className="rounded-[22px] p-5 border shadow-lg mb-5 bg-white border-slate-200">
            <View className="mb-[18px]">
              <View className="flex-row gap-2 mb-3">
                <View className="bg-[rgba(242,184,7,0.16)] px-2.5 py-1 rounded-lg">
                  <Text className="text-unefa-goldDark text-[11px] font-extrabold">Nuevo ingreso</Text>
                </View>
                <View className="px-2.5 py-1 rounded-lg border bg-slate-100 border-slate-200">
                  <Text className="text-[11px] font-bold text-slate-600">
                    Expediente digital
                  </Text>
                </View>
              </View>

              <Text className="text-[26px] font-black mb-1.5 text-neutral-950">
                Preinscripción CINU
              </Text>
              <Text className="text-[13px] leading-[18px] text-slate-600">
                Completa las 3 secciones para formalizar tu solicitud de ingreso universitario.
              </Text>
            </View>

            {/* Stepper (only when not submitted) */}
            {!isSubmitted && (
              <View className="flex-row gap-2 mb-5 py-1">
                <View className="flex-1">
                  <View
                    className={`h-1 rounded-sm bg-slate-200 mb-1.5 ${currentStep >= 1 ? 'bg-unefa-gold' : ''}`}
                  />
                  <Text
                    className={`text-[11px] text-slate-500 font-semibold ${currentStep === 1 ? 'text-unefa-blue font-extrabold' : ''}`}>
                    <Text className="font-black">01.</Text> Acceso
                  </Text>
                </View>

                <View className="flex-1">
                  <View
                    className={`h-1 rounded-sm bg-slate-200 mb-1.5 ${currentStep >= 2 ? 'bg-unefa-gold' : ''}`}
                  />
                  <Text
                    className={`text-[11px] text-slate-500 font-semibold ${currentStep === 2 ? 'text-unefa-blue font-extrabold' : ''}`}>
                    <Text className="font-black">02.</Text> Académico
                  </Text>
                </View>

                <View className="flex-1">
                  <View
                    className={`h-1 rounded-sm bg-slate-200 mb-1.5 ${currentStep === 3 ? 'bg-unefa-gold' : ''}`}
                  />
                  <Text
                    className={`text-[11px] text-slate-500 font-semibold ${currentStep === 3 ? 'text-unefa-blue font-extrabold' : ''}`}>
                    <Text className="font-black">03.</Text> Residencia
                  </Text>
                </View>
              </View>
            )}

            {/* Error Message */}
            {errorMsg ? (
              <View className="bg-red-100 border border-red-300 p-3 rounded-xl mb-4">
                <Text className="text-unefa-red text-[13px] font-bold">⚠️ {errorMsg}</Text>
              </View>
            ) : null}

            {/* SUCCESS PANEL */}
            {isSubmitted ? (
              <View className="p-6 rounded-[18px] items-center border mb-5 bg-slate-50 border-slate-200">
                <View className="w-16 h-16 rounded-full bg-green-100 items-center justify-center mb-4">
                  <Text className="text-[32px] text-unefa-green font-black">✓</Text>
                </View>
                <View className="bg-[rgba(4,15,217,0.1)] px-2.5 py-1 rounded-lg self-center mb-2">
                  <Text className="text-unefa-blue text-[11px] font-extrabold">Expediente registrado</Text>
                </View>
                <Text className="text-[22px] font-black mb-2.5 text-center text-neutral-950">
                  ¡Preinscripción exitosa!
                </Text>
                <Text className="text-sm leading-5 text-center mb-5 text-slate-600">
                  Tu solicitud para el <Text className="font-extrabold">Curso Integral de Nivelación Universitaria (CINU 2026-I)</Text> fue registrada. Recibirás por correo la fecha para consignar tus documentos en Control de Estudios.
                </Text>

                <View className="w-full gap-2.5">
                  <Pressable
                    className="py-3 rounded-[14px] items-center justify-center flex-row gap-2 bg-unefa-gold"
                    onPress={() => router.push('/login')}>
                    <Text className="text-unefa-navy font-black text-sm">Ir al portal SICEU</Text>
                  </Pressable>
                  <Pressable
                    className="py-3 rounded-[14px] items-center justify-center flex-row gap-2 border border-slate-300 bg-transparent"
                    onPress={() => router.push('/landing')}>
                    <Text className="font-bold text-[13px] text-neutral-950">
                      Volver a la página principal
                    </Text>
                  </Pressable>
                </View>
              </View>
            ) : (
              /* FORM STEPS */
              <View className="mb-2.5">
                {/* ── PASO 1 ────────────────────────────────────────── */}
                {currentStep === 1 && (
                  <View className="gap-1">
                    <View className="mb-4">
                      <Text className="text-[13px] font-bold mb-1.5 text-neutral-950">
                        Primer nombre *
                      </Text>
                      <TextInput
                        className="h-12 rounded-xl px-3.5 text-sm border bg-slate-50 border-slate-300 text-neutral-950"
                        placeholder="Ej. Carlos"
                        placeholderTextColor="#94a3b8"
                        value={firstName}
                        onChangeText={setFirstName}
                      />
                    </View>

                    <View className="mb-4">
                      <Text className="text-[13px] font-bold mb-1.5 text-neutral-950">
                        Segundo nombre
                      </Text>
                      <TextInput
                        className="h-12 rounded-xl px-3.5 text-sm border bg-slate-50 border-slate-300 text-neutral-950"
                        placeholder="Ej. Eduardo"
                        placeholderTextColor="#94a3b8"
                        value={middleName}
                        onChangeText={setMiddleName}
                      />
                    </View>

                    <View className="mb-4">
                      <Text className="text-[13px] font-bold mb-1.5 text-neutral-950">
                        Primer apellido *
                      </Text>
                      <TextInput
                        className="h-12 rounded-xl px-3.5 text-sm border bg-slate-50 border-slate-300 text-neutral-950"
                        placeholder="Ej. Mendoza"
                        placeholderTextColor="#94a3b8"
                        value={lastName}
                        onChangeText={setLastName}
                      />
                    </View>

                    <View className="mb-4">
                      <Text className="text-[13px] font-bold mb-1.5 text-neutral-950">
                        Segundo apellido
                      </Text>
                      <TextInput
                        className="h-12 rounded-xl px-3.5 text-sm border bg-slate-50 border-slate-300 text-neutral-950"
                        placeholder="Ej. Gómez"
                        placeholderTextColor="#94a3b8"
                        value={secondLastName}
                        onChangeText={setSecondLastName}
                      />
                    </View>

                    <View className="mb-4">
                      <Text className="text-[13px] font-bold mb-1.5 text-neutral-950">
                        Documento de identidad *
                      </Text>
                      <View className="flex-row gap-2">
                        <View className="flex-row rounded-xl bg-slate-100 p-[3px]">
                          <Pressable
                            className={`px-3 py-2.5 rounded-[10px] justify-center items-center ${nacionalidad === 'V' ? 'bg-unefa-blue' : ''}`}
                            onPress={() => setNacionalidad('V')}>
                            <Text
                              className={`text-[13px] font-extrabold text-slate-500 ${nacionalidad === 'V' ? 'text-white' : ''}`}>
                              V-
                            </Text>
                          </Pressable>
                          <Pressable
                            className={`px-3 py-2.5 rounded-[10px] justify-center items-center ${nacionalidad === 'E' ? 'bg-unefa-blue' : ''}`}
                            onPress={() => setNacionalidad('E')}>
                            <Text
                              className={`text-[13px] font-extrabold text-slate-500 ${nacionalidad === 'E' ? 'text-white' : ''}`}>
                              E-
                            </Text>
                          </Pressable>
                        </View>
                        <TextInput
                          className="h-12 rounded-xl px-3.5 text-sm border flex-1 bg-slate-50 border-slate-300 text-neutral-950"
                          keyboardType="numeric"
                          placeholder="Ej. 29123456"
                          placeholderTextColor="#94a3b8"
                          value={cedula}
                          onChangeText={setCedula}
                        />
                      </View>
                    </View>

                    <View className="mb-4">
                      <Text className="text-[13px] font-bold mb-1.5 text-neutral-950">
                        Correo electrónico *
                      </Text>
                      <TextInput
                        className="h-12 rounded-xl px-3.5 text-sm border bg-slate-50 border-slate-300 text-neutral-950"
                        keyboardType="email-address"
                        autoCapitalize="none"
                        placeholder="nombre@correo.com"
                        placeholderTextColor="#94a3b8"
                        value={email}
                        onChangeText={setEmail}
                      />
                    </View>

                    <View className="mb-4">
                      <Text className="text-[13px] font-bold mb-1.5 text-neutral-950">
                        Contraseña *
                      </Text>
                      <View className="relative justify-center">
                        <TextInput
                          className="h-12 rounded-xl px-3.5 text-sm border bg-slate-50 border-slate-300 text-neutral-950"
                          secureTextEntry={!showPass}
                          placeholder="Mínimo 8 caracteres"
                          placeholderTextColor="#94a3b8"
                          value={password}
                          onChangeText={setPassword}
                        />
                        <Pressable
                          className="absolute right-3 px-2 py-1"
                          onPress={() => setShowPass((p) => !p)}>
                          <Text className="text-xs text-unefa-blue font-bold">{showPass ? 'Ocultar' : 'Ver'}</Text>
                        </Pressable>
                      </View>
                    </View>

                    <View className="mb-4">
                      <Text className="text-[13px] font-bold mb-1.5 text-neutral-950">
                        Confirmar contraseña *
                      </Text>
                      <View className="relative justify-center">
                        <TextInput
                          className="h-12 rounded-xl px-3.5 text-sm border bg-slate-50 border-slate-300 text-neutral-950"
                          secureTextEntry={!showConfirmPass}
                          placeholder="Repite la contraseña"
                          placeholderTextColor="#94a3b8"
                          value={confirmPassword}
                          onChangeText={setConfirmPassword}
                        />
                        <Pressable
                          className="absolute right-3 px-2 py-1"
                          onPress={() => setShowConfirmPass((p) => !p)}>
                          <Text className="text-xs text-unefa-blue font-bold">
                            {showConfirmPass ? 'Ocultar' : 'Ver'}
                          </Text>
                        </Pressable>
                      </View>
                    </View>
                  </View>
                )}

                {/* ── PASO 2 ────────────────────────────────────────── */}
                {currentStep === 2 && (
                  <View className="gap-1">
                    <View className="mb-4">
                      <Text className="text-[13px] font-bold mb-1.5 text-neutral-950">
                        Fecha de nacimiento *
                      </Text>
                      <TextInput
                        className="h-12 rounded-xl px-3.5 text-sm border bg-slate-50 border-slate-300 text-neutral-950"
                        placeholder="AAAA-MM-DD (Ej. 2005-08-14)"
                        placeholderTextColor="#94a3b8"
                        value={birthDate}
                        onChangeText={setBirthDate}
                      />
                    </View>

                    <View className="mb-4">
                      <Text className="text-[13px] font-bold mb-1.5 text-neutral-950">
                        Teléfono de contacto *
                      </Text>
                      <TextInput
                        className="h-12 rounded-xl px-3.5 text-sm border bg-slate-50 border-slate-300 text-neutral-950"
                        keyboardType="phone-pad"
                        placeholder="Ej. 0414-1234567"
                        placeholderTextColor="#94a3b8"
                        value={phone}
                        onChangeText={setPhone}
                      />
                    </View>

                    <View className="mb-4">
                      <Text className="text-[13px] font-bold mb-1.5 text-neutral-950">
                        Género *
                      </Text>
                      <View className="flex-row gap-2">
                        {[
                          { val: 'Male', lbl: 'Masculino' },
                          { val: 'Female', lbl: 'Femenino' },
                          { val: 'Other', lbl: 'Otro' },
                        ].map((g) => (
                          <Pressable
                            key={g.val}
                            className={`flex-1 py-2.5 px-2 rounded-[10px] border items-center bg-white border-slate-200 ${gender === g.val ? 'border-unefa-blue bg-[rgba(4,15,217,0.08)]' : ''}`}
                            onPress={() => setGender(g.val as any)}>
                            <Text
                              className={`text-xs font-bold ${gender === g.val ? 'text-unefa-blue font-extrabold' : ''}`}>
                              {g.lbl}
                            </Text>
                          </Pressable>
                        ))}
                      </View>
                    </View>

                    <View className="mb-4">
                      <Text className="text-[13px] font-bold mb-1.5 text-neutral-950">
                        Nivel de instrucción *
                      </Text>
                      <View className="gap-1.5">
                        {[
                          { val: 'Bachiller', lbl: 'Bachiller en Ciencias' },
                          { val: 'TecnicoMedio', lbl: 'Técnico Medio Industrial' },
                          { val: 'BachillerHumanidades', lbl: 'Bachiller en Humanidades' },
                        ].map((lvl) => (
                          <Pressable
                            key={lvl.val}
                            className={`py-2.5 px-3.5 rounded-[10px] border bg-white border-slate-200 ${level === lvl.val ? 'border-unefa-blue bg-[rgba(4,15,217,0.08)]' : ''}`}
                            onPress={() => setLevel(lvl.val as any)}>
                            <Text
                              className={`text-xs font-bold ${level === lvl.val ? 'text-unefa-blue font-extrabold' : ''}`}>
                              {lvl.lbl}
                            </Text>
                          </Pressable>
                        ))}
                      </View>
                    </View>

                    <View className="mb-4">
                      <Text className="text-[13px] font-bold mb-1.5 text-neutral-950">
                        Año de egreso de bachillerato *
                      </Text>
                      <TextInput
                        className="h-12 rounded-xl px-3.5 text-sm border bg-slate-50 border-slate-300 text-neutral-950"
                        keyboardType="numeric"
                        placeholder="Ej. 2025"
                        placeholderTextColor="#94a3b8"
                        value={gradYear}
                        onChangeText={setGradYear}
                      />
                    </View>

                    <View className="mb-4">
                      <Text className="text-[13px] font-bold mb-1.5 text-neutral-950">
                        Carrera de preferencia *
                      </Text>
                      <View className="gap-1.5">
                        {[
                          { val: 'ING-SIS', lbl: 'Ingeniería de Sistemas' },
                          { val: 'ING-TEL', lbl: 'Ingeniería de Telecomunicaciones' },
                          { val: 'ING-MEC', lbl: 'Ingeniería Mecánica' },
                          { val: 'ING-ELE', lbl: 'Ingeniería Electrónica' },
                          { val: 'LIC-AGM', lbl: 'Lic. Administración y Gestión Municipal' },
                          { val: 'LIC-ENF', lbl: 'Licenciatura en Enfermería' },
                          { val: 'TSU-SIS', lbl: 'TSU en Análisis de Sistemas' },
                          { val: 'TSU-ENF', lbl: 'TSU en Enfermería' },
                        ].map((c) => (
                          <Pressable
                            key={c.val}
                            className={`py-2.5 px-3.5 rounded-[10px] border bg-white border-slate-200 ${carrera === c.val ? 'border-unefa-blue bg-[rgba(4,15,217,0.08)]' : ''}`}
                            onPress={() => setCarrera(c.val)}>
                            <Text
                              className={`text-xs font-bold ${carrera === c.val ? 'text-unefa-blue font-extrabold' : ''}`}>
                              {c.lbl}
                            </Text>
                          </Pressable>
                        ))}
                      </View>
                    </View>
                  </View>
                )}

                {/* ── PASO 3 ────────────────────────────────────────── */}
                {currentStep === 3 && (
                  <View className="gap-1">
                    <View className="mb-4">
                      <Text className="text-[13px] font-bold mb-1.5 text-neutral-950">
                        Estado *
                      </Text>
                      <View className="gap-1.5">
                        {[
                          'Distrito Capital',
                          'Miranda',
                          'Aragua',
                          'Carabobo',
                          'Zulia',
                          'Lara',
                          'Anzoátegui',
                          'Bolívar',
                          'Táchira',
                          'Otro estado de Venezuela',
                        ].map((est) => (
                          <Pressable
                            key={est}
                            className={`py-2.5 px-3.5 rounded-[10px] border bg-white border-slate-200 ${state === est ? 'border-unefa-blue bg-[rgba(4,15,217,0.08)]' : ''}`}
                            onPress={() => setState(est)}>
                            <Text
                              className={`text-xs font-bold ${state === est ? 'text-unefa-blue font-extrabold' : ''}`}>
                              {est}
                            </Text>
                          </Pressable>
                        ))}
                      </View>
                    </View>

                    <View className="mb-4">
                      <Text className="text-[13px] font-bold mb-1.5 text-neutral-950">
                        Municipio *
                      </Text>
                      <TextInput
                        className="h-12 rounded-xl px-3.5 text-sm border bg-slate-50 border-slate-300 text-neutral-950"
                        placeholder="Ej. Libertador"
                        placeholderTextColor="#94a3b8"
                        value={municipality}
                        onChangeText={setMunicipality}
                      />
                    </View>

                    <View className="mb-4">
                      <Text className="text-[13px] font-bold mb-1.5 text-neutral-950">
                        Parroquia *
                      </Text>
                      <TextInput
                        className="h-12 rounded-xl px-3.5 text-sm border bg-slate-50 border-slate-300 text-neutral-950"
                        placeholder="Ej. Sucre / El Valle"
                        placeholderTextColor="#94a3b8"
                        value={parish}
                        onChangeText={setParish}
                      />
                    </View>

                    <View className="mb-4">
                      <Text className="text-[13px] font-bold mb-1.5 text-neutral-950">
                        Urbanización / sector *
                      </Text>
                      <TextInput
                        className="h-12 rounded-xl px-3.5 text-sm border bg-slate-50 border-slate-300 text-neutral-950"
                        placeholder="Ej. Casalta / Chuao"
                        placeholderTextColor="#94a3b8"
                        value={urbanizacion}
                        onChangeText={setUrbanizacion}
                      />
                    </View>

                    <View className="mb-4">
                      <Text className="text-[13px] font-bold mb-1.5 text-neutral-950">
                        Calle o avenida *
                      </Text>
                      <TextInput
                        className="h-12 rounded-xl px-3.5 text-sm border bg-slate-50 border-slate-300 text-neutral-950"
                        placeholder="Ej. Av. Principal con Calle 3"
                        placeholderTextColor="#94a3b8"
                        value={calleAv}
                        onChangeText={setCalleAv}
                      />
                    </View>

                    <View className="mb-4">
                      <Text className="text-[13px] font-bold mb-1.5 text-neutral-950">
                        Nro. casa / edificio *
                      </Text>
                      <TextInput
                        className="h-12 rounded-xl px-3.5 text-sm border bg-slate-50 border-slate-300 text-neutral-950"
                        placeholder="Ej. 14-B"
                        placeholderTextColor="#94a3b8"
                        value={nroCasa}
                        onChangeText={setNroCasa}
                      />
                    </View>

                    <Text className="text-[11px] leading-4 text-slate-500 italic mt-1.5 mb-2.5">
                      Al enviar este formulario certifico bajo fe de juramento que todos los datos
                      consignados son fidedignos y me comprometo a cumplir el reglamento disciplinario
                      del CINU y la doctrina cívico-militar unefista.
                    </Text>
                  </View>
                )}

                {/* Form Actions Footer */}
                <View className="flex-row items-center justify-between pt-4 border-t-[0.5px] border-slate-300 mt-2.5">
                  <Text className="text-xs font-bold text-slate-500">Paso {currentStep} / 3</Text>
                  <View className="flex-row gap-2">
                    {currentStep > 1 && (
                      <Pressable
                        className="py-3 rounded-[14px] items-center justify-center flex-row gap-2 border border-slate-300 bg-transparent py-2.5 px-4"
                        onPress={handlePrev}>
                        <Text className="font-bold text-[13px] text-neutral-950">
                          ← Atrás
                        </Text>
                      </Pressable>
                    )}
                    {currentStep < 3 ? (
                      <Pressable className="py-3 rounded-[14px] items-center justify-center flex-row gap-2 bg-unefa-gold py-2.5 px-4" onPress={handleNext}>
                        <Text className="text-unefa-navy font-black text-sm">Continuar →</Text>
                      </Pressable>
                    ) : (
                      <Pressable className="py-3 rounded-[14px] items-center justify-center flex-row gap-2 bg-unefa-blue py-2.5 px-4" onPress={handleSubmit}>
                        <Text className="text-white font-black text-sm">Finalizar ✓</Text>
                      </Pressable>
                    )}
                  </View>
                </View>
              </View>
            )}

            {/* Auth Switch */}
            <View className="mt-5 pt-4 border-t-[0.5px] border-slate-300 gap-2.5">
              <Text className="text-xs text-center font-semibold text-slate-600">
                ¿Ya posees matrícula o usuario activo?
              </Text>
              <Pressable
                className="py-3 rounded-[14px] items-center justify-center flex-row gap-2 border border-slate-300 bg-transparent"
                onPress={() => router.push('/login')}>
                <Text className="font-bold text-[13px] text-neutral-950">
                  Iniciar sesión en SICEU
                </Text>
              </Pressable>
            </View>
          </View>
        </View>
      </ScrollView>
      {/* La barra y el modal QR se mantienen disponibles desde CINU. */}
      <BottomNav activeTab="cinu" onOpenQr={() => setQrOpen(true)} />
      <QrModal visible={qrOpen} onClose={() => setQrOpen(false)} />
    </SafeAreaView>
  );
}
