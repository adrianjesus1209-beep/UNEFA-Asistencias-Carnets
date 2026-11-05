import React from 'react';
import { View, Text, StyleSheet, Modal, Pressable } from 'react-native';
import { UnefaColors } from '@/constants/theme';

interface QrModalProps {
  visible: boolean;
  onClose: () => void;
}

export function QrModal({ visible, onClose }: QrModalProps) {
  return (
    <Modal
      visible={visible}
      transparent
      animationType="fade"
      onRequestClose={onClose}>
      <Pressable style={styles.backdrop} onPress={onClose}>
        <Pressable
          style={styles.card}
          onPress={(e) => e.stopPropagation()}>
          <View style={styles.iconWrap}>
            <Text style={styles.cameraIcon}>📷</Text>
          </View>
          <Text style={styles.title}>
            Acceso a la cámara
          </Text>
          <Text style={styles.description}>
            ¿Desea permitir que UNEFA Móvil acceda a la cámara del dispositivo para escanear un código QR?
          </Text>
          <Text style={styles.note}>
            Esta es una interfaz de prueba: la cámara no se activará.
          </Text>
          <View style={styles.actions}>
            <Pressable
              style={[styles.btn, styles.btnOutline]}
              onPress={onClose}>
              <Text style={styles.btnText}>Ahora no</Text>
            </Pressable>
            <Pressable style={[styles.btn, styles.btnGold]} onPress={onClose}>
              <Text style={styles.btnGoldText}>Permitir</Text>
            </Pressable>
          </View>
        </Pressable>
      </Pressable>
    </Modal>
  );
}

const styles = StyleSheet.create({
  backdrop: {
    flex: 1,
    backgroundColor: 'rgba(6, 21, 42, 0.65)',
    justifyContent: 'center',
    alignItems: 'center',
    padding: 24,
  },
  card: {
    width: '100%',
    maxWidth: 360,
    borderRadius: 22,
    padding: 24,
    alignItems: 'center',
    shadowColor: '#06152a',
    shadowOffset: { width: 0, height: 12 },
    shadowOpacity: 0.25,
    shadowRadius: 24,
    elevation: 10,
    backgroundColor: '#ffffff',
  },
  iconWrap: {
    width: 60,
    height: 60,
    borderRadius: 30,
    backgroundColor: UnefaColors.goldSoft,
    alignItems: 'center',
    justifyContent: 'center',
    marginBottom: 16,
  },
  cameraIcon: {
    fontSize: 28,
  },
  title: {
    fontSize: 18,
    fontWeight: '800',
    marginBottom: 10,
    textAlign: 'center',
    color: '#0a0a0a',
  },
  description: {
    fontSize: 14,
    lineHeight: 20,
    textAlign: 'center',
    marginBottom: 12,
    color: '#475569',
  },
  note: {
    fontSize: 12,
    color: UnefaColors.goldDark,
    textAlign: 'center',
    marginBottom: 20,
    fontStyle: 'italic',
  },
  actions: {
    flexDirection: 'row',
    gap: 12,
    width: '100%',
  },
  btn: {
    flex: 1,
    paddingVertical: 12,
    borderRadius: 14,
    alignItems: 'center',
    justifyContent: 'center',
  },
  btnOutline: {
    borderWidth: 1,
    borderColor: '#cbd5e1',
    backgroundColor: 'transparent',
  },
  btnGold: {
    backgroundColor: UnefaColors.gold,
  },
  btnText: {
    fontWeight: '700',
    fontSize: 14,
    color: '#0a0a0a',
  },
  btnGoldText: {
    color: UnefaColors.navy,
    fontWeight: '800',
    fontSize: 14,
  },
});
