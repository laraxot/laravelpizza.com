---
issues: []
discussions: []
title: Gdpr Module Analysis
type: concept
tags: [gdpr, privacy, personal-data, consent]
created: 2026-09-05
updated: 2026-09-05
qmd: "gdpr module-analysis scopo religione filosofia politica zen"
module: Gdpr
related:
  - ./docs/README.md
  - ../User/docs/README.md
  - ../Activity/docs/README.md
---

# Gdpr Module Analysis

## Scopo
Conformità GDPR completa con gestione consensi, privacy policy, diritti utente (accesso, rettifica, cancellazione, portabilità) e data breach notification.

## Religione
- **Consent granular**: ogni finalità di trattamento richiede consenso separato
- **Proof of consent**: ogni consenso è logged con timestamp, IP, versione policy
- **Right to erasure**: cancellazione dati che rimuove PII senza violare obblighi legali
- **Data portability**: export in formato machine-readable (JSON/CSV)
- **Privacy by design**: i dati personali sono marcati e tracciati
- **Retention policies**: cancellazione automatica dopo retention period

## Filosofia
- **Il consenso non è un checkbox**: è un contratto tra titolare e interessato
- **Minimizzazione dati**: solo i dati necessari, per il tempo necessario
- **Trasparenza radicale**: l'utente sa esattamente cosa facciamo con i suoi dati
- **Diritto al oblio praticabile**: non è solo cancellare, è gestire cascata riferimenti

## Politica
- Ogni consenso ha: utente, finalità, versione policy, timestamp, IP, user agent, revocabile
- Le richieste diritti hanno workflow: ricezione → validation → elaborazione → chiusura
- I dati cancellati sono replaced con hash irreversibile per audit trail
- Le cookie policy sono separate dalla privacy policy
- Il DPO (se nominato) riceve notifica di tutte le richieste
- I data breach sono notificati al Garante entro 72 ore se a rischio

## Perché
Perché il GDPR non è un'opzione - è obbligatorio e le sanzioni sono severe. Il modulo rende la compliance sistematica, non spot-check.

## Zen
Il consenso dato, il consenso revocato, il dato cancellato - tutto tracciato, nulla dimenticato.

## Cosa manca
- Privacy Impact Assessment (PIA/DPIA) integrato
- Registro trattamenti automatico
- DPO dashboard
- Cookie banner avanzato con granularità
- International data transfers (SCCs)
- Pseudonimizzazione automatica per dati analytics

## Cosa aggiungerei
- AI-based data classification (identifica automaticamente PII)
- Consent management platform (CMP) certificata
- Automated DPA requests handling
- Real-time consent audit per auditor
- Cookie-less analytics integration
- Blockchain per immutable consent records

## Divisione o Unione
- **Mantieni separato**: GDPR è compliance, non business logic
- **Potenziale integrazione**: dovrebbe avere hooks in ogni modulo che tratta dati personali
- **Conflitto**: con Activity (audit trail), con User (gestione consensi), con Compliance (norme regolatorie)