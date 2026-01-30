/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    '../../app/Filament/**/*.php',
    '../../resources/views/filament/**/*.blade.php',
    '../../vendor/filament/**/*.blade.php',
    '../../vendor/awcodes/overlook/resources/**/*.blade.php',
    '../../Modules/**/*.php',
    '../../Modules/Resources/**/*.php',
    '../../Modules/Http/**/*.php',
    '../../Modules/Filament/**/*.php',
    '../../Modules/View/**/*.php',
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}

