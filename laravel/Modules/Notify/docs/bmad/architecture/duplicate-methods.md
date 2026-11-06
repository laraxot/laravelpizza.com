---
title: "Metodi duplicati: Notify"
type: concept
tags: [duplicate, methods]
created: 2026-07-14
updated: 2026-07-14
qmd: "duplicate-methods-1 metodi duplicati: notify"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
status: draft
---

# Metodi duplicati: Notify

Analisi sintetica dei metodi PHP con lo stesso nome all’interno di questo ambito.

- File PHP analizzati: **346**
- Metodi duplicati trovati: **66**

## Metodi duplicati

| Metodo | Occorrenze | Note |
|--------|----------|------|
| `__construct` | 48 | candidato a trait/helper |
| `execute` | 36 | candidato a trait/helper |
| `up` | 26 | candidato a trait/helper |
| `casts` | 13 | candidato a trait/helper |
| `fillForms` | 13 | candidato a trait/helper |
| `getFormSchema` | 13 | candidato a trait/helper |
| `getForms` | 13 | candidato a trait/helper |
| `make` | 13 | candidato a trait/helper |
| `mount` | 13 | candidato a trait/helper |
| `definition` | 12 | candidato a trait/helper |
| `getUser` | 12 | candidato a trait/helper |
| `getTableColumns` | 11 | candidato a trait/helper |
| `send` | 11 | candidato a trait/helper |
| `via` | 10 | candidato a trait/helper |
| `toArray` | 9 | candidato a trait/helper |
| `getInfolistSchema` | 7 | candidato a trait/helper |
| `emailForm` | 6 | candidato a trait/helper |
| `getEmailFormActions` | 6 | candidato a trait/helper |
| `handle` | 6 | candidato a trait/helper |
| `sendEmail` | 6 | candidato a trait/helper |

... altri 46 metodi duplicati non elencati per sintesi.

## Riflessioni

- I duplicati con nomi generici (`__construct`, `up`, `down`, `definition`) sono spesso inevitabili, ma vanno monitorati.
- Quando un metodo compare in più classi con firme simili, conviene valutare un trait o una classe base condivisa.
- Se il metodo ha firme diverse, meglio evitare l’ereditarietà implicita e preferire un service/helper dedicato.
- Per i metodi di tipo accessor/mutator, la duplicazione è spesso legata a pattern Eloquent ricorrenti.

> Documento generato il 2026-06-15 da Claude Code.
