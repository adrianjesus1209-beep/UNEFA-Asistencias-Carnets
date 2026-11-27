/** @type {import('tailwindcss').Config} */
// Configuracion de Tailwind para el portal UNEFA (landing, auth y SICEU unificado por roles).
module.exports = {
  content: [
    "./resources/views/**/*.blade.php",
    "./public/js/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        unefa: {
          blue: "#002855",
          blueDeep: "#001736",
          "blue-deep": "#001736",
          "blue-light": "#0a3d7a",
          navy: "#06152a",
          "navy-soft": "#0b2545",
          gold: "#f2b807",
          goldLight: "#ffd740",
          "gold-light": "#ffd740",
          goldDark: "#b58105",
          "gold-dark": "#b58105",
          red: "#c8102e",
          teal: "#0d9488",
          green: "#10b981",
        },
        "bg-page": "#f4f6fa",
        "bg-secondary": "#f4f6fa",
        "bg-tertiary": "#e9eef6",
        "surface-input": "#f0f3ff",
        "text-primary": "#06152a",
        "text-secondary": "#2d3748",
        "text-muted": "#44474e",
        "border-subtle": "#e2e8f0",
        "border-primary": "#cbd5e1",
        "border-grid": "#94a3b8",
      },
      spacing: {
        "4.5": "1.125rem",
        "9.5": "2.375rem",
        "13": "3.25rem",
        "17": "4.25rem",
      },
      opacity: {
        "8": "0.08",
        "12": "0.12",
      },
      fontFamily: {
        sans: ['system-ui', '-apple-system', 'BlinkMacSystemFont', '"Segoe UI"', 'Roboto', 'sans-serif'],
        mono: ['ui-monospace', 'SFMono-Regular', 'Menlo', 'Consolas', '"Liberation Mono"', 'monospace'],
      },
    },
  },
  plugins: [],
};
