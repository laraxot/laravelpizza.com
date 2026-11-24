<<<<<<< .merge_file_DcJcKw
// Nessun plugin PostCSS, di proposito. Tailwind v4 gira gia' dentro `@tailwindcss/vite` (vite.config.js) e da solo
// risolve `@import`, abbassa il nesting e mette i prefissi vendor: elencarlo anche qui lo elaborerebbe due volte.
// NON aggiungere `@tailwindcss/postcss` (non e' in package.json: `npm run build` fallisce con "Cannot find module")
// ne' `./postcss/*.cjs` (plugin del tema Sixteen, DCP-195: in Meetup i file non esistono e lo scope
// `.page-content[data-dc]` non e' mai usato; `isolate-legacy-important` gonfierebbe il CSS di circa il 64%).
// Perche' e prove: docs/development-workflow-css-js-changes.md, sezione "PostCSS".
export default { plugins: {} }
=======
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
>>>>>>> .merge_file_6M39Wg
