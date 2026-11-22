import React from 'react';
import { View, Text } from 'react-native';

export interface MetricItem {
  value: string;
  label: string;
  valueColor?: string;
}

interface MetricsGridProps {
  items: MetricItem[];
}

export function MetricsGrid({ items }: MetricsGridProps) {
  return (
    <View className="flex-row flex-wrap gap-2.5">
      {items.map((item, idx) => (
        <View
          key={idx}
          className="flex-1 min-w-[45%] bg-slate-50 rounded-2xl p-3.5 border border-slate-200 items-center">
          <Text
            className="text-[22px] font-black text-slate-900 mb-1"
            style={item.valueColor ? { color: item.valueColor } : undefined}>
            {item.value}
          </Text>
          <Text className="text-[11px] font-semibold text-slate-400 text-center">
            {item.label}
          </Text>
        </View>
      ))}
    </View>
  );
}
