---
title: "[STORY] Chiusura parita' head Sixteen: D-7, sweep H-5 e gate go-live"
type: story
module: Cms
status: planning
priority: high
created: 2026-11-11
updated: 2026-11-11
tags: [bmad, ecc, seo, head, laravel-head, theme-sixteen, parity, go-live-gate]
related:
  - "head-sixteen-layout-migration.story.md"
  - "../seo-head-architecture.md"
  - "../../../../Themes/Sixteen/docs/stories/front-office-production-readiness-audit.story.md"
issues: []
discussions: ["https://github.com/laraxot/theme_sixteen_fila5/discussions/93"]
---

# [STORY] Chiusura parita' head Sixteen: D-7, sweep H-5 e gate go-live

## Scopo

Chiudere la migrazione del `<head>` di Sixteen su `<x-cms::head>` (story madre
`head-sixteen-layout-migration.story.md`): risolvere la regressione di parita' trovata dal diff a 128 URL,
eseguire lo sweep di parita' H-5 completo e riportare verdi i cancelli `LG-03`/`LG-04` del go-live gate.

## Perche' (il senso)

La testa scritta a mano emetteva canonical e hreflang **su ogni pagina**, incluse quelle `noindex`
(`x-layouts.seo-links`). Il componente Cms le emette solo sulle pagine indicizzabili: e' SEO-coerente
(`noindex` sconsiglia la canonicalizzazione) ma e' una **divergenza non coperta da nessuna decisione approvata**
e fa fallire `LG-03`/`LG-04` (DCP-166, 12 su 48). Finche' non si decide, il gate resta rosso per questa sola
ragione e la story madre non puo' chiudersi.

## Stato misurato (2026-11-11, vedi sezione «Diff di parita'» della story madre)

- 0 differenze su `status`, `description`, `og:title`, `<html lang>`, `<title>` delle pagine interne.
- Previsto e approvato: robots `index, follow, max-image-preview:large` sulle pubbliche (D-4); separatore `|` (D-2);
  home title con ordine invertito `Titolo | FixCity` (confermare in H-5).
- **Da decidere (D-7):** canonical autoreferenziale + hreflang anche su pagine `noindex`, oppure ridurre
  `LG-03`/`LG-04` alle sole pagine indicizzabili (decisione di prodotto da registrare in DCP-166).

## Piano

| Step | Cosa | Owner | Cancello |
|------|------|-------|----------|
| C-1 | PO decide D-7 (le due opzioni sono nella story madre) | PO/utente | decisione scritta qui e nella story madre |
| C-2 | Implementazione dell'esito in `Modules/Cms` (`Head::render`, al caso `ResolveHreflangAlternatesAction`) + Pest | Cms | test verdi; canonical/robots coerenti |
| C-3 | H-5: diff `<head>` DOM (non solo HTML) su URL × 4 lingue + 404, anonimo e loggato; screenshot 1440/375 chiaro/scuro | Sixteen | 0 differenze oltre a quelle deliberate |
| C-4 | `go-live-gate.py --skip-pest` (poi con Pest a macchina libera): `LG-03`/`LG-04` verdi o divergenza documentata | Sixteen | gate senza FAIL riconducibili alla head |
| C-5 | Aggiornare `status` delle due story e `document-shell.md`/`seo-head-architecture.md` se serve | Cms + Sixteen | documenti coerenti col codice |

## Non-obiettivi

- I FAIL di ambiente (`ENV-*`, `NET-01`, `REPO-02`) non sono di questa story: sono del deploy e del debito documenti.
- `F-07` (dettagli blog/eventi non tradotti senza `noindex`) resta una decisione di prodotto separata.

## Accettazione

- D-7 deciso e registrato; `LG-03`/`LG-04` non falliscono piu' per la head.
- Diff di parita' senza differenze non deliberate; screenshot senza regressione visiva.
