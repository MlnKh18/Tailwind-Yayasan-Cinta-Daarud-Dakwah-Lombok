/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./public/**/*.{html,js}"],
  theme: {
    extend: {
      colors: {
        'primary': {
          "default": '#ffe8ba',
          "hover": "#ffffff"
        },
        'secondary': '#0E6678',
      }
    },
  },
  plugins: [],
}