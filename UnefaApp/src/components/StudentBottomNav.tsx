import React from 'react';
import { View, Text, Pressable, Platform, StyleSheet } from 'react-native';
import { Home, IdCard, ListChecks, User } from 'lucide-react-native';
import { UnefaColors } from '@/constants/theme';

export type StudentTab = 'inicio' | 'carnet' | 'escanear' | 'asistencia' | 'perfil';

interface StudentBottomNavProps {
  activeTab?: StudentTab;
  onPressInicio?: () => void;
  onPressCarnet?: () => void;
  onPressEscanear?: () => void;
  onPressAsistencia?: () => void;
  onPressPerfil?: () => void;
}

export function StudentBottomNav({
  activeTab = 'inicio',
  onPressInicio,
  onPressCarnet,
  onPressEscanear,
  onPressAsistencia,
  onPressPerfil,
}: StudentBottomNavProps) {
  const isTabActive = (tab: StudentTab) => {
    if (tab === 'escanear' || tab === 'asistencia') {
      return activeTab === 'escanear' || activeTab === 'asistencia';
    }
    return activeTab === tab;
  };

  const iconColor = (tab: StudentTab) =>
    isTabActive(tab) ? UnefaColors.blue : '#475569';

  const iconStroke = (tab: StudentTab) => (isTabActive(tab) ? 2.5 : 2);

  const handleAsistencia = onPressAsistencia ?? onPressEscanear;

  return (
    <View
      style={[
        styles.bar,
        Platform.OS === 'ios' ? styles.iosPadding : styles.androidPadding,
      ]}>
      {/* Inicio */}
      <Pressable
        style={styles.tab}
        accessibilityRole="tab"
        accessibilityState={{ selected: isTabActive('inicio') }}
        accessibilityLabel="Inicio"
        onPress={onPressInicio}>
        <Home size={22} color={iconColor('inicio')} strokeWidth={iconStroke('inicio')} />
        <Text style={[styles.label, isTabActive('inicio') && styles.labelActive]}>
          Inicio
        </Text>
      </Pressable>

      {/* Mi Carnet */}
      <Pressable
        style={styles.tab}
        accessibilityRole="tab"
        accessibilityState={{ selected: isTabActive('carnet') }}
        accessibilityLabel="Mi Carnet digital"
        onPress={onPressCarnet}>
        <IdCard size={22} color={iconColor('carnet')} strokeWidth={iconStroke('carnet')} />
        <Text style={[styles.label, isTabActive('carnet') && styles.labelActive]}>
          Mi Carnet
        </Text>
      </Pressable>

      {/* Asistencia — acción primaria con checklist, fondo dorado */}
      <Pressable
        style={styles.tab}
        accessibilityRole="tab"
        accessibilityState={{ selected: isTabActive('asistencia') }}
        accessibilityLabel="Control de asistencia"
        onPress={handleAsistencia}>
        <View
          style={[
            styles.qrPill,
            isTabActive('asistencia') && styles.qrPillActive,
          ]}>
          <ListChecks
            size={20}
            color={isTabActive('asistencia') ? '#ffffff' : UnefaColors.navy}
            strokeWidth={2.5}
          />
        </View>
        <Text
          style={[
            styles.label,
            styles.labelQr,
            isTabActive('asistencia') && styles.labelQrActive,
          ]}>
          Asistencia
        </Text>
      </Pressable>

      {/* Mi Perfil */}
      <Pressable
        style={styles.tab}
        accessibilityRole="tab"
        accessibilityState={{ selected: isTabActive('perfil') }}
        accessibilityLabel="Mi Perfil"
        onPress={onPressPerfil}>
        <User size={22} color={iconColor('perfil')} strokeWidth={iconStroke('perfil')} />
        <Text style={[styles.label, isTabActive('perfil') && styles.labelActive]}>
          Perfil
        </Text>
      </Pressable>
    </View>
  );
}

const styles = StyleSheet.create({
  bar: {
    height: 64,
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-around',
    backgroundColor: '#ffffff',
    borderTopWidth: 1,
    borderTopColor: '#e2e8f0',
    paddingTop: 6,
    zIndex: 50,
  },
  iosPadding: {
    paddingBottom: 12,
    height: 76,
  },
  androidPadding: {
    paddingBottom: 6,
  },
  tab: {
    flex: 1,
    alignItems: 'center',
    justifyContent: 'center',
    gap: 2,
  },
  label: {
    fontSize: 10,
    fontWeight: '600',
    color: '#475569',
    marginTop: 2,
  },
  labelActive: {
    color: UnefaColors.blue,
    fontWeight: '800',
  },
  // QR pill — destacado visualmente como acción primaria
  qrPill: {
    width: 40,
    height: 40,
    borderRadius: 12,
    backgroundColor: UnefaColors.goldSoft,
    alignItems: 'center',
    justifyContent: 'center',
    marginBottom: -6,
  },
  qrPillActive: {
    backgroundColor: UnefaColors.gold,
  },
  labelQr: {
    color: UnefaColors.navy,
    fontWeight: '700',
  },
  labelQrActive: {
    color: UnefaColors.goldDark,
    fontWeight: '800',
  },
});
