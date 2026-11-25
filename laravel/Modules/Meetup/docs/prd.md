# Meetup - Product Requirements Document (PRD)

> Documento vivente. Modulo eventi e meetup.

## 1. Purpose & Vision

Il modulo **Meetup** gestisce eventi e meetup per sviluppatori Laravel. È il cuore del dominio LaravelPizza: eventi tech, iscrizioni, sedi, organizzatori.

**Visione**: Piattaforma eventi conversion-optimized, share-worthy, viral-ready.

## 2. Problem Statement

Senza Meetup:
- Nessuna gestione eventi e calendario
- Impossibile iscriversi o condividere eventi
- Contenuti statici invece di dinamici

## 3. Target Users

| User | Ruolo | Bisogni |
|------|-------|---------|
| **Partecipante** | Sviluppatore Laravel | Scoprire eventi, iscriversi, condividere |
| **Organizzatore** | Crea eventi | Gestire eventi, partecipanti, sedi |
| **Admin** | Configurazione | EventResource, categorie, sedi |

## 4. Scope

### In Scope
- Modello Event con date, sedi, organizzatori
- EventResource Filament
- Pagine pubbliche: lista eventi, dettaglio evento
- Iscrizioni e partecipanti
- Integrazione Geo per sedi
- Integrazione Cms per pagine eventi

### Out of Scope
- Pagamento biglietti (estensione futura)
- Streaming live
- Chat durante eventi

## 5. Functional Requirements (Prioritized)

### P0: Core
- **FR-001**: CRUD eventi da Filament
- **FR-002**: Lista eventi pubblica (pagina events)
- **FR-003**: Dettaglio evento con sede, data, descrizione
- **FR-004**: Iscrizione evento (registrazione partecipante)

### P1: Enhancement
- **FR-005**: Filtri per data, città, tipo
- **FR-006**: Condivisione social
- **FR-007**: Calendario eventi

## 6. Non-Functional Requirements

- **NFR-001**: PHPStan Level 10
- **NFR-002**: Pagine eventi via Cms (JSON)
- **NFR-003**: Localizzazione eventi (IT/EN)

## 7. Technical Architecture

- **Dipendenze**: Xot, Cms, Geo, User, UI
- **Modelli**: Event, EventPerformer, EventVenue (o equivalenti)
- **Rendering**: Blocchi Cms + componenti tema Meetup

## 8. Risks & Assumptions

- Assunzione: eventi gratuiti come default
- Rischio: picco iscrizioni → queue per notifiche

## 9. References

- [PRD Progetto](../../../../docs/prd.md)
- [Architecture Reference](./architecture-reference.md)
- [Tema Meetup PRD](../../../Themes/Meetup/docs/prd.md)

## Testing & Coverage

Il modulo $(basename $(dirname $(dirname "$prd"))) segue la **Metodologia "Super Mucca" (Laraxot Zen)**:
- **XotBaseTestCase**: Tutti i test estendono `Modules\Xot\Tests\XotBaseTestCase`.
- **MySQL Only**: Test eseguiti contro MySQL (.env.testing).
- **No RefreshDatabase**: Utilizzo di `DatabaseTransactions`.
- **Obiettivo**: 100% di coverage. Se un test fallisce, va sistemato o eliminato se il sito è funzionale.

