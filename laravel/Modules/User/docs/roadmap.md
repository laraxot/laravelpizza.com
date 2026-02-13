# User Module Roadmap

"Proteggere l'identità: il fondamento della fiducia."

## 🎯 Visione
Diventare un identity provider completo (IdP) che supporta standard moderni come Passkeys (WebAuthn), garantendo un'esperienza di login fluida e sicura, integrata con modelli di moderazione proattiva basati su AI.

## 🏗️ Fasi di Sviluppo

### Fase 1: Stability & Security (Completed)
- [x] PHPStan Level 10 Compliance.
- [x] Recursive documentation cleanup and standardization.
- [x] GitHub Action automation for Quality Check and Releases.

### Fase 2: Modern Identity (In Progress)
- [ ] Implementazione del **Security Cluster** in Filament v5.
- [ ] Supporto completo per **Laravel 12 Authentication Features**.
- [ ] Integrazione **WebAuthn** per login biometrici (TouchID, FaceID).
- [ ] Socialite Cluster: aggiunta facile di nuovi provider OAuth (Google, Apple, etc.).
- [ ] Sistema di "Impersonation" sicuro per il supporto tecnico (SuperAdmin).

### Fase 3: AI Moderation (Future)
- [ ] **AI Identity Verification**: Verifica automatica dei documenti caricati (es. tesserini medici).
- [ ] **Anomaly Detection**: Rilevamento di tentativi di login sospetti basati su pattern comportamentali.
- [ ] **Dynamic Permissions**: L'AI suggerisce i permessi minimi necessari in base all'uso effettivo dell'utente.

## ✅ Checklist Qualità
- [x] PHPStan Level 10.
- [ ] 100% test coverage sui flussi critici di Auth.
- [ ] Auditing delle chiavi segrete e dei token (Passport/Sanctum).

---
**Ultimo aggiornamento**: 31 Gennaio 2026
