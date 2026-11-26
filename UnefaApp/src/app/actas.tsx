import React from 'react';
import { View, Text, Pressable, ScrollView } from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';
import { useLocalSearchParams, useRouter } from 'expo-router';
import { ClipboardList, CheckCircle2, XCircle } from 'lucide-react-native';
import { UnefaColors } from '@/constants/theme';
import { COURSES, Student, getCourseStats } from '@/constants/attendance';
import { Header } from '@/components/Header';
import { MetricsGrid } from '@/components/dashboard/MetricsGrid';

function StatusChip({ status }: { status: Student['status'] }) {
  const isPresent = status === 'asistente';
  return (
    <View
      className="px-2.5 py-1 rounded-full flex-row items-center gap-1"
      style={{ backgroundColor: isPresent ? UnefaColors.greenSoft : 'rgba(217, 41, 41, 0.1)' }}>
      {isPresent ? (
        <CheckCircle2 size={12} color={UnefaColors.green} />
      ) : (
        <XCircle size={12} color={UnefaColors.red} />
      )}
      <Text
        className="text-[10px] font-black uppercase tracking-wide"
        style={{ color: isPresent ? UnefaColors.green : UnefaColors.red }}>
        {isPresent ? 'Asistente' : 'Inasistente'}
      </Text>
    </View>
  );
}

export default function ActasScreen() {
  const router = useRouter();
  const params = useLocalSearchParams<{ course?: string }>();

  // La materia seleccionada vive en los params para que "Ver Planilla" pueda preseleccionarla.
  const course =
    COURSES.find((c) => c.id === params.course) ?? COURSES[0];
  const { total, present, absent } = getCourseStats(course);

  const selectCourse = (id: string) => router.setParams({ course: id });

  return (
    <SafeAreaView className="flex-1 bg-white">
      <Header subtitle="Actas de asistencia" showBack={true} />

      <ScrollView
        className="flex-1"
        contentContainerStyle={{ paddingBottom: 40 }}
        showsVerticalScrollIndicator={false}>
        <View className="w-full px-4 pt-4" style={{ maxWidth: 480 }}>
          {/* Título */}
          <View className="flex-row items-center gap-3 mb-4">
            <View
              className="w-11 h-11 rounded-2xl items-center justify-center"
              style={{ backgroundColor: 'rgba(13, 148, 136, 0.1)' }}>
              <ClipboardList size={22} color="#0d9488" />
            </View>
            <View className="flex-1">
              <Text
                className="text-[10px] font-black tracking-widest uppercase mb-0.5"
                style={{ color: UnefaColors.blue }}>
                SESIÓN DOCENTE 2026-I
              </Text>
              <Text className="text-base font-black text-slate-900">Actas de Asistencia</Text>
            </View>
          </View>

          {/* Selector de materia */}
          <Text className="text-[11px] font-black uppercase tracking-wide text-slate-400 mb-2">
            Materia
          </Text>
          <ScrollView
            horizontal
            showsHorizontalScrollIndicator={false}
            contentContainerStyle={{ gap: 8, paddingRight: 16 }}
            className="mb-4">
            {COURSES.map((c) => {
              const isActive = c.id === course.id;
              return (
                <Pressable
                  key={c.id}
                  onPress={() => selectCourse(c.id)}
                  accessibilityRole="button"
                  accessibilityState={{ selected: isActive }}
                  className={`px-3.5 py-2 rounded-xl border ${
                    isActive ? 'border-transparent' : 'border-slate-200 bg-white'
                  }`}
                  style={isActive ? { backgroundColor: '#0d9488' } : undefined}>
                  <Text
                    className={`text-[12px] font-black ${isActive ? 'text-white' : 'text-slate-600'}`}>
                    {c.section}
                  </Text>
                </Pressable>
              );
            })}
          </ScrollView>

          {/* Datos de la sesión */}
          <View className="bg-white rounded-[18px] p-4 border border-slate-200 mb-4">
            <View className="flex-row justify-between items-start mb-3">
              <View className="flex-1 pr-3">
                <Text
                  className="text-[11px] font-black uppercase mb-0.5"
                  style={{ color: '#0d9488' }}>
                  {course.section}
                </Text>
                <Text className="text-[15px] font-black text-slate-900">{course.name}</Text>
              </View>
              <View className="px-2 py-1 rounded-xl" style={{ backgroundColor: 'rgba(13, 148, 136, 0.1)' }}>
                <Text className="text-[11px] font-black" style={{ color: '#0d9488' }}>
                  {course.room}
                </Text>
              </View>
            </View>
            <Text className="text-[11px] font-semibold text-slate-500">🕒 {course.schedule}</Text>
          </View>

          {/* Resumen */}
          <MetricsGrid
            items={[
              { value: String(total), label: 'Estudiantes en lista' },
              { value: String(present), label: 'Asistentes', valueColor: UnefaColors.green },
              { value: String(absent), label: 'Inasistentes', valueColor: UnefaColors.red },
            ]}
          />

          {/* Tabla de estudiantes */}
          <View className="bg-white rounded-[18px] border border-slate-200 mt-4 overflow-hidden">
            <View className="flex-row items-center gap-2 px-3.5 py-3 bg-slate-50 border-b border-slate-200">
              <Text className="w-5 text-[10px] font-black uppercase tracking-wide text-slate-400">#</Text>
              <Text
                className="flex-1 text-[10px] font-black uppercase tracking-wide"
                style={{ color: UnefaColors.blue }}>
                Estudiante
              </Text>
              <Text className="text-[10px] font-black uppercase tracking-wide text-slate-400">
                Estado
              </Text>
            </View>

            {course.students.map((student, idx) => (
              <View
                key={student.id}
                className={`flex-row items-center gap-2 px-3.5 py-3 ${
                  idx % 2 === 1 ? 'bg-slate-50' : 'bg-white'
                }`}
                style={{
                  borderBottomWidth: idx === course.students.length - 1 ? 0 : 1,
                  borderBottomColor: '#e2e8f0',
                }}>
                <Text className="w-5 text-[12px] font-bold text-slate-400">{idx + 1}</Text>
                <View className="flex-1 pr-2">
                  <Text className="text-[13px] font-black text-slate-900" numberOfLines={2}>
                    {student.name}
                  </Text>
                  <Text className="text-[11px] font-semibold text-slate-400">
                    {student.cedula}
                  </Text>
                </View>
                <StatusChip status={student.status} />
              </View>
            ))}
          </View>

          <Text className="text-[11px] text-slate-400 text-center mt-3">
            Listado de solo lectura · Matrícula oficial 2026-I
          </Text>
        </View>
      </ScrollView>
    </SafeAreaView>
  );
}
