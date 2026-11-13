import React from 'react';
import { View, Text } from 'react-native';
import { UnefaColors } from '@/constants/theme';
import { MetricsGrid } from './MetricsGrid';

const SUPERVISION_ITEMS = [
  { title: 'Asistencia de docentes', val: '20 de 22 docentes en aula', badge: '91% Cumplimiento', desc: 'Registro validado en sistemas y laboratorios de computación.' },
  { title: 'Inasistencia Estudiantil', val: '12 casos en seguimiento', badge: 'Atención requerida', desc: 'Aspirantes y estudiantes con más de 3 ausencias consecutivas.' },
  { title: 'Disponibilidad de Laboratorios', val: '5 salas y laboratorios operativos', badge: '100% Funcional', desc: 'Lab Telemática, Sistemas, Redes, Física y Electrónica en uso.' },
  { title: 'Consignación de Actas y Cortes', val: '18 de 24 actas registradas', badge: 'En progreso', desc: 'Cierre de actas parciales de evaluación continua 2026-I.' },
];

const COORD_ACTIONS = [
  { title: 'Asignación de Carga Académica', desc: 'Distribución de horas docentes y aprobación de horarios' },
  { title: 'Validación de Jurados de Grado', desc: 'Aprobación de Trabajos Especiales de Grado (TEG)' },
  { title: 'Solicitudes de Cambio de Sección', desc: '5 solicitudes pendientes por cupo y compatibilidad' },
  { title: 'Reporte al Decanato Académico', desc: 'Informe mensual de rendimiento y retención estudiantil' },
];

export function CoordinadorDashboard() {
  return (
    <View className="gap-5">
      <MetricsGrid
        items={[
          { value: '645', label: 'Matrícula carrera' },
          { value: '22', label: 'Docentes adscritos' },
          { value: '24', label: 'Secciones activas', valueColor: '#b45309' },
          { value: '93.8%', label: 'Asistencia global', valueColor: UnefaColors.green },
        ]}
      />

      {/* Supervisión en tiempo real */}
      <View className="bg-white rounded-[18px] p-4 border border-slate-200">
        <View className="flex-row justify-between items-start mb-3.5">
          <View>
            <Text className="text-[10px] font-black tracking-widest uppercase mb-0.5"
              style={{ color: UnefaColors.blue }}>
              SUPERVISIÓN DE CARRERA
            </Text>
            <Text className="text-base font-black text-slate-900">cátedras y docentes</Text>
          </View>
          <View className="px-2 py-1 rounded-lg" style={{ backgroundColor: 'rgba(180, 83, 9, 0.1)' }}>
            <Text className="text-[11px] font-black text-amber-700">Guacara · Activo</Text>
          </View>
        </View>

        {SUPERVISION_ITEMS.map((item, idx) => (
          <View key={idx} className="bg-slate-50 rounded-2xl p-3.5 mb-2.5 border border-slate-200">
            <View className="flex-row justify-between items-center mb-1.5">
              <Text className="text-[13px] font-black text-slate-900">{item.title}</Text>
              <View className="px-2 py-0.5 rounded-lg" style={{ backgroundColor: 'rgba(180, 83, 9, 0.1)' }}>
                <Text className="text-[10px] font-black text-amber-700">{item.badge}</Text>
              </View>
            </View>
            <Text className="text-[15px] font-black text-amber-700 mb-1">{item.val}</Text>
            <Text className="text-[11px] text-slate-500 leading-4">{item.desc}</Text>
          </View>
        ))}
      </View>

      {/* Acciones */}
      <View className="bg-white rounded-[18px] p-4 border border-slate-200">
        <Text className="text-[10px] font-black tracking-widest uppercase mb-0.5"
          style={{ color: UnefaColors.blue }}>
          GESTIÓN DEPARTAMENTAL
        </Text>
        <Text className="text-base font-black text-slate-900 mb-2.5">Acciones de carrera</Text>
        <View className="gap-2 mt-2.5">
          {COORD_ACTIONS.map((s, i) => (
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
