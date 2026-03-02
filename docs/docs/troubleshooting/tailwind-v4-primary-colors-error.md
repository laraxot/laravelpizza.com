# Tailwind CSS v4 - Errore Primary Colors

**Autore**: Claude Code
**Problema**: `Cannot apply unknown utility class 'focus:ring-primary-500'` e `text-primary-600`

---

## Problema Riscontrato

### Errore Vite/Tailwind
```
[plugin:@tailwindcss/vite:generate:serve] Cannot apply unknown utility class `focus:ring-primary-500`
[plugin:@tailwindcss/vite:generate:serve] Cannot apply unknown utility class `px-6`
[plugin:@tailwindcss/vite:generate:serve] Cannot apply unknown utility class `text-primary-600`
```

### Contesto
- **Tailwind CSS Version**: v4.x (ultima versione)
- **File interessati**: index.html, events.html, e tutti i file HTML
- **Classi non riconosciute**: `primary-*`, `focus:ring-primary-500`, `bg-primary-600`, ecc.

---

## Causa del Problema

### Tailwind CSS v4 - CSS-First Configuration

In **Tailwind CSS v4**, il sistema di configurazione è cambiato radicalmente:

#### ❌ BEFORE (Tailwind v3)
```js
// tailwind.config.js
module.exports = {
  theme: {
    extend: {
      colors: {
        primary: {
          50: '#fef2f2',
          100: '#fee2e2',
          // ...
          600: '#dc2626',
          700: '#b91c1c',
          // ...
        }
      }
    }
  }
}
```

#### ✅ AFTER (Tailwind v4)
```css
/* css/app.css */
@import "tailwindcss";

@theme {
  --color-primary-50: #fef2f2;
  --color-primary-100: #fee2e2;
  --color-primary-200: #fecaca;
  --color-primary-300: #fca5a5;
  --color-primary-400: #f87171;
  --color-primary-500: #ef4444;
  --color-primary-600: #dc2626;
  --color-primary-700: #b91c1c;
  --color-primary-800: #991b1b;
  --color-primary-900: #7f1d1d;
  --color-primary-950: #450a0a;
}
```

### Perché `px-6` non funziona?

L'errore `px-6` suggerisce che **@import "tailwindcss"** potrebbe non essere presente o non essere processato correttamente.

---

## Soluzione

### Step 1: Verificare css/app.css

Il file `resources/html/css/app.css` DEVE contenere:

```css
@import "tailwindcss";

@theme {
  /* Colori Primary (Rosso Pizza) */
  --color-primary-50: #fef2f2;
  --color-primary-100: #fee2e2;
  --color-primary-200: #fecaca;
  --color-primary-300: #fca5a5;
  --color-primary-400: #f87171;
  --color-primary-500: #ef4444;
  --color-primary-600: #dc2626;
  --color-primary-700: #b91c1c;
  --color-primary-800: #991b1b;
  --color-primary-900: #7f1d1d;
  --color-primary-950: #450a0a;

  /* Spacing personalizzati (opzionale) */
  --spacing-18: 4.5rem;
  --spacing-72: 18rem;
  --spacing-84: 21rem;
  --spacing-96: 24rem;
}
```

### Step 2: Rimuovere tailwind.config.js

In Tailwind v4, il file `tailwind.config.js` **NON è più necessario** se usi solo `@theme`.

Puoi rimuoverlo o svuotarlo:

```js
// tailwind.config.js (opzionale, può essere vuoto)
export default {}
```

### Step 3: Verificare vite.config.js

```js
import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite'

export default defineConfig({
  plugins: [
    tailwindcss(),
  ],
  // ...
})
```

### Step 4: Restart Vite Dev Server

```bash
# Ferma il server
Ctrl+C

# Pulisci la cache
rm -rf node_modules/.vite

# Riavvia
npm run dev
```

---

## Implementazione Corretta

### File: resources/html/css/app.css

```css
@import "tailwindcss";

@theme {
  /* ========================================
     COLORI BRAND - Laravel Pizza
     ======================================== */

  /* Primary (Rosso Pizza) */
  --color-primary-50: #fef2f2;
  --color-primary-100: #fee2e2;
  --color-primary-200: #fecaca;
  --color-primary-300: #fca5a5;
  --color-primary-400: #f87171;
  --color-primary-500: #ef4444;
  --color-primary-600: #dc2626;
  --color-primary-700: #b91c1c;
  --color-primary-800: #991b1b;
  --color-primary-900: #7f1d1d;
  --color-primary-950: #450a0a;
}

/* Custom utilities (se necessario) */
@utility btn-primary {
  background-color: var(--color-primary-600);
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 0.5rem;

  &:hover {
    background-color: var(--color-primary-700);
  }
}
```

### Utilizzo in HTML

```html
<!-- Ora funziona -->
<button class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-2 rounded-lg">
  Ordina Ora
</button>

<input class="border-gray-300 focus:ring-primary-500 focus:border-primary-500" />

<!-- Utility custom -->
<button class="btn-primary">
  Click Me
</button>
```

---

## Checklist Verifica

- [ ] `@import "tailwindcss"` presente in `css/app.css`
- [ ] `@theme` definito con colori `--color-primary-*`
- [ ] `tailwind.config.js` rimosso o svuotato
- [ ] Vite server riavviato
- [ ] Cache Vite pulita (`rm -rf node_modules/.vite`)
- [ ] Classi `primary-*` funzionano in HTML
- [ ] Classi base (`px-6`, `py-2`) funzionano

---

## Riferimenti

- [Tailwind CSS v4 Documentation](https://tailwindcss.com/docs)
- [Tailwind v4 @theme directive](https://tailwindcss.com/docs/functions-and-directives#theme)
- [Migration Guide v3 → v4](https://tailwindcss.com/docs/upgrade-guide)

---

## Note per Altri AI/Sviluppatori

**ATTENZIONE**: Tailwind CSS v4 usa un approccio **CSS-first**. NON usare più `tailwind.config.js` per definire colori. Usa `@theme` in CSS.

Se vedi errori come "Cannot apply unknown utility class", controlla SEMPRE `css/app.css` prima di cercare altrove.
