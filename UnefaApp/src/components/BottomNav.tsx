import React from 'react';
import { View, Text, Pressable, Platform } from 'react-native';
import { useRouter } from 'expo-router';
import { Home, FileText, User } from 'lucide-react-native';
import { UnefaColors } from '@/constants/theme';

interface BottomNavProps {
  activeTab?: 'inicio' | 'registro' | 'portal';
  onPressInicio?: () => void;
  onOpenQr?: () => void;
}

export function BottomNav({
  activeTab = 'inicio',
  onPressInicio,
  onOpenQr,
}: BottomNavProps) {
  const router = useRouter();

  const getIconColor = (tab: BottomNavProps['activeTab']) =>
    activeTab === tab ? UnefaColors.blue : '#475569';

  return (
    <View
      className={`h-16 flex-row items-center justify-around bg-white border-t border-slate-200 pt-1.5 z-50 ${
        Platform.OS === 'ios' ? 'pb-3' : 'pb-1.5'
      }`}>
      {/* Tab: Inicio */}
      <Pressable
        className="flex-1 items-center justify-center py-1 gap-0.5"
        accessibilityRole="tab"
        accessibilityState={{ selected: activeTab === 'inicio' }}
        accessibilityLabel="Inicio"
        onPress={() => {
          if (onPressInicio) onPressInicio();
          else router.replace('/landing');
        }}>
        <Home
          size={20}
          color={getIconColor('inicio')}
          strokeWidth={activeTab === 'inicio' ? 2.5 : 2}
        />
        <Text
          className={`text-[11px] ${
            activeTab === 'inicio'
              ? 'font-bold text-unefa-blue'
              : 'font-semibold text-slate-500'
          }`}>
          Inicio
        </Text>
      </Pressable>

      {/* Tab: Registro */}
      <Pressable
        className="flex-1 items-center justify-center py-1 gap-0.5"
        accessibilityRole="tab"
        accessibilityState={{ selected: activeTab === 'registro' }}
        accessibilityLabel="Crear cuenta"
        onPress={() => router.replace('/registro')}>
        <FileText
          size={20}
          color={getIconColor('registro')}
          strokeWidth={activeTab === 'registro' ? 2.5 : 2}
        />
        <Text
          className={`text-[11px] ${
            activeTab === 'registro'
              ? 'font-bold text-unefa-blue'
              : 'font-semibold text-slate-500'
          }`}>
          Registro
        </Text>
      </Pressable>

      {/* Tab: Portal */}
      <Pressable
        className="flex-1 items-center justify-center py-1 gap-0.5"
        accessibilityRole="tab"
        accessibilityState={{ selected: activeTab === 'portal' }}
        accessibilityLabel="Portal"
        onPress={() => router.replace('/login')}>
        <User
          size={20}
          color={getIconColor('portal')}
          strokeWidth={activeTab === 'portal' ? 2.5 : 2}
        />
        <Text
          className={`text-[11px] ${
            activeTab === 'portal'
              ? 'font-bold text-unefa-blue'
              : 'font-semibold text-slate-500'
          }`}>
          Portal
        </Text>
      </Pressable>
    </View>
  );
}