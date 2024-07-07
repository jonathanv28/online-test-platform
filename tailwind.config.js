/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./src/**/*.{html,js}",
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js",
  ],
  theme: {
    extend: {},
    colors: {
      transparent: 'transparent',
      current: 'currentColor',
      'grass': '#00AD00',
      'grassbold': '#058605',
      'darkblue': '#101820',
    },
  },
  plugins: [
    require('flowbite/plugin')
  ],
  darkMode: 'false',
}

