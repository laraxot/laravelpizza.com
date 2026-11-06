---
title: "Approfondimento: Editor Visuali ed Esterni (Mailgun, MJML, BeeFree, Stripo, ecc.)"
type: concept
tags: [email, templates, editor, visuali]
created: 2026-07-14
updated: 2026-07-14
qmd: "email-templates-editor-visuali-1 approfondimento: editor visuali ed esterni (mailgun, mjml, beefree, stripo, ecc.)"
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
status: superseded
superseded_by: ../../email-templates-editor-visuali.md
---

# Approfondimento: Editor Visuali ed Esterni (Mailgun, MJML, BeeFree, Stripo, ecc.)

## Strumenti Analizzati
- [MJML](https://mjml.io/): markup per email responsive
- [BeeFree](https://beefree.io/templates): editor drag&drop, esportazione HTML
- [Stripo](https://stripo.email/templates/): editor drag&drop, AMP, esportazione HTML
- [Mailjet](https://www.mailjet.com/): editor visuale, API, gestione team
- [Mailgun](https://www.mailgun.com/): editor, analytics, A/B test
- [Unlayer](https://unlayer.com/): builder visuale, integrazione API

## Vantaggi
- Template altamente personalizzabili e responsive
- Anteprima visuale, supporto drag&drop
- Funzionalità avanzate: A/B test, analytics, gestione team
- Esportazione HTML compatibile con Laravel

## Svantaggi
- Dipendenza da servizi esterni, costi
- Integrazione con Laravel non sempre nativa
- Gestione localizzazione e variabili più complessa

## Pattern utili per <nome progetto>
- Usare builder visuali per template complessi o per marketing
- Esportare HTML e integrarlo come base per template Laravel
- Sincronizzazione API solo per casi business-critical

## Raccomandazioni
- Limitare uso a template marketing/DEM
- Documentare processo di esportazione/importazione
