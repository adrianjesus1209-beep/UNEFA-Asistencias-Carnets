import React, { useState } from 'react';
import { View, Text, Pressable, ScrollView } from 'react-native';
import { useRouter, useLocalSearchParams } from 'expo-router';
import { SafeAreaView } from 'react-native-safe-area-context';
import { ArrowLeft } from 'lucide-react-native';
import { UnefaColors } from '@/constants/theme';
import { Header } from '@/components/Header';
import { BottomNav } from '@/components/BottomNav';
import { StudentBottomNav } from '@/components/StudentBottomNav';
import { QrModal } from '@/components/QrModal';
import { EntityRole, ROLES_DATA } from '@/components/dashboard/types';
import { RoleSelectorCard } from '@/components/dashboard/RoleSelectorCard';
import { SessionBanner } from '@/components/dashboard/SessionBanner';
import { EstudianteDashboard } from '@/components/dashboard/EstudianteDashboard';
import { ProfesorDashboard } from '@/components/dashboard/ProfesorDashboard';
import { CoordinadorDashboard } from '@/components/dashboard/CoordinadorDashboard';
import { DirectorDashboard } from '@/components/dashboard/DirectorDashboard';

export type { EntityRole };

export default function DashboardScreen() {
  const router = useRouter();
  const params = useLocalSearchParams<{ role?: string }>();

  const initialRole: EntityRole =
    params.role === 'profesor' ||
    params.role === 'coordinador' ||
    params.role === 'director'
      ? (params.role as EntityRole)
      : 'estudiante';

  const [activeRole, setActiveRole] = useState<EntityRole>(initialRole);
  const [qrOpen, setQrOpen] = useState(false);

  const currentRole = ROLES_DATA[activeRole];

  return (
    <SafeAreaView className="flex-1 bg-white">
      <Header subtitle={`Panel ${currentRole.title}`} showBack={true} />

      <ScrollView
        className="flex-1"
        contentContainerStyle={{ paddingBottom: 40, alignItems: 'center' }}
        showsVerticalScrollIndicator={false}>
        <View
          className="w-full px-4 pt-4"
          style={{ maxWidth: 480 }}>

          <RoleSelectorCard activeRole={activeRole} onSelect={setActiveRole} />

          <SessionBanner
            activeRole={activeRole}
            config={currentRole}
            onLogout={() => router.replace('/login' as any)}
          />

          {activeRole === 'estudiante' && <EstudianteDashboard config={currentRole} />}
          {activeRole === 'profesor' && <ProfesorDashboard />}
          {activeRole === 'coordinador' && <CoordinadorDashboard />}
          {activeRole === 'director' && <DirectorDashboard />}

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

      {/* Barra inferior diferenciada por rol */}
      {activeRole === 'estudiante' ? (
        <StudentBottomNav
          activeTab="inicio"
          onPressInicio={() => {}}
          onPressCarnet={() => {}}
          onPressEscanear={() => {}}
          onPressPerfil={() => {}}
        />
      ) : (
        <BottomNav activeTab="siceu" onOpenQr={() => setQrOpen(true)} />
      )}

      <QrModal visible={qrOpen} onClose={() => setQrOpen(false)} />
    </SafeAreaView>
  );
}
