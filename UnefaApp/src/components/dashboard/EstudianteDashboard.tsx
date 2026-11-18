import React from 'react';
import { View, Text, StyleSheet } from 'react-native';
import { User, QrCode, CheckCircle2, Clock, ChevronRight } from 'lucide-react-native';
import { UnefaColors } from '@/constants/theme';
import { RoleConfig } from './types';
import { MetricsGrid } from './MetricsGrid';

interface EstudianteDashboardProps {
  config: RoleConfig;
}

const SUBJECTS = [
  { code: 'SIS-701', name: 'Sistemas Distribuidos', prof: 'Prof. Elena Rivas Méndez', room: 'Lab Telemática 2', attendance: '96%', hours: '24/25 asistidas' },
  { code: 'CIB-702', name: 'Ciberseguridad y Soberanía Nacional', prof: 'Prof. Carlos Morales', room: 'Aula A-04', attendance: '100%', hours: '20/20 asistidas' },
  { code: 'TEL-703', name: 'Redes de Computadoras II', prof: 'Prof. Luis Sánchez', room: 'Aula C-10', attendance: '88%', hours: '22/25 asistidas' },
  { code: 'PRY-704', name: 'Metodología y Proyecto Especial', prof: 'Prof. Carmen Gómez', room: 'Aula A-02', attendance: '95%', hours: '19/20 asistidas' },
  { code: 'SOF-705', name: 'Ingeniería de Software Crítico', prof: 'Dr. Marcos Peña', room: 'Lab 3', attendance: '92%', hours: '23/25 asistidas' },
];

const SERVICES = [
  { title: 'Constancia de Estudio', desc: 'Descarga inmediata con firma digital y sello QR' },
  { title: 'Récord de Calificaciones', desc: 'Historial acumulado y promedio ponderado' },
  { title: 'Horario Semanal 2026-I', desc: 'Distribución de bloques por aula y laboratorio' },
  { title: 'Justificar Inasistencia', desc: 'Consignación digital de justificativo médico/laboral' },
];

