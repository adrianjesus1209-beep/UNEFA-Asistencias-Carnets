import React, { useState } from 'react';
import { View, Text, ScrollView, TextInput, Pressable } from 'react-native';
import { useRouter } from 'expo-router';
import { SafeAreaView } from 'react-native-safe-area-context';
import { Header } from '@/components/Header';
import { BottomNav } from '@/components/BottomNav';
import { QrModal } from '@/components/QrModal';

export default function RegistroScreen() {
  const router = useRouter();
  const [firstName, setFirstName] = useState('');
  const [lastName, setLastName] = useState('');
  const [nationality, setNationality] = useState<'V' | 'E'>('V');
  const [identityNumber, setIdentityNumber] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');
  const [showPassword, setShowPassword] = useState(false);
  const [errorMessage, setErrorMessage] = useState('');
  const [registered, setRegistered] = useState(false);
  const [qrOpen, setQrOpen] = useState(false);

  const handleRegister = () => {
    setErrorMessage('');

    if (
      !firstName.trim() ||
      !lastName.trim() ||
      !identityNumber.trim() ||
      !email.trim() ||
      !password ||
      !confirmPassword
    ) {
      setErrorMessage('Completa todos los campos para crear tu cuenta.');
      return;
    }

    if (!/^\d+$/.test(identityNumber.trim())) {
      setErrorMessage('La cédula debe contener solo números.');
      return;
    }

    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.trim())) {
      setErrorMessage('Ingresa un correo electrónico válido.');
      return;
    }

    if (password.length < 8) {
      setErrorMessage('La contraseña debe tener al menos 8 caracteres.');
      return;
    }

    if (password !== confirmPassword) {
      setErrorMessage('Las contraseñas no coinciden.');
      return;
    }

    setRegistered(true);
  };

  return (
    <SafeAreaView className="flex-1 bg-white">
      <Header subtitle="Registro de cuenta" showBack />

      <ScrollView
        className="flex-1"
        contentContainerClassName="items-center pb-24"
        keyboardShouldPersistTaps="handled"
        showsVerticalScrollIndicator={false}>
        <View className="w-full max-w-[480px] px-4 pt-5">
          <View className="mb-4 rounded-[18px] border border-unefa-blue/15 bg-unefa-blue/[0.05] p-5">
            <Text className="mb-1 text-[11px] font-extrabold uppercase tracking-[1px] text-unefa-blue">
              Comunidad UNEFA
            </Text>
            <Text className="text-[25px] font-black text-neutral-950">
              Crear una cuenta
            </Text>
            <Text className="mt-1 text-[13px] leading-5 text-slate-600">
              Registra tus datos para acceder a los servicios digitales de la universidad.
            </Text>
          </View>

          <View className="mb-5 rounded-[22px] border border-slate-200 bg-white p-5 shadow-sm">
            {registered ? (
              <View className="items-center py-4">
                <View className="mb-4 h-16 w-16 items-center justify-center rounded-full bg-green-100">
                  <Text className="text-3xl font-black text-unefa-green">✓</Text>
                </View>
                <Text className="mb-2 text-center text-xl font-black text-neutral-950">
                  Datos validados
                </Text>
                <Text className="mb-5 text-center text-sm leading-5 text-slate-600">
                  El formulario se completó correctamente. La creación de la cuenta requiere conexión con el servicio institucional.
                </Text>
                <Pressable
                  className="w-full items-center rounded-[14px] bg-unefa-gold py-3.5"
                  onPress={() => router.replace('/login')}>
                  <Text className="font-extrabold text-unefa-navy">Ir al portal SICEU</Text>
                </Pressable>
              </View>
            ) : (
              <>
                <Text className="mb-1 text-xl font-black text-neutral-950">
                  Datos personales
                </Text>
                <Text className="mb-5 text-[13px] leading-5 text-slate-600">
                  Completa la información para solicitar tu cuenta.
                </Text>

                {errorMessage ? (
                  <View
                    className="mb-4 rounded-xl border border-red-300 bg-red-50 p-3"
                    accessibilityRole="alert">
                    <Text className="text-[13px] font-bold text-unefa-red">
                      {errorMessage}
                    </Text>
                  </View>
                ) : null}

                <View className="mb-4">
                  <Text className="mb-1.5 text-[13px] font-bold text-neutral-950">
                    Nombre *
                  </Text>
                  <TextInput
                    className="h-12 rounded-xl border border-slate-300 bg-slate-50 px-3.5 text-sm text-neutral-950"
                    value={firstName}
                    onChangeText={setFirstName}
                    autoCapitalize="words"
                    autoComplete="given-name"
                    accessibilityLabel="Nombre"
                    placeholder="Tu nombre"
                    placeholderTextColor="#94a3b8"
                  />
                </View>

                <View className="mb-4">
                  <Text className="mb-1.5 text-[13px] font-bold text-neutral-950">
                    Apellido *
                  </Text>
                  <TextInput
                    className="h-12 rounded-xl border border-slate-300 bg-slate-50 px-3.5 text-sm text-neutral-950"
                    value={lastName}
                    onChangeText={setLastName}
                    autoCapitalize="words"
                    autoComplete="family-name"
                    accessibilityLabel="Apellido"
                    placeholder="Tu apellido"
                    placeholderTextColor="#94a3b8"
                  />
                </View>

                <View className="mb-4">
                  <Text className="mb-1.5 text-[13px] font-bold text-neutral-950">
                    Documento de identidad *
                  </Text>
                  <View className="flex-row gap-2">
                    <View className="flex-row rounded-xl bg-slate-100 p-[3px]">
                      {(['V', 'E'] as const).map((value) => (
                        <Pressable
                          key={value}
                          className={`items-center justify-center rounded-[10px] px-3 py-2.5 ${
                            nationality === value ? 'bg-unefa-blue' : ''
                          }`}
                          onPress={() => setNationality(value)}
                          accessibilityRole="button"
                          accessibilityState={{ selected: nationality === value }}
                          accessibilityLabel={`Nacionalidad ${value}`}>
                          <Text
                            className={`text-[13px] font-extrabold ${
                              nationality === value ? 'text-white' : 'text-slate-500'
                            }`}>
                            {value}-
                          </Text>
                        </Pressable>
                      ))}
                    </View>
                    <TextInput
                      className="h-12 flex-1 rounded-xl border border-slate-300 bg-slate-50 px-3.5 text-sm text-neutral-950"
                      value={identityNumber}
                      onChangeText={(value) => setIdentityNumber(value.replace(/\D/g, ''))}
                      keyboardType="numeric"
                      maxLength={12}
                      accessibilityLabel="Número de documento"
                      placeholder="Ej. 28123456"
                      placeholderTextColor="#94a3b8"
                    />
                  </View>
                </View>

                <View className="mb-4">
                  <Text className="mb-1.5 text-[13px] font-bold text-neutral-950">
                    Correo electrónico *
                  </Text>
                  <TextInput
                    className="h-12 rounded-xl border border-slate-300 bg-slate-50 px-3.5 text-sm text-neutral-950"
                    value={email}
                    onChangeText={setEmail}
                    keyboardType="email-address"
                    autoCapitalize="none"
                    autoComplete="email"
                    accessibilityLabel="Correo electrónico"
                    placeholder="nombre@correo.com"
                    placeholderTextColor="#94a3b8"
                  />
                </View>

                <View className="mb-4">
                  <Text className="mb-1.5 text-[13px] font-bold text-neutral-950">
                    Contraseña *
                  </Text>
                  <TextInput
                    className="h-12 rounded-xl border border-slate-300 bg-slate-50 px-3.5 text-sm text-neutral-950"
                    value={password}
                    onChangeText={setPassword}
                    secureTextEntry={!showPassword}
                    autoComplete="new-password"
                    accessibilityLabel="Contraseña"
                    placeholder="Mínimo 8 caracteres"
                    placeholderTextColor="#94a3b8"
                  />
                </View>

                <View className="mb-5">
                  <Text className="mb-1.5 text-[13px] font-bold text-neutral-950">
                    Confirmar contraseña *
                  </Text>
                  <View className="relative justify-center">
                    <TextInput
                      className="h-12 rounded-xl border border-slate-300 bg-slate-50 px-3.5 pr-20 text-sm text-neutral-950"
                      value={confirmPassword}
                      onChangeText={setConfirmPassword}
                      secureTextEntry={!showPassword}
                      autoComplete="new-password"
                      accessibilityLabel="Confirmar contraseña"
                      placeholder="Repite la contraseña"
                      placeholderTextColor="#94a3b8"
                    />
                    <Pressable
                      className="absolute right-3 px-2 py-1"
                      onPress={() => setShowPassword((current) => !current)}
                      accessibilityRole="button"
                      accessibilityLabel={showPassword ? 'Ocultar contraseñas' : 'Mostrar contraseñas'}>
                      <Text className="text-xs font-bold text-unefa-blue">
                        {showPassword ? 'Ocultar' : 'Mostrar'}
                      </Text>
                    </Pressable>
                  </View>
                </View>

                <Pressable
                  className="items-center rounded-[14px] bg-unefa-gold py-4 shadow-sm"
                  onPress={handleRegister}
                  accessibilityRole="button">
                  <Text className="text-[15px] font-black text-unefa-navy">
                    Crear cuenta
                  </Text>
                </Pressable>
              </>
            )}
          </View>
        </View>
      </ScrollView>

      {/* La barra y el acceso al lector QR permanecen disponibles durante el registro. */}
      <BottomNav activeTab="registro" onOpenQr={() => setQrOpen(true)} />
      <QrModal visible={qrOpen} onClose={() => setQrOpen(false)} />
    </SafeAreaView>
  );
}
