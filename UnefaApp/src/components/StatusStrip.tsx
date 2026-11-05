import React from 'react';
import { View, Text, StyleSheet } from 'react-native';
import { UnefaColors } from '@/constants/theme';

interface StatusStripProps {
  label: string;
  sublabel: string;
  statusText: string;
}

export function StatusStrip({ label, sublabel, statusText }: StatusStripProps) {
  return (
    <View style={styles.container}>
      <View style={styles.left}>
        <Text style={styles.boldText}>{label}</Text>
        <Text style={styles.subText}> · {sublabel}</Text>
      </View>
      <View style={styles.right}>
        <View style={styles.liveDot} />
        <Text style={styles.statusText}>{statusText}</Text>
      </View>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    paddingHorizontal: 16,
    paddingVertical: 7,
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    borderBottomWidth: StyleSheet.hairlineWidth,
    backgroundColor: '#f1f5f9',
    borderBottomColor: '#e2e8f0',
  },
  left: {
    flexDirection: 'row',
    alignItems: 'center',
  },
  right: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 6,
  },
  liveDot: {
    width: 6,
    height: 6,
    borderRadius: 3,
    backgroundColor: '#10b981',
  },
  boldText: {
    fontWeight: '800',
    fontSize: 11,
    letterSpacing: 0.3,
    color: '#0f172a',
  },
  subText: {
    fontSize: 11,
    fontWeight: '500',
    color: '#64748b',
  },
  statusText: {
    fontSize: 11,
    fontWeight: '600',
    color: '#64748b',
  },
});
