import { UnefaColors } from '@/constants/theme';

export type EntityRole = 'estudiante' | 'profesor' | 'coordinador' | 'director';

export interface RoleConfig {
  id: EntityRole;
  title: string;
  badge: string;
  badgeColor: string;
  badgeBg: string;
  name: string;
  cedula: string;
  department: string;
  subtitle: string;
  matricula: string;
  accentColor: string;
}

export const ROLES_DATA: Record<EntityRole, RoleConfig> = {
  estudiante: {
    id: 'estudiante',
    title: 'Estudiante',
    badge: 'ESTUDIANTE REGULAR',
    badgeColor: UnefaColors.blue,
    badgeBg: 'rgba(4, 15, 217, 0.08)',
    name: 'Carlos Manuel Mendoza Rojas',
    cedula: 'V-28.123.456',
    department: 'Ingeniería de Sistemas · 7mo Semestre',
    subtitle: 'Matrícula Oficial 2026-I · Modalidad Diurna',
    matricula: 'UNEFA-2022-04921',
    accentColor: UnefaColors.blue,
  },
  profesor: {
    id: 'profesor',
    title: 'Profesor',
    badge: 'DOCENTE ORDINARIO',
    badgeColor: '#0d9488',
    badgeBg: 'rgba(13, 148, 136, 0.1)',
    name: 'Prof. Ing. Elena Rivas Méndez',
    cedula: 'V-14.567.890',
    department: 'Dpto. de Informática y Telecomunicaciones',
    subtitle: 'Dedicación Exclusiva · Escalafón Agregado',
    matricula: 'DOC-UNEFA-8812',
    accentColor: '#0d9488',
  },
  coordinador: {
    id: 'coordinador',
    title: 'Coordinador',
    badge: 'COORDINACIÓN DE CARRERA',
    badgeColor: '#b45309',
    badgeBg: 'rgba(180, 83, 9, 0.1)',
    name: 'Dr. Marcos Peña Colmenares',
    cedula: 'V-11.234.567',
    department: 'Coordinación de Ing. Sistemas y Telemática',
    subtitle: 'Decanato Académico · Núcleo Caracas',
    matricula: 'COORD-SIS-2026',
    accentColor: '#b45309',
  },
  director: {
    id: 'director',
    title: 'Director',
    badge: 'DIRECCIÓN GENERAL DE NÚCLEO',
    badgeColor: UnefaColors.navy,
    badgeBg: 'rgba(6, 21, 42, 0.12)',
    name: 'Cnel. Roberto Silva Pacheco',
    cedula: 'V-09.876.543',
    department: 'Dirección General de Núcleo · Decanato Militar',
    subtitle: 'Comando y Gestión Académica Institucional',
    matricula: 'DIR-UNEFA-001',
    accentColor: UnefaColors.navy,
  },
};
