import React from 'react';
import { View, Text, Pressable, StyleSheet } from 'react-native';
import { useRouter } from 'expo-router';
import { QrCode, Award, Users, Calendar } from 'lucide-react-native';
import { UnefaColors } from '@/constants/theme';
import { COURSES, getCourseStats } from '@/constants/attendance';
import { MetricsGrid } from './MetricsGrid';

const ACTIONS = [
  { icon: <Award size={20} color="#0d9488" />, title: 'Cargar Calificaciones 1er Corte', sub: 'Plazo de consignación abierto hasta la semana 6' },
  { icon: <Users size={20} color={UnefaColors.blue} />, title: 'Reportar Inasistencias Críticas', sub: 'Notificación preventiva a la Coordinación de Carrera' },
  { icon: <Calendar size={20} color={UnefaColors.goldDark} />, title: 'Planificación Semestral Consolidada', sub: 'Cronograma de evaluaciones, talleres y defensas' },
];

export function ProfesorDashboard() {
  const router = useRouter();
  const totalStudents = COURSES.reduce((acc, c) => acc + c.students.length, 0);
  const totalPresent = COURSES.reduce(
    (acc, c) => acc + getCourseStats(c).present,
    0
  );
  const avgAttendance = `${((totalPresent / totalStudents) * 100).toFixed(1)}%`;

  return (
    <View className="gap-5">
      <MetricsGrid
        items={[
          { value: String(COURSES.length), label: 'Secciones asignadas' },
          { value: String(totalStudents), label: 'Alumnos matriculados' },
          { value: '32', label: 'Clases impartidas', valueColor: '#0d9488' },
          { value: avgAttendance, label: 'Asistencia promedio', valueColor: UnefaColors.green },
        ]}
      />

      {/* Secciones a cargo */}
      <View className="bg-white rounded-[18px] p-4 border border-slate-200">
        <View className="flex-row justify-between items-start mb-3.5">
          <View>
            <Text className="text-[10px] font-black tracking-widest uppercase mb-0.5"
              style={{ color: UnefaColors.blue }}>
              CÁTEDRA ACTIVA
            </Text>
            <Text className="text-base font-black text-slate-900">Secciones</Text>
          </View>
          <View className="px-2 py-1 rounded-lg" style={{ backgroundColor: 'rgba(13, 148, 136, 0.1)' }}>
            <Text className="text-[11px] font-black" style={{ color: '#0d9488' }}>Activas 2026-I</Text>
          </View>
        </View>

        {COURSES.map((course) => {
          const stats = getCourseStats(course);
          return (
            <View key={course.id} className="bg-slate-50 rounded-2xl p-3.5 mb-3 border border-slate-200">
              <View className="flex-row justify-between items-start mb-2">
                <View>
                  <Text className="text-[11px] font-black uppercase" style={{ color: '#0d9488' }}>
                    {course.section}
                  </Text>
                  <Text className="text-[15px] font-black text-slate-900">{course.name}</Text>
                </View>
                <View className="px-2 py-1 rounded-xl items-center"
                  style={{ backgroundColor: 'rgba(13, 148, 136, 0.1)' }}>
                  <Text className="text-[13px] font-black" style={{ color: '#0d9488' }}>
                    {stats.percent}
                  </Text>
                  <Text className="text-[9px] font-bold" style={{ color: '#0d9488' }}>Asistencia</Text>
                </View>
              </View>

              <View className="flex-row flex-wrap gap-2.5 mb-3">
                <Text className="text-[11px] font-semibold text-slate-500">👥 {stats.total} estudiantes</Text>
                <Text className="text-[11px] font-semibold text-slate-500">🕒 {course.schedule}</Text>
                <Text className="text-[11px] font-semibold text-slate-500">📍 {course.room}</Text>
              </View>

              <View className="flex-row gap-2 pt-2.5" style={styles.courseActionBorder}>
                <View className="flex-row items-center gap-1.5 flex-1 justify-center px-3 py-2 rounded-xl"
                  style={{ backgroundColor: UnefaColors.blue }}>
                  <QrCode size={13} color="#ffffff" />
                  <Text className="text-xs font-black text-white">Escanear Asistencia QR</Text>
                </View>
                <Pressable
                  className="bg-white border border-slate-300 px-3 py-2 rounded-xl justify-center active:bg-slate-100"
                  accessibilityRole="button"
                  accessibilityLabel={`Ver planilla de ${course.name}`}
                  onPress={() => router.push(`/actas?course=${course.id}`)}>
                  <Text className="text-xs font-bold text-slate-700">Ver Planilla</Text>
                </Pressable>
              </View>
            </View>
          );
        })}
      </View>

      {/* Herramientas */}
      <View className="bg-white rounded-[18px] p-4 border border-slate-200">
        <Text className="text-[10px] font-black tracking-widest uppercase mb-0.5"
          style={{ color: UnefaColors.blue }}>
          GESTIÓN ACADÉMICA DOCENTE
        </Text>
        <Text className="text-base font-black text-slate-900 mb-2.5">Operaciones de cátedra</Text>
        <View className="gap-2.5 mt-2.5">
          {ACTIONS.map((action, idx) => (
            <View key={idx}
              className="flex-row items-center gap-3 bg-slate-50 rounded-xl p-3 border border-slate-200">
              {action.icon}
              <View className="flex-1">
                <Text className="text-[13px] font-black text-slate-900">{action.title}</Text>
                <Text className="text-[11px] text-slate-400">{action.sub}</Text>
              </View>
            </View>
          ))}
        </View>
      </View>
    </View>
  );
}

const styles = StyleSheet.create({
  courseActionBorder: {
    borderTopWidth: StyleSheet.hairlineWidth,
    borderTopColor: '#e2e8f0',
  },
});
