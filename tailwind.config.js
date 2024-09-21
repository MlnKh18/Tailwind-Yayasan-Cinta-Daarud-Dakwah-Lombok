/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./public/**/*.{html,js}"],
  theme: {
    extend: {
      fontFamily: {
        custom: 'Coolvetica Crammed Regular',
        poppins: 'Poppins'
      },
      colors: {
        'primary': {
          "default": '#ffe8ba',
          "hover": "#ffffff"
        },
        'secondary': '#0E6678',
        'third': '#FFA500',
        'hover-color': 'rgba(67, 67, 67, 0.42)'
      }
    },
  },
  plugins: [],
}