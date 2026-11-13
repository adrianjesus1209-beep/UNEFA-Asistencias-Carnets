export interface Pillar {
  id: string;
  number: string;
  title: string;
  tabTitle: string;
  subtitle: string;
  caption: string;
  image: string;
  description: string;
  highlights: string[];
}

export const PILLARS_DATA: Record<string, Pillar> = {
  ingenieria: {
    id: 'ingenieria',
    number: '01',
    tabTitle: 'Innovación Politécnica',
    subtitle: 'Área técnica',
    title: 'Innovación Politécnica e Investigación',
    caption: 'FIG. 02 — BANCO DE PRUEBAS ELECTRÓNICAS Y MECATRÓNICA',
    image: 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=1200&q=80',
    description:
      'Programas orientados a la soberanía científica: desarrollo de software crítico, automatización, diseño mecánico y telecomunicaciones satelitales que atienden las necesidades estratégicas de la nación.',
    highlights: [
      'Laboratorios equipados para prácticas de hardware y redes',
      'Proyectos de tesis orientados a resolver problemas industriales reales',
      'Docencia a cargo de especialistas con trayectoria técnica probada',
    ],
  },
  doctrina: {
    id: 'doctrina',
    number: '02',
    tabTitle: 'Doctrina Cívico-Militar',
    subtitle: 'Defensa integral',
    title: 'Doctrina Cívico-Militar y Liderazgo',
    caption: 'FIG. 03 — FORMACIÓN INTEGRAL Y PATRIMONIO INSTITUCIONAL',
    image: 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?auto=format&fit=crop&w=1200&q=80',
    description:
      'Formación en valores de honor, disciplina, lealtad y corresponsabilidad ciudadana en la defensa y desarrollo integral de la patria, forjando un carácter ético inquebrantable en cada profesional.',
    highlights: [
      'Instrucción en orden cerrado, liderazgo y trabajo bajo presión',
      'Cátedra de Defensa Integral de la Nación y soberanía popular',
      'Ética cívica aplicada a la ingeniería y la administración pública',
    ],
  },
  extension: {
    id: 'extension',
    number: '03',
    tabTitle: 'Extensión Comunitaria',
    subtitle: 'Vinculación',
    title: 'Extensión y Compromiso Comunitario',
    caption: 'FIG. 04 — VINCULACIÓN COMUNITARIA Y SERVICIO SOCIAL',
    image: 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1200&q=80',
    description:
      'La ciencia y la técnica no se quedan en el aula: los estudiantes unefistas transfieren sus proyectos directamente a las comunidades, consejos comunales y empresas públicas a través del Servicio Comunitario obligatorio.',
    highlights: [
      'Más de 100 proyectos comunitarios activos por semestre',
      'Capacitación tecnológica a sectores vulnerables y escuelas técnicas',
      'Soluciones de ingeniería de bajo costo con alto impacto social',
    ],
  },
  gratuidad: {
    id: 'gratuidad',
    number: '04',
    tabTitle: 'Inclusión y Cobertura',
    subtitle: 'Igualdad social',
    title: 'Inclusión Radical y Cobertura Nacional',
    caption: 'FIG. 05 — AULAS DIGITALES Y ACCESO IRRESTRICTO',
    image: 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&w=1200&q=80',
    description:
      'Educación universitaria de primer nivel completamente pública y gratuita, garantizando que el talento de cualquier rincón del país tenga acceso a las carreras más demandadas del mercado tecnológico.',
    highlights: [
      '0 aranceles de matrícula durante toda la carrera',
      'Presencia en los 24 estados con sedes y extensiones',
      'Igualdad de oportunidades mediante el Curso Introductorio CINU',
    ],
  },
};

export interface Career {
  id: string;
  code: string;
  title: string;
  duration: string;
  degree: string;
  image: string;
  description: string;
  competencies: string[];
  subjects: string[];
}

