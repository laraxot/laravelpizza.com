# bmad method nel tema meetup

## obiettivo

Applicare il **BMAD Method** al tema `Meetup` per mantenere:

- coerenza con l'architettura Laraxot (Folio + Volt + Filament)
- allineamento con le regole di design e UX già presenti nel tema
- tracciabilità delle decisioni (sempre documentate in `docs/`)

Questo documento integra le regole esistenti (`theme-development-rules.md`, `architecture-folio-volt-filament.md`, `critical-rules-and-patterns.md`).

## stato nel progetto

BMAD è già installato nel repository (cartella `_bmad/`) e convive con GSD:

- GSD resta l'orchestratore primario (`.planning/`)
- BMAD si usa come supporto per ricerca profonda, architettura e code review
- la mappa di integrazione è in `_bmad/bmap.md`

## perché `bmad-help` sembra non funzionare

`bmad-help` **non è un comando da terminale**: è una “skill” descritta da file dentro `_bmad/`.

Se Cursor non ha caricato/registrato automaticamente le skill del repo, allora scrivere `bmad-help` non attiva nulla.
In quel caso l’uso corretto è:

- continuare con i comandi GSD (`/gsd-plan-phase`, `/gsd-execute-phase`, …) come percorso principale;
- usare BMAD come “workflow in repo” leggendo e seguendo `_bmad/core/skills/bmad-help/workflow.md`;
- oppure chiedere direttamente in chat “usiamo bmad-help per: …” e io applico il workflow (leggendo `_bmad/_config/bmad-help.csv` e suggerendo il prossimo passo).

## come usiamo bmad nel tema

- **scale‑adaptive**:
  - micro‑fix UI (padding, colore, typo) → ciclo brevissimo, nessun cambio di architettura
  - nuove sezioni (hero, events, CTA) → aggiornare anche docs su componenti Blade/Volt e flusso utente
  - modifiche strutturali (layout, routing Folio, blocchi CMS) → analisi completa di impatto su SEO, accessibilità, performance
- **workflow guidato**:
  1. capire la richiesta in termini di business (cosa deve ottenere la pagina/utente)
  2. verificare docs esistenti del tema e dei moduli coinvolti (Meetup, UI, Seo, Lang, Xot)
  3. progettare la soluzione usando pattern già presenti (blocchi, layout, componenti)
  4. implementare in Volt/Blade/Tailwind in modo minimale e leggibile
  5. testare:
     - UI/UX (desktop + mobile)
     - accessibilità (WCAG note nei docs)
     - localizzazione URL (mcamara/laravel‑localization)
  6. aggiornare o creare doc nella cartella `docs/` del tema con:
     - scopo del cambiamento
     - impatto su UX/SEO/architettura
     - riferimenti ai moduli backend se coinvolti

## principi pratici

- **business‑first**: ogni modifica al tema deve avere uno scopo chiaro (es. aumentare registrazioni eventi, migliorare comprensione agenda, rafforzare brand LaravelPizza).
- **riuso massimo**:
  - preferire componenti Blade/Volt esistenti rispetto alla creazione di nuovi
  - quando si introduce un nuovo pattern UI, documentarlo e renderlo riutilizzabile
- **allineamento moduli ↔ tema**:
  - per ogni modifica di presentazione che dipende da dati (Eventi, Media, Seo), verificare prima le docs dei moduli corrispondenti
  - usare BMAD per decidere se il cambiamento è solo “tema” o richiede evoluzione del dominio backend

## collegamenti interni

- regole tema: `theme-development-rules.md`, `critical-rules-and-patterns.md`
- architettura Folio + Volt + Filament: `architecture-folio-volt-filament.md`
- SEO e metatag: `seo.md`, `seo-best-practices.md`, metatags docs in `Modules/Seo/docs/`
- mappa BMAD ↔ GSD: `../_bmad/bmap.md`
- metodo globale (Xot): `../laravel/Modules/Xot/docs/bmad-method.md`

