# Introduzione al Prediction Market

Un **prediction market** è una piattaforma dove gli utenti possono scommettere sull'esito di eventi futuri (politica, sport, economia, ecc.), aggregando la "saggezza della folla" per produrre previsioni statisticamente rilevanti. I prediction market moderni sono spesso decentralizzati (Web3), basati su blockchain e smart contract.

## Vantaggi
- Aggregazione della conoscenza collettiva
- Trasparenza e auditabilità
- Incentivi economici per la veridicità delle previsioni
- Applicazioni in politica, sport, economia, scienza

## Contesto
Questa documentazione descrive come progettare e realizzare un prediction market moderno, ispirato alle migliori piattaforme internazionali, utilizzando Laravel e i pattern di event sourcing.

## Novità: LMSR (Logarithmic Market Scoring Rule)
Il modulo integra ora la regola LMSR per garantire liquidità automatica e prezzi dinamici nei mercati predittivi. Per dettagli matematici e implementativi vedi il file `lmsr.md`.