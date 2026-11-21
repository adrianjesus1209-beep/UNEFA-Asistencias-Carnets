/** @type {import('tailwindcss').Config} */
// Configuracion de Tailwind para el portal UNEFA.
// La paleta replica las marcas usadas en la aplicacion movil (UnefaApp).
module.exports = {
  content: [
    "./resources/views/**/*.blade.php",
    "./public/js/**/*.js",
  ],
  theme: {
    extend: {
      colors: {
        unefa: {
          blue: "#040fd9",
          blueDeep: "#030ba6",
          navy: "#06152a",
          gold: "#f2b807",
          goldLight: "#ffd740",
          goldDark: "#c99106",
          red: "#d92929",
          teal: "#14a6a5",
          green: "#16a34a",
        },
      },
      fontFamily: {
        sans: ['system-ui', '-apple-system', 'BlinkMacSystemFont', '"Segoe UI"', 'Roboto', 'sans-serif'],
        mono: ['ui-monospace', 'SFMono-Regular', 'Menlo', 'Consolas', '"Liberation Mono"', 'monospace'],
      },
    },
  },
  plugins: [],
};
