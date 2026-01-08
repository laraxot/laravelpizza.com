# Guida: Creazione di Plugin Tailwind Custom per <nome progetto>

Questa guida mostra come creare, documentare e integrare plugin custom Tailwind CSS per pattern condivisi (bottoni, alert, badge, ecc.) secondo le best practice Webcrunch e le regole <nome progetto>.

---

## 1. Cos'è un Plugin Tailwind
Un plugin Tailwind permette di aggiungere nuove utility, componenti o variant personalizzate, centralizzando la logica di stile e favorendo la coerenza tra moduli/temi.

---

## 2. Struttura Base di un Plugin
**Esempio: plugin per button variants**

**plugins/button-variants.js**
```js
const plugin = require('tailwindcss/plugin');

module.exports = plugin(function({ addComponents, theme }) {
  const buttons = {
    '.btn': {
      padding: `${theme('spacing.2')} ${theme('spacing.4')}`,
      borderRadius: theme('borderRadius.lg'),
      fontWeight: theme('fontWeight.medium'),
      display: 'inline-flex',
      alignItems: 'center',
      justifyContent: 'center',
      transition: 'background 0.2s',
    },
    '.btn-primary': {
      backgroundColor: theme('colors.blue.600'),
      color: theme('colors.white'),
      '&:hover': {
        backgroundColor: theme('colors.blue.700'),
      },
    },
    '.btn-secondary': {
      backgroundColor: theme('colors.gray.200'),
      color: theme('colors.gray.900'),
      '&:hover': {
        backgroundColor: theme('colors.gray.300'),
      },
    },
  };
  addComponents(buttons);
});
```

---

## 3. Integrazione nel Progetto
**tailwind.config.js**
```js
module.exports = {
  // ...
  plugins: [
    require('./plugins/button-variants'),
    // altri plugin custom...
  ],
};
```

---

## 4. Best Practice
- Documentare ogni plugin in `/docs` e `/Themes/One/project_docs/`.
- Documentare ogni plugin in `/docs` e `/Themes/One/docs/`.
- Usare i plugin per pattern condivisi (bottoni, alert, badge, card, ecc.).
- Versionare e testare i plugin per evitare regressioni.
- Integrare plugin solo se realmente riutilizzati da più moduli/temi.
- Favorire la coerenza di naming e struttura.

---

## 5. Esempi di Plugin Utili per <nome progetto>
- **Button variants**: `.btn`, `.btn-primary`, `.btn-secondary`, ecc.
- **Alert**: `.alert-info`, `.alert-success`, ecc.
- **Badge**: `.badge`, `.badge-success`, ecc.
- **Card**: `.card`, `.card-header`, `.card-footer`.

---

## 6. Collegamenti e Risorse
- [Tailwind CSS Plugin Docs](https://tailwindcss.com/project_docs/plugins)
- [Tailwind CSS Plugin Docs](https://tailwindcss.com/docs/plugins)
- [Webcrunch: Creare Plugin Tailwind](https://webcrunch.com/posts/create-a-tailwind-css-plugin-from-scratch)

---

## Raccomandazioni Finali
- Centralizzare i plugin condivisi per evitare duplicazione.
- Documentare pattern e snippet di utilizzo.
- Integrare plugin custom solo se portano reale valore e riuso.
