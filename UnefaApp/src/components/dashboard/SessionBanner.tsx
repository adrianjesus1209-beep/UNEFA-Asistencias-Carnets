import React from 'react';
import { View, Text, Pressable, StyleSheet } from 'react-native';
import {
  GraduationCap,
  BookOpen,
  ClipboardCheck,
  ShieldCheck,
  LogOut,
} from 'lucide-react-native';
import { EntityRole, RoleConfig } from './types';

interface SessionBannerProps {
  activeRole: EntityRole;
  config: RoleConfig;
  onLogout: () => void;
}

const ROLE_ICON: Record<EntityRole, React.ReactNode> = {
  estudiante: <GraduationCap size={28} color="#ffffff" />,
  profesor: <BookOpen size={28} color="#ffffff" />,
  coordinador: <ClipboardCheck size={28} color="#ffffff" />,
  director: <ShieldCheck size={28} color="#ffffff" />,
};

export function SessionBanner({ activeRole, config, onLogout }: SessionBannerProps) {
  return (
    <View
      className="bg-white rounded-[18px] p-[18px] mb-5"
      style={[styles.shadow, { borderWidth: 1.5, borderColor: config.accentColor }]}>

      {/* Top row: status pill + role badge */}
      <View className="flex-row items-center justify-between mb-3.5">
        <View className="flex-row items-center gap-1.5 bg-green-100 px-2.5 py-1 rounded-full">
          <View className="w-[7px] h-[7px] rounded-full bg-green-600" />
          <Text className="text-[10px] font-black text-green-700 tracking-wide">
            SESIÓN ACTIVA
          </Text>
        </View>
        <View className="px-2.5 py-1 rounded-lg" style={{ backgroundColor: config.badgeBg }}>
          <Text className="text-[11px] font-black tracking-wide"
            style={{ color: config.badgeColor }}>
            {config.badge}
          </Text>
        </View>
      </View>

      {/* Profile row */}
      <View className="flex-row gap-3.5 items-center mb-3.5">
        <View
          className="w-[54px] h-[54px] rounded-2xl items-center justify-center"
          style={{ backgroundColor: config.accentColor }}>
          {ROLE_ICON[activeRole]}
        </View>
        <View className="flex-1">
          <Text className="text-base font-black text-slate-900 mb-0.5">{config.name}</Text>
          <Text className="text-[13px] font-bold mb-0.5" style={{ color: config.accentColor }}>
            {config.cedula}
          </Text>
          <Text className="text-xs font-semibold text-slate-500">{config.department}</Text>
          <Text className="text-[11px] text-slate-400 mt-0.5">{config.subtitle}</Text>
        </View>
      </View>

      {/* Footer: matricula + logout */}
      <View className="flex-row items-center justify-between pt-3"
        style={styles.footerBorder}>
        <View className="flex-row items-center gap-1.5">
          <Text className="text-[11px] font-semibold text-slate-400">ID Institucional:</Text>
          <Text className="text-[11px] font-black text-slate-900 font-mono">
            {config.matricula}
          </Text>
        </View>
        <Pressable
          className="flex-row items-center gap-1 py-1 px-2 rounded-md"
          onPress={onLogout}>
          <LogOut size={14} color="#ef4444" />
          <Text className="text-xs font-bold text-red-500">Cerrar sesión</Text>
        </Pressable>
      </View>
    </View>
  );
}

const styles = StyleSheet.create({
  shadow: {
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.05,
    shadowRadius: 8,
    elevation: 3,
  },
  footerBorder: {
    borderTopWidth: StyleSheet.hairlineWidth,
    borderTopColor: '#e2e8f0',
  },
});