export function EstudianteDashboard({ config }: EstudianteDashboardProps) {
  return (
    <View className="gap-5">
      {/* Carnet Digital */}
      <View className="rounded-[18px] p-4 border"
        style={{ backgroundColor: UnefaColors.navy, borderColor: 'rgba(242, 184, 7, 0.4)' }}>
        {/* Carnet header */}
        <View className="flex-row justify-between pb-2.5 mb-3.5"
          style={styles.carnetHeaderBorder}>
          <View className="flex-1">
            <Text className="text-[8px] font-black tracking-wide text-slate-300">
              REPÚBLICA BOLIVARIANA DE VENEZUELA
            </Text>
            <Text className="text-[7px] text-slate-400 tracking-wide">
              MINISTERIO DEL PODER POPULAR PARA LA DEFENSA
            </Text>
            <Text className="text-[11px] font-black tracking-wide mt-0.5"
              style={{ color: UnefaColors.gold }}>
              UNEFA · CARNET DE ASISTENCIA DIGITAL
            </Text>
          </View>
          <View className="px-2 py-0.5 rounded-md self-start"
            style={{ backgroundColor: UnefaColors.gold }}>
            <Text className="text-[11px] font-black" style={{ color: UnefaColors.navy }}>
              2026-I
            </Text>
          </View>
        </View>

        {/* Carnet body */}
        <View className="flex-row gap-3.5">
          <View className="w-[78px] h-24 rounded-xl bg-white items-center justify-center border-2 p-1"
            style={{ borderColor: UnefaColors.gold }}>
            <User size={38} color="#64748b" />
            <Text className="text-[8px] font-black text-slate-500 text-center mt-1">
              FOTO ESTUDIANTE
            </Text>
          </View>
          <View className="flex-1">
            <Text className="text-[13px] font-black text-white mb-0.5">{config.name}</Text>
            <Text className="text-xs font-black mb-0.5" style={{ color: UnefaColors.gold }}>
              {config.cedula}
            </Text>
            <Text className="text-[10px] font-bold text-slate-300 mb-0.5">
              INGENIERÍA DE SISTEMAS
            </Text>
            <Text className="text-[9px] font-black text-emerald-400 mb-2">
              CONDICIÓN: REGULAR ACTIVO
            </Text>
            {/* QR row */}
            <View className="flex-row items-center gap-2 bg-white rounded-lg p-1">
              <View className="w-11 h-11 items-center justify-center">
                <QrCode size={40} color={UnefaColors.navy} />
              </View>
              <View className="flex-1">
                <Text className="text-[10px] font-bold text-slate-900 font-mono tracking-widest">
                  ||| | |||| || ||| |||| | |||
                </Text>
                <Text className="text-[8px] font-bold text-slate-400 font-mono">
                  MAT: 2022-04921-SICEU
                </Text>
              </View>
            </View>
          </View>
        </View>
      </View>

      {/* Métricas */}
      <MetricsGrid
        items={[
          { value: '7mo', label: 'Semestre en curso' },
          { value: '6', label: 'Materias inscritas' },
          { value: '17.42', label: 'Promedio general', valueColor: UnefaColors.blue },
          { value: '94.5%', label: 'Asistencia global', valueColor: UnefaColors.green },
        ]}
      />

      {/* Asignaturas */}
      <View className="bg-white rounded-[18px] p-4 border border-slate-200">
        <View className="flex-row justify-between items-start mb-3.5">
          <View>
            <Text className="text-[10px] font-black tracking-widest uppercase mb-0.5"
              style={{ color: UnefaColors.blue }}>
              CONTROL DE ASISTENCIAS
            </Text>
            <Text className="text-base font-black text-slate-900">Mis asignaturas inscritas</Text>
          </View>
          <View className="flex-row items-center gap-1 bg-green-100 px-2 py-1 rounded-lg">
            <CheckCircle2 size={12} color={UnefaColors.green} />
            <Text className="text-[11px] font-black text-green-700">Solvente</Text>
          </View>
        </View>

        {SUBJECTS.map((item, idx) => (
          <View key={idx} className="bg-slate-50 rounded-2xl p-3.5 mb-2.5 border border-slate-200">
            <View className="flex-row justify-between items-center mb-1.5">
              <View className="bg-slate-200 px-1.5 py-0.5 rounded-md">
                <Text className="text-[10px] font-black text-slate-700 font-mono">{item.code}</Text>
              </View>
              <View className="px-2 py-0.5 rounded-xl" style={{ backgroundColor: 'rgba(4, 15, 217, 0.1)' }}>
                <Text className="text-[11px] font-black" style={{ color: UnefaColors.blue }}>
                  {item.attendance}
                </Text>
              </View>
            </View>
            <Text className="text-sm font-black text-slate-900 mb-0.5">{item.name}</Text>
            <Text className="text-xs text-slate-500 mb-2">{item.prof}</Text>
            <View className="flex-row justify-between items-center pt-2"
              style={styles.subjectFooterBorder}>
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
      </View>

      {/* Trámites */}
      <View className="bg-white rounded-[18px] p-4 border border-slate-200">
        <Text className="text-[10px] font-black tracking-widest uppercase mb-0.5"
          style={{ color: UnefaColors.blue }}>
          TRÁMITES Y CONSTANCIAS
        </Text>
        <Text className="text-base font-black text-slate-900 mb-2.5">
          Servicios digitales disponibles
        </Text>
        <View className="gap-2 mt-2.5">
          {SERVICES.map((s, i) => (
            <View key={i} className="bg-slate-50 rounded-xl p-3 border border-slate-200">
              <View className="flex-row justify-between items-center mb-1">
                <Text className="text-[13px] font-black text-slate-900">{s.title}</Text>
                <ChevronRight size={16} color={UnefaColors.blue} />
              </View>
              <Text className="text-[11px] text-slate-400 leading-4">{s.desc}</Text>
            </View>
          ))}
        </View>
      </View>
    </View>
  );
}

const styles = StyleSheet.create({
  carnetHeaderBorder: {
    borderBottomWidth: 1,
    borderBottomColor: 'rgba(255, 255, 255, 0.15)',
  },
  subjectFooterBorder: {
    borderTopWidth: StyleSheet.hairlineWidth,
    borderTopColor: '#e2e8f0',
  },
});
