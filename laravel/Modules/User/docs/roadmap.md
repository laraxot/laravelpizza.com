# Roadmap Modulo User

## 🎯 Visione
Garantire un sistema di gestione dell'identità sicuro, scalabile e moderno, supportando standard come Passkeys (WebAuthn) e fornendo strumenti di amministrazione avanzati per la sicurezza dei dati degli utenti.

## 🏗️ Fasi di Sviluppo

### Fase 1: Stabilità e Sicurezza (In Corso)
- [x] PHPStan Level 10 Compliance.
- [ ] Implementazione del **Cluster Security** per Filament.
- [ ] Rimozione sistematica di file obsoleti e ridondanti.
- [ ] Piena integrazione con le nuove funzionalità di autenticazione di Laravel 12.

### Fase 2: Identity Modernization (Pianificato)
- [ ] Integrazione di **WebAuthn** per login biometrici sicuri (Passkeys).
- [ ] Miglioramento del sistema Socialite per l'aggiunta semplificata di provider OAuth.
- [ ] Implementazione di un sistema di "Impersonation" sicuro per supporto tecnico.

### Fase 3: AI Moderation e Sicurezza (Futuro)
- [ ] **AI Identity Verification**: Verifica automatica dell'integrità dei profili.
- [ ] **Anomaly Detection**: Rilevamento di pattern di login sospetti tramite AI.
- [ ] **Dynamic Permissions**: Suggerimenti intelligenti per l'assegnazione dei permessi minimi necessari.

## ✅ Checklist Qualità
- [x] PHPStan Level 10.
- [ ] 100% test coverage sui flussi critici di autenticazione.
- [ ] Auditing periodico delle chiavi segrete e dei token di accesso.
- [ ] Documentazione dei flussi di sicurezza aggiornata in `docs/`.
- [x] Migrazioni schema utenti (UUID, lang, ecc.) allineate a XotBaseMigration (vedi [standard migrazioni](../Xot/docs/migrations-consolidated.md)).
