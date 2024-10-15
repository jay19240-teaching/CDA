/** @type {import('tailwindcss').Config} */
export default {
  content: [],
  purge: ['./index.html', './src/**/*.{vue,js,ts,jsx,tsx}'],
  theme: {
    extend: {
      colors: {
        'alpha': '#BDBDCD',
        'beta': '#5A5A7B',
        'gamma': '#393952',
        'delta': '#e6e6ee',
        'epsilon': '#ffffff',
        'zeta': '#ac3929'
      },
    },
  },
  plugins: [],
}