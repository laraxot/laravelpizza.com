---
title: "Design system del tema Meetup"
type: reference
status: active
theme: Meetup
qmd: "design system colori palette tipografia animazioni particelle dark mode tailwind v4 theme custom.css kinetic ux motion"
---

# Design system del tema Meetup

## Perche' esiste

Il tema vuole essere piu' moderno e piu' coinvolgente di laravelpizza.com senza perdere il suo marchio: rosso su superfici slate scure, tipografia Inter, movimento sobrio. Tutto vive in due file, `resources/css/custom.css` (token, classi di componente, utility) e le classi Tailwind nelle viste. Questa pagina fissa i valori e le regole d'uso; layout e struttura sono in [layouts.md](layouts.md).

## Stack di stile

- **Tailwind v4, CSS-first**: `@import 'tailwindcss'` in `resources/css/app.css` (con il CSS di Filament) e in `resources/css/site.css` (senza Filament); entrambi importano `custom.css`. I token stanno in `@theme { ... }` dentro `custom.css`.
- `tailwind.config.js` e `tailwind.config.cjs` esistono ancora ma nessun CSS li carica (`@config` assente, Tailwind v4 non li legge da solo). Per aggiungere un colore o un font si modifica `@theme`. Errore tipico: `Cannot apply unknown utility class 'focus:ring-primary-500'` significa che la scala `--color-primary-*` non e' definita in `@theme`.
- `postcss.config.js` esporta `{ plugins: {} }` di proposito: Tailwind gira gia' dentro `@tailwindcss/vite`. Non aggiungere `@tailwindcss/postcss` (non e' in `package.json`, la build fallisce) ne' i plugin PostCSS del tema Sixteen. Vedi [assets-and-build.md](assets-and-build.md).
- `@source '../../../../Modules/Meetup/resources/views'` in `custom.css` fa scansionare a Tailwind anche le viste del modulo Meetup usate nelle pagine pubbliche.

## Colori

| Ruolo | Valore | Uso |
|---|---|---|
| Rosso marchio | `red-500` `#ef4444` | logo, icone, accenti, hover |
| Rosso azione | `red-600` `#dc2626` / `red-700` `#b91c1c` | CTA primarie, `.btn-primary`, hover |
| Complemento caldo | `orange-500` | solo in gradienti (`from-red-500 via-red-600 to-orange-500`) |
| Superfici scure | `slate-950`, `slate-900`, `slate-800` | footer, header, schede |
| Testo su scuro | `white`, `slate-100` (nav), `slate-300`, `slate-400` (secondario) | |
| Testo su chiaro | `slate-900`, `slate-700`, `slate-500` | |
| Successo / errore | `green-*`, `red-*` | stati dei form |

In `@theme` le scale `red`, `primary`, `slate` e `gray` sono ridefinite con i valori standard Tailwind; `primary-*` e' un alias della scala rossa (`primary-600` = `#dc2626`). Gradiente tipico dell'hero e delle pagine di accesso: `from-slate-900 via-slate-800 to-red-900`; classi pronte `.bg-gradient-pizza` e `.bg-gradient-pizza-alt`.

**Regole**: un solo accento (rosso); niente blu per CTA o link. Il testo normale deve restare a contrasto WCAG AA (4.5:1): sul nav, `text-slate-100` su slate-800 e' circa 9:1 (commento in `custom.css`); evitare `text-gray-400` su bianco. Sempre uno stato `focus-visible` evidente.

## Dark mode

Basata su classe: `@variant dark (&:where(.dark, .dark *))` in `custom.css`. Il default e' scuro: lo script inline di `x-layouts.main` aggiunge `dark` a `<html>` salvo `localStorage.theme_dark === 'false'`, cosi' non c'e' flash alla prima resa. Le viste usano le varianti `dark:` (oltre 200 occorrenze). Il componente `x-ui.theme-toggle` salva la scelta con `$persist(true).as('theme_dark')`.

## Tipografia

- **Font**: Inter variabile, servito dal sito stesso con `@fontsource-variable/inter` (`@import '@fontsource-variable/inter/wght.css'`; i `.woff2` finiscono in `public/assets/`). `--font-sans: 'Inter Variable', 'Inter', ui-sans-serif, system-ui, sans-serif`. Niente Google Fonts: nessuna richiesta a terzi prima del consenso (regola R-10, vedi [gdpr-compliance.md](gdpr-compliance.md)).
- **Scala**: base 16 px (`text-base`), `leading-normal` per il corpo, `leading-tight` per i titoli; titoli responsive con i breakpoint Tailwind. Utility pronte: `.text-display` (`text-4xl md:text-5xl lg:text-6xl font-bold`) e `.text-heading` (`text-2xl md:text-3xl lg:text-4xl font-bold`).
- Linea guida per i titoli (non imposta dal codice): h1 `text-4xl font-bold`, h2 `text-3xl font-bold`, h3 `text-2xl font-bold`, h4 `text-xl font-semibold`, piccolo `text-sm`.

