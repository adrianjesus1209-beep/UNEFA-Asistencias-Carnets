import React from 'react';
import { View, Text, StyleSheet, Pressable } from 'react-native';
import { Image } from 'expo-image';
import { useRouter } from 'expo-router';
import { UnefaColors } from '@/constants/theme';

interface HeaderProps {
  subtitle: string;
  showBack?: boolean;
  onMenuPress?: () => void;
}

export function Header({ subtitle, showBack, onMenuPress }: HeaderProps) {
  const router = useRouter();

  return (
    <View style={styles.header}>
      <Pressable
        style={styles.brand}
        onPress={() => router.push('/')}
        accessibilityRole="button"
        accessibilityLabel="Ir al inicio">
        <View style={styles.logoWrap}>
          <Image
            source={require('@/assets/images/unefa-logo.png')}
            style={styles.logo}
            contentFit="contain"
          />
        </View>
        <View style={styles.brandTextWrap}>
          <Text style={styles.brandName}>UNEFA</Text>
          <Text style={styles.brandSub}>{subtitle}</Text>
        </View>
      </Pressable>

      <View style={styles.tools}>
        {showBack && (
          <Pressable
            style={styles.iconBtn}
            onPress={() => router.push('/')}
            accessibilityRole="button"
            accessibilityLabel="Volver al inicio">
            <Text style={styles.backArrow}>←</Text>
            <Text style={styles.backLabel}>Inicio</Text>
          </Pressable>
        )}

        {onMenuPress && (
          <Pressable
            style={styles.iconBtn}
            onPress={onMenuPress}
            accessibilityRole="button"
            accessibilityLabel="Abrir menú">
            <Text style={styles.menuIcon}>☰</Text>
          </Pressable>
        )}
      </View>
    </View>
  );
}

const styles = StyleSheet.create({
  header: {
    height: 58,
    paddingHorizontal: 16,
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    borderBottomWidth: StyleSheet.hairlineWidth,
    zIndex: 50,
    backgroundColor: '#ffffff',
    borderBottomColor: '#e2e8f0',
  },
  brand: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 10,
  },
  logoWrap: {
    width: 36,
    height: 36,
    borderRadius: 8,
    alignItems: 'center',
    justifyContent: 'center',
    backgroundColor: '#ffffff',
    padding: 2,
    borderWidth: 1,
    borderColor: '#e2e8f0',
  },
  logo: {
    width: 30,
    height: 30,
  },
  brandTextWrap: {
    justifyContent: 'center',
  },
  brandName: {
    fontSize: 16,
    fontWeight: '900',
    letterSpacing: 0.8,
    color: '#0f172a',
  },
  brandSub: {
    fontSize: 10,
    color: '#64748b',
    fontWeight: '600',
    textTransform: 'uppercase',
    letterSpacing: 0.3,
  },
  tools: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 8,
  },
  iconBtn: {
    height: 36,
    paddingHorizontal: 10,
    borderRadius: 18,
    alignItems: 'center',
    justifyContent: 'center',
    flexDirection: 'row',
    gap: 4,
    borderWidth: 1,
    backgroundColor: '#f8fafc',
    borderColor: '#e2e8f0',
  },
  backArrow: {
    fontSize: 14,
    fontWeight: '700',
    color: '#0f172a',
  },
  backLabel: {
    fontSize: 12,
    fontWeight: '700',
    color: '#0f172a',
  },
  menuIcon: {
    fontSize: 18,
    fontWeight: '700',
    color: '#0f172a',
  },
});
