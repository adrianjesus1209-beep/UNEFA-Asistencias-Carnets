# SISTEMA INTEGRAL DE ASISTENCIAS Y CARNETIZACION DIGITAL - UNEFA

Sistema universitario para la gestion, carnetizacion digital con codigo QR y control de asistencia estudiantil y docente de la Universidad Nacional Experimental Politecnica de la Fuerza Armada Nacional Bolivariana (UNEFA).

---

## ESTRUCTURA DE LA COMUNIDAD Y DEPARTAMENTOS

### LIDER GENERAL DE TODOS LOS DEPARTAMENTOS
- **Adrian Bello**

---

### 1. DEPARTAMENTO DE BACKEND
- **Lider de departamento:** Gabriel Cobo
- **Sublider:** Cristian Trosel
- **Integrantes:**
  - Rutbelis Cordova
  - Jose Losad
  - Susana Acevedo
  - Nestor Marquina
  - Reyli Gonzales
- **Rama en GitHub:** Backend
- **Responsabilidad:** Logica del servidor (PHP nativo), modelos, controladores, autenticacion, control de sesiones, endpoints y validaciones.

---

### 2. DEPARTAMENTO DE FRONTEND
- **Lider de departamento:** Deiber Vasquez
- **Sublider:** Jesus Pacheco
- **Integrantes:**
  - Keinserling Leama
  - Gregori Arrieta
  - Josfrancis Torres
  - Ismael Maestre
  - Jesus Parra
- **Rama en GitHub:** Frontend
- **Responsabilidad:** Vistas web y movil (HTML, CSS, JavaScript, React), diseño responsivo, interfaz del carnet digital y lector de codigos QR.

---

### 3. DEPARTAMENTO DE BASE DE DATOS
- **Lider de departamento:** John Frank Romero
- **Sublider / Co-lider:** Adrian Bello
- **Integrantes:**
  - Gabriel Hidalgo
  - Aura Izquierdo
  - Brigitte Rodriguez
  - Chukwuduben Onoh
  - Eduardo Martinez
- **Rama en GitHub:** Database
- **Responsabilidad:** Esquema relacional MySQL / MariaDB, diseño de tablas, normalizacion, indices, optimizacion de consultas y respaldos SQL.

---

### 4. DEPARTAMENTO DE DOCUMENTACION
- **Lider de departamento:** Abel Leon
- **Integrantes:**
  - Gabriel Gonzalez
  - Osmely Sangronis
- **Rama en GitHub:** Documentacion
- **Responsabilidad:** Documentacion tecnica, diagramas de flujo y arquitectura, diccionario de datos y manuales de usuario.

---

## POLITICA DE RAMAS EN GIT

Para mantener el orden entre los cuatro departamentos, el repositorio se organiza con el siguiente esquema de ramas:

1. **main (Produccion / Estable):**
   - Contiene unicamente versiones estables y aprobadas formalmente por el Lider General Adrian Bello.
   - Rama protegida con revision obligatoria.

2. **develop (Integracion General):**
   - Rama donde convergen las caracteristicas terminadas y revisadas de todos los departamentos.

3. **Ramas Fijas por Departamento:**
   - **Backend**: Base para el equipo de Backend.
   - **Frontend**: Base para el equipo de Frontend.
   - **Database**: Base para el equipo de Base de Datos.
   - **Documentacion**: Base para el equipo de Documentacion.

---

## POLITICA DE REVISION DE COMMITS (CODE REVIEW)

Antes de fusionar cualquier cambio a las ramas departamentales o a develop:
1. El commit o pull request debe ser revisado y aprobado por el Lider General (Adrian Bello) y los Lideres Departamentales.
2. No se permite el uso de emojis en ninguna parte del codigo, comentarios o mensajes de commit.
3. El codigo debe mantener un estilo autodocumentado, con explicaciones sencillas y comprensibles para todo el equipo.