## Classi di componente (`@layer components` in custom.css)

`.btn-primary`, `.btn-secondary`, `.btn-outline` (focus ring rosso/slate con offset), `.event-card`, `.feature-card` (glass: `bg-slate-800/50 backdrop-blur-sm`), `.container-custom`, `.section`, `.hero-section`, `.cta-section`, `.nav-container`, `.nav-item`, `.text-wcag-dark`. Utility: `.text-balance`, `.sr-only` / `focus:not-sr-only`, `.animate-fade-in` / `.animate-fade-out`. Prima di scrivere una nuova variante di bottone o scheda, riusare queste. Per i blocchi vedi [blocks-and-components.md](blocks-and-components.md).

## Movimento

- **Principi**: ogni animazione ha uno scopo (feedback, orientamento); durate 150-300 ms, `ease-in-out`; solo `transform` e `opacity` (niente layout thrashing); lazy load dei componenti non visibili subito.
- **Reduced motion**: la regola globale in `custom.css` (`@media (prefers-reduced-motion: reduce)`) porta a 0.01 ms durata di `animation` e `transition`. Copre le animazioni CSS, **non** i canvas.
- **Keyframes del tema**: `fadeIn`, `fadeOut`, `dropdownSlide` (menu lingua), `mobileMenuSlide`; la pagina di registrazione ha i propri keyframes in uno `<style>` inline (blob, float).

### Particelle

Effetto di sfondo "antigravita'": particelle colorate che si allontanano dal cursore.

- Implementazione in uso: `components/ui/particles.blade.php` (Alpine `particles()` con script inline). Canvas `fixed inset-0 pointer-events-none z-0` con `aria-hidden="true"`; numero di particelle = area finestra / 15000; supporto DPR; repulsione dal mouse entro 150 px; rientro alla velocita' base; ritorno ai bordi opposti.
- Incluso solo in `pages/auth/register.blade.php` e `components/blocks/events/detail.blade.php` (`@include('pub_theme::components.ui.particles')`).
- Se le particelle non compaiono: controlla errori in console e che il canvas esista nel DOM; se rallentano, riduci il numero (cambia il divisore).
- `resources/js/particles.js` (classe `ParticleSystem`, 80 particelle) e' importato da `app.js` ma cerca `#particleCanvas`, che nessuna vista contiene: e' inerte.
- **Lacuna**: ne' lo script Alpine ne' `particles.js` controllano `prefers-reduced-motion`. Correzione minima: in `init()` uscire subito se `window.matchMedia('(prefers-reduced-motion: reduce)').matches`.

### Checklist "kinetic UX"

Per ogni modifica di movimento: stato del menu mobile con una sola fonte di verita'; dropdown lingua e toggle tema con focus visibile e `aria-*` coerenti; micro-movimento solo su transform/opacity; reduced motion rispettato (anche canvas); animazioni non informative disattivabili. Lo stato di questi punti e' in "Da verificare".

## Da verificare

- Accenti blu residui (`bg-blue-600`, `text-blue-600`...) in `ui/badge`, `ui/button`, `ui/theme-toggle`, `blocks/forms/login-card`, `layouts/auth`: da allineare al rosso. Anche l'outline globale di `:focus-visible` in `custom.css` usa `--color-blue-600`.
- `x-ui.theme-toggle` e' incluso solo in `ui/app/header.blade.php`; l'header attivo (`sections/header/v1`) non lo contiene, quindi oggi il tema si cambia solo da `localStorage`.
- I rapporti di contrasto "AAA" dichiarati in analisi precedenti non sono stati misurati sul CSS reale: usare AA come soglia e verificare con `npm run a11y`.
- Le utility `.kinetic-lift` e il fallback reduced-motion per canvas, citati in analisi precedenti, non esistono nel codice.

## Vedi anche

- [layouts.md](layouts.md)
- [header-footer-logo.md](header-footer-logo.md)
- [blocks-and-components.md](blocks-and-components.md)
- [accessibility.md](accessibility.md)
- [assets-and-build.md](assets-and-build.md)
