/**
 * Configurazione Tailwind CSS per il progetto Laraxot PTVX
/**
 * Configurazione Tailwind CSS per il progetto
  *
 * Perché: Tailwind CSS è un framework CSS utility-first che permette di costruire
 * interfacce moderne e responsive con un approccio component-first. Questa configurazione
 * definisce come Tailwind deve essere compilato e quali estensioni utilizzare.
 *
 * Cosa: Questa configurazione definisce:
 * - I percorsi dei file da analizzare per il purging delle classi non utilizzate
 * - Le estensioni al tema di base (colori, font, spaziature, ecc.)
 * - I plugin da utilizzare per funzionalità aggiuntive
 *
 * @type {import('tailwindcss').Config}
 */
module.exports = {
  content: [
    // Percorsi dei file da analizzare per il purging
    './laravel/Modules/**/Resources/views/**/*.blade.php',
    './laravel/Modules/**/Resources/js/**/*.js',
    './laravel/Modules/**/Resources/js/**/*.vue',
  ],
  theme: {
    extend: {
      // Estensioni al tema di base
      colors: {
        primary: {
          50: '#f0f9ff',
          100: '#e0f2fe',
          500: '#0ea5e9',
          700: '#0369a1',
          900: '#0c4a6e',
        },
      },
      fontFamily: {
        sans: ['Inter var', 'sans-serif'],
      },
    },
  },
  plugins: [
    // Plugin per form elements, typography e altri componenti
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
  ],
}
/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [],
  theme: {
    extend: {},
  },
  plugins: [],
  }

 
