import React from 'react';
import { View, Text, Pressable } from 'react-native';
import { Image } from 'expo-image';
import { useRouter } from 'expo-router';
import { ArrowLeft, Menu } from 'lucide-react-native';

interface HeaderProps {
  subtitle: string;
  showBack?: boolean;
  onMenuPress?: () => void;
}

export function Header({ subtitle, showBack, onMenuPress }: HeaderProps) {
  const router = useRouter();

  const handleGoHome = () => {
    if (router.canGoBack()) {
      router.back();
    } else {
      router.replace('/landing');
    }
  };

  return (
    <View className="h-[58px] px-4 flex-row items-center justify-between bg-white border-b border-slate-200 z-50">
      <Pressable
        className="flex-row items-center gap-2.5"
        onPress={handleGoHome}
        accessibilityRole="button"
        accessibilityLabel="Ir al inicio">
        <View className="w-9 h-9 rounded-lg items-center justify-center bg-white p-0.5 border border-slate-200">
          <Image
            source={require('@/assets/images/unefa-logo.png')}
            style={{ width: 30, height: 30 }}
            contentFit="contain"
          />
        </View>
        <View className="justify-center">
          <Text className="text-base font-black tracking-wider text-slate-900">
            UNEFA
          </Text>
          <Text className="text-[10px] text-slate-500 font-semibold uppercase tracking-wide">
            {subtitle}
          </Text>
        </View>
      </Pressable>

      <View className="flex-row items-center gap-2">
        {showBack && (
          <Pressable
            className="h-9 px-3 rounded-full items-center justify-center flex-row gap-1.5 border border-slate-200 bg-slate-50 active:bg-slate-100"
            hitSlop={8}
            onPress={handleGoHome}
            accessibilityRole="button"
            accessibilityLabel="Volver al inicio">
            <ArrowLeft size={15} color="#0f172a" strokeWidth={2.5} />
            <Text className="text-xs font-bold text-slate-900">Inicio</Text>
          </Pressable>
        )}

        {onMenuPress && (
          <Pressable
            className="w-9 h-9 rounded-full items-center justify-center border border-slate-200 bg-slate-50 active:bg-slate-100"
            hitSlop={8}
            onPress={onMenuPress}
            accessibilityRole="button"
            accessibilityLabel="Abrir menú">
            <Menu size={18} color="#0f172a" strokeWidth={2.5} />
          </Pressable>
        )}
      </View>
    </View>
  );
}