import React from 'react';
import { View, Text, StyleSheet, Pressable, Platform } from 'react-native';
import { useRouter } from 'expo-router';
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

  return (
    <View style={[styles.nav, styles.navLight]}>
      <Pressable
        style={[styles.item, activeTab === 'inicio' && styles.itemActive]}
        onPress={() => {
          if (onPressInicio) onPressInicio();
          else router.push('/');
        }}>
        <Text style={[styles.icon, activeTab === 'inicio' ? styles.iconActive : styles.textDark]}>
          ⌂
        </Text>
        <Text style={[styles.label, activeTab === 'inicio' ? styles.labelActive : styles.subLight]}>
          Inicio
        </Text>
      </Pressable>

      <Pressable
        style={[styles.item, activeTab === 'carreras' && styles.itemActive]}
        onPress={() => {
          if (onPressCarreras) onPressCarreras();
          else router.push('/');
        }}>
        <Text style={[styles.icon, activeTab === 'carreras' ? styles.iconActive : styles.textDark]}>
          🎓
        </Text>
        <Text style={[styles.label, activeTab === 'carreras' ? styles.labelActive : styles.subLight]}>
          Carreras
        </Text>
      </Pressable>

      <Pressable
        style={[styles.item, activeTab === 'cinu' && styles.itemActive]}
        onPress={() => router.push('/registro')}>
        <Text style={[styles.icon, activeTab === 'cinu' ? styles.iconActive : styles.textDark]}>
          📝
        </Text>
        <Text style={[styles.label, activeTab === 'cinu' ? styles.labelActive : styles.subLight]}>
          CINU
        </Text>
      </Pressable>

      <Pressable
        style={[styles.item, activeTab === 'siceu' && styles.itemActive]}
        onPress={() => router.push('/login')}>
        <Text style={[styles.icon, activeTab === 'siceu' ? styles.iconActive : styles.textDark]}>
          👤
        </Text>
        <Text style={[styles.label, activeTab === 'siceu' ? styles.labelActive : styles.subLight]}>
          SICEU
        </Text>
      </Pressable>

      <Pressable
        style={[styles.item, styles.qrItem]}
        onPress={onOpenQr}>
        <View style={styles.qrBadge}>
          <Text style={styles.qrIcon}>▦</Text>
        </View>
        <Text style={[styles.label, styles.qrLabel]}>ScanerQR</Text>
      </Pressable>
    </View>
  );
}

const styles = StyleSheet.create({
  nav: {
    height: 64,
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-around',
    borderTopWidth: StyleSheet.hairlineWidth,
    paddingBottom: Platform.OS === 'ios' ? 12 : 6,
    paddingTop: 6,
    zIndex: 90,
  },
  navLight: {
    backgroundColor: '#ffffff',
    borderTopColor: '#e2e8f0',
  },
  navDark: {
    backgroundColor: '#0d1829',
    borderTopColor: 'rgba(255, 255, 255, 0.1)',
  },
  item: {
    flex: 1,
    alignItems: 'center',
    justifyContent: 'center',
    paddingVertical: 4,
  },
  itemActive: {},
  icon: {
    fontSize: 18,
    marginBottom: 2,
  },
  iconActive: {
    color: UnefaColors.blue,
  },
  label: {
    fontSize: 11,
    fontWeight: '600',
  },
  labelActive: {
    color: UnefaColors.blue,
    fontWeight: '700',
  },
  qrItem: {},
  qrBadge: {
    width: 26,
    height: 26,
    borderRadius: 7,
    backgroundColor: UnefaColors.gold,
    alignItems: 'center',
    justifyContent: 'center',
    marginBottom: 2,
  },
  qrIcon: {
    fontSize: 14,
    color: UnefaColors.navy,
    fontWeight: '900',
  },
  qrLabel: {
    color: UnefaColors.goldDark,
    fontWeight: '700',
  },
  textLight: {
    color: '#cbd5e1',
  },
  textDark: {
    color: '#475569',
  },
  subLight: {
    color: '#64748b',
  },
  subDark: {
    color: '#94a3b8',
  },
});

