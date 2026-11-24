export default {
  plugins: {
    'postcss-import': {},
    'postcss-nesting': {},
    '@tailwindcss/postcss': {},
    autoprefixer: {},
    // DCP-195: preflight button/submit trasparente → @layer base (prima dell'isolate)
    './postcss/layer-button-preflight.cjs': {},
    // ultimo: limita le regole legacy con !important agli elementi fuori da .dc-page
    './postcss/isolate-legacy-important.cjs': {},
  },
}
