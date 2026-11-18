import React from 'react';
import { View, Text } from 'react-native';
import { Building2, QrCode, Users, ShieldCheck } from 'lucide-react-native';
import { UnefaColors } from '@/constants/theme';
import { MetricsGrid } from './MetricsGrid';

const FACULTIES = [
  { fac: 'Facultad de Ingeniería', rate: '96.2%', pct: 96 },
  { fac: 'Facultad de Ciencias Sociales', rate: '93.5%', pct: 93 },
  { fac: 'Técnico Superior Universitario', rate: '95.0%', pct: 95 },
  { fac: 'Curso Integral de Nivelación Universitaria', rate: '97.4%', pct: 97 },
];

const STAT_BOXES = [
  { icon: <Building2 size={22} color={UnefaColors.navy} />, num: '4 Sedes', lbl: 'Extensiones del núcleo operando' },
  { icon: <QrCode size={22} color={UnefaColors.blue} />, num: '3.120 lecturas', lbl: 'Accesos por carnet QR hoy' },
  { icon: <Users size={22} color={UnefaColors.green} />, num: '1.450 raciones', lbl: 'Comedor estudiantil solvente' },
  { icon: <ShieldCheck size={22} color={UnefaColors.goldDark} />, num: '0 Novedades', lbl: 'Doctrina y disciplina militar' },
];

const DIRECTOR_ACTIONS = [
  { title: 'Reporte al Vicerrectorado Académico', desc: 'Consolidado de auditoría semestral y rendimiento de núcleos' },
  { title: 'Auditoría Integral SICEU', desc: 'Supervisión de actas de grado y récord académico nacional' },
  { title: 'Plan Soberanía y Defensa 2026', desc: 'Seguimiento de convenios tecnológicos con la FANB' },
  { title: 'Aprobación de Convocatoria CINU 2026-II', desc: 'Planificación de cupos para bachilleres de nuevo ingreso' },
];

export function DirectorDashboard() {
  return (
    <View className="gap-5">
      <MetricsGrid
        items={[
          { value: '3.450', label: 'Matrícula total núcleo', valueColor: UnefaColors.navy },
          { value: '210', label: 'Personal activo' },
          { value: '95.1%', label: 'Asistencia general', valueColor: UnefaColors.green },
          { value: '100%', label: 'Gratuidad garantizada', valueColor: UnefaColors.goldDark },
        ]}
      />

      {/* Supervisión general */}
      <View className="bg-white rounded-[18px] p-4 border border-slate-200">
        <View className="flex-row justify-between items-start mb-3.5">
          <View>
            <Text className="text-[10px] font-black tracking-widest uppercase mb-0.5"
              style={{ color: UnefaColors.blue }}>
              DIRECCIÓN GENERAL Y MANDO
            </Text>
            <Text className="text-base font-black text-slate-900">
              Supervisión consolidada de sedes
            </Text>
          </View>
          <View className="px-2 py-1 rounded-lg" style={{ backgroundColor: 'rgba(6, 21, 42, 0.1)' }}>
            <Text className="text-[11px] font-black" style={{ color: UnefaColors.navy }}>
              Mando Soberano
            </Text>
          </View>
        </View>

        {/* Asistencia por facultad */}
        <View className="bg-slate-50 rounded-2xl p-3.5 mb-3.5 border border-slate-200">
          <Text className="text-[13px] font-black text-slate-900 mb-3">
            Asistencia consolidada por facultad
          </Text>
          {FACULTIES.map((f, i) => (
            <View key={i} className="mb-2.5">
              <View className="flex-row justify-between mb-1">
                <Text className="text-[11px] font-semibold text-slate-700">{f.fac}</Text>
                <Text className="text-[11px] font-black" style={{ color: UnefaColors.navy }}>
                  {f.rate}
                </Text>
              </View>
              <View className="h-2 bg-slate-200 rounded-full overflow-hidden">
                <View
                  className="h-full rounded-full"
                  style={{ width: `${f.pct}%`, backgroundColor: UnefaColors.navy }}
                />
              </View>
            </View>
          ))}
        </View>

        {/* Stat boxes */}
        <View className="flex-row flex-wrap gap-2.5">
          {STAT_BOXES.map((box, idx) => (
            <View key={idx}
              className="flex-1 min-w-[45%] bg-slate-50 rounded-2xl p-3 border border-slate-200 items-center">
              {box.icon}
              <Text className="text-base font-black text-slate-900 mt-1.5 mb-0.5">{box.num}</Text>
              <Text className="text-[10px] font-semibold text-slate-400 text-center">{box.lbl}</Text>
            </View>
          ))}
        </View>
      </View>

      {/* Acciones directivas */}
      <View className="bg-white rounded-[18px] p-4 border border-slate-200">
        <Text className="text-[10px] font-black tracking-widest uppercase mb-0.5"
          style={{ color: UnefaColors.blue }}>
          COMANDO INSTITUCIONAL
        </Text>
        <Text className="text-base font-black text-slate-900 mb-2.5">
          Acciones directivas estratégicas
        </Text>
        <View className="gap-2 mt-2.5">
          {DIRECTOR_ACTIONS.map((s, i) => (
            <View key={i} className="bg-slate-50 rounded-xl p-3 border border-slate-200">
              <Text className="text-[13px] font-black text-slate-900 mb-1">{s.title}</Text>
              <Text className="text-[11px] text-slate-400 leading-4">{s.desc}</Text>
            </View>
          ))}
        </View>
      </View>
    </View>
  );
}
