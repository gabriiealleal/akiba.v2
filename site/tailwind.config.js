/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      width: {
        '32rem': '32rem',
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
        'login': "url('https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/b6843562-1654-4d17-94f0-674eb6e68d27/dc5c7gt-85951a90-8530-43ab-9105-f3dca13ade19.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7InBhdGgiOiJcL2ZcL2I2ODQzNTYyLTE2NTQtNGQxNy05NGYwLTY3NGViNmU2OGQyN1wvZGM1YzdndC04NTk1MWE5MC04NTMwLTQzYWItOTEwNS1mM2RjYTEzYWRlMTkucG5nIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmZpbGUuZG93bmxvYWQiXX0.kGYGg9qyG_dkKUNDXwPzYUly44HKJo3kFNZZZ-ju7_Q')",
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

