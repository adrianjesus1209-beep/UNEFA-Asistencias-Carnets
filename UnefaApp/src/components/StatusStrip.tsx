import React from 'react';
import { View, Text } from 'react-native';

interface StatusStripProps {
  label: string;
  sublabel: string;
  statusText: string;
}

export function StatusStrip({ label, sublabel, statusText }: StatusStripProps) {
  return (
    <View className="flex-row items-center justify-between border-b border-slate-200 bg-slate-100 px-4 py-[7px]">
      <View className="flex-row items-center">
        <Text className="text-[11px] font-extrabold tracking-[0.3px] text-slate-900">
          {label}
        </Text>
        <Text className="text-[11px] font-medium text-slate-500">
          {' · '}{sublabel}
        </Text>
      </View>
      <View className="flex-row items-center gap-1.5">
        <View className="h-1.5 w-1.5 rounded-full bg-emerald-500" />
        <Text className="text-[11px] font-semibold text-slate-500">
          {statusText}
        </Text>
      </View>
    </View>
  );
}
