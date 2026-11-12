# UnefaApp — Guía de arquitectura y desarrollo

Aplicación móvil y web universal construida con **Expo SDK 58**, **React Native 0.88**, **React 19** y **Expo Router**. El proyecto tiene habilitados el soporte experimental para **React Compiler** y las **Typed Routes**.

## Inicio rápido

### Requisitos

- Node.js y pnpm instalados.
- Un emulador Android, un simulador iOS o un navegador para ejecutar la aplicación.

### Instalación y ejecución

```bash
# Instalar dependencias
pnpm install

# Iniciar Metro
pnpm start

# Iniciar directamente en una plataforma
pnpm android
pnpm ios
pnpm web
```

## Estructura del proyecto

La aplicación utiliza una arquitectura basada en `src/`, que separa las rutas de navegación, la lógica compartida y los recursos estáticos:

```text
UnefaApp/
├── assets/                  # Recursos estáticos empaquetados con la aplicación
│   ├── expo.icon/           # Configuración de ícono multicapa para iOS/watchOS
│   └── images/              # Íconos, imágenes, splash screen y tabIcons
├── scripts/
│   └── reset-project.js     # Limpia el código de demostración inicial
├── src/                     # Código fuente principal
│   ├── app/                 # Rutas basadas en archivos (Expo Router)
│   │   ├── _layout.tsx      # Layout raíz, tema, splash y AppTabs
│   │   ├── index.tsx        # Pantalla principal (ruta `/`)
│   │   └── explore.tsx      # Pantalla secundaria (ruta `/explore`)
│   ├── components/          # Componentes de UI reutilizables
│   │   ├── ui/              # Primitivas de interfaz
│   │   ├── app-tabs.tsx     # Pestañas nativas para Android/iOS
│   │   ├── app-tabs.web.tsx # Pestañas adaptadas para Web
│   │   ├── themed-text.tsx  # Texto con soporte de tema
│   │   └── themed-view.tsx  # Contenedor con soporte de tema
│   ├── constants/
│   │   └── theme.ts         # Colores, fuentes, espaciado y dimensiones
│   ├── hooks/               # Hooks de tema y plataforma
│   │   ├── use-color-scheme.ts
│   │   ├── use-color-scheme.web.ts
│   │   └── use-theme.ts
│   └── global.css           # Variables CSS globales para Web
├── AGENTS.md                # Directrices técnicas para asistentes de IA
├── app.json                 # Configuración global de Expo
├── package.json             # Dependencias, scripts y punto de entrada
└── tsconfig.json            # TypeScript estricto y alias del proyecto
```

## Expo Router y navegación

El punto de entrada está definido en `package.json`:

```json
{
  "main": "expo-router/entry"
}
```

Expo Router escanea automáticamente `src/app/` y convierte cada archivo exportado por defecto en una ruta navegable en móvil y Web.

| Archivo | Ruta | Responsabilidad |
| --- | --- | --- |
| `src/app/_layout.tsx` | — | Layout estructural, tema, splash y pestañas |
| `src/app/index.tsx` | `/` | Pantalla de inicio |
| `src/app/explore.tsx` | `/explore` | Segunda pestaña |

### Patrones para ampliar las rutas

- **Ruta estática:** `src/app/perfil.tsx` genera `/perfil`.
- **Ruta dinámica:** `src/app/materias/[id].tsx` genera `/materias/123`. El parámetro se lee con `useLocalSearchParams()`.
- **Grupo de rutas:** `src/app/(auth)/login.tsx` permite organizar pantallas bajo un layout sin agregar `(auth)` a la URL.

> **Regla de oro:** no coloques componentes auxiliares, hooks, servicios ni utilidades dentro de `src/app/`. Todo archivo allí se interpreta como una pantalla o parte del enrutamiento público.

### Resolución por plataforma

Los archivos `app-tabs.tsx` y `app-tabs.web.tsx` comparten el mismo nombre base. Al importar:

```tsx
import AppTabs from '@/components/app-tabs';
```

Metro selecciona automáticamente la variante `.web.tsx` para navegador y `.tsx` para Android/iOS. El mismo patrón se utiliza en `use-color-scheme`.

## Guía para modificar archivos

