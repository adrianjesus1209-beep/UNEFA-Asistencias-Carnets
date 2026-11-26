export type AttendanceStatus = 'asistente' | 'inasistente';

export interface Student {
  id: string;
  name: string;
  cedula: string;
  status: AttendanceStatus;
}

export interface Course {
  id: string;
  name: string;
  section: string;
  schedule: string;
  room: string;
  students: Student[];
}

export const COURSES: Course[] = [
  {
    id: 'sis-701',
    name: 'Sistemas Distribuidos',
    section: 'Sección SIS-701',
    schedule: 'Lun y Mié 08:00 - 10:15',
    room: 'Lab Telemática 2',
    students: [
      { id: '1', name: 'Carlos Manuel Mendoza Rojas', cedula: 'V-28.123.456', status: 'asistente' },
      { id: '2', name: 'Ana Sofía Castillo Pérez', cedula: 'V-27.456.789', status: 'asistente' },
      { id: '3', name: 'Luis Alejandro Gutiérrez Márquez', cedula: 'V-29.345.678', status: 'inasistente' },
      { id: '4', name: 'María Gabriela Rondón Silva', cedula: 'V-26.789.012', status: 'asistente' },
      { id: '5', name: 'José Gregory Hernández Ruiz', cedula: 'V-30.112.233', status: 'asistente' },
      { id: '6', name: 'Daniela Carolina Peña Torres', cedula: 'V-28.990.887', status: 'inasistente' },
      { id: '7', name: 'Ricardo Andrés Salazar Mora', cedula: 'V-27.654.321', status: 'asistente' },
      { id: '8', name: 'Yorgelis Andreína Blanco Díaz', cedula: 'V-29.876.543', status: 'asistente' },
      { id: '9', name: 'Sebastián Josué Contreras León', cedula: 'V-31.223.344', status: 'asistente' },
      { id: '10', name: 'Katherine del Carmen Suárez Gil', cedula: 'V-26.554.433', status: 'asistente' },
      { id: '11', name: 'Andrés Felipe Jiménez Toro', cedula: 'V-28.300.145', status: 'asistente' },
      { id: '12', name: 'Beatriz Alexandra Mendoza Liendo', cedula: 'V-27.712.098', status: 'asistente' },
      { id: '13', name: 'Carlos Eduardo Rivas Peralta', cedula: 'V-29.445.670', status: 'asistente' },
      { id: '14', name: 'Daniela Michelle Sánchez Ortega', cedula: 'V-30.908.231', status: 'asistente' },
      { id: '15', name: 'Éder Josué Carmona Bermúdez', cedula: 'V-26.118.774', status: 'asistente' },
      { id: '16', name: 'Frangelis Génesis Pérez Marrero', cedula: 'V-28.665.409', status: 'asistente' },
      { id: '17', name: 'Gabriel Antonio Isola Funes', cedula: 'V-27.302.556', status: 'asistente' },
      { id: '18', name: 'Héctor Luis Alvarado Negrón', cedula: 'V-29.771.018', status: 'asistente' },
      { id: '19', name: 'Irelis Margarita Chacón Trujillo', cedula: 'V-31.450.992', status: 'asistente' },
      { id: '20', name: 'Jesús Manuel Pereira Domínguez', cedula: 'V-30.284.613', status: 'asistente' },
      { id: '21', name: 'Karla Vanessa Berrío Cortés', cedula: 'V-26.937.550', status: 'asistente' },
      { id: '22', name: 'Leonardo Daniel Montoya Cabrera', cedula: 'V-28.519.264', status: 'asistente' },
      { id: '23', name: 'María Alejandra Ponce Rincón', cedula: 'V-27.086.341', status: 'asistente' },
      { id: '24', name: 'Nelson Alexander Guzmán Pereda', cedula: 'V-29.613.827', status: 'asistente' },
      { id: '25', name: 'Oscar Javier Hernández Urdaneta', cedula: 'V-30.729.148', status: 'asistente' },
      { id: '26', name: 'Priscila Andreína Márquez Lozano', cedula: 'V-26.402.775', status: 'asistente' },
      { id: '27', name: 'Renny Alexander Marcano Guao', cedula: 'V-28.874.193', status: 'asistente' },
      { id: '28', name: 'Sofía Isabel Delgado Aponte', cedula: 'V-27.550.368', status: 'asistente' },
      { id: '29', name: 'Tomás Eduardo Jáuregui Sosa', cedula: 'V-29.164.702', status: 'asistente' },
      { id: '30', name: 'Yurbi Andreína Pestana Fuentes', cedula: 'V-31.827.405', status: 'asistente' },
      { id: '31', name: 'Zulimar Cristina Páez Batista', cedula: 'V-30.541.269', status: 'asistente' },
      { id: '32', name: 'Daniel Alejandro Nieves Segundo', cedula: 'V-26.649.830', status: 'asistente' },
    ],
  },
  {
    id: 'sis-702',
    name: 'Arquitectura de Software',
    section: 'Sección SIS-702',
    schedule: 'Mar y Jue 10:30 - 12:45',
    room: 'Aula B-12',
    students: [
      { id: '1', name: 'Alejandro Jesús Martínez Roa', cedula: 'V-28.321.654', status: 'asistente' },
      { id: '2', name: 'Gabrielis Mercedes Ávila Cruz', cedula: 'V-27.147.258', status: 'inasistente' },
      { id: '3', name: 'Roberto Emilio Fuentes Páez', cedula: 'V-29.258.369', status: 'asistente' },
      { id: '4', name: 'Stephanie Nicole Guerrero Lara', cedula: 'V-30.456.789', status: 'asistente' },
      { id: '5', name: 'Jhon Alexander Molina Cordero', cedula: 'V-26.369.258', status: 'asistente' },
      { id: '6', name: 'Omar Daniel Vargas Uzcátegui', cedula: 'V-28.741.852', status: 'inasistente' },
      { id: '7', name: 'Lucía Fernanda Méndez Aponte', cedula: 'V-27.852.963', status: 'asistente' },
      { id: '8', name: 'Christian Alexis Núñez Barrios', cedula: 'V-29.963.741', status: 'inasistente' },
      { id: '9', name: 'Valeria Antonieta Campos Ríos', cedula: 'V-31.135.792', status: 'asistente' },
      { id: '10', name: 'Antonio Rafael Villanueva Mesa', cedula: 'V-28.204.517', status: 'asistente' },
      { id: '11', name: 'Carla Margarita Sequera Bustamante', cedula: 'V-27.671.039', status: 'asistente' },
      { id: '12', name: 'David Josué Ramírez Colmenares', cedula: 'V-29.385.476', status: 'asistente' },
      { id: '13', name: 'Estefanía Daniela Maestre Rangel', cedula: 'V-30.612.904', status: 'asistente' },
      { id: '14', name: 'Francisco José Perdomo Leal', cedula: 'V-26.827.315', status: 'asistente' },
      { id: '15', name: 'Gabriela Soleida Torres Pineda', cedula: 'V-28.450.762', status: 'asistente' },
      { id: '16', name: 'Hernán Alejandro Barreto Cárdenas', cedula: 'V-27.239.608', status: 'asistente' },
      { id: '17', name: 'Ingrid Carolina Salas Amaya', cedula: 'V-29.704.183', status: 'asistente' },
      { id: '18', name: 'Javier Enrique Rodríguez Tovar', cedula: 'V-30.358.271', status: 'asistente' },
      { id: '19', name: 'Katherine Johana Gómez Batista', cedula: 'V-26.593.846', status: 'asistente' },
      { id: '20', name: 'Luis Fernando Acosta Millán', cedula: 'V-28.116.902', status: 'asistente' },
      { id: '21', name: 'Mónica Alexandra Páez Cedeño', cedula: 'V-27.947.250', status: 'asistente' },
      { id: '22', name: 'Nelson Gregorio Castillo Fuenmayor', cedula: 'V-29.530.614', status: 'asistente' },
      { id: '23', name: 'Olga Patricia Terán Merchán', cedula: 'V-30.845.037', status: 'asistente' },
      { id: '24', name: 'Pedro Luis Manrique La Rosa', cedula: 'V-26.318.729', status: 'asistente' },
      { id: '25', name: 'Rafael Eduardo Zerpa Aguilar', cedula: 'V-28.693.140', status: 'asistente' },
      { id: '26', name: 'Sandra Milagros Ríos Ocampo', cedula: 'V-27.465.981', status: 'asistente' },
      { id: '27', name: 'Wilmer Alexis Pinto Contreras', cedula: 'V-29.052.473', status: 'asistente' },
      { id: '28', name: 'Yudith Marcela Fuenmayor Alvarado', cedula: 'V-31.726.358', status: 'asistente' },
    ],
  },
  {
    id: 'pry-501',
    name: 'Proyecto Sociotecnológico I',
    section: 'Sección PRY-501',
    schedule: 'Viernes 08:00 - 11:30',
    room: 'Aula A-05',
    students: [
      { id: '1', name: 'Anthony Rafael Colmenares Ojeda', cedula: 'V-28.753.951', status: 'asistente' },
      { id: '2', name: 'Marielis Yohana Prado Espinoza', cedula: 'V-27.951.753', status: 'asistente' },
      { id: '3', name: 'Diego Alfredo Sánchez Mata', cedula: 'V-29.159.357', status: 'asistente' },
      { id: '4', name: 'Jesús David Rodríguez Pinto', cedula: 'V-30.357.159', status: 'inasistente' },
      { id: '5', name: 'Amanda Lizbeth Torres Guerra', cedula: 'V-26.274.815', status: 'asistente' },
      { id: '6', name: 'Francisco Javier Delgado Sosa', cedula: 'V-28.815.274', status: 'asistente' },
      { id: '7', name: 'Isabella Margarita Rojas Cova', cedula: 'V-27.386.924', status: 'asistente' },
      { id: '8', name: 'Éder Ramón Castillo Villegas', cedula: 'V-29.924.386', status: 'asistente' },
      { id: '9', name: 'Nashaly Caroline Buitriago Ruiz', cedula: 'V-31.608.472', status: 'inasistente' },
      { id: '10', name: 'Adriana Josefina Mendoza Parra', cedula: 'V-28.507.194', status: 'asistente' },
      { id: '11', name: 'Brayan Steven Ordóñez Apure', cedula: 'V-27.730.456', status: 'asistente' },
      { id: '12', name: 'Camila Andrea Villalobos Vera', cedula: 'V-29.648.207', status: 'asistente' },
      { id: '13', name: 'Eduard José Padrón Brito', cedula: 'V-30.196.583', status: 'asistente' },
      { id: '14', name: 'Erika Nathalie Fuentes Salcedo', cedula: 'V-26.785.431', status: 'asistente' },
      { id: '15', name: 'Franklin Daniel Suárez Pereira', cedula: 'V-28.942.065', status: 'asistente' },
      { id: '16', name: 'Gleidys Patricia Mora Gil', cedula: 'V-27.514.872', status: 'asistente' },
      { id: '17', name: 'Hans Steven Chávez Marcano', cedula: 'V-29.863.049', status: 'asistente' },
      { id: '18', name: 'Indira Carolina Peña Valera', cedula: 'V-30.473.620', status: 'asistente' },
      { id: '19', name: 'Jhon Fredy Alexander Pirela Núñez', cedula: 'V-26.429.718', status: 'asistente' },
      { id: '20', name: 'Joselyn Katherine Ruiz Terán', cedula: 'V-28.370.596', status: 'asistente' },
      { id: '21', name: 'Kevin Alejandro Nava Espinoza', cedula: 'V-27.106.834', status: 'asistente' },
      { id: '22', name: 'Liseth Andreína Sosa Coronado', cedula: 'V-29.481.257', status: 'asistente' },
      { id: '23', name: 'Manuel Alejandro Iturriza Hernández', cedula: 'V-30.764.019', status: 'asistente' },
      { id: '24', name: 'Nataly Sofía Benítez Gallardo', cedula: 'V-26.152.940', status: 'asistente' },
      { id: '25', name: 'Oscar Alejandro Quintero Jaimes', cedula: 'V-28.639.774', status: 'asistente' },
      { id: '26', name: 'Paola Andrea Blanco Márquez', cedula: 'V-27.895.362', status: 'asistente' },
      { id: '27', name: 'Roger Andrés Stahler Scull', cedula: 'V-29.270.685', status: 'asistente' },
      { id: '28', name: 'Sonia Elizabeth Delgado Perla', cedula: 'V-30.918.403', status: 'asistente' },
      { id: '29', name: 'Yeison Carlos Pérez Colmenares', cedula: 'V-31.347.056', status: 'asistente' },
    ],
  },
];

export interface CourseStats {
  total: number;
  present: number;
  absent: number;
  percent: string;
}

/** Estadísticas de asistencia derivadas de la lista de estudiantes. */
export function getCourseStats(course: Course): CourseStats {
  const total = course.students.length;
  const present = course.students.filter((s) => s.status === 'asistente').length;
  const absent = total - present;
  const percent = total === 0 ? '0.0%' : `${((present / total) * 100).toFixed(1)}%`;
  return { total, present, absent, percent };
}
