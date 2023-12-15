/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
  content: [
    "./index.html",
    "./src/**/*.{js,ts,jsx,tsx,vue,blade.php}",
  ],
  theme: {
    extend: {
      fontFamily: {
          sans: ['Figtree', ...defaultTheme.fontFamily.sans],
      },
  },
  container: {
      center: true,
      padding: {
          DEFAULT: '1rem',
          sm: '2rem',
          lg: '4rem',
          xl: '5rem',
          '2xl': '12rem',
      },
  },
  },
  plugins: [],
}

