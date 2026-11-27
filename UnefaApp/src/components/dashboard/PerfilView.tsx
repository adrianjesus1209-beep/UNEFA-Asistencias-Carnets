import React, { useState } from 'react';
import { View, Text, TextInput, Pressable, StyleSheet } from 'react-native';
import {
  User,
  Shield,
  KeyRound,
  Eye,
  EyeOff,
  CheckCircle2,
  AlertCircle,
  IdCard,
  Mail,
  GraduationCap,
  LogOut,
} from 'lucide-react-native';
import { UnefaColors } from '@/constants/theme';
import { RoleConfig } from './types';

interface PerfilViewProps {
  config: RoleConfig;
  onLogout?: () => void;
}

export function PerfilView({ config, onLogout }: PerfilViewProps) {
  // Estados para el reseteo de contraseña
  const [currentPassword, setCurrentPassword] = useState('');
  const [newPassword, setNewPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');

  const [showCurrent, setShowCurrent] = useState(false);
  const [showNew, setShowNew] = useState(false);
  const [showConfirm, setShowConfirm] = useState(false);

  const [errorMessage, setErrorMessage] = useState('');
  const [successMessage, setSuccessMessage] = useState('');

  // Generar correo institucional representativo según el nombre
  const emailUsername = config.name
    .toLowerCase()
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '')
    .split(' ')
    .slice(0, 2)
    .join('.');
  const institutionalEmail = `${emailUsername}@unefa.edu.ve`;

  const handleResetPassword = () => {
    setErrorMessage('');
    setSuccessMessage('');

    if (!currentPassword.trim()) {
      setErrorMessage('Debe ingresar su contraseña institucional actual.');
      return;
    }

    if (newPassword.length < 8) {
      setErrorMessage('La nueva contraseña debe tener al menos 8 caracteres.');
      return;
    }

    if (newPassword !== confirmPassword) {
      setErrorMessage('La confirmación de la contraseña no coincide.');
      return;
    }

    // Éxito simulado
    setSuccessMessage(
      '¡Contraseña actualizada exitosamente! Sus credenciales han sido renovadas para este período académico.'
    );
    setCurrentPassword('');
    setNewPassword('');
    setConfirmPassword('');
  };

  return (
    <View className="gap-5">
      {/* Encabezado */}
      <View className="bg-white rounded-[18px] p-4 border border-slate-200">
        <View className="flex-row items-center gap-2 mb-1">
          <Shield size={16} color={UnefaColors.blue} />
          <Text
            className="text-[10px] font-black tracking-widest uppercase"
            style={{ color: UnefaColors.blue }}>
            PERFIL Y SEGURIDAD INSTITUCIONAL
          </Text>
        </View>
        <Text className="text-lg font-black text-slate-900 mb-1">
          Mi Perfil de Usuario
        </Text>
        <Text className="text-xs text-slate-500 leading-relaxed">
          Consulta y verificación de datos de identificación oficial y opciones de reseteo de
          credenciales de acceso.
        </Text>
      </View>

      {/* Sección 1: Datos de Identificación */}
      <View className="bg-white rounded-[18px] p-4 border border-slate-200">
        <View className="flex-row items-center justify-between mb-4 pb-3 border-b border-slate-100">
          <View className="flex-row items-center gap-2">
            <IdCard size={18} color={UnefaColors.navy} />
            <Text className="text-sm font-black text-slate-900">
              Datos de Identificación
            </Text>
          </View>
          <View
            className="px-2.5 py-0.5 rounded-full"
            style={{ backgroundColor: config.badgeBg }}>
            <Text
              className="text-[10px] font-black"
              style={{ color: config.badgeColor }}>
              {config.badge}
            </Text>
          </View>
        </View>

        {/* Tarjeta de identificación */}
        <View className="bg-slate-50 rounded-2xl p-4 border border-slate-200 mb-4">
          <View className="flex-row items-center gap-3.5 mb-3.5">
            <View
              className="w-14 h-14 rounded-2xl items-center justify-center border-2"
              style={{
                backgroundColor: UnefaColors.navy,
                borderColor: UnefaColors.gold,
              }}>
              <User size={28} color="#ffffff" />
            </View>
            <View className="flex-1">
              <Text className="text-base font-black text-slate-900 leading-tight">
                {config.name}
              </Text>
              <Text className="text-xs font-black text-amber-600 mt-0.5">
                {config.cedula}
              </Text>
              <Text className="text-[11px] font-semibold text-slate-500 mt-0.5">
                {config.title} UNEFA
              </Text>
            </View>
          </View>

          {/* Grid de campos de identificación */}
          <View className="gap-2.5 pt-2 border-t border-slate-200">
            <View className="flex-row justify-between items-center">
              <View className="flex-row items-center gap-1.5">
                <IdCard size={14} color="#64748b" />
                <Text className="text-xs font-bold text-slate-500">Matrícula:</Text>
              </View>
              <Text className="text-xs font-mono font-black text-slate-800">
                {config.matricula}
              </Text>
            </View>

            <View className="flex-row justify-between items-center">
              <View className="flex-row items-center gap-1.5">
                <GraduationCap size={14} color="#64748b" />
                <Text className="text-xs font-bold text-slate-500">Carrera:</Text>
              </View>
              <Text className="text-xs font-bold text-slate-800 text-right max-w-[200px]">
                {config.department}
              </Text>
            </View>

            <View className="flex-row justify-between items-center">
              <View className="flex-row items-center gap-1.5">
                <Mail size={14} color="#64748b" />
                <Text className="text-xs font-bold text-slate-500">Correo institucional:</Text>
              </View>
              <Text className="text-xs font-mono font-bold text-unefa-blue">
                {institutionalEmail}
              </Text>
            </View>


            <View className="flex-row justify-between items-center">
              <Text className="text-xs font-bold text-slate-500">Régimen académico:</Text>
              <Text className="text-xs font-bold text-slate-700">
                {config.subtitle}
              </Text>
            </View>
          </View>
        </View>
      </View>

      {/* Sección 2: Opciones para Resetear Contraseña */}
      <View className="bg-white rounded-[18px] p-4 border border-slate-200">
        <View className="flex-row items-center gap-2 mb-1">
          <KeyRound size={18} color={UnefaColors.blue} />
          <Text className="text-sm font-black text-slate-900">
            Opciones para Resetear Contraseña
          </Text>
        </View>
        <Text className="text-xs text-slate-500 mb-4">
          Actualice su clave de acceso para proteger su carnet digital y registros académicos.
        </Text>

        {/* Mensajes de error o éxito */}
        {errorMessage ? (
          <View className="flex-row items-center gap-2 bg-rose-50 border border-rose-300 rounded-xl p-3 mb-3">
            <AlertCircle size={16} color="#e11d48" />
            <Text className="text-xs font-bold text-rose-700 flex-1">
              {errorMessage}
            </Text>
          </View>
        ) : null}

        {successMessage ? (
          <View className="flex-row items-center gap-2 bg-emerald-50 border border-emerald-300 rounded-xl p-3 mb-3">
            <CheckCircle2 size={16} color="#059669" />
            <Text className="text-xs font-bold text-emerald-800 flex-1">
              {successMessage}
            </Text>
          </View>
        ) : null}

        {/* Formulario */}
        <View className="gap-3">
          {/* Contraseña actual */}
          <View>
            <Text className="text-xs font-extrabold uppercase text-slate-700 mb-1">
              Contraseña actual *
            </Text>
            <View className="flex-row items-center bg-slate-50 border border-slate-300 rounded-xl px-3 h-11 focus:border-unefa-blue focus:bg-white">
              <TextInput
                value={currentPassword}
                onChangeText={setCurrentPassword}
                secureTextEntry={!showCurrent}
                placeholder="Ingrese contraseña actual"
                placeholderTextColor="#94a3b8"
                className="flex-1 text-xs text-slate-900 font-medium"
              />
              <Pressable
                onPress={() => setShowCurrent(!showCurrent)}
                hitSlop={8}
                accessibilityRole="button"
                accessibilityLabel="Alternar visualización de contraseña actual">
                {showCurrent ? (
                  <EyeOff size={16} color="#64748b" />
                ) : (
                  <Eye size={16} color="#64748b" />
                )}
              </Pressable>
            </View>
          </View>

          {/* Nueva contraseña */}
          <View>
            <Text className="text-xs font-extrabold uppercase text-slate-700 mb-1">
              Nueva contraseña institucional *
            </Text>
            <View className="flex-row items-center bg-slate-50 border border-slate-300 rounded-xl px-3 h-11 focus:border-unefa-blue focus:bg-white">
              <TextInput
                value={newPassword}
                onChangeText={setNewPassword}
                secureTextEntry={!showNew}
                placeholder="Mínimo 8 caracteres"
                placeholderTextColor="#94a3b8"
                className="flex-1 text-xs text-slate-900 font-medium"
              />
              <Pressable
                onPress={() => setShowNew(!showNew)}
                hitSlop={8}
                accessibilityRole="button"
                accessibilityLabel="Alternar visualización de nueva contraseña">
                {showNew ? (
                  <EyeOff size={16} color="#64748b" />
                ) : (
                  <Eye size={16} color="#64748b" />
                )}
              </Pressable>
            </View>
          </View>

          {/* Confirmar nueva contraseña */}
          <View>
            <Text className="text-xs font-extrabold uppercase text-slate-700 mb-1">
              Confirmar nueva contraseña *
            </Text>
            <View className="flex-row items-center bg-slate-50 border border-slate-300 rounded-xl px-3 h-11 focus:border-unefa-blue focus:bg-white">
              <TextInput
                value={confirmPassword}
                onChangeText={setConfirmPassword}
                secureTextEntry={!showConfirm}
                placeholder="Repita la nueva contraseña"
                placeholderTextColor="#94a3b8"
                className="flex-1 text-xs text-slate-900 font-medium"
              />
              <Pressable
                onPress={() => setShowConfirm(!showConfirm)}
                hitSlop={8}
                accessibilityRole="button"
                accessibilityLabel="Alternar visualización de confirmación de contraseña">
                {showConfirm ? (
                  <EyeOff size={16} color="#64748b" />
                ) : (
                  <Eye size={16} color="#64748b" />
                )}
              </Pressable>
            </View>
          </View>

          {/* Botón Actualizar */}
          <Pressable
            accessibilityRole="button"
            accessibilityLabel="Actualizar contraseña"
            onPress={handleResetPassword}
            className="mt-2 py-3 rounded-xl items-center active:opacity-90"
            style={{ backgroundColor: UnefaColors.blue }}>
            <Text className="text-xs font-black text-white">
              Actualizar Contraseña
            </Text>
          </Pressable>

          {/* Opción adicional: Recuperación alternativa */}
          <View className="mt-2 pt-3 border-t border-slate-100 items-center">
            <Text className="text-[11px] text-slate-500 text-center">
              ¿Olvidó su contraseña actual? Puede restablecerla mediante las{' '}
              <Text className="font-bold text-unefa-blue">
                Preguntas de Seguridad (RF-04)
              </Text>{' '}
              configuradas en su expediente.
            </Text>
          </View>
        </View>
      </View>

      {/* Opción de cierre de sesión */}
      {onLogout && (
        <View className="items-center pb-2">
          <Pressable
            accessibilityRole="button"
            accessibilityLabel="Cerrar sesión institucional"
            onPress={onLogout}
            className="flex-row items-center gap-2 py-3 px-5 rounded-xl bg-slate-100 border border-slate-300 active:bg-slate-200">
            <LogOut size={16} color={UnefaColors.navy} />
            <Text className="text-xs font-black" style={{ color: UnefaColors.navy }}>
              Cerrar sesión institucional
            </Text>
          </Pressable>
        </View>
      )}
    </View>
  );
}
