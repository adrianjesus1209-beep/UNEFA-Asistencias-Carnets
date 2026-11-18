import React from 'react';
import { View, Text, Pressable, Platform } from 'react-native';
import { useRouter } from 'expo-router';
import { Home, GraduationCap, FileText, User } from 'lucide-react-native';
import { UnefaColors } from '@/constants/theme';

interface BottomNavProps {
  activeTab?: 'inicio' | 'carreras' | 'cinu' | 'siceu';
  onPressInicio?: () => void;
  onPressCarreras?: () => void;
  onOpenQr?: () => void;
}

export function BottomNav({
  activeTab = 'inicio',
  onPressInicio,
  onPressCarreras,
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

      {/* Tab: Carreras */}
      <Pressable
        className="flex-1 items-center justify-center py-1 gap-0.5"
        accessibilityRole="tab"
        accessibilityState={{ selected: activeTab === 'carreras' }}
        accessibilityLabel="Carreras"
        onPress={() => {
          if (onPressCarreras) onPressCarreras();
          else router.replace('/landing');
        }}>
        <GraduationCap
          size={20}
          color={getIconColor('carreras')}
          strokeWidth={activeTab === 'carreras' ? 2.5 : 2}
        />
        <Text
          className={`text-[11px] ${
            activeTab === 'carreras'
              ? 'font-bold text-unefa-blue'
              : 'font-semibold text-slate-500'
          }`}>
          Carreras
        </Text>
      </Pressable>

      {/* Tab: CINU */}
      <Pressable
        className="flex-1 items-center justify-center py-1 gap-0.5"
        accessibilityRole="tab"
        accessibilityState={{ selected: activeTab === 'cinu' }}
        accessibilityLabel="Preinscripción CINU"
        onPress={() => router.replace('/registro')}>
        <FileText
          size={20}
          color={getIconColor('cinu')}
          strokeWidth={activeTab === 'cinu' ? 2.5 : 2}
        />
        <Text
          className={`text-[11px] ${
            activeTab === 'cinu'
              ? 'font-bold text-unefa-blue'
              : 'font-semibold text-slate-500'
          }`}>
          CINU
        </Text>
      </Pressable>

      {/* Tab: SICEU */}
      <Pressable
        className="flex-1 items-center justify-center py-1 gap-0.5"
        accessibilityRole="tab"
        accessibilityState={{ selected: activeTab === 'siceu' }}
        accessibilityLabel="Portal SICEU"
        onPress={() => router.replace('/login')}>
        <User
          size={20}
          color={getIconColor('siceu')}
          strokeWidth={activeTab === 'siceu' ? 2.5 : 2}
        />
        <Text
          className={`text-[11px] ${
            activeTab === 'siceu'
              ? 'font-bold text-unefa-blue'
              : 'font-semibold text-slate-500'
          }`}>
          SICEU
        </Text>
      </Pressable>
    </View>
  );
}