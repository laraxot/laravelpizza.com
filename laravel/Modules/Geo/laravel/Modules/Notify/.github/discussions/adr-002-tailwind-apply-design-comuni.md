# ADR 001: Tailwind @apply per Bootstrap Italia

**Data:** 2026-04-01  
**Stato:** ✅ Accettato  
**Livello:** Architettura  

---

## Contesto

Dobbiamo replicare le pagine statiche di [Design Comuni](https://github.com/italia/design-comuni-pagine-statiche) che utilizzano Bootstrap Italia come framework CSS.

**Problema:** Come gestire lo styling mantenendo coerenza con il design system Bootstrap Italia ma utilizzando Tailwind CSS?

---

## Decisione

Utilizziamo **Tailwind CSS con `@apply`** per replicare le classi Bootstrap Italia.

**File:** `laravel/Themes/Sixteen/resources/css/app.css`

```css
/* ✅ CORRETTO: Tailwind @apply */
@import url('https://fonts.googleapis.com/css2?family=Titillium+Web:...');
@import 'tailwindcss';

.it-header-slim-wrapper {
  @apply py-2 text-sm bg-[#00614a];
}

.it-header-wrapper {
  @apply text-white relative bg-[#007a52];
}

/* ❌ SBAGLIATO: @import Bootstrap */
@import url('https://cdn.jsdelivr.net/npm/bootstrap-italia...');
```

---

## Conseguenze

### Positive ✅
- ✅ Manteniamo il controllo completo dello styling
- ✅ Possibilità di customizzare facilmente
- ✅ Performance migliori (no CSS bloat)
- ✅ Coerenza con il resto del progetto
- ✅ Utility-first approach

### Negative ❌
- ❌ Richiede più lavoro iniziale
- ❌ Dobbiamo replicare manualmente tutte le classi
- ❌ Possibili discrepanze visive durante la replicazione

### Neutral ⚖️
- ⚖️ Le classi HTML rimangono quelle Bootstrap Italia
- ⚖️ Lo styling è gestito da Tailwind @apply
- ⚖️ Necessario aggiornare style-apply.css per ogni nuova classe

---

## Compliance

### DRY ✅
- ✅ Definizione CSS una sola volta
- ✅ Riutilizzabile per tutte le pagine
- ✅ No duplicazione di codice

### KISS ✅
- ✅ Semplice: classe CSS → @apply Tailwind
- ✅ Facile da mantenere
- ✅ Facile da capire

---

## Riferimenti

- **Source:** https://italia.github.io/design-comuni-pagine-statiche/
- **Style File:** `laravel/Themes/Sixteen/Main_files/five/src/style-apply.css`
- **Docs:** `laravel/Themes/Sixteen/docs/design-comuni/CSS_ARCHITECTURE.md`

---

## Note Implementative

1. **Font:** Titillium Web (Bootstrap Italia official)
2. **Colori:** Variabili CSS custom per Bootstrap Italia colors
3. **Componenti:** Ispirati da Flowbite, DaisyUI, Tailwind UI Blocks

---

**Approvato da:** AI Agent Team  
**Data Approvazione:** 2026-04-01
