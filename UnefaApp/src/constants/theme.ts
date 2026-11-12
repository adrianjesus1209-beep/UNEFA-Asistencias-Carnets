import { Platform } from 'react-native';

export const UnefaColors = {
  blue: '#040fd9',
  blueDeep: '#030ba6',
  blueSoft: 'rgba(4, 15, 217, 0.08)',
  navy: '#06152a',
  gold: '#f2b807',
  goldLight: '#ffd740',
  goldDark: '#c99106',
  goldSoft: 'rgba(242, 184, 7, 0.16)',
  red: '#d92929',
  teal: '#14a6a5',
  green: '#16a34a',
  greenSoft: '#dcfce7',
};

export const Colors = {
  light: {
    text: '#0a0a0a',
    textSecondary: '#475569',
    textMuted: '#64748b',
    background: '#ffffff',
    backgroundSecondary: '#f8fafc',
    backgroundTertiary: '#f1f5f9',
    backgroundCard: '#ffffff',
    backgroundElement: '#f1f5f9',
    backgroundSelected: '#e2e8f0',
    border: '#000000',
    borderSubtle: '#e2e8f0',
    borderGrid: '#cbd5e1',
    primary: UnefaColors.blue,
    accent: UnefaColors.gold,
  },
} as const;

export type ThemeColor = keyof typeof Colors.light;

export const Fonts = Platform.select({
  ios: {
    sans: 'system-ui',
    serif: 'ui-serif',
    rounded: 'ui-rounded',
    mono: 'ui-monospace',
  },
  default: {
    sans: 'normal',
    serif: 'serif',
    rounded: 'normal',
    mono: 'monospace',
  },
  web: {
    sans: 'system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
    serif: 'serif',
    rounded: 'normal',
    mono: 'ui-monospace, monospace',
  },
});

export const Spacing = {
  half: 2,
  one: 4,
  two: 8,
  three: 16,
  four: 24,
  five: 32,
  six: 64,
} as const;

export const BottomTabInset = Platform.select({ ios: 50, android: 80 }) ?? 0;
export const MaxContentWidth = 480;
