/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      fontFamily: {
        'noto-sans': ['Noto Sans', 'sans-serif'], // Adicione esta linha
      },
      backgroundImage: {
        'login': "url('https://i.imgur.com/iTUkmyD.gif')",
      },
      colors:{
        'aurora': '#FFF6E6',
        'creme': '#FFE8BF',
        'laranja': '#FFA919',
        'azul-escuro': '#00061A',
        'azul-medio': '#002080',
        'azul-claro': '#0091FF',
      }
    },
  },
  plugins: [],
}

