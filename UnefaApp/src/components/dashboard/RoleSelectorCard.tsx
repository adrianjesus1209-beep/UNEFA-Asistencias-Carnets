import React from 'react';
import { View, Text, Pressable } from 'react-native';
import { Sparkles } from 'lucide-react-native';
import { UnefaColors } from '@/constants/theme';
import { EntityRole, ROLES_DATA } from './types';

interface RoleSelectorCardProps {
  activeRole: EntityRole;
  onSelect: (role: EntityRole) => void;
}

const ROLE_EMOJI: Record<EntityRole, string> = {
  estudiante: '🎓 ',
  profesor: '👨‍🏫 ',
  coordinador: '📋 ',
  director: '🏛️ ',
};

export function RoleSelectorCard({ activeRole, onSelect }: RoleSelectorCardProps) {
  return (
    <View className="bg-slate-50 rounded-2xl p-3.5 mb-4 border border-slate-200">
      {/* Header */}
      <View className="mb-2.5">
        <View className="flex-row items-center gap-1 self-start px-2 py-0.5 rounded-md mb-1.5"
          style={{ backgroundColor: UnefaColors.goldSoft }}>
          <Sparkles size={13} color={UnefaColors.navy} />
          <Text className="text-[10px] font-black tracking-widest"
            style={{ color: UnefaColors.navy }}>
            MÓDULOS DE EVALUACIÓN
          </Text>
        </View>
        <Text className="text-xs font-bold text-slate-500">
          Cambiar vista de entidad:
        </Text>
      </View>

      {/* Role chips */}
      <View className="flex-row flex-wrap gap-1.5">
        {(Object.keys(ROLES_DATA) as EntityRole[]).map((r) => {
          const isSelected = activeRole === r;
          return (
            <Pressable
              key={r}
              className={`py-2 px-3 rounded-xl border ${
                isSelected
                  ? 'border-unefa-navy bg-unefa-navy'
                  : 'border-slate-300 bg-white'
              }`}
              onPress={() => onSelect(r)}>
              <Text
                className={`text-xs font-bold ${
                  isSelected ? 'text-white' : 'text-slate-700'
                }`}>
                {ROLE_EMOJI[r]}{ROLES_DATA[r].title}
              </Text>
            </Pressable>
          );
        })}
      </View>
    </View>
  );
}
