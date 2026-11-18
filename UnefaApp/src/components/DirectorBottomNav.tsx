import React from 'react';
import { View, Text, Pressable, Platform, StyleSheet } from 'react-native';
import { Home, Building2, ShieldCheck, User } from 'lucide-react-native';
import { UnefaColors } from '@/constants/theme';

export type DirectorTab = 'inicio' | 'sedes' | 'auditoria' | 'perfil';

interface DirectorBottomNavProps {
  activeTab?: DirectorTab;
  onPressInicio?: () => void;
  onPressSedes?: () => void;
  onPressAuditoria?: () => void;
  onPressPerfil?: () => void;
}

const NAVY = UnefaColors.navy;

export function DirectorBottomNav({
  activeTab = 'inicio',
  onPressInicio,
  onPressSedes,
  onPressAuditoria,
  onPressPerfil,
}: DirectorBottomNavProps) {
  const isActive = (tab: DirectorTab) => activeTab === tab;
  const color = (tab: DirectorTab) => (isActive(tab) ? NAVY : '#475569');
  const stroke = (tab: DirectorTab) => (isActive(tab) ? 2.5 : 2);

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
        accessibilityState={{ selected: isActive('inicio') }}
        accessibilityLabel="Inicio"
        onPress={onPressInicio}>
        <Home size={20} color={color('inicio')} strokeWidth={stroke('inicio')} />
        <Text style={[styles.label, isActive('inicio') && styles.labelActive]}>Inicio</Text>
      </Pressable>

      {/* Sedes — acción primaria con pill azul oscuro */}
      <Pressable
        style={styles.tab}
        accessibilityRole="tab"
        accessibilityState={{ selected: isActive('sedes') }}
        accessibilityLabel="Supervisión de sedes"
        onPress={onPressSedes}>
        <View style={[styles.pill, isActive('sedes') && styles.pillActive]}>
          <Building2
            size={18}
            color={isActive('sedes') ? '#ffffff' : NAVY}
            strokeWidth={2.5}
          />
        </View>
        <Text style={[styles.label, styles.labelHighlight, isActive('sedes') && styles.labelHighlightActive]}>
          Sedes
        </Text>
      </Pressable>

      {/* Auditoría */}
      <Pressable
        style={styles.tab}
        accessibilityRole="tab"
        accessibilityState={{ selected: isActive('auditoria') }}
        accessibilityLabel="Auditoría SICEU"
        onPress={onPressAuditoria}>
        <ShieldCheck size={20} color={color('auditoria')} strokeWidth={stroke('auditoria')} />
        <Text style={[styles.label, isActive('auditoria') && styles.labelActive]}>Auditoría</Text>
      </Pressable>

      {/* Perfil */}
      <Pressable
        style={styles.tab}
        accessibilityRole="tab"
        accessibilityState={{ selected: isActive('perfil') }}
        accessibilityLabel="Mi perfil directivo"
        onPress={onPressPerfil}>
        <User size={20} color={color('perfil')} strokeWidth={stroke('perfil')} />
        <Text style={[styles.label, isActive('perfil') && styles.labelActive]}>Perfil</Text>
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
  iosPadding: { paddingBottom: 12, height: 76 },
  androidPadding: { paddingBottom: 6 },
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
    color: NAVY,
    fontWeight: '800',
  },
  pill: {
    width: 38,
    height: 38,
    borderRadius: 11,
    backgroundColor: 'rgba(6, 21, 42, 0.12)',
    alignItems: 'center',
    justifyContent: 'center',
    marginBottom: -4,
  },
  pillActive: {
    backgroundColor: NAVY,
  },
  labelHighlight: {
    color: NAVY,
    fontWeight: '700',
  },
  labelHighlightActive: {
    color: NAVY,
    fontWeight: '800',
  },
});