| Ubicación | Uso |
| --- | --- |
| `src/app/**` | Pantallas, flujos de navegación y layouts anidados |
| `src/components/**` | Componentes visuales y pestañas principales |
| `src/constants/theme.ts` | Paleta institucional, espaciado y tipografías |
| `app.json` | Nombre, slug, scheme, permisos y config plugins nativos |

### Archivos que no deben editarse manualmente

- **`android/` y `ios/`:** si se generan localmente, el proyecto usa CNG (Continuous Native Generation). Los cambios nativos manuales se perderán; utiliza `app.json` o config plugins.
- **`.expo/` y `expo-env.d.ts`:** son generados por Expo y Typed Routes. No deben editarse ni subirse al repositorio.
- **`scripts/reset-project.js`:** es un script de un solo uso para limpiar la plantilla. Puede eliminarse después de completar esa limpieza, junto con su entrada en `package.json`.

## Convenciones para organizar código nuevo

Respeta los alias definidos en `tsconfig.json`:

- `@/*` apunta a `./src/*`.
- `@/assets/*` apunta a `./assets/*`.

Organiza el crecimiento de la aplicación con esta estructura:

```text
src/
├── app/             # Exclusivamente pantallas y _layout.tsx
├── components/      # Componentes visuales
│   ├── ui/          # Átomos reutilizables
│   └── [feature]/   # Componentes acoplados a un módulo
├── hooks/           # Estado reutilizable y ciclo de vida
├── services/        # Clientes HTTP/API y adaptadores externos
├── stores/          # Estado global ligero
├── types/           # Interfaces y tipos de dominio
├── utils/           # Funciones puras y validadores
└── constants/       # Tokens de diseño y configuraciones fijas
```

### Reglas internas

- **Pantallas delgadas:** `src/app/` debe leer parámetros, coordinar el layout y delegar la interfaz y la lógica pesada a componentes y hooks.
- **Estilos y temas:** usa `ThemedView` y `ThemedText` como bloques base. Consume colores con `useTheme()` y medidas de `Spacing` desde `@/constants/theme`; evita valores mágicos en `StyleSheet.create`.
- **React Compiler:** `reactCompiler` está activo en `app.json`. No agregues `useMemo` o `useCallback` prematuramente, salvo que sean necesarios para referencias de efectos externos.
- **Assets:** usa `Image` de `expo-image` en lugar de `Image` de `react-native` para aprovechar la caché en disco. Importa imágenes estáticas mediante `@/assets/images/...`. Metro seleccionará la densidad adecuada si existen variantes `@2x.png` y `@3x.png`.
- **Pruebas:** coloca los tests junto al módulo probado, por ejemplo `src/components/ui/__tests__/collapsible.test.tsx`, o en `src/__tests__/` para pruebas de integración.

## Flujo de trabajo y comandos

### Instalar paquetes de Expo y React Native

No uses `pnpm add` directamente para librerías del ecosistema Expo o React Native. Utiliza el wrapper de Expo para resolver la versión compatible con el SDK 58:

```bash
pnpm dlx expo install <nombre-del-paquete>
```

### Calidad de código y diagnóstico

Ejecuta siempre el linter y el chequeo de tipos antes de confirmar cambios:

```bash
# ESLint configurado por Expo
pnpm lint

# TypeScript sin emitir archivos compilados
pnpm exec tsc --noEmit

# Diagnosticar incompatibilidades del SDK
pnpm dlx expo-doctor

# Reparar versiones incompatibles con el SDK
pnpm dlx expo install --fix
```

### Limpiar el código de ejemplo

```bash
pnpm reset-project
```

### Limpiar caché y resolver problemas

Si aparecen errores de resolución de módulos en Metro o los cambios no se reflejan:

```bash
# Iniciar Metro limpiando la caché
pnpm start --clear
```

En Windows PowerShell, para una limpieza profunda de dependencias y caché local:

```powershell
Remove-Item -Recurse -Force node_modules, .expo
pnpm install
```

En macOS/Linux, el equivalente es:

```bash
rm -rf node_modules .expo
pnpm install
```

## Recursos oficiales

- [Documentación de Expo](https://docs.expo.dev/)
- [Expo Router](https://docs.expo.dev/router/introduction)
- [Builds de desarrollo](https://docs.expo.dev/develop/development-builds/introduction/)
- [TypeScript en Expo](https://docs.expo.dev/guides/typescript/)
