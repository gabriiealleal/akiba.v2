/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      width: {
        '80rem': '80rem',
        '19.45%': '19.45%',
        '49.6%': '49.6%',
      },
      fontFamily: {
        'averta': ['Averta', 'sans-serif'],
      },
      fontWeight: {
        'regular': 400,
        'extrabold': 800,
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

