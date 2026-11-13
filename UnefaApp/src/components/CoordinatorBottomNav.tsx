import React from 'react';
import { View, Text, Pressable, Platform, StyleSheet } from 'react-native';
import { Home, ClipboardCheck, Users, User } from 'lucide-react-native';

export type CoordinatorTab = 'inicio' | 'catedras' | 'gestion' | 'perfil';

interface CoordinatorBottomNavProps {
  activeTab?: CoordinatorTab;
  onPressInicio?: () => void;
  onPressCatedras?: () => void;
  onPressGestion?: () => void;
  onPressPerfil?: () => void;
}

const AMBER = '#b45309';

export function CoordinatorBottomNav({
  activeTab = 'inicio',
  onPressInicio,
  onPressCatedras,
  onPressGestion,
  onPressPerfil,
}: CoordinatorBottomNavProps) {
  const isActive = (tab: CoordinatorTab) => activeTab === tab;
  const color = (tab: CoordinatorTab) => (isActive(tab) ? AMBER : '#475569');
  const stroke = (tab: CoordinatorTab) => (isActive(tab) ? 2.5 : 2);

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

      {/* Cátedras — acción primaria con pill ámbar */}
      <Pressable
        style={styles.tab}
        accessibilityRole="tab"
        accessibilityState={{ selected: isActive('catedras') }}
        accessibilityLabel="Supervisión de cátedras"
        onPress={onPressCatedras}>
        <View style={[styles.pill, isActive('catedras') && styles.pillActive]}>
          <ClipboardCheck
            size={18}
            color={isActive('catedras') ? '#ffffff' : AMBER}
            strokeWidth={2.5}
          />
        </View>
        <Text style={[styles.label, styles.labelHighlight, isActive('catedras') && styles.labelHighlightActive]}>
          Cátedras
        </Text>
      </Pressable>

      {/* Gestión */}
      <Pressable
        style={styles.tab}
        accessibilityRole="tab"
        accessibilityState={{ selected: isActive('gestion') }}
        accessibilityLabel="Gestión académica"
        onPress={onPressGestion}>
        <Users size={20} color={color('gestion')} strokeWidth={stroke('gestion')} />
        <Text style={[styles.label, isActive('gestion') && styles.labelActive]}>Gestión</Text>
      </Pressable>

      {/* Perfil */}
      <Pressable
        style={styles.tab}
        accessibilityRole="tab"
        accessibilityState={{ selected: isActive('perfil') }}
        accessibilityLabel="Mi perfil"
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
    color: AMBER,
    fontWeight: '800',
  },
  pill: {
    width: 38,
    height: 38,
    borderRadius: 11,
    backgroundColor: 'rgba(180, 83, 9, 0.12)',
    alignItems: 'center',
    justifyContent: 'center',
    marginBottom: -4,
  },
  pillActive: {
    backgroundColor: AMBER,
  },
  labelHighlight: {
    color: AMBER,
    fontWeight: '700',
  },
  labelHighlightActive: {
    color: AMBER,
    fontWeight: '800',
  },
});
