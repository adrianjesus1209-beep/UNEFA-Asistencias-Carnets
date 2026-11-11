import React from 'react';
import { View, Text, Modal, Pressable } from 'react-native';
import { UnefaColors } from '@/constants/theme';
import { Camera } from 'lucide-react-native';

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
      <Pressable
        className="flex-1 items-center justify-center bg-[rgba(6,21,42,0.65)] p-6"
        onPress={onClose}>
        <Pressable
          className="w-full max-w-[360px] items-center rounded-[22px] bg-white p-6 shadow-2xl"
          onPress={(e) => e.stopPropagation()}>
          <View className="mb-4 h-[60px] w-[60px] items-center justify-center rounded-full bg-[rgba(242,184,7,0.16)]">
            <Camera size={28} color={UnefaColors.goldDark} strokeWidth={2.2} />
          </View>
          <Text className="mb-2.5 text-center text-lg font-extrabold text-neutral-950">
            Acceso a la cámara
          </Text>
          <Text className="mb-3 text-center text-sm leading-5 text-slate-600">
            ¿Desea permitir que UNEFA Móvil acceda a la cámara del dispositivo para escanear un código QR?
          </Text>
          <Text className="mb-5 text-center text-xs italic text-unefa-goldDark">
            Esta es una interfaz de prueba: la cámara no se activará.
          </Text>
          <View className="w-full flex-row gap-3">
            <Pressable
              className="flex-1 items-center justify-center rounded-[14px] border border-slate-300 py-3"
              onPress={onClose}>
              <Text className="text-sm font-bold text-neutral-950">Ahora no</Text>
            </Pressable>
            <Pressable
              className="flex-1 items-center justify-center rounded-[14px] bg-unefa-gold py-3"
              onPress={onClose}>
              <Text className="text-sm font-extrabold text-unefa-navy">
                Permitir
              </Text>
            </Pressable>
          </View>
        </Pressable>
      </Pressable>
    </Modal>
  );
}
