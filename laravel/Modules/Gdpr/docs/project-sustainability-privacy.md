---
title: "Sostenibilità — privacy di CTA e contributi"
type: concept
module: Gdpr
status: decision-input
updated: 2026-10-15
tags: [sustainability, gdpr, privacy, bmad]
qmd: "privacy (ownership gdpr) gdpr"
---

# Privacy (ownership Gdpr)

## Perché questo modulo

Ogni CTA monetaria o form «sostieni» tratta dati personali. Prima del design FO
servono titolare, finalità, base giuridica, conservazione e responsabili.

## Scopo business

Abilitare (un giorno) donazioni o richieste di collaborazione **senza** pixel di
sponsor e senza mescolare consenso marketing con accettazione termini servizio.

## Checklist pre-GO (se CTA monetaria)

- [ ] Titolare del trattamento identificato
- [ ] Finalità: gestione contributo / ricevuta / anti-frode
- [ ] Base giuridica (contratto / obbligo legale / consenso — da legale)
- [ ] Conservazione e cancellazione
- [ ] Responsabili (PSP, fiscal host) con DPA
- [ ] Informativa dedicata o sezione chiara
- [ ] Nessun ad-tech / retargeting legato al contributo

## Se CTA solo informativa

Link a pagina Cms senza form: rischio basso; restano log server standard.
Comunque vietati beacon di terzi «per misurare gli sponsor».

## Confini

- Gdpr non sceglie il modello economico
- Gdpr non pubblica partner
- Allineamento a gate già noti su registrazione/consensi (decision-log root)

## Collegamenti

- Dossier: [project-sustainability](../../../../../../bmad-output/project-sustainability/README.md)
- Footer sponsorship privacy notes: [research](../../../../../../bmad-output/footer-sponsorship/research-report.md)
