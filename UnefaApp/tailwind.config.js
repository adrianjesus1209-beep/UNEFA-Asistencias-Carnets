/** @type {import('tailwindcss').Config} */
module.exports = {
  // Apunta a todas tus pantallas y componentes dentro de src/
  content: ["./src/**/*.{js,jsx,ts,tsx}"],
  presets: [require("nativewind/preset")],
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
    },
  },
  plugins: [],
};