export const CAREERS_DATA: Record<string, Career[]> = {
  ingenieria: [
    {
      id: 'sistemas',
      code: 'ING-SIS-10',
      title: 'Ingeniería de Sistemas',
      duration: '10 Semestres (5 Años)',
      degree: 'Ingeniero de Sistemas',
      image: 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&w=1200&q=80',
      description:
        'Formación de avanzada en ingeniería de software crítico, arquitectura de sistemas distribuidos, bases de datos masivas, ciberseguridad y computación para la defensa y desarrollo soberano.',
      competencies: [
        'Desarrollo de software de misión crítica',
        'Ciberseguridad y soberanía de datos',
        'Modelado matemático e inteligencia artificial',
        'Gestión de infraestructuras del Estado',
      ],
      subjects: [
        'Algoritmos y Estructuras',
        'Bases de Datos Masivas',
        'Redes y Teleproceso',
        'Ingeniería de Software',
        'Sistemas Operativos',
      ],
    },
    {
      id: 'telecom',
      code: 'ING-TEL-10',
      title: 'Ingeniería de Telecomunicaciones',
      duration: '10 Semestres (5 Años)',
      degree: 'Ingeniero de Telecomunicaciones',
      image: 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?auto=format&fit=crop&w=1200&q=80',
      description:
        'Especialistas en transmisión por fibra óptica, microondas, enlaces satelitales civiles y militares, antenas y procesamiento digital de señales para redes estratégicas.',
      competencies: [
        'Diseño de redes de comunicación nacional',
        'Operación de estaciones terrenas y satélites',
        'Propagación electromagnética y microondas',
        'Protocolos tácticos y seguros de comunicación',
      ],
      subjects: [
        'Teoría Electromagnética',
        'Sistemas de Transmisión',
        'Microondas y Radar',
        'Comunicaciones Ópticas',
        'Redes de Conmutación',
      ],
    },
    {
      id: 'mecanica',
      code: 'ING-MEC-10',
      title: 'Ingeniería Mecánica',
      duration: '10 Semestres (5 Años)',
      degree: 'Ingeniero Mecánico',
      image: 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=1200&q=80',
      description:
        'Diseño asistido por computadora (CAD/CAM), plantas térmicas, turbomáquinas, manufactura avanzada y mantenimiento de plantas industriales y de defensa.',
      competencies: [
        'Diseño y simulación de mecanismos',
        'Plantas térmicas y conversión de potencia',
        'Automatización de procesos industriales',
        'Metalurgia y resistencia de materiales',
      ],
      subjects: [
        'Mecánica de Fluidos',
        'Termodinámica Aplicada',
        'Diseño de Máquinas',
        'Resistencia de Materiales',
        'Transferencia de Calor',
      ],
    },
    {
      id: 'electronica',
      code: 'ING-ELE-10',
      title: 'Ingeniería Electrónica',
      duration: '10 Semestres (5 Años)',
      degree: 'Ingeniero Electrónico',
      image: 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1200&q=80',
      description:
        'Control automático, diseño de sistemas embebidos, instrumentación industrial y biomédica, robótica aplicada y electrónica de potencia.',
      competencies: [
        'Sistemas embebidos y microcontroladores',
        'Control y automatismos de plantas',
        'Electrónica de potencia industrial',
        'Robótica y sensórica aplicada',
      ],
      subjects: [
        'Circuitos Eléctricos',
        'Electrónica Analógica y Digital',
        'Sistemas de Control',
        'Microprocesadores',
        'Robótica Industrial',
      ],
    },
  ],
  licenciaturas: [
    {
      id: 'administracion',
      code: 'LIC-AGM-08',
      title: 'Administración y Gestión Municipal',
      duration: '8 Semestres (4 Años)',
      degree: 'Licenciado en Administración y Gestión Municipal',
      image: 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1200&q=80',
      description:
        'Formación en gerencia pública estratégica, presupuesto y contabilidad del Estado, contrataciones públicas y gestión de proyectos socio-productivos comunales.',
      competencies: [
        'Planificación presupuestaria pública',
        'Gobernanza territorial y comunal',
        'Auditoría y control de gestión',
        'Diseño de políticas socio-productivas',
      ],
      subjects: [
        'Derecho Administrativo',
        'Finanzas Públicas',
        'Planificación Estratégica',
        'Gestión Tributaria',
        'Proyectos Comunales',
      ],
    },
    {
      id: 'enfermeria',
      code: 'LIC-ENF-08',
      title: 'Licenciatura en Enfermería',
      duration: '8 Semestres (4 Años)',
      degree: 'Licenciado en Enfermería',
      image: 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=1200&q=80',
      description:
        'Atención hospitalaria, salud integral preventiva, gestión de emergencias clínicas y medicina táctica en apoyo a las comunidades y la fuerza armada.',
      competencies: [
        'Cuidados intensivos y prehospitalarios',
        'Epidemiología y salud pública',
        'Administración de servicios clínicos',
        'Atención en situaciones de contingencia',
      ],
      subjects: [
        'Anatomía y Fisiología',
        'Farmacología Clínica',
        'Enfermería Médico-Quirúrgica',
        'Salud Pública',
        'Medicina de Emergencia',
      ],
    },
  ],
  tsu: [
    {
      id: 'tsu-sistemas',
      code: 'TSU-SIS-06',
      title: 'TSU en Análisis de Sistemas',
      duration: '6 Semestres (3 Años)',
      degree: 'Técnico Superior Universitario en Análisis de Sistemas',
      image: 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=1200&q=80',
      description:
        'Inserción técnica directa: programación web, administración de bases de datos relacionales, soporte de redes locales y mantenimiento de infraestructura informática.',
      competencies: [
        'Desarrollo web y aplicaciones',
        'Configuración de redes LAN',
        'Mantenimiento preventivo y correctivo de software',
      ],
      subjects: [
        'Lenguajes de Programación',
        'Bases de Datos Relacionales',
        'Redes de Computadoras',
        'Sistemas de Información',
      ],
    },
    {
      id: 'tsu-enfermeria',
      code: 'TSU-ENF-06',
      title: 'TSU en Enfermería',
      duration: '6 Semestres (3 Años)',
      degree: 'Técnico Superior Universitario en Enfermería',
      image: 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=1200&q=80',
      description:
        'Asistencia clínica directa en hospitales y ambulatorios, curas y primeros auxilios, vacunación y apoyo inmediato a brigadas de salud preventiva.',
      competencies: [
        'Procedimientos de enfermería básicos y avanzados',
        'Atención inmediata en triaje y primeros auxilios',
        'Protocolos de esterilización y bioseguridad',
      ],
      subjects: [
        'Fundamentos de Enfermería',
        'Bioquímica Básica',
        'Enfermería Comunitaria',
        'Atención Materno-Infantil',
      ],
    },
  ],
};

export interface ChecklistItem {
  id: number;
  text: string;
  phase: string;
  defaultChecked: boolean;
}

export const CHECKLIST_ITEMS: ChecklistItem[] = [
  {
    id: 1,
    text: 'Cédula de identidad laminada y 2 fotocopias legibles',
    phase: 'Fase 1',
    defaultChecked: true,
  },
  {
    id: 2,
    text: 'Título de bachiller autenticado por Zona Educativa',
    phase: 'Fase 2',
    defaultChecked: true,
  },
  {
    id: 3,
    text: 'Notas certificadas de 1º a 5º año de educación media',
    phase: 'Fase 2',
    defaultChecked: false,
  },
  {
    id: 4,
    text: 'Certificado de participación en el SNI / OPSU',
    phase: 'Fase 1',
    defaultChecked: false,
  },
  {
    id: 5,
    text: 'Partida de nacimiento en formato reciente legible',
    phase: 'Fase 2',
    defaultChecked: false,
  },
  {
    id: 6,
    text: '2 fotografías recientes fondo blanco tipo carnet',
    phase: 'Fase 3',
    defaultChecked: false,
  },
];

