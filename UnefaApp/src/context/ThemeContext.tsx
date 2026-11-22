import React, { createContext, useContext } from 'react';
import { Colors } from '@/constants/theme';

interface ThemeContextType {
  isDark: false;
  colors: typeof Colors['light'];
}

const ThemeContext = createContext<ThemeContextType>({
  isDark: false,
  colors: Colors.light,
});

export function AppThemeProvider({ children }: { children: React.ReactNode }) {
  return (
    <ThemeContext.Provider value={{ isDark: false, colors: Colors.light }}>
      {children}
    </ThemeContext.Provider>
  );
}

export function useAppTheme() {
  return useContext(ThemeContext);
}
