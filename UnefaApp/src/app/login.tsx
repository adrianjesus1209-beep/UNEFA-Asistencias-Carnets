import React, { useState } from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  TextInput,
  Pressable,
  ActivityIndicator,
} from 'react-native';
import { Image } from 'expo-image';
import { useRouter } from 'expo-router';
import { UnefaColors, MaxContentWidth } from '@/constants/theme';
import { Header } from '@/components/Header';
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
        `Acceso simulado. Credenciales verificadas para la cédula ${nacionalidad}-${cedula.trim()}. En producción, aquí se abriría el panel SICEU.`
      );
    }, 900);
  };

  return (
    <SafeAreaView style={[styles.root, styles.rootLight]}>
      <Header subtitle="SICEU en línea" showBack={true} />

      <ScrollView
        style={styles.scroll}
        contentContainerStyle={styles.scrollContent}
        showsVerticalScrollIndicator={false}
        keyboardShouldPersistTaps="handled">
        <View style={styles.centerContainer}>
          {/* Institutional banner */}
          <View style={styles.banner}>
            <View style={styles.bannerTopRow}>
              <View style={styles.bannerBrand}>
                <View style={styles.bannerMark}>
                  <Image
                    source={require('@/assets/images/unefa-logo.png')}
                    style={styles.bannerLogo}
                    contentFit="contain"
                    accessibilityLabel="Logo de la UNEFA"
                  />
                </View>
                <View>
                  <Text style={styles.bannerSub}>PORTAL ACADÉMICO</Text>
                  <Text style={styles.bannerTitle}>SICEU en línea</Text>
                </View>
              </View>
              <View style={styles.periodBadge}>
                <Text style={styles.periodBadgeText}>2026-I</Text>
              </View>
            </View>
            <Text style={styles.bannerCaption}>
              Acceso seguro para estudiantes y personal UNEFA.
            </Text>
          </View>

          {/* Auth Main Card */}
          <View style={[styles.authCard, styles.cardLight]}>
            <View style={styles.cardHead}>
              <View style={styles.badgeRow}>
                <View style={styles.badgeBlue}>
                  <Text style={styles.badgeBlueText}>SICEU / Acceso</Text>
                </View>
                <View style={[styles.badgeNeutral, styles.badgeLight]}>
                  <Text style={[styles.badgeNeutralText, styles.subLight]}>
                    Periodo 2026-I
                  </Text>
                </View>
              </View>

              <Text style={[styles.authTitle, styles.textDark]}>
                Iniciar sesión
              </Text>
              <Text style={[styles.authSub, styles.subLight]}>
                Ingresa con tu documento de identidad y clave institucional.
              </Text>
            </View>

            {/* Error alert */}
            {errorMsg ? (
              <View style={styles.alertError}>
                <Text style={styles.alertErrorText}>⚠️ {errorMsg}</Text>
              </View>
            ) : null}

            {/* Success alert */}
            {successMsg ? (
              <View style={styles.alertSuccess}>
                <Text style={styles.alertSuccessText}>✓ {successMsg}</Text>
              </View>
            ) : null}

            {/* Field: Documento de identidad */}
            <View style={styles.field}>
              <Text style={[styles.label, styles.textDark]}>
                Documento de identidad
              </Text>
              <View style={styles.cedulaGroup}>
                {/* V / E Selector */}
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

                {/* Cédula Input */}
                <TextInput
                  style={[
                    styles.input,
                    styles.cedulaInput,
                    styles.inputLight,
                  ]}
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
            <View style={styles.field}>
              <View style={styles.fieldLabelRow}>
                <Text style={[styles.label, styles.textDark]}>
                  Contraseña institucional
                </Text>
                <Pressable onPress={() => setShowForgotNote((prev) => !prev)}>
                  <Text style={styles.inlineLink}>¿La olvidaste?</Text>
                </Pressable>
              </View>

              <View style={styles.passwordWrap}>
                <TextInput
                  style={[styles.input, styles.inputLight]}
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
                  style={styles.togglePassBtn}
                  onPress={() => setShowPassword((prev) => !prev)}
                  accessibilityRole="button"
                  accessibilityLabel={showPassword ? 'Ocultar contraseña' : 'Mostrar contraseña'}>
                  <Text style={styles.togglePassText}>{showPassword ? 'Ocultar' : 'Mostrar'}</Text>
                </Pressable>
              </View>

              {showForgotNote && (
                <Text style={styles.formNote}>
                  Contacta al departamento de Control de Estudios de tu núcleo para el
                  restablecimiento de la clave institucional.
                </Text>
              )}
            </View>

            {/* Submit Button */}
            <Pressable
              style={[styles.btn, styles.btnGold, styles.btnLg]}
              onPress={handleSubmit}
              disabled={isLoading}
              accessibilityRole="button"
              accessibilityLabel="Acceder al SICEU">
              {isLoading ? (
                <ActivityIndicator color={UnefaColors.navy} size="small" />
              ) : (
                <>
                  <Text style={styles.btnGoldText}>Acceder al SICEU</Text>
                  <Text style={styles.btnGoldArrow}>→</Text>
                </>
              )}
            </Pressable>

            {/* Auth Switch */}
            <View style={styles.authSwitch}>
              <Text style={[styles.switchPrompt, styles.subLight]}>
                ¿Eres aspirante de nuevo ingreso?
              </Text>
              <Pressable
                style={[styles.btn, styles.btnOutline]}
                onPress={() => router.push('/registro')}>
                <Text style={[styles.btnOutlineText, styles.textDark]}>
                  Preinscripción al CINU 2026-I
                </Text>
              </Pressable>
            </View>

            <Text style={styles.secureNote}>
              Conexión segura con el servidor de la UNEFA.{'\n'}
              Uso exclusivo para la comunidad universitaria autorizada.
            </Text>
          </View>

          {/* Aside Help */}
          <View style={[styles.authHelp, styles.cardLight]}>
            <Text style={styles.helpKicker}>¿Necesitas ayuda?</Text>
            <Text style={[styles.helpText, styles.subLight]}>
              Si no recuerdas tu clave o tu usuario no está activo, acude a la Unidad de Control de
              Estudios de tu núcleo.
            </Text>
            <Pressable onPress={() => router.push('/landing')}>
              <Text style={styles.miniLink}>Volver a la landing →</Text>
            </Pressable>
          </View>
        </View>
      </ScrollView>
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
