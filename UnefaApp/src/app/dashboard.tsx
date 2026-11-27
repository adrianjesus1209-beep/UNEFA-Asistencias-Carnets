import React, { useState } from 'react';
import { View, Text, Pressable, ScrollView } from 'react-native';
import { useRouter, useLocalSearchParams } from 'expo-router';
import { SafeAreaView } from 'react-native-safe-area-context';
import { ArrowLeft } from 'lucide-react-native';
import { UnefaColors } from '@/constants/theme';
import { Header } from '@/components/Header';
import { StudentBottomNav } from '@/components/StudentBottomNav';
import { TeacherBottomNav } from '@/components/TeacherBottomNav';
import { CoordinatorBottomNav } from '@/components/CoordinatorBottomNav';
import { DirectorBottomNav } from '@/components/DirectorBottomNav';
import { EntityRole, ROLES_DATA } from '@/components/dashboard/types';
import { RoleSelectorCard } from '@/components/dashboard/RoleSelectorCard';
import { SessionBanner } from '@/components/dashboard/SessionBanner';
import { EstudianteDashboard } from '@/components/dashboard/EstudianteDashboard';
import { ProfesorDashboard } from '@/components/dashboard/ProfesorDashboard';
import { CoordinadorDashboard } from '@/components/dashboard/CoordinadorDashboard';
import { DirectorDashboard } from '@/components/dashboard/DirectorDashboard';
import { CarnetFotoView } from '@/components/dashboard/CarnetFotoView';
import { PerfilView } from '@/components/dashboard/PerfilView';
import { EstudianteAsistenciaView } from '@/components/dashboard/EstudianteAsistenciaView';

export type { EntityRole };

export default function DashboardScreen() {
  const router = useRouter();
  const params = useLocalSearchParams<{ role?: string }>();

  const roleFromParams: EntityRole | null =
    params.role === 'profesor' ||
    params.role === 'coordinador' ||
    params.role === 'director' ||
    params.role === 'estudiante'
      ? (params.role as EntityRole)
      : null;

  // Si viene con param de login, el rol queda fijo (sesión real).
  // Sin param, habilita el selector de evaluación.
  const fromLogin = Boolean(roleFromParams);
  const [selectedRole, setSelectedRole] = useState<EntityRole>('estudiante');
  const [activeTab, setActiveTab] = useState<string>('inicio');

  const activeRole: EntityRole = roleFromParams ?? selectedRole;
  const currentRole = ROLES_DATA[activeRole];

  const handleRoleSelect = (role: EntityRole) => {
    setSelectedRole(role);
    setActiveTab('inicio');
  };

  const getHeaderSubtitle = () => {
    if (activeTab === 'carnet') return `Mi Carnet · ${currentRole.title}`;
    if (activeTab === 'perfil') return `Mi Perfil · ${currentRole.title}`;
    if (activeTab === 'asistencia') return `Asistencias · ${currentRole.title}`;
    if (activeTab === 'clase') return `Clase Activa · ${currentRole.title}`;
    return `Panel ${currentRole.title}`;
  };

  const renderContent = () => {
    // Vista dedicada para Mi Carnet (solo opciones para agregar la foto del carnet)
    if (activeTab === 'carnet') {
      return <CarnetFotoView config={currentRole} />;
    }

    // Vista dedicada para Perfil (datos de identificación y opciones para resetear contraseña)
    if (activeTab === 'perfil') {
      return (
        <PerfilView
          config={currentRole}
          onLogout={() => router.replace('/login' as any)}
        />
      );
    }

    // Vista dedicada de Asistencias para Estudiante
    if (activeRole === 'estudiante' && activeTab === 'asistencia') {
      return <EstudianteAsistenciaView config={currentRole} />;
    }

    // Vista de Inicio según el rol activo
    return (
      <>
        <SessionBanner
          activeRole={activeRole}
          config={currentRole}
          onLogout={() => router.replace('/login' as any)}
        />

        {activeRole === 'estudiante' && <EstudianteDashboard config={currentRole} />}
        {activeRole === 'profesor' && <ProfesorDashboard />}
        {activeRole === 'coordinador' && <CoordinadorDashboard />}
        {activeRole === 'director' && <DirectorDashboard />}
      </>
    );
  };

  return (
    <SafeAreaView className="flex-1 bg-white">
      <Header subtitle={getHeaderSubtitle()} showBack={true} />

      <ScrollView
        className="flex-1"
        contentContainerStyle={{ paddingBottom: 40, alignItems: 'center' }}
        showsVerticalScrollIndicator={false}>
        <View
          className="w-full px-4 pt-4"
          style={{ maxWidth: 480 }}>

          {/* Selector de rol solo en modo evaluación (sin sesión real) */}
          {!fromLogin && (
            <RoleSelectorCard activeRole={activeRole} onSelect={handleRoleSelect} />
          )}

          {/* Contenido dinámico según el botón seleccionado en el tab bar */}
          {renderContent()}

          {/* Volver al login */}
          <View className="mt-2.5 mb-5 items-center">
            <Pressable
              className="flex-row items-center gap-2 py-3 px-5 rounded-xl bg-slate-100 border border-slate-300"
              onPress={() => router.replace('/login' as any)}>
              <ArrowLeft size={16} color={UnefaColors.navy} />
              <Text className="text-[13px] font-black" style={{ color: UnefaColors.navy }}>
                Volver al inicio de sesión
              </Text>
            </Pressable>
          </View>

        </View>
      </ScrollView>

      {/* Barra inferior interactiva por rol */}
      {activeRole === 'estudiante' && (
        <StudentBottomNav
          activeTab={activeTab as any}
          onPressInicio={() => setActiveTab('inicio')}
          onPressCarnet={() => setActiveTab('carnet')}
          onPressAsistencia={() => setActiveTab('asistencia')}
          onPressPerfil={() => setActiveTab('perfil')}
        />
      )}
      {activeRole === 'profesor' && (
        <TeacherBottomNav
          activeTab={activeTab as any}
          onPressInicio={() => setActiveTab('inicio')}
          onPressClase={() => setActiveTab('clase')}
          onPressActas={() => router.push('/actas')}
          onPressCarnet={() => setActiveTab('carnet')}
          onPressPerfil={() => setActiveTab('perfil')}
        />
      )}
      {activeRole === 'coordinador' && (
        <CoordinatorBottomNav
          activeTab={activeTab as any}
          onPressInicio={() => setActiveTab('inicio')}
          onPressCatedras={() => setActiveTab('catedras')}
          onPressGestion={() => setActiveTab('gestion')}
          onPressPerfil={() => setActiveTab('perfil')}
        />
      )}
      {activeRole === 'director' && (
        <DirectorBottomNav
          activeTab={activeTab as any}
          onPressInicio={() => setActiveTab('inicio')}
          onPressSedes={() => setActiveTab('sedes')}
          onPressAuditoria={() => setActiveTab('auditoria')}
          onPressPerfil={() => setActiveTab('perfil')}
        />
      )}
    </SafeAreaView>
  );
}
