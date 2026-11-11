import React, { useState } from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  TextInput,
  Pressable,
} from 'react-native';
import { useRouter } from 'expo-router';
import { UnefaColors, MaxContentWidth } from '@/constants/theme';
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
    <SafeAreaView style={[styles.root, styles.rootLight]}>
      <Header subtitle="Registro CINU" showBack={true} />

      <ScrollView
        style={styles.scroll}
        contentContainerStyle={styles.scrollContent}
        showsVerticalScrollIndicator={false}
        keyboardShouldPersistTaps="handled">
        <View style={styles.centerContainer}>
          {/* Banner */}
          <View style={[styles.banner, styles.bannerLight]}>
            <Text style={[styles.bannerSub, styles.subLight]}>
              Admisiones · Curso de nivelación
            </Text>
            <Text style={[styles.bannerTitle, styles.textDark]}>
              CINU 2026-I
            </Text>
          </View>

          {/* Auth Card */}
          <View style={[styles.authCard, styles.cardLight]}>
            <View style={styles.cardHead}>
              <View style={styles.badgeRow}>
                <View style={styles.badgeGold}>
                  <Text style={styles.badgeGoldText}>Nuevo ingreso</Text>
                </View>
                <View style={[styles.badgeNeutral, styles.badgeLight]}>
                  <Text style={[styles.badgeNeutralText, styles.subLight]}>
                    Expediente digital
                  </Text>
                </View>
              </View>

              <Text style={[styles.authTitle, styles.textDark]}>
                Preinscripción CINU
              </Text>
              <Text style={[styles.authSub, styles.subLight]}>
                Completa las 3 secciones para formalizar tu solicitud de ingreso universitario.
              </Text>
            </View>

            {/* Stepper (only when not submitted) */}
            {!isSubmitted && (
              <View style={styles.stepper}>
                <View
                  style={[
                    styles.stepInd,
                    currentStep === 1 && styles.stepIndActive,
                    currentStep > 1 && styles.stepIndCompleted,
                  ]}>
                  <View
                    style={[
                      styles.stepBar,
                      (currentStep >= 1) && styles.stepBarActive,
                    ]}
                  />
                  <Text
                    style={[
                      styles.stepLabel,
                      currentStep === 1 && styles.stepLabelActive,
                    ]}>
                    <Text style={styles.boldIdx}>01.</Text> Acceso
                  </Text>
                </View>

                <View
                  style={[
                    styles.stepInd,
                    currentStep === 2 && styles.stepIndActive,
                    currentStep > 2 && styles.stepIndCompleted,
                  ]}>
                  <View
                    style={[
                      styles.stepBar,
                      (currentStep >= 2) && styles.stepBarActive,
                    ]}
                  />
                  <Text
                    style={[
                      styles.stepLabel,
                      currentStep === 2 && styles.stepLabelActive,
                    ]}>
                    <Text style={styles.boldIdx}>02.</Text> Académico
                  </Text>
                </View>

                <View
                  style={[
                    styles.stepInd,
                    currentStep === 3 && styles.stepIndActive,
                  ]}>
                  <View
                    style={[
                      styles.stepBar,
                      (currentStep === 3) && styles.stepBarActive,
                    ]}
                  />
                  <Text
                    style={[
                      styles.stepLabel,
                      currentStep === 3 && styles.stepLabelActive,
                    ]}>
                    <Text style={styles.boldIdx}>03.</Text> Residencia
                  </Text>
                </View>
              </View>
            )}

            {/* Error Message */}
            {errorMsg ? (
              <View style={styles.alertError}>
                <Text style={styles.alertErrorText}>⚠️ {errorMsg}</Text>
              </View>
            ) : null}

            {/* SUCCESS PANEL */}
            {isSubmitted ? (
              <View style={[styles.successPanel, styles.successPanelLight]}>
                <View style={styles.successIconWrap}>
                  <Text style={styles.successIconCheck}>✓</Text>
                </View>
                <View style={styles.badgeBlue}>
                  <Text style={styles.badgeBlueText}>Expediente registrado</Text>
                </View>
                <Text style={[styles.successTitle, styles.textDark]}>
                  ¡Preinscripción exitosa!
                </Text>
                <Text style={[styles.successDesc, styles.subLight]}>
                  Tu solicitud para el <Text style={{ fontWeight: '800' }}>Curso Integral de Nivelación Universitaria (CINU 2026-I)</Text> fue registrada. Recibirás por correo la fecha para consignar tus documentos en Control de Estudios.
                </Text>

                <View style={styles.successActions}>
                  <Pressable
                    style={[styles.btn, styles.btnGold]}
                    onPress={() => router.push('/login')}>
                    <Text style={styles.btnGoldText}>Ir al portal SICEU</Text>
                  </Pressable>
                  <Pressable
                    style={[styles.btn, styles.btnOutline]}
                    onPress={() => router.push('/landing')}>
                    <Text style={[styles.btnOutlineText, styles.textDark]}>
                      Volver a la página principal
                    </Text>
                  </Pressable>
                </View>
              </View>
            ) : (
              /* FORM STEPS */
              <View style={styles.formContent}>
                {/* ── PASO 1 ────────────────────────────────────────── */}
                {currentStep === 1 && (
                  <View style={styles.stepContainer}>
                    <View style={styles.field}>
                      <Text style={[styles.label, styles.textDark]}>
                        Primer nombre *
                      </Text>
                      <TextInput
                        style={[styles.input, styles.inputLight]}
                        placeholder="Ej. Carlos"
                        placeholderTextColor="#94a3b8"
                        value={firstName}
                        onChangeText={setFirstName}
                      />
                    </View>

                    <View style={styles.field}>
                      <Text style={[styles.label, styles.textDark]}>
                        Segundo nombre
                      </Text>
                      <TextInput
                        style={[styles.input, styles.inputLight]}
                        placeholder="Ej. Eduardo"
                        placeholderTextColor="#94a3b8"
                        value={middleName}
                        onChangeText={setMiddleName}
                      />
                    </View>

                    <View style={styles.field}>
                      <Text style={[styles.label, styles.textDark]}>
                        Primer apellido *
                      </Text>
                      <TextInput
                        style={[styles.input, styles.inputLight]}
                        placeholder="Ej. Mendoza"
                        placeholderTextColor="#94a3b8"
                        value={lastName}
                        onChangeText={setLastName}
                      />
                    </View>

                    <View style={styles.field}>
                      <Text style={[styles.label, styles.textDark]}>
                        Segundo apellido
                      </Text>
                      <TextInput
                        style={[styles.input, styles.inputLight]}
                        placeholder="Ej. Gómez"
                        placeholderTextColor="#94a3b8"
                        value={secondLastName}
                        onChangeText={setSecondLastName}
                      />
                    </View>

                    <View style={styles.field}>
                      <Text style={[styles.label, styles.textDark]}>
                        Documento de identidad *
                      </Text>
                      <View style={styles.cedulaGroup}>
                        <View style={styles.nationalityToggle}>
                          <Pressable
                            style={[
                              styles.natBtn,
                              nacionalidad === 'V' && styles.natBtnActive,
                            ]}
                            onPress={() => setNacionalidad('V')}>
                            <Text
                              style={[
                                styles.natBtnText,
                                nacionalidad === 'V' && styles.natBtnTextActive,
                              ]}>
                              V-
                            </Text>
                          </Pressable>
                          <Pressable
                            style={[
                              styles.natBtn,
                              nacionalidad === 'E' && styles.natBtnActive,
                            ]}
                            onPress={() => setNacionalidad('E')}>
                            <Text
                              style={[
                                styles.natBtnText,
                                nacionalidad === 'E' && styles.natBtnTextActive,
                              ]}>
                              E-
                            </Text>
                          </Pressable>
                        </View>
                        <TextInput
                          style={[
                            styles.input,
                            styles.cedulaInput,
                            styles.inputLight,
                          ]}
                          keyboardType="numeric"
                          placeholder="Ej. 29123456"
                          placeholderTextColor="#94a3b8"
                          value={cedula}
                          onChangeText={setCedula}
                        />
                      </View>
                    </View>

                    <View style={styles.field}>
                      <Text style={[styles.label, styles.textDark]}>
                        Correo electrónico *
                      </Text>
                      <TextInput
                        style={[styles.input, styles.inputLight]}
                        keyboardType="email-address"
                        autoCapitalize="none"
                        placeholder="nombre@correo.com"
                        placeholderTextColor="#94a3b8"
                        value={email}
                        onChangeText={setEmail}
                      />
                    </View>

                    <View style={styles.field}>
                      <Text style={[styles.label, styles.textDark]}>
                        Contraseña *
                      </Text>
                      <View style={styles.passwordWrap}>
                        <TextInput
                          style={[styles.input, styles.inputLight]}
                          secureTextEntry={!showPass}
                          placeholder="Mínimo 8 caracteres"
                          placeholderTextColor="#94a3b8"
                          value={password}
                          onChangeText={setPassword}
                        />
                        <Pressable
                          style={styles.togglePassBtn}
                          onPress={() => setShowPass((p) => !p)}>
                          <Text style={styles.togglePassText}>{showPass ? 'Ocultar' : 'Ver'}</Text>
                        </Pressable>
                      </View>
                    </View>

                    <View style={styles.field}>
                      <Text style={[styles.label, styles.textDark]}>
                        Confirmar contraseña *
                      </Text>
                      <View style={styles.passwordWrap}>
                        <TextInput
                          style={[styles.input, styles.inputLight]}
                          secureTextEntry={!showConfirmPass}
                          placeholder="Repite la contraseña"
                          placeholderTextColor="#94a3b8"
                          value={confirmPassword}
                          onChangeText={setConfirmPassword}
                        />
                        <Pressable
                          style={styles.togglePassBtn}
                          onPress={() => setShowConfirmPass((p) => !p)}>
                          <Text style={styles.togglePassText}>
                            {showConfirmPass ? 'Ocultar' : 'Ver'}
                          </Text>
                        </Pressable>
                      </View>
                    </View>
                  </View>
                )}

                {/* ── PASO 2 ────────────────────────────────────────── */}
                {currentStep === 2 && (
                  <View style={styles.stepContainer}>
                    <View style={styles.field}>
                      <Text style={[styles.label, styles.textDark]}>
                        Fecha de nacimiento *
                      </Text>
                      <TextInput
                        style={[styles.input, styles.inputLight]}
                        placeholder="AAAA-MM-DD (Ej. 2005-08-14)"
                        placeholderTextColor="#94a3b8"
                        value={birthDate}
                        onChangeText={setBirthDate}
                      />
                    </View>

                    <View style={styles.field}>
                      <Text style={[styles.label, styles.textDark]}>
                        Teléfono de contacto *
                      </Text>
                      <TextInput
                        style={[styles.input, styles.inputLight]}
                        keyboardType="phone-pad"
                        placeholder="Ej. 0414-1234567"
                        placeholderTextColor="#94a3b8"
                        value={phone}
                        onChangeText={setPhone}
                      />
                    </View>

                    <View style={styles.field}>
                      <Text style={[styles.label, styles.textDark]}>
                        Género *
                      </Text>
                      <View style={styles.pickerRow}>
                        {[
                          { val: 'Male', lbl: 'Masculino' },
                          { val: 'Female', lbl: 'Femenino' },
                          { val: 'Other', lbl: 'Otro' },
                        ].map((g) => (
                          <Pressable
                            key={g.val}
                            style={[
                              styles.pickerOption,
                              gender === g.val && styles.pickerOptionActive,
                              styles.cardLight,
                            ]}
                            onPress={() => setGender(g.val as any)}>
                            <Text
                              style={[
                                styles.pickerOptionText,
                                gender === g.val && styles.pickerOptionTextActive,
                              ]}>
                              {g.lbl}
                            </Text>
                          </Pressable>
                        ))}
                      </View>
                    </View>

                    <View style={styles.field}>
                      <Text style={[styles.label, styles.textDark]}>
                        Nivel de instrucción *
                      </Text>
                      <View style={styles.pickerColumn}>
                        {[
                          { val: 'Bachiller', lbl: 'Bachiller en Ciencias' },
                          { val: 'TecnicoMedio', lbl: 'Técnico Medio Industrial' },
                          { val: 'BachillerHumanidades', lbl: 'Bachiller en Humanidades' },
                        ].map((lvl) => (
                          <Pressable
                            key={lvl.val}
                            style={[
                              styles.pickerBlock,
                              level === lvl.val && styles.pickerBlockActive,
                              styles.cardLight,
                            ]}
                            onPress={() => setLevel(lvl.val as any)}>
                            <Text
                              style={[
                                styles.pickerOptionText,
                                level === lvl.val && styles.pickerOptionTextActive,
                              ]}>
                              {lvl.lbl}
                            </Text>
                          </Pressable>
                        ))}
                      </View>
                    </View>

                    <View style={styles.field}>
                      <Text style={[styles.label, styles.textDark]}>
                        Año de egreso de bachillerato *
                      </Text>
                      <TextInput
                        style={[styles.input, styles.inputLight]}
                        keyboardType="numeric"
                        placeholder="Ej. 2025"
                        placeholderTextColor="#94a3b8"
                        value={gradYear}
                        onChangeText={setGradYear}
                      />
                    </View>

                    <View style={styles.field}>
                      <Text style={[styles.label, styles.textDark]}>
                        Carrera de preferencia *
                      </Text>
                      <View style={styles.pickerColumn}>
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
                            style={[
                              styles.pickerBlock,
                              carrera === c.val && styles.pickerBlockActive,
                              styles.cardLight,
                            ]}
                            onPress={() => setCarrera(c.val)}>
                            <Text
                              style={[
                                styles.pickerOptionText,
                                carrera === c.val && styles.pickerOptionTextActive,
                              ]}>
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
                  <View style={styles.stepContainer}>
                    <View style={styles.field}>
                      <Text style={[styles.label, styles.textDark]}>
                        Estado *
                      </Text>
                      <View style={styles.pickerColumn}>
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
                            style={[
                              styles.pickerBlock,
                              state === est && styles.pickerBlockActive,
                              styles.cardLight,
                            ]}
                            onPress={() => setState(est)}>
                            <Text
                              style={[
                                styles.pickerOptionText,
                                state === est && styles.pickerOptionTextActive,
                              ]}>
                              {est}
                            </Text>
                          </Pressable>
                        ))}
                      </View>
                    </View>

                    <View style={styles.field}>
                      <Text style={[styles.label, styles.textDark]}>
                        Municipio *
                      </Text>
                      <TextInput
                        style={[styles.input, styles.inputLight]}
                        placeholder="Ej. Libertador"
                        placeholderTextColor="#94a3b8"
                        value={municipality}
                        onChangeText={setMunicipality}
                      />
                    </View>

                    <View style={styles.field}>
                      <Text style={[styles.label, styles.textDark]}>
                        Parroquia *
                      </Text>
                      <TextInput
                        style={[styles.input, styles.inputLight]}
                        placeholder="Ej. Sucre / El Valle"
                        placeholderTextColor="#94a3b8"
                        value={parish}
                        onChangeText={setParish}
                      />
                    </View>

                    <View style={styles.field}>
                      <Text style={[styles.label, styles.textDark]}>
                        Urbanización / sector *
                      </Text>
                      <TextInput
                        style={[styles.input, styles.inputLight]}
                        placeholder="Ej. Casalta / Chuao"
                        placeholderTextColor="#94a3b8"
                        value={urbanizacion}
                        onChangeText={setUrbanizacion}
                      />
                    </View>

                    <View style={styles.field}>
                      <Text style={[styles.label, styles.textDark]}>
                        Calle o avenida *
                      </Text>
                      <TextInput
                        style={[styles.input, styles.inputLight]}
                        placeholder="Ej. Av. Principal con Calle 3"
                        placeholderTextColor="#94a3b8"
                        value={calleAv}
                        onChangeText={setCalleAv}
                      />
                    </View>

                    <View style={styles.field}>
                      <Text style={[styles.label, styles.textDark]}>
                        Nro. casa / edificio *
                      </Text>
                      <TextInput
                        style={[styles.input, styles.inputLight]}
                        placeholder="Ej. 14-B"
                        placeholderTextColor="#94a3b8"
                        value={nroCasa}
                        onChangeText={setNroCasa}
                      />
                    </View>

                    <Text style={styles.consent}>
                      Al enviar este formulario certifico bajo fe de juramento que todos los datos
                      consignados son fidedignos y me comprometo a cumplir el reglamento disciplinario
                      del CINU y la doctrina cívico-militar unefista.
                    </Text>
                  </View>
                )}

                {/* Form Actions Footer */}
                <View style={styles.formActions}>
                  <Text style={styles.stepCount}>Paso {currentStep} / 3</Text>
                  <View style={styles.btnRow}>
                    {currentStep > 1 && (
                      <Pressable
                        style={[styles.btn, styles.btnOutline, styles.btnSm]}
                        onPress={handlePrev}>
                        <Text style={[styles.btnOutlineText, styles.textDark]}>
                          ← Atrás
                        </Text>
                      </Pressable>
                    )}
                    {currentStep < 3 ? (
                      <Pressable style={[styles.btn, styles.btnGold, styles.btnSm]} onPress={handleNext}>
                        <Text style={styles.btnGoldText}>Continuar </Text>
                      </Pressable>
                    ) : (
                      <Pressable style={[styles.btn, styles.btnBlue, styles.btnSm]} onPress={handleSubmit}>
                        <Text style={styles.btnBlueText}>Finalizar </Text>
                      </Pressable>
                    )}
                  </View>
                </View>
              </View>
            )}

            {/* Auth Switch */}
            <View style={styles.authSwitch}>
              <Text style={[styles.switchPrompt, styles.subLight]}>
                ¿Ya posees matrícula o usuario activo?
              </Text>
              <Pressable
                style={[styles.btn, styles.btnOutline]}
                onPress={() => router.push('/login')}>
                <Text style={[styles.btnOutlineText, styles.textDark]}>
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
    padding: 14,
    borderRadius: 14,
    marginBottom: 16,
    borderWidth: 1,
  },
  bannerLight: {
    backgroundColor: '#f8fafc',
    borderColor: '#e2e8f0',
  },
  bannerDark: {
    backgroundColor: '#0f1d33',
    borderColor: 'rgba(255, 255, 255, 0.08)',
  },
  bannerSub: {
    fontSize: 11,
    fontWeight: '600',
    marginBottom: 2,
  },
  bannerTitle: {
    fontSize: 16,
    fontWeight: '900',
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
    marginBottom: 18,
  },
  badgeRow: {
    flexDirection: 'row',
    gap: 8,
    marginBottom: 12,
  },
  badgeGold: {
    backgroundColor: UnefaColors.goldSoft,
    paddingHorizontal: 10,
    paddingVertical: 4,
    borderRadius: 8,
  },
  badgeGoldText: {
    color: UnefaColors.goldDark,
    fontSize: 11,
    fontWeight: '800',
  },
  badgeBlue: {
    backgroundColor: 'rgba(4, 15, 217, 0.1)',
    paddingHorizontal: 10,
    paddingVertical: 4,
    borderRadius: 8,
    alignSelf: 'center',
    marginBottom: 8,
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

  // Stepper
  stepper: {
    flexDirection: 'row',
    gap: 8,
    marginBottom: 20,
    paddingVertical: 4,
  },
  stepInd: {
    flex: 1,
  },
  stepIndActive: {},
  stepIndCompleted: {},
  stepBar: {
    height: 4,
    borderRadius: 2,
    backgroundColor: '#e2e8f0',
    marginBottom: 6,
  },
  stepBarActive: {
    backgroundColor: UnefaColors.gold,
  },
  stepLabel: {
    fontSize: 11,
    color: '#64748b',
    fontWeight: '600',
  },
  stepLabelActive: {
    color: UnefaColors.blue,
    fontWeight: '800',
  },
  boldIdx: {
    fontWeight: '900',
  },

  // Alert
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

  // Success Panel
  successPanel: {
    padding: 24,
    borderRadius: 18,
    alignItems: 'center',
    borderWidth: 1,
    marginBottom: 20,
  },
  successPanelLight: {
    backgroundColor: '#f8fafc',
    borderColor: '#e2e8f0',
  },
  successPanelDark: {
    backgroundColor: '#0f1d33',
    borderColor: 'rgba(255, 255, 255, 0.1)',
  },
  successIconWrap: {
    width: 64,
    height: 64,
    borderRadius: 32,
    backgroundColor: '#dcfce7',
    alignItems: 'center',
    justifyContent: 'center',
    marginBottom: 16,
  },
  successIconCheck: {
    fontSize: 32,
    color: UnefaColors.green,
    fontWeight: '900',
  },
  successTitle: {
    fontSize: 22,
    fontWeight: '900',
    marginBottom: 10,
    textAlign: 'center',
  },
  successDesc: {
    fontSize: 14,
    lineHeight: 20,
    textAlign: 'center',
    marginBottom: 20,
  },
  successActions: {
    width: '100%',
    gap: 10,
  },

  // Form
  formContent: {
    marginBottom: 10,
  },
  stepContainer: {
    gap: 4,
  },
  field: {
    marginBottom: 16,
  },
  label: {
    fontSize: 13,
    fontWeight: '700',
    marginBottom: 6,
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

  // Selectors / Picker simulations
  pickerRow: {
    flexDirection: 'row',
    gap: 8,
  },
  pickerOption: {
    flex: 1,
    paddingVertical: 10,
    paddingHorizontal: 8,
    borderRadius: 10,
    borderWidth: 1,
    alignItems: 'center',
  },
  pickerOptionActive: {
    borderColor: UnefaColors.blue,
    backgroundColor: 'rgba(4, 15, 217, 0.08)',
  },
  pickerOptionText: {
    fontSize: 12,
    fontWeight: '700',
  },
  pickerOptionTextActive: {
    color: UnefaColors.blue,
    fontWeight: '800',
  },
  pickerColumn: {
    gap: 6,
  },
  pickerBlock: {
    paddingVertical: 10,
    paddingHorizontal: 14,
    borderRadius: 10,
    borderWidth: 1,
  },
  pickerBlockActive: {
    borderColor: UnefaColors.blue,
    backgroundColor: 'rgba(4, 15, 217, 0.08)',
  },

  consent: {
    fontSize: 11,
    lineHeight: 16,
    color: '#64748b',
    fontStyle: 'italic',
    marginTop: 6,
    marginBottom: 10,
  },

  // Actions
  formActions: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingTop: 16,
    borderTopWidth: StyleSheet.hairlineWidth,
    borderTopColor: '#cbd5e1',
    marginTop: 10,
  },
  stepCount: {
    fontSize: 12,
    fontWeight: '700',
    color: '#64748b',
  },
  btnRow: {
    flexDirection: 'row',
    gap: 8,
  },
  btn: {
    paddingVertical: 12,
    borderRadius: 14,
    alignItems: 'center',
    justifyContent: 'center',
    flexDirection: 'row',
    gap: 8,
  },
  btnSm: {
    paddingVertical: 10,
    paddingHorizontal: 16,
  },
  btnGold: {
    backgroundColor: UnefaColors.gold,
  },
  btnGoldText: {
    color: UnefaColors.navy,
    fontWeight: '900',
    fontSize: 14,
  },
  btnBlue: {
    backgroundColor: UnefaColors.blue,
  },
  btnBlueText: {
    color: '#ffffff',
    fontWeight: '900',
    fontSize: 14,
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
    marginTop: 20,
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

  // Card themes
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
