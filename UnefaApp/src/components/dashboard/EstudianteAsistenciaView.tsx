import React, { useState } from 'react';
import { View, Text, Pressable, StyleSheet } from 'react-native';
import {
  ListChecks,
  CheckCircle2,
  Clock,
  Calendar,
  FileCheck2,
  AlertTriangle,
} from 'lucide-react-native';
import { UnefaColors } from '@/constants/theme';
import { RoleConfig } from './types';
import { MetricsGrid } from './MetricsGrid';

interface EstudianteAsistenciaViewProps {
  config: RoleConfig;
}

const SUBJECTS = [
  { code: 'SIS-701', name: 'Sistemas Distribuidos', prof: 'Prof. Elena Rivas Méndez', room: 'Lab Telemática 2', attendance: '96%', hours: '24/25 asistidas', status: 'Solvente' },
  { code: 'CIB-702', name: 'Ciberseguridad y Soberanía Nacional', prof: 'Prof. Carlos Morales', room: 'Aula A-04', attendance: '100%', hours: '20/20 asistidas', status: 'Solvente' },
  { code: 'TEL-703', name: 'Redes de Computadoras II', prof: 'Prof. Luis Sánchez', room: 'Aula C-10', attendance: '88%', hours: '22/25 asistidas', status: 'Solvente' },
  { code: 'PRY-704', name: 'Metodología y Proyecto Especial', prof: 'Prof. Carmen Gómez', room: 'Aula A-02', attendance: '95%', hours: '19/20 asistidas', status: 'Solvente' },
  { code: 'SOF-705', name: 'Ingeniería de Software Crítico', prof: 'Dr. Marcos Peña', room: 'Lab 3', attendance: '92%', hours: '23/25 asistidas', status: 'Solvente' },
];

export function EstudianteAsistenciaView({ config: _config }: EstudianteAsistenciaViewProps) {
  const [justificationSent, setJustificationSent] = useState(false);

  return (
    <View className="gap-5">
      {/* Encabezado */}
      <View className="bg-white rounded-[18px] p-4 border border-slate-200">
        <View className="flex-row items-center gap-2 mb-1">
          <ListChecks size={18} color={UnefaColors.blue} />
          <Text
            className="text-[10px] font-black tracking-widest uppercase"
            style={{ color: UnefaColors.blue }}>
            CONTROL DE ASISTENCIAS
          </Text>
        </View>
        <Text className="text-lg font-black text-slate-900 mb-1">
          Registro Oficial de Asistencias
        </Text>
        <Text className="text-xs text-slate-500 leading-relaxed">
          Seguimiento consolidado de asistencia por cátedra y estado de solvencia reglamentaria
          para el período 2026-I.
        </Text>
      </View>

      {/* Métricas de Asistencia */}
      <MetricsGrid
        items={[
          { value: '94.5%', label: 'Asistencia global', valueColor: UnefaColors.green },
          { value: '108/115', label: 'Horas asistidas', valueColor: UnefaColors.blue },
          { value: '5', label: 'Cátedras solventes', valueColor: '#0d9488' },
          { value: '0', label: 'Inasistencias críticas', valueColor: UnefaColors.green },
        ]}
      />

      {/* Justificación de inasistencia */}
      {justificationSent ? (
        <View className="flex-row items-center gap-3 bg-emerald-50 border border-emerald-300 rounded-2xl p-4">
          <CheckCircle2 size={20} color="#059669" />
          <View className="flex-1">
            <Text className="text-xs font-black text-emerald-900">
              Solicitud de Justificación Enviada
            </Text>
            <Text className="text-[11px] text-emerald-700">
              Su justificativo fue registrado para revisión por la Coordinación Académica.
            </Text>
          </View>
        </View>
      ) : (
        <View className="bg-white rounded-[18px] p-4 border border-slate-200">
          <View className="flex-row items-center justify-between mb-2">
            <View className="flex-row items-center gap-2">
              <FileCheck2 size={16} color={UnefaColors.blue} />
              <Text className="text-xs font-black text-slate-900">
                Justificación de Inasistencia
              </Text>
            </View>
            <View className="px-2 py-0.5 rounded bg-blue-50">
              <Text className="text-[10px] font-bold text-unefa-blue">Digital</Text>
            </View>
          </View>
          <Text className="text-xs text-slate-500 mb-3 leading-4">
            Si tuviste una falta justificada por motivos de salud o laborales, puedes consignar tu
            comprobante digital.
          </Text>
          <Pressable
            accessibilityRole="button"
            accessibilityLabel="Consignar justificativo de inasistencia"
            onPress={() => setJustificationSent(true)}
            className="py-2.5 px-4 rounded-xl items-center bg-slate-100 border border-slate-300 active:bg-slate-200">
            <Text className="text-xs font-black text-slate-800">
              Consignar Justificativo Médico / Laboral
            </Text>
          </Pressable>
        </View>
      )}

      {/* Listado de Asignaturas */}
      <View className="bg-white rounded-[18px] p-4 border border-slate-200">
        <View className="flex-row justify-between items-start mb-3.5">
          <View>
            <Text className="text-base font-black text-slate-900">
              Asignaturas Inscritas
            </Text>
            <Text className="text-xs text-slate-400">
              Porcentaje acumulado por materia
            </Text>
          </View>
          <View className="flex-row items-center gap-1 bg-green-100 px-2 py-1 rounded-lg">
            <CheckCircle2 size={12} color={UnefaColors.green} />
            <Text className="text-[11px] font-black text-green-700">100% Solvente</Text>
          </View>
        </View>

        {SUBJECTS.map((item, idx) => (
          <View
            key={idx}
            className="bg-slate-50 rounded-2xl p-3.5 mb-2.5 border border-slate-200">
            <View className="flex-row justify-between items-center mb-1.5">
              <View className="bg-slate-200 px-1.5 py-0.5 rounded-md">
                <Text className="text-[10px] font-black text-slate-700 font-mono">
                  {item.code}
                </Text>
              </View>
              <View
                className="px-2 py-0.5 rounded-xl"
                style={{ backgroundColor: 'rgba(4, 15, 217, 0.1)' }}>
                <Text className="text-[11px] font-black" style={{ color: UnefaColors.blue }}>
                  {item.attendance}
                </Text>
              </View>
            </View>

            <Text className="text-sm font-black text-slate-900 mb-0.5">{item.name}</Text>
            <Text className="text-xs text-slate-500 mb-2">{item.prof}</Text>

            <View className="flex-row justify-between items-center pt-2" style={styles.footerBorder}>
              <View className="flex-row items-center gap-1">
                <Clock size={12} color="#64748b" />
                <Text className="text-[11px] font-semibold text-slate-400">{item.room}</Text>
              </View>
              <Text className="text-[11px] font-bold" style={{ color: UnefaColors.blue }}>
                {item.hours}
              </Text>
            </View>
          </View>
        ))}

        <View className="flex-row items-center gap-2 mt-2 pt-2 border-t border-slate-100 justify-center">
          <AlertTriangle size={14} color="#d97706" />
          <Text className="text-[11px] font-semibold text-slate-500">
            Límite mínimo aprobatorio reglamentario: 75% de asistencia
          </Text>
        </View>
      </View>
    </View>
  );
}

const styles = StyleSheet.create({
  footerBorder: {
    borderTopWidth: StyleSheet.hairlineWidth,
    borderTopColor: '#e2e8f0',
  },
});
