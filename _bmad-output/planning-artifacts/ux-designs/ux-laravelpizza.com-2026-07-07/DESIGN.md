---
name: LaravelPizza
description: "Sistema visivo per la piattaforma di meetup Laravel italiani: energico e caldo (palette a tema pizza), ma sobrio e credibile per un pubblico di sviluppatori."
status: final
created: 2026-07-07
updated: 2026-07-07
colors:
  primary-50: '#fef2f2'
  primary-100: '#fee2e2'
  primary-200: '#fecaca'
  primary-300: '#fca5a5'
  primary-400: '#f87171'
  primary-500: '#ef4444'
  primary-600: '#dc2626'
  primary-700: '#b91c1c'
  primary-800: '#991b1b'
  primary-900: '#7f1d1d'
  secondary-50: '#fffbeb'
  secondary-100: '#fef3c7'
  secondary-200: '#fde68a'
  secondary-300: '#fcd34d'
  secondary-400: '#fbbf24'
  secondary-500: '#f59e0b'
  secondary-600: '#d97706'
  secondary-700: '#b45309'
  secondary-800: '#92400e'
  secondary-900: '#78350f'
  accent-50: '#f0fdf4'
  accent-100: '#dcfce7'
  accent-200: '#bbf7d0'
  accent-300: '#86efac'
  accent-400: '#4ade80'
  accent-500: '#22c55e'
  accent-600: '#16a34a'
  accent-700: '#15803d'
  accent-800: '#166534'
  accent-900: '#14532d'
  focus-ring: '#2563eb'
typography:
  sans:
    fontFamily: 'Inter, ui-sans-serif, system-ui, sans-serif'
rounded:
  sm: '0.5rem'
  md: '0.75rem'
  lg: '1rem'
  xl: '1.5rem'
  full: '9999px'
spacing:
  section-y: '4rem'
  card-padding: '1.5rem'
components:
  button-primary:
    background: '{colors.primary-600}'
    backgroundHover: '{colors.primary-700}'
    text: '#ffffff'
    rounded: '{rounded.md}'
  button-secondary:
    background: 'transparent'
    border: '{colors.primary-600}'
    text: '{colors.primary-700}'
    rounded: '{rounded.md}'
  event-card:
    rounded: '{rounded.lg}'
    padding: '{spacing.card-padding}'
  form-section:
    rounded: '{rounded.xl}'
    padding: '{spacing.card-padding}'
---

## Brand & Style

LaravelPizza è energico ma non urlato: la palette richiama esplicitamente la pizza (rosso pomodoro, ambra formaggio/crosta, verde basilico — che è anche, non a caso, la tripletta della bandiera italiana), ma il linguaggio visivo resta pulito e leggibile, perché il pubblico primario sono sviluppatori che valutano il prodotto anche come esempio tecnico. Non è un brand giocoso da consumer app né un brand corporate freddo: è un brand da developer tool con un'identità calda. [ASSUMPTION: bilanciamento "energico ma credibile" confermato dall'utente in sede di Discovery; nessun riferimento visivo esterno fornito, quindi la palette esistente nel tema (`tailwind.config.js`) è trattata come la base di verità, non reinventata.]

## Colors

- **`{colors.primary-*}` (rosso)** — colore d'azione primario: CTA principali ("Iscriviti", "Pubblica evento"), stati attivi, badge Evento in corso. Non usato per testo su grandi superfici (fatica di lettura), riservato ad accenti e bottoni.
- **`{colors.secondary-*}` (ambra)** — colore di supporto: evidenziazione secondaria, badge "Prossimamente", elementi decorativi negli hero. Non usato per CTA primarie (competerebbe visivamente col rosso).
- **`{colors.accent-*}` (verde)** — stato di successo e conferma: iscrizione completata, evento con posti disponibili. Non usato per errori o avvisi (riservare rosso/ambra a seconda della gravità, coerente con l'uso convenzionale del colore).
- **`{colors.focus-ring}` (blu)** — riservato esclusivamente al focus-visible da tastiera (già implementato in `app.css`); non va mai riusato per altri scopi decorativi, per non confondere l'utente da tastiera sullo stato di focus.

## Typography

Font unico: **Inter** (`{typography.sans.fontFamily}`), già in uso nel tema. Nessuna seconda famiglia per display/heading: la leggibilità tecnica prevale sull'effetto scenico. [ASSUMPTION: scala tipografica dettagliata (dimensioni h1-h6, line-height) non specificata esplicitamente — ereditata dai default Tailwind del tema esistente finché non emerge un bisogno specifico.]

## Layout & Spacing

Ritmo verticale a sezioni ampie (`{spacing.section-y}`) sulle pagine pubbliche (home, eventi), coerente con un sito "vetrina" che deve respirare. Card (Evento, contenuto) usano `{spacing.card-padding}` come padding interno standard. [ASSUMPTION: breakpoint e comportamento griglia ereditati dai default Tailwind del tema, non ridefiniti qui in assenza di un bisogno specifico emerso in Discovery.]

## Shapes

Angoli morbidi ma non arrotondati come un'app consumer: `{rounded.md}` per bottoni e input, `{rounded.lg}` per le card Evento, `{rounded.xl}` per sezioni contenitore più ampie (coerente con `.form-section` già in `app.css`, che usa `border-radius: 1rem`). Nessun elemento con `{rounded.full}` salvo avatar/badge circolari.

## Components

- **`button-primary`** — sfondo `{colors.primary-600}`, hover `{colors.primary-700}`, testo bianco, `{rounded.md}`. Usato per l'azione principale di ogni schermata (es. "Iscriviti all'evento").
- **`button-secondary`** — bordo `{colors.primary-600}`, sfondo trasparente, testo `{colors.primary-700}`. Usato per azioni secondarie (es. "Vedi tutti gli eventi").
- **`event-card`** — `{rounded.lg}`, padding `{spacing.card-padding}`. Anatomia comportamentale in EXPERIENCE.md §Component Patterns.
- **`form-section`** — `{rounded.xl}`, padding `{spacing.card-padding}`, coerente con lo stile già presente in `app.css` per le sezioni form (registrazione).

## Do's and Don'ts

- **Fai**: usa `{colors.primary-*}` per una sola CTA primaria per schermata — non competere con te stesso.
- **Fai**: mantieni il focus-visible blu (`{colors.focus-ring}`) intatto su ogni elemento interattivo, sia in light sia in dark mode.
- **Non fare**: non introdurre una quarta famiglia di colore saturo — se serve un nuovo significato semantico (es. errore), usa varianti più scure/desaturate delle scale esistenti prima di aggiungerne una nuova.
- **Non fare**: non usare animazioni con durata > 400ms o effetti "attention-grabbing" aggressivi (autoplay video, popup invasivi) — il tono resta energico ma non clickbait, per scelta esplicita (vedi Brand & Style).
