import React from 'react';
import { View, Text, StyleSheet } from 'react-native';
import { UnefaColors } from '@/constants/theme';

interface PreviewBarProps {
  viewName: string;
}

export function PreviewBar({ viewName }: PreviewBarProps) {
  return (
    <View style={styles.bar}>
      <View style={styles.left}>
        <View style={styles.dot} />
        <Text style={styles.boldText}>Propuesta móvil · Clay</Text>
      </View>
      <Text style={styles.rightText}>{viewName}</Text>
    </View>
  );
}

const styles = StyleSheet.create({
  bar: {
    backgroundColor: UnefaColors.navy,
    paddingHorizontal: 16,
    paddingVertical: 6,
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    zIndex: 100,
  },
  left: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 6,
  },
  dot: {
    width: 7,
    height: 7,
    borderRadius: 4,
    backgroundColor: '#10b981',
  },
  boldText: {
    color: '#f8fafc',
    fontSize: 11,
    fontWeight: '700',
    letterSpacing: 0.2,
  },
  rightText: {
    color: '#94a3b8',
    fontSize: 11,
    fontWeight: '500',
  },
});

