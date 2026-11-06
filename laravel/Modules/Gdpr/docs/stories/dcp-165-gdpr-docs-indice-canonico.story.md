---
type: index
tags: [gdpr, cookie, consent, legal, compliance]
created: 2026-10-14
updated: 2026-10-14
qmd: "gdpr modulo docs indice canonico cookie consenso legali privacy"
issues: []
discussions: []
id: "2026-10-14-dcp-165"
epic: 165
title: "Docs Gdpr — indice canonico e consolidamento"
slug: gdpr-docs-indice-canonico
status: ready-for-dev
scope: module:Gdpr
github:
  repository: https://github.com/laraxot/module_gdpr_fila5
  issues: https://github.com/laraxot/module_gdpr_fila5/issues/65
  discussions: https://github.com/laraxot/module_gdpr_fila5/discussions/66
  issue_status: "aperta"
related:
  - ../docs/stories/dcp-164-registrazione-consenso-obbligatorio-PA.story.md
  - ../docs/stories/dcp-153-cookiebar-integrata-nel-modulo-gdpr.story.md
  - ../docs/stories/dcp-156-pagine-legali-complete-a-norma.story.md
---

# 2026-10-14 DCP-165 Docs Gdpr — indice canonico e consolidamento

## Perché

La cartella `Modules/Gdpr/docs/` contiene **oltre 200 file .md**, molti dei quali duplicati (es. `cookie-consent.md` / `cookie-consent-1.md` / `cookie_consent.md`, `terms-conditions.md` / `terms-conditions-collegamenti-versioni.md`, `cookiebar-integration.md`). Un agente che cerca "cookie policy" trova 5 file diversi e non sa quale usare.

## Obiettivo

- Creare un `INDEX.md` unico che mappi i documenti **canonici** per tema.
- Segnalare i duplicati da consolidare (non cancellare: regola BMAD).
- Garantire che ogni link relativo risolva.

## Documenti canonici (da promuovere a SSoT)

| Tema | File canonico |
|------|---------------|
| Cookie bar / consenso | `cookiebar-integration.md` |
| Cookie consent package | `consent-packages-research.md` |
| Consenso modelli | `consents.md` |
| Termini e condizioni | `terms-conditions.md` |
| Registrazione | `register-widget.md` |
| Diritto all'oblio / export | `task-export-dati-utente.md` |
| Compliance roadmap | `gdpr-compliance-roadmap.md` |
| Module overview | `module-gdpr.md` |

## Accettazione

1. `INDEX.md` creato con la mappa canonica.
2. Ogni link relativo risolva (`rg` per verificare).
3. Duplicati elencati come `superseded` (nessun file cancellato).
4. Nessun file in `app/Http/Controllers`.