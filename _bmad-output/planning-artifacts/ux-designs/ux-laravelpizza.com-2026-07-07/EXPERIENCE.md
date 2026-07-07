---
title: "EXPERIENCE: LaravelPizza"
status: final
created: 2026-07-07
updated: 2026-07-07
sources:
  - ../../prds/prd-laravelpizza.com-2026-07-07/prd.md
  - ../../briefs/brief-laravelpizza.com-2026-07-07/brief.md
design_reference: ./DESIGN.md
---

# EXPERIENCE: LaravelPizza

*Le decisioni visive vivono in [DESIGN.md](./DESIGN.md), referenziato per nome (`{path.to.token}`). In caso di conflitto tra questo documento e un mock/wireframe/import, vincono i due spine (DESIGN.md + questo documento).*

## Foundation

**Form-factor:** Web responsive, mobile-first per la scoperta pubblica eventi; nessuna app nativa (PRD §2.2). L'amministrazione (Filament) è desktop-oriented per natura del pannello, non ridisegnata qui: eredita l'UX standard di Filament, non è oggetto di questo documento.

**UI system:** Nessun design system esterno (shadcn/MUI) — Tailwind CSS puro sopra ai token di DESIGN.md, coerente con lo stack esistente del tema Meetup.

**Light/Dark mode:** Requisito di prima classe, non secondario — il tema ha già `darkMode: 'class'` configurato. Ogni Key Flow e Component Pattern di questo documento vale per entrambe le modalità; dove non specificato diversamente, il comportamento è identico salvo l'inversione dei toni di sfondo/testo.

## Information Architecture

- **Home** (`/`) — Pagina CMS-driven (PRD FR-12–14): hero, panoramica community, CTA verso Eventi. Realizza l'ingresso di UJ-2.
- **Eventi** (`/events`) — Lista Eventi futuri + passati, filtro città/data (PRD FR-5, FR-6, FR-8). Realizza il "path" centrale di UJ-2.
- **Dettaglio Evento** (`/events/{slug}`) — Metadati completi, Capienza residua, CTA Iscrizione (PRD FR-7). Realizza il climax di UJ-2.
- **Iscrizione** (embedded nel Dettaglio Evento o step successivo — [ASSUMPTION: da chiarire in fase tecnica se è un modal/sezione inline o una pagina dedicata; qui trattata come flusso, non come superficie separata]) — form email+password (PRD FR-9, FR-10, FR-11).
- **Pagine CMS statiche** (`/about`, `/contact`, `/terms`, `/privacy`, ecc.) — stesso pattern Home, contenuto variabile via JSON (PRD FR-12–14).
- **Amministrazione** (Filament, `/admin`) — fuori scope per questo documento; eredita i pattern UX standard di Filament (PRD FR-1–4).

**Chiusura IA:** ogni bisogno dichiarato in PRD §2.1 ha una superficie: l'Organizzatore usa Filament (fuori scope qui); il Partecipante/Visitatore copre Home → Eventi → Dettaglio → Iscrizione; lo Sviluppatore esterno (JTBD secondario) non ha una superficie UI dedicata — il suo "prodotto" è il repository stesso, non una schermata (coerente con UJ-3 in PRD, non load-bearing per nessun FR).

## Voice and Tone

Diretto e concreto, mai gonfio di superlativi da marketing aggressivo — coerente con la scelta di bilanciare "energico" e "credibile per developer" (vedi DESIGN.md Brand & Style). Esempi:

- CTA: "Iscriviti all'evento" (non "Non perdere questa occasione imperdibile!!!").
- Stato capienza: "12 posti rimasti" invece di toni allarmistici tipo "Ultimi posti disponibili, affrettati!".
- Errori: espliciti e utili ("Questo evento ha raggiunto la capienza massima"), mai colpevolizzanti.

[ASSUMPTION: il tono editoriale specifico dei testi CMS (home, about) non è stato rivisto in dettaglio in questa sessione — questa sezione fissa il tono per i microcopy funzionali (CTA, stati, errori), non per i testi editoriali lunghi delle Pagine CMS.]

## Component Patterns

