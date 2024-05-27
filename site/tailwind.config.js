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
      height: {
        '71%': '71%',
      },
      fontFamily: {
        'averta': ['Averta', 'sans-serif'],
      },
      fontWeight: {
        'regular': 400,
        'extrabold': 800,
      },
      backgroundImage: {
        'footer': "url('https://i.imgur.com/iTUkmyD.gif')",
        'login': "url('https://images6.alphacoders.com/134/1347028.jpeg')",
      },
      colors:{
        'aurora': '#FFF6E6',
        'creme': '#FFE8BF',
        'laranja': '#FFA919',
        'laranja2': '#cc6633',
        'azul-escuro': '#00061A',
        'azul-medio': '#002080',
        'azul-claro': '#0091FF',
        'roxo': '#b82bff',
        'roxo2': '#9765fd',
        'verde': '#00a859',
        'vermelho': '#f43e37',
      }
    },
  },
  plugins: [],
}

