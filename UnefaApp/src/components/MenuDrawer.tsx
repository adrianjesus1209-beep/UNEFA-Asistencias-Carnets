import React, { useEffect, useRef, useState } from 'react';
import {
  View,
  Text,
  Modal,
  Pressable,
  ScrollView,
  Animated,
  useWindowDimensions,
} from 'react-native';
import { Image } from 'expo-image';
import { useRouter } from 'expo-router';
import { UnefaColors } from '@/constants/theme';
import { X, ArrowRight } from 'lucide-react-native';

interface MenuDrawerProps {
  visible: boolean;
  onClose: () => void;
  onNavigateSection?: (sectionId: string) => void;
}

export function MenuDrawer({ visible, onClose, onNavigateSection }: MenuDrawerProps) {
  const router = useRouter();
  const { width: windowWidth } = useWindowDimensions();
  const drawerWidth = windowWidth * 0.85;
  const drawerTranslateX = useRef(new Animated.Value(drawerWidth)).current;
  const backdropOpacity = useRef(new Animated.Value(0)).current;
  const [modalVisible, setModalVisible] = useState(visible);
  const modalMounted = useRef(visible);

  // Mantiene el modal montado hasta completar la entrada o salida lateral.
  useEffect(() => {
    if (visible) {
      modalMounted.current = true;
      setModalVisible(true);
      drawerTranslateX.setValue(drawerWidth);
      backdropOpacity.setValue(0);

      const openingAnimation = Animated.parallel([
        Animated.timing(drawerTranslateX, {
          toValue: 0,
          duration: 260,
          useNativeDriver: true,
        }),
        Animated.timing(backdropOpacity, {
          toValue: 1,
          duration: 220,
          useNativeDriver: true,
        }),
      ]);

      openingAnimation.start();
      return () => openingAnimation.stop();
    }

    if (!modalMounted.current) return;

    const closingAnimation = Animated.parallel([
      Animated.timing(drawerTranslateX, {
        toValue: drawerWidth,
        duration: 260,
        useNativeDriver: true,
      }),
      Animated.timing(backdropOpacity, {
        toValue: 0,
        duration: 220,
        useNativeDriver: true,
      }),
    ]);

    closingAnimation.start(({ finished }) => {
      if (finished) {
        modalMounted.current = false;
        setModalVisible(false);
      }
    });
    return () => closingAnimation.stop();
  }, [backdropOpacity, drawerTranslateX, drawerWidth, visible]);

  const handleLink = (section: string) => {
    onClose();
    if (onNavigateSection) {
      onNavigateSection(section);
    }
  };

  return (
    <Modal visible={modalVisible} transparent animationType="none" onRequestClose={onClose}>
      <Animated.View
        className="flex-1 flex-row bg-[rgba(6,21,42,0.65)]"
        style={{ opacity: backdropOpacity }}>
        <Pressable className="h-full flex-1" onPress={onClose} />
        <Animated.View
          className="h-full bg-white px-5 pb-6 pt-4"
          style={{ width: drawerWidth, transform: [{ translateX: drawerTranslateX }] }}>
          <View className="flex-row items-center justify-between border-b border-slate-300 pb-4">
            <View className="flex-row items-center gap-2.5">
              <View className="h-[34px] w-[34px] items-center justify-center rounded-lg border border-slate-200 bg-white">
                <Image
                  source={require('@/assets/images/unefa-logo.png')}
                  style={{ width: 28, height: 28 }}
                  contentFit="contain"
                />
              </View>
              <View>
                <Text className="text-base font-black text-neutral-950">
                  UNEFA
                </Text>
                <Text className="text-[10px] font-semibold text-slate-500">
                  Menú institucional
                </Text>
              </View>
            </View>
            <Pressable
              className="h-8 w-8 items-center justify-center rounded-full bg-slate-100"
              onPress={onClose}>
              <X size={18} color="#0f172a" strokeWidth={2.5} />
            </Pressable>
          </View>

          <ScrollView className="mt-4 flex-1" showsVerticalScrollIndicator={false}>
            <View className="mb-5 gap-1.5">
              <Pressable
                className="flex-row items-center border-b border-[rgba(148,163,184,0.2)] py-3"
                onPress={() => handleLink('inicio')}>
                <Text className="w-[38px] font-mono text-xs font-bold text-unefa-blue">
                  [01]
                </Text>
                <Text className="flex-1 text-base font-bold text-neutral-950">
                  Inicio
                </Text>
                <ArrowRight size={16} color={UnefaColors.gold} strokeWidth={2.5} />
              </Pressable>

              <Pressable
                className="flex-row items-center border-b border-[rgba(148,163,184,0.2)] py-3"
                onPress={() => handleLink('nosotros')}>
                <Text className="w-[38px] font-mono text-xs font-bold text-unefa-blue">
                  [02]
                </Text>
                <Text className="flex-1 text-base font-bold text-neutral-950">
                  Doctrina
                </Text>
                <ArrowRight size={16} color={UnefaColors.gold} strokeWidth={2.5} />
              </Pressable>

              <Pressable
                className="flex-row items-center border-b border-[rgba(148,163,184,0.2)] py-3"
                onPress={() => handleLink('carreras')}>
                <Text className="w-[38px] font-mono text-xs font-bold text-unefa-blue">
                  [03]
                </Text>
                <Text className="flex-1 text-base font-bold text-neutral-950">
                  Carreras
                </Text>
                <ArrowRight size={16} color={UnefaColors.gold} strokeWidth={2.5} />
              </Pressable>

              <Pressable
                className="flex-row items-center border-b border-[rgba(148,163,184,0.2)] py-3"
                onPress={() => handleLink('admisiones')}>
                <Text className="w-[38px] font-mono text-xs font-bold text-unefa-blue">
                  [04]
                </Text>
                <Text className="flex-1 text-base font-bold text-neutral-950">
                  Admisiones CINU
                </Text>
                <ArrowRight size={16} color={UnefaColors.gold} strokeWidth={2.5} />
              </Pressable>

              <Pressable
                className="flex-row items-center border-b border-[rgba(148,163,184,0.2)] py-3"
                onPress={() => handleLink('servicios')}>
                <Text className="w-[38px] font-mono text-xs font-bold text-unefa-blue">
                  [05]
                </Text>
                <Text className="flex-1 text-base font-bold text-neutral-950">
                  Servicios
                </Text>
                <ArrowRight size={16} color={UnefaColors.gold} strokeWidth={2.5} />
              </Pressable>
            </View>

            <View className="mb-5 rounded-2xl border border-slate-200 bg-slate-50 p-4">
              <Text className="mb-1.5 text-[11px] font-extrabold uppercase text-unefa-blue">
                [+] Institución
              </Text>
              <Text className="mb-3 text-xs leading-[18px] text-slate-600">
                Formación politécnica, investigación aplicada y doctrina cívico-militar al servicio de la República.
              </Text>
              <View className="flex-row gap-4">
                <View className="flex-1 items-center rounded-[10px] bg-white/15 p-2">
                  <Text className="text-base font-black text-neutral-950">
                    100%
                  </Text>
                  <Text className="text-[10px] font-semibold text-slate-500">
                    Gratuidad
                  </Text>
                </View>
                <View className="flex-1 items-center rounded-[10px] bg-white/15 p-2">
                  <Text className="text-base font-black text-neutral-950">
                    24
                  </Text>
                  <Text className="text-[10px] font-semibold text-slate-500">
                    Estados
                  </Text>
                </View>
              </View>
            </View>

            <View className="mb-5 gap-2.5">
              <Pressable
                className="items-center justify-center rounded-[14px] bg-unefa-gold py-[13px]"
                onPress={() => {
                  onClose();
                  router.push('/registro');
                }}>
                <Text className="text-sm font-extrabold text-unefa-navy">
                  Preinscripción CINU
                </Text>
              </Pressable>
              <Pressable
                className="items-center justify-center rounded-[14px] border border-slate-300 py-[13px]"
                onPress={() => {
                  onClose();
                  router.push('/login');
                }}>
                <Text className="text-sm font-bold text-neutral-950">
                  Portal SICEU
                </Text>
              </Pressable>
            </View>

            <Text className="mb-6 text-center text-[10px] leading-[15px] text-slate-500">
              Periodo académico 2026-I · Presencia en los 24 estados{'\n'}República Bolivariana de Venezuela
            </Text>
          </ScrollView>
        </Animated.View>
      </Animated.View>
    </Modal>
  );
}
