---
title: "Gdpr — Gestione consensi + export dati + right-to-forget"
id: "gdpr.002-consent-export"
module: Gdpr
type: story
status: todo
priority: high
created: 2026-11-04
---

# Gdpr.002 — Consensi, export dati, cancellazione

## Contesto

Il modulo Gdpr gestisce la registrazione con consensi ma non ha implementato
l'export dati personali (richiesto da GDPR Art. 20) né la cancellazione account
(Art. 17 - right to erasure).

## Obiettivo

Implementare export dati personali e cancellazione account nel rispetto GDPR.

## Acceptance criteria

- [ ] `ExportUserDataAction` che raccoglie tutti i dati dell'utente (User, Trade, Activity)
- [ ] Export in formato JSON scaricabile dall'utente
- [ ] `DeleteUserAccountAction` che anonimizza i dati personali (non cancella i log)
- [ ] `ConsentRecord` model che traccia chi ha dato quale consenso e quando
- [ ] `RevokeConsentAction` per revoca singolo consenso
- [ ] Tutti i dati personali nei log sono hashed/anonymized
- [ ] PHPStan zero errori su tutti i file nuovi
- [ ] Test Pest per export e cancellazione

## Note tecniche

- Usa `spatie/laravel-personal-data-export` già installato nel progetto
- `DeleteUserAccountAction` usa anonimizzazione, non cancellazione fisica
- `ConsentRecord` usa `spatie/laravel-activitylog` per immutabilità
