# Product Launch Plan - FixCity Platform

> **Version**: 1.0.0
> **Last Updated**: 2026-03-13
> **Status**: Draft

## 1. Launch Protocol (Standard)
Ogni rilascio di modulo o feature core deve seguire questa checklist non negoziabile:

### Technical Readiness
- [ ] **PHPStan Level 10**: 0 errori rilevati.
- [ ] **Test Coverage**: ≥90% con Pest (Feature + Unit).
- [ ] **Laravel Pint**: Formattazione eseguita (`--dirty`).
- [ ] **Migrations**: Classi nominate correttamente ed estendenti `XotBaseMigration`.
- [ ] **Translations**: Chiavi IT ed EN presenti per ogni etichetta UI.

### Documentation
- [ ] `prd.md` aggiornato con le nuove funzionalità.
- [ ] `changelog.md` aggiornato.
- [ ] Roadmap aggiornata con lo stato 'Completed'.

## 2. Release Phases

### Phase 1: Alpha (Internal)
- Test su ambienti di staging isolati.
- Verifica integrità database multi-tenant.

### Phase 2: Beta (Controlled)
- Rilascio a un set limitato di tenant.
- Monitoraggio log tramite Pail e Pulse.

### Phase 3: Production (General Availability)
- Deployment automatizzato tramite CI/CD.
- Verifica post-release dei KPI definiti nel PRD.

## 3. Communication Plan
- **Internal**: Notifica al team dev su Slack/Discord.
- **External**: Aggiornamento delle "Product Notes" nel pannello admin.

## 4. References
- [prd.md](prd.md)
- [roadmap.md](roadmap.md)
- [CONTRIBUTING.md](CONTRIBUTING.md)
