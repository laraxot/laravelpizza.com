# AI - Product Requirements Document (PRD)

> Documento vivente. Modulo di integrazione AI del progetto.
> Stato stimato: 55% implementato, 45% da convergere.

## 1. Purpose & Vision

Il modulo **AI** fornisce il layer di integrazione con modelli e provider AI per generare contenuti, draft, classificazioni e automazioni assistite. Nel progetto prediction market il suo ruolo non e' sostituire il dominio, ma accelerare workflow editoriali e operativi con output controllabili.

**Visione**: AI come infrastruttura applicativa affidabile, osservabile e sostituibile, costruita con action piccole e queueable quando serve, con fallback deterministici quando il provider esterno non e' disponibile.

## 2. Problem Statement

Senza il modulo AI:
- i contenuti seed, draft e assistiti vengono creati manualmente
- i flussi admin dipendono da copy hardcoded o dati sintetici incoerenti
- manca un punto unico per provider, prompt, fallback e telemetria

## 3. Target Users

| User | Ruolo | Bisogni |
|------|-------|---------|
| **Admin editoriale** | Popola contenuti e prediction | Draft coerenti e realistici |
| **Product owner** | Misura qualita' output | Controllo costi, fallback, audit |
| **Sviluppatore** | Integra nuove action AI | Contratti tipizzati e provider sostituibili |

## 4. Scope

### In Scope
- Action AI invocabili dal dominio e dall'admin
- Draft generation per prediction e contenuti editoriali
- Fallback locale quando il provider non e' configurato
- Configurazione provider, chiavi, modelli e timeout
- Telemetria minima di esecuzione e logging errori

### Out of Scope
- Decisioni autonome di business sul settlement dei mercati
- Persistenza diretta di denaro, payout o ledger
- Prompt non tracciabili o logica AI dispersa nei controller

## 5. Functional Requirements (Prioritized)

### P0: Core
- **FR-001**: Esporre action AI riusabili dal dominio applicativo.
- **FR-002**: Restituire output strutturati e validabili, non testo libero fragile.
- **FR-003**: Garantire fallback deterministici quando manca la configurazione del provider.
- **FR-004**: Consentire la generazione di prediction draft con titolo, summary, categoria, tag e approfondimento.

### P1: Reliability
- **FR-005**: Registrare errori, sorgente output (`provider` vs `fallback`) e volumetrie.
- **FR-006**: Separare prompt, parsing e persistenza finale.
- **FR-007**: Rendere ogni action testabile senza chiamate reali al provider.

### P2: Evolution
- **FR-008**: Supportare provider multipli senza cambiare il chiamante.
- **FR-009**: Introdurre quality scoring automatico sugli output.

## 6. Non-Functional Requirements

- **NFR-001**: PHPStan a `level: max` senza modificare `laravel/phpstan.neon`.
- **NFR-002**: Nessuna dipendenza hardcoded da un solo provider.
- **NFR-003**: Fallback disponibile nel 100% dei flussi critici admin.
- **NFR-004**: Nessuna persistenza di output AI non validato contro schema reale.
- **NFR-005**: Nessun nuovo `Service` applicativo; usare `Actions` e `QueueableAction`.

## 7. Technical Architecture

- **Dipendenze principali**: Xot, Predict, Blog, Filament.
- **Pattern**: action-oriented architecture; quando serve asincronia o invocabilita' uniforme, usare `spatie/laravel-queueable-action`.
- **Ingressi**: prompt contestuali, metadata di dominio, count/obiettivo.
- **Uscite**: array tipizzati o DTO da validare prima della persistenza.
- **Osservabilita'**: logging applicativo e notifica admin sul risultato.

## 8. Current State & Gaps

### Stato reale al 2026-03-12
- Generazione draft prediction disponibile: **70%**
- Fallback deterministici disponibili: **80%**
- Telemetria e quality scoring: **25%**
- Supporto provider multipli ben convergente: **35%**
- Copertura test orientata ai casi business: **45%**

### Gap prioritari
- Mancano metriche affidabili su costo, latenza, tasso fallback e qualita' output.
- Il modulo e' forte sulla generazione, ma debole nella governance del risultato.
- Serve un contratto unico per draft AI riusabile anche fuori dal seed admin.

## 9. Success Metrics & KPIs

| Metrica | Target |
|--------|--------|
| Generazione draft admin senza errori schema | 95% |
| Fallback successful rate nei flussi critici | 100% |
| PHPStan su `Modules/AI` | 0 errori |
| Test deterministici sulle action core | 90% dei flussi P0 |

## 10. Risks & Assumptions

- Assunzione: il progetto deve funzionare anche senza provider esterno configurato.
- Rischio: prompt drift e parsing fragile degradano la qualita' dei seed.
- Rischio: side effects nascosti nelle action AI rendono i test poco affidabili.

## 11. Release Priorities

### Fase 1
- Consolidare i contratti di draft prediction.
- Estendere logging e reporting admin.

### Fase 2
- Introdurre scoring qualitativo e retry policy.
- Aggiungere provider multipli dietro un contratto comune.

## 12. References

- [predict-drafts-contract.md](predict-drafts-contract.md)
- [roadmap-and-issues.md](roadmap-and-issues.md)
- [PRD Indice Centrale](../../../../docs/project/PRD_INDEX_2026_03_12.md)

## Testing & Coverage

Il modulo AI segue la metodologia operativa del progetto:
- test su action e flussi business verificabili
- nessun `RefreshDatabase`
- fallback sempre verificabile anche senza provider reale
