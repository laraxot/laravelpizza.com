/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/html/**/*.html',
    './resources/views/**/*.blade.php',
    './Modules/**/resources/views/**/*.blade.php',
    './Themes/**/resources/views/**/*.blade.php',
  ],
  theme: {
    extend: {
      colors: {
        'pizza-red': '#DC2626',
        'pizza-gold': '#F59E0B',
        'pizza-brown': '#92400E',
        'pizza-dark': '#1F2937',
      },
      fontFamily: {
        'display': ['Poppins', 'sans-serif'],
        'body': ['Inter', 'sans-serif'],
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
}