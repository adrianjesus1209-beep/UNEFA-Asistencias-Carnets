import React from 'react';
import { View, Text } from 'react-native';

interface PreviewBarProps {
  viewName: string;
}

export function PreviewBar({ viewName }: PreviewBarProps) {
  return (
    <View className="z-[100] flex-row items-center justify-between bg-unefa-navy px-4 py-1.5">
      <View className="flex-row items-center gap-1.5">
        <View className="h-[7px] w-[7px] rounded-full bg-emerald-500" />
        <Text className="text-[11px] font-bold tracking-[0.2px] text-slate-50">
          Propuesta móvil · Clay
        </Text>
      </View>
      <Text className="text-[11px] font-medium text-slate-400">{viewName}</Text>
    </View>
  );
}
