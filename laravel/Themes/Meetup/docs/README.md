---
title: "Meetup: ingresso alla documentazione"
type: readme
theme: Meetup
status: active
updated: 2026-11-12
tags: [meetup, theme, docs, readme]
qmd: "meetup theme docs readme laravelpizza tema pubblico folio volt cms blocchi audit"
related:
  - ./00-index.md
  - ./front-office-audit.md
  - ./manuale-utente/readme.md
---

# Tema Meetup (LaravelPizza)

Meetup è il **tema pubblico di LaravelPizza** (`pub_theme` in `laravel/config/local/laravelpizza/xra.php`):
tutte le pagine che vede un visitatore o un partecipante. Tailwind 4 + Alpine.js, pagine Folio + Volt,
contenuti dal CMS (JSON in `laravel/config/local/laravelpizza/database/content/pages`).

> Questa cartella contiene anche documenti storici scritti per altri progetti Laraxot (Fixcity) o per
> versioni precedenti del tema. Se un documento contraddice questo file o il codice, vale il codice;
> i documenti qui sotto sono quelli verificati.

## Da leggere per primi

| Documento | Cosa spiega |
|---|---|
| [manuale-utente/readme.md](manuale-utente/readme.md) | manuale d'uso per visitatori, partecipanti e organizzatori (anche PDF) |
| [front-office-audit.md](front-office-audit.md) | come controllare tutto il front office prima di un rilascio (`npm run audit:fo`) e cosa ha corretto l'audit del 12/11/2026 |
| [build-and-copy-workflow.md](build-and-copy-workflow.md) | build del tema: `npm run build`, nessuna copia (`public_html/themes/Meetup` è un symlink) |
| [../../../Modules/Cms/docs/page-title-and-description.md](../../../Modules/Cms/docs/page-title-and-description.md) | da dove arrivano `<title>` e meta description di ogni pagina |
| [../../../Modules/User/docs/front-office-privacy-avatar-password-reset.md](../../../Modules/User/docs/front-office-privacy-avatar-password-reset.md) | avatar senza Gravatar, profilo pubblico, reset password |
| [../../../../docs/deploy/runbook.md](../../../../docs/deploy/runbook.md) | messa in produzione e controlli dopo il rilascio |

## Mappa del tema

| Percorso | Contenuto |
|---|---|
| `resources/views/pages/` | rotte Folio: `index` (home), `[slug]` (pagine CMS), `[container0]/[slug0]` (dettaglio evento), `profile/[id]`, `auth/*` |
| `resources/views/components/layouts/` | `main` (HTML, `<x-metatags>`), `app` (menu + footer); entrambi accettano `title` e `description` |
| `resources/views/components/blocks/` | blocchi usati dai JSON del CMS (hero, events, contact, legal, profile…) |
| `resources/views/components/sections/` | header e footer |
| `resources/views/components/ui/` | componenti piccoli: `auth-card`, `auth-field`, `language-switcher`, … |
| `resources/views/errors/page.blade.php` | pagine 403/404/419/429 nel layout del tema (500/503 in `laravel/resources/views/errors/fallback.blade.php`) |
| `resources/mail-layouts/base.html` | layout delle email (solo HTML inline, nessuna immagine remota) |
| `lang/{it,en,de,fr,es,ru}/` | testi del tema (`pub_theme::…`) |
| `scripts/` | `a11y-audit.mjs` (axe), `front-office-audit.cjs` (audit completo), screenshot del manuale |
| `public/` | output di `npm run build`, servito da `public_html/themes/Meetup` (symlink) |

## Regole che valgono qui

- Nessun SVG inline: file in `Modules/Meetup/resources/svg/` e `<x-filament::icon icon="meetup-…">`.
- Link e form con `LaravelLocalization::localizeUrl()`.
- Niente richieste a siti terzi al caricamento (font inclusi nel CSS, niente Gravatar, niente CDN).
- Ogni pagina ha un solo `h1`, un `<title>` proprio e testi tradotti in tutte e 6 le lingue.
- I test del tema stanno in `laravel/Modules/Meetup/tests` (suite `Project`).
