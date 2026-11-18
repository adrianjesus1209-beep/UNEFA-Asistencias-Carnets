import React from 'react';
import { View, Text, Pressable, Platform, StyleSheet } from 'react-native';
import { Home, Radio, FileText, IdCard, User } from 'lucide-react-native';

export type TeacherTab = 'inicio' | 'clase' | 'actas' | 'carnet' | 'perfil';

interface TeacherBottomNavProps {
  activeTab?: TeacherTab;
  onPressInicio?: () => void;
  onPressClase?: () => void;
  onPressActas?: () => void;
  onPressCarnet?: () => void;
  onPressPerfil?: () => void;
}

const TEAL = '#0d9488';

export function TeacherBottomNav({
  activeTab = 'inicio',
  onPressInicio,
  onPressClase,
  onPressActas,
  onPressCarnet,
  onPressPerfil,
}: TeacherBottomNavProps) {
  const isActive = (tab: TeacherTab) => activeTab === tab;
  const color = (tab: TeacherTab) => (isActive(tab) ? TEAL : '#475569');
  const stroke = (tab: TeacherTab) => (isActive(tab) ? 2.5 : 2);

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

      {/* Clase activa — acción primaria con pill teal */}
      <Pressable
        style={styles.tab}
        accessibilityRole="tab"
        accessibilityState={{ selected: isActive('clase') }}
        accessibilityLabel="Clase activa"
        onPress={onPressClase}>
        <View style={[styles.clasePill, isActive('clase') && styles.clasePillActive]}>
          <Radio
            size={18}
            color={isActive('clase') ? '#ffffff' : TEAL}
            strokeWidth={2.5}
          />
        </View>
        <Text style={[styles.label, styles.labelClase, isActive('clase') && styles.labelClaseActive]}>
          Clase
        </Text>
      </Pressable>

      {/* Actas */}
      <Pressable
        style={styles.tab}
        accessibilityRole="tab"
        accessibilityState={{ selected: isActive('actas') }}
        accessibilityLabel="Actas de asistencia"
        onPress={onPressActas}>
        <FileText size={20} color={color('actas')} strokeWidth={stroke('actas')} />
        <Text style={[styles.label, isActive('actas') && styles.labelActive]}>Actas</Text>
      </Pressable>

      {/* Mi Carnet */}
      <Pressable
        style={styles.tab}
        accessibilityRole="tab"
        accessibilityState={{ selected: isActive('carnet') }}
        accessibilityLabel="Mi carnet digital"
        onPress={onPressCarnet}>
        <IdCard size={20} color={color('carnet')} strokeWidth={stroke('carnet')} />
        <Text style={[styles.label, isActive('carnet') && styles.labelActive]}>Carnet</Text>
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
    color: TEAL,
    fontWeight: '800',
  },
  // Clase pill — acción primaria del docente
  clasePill: {
    width: 38,
    height: 38,
    borderRadius: 11,
    backgroundColor: 'rgba(13, 148, 136, 0.12)',
    alignItems: 'center',
    justifyContent: 'center',
    marginBottom: -4,
  },
  clasePillActive: {
    backgroundColor: TEAL,
  },
  labelClase: {
    color: TEAL,
    fontWeight: '700',
  },
  labelClaseActive: {
    color: TEAL,
    fontWeight: '800',
  },
});