- **`event-card`** (`{components.event-card}` in DESIGN.md) — usata nella lista Eventi. Mostra: titolo, data, Sede (città), badge stato (Prossimo/Passato/Posti limitati), CTA "Vedi dettagli". Comportamento: click su tutta la card naviga al Dettaglio, non solo sul titolo (target di click ampio per mobile).
- **`button-primary` / `button-secondary`** — un solo `button-primary` per schermata (vedi DESIGN.md Do's and Don'ts); "Iscriviti" è sempre `button-primary` nel Dettaglio Evento.
- **`form-section`** — usata per il form di Iscrizione: raggruppa email+password con validazione inline, non a step multipli (coerente con "minimo attrito", PRD §2.1).
- **Badge Capienza** — tre stati visivi: disponibile (verde, `{colors.accent-500}`), pochi posti (ambra, `{colors.secondary-500}`, soglia [ASSUMPTION: es. <10% della Capienza, da definire in fase tecnica]), esaurito (rosso, `{colors.primary-600}`, CTA Iscrizione disabilitata).

## State Patterns

- **Lista Eventi vuota** (nessun risultato dal filtro): messaggio esplicito + CTA per rimuovere il filtro (mai una lista vuota senza spiegazione, coerente con PRD FR-8 Consequences).
- **Iscrizione in corso** (submit): bottone in stato loading, disabilitato, per prevenire doppi submit che potrebbero violare il limite di Capienza (PRD FR-11).
- **Iscrizione riuscita**: conferma visiva immediata (non solo l'email, PRD FR-10) — un messaggio inline "Ti abbiamo mandato una conferma via email" prima che l'utente lasci la pagina.
- **Capienza esaurita durante la compilazione**: se la Capienza si esaurisce mentre l'utente sta compilando il form (race condition), il messaggio d'errore appare prima del redirect di successo, mai dopo un falso "riuscito" (PRD FR-11 Consequences).

## Interaction Primitives

- Navigazione da tastiera completa su tutti i flussi pubblici (focus-visible blu, `{colors.focus-ring}`, già implementato in `app.css`).
- Nessuna interazione critica dipende solo da hover (mobile-first, touch-friendly).
- Transizioni di stato (hover, loading) entro 400ms, coerente con DESIGN.md Do's and Don'ts.

## Accessibility Floor

Vincolo comportamentale minimo, ereditato da PRD FR-19 (WCAG 2.1 AA): ogni Key Flow di questo documento (Home, Eventi, Dettaglio, Iscrizione) deve restare navigabile e comprensibile con screen reader e da tastiera. Il contrasto colore specifico è responsabilità di DESIGN.md (le scale primary/secondary/accent sono già tarate su Tailwind default, che rispetta AA per i toni ≥600 su sfondo bianco — [ASSUMPTION: da verificare puntualmente in fase tecnica con l'audit automatico previsto in PRD FR-19]).

## Key Flows

- **KF-1. Giulia scopre e si iscrive** *(realizza UJ-2 del PRD)*
  Giulia atterra su Home da un link condiviso, clicca "Vedi eventi" (`button-secondary`), filtra per città nella lista Eventi, clicca una `event-card`, arriva al Dettaglio dove vede Capienza residua e clicca "Iscriviti" (`button-primary`), compila il `form-section` con email+password, vede lo stato di conferma inline, riceve l'email. **Climax:** il messaggio di conferma inline immediato — prima ancora che arrivi l'email — è il momento in cui Giulia sa che ha funzionato.

- **KF-2. Un visitatore usa il selettore di lingua a metà navigazione** *(realizza LOCL-01/02 del PRD)*
  Un visitatore su una pagina Dettaglio Evento in italiano cambia lingua dal selettore; resta sulla stessa pagina (stesso Evento) ma in inglese, senza tornare alla Home (PRD FR-16 Consequences).

- **KF-3. Marco pubblica un evento** *(realizza UJ-1 del PRD — fuori scope visivo, eredita Filament)*
  Marco lavora interamente nel pannello Filament standard; questo documento non specifica pattern custom per questo flusso, solo il vincolo che l'Evento pubblicato appaia immediatamente nella lista pubblica Eventi (PRD FR-1